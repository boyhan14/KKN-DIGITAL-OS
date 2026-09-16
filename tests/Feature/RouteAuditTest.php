<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Village;
use App\Models\KknGroup;
use App\Models\Article;
use App\Models\Umkm;
use App\Models\TourismPlace;
use App\Models\Program;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RouteAuditTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_all_routes_render_successfully(): void
    {
        $user = User::where('role', 'STUDENT')->first();
        $supervisor = User::where('role', 'SUPERVISOR')->first();
        $campusAdmin = User::where('role', 'CAMPUS_ADMIN')->first();
        $village = Village::first();
        $group = KknGroup::first();
        $article = Article::first();
        $umkm = Umkm::first();
        $tourism = TourismPlace::first();
        $program = Program::first();

        $publicRoutes = [
            '/',
            '/login',
            '/register',
            "/desa/{$village->slug}",
            "/desa/{$village->slug}/tentang",
            "/desa/{$village->slug}/umkm",
            "/desa/{$village->slug}/umkm/{$umkm->slug}",
            "/desa/{$village->slug}/wisata",
            "/desa/{$village->slug}/peta",
            "/desa/{$village->slug}/kegiatan",
            "/desa/{$village->slug}/berita",
            "/desa/{$village->slug}/berita/{$article->slug}",
            "/desa/{$village->slug}/galeri",
            "/desa/{$village->slug}/kkn",
            "/desa/{$village->slug}/impact",
            "/desa/{$village->slug}/handover",
            "/desa/{$village->slug}/kontak",
        ];

        foreach ($publicRoutes as $route) {
            $response = $this->get($route);
            $this->assertTrue(
                in_array($response->status(), [200, 302]),
                "Public route {$route} failed with status {$response->status()}"
            );
        }

        // Student Auth routes
        $studentRoutes = [
            '/dashboard',
            "/workspace/group/{$group->id}",
            "/workspace/group/{$group->id}/members",
            "/workspace/group/{$group->id}/activity",
            "/workspace/group/{$group->id}/programs",
            "/workspace/group/{$group->id}/programs/{$program->id}",
            "/workspace/group/{$group->id}/documents",
            "/workspace/group/{$group->id}/impact",
            "/workspace/group/{$group->id}/handover",
            "/workspace/group/{$group->id}/reports",
            "/workspace/group/{$group->id}/reports/kkn-summary",
            "/workspace/group/{$group->id}/reports/village-profile",
            "/workspace/group/{$group->id}/reports/impact",
            "/workspace/village/{$village->id}",
            "/workspace/village/{$village->id}/profile",
            "/workspace/village/{$village->id}/umkm",
            "/workspace/village/{$village->id}/umkm/create",
            "/workspace/village/{$village->id}/umkm/{$umkm->id}/edit",
            "/workspace/village/{$village->id}/tourism",
            "/workspace/village/{$village->id}/tourism/create",
            "/workspace/village/{$village->id}/tourism/{$tourism->id}/edit",
            "/workspace/village/{$village->id}/map",
            "/workspace/village/{$village->id}/events",
            "/workspace/village/{$village->id}/articles",
            "/workspace/village/{$village->id}/articles/create",
            "/workspace/village/{$village->id}/articles/{$article->id}/edit",
            "/workspace/village/{$village->id}/gallery",
        ];

        foreach ($studentRoutes as $route) {
            $response = $this->actingAs($user)->get($route);
            $this->assertTrue(
                in_array($response->status(), [200, 302]),
                "Student route {$route} failed with status {$response->status()}"
            );
        }

        // Supervisor
        $response = $this->actingAs($supervisor)->get('/supervisor/dashboard');
        $this->assertEquals(200, $response->status(), "Supervisor dashboard failed with status {$response->status()}");

        // Campus Admin
        $response = $this->actingAs($campusAdmin)->get('/campus/dashboard');
        $this->assertEquals(200, $response->status(), "Campus admin dashboard failed with status {$response->status()}");
    }

    public function test_all_crud_and_workflow_actions(): void
    {
        $user = User::where('role', 'STUDENT')->first();
        $supervisor = User::where('role', 'SUPERVISOR')->first();
        $village = Village::first();
        $group = KknGroup::first();
        $group->update(['status' => 'ACTIVE']);

        // 1. AI Draft endpoint
        $response = $this->actingAs($user)->postJson('/ai/draft', [
            'type' => 'village_profile',
            'village_name' => 'Desa Makmur',
            'history' => 'Berdiri tahun 1920',
        ]);
        $response->assertOk();
        $this->assertNotEmpty($response->json('draft'));

        // 2. Program Task Creation & Status Change
        $program = Program::where('kkn_group_id', $group->id)->first();
        $response = $this->actingAs($user)->post("/workspace/group/{$group->id}/programs/{$program->id}/tasks", [
            'title' => 'Tugas Pengujian Otomatis',
            'assigned_to' => $user->id,
            'due_date' => now()->addDays(3)->toDateString(),
            'status' => 'TODO',
            'priority' => 'HIGH',
        ]);
        $response->assertRedirect();

        $task = \App\Models\ProgramTask::where('title', 'Tugas Pengujian Otomatis')->first();
        $this->assertNotNull($task);

        $response = $this->actingAs($user)->postJson("/workspace/group/{$group->id}/programs/{$program->id}/tasks/{$task->id}/status", [
            'status' => 'DONE',
        ]);
        $response->assertOk();

        // 3. Facility Creation and Deletion
        $response = $this->actingAs($user)->post("/workspace/village/{$village->id}/facilities", [
            'name' => 'Posyandu Mawar',
            'category' => 'HEALTH',
            'address' => 'Jl. Mawar No 1',
        ]);
        $response->assertRedirect();
        $facility = \App\Models\VillageFacility::where('name', 'Posyandu Mawar')->first();
        $this->assertNotNull($facility);

        $response = $this->actingAs($user)->delete("/workspace/village/{$village->id}/facilities/{$facility->id}");
        $response->assertRedirect();
        $this->assertNull(\App\Models\VillageFacility::find($facility->id));

        // 4. Event Creation and Deletion
        $response = $this->actingAs($user)->post("/workspace/village/{$village->id}/events", [
            'title' => 'Pelatihan Digitalisasi UMKM',
            'category' => 'Pelatihan',
            'date' => now()->addDays(7)->toDateString(),
            'time' => '09:00',
            'location' => 'Balai Desa',
            'description' => 'Pelatihan pembuatan katalog digital.',
        ]);
        $response->assertRedirect();
        $event = \App\Models\Event::where('title', 'Pelatihan Digitalisasi UMKM')->first();
        $this->assertNotNull($event);

        $response = $this->actingAs($user)->delete("/workspace/village/{$village->id}/events/{$event->id}");
        $response->assertRedirect();
        $this->assertNull(\App\Models\Event::find($event->id));

        // 5. Impact Metric CRUD
        $response = $this->actingAs($user)->post("/workspace/group/{$group->id}/impact", [
            'metric_name' => 'Warga Terlatih',
            'category' => 'PENDIDIKAN',
            'baseline' => 0,
            'target' => 100,
            'achieved' => 50,
            'unit' => 'orang',
        ]);
        $response->assertRedirect();
        $metric = \App\Models\ImpactMetric::where('metric_name', 'Warga Terlatih')->first();
        $this->assertNotNull($metric);

        $response = $this->actingAs($user)->put("/workspace/group/{$group->id}/impact/{$metric->id}", [
            'achieved' => 80,
            'description' => 'Capaian diperbarui',
        ]);
        $response->assertRedirect();
        $metric->refresh();
        $this->assertEquals(80, $metric->achieved);

        $response = $this->actingAs($user)->delete("/workspace/group/{$group->id}/impact/{$metric->id}");
        $response->assertRedirect();
        $this->assertNull(\App\Models\ImpactMetric::find($metric->id));
    }
}

