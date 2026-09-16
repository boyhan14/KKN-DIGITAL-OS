<?php

namespace Tests\Feature;

use App\Models\KknGroup;
use App\Models\Program;
use App\Models\ProgramTask;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramAndKanbanTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $leader;
    protected User $student;
    protected KknGroup $group;

    protected function setUp(): void
    {
        parent::setUp();
        $this->leader = User::where('email', 'leader@example.com')->firstOrFail();
        $this->student = User::where('email', 'student@example.com')->firstOrFail();
        $this->group = KknGroup::firstOrFail();
        $this->group->update(['status' => 'ACTIVE']);
    }

    public function test_can_view_group_programs_list(): void
    {
        $response = $this->actingAs($this->leader)->get("/workspace/group/{$this->group->id}/programs");

        $response->assertStatus(200);
        $response->assertSee('Program Kerja');
        $response->assertSee('Digitalisasi Katalog');
    }

    public function test_can_create_new_work_program(): void
    {
        $programData = [
            'title' => 'Edukasi Literasi Keuangan Digital Warga',
            'category' => 'EDUCATION',
            'objective' => 'Meningkatkan pemahaman warga tentang QRIS dan tabungan digital',
            'target_audience' => 'Ibu-ibu PKK dan Pelaku Usaha',
            'location' => 'Balai Warga RW 02 Sukamaju',
            'start_date' => '2026-09-20',
            'end_date' => '2026-10-05',
            'budget' => 1500000,
            'priority' => 'HIGH',
            'description' => 'Workshop interaktif penggunaan mobile banking dan pencatatan kas sederhana.',
        ];

        $response = $this->actingAs($this->leader)
            ->post("/workspace/group/{$this->group->id}/programs", $programData);

        $response->assertRedirect();
        $this->assertDatabaseHas('programs', [
            'kkn_group_id' => $this->group->id,
            'title' => 'Edukasi Literasi Keuangan Digital Warga',
            'status' => 'PLANNED',
        ]);
    }

    public function test_can_view_program_kanban_board(): void
    {
        $program = $this->group->programs()->firstOrFail();

        $response = $this->actingAs($this->leader)
            ->get("/workspace/group/{$this->group->id}/programs/{$program->id}");

        $response->assertStatus(200);
        $response->assertSee('Kanban Board');
        $response->assertSee('TODO');
        $response->assertSee('IN PROGRESS');
        $response->assertSee('REVIEW');
        $response->assertSee('DONE');
    }

    public function test_can_create_task_under_program(): void
    {
        $program = $this->group->programs()->firstOrFail();

        $taskData = [
            'title' => 'Menyusun modul panduan penggunaan QRIS',
            'assignee_id' => $this->student->id,
            'priority' => 'HIGH',
            'status' => 'TODO',
            'due_date' => '2026-09-25',
            'description' => 'Draft buku saku ringkas 8 halaman.',
        ];

        $response = $this->actingAs($this->leader)
            ->post("/workspace/group/{$this->group->id}/programs/{$program->id}/tasks", $taskData);

        $response->assertRedirect();
        $this->assertDatabaseHas('program_tasks', [
            'program_id' => $program->id,
            'title' => 'Menyusun modul panduan penggunaan QRIS',
            'status' => 'TODO',
        ]);
    }

    public function test_can_update_task_kanban_status(): void
    {
        $program = $this->group->programs()->firstOrFail();
        $task = ProgramTask::create([
            'program_id' => $program->id,
            'kkn_group_id' => $this->group->id,
            'assignee_id' => $this->student->id,
            'title' => 'Survei lokasi workshop',
            'priority' => 'MEDIUM',
            'status' => 'TODO',
        ]);

        // Move to IN_PROGRESS
        $response = $this->actingAs($this->student)
            ->post("/workspace/group/{$this->group->id}/programs/{$program->id}/tasks/{$task->id}/status", [
                'status' => 'IN_PROGRESS',
            ]);

        $response->assertRedirect();
        $this->assertEquals('IN_PROGRESS', $task->fresh()->status);

        // Move to REVIEW
        $this->actingAs($this->student)
            ->post("/workspace/group/{$this->group->id}/programs/{$program->id}/tasks/{$task->id}/status", [
                'status' => 'REVIEW',
            ]);
        $this->assertEquals('REVIEW', $task->fresh()->status);

        // Move to DONE
        $this->actingAs($this->leader)
            ->post("/workspace/group/{$this->group->id}/programs/{$program->id}/tasks/{$task->id}/status", [
                'status' => 'DONE',
            ]);
        $this->assertEquals('DONE', $task->fresh()->status);
    }

    public function test_can_update_program_status(): void
    {
        $program = $this->group->programs()->firstOrFail();

        $response = $this->actingAs($this->leader)
            ->post("/workspace/group/{$this->group->id}/programs/{$program->id}/status", [
                'status' => 'ONGOING',
            ]);

        $response->assertRedirect();
        $this->assertEquals('ONGOING', $program->fresh()->status);
    }

    public function test_cannot_add_program_or_task_when_group_is_completed(): void
    {
        $this->group->update(['status' => 'COMPLETED']);

        $programResponse = $this->actingAs($this->leader)
            ->post("/workspace/group/{$this->group->id}/programs", [
                'title' => 'Program Terlarang Pasca Handover',
                'category' => 'OTHER',
                'priority' => 'LOW',
            ]);

        $programResponse->assertStatus(403);
    }
}
