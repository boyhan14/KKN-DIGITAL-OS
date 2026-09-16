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
}
