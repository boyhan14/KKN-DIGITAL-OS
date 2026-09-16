<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAndRbacTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_guest_can_view_login_and_register_pages(): void
    {
        $this->get('/login')->assertStatus(200)->assertSee('Masuk ke Workspace');
        $this->get('/register')->assertStatus(200)->assertSee('Pendaftaran Pengguna');
    }

    public function test_login_with_invalid_credentials_fails(): void
    {
        $response = $this->post('/login', [
            'email' => 'campus@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_campus_admin_login_and_dashboard_redirection(): void
    {
        $response = $this->post('/login', [
            'email' => 'campus@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        // Following to /dashboard routes to campus dashboard
        $this->get('/dashboard')->assertRedirect('/campus/dashboard');
        $this->get('/campus/dashboard')->assertStatus(200)->assertSee('Manajemen KKN');
    }

    public function test_supervisor_login_and_dashboard_redirection(): void
    {
        $response = $this->post('/login', [
            'email' => 'supervisor@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $this->get('/dashboard')->assertRedirect('/supervisor/dashboard');
        $this->get('/supervisor/dashboard')->assertStatus(200)->assertSee('Dosen Pembimbing Lapangan');
    }

    public function test_group_leader_login_and_dashboard_redirection(): void
    {
        $response = $this->post('/login', [
            'email' => 'leader@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $this->get('/dashboard')->assertRedirect('/workspace/group/1');
        $this->get('/workspace/group/1')->assertStatus(200)->assertSee('Kelompok KKN 14');
    }

    public function test_village_admin_login_and_dashboard_redirection(): void
    {
        $response = $this->post('/login', [
            'email' => 'village@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $this->get('/dashboard')->assertRedirect('/workspace/village/1');
        $this->get('/workspace/village/1')->assertStatus(200);
    }

    public function test_student_cannot_access_campus_admin_dashboard(): void
    {
        $student = User::where('email', 'student@example.com')->first();

        $response = $this->actingAs($student)->get('/campus/dashboard');
        $response->assertStatus(403);
    }

    public function test_user_can_logout_successfully(): void
    {
        $user = User::where('email', 'student@example.com')->first();

        $response = $this->actingAs($user)->post('/logout');
        $response->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_group_leader_can_manage_members_and_student_cannot(): void
    {
        $leader = User::where('email', 'leader@example.com')->first();
        $student = User::where('email', 'student@example.com')->first();
        $group = \App\Models\KknGroup::first();
        $group->update(['status' => 'ACTIVE']);

        // 1. Regular student CANNOT add member
        $resForbidden = $this->actingAs($student)->post("/workspace/group/{$group->id}/members", [
            'new_name' => 'Budi Santoso',
            'new_email' => 'budi@univ.ac.id',
            'role' => 'MEMBER',
            'contribution_notes' => 'Divisi Lingkungan',
        ]);
        $resForbidden->assertStatus(403);

        // 2. Leader CAN add new student member
        $resLeaderAdd = $this->actingAs($leader)->post("/workspace/group/{$group->id}/members", [
            'new_name' => 'Budi Santoso',
            'new_email' => 'budi@univ.ac.id',
            'role' => 'MEMBER',
            'contribution_notes' => 'Divisi Lingkungan',
        ]);
        $resLeaderAdd->assertRedirect();
        
        $budi = User::where('email', 'budi@univ.ac.id')->first();
        $this->assertNotNull($budi);
        $this->assertDatabaseHas('group_members', [
            'kkn_group_id' => $group->id,
            'user_id' => $budi->id,
            'role' => 'MEMBER',
            'contribution_notes' => 'Divisi Lingkungan',
        ]);

        // 3. Leader CAN update member division/role
        $resUpdate = $this->actingAs($leader)->put("/workspace/group/{$group->id}/members/{$budi->id}", [
            'role' => 'MEMBER',
            'contribution_notes' => 'Divisi Web GIS & IT',
        ]);
        $resUpdate->assertRedirect();
        $this->assertDatabaseHas('group_members', [
            'kkn_group_id' => $group->id,
            'user_id' => $budi->id,
            'contribution_notes' => 'Divisi Web GIS & IT',
        ]);

        // 4. Regular student CANNOT remove member
        $resStudentDel = $this->actingAs($student)->delete("/workspace/group/{$group->id}/members/{$budi->id}");
        $resStudentDel->assertStatus(403);

        // 5. Leader CAN remove member
        $resLeaderDel = $this->actingAs($leader)->delete("/workspace/group/{$group->id}/members/{$budi->id}");
        $resLeaderDel->assertRedirect();
        $this->assertDatabaseMissing('group_members', [
            'kkn_group_id' => $group->id,
            'user_id' => $budi->id,
        ]);
    }

    public function test_regular_student_cannot_execute_handover(): void
    {
        $student = User::where('email', 'student@example.com')->first();
        $villageAdmin = User::where('email', 'village@example.com')->first();
        $group = \App\Models\KknGroup::first();
        $group->update(['status' => 'ACTIVE']);

        $response = $this->actingAs($student)->post("/workspace/group/{$group->id}/handover/execute", [
            'village_admin_id' => $villageAdmin->id,
            'title' => 'Serah Terima Tidak Sah',
            'handover_date' => now()->toDateString(),
            'confirm_finalize' => '1',
        ]);

        $response->assertStatus(403);
    }

    public function test_village_admin_can_access_dashboard_and_delegation(): void
    {
        $villageAdmin = User::where('email', 'village@example.com')->first();
        $village = \App\Models\Village::first();

        $this->actingAs($villageAdmin)->get("/workspace/village/{$village->id}")->assertStatus(200)->assertSee('Pemerintah Desa');
        $this->actingAs($villageAdmin)->get("/workspace/village/{$village->id}/dashboard")->assertStatus(200)->assertSee('Aksi Cepat Tata Kelola Desa');
        $this->actingAs($villageAdmin)->get("/workspace/village/{$village->id}/delegation")->assertStatus(200)->assertSee('Delegasi Mahasiswa KKN');
    }
}
