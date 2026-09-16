<?php

namespace Tests\Feature;

use App\Models\HandoverPackage;
use App\Models\KknGroup;
use App\Models\User;
use App\Models\Village;
use App\Services\HandoverService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandoverWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $leader;
    protected User $villageAdmin;
    protected Village $village;
    protected KknGroup $group;

    protected function setUp(): void
    {
        parent::setUp();
        $this->leader = User::where('email', 'leader@example.com')->firstOrFail();
        $this->villageAdmin = User::where('email', 'village@example.com')->firstOrFail();
        $this->village = Village::where('slug', 'sukamaju')->firstOrFail();
        $this->group = KknGroup::firstOrFail();
    }

    public function test_can_view_handover_dashboard_with_readiness_checklist(): void
    {
        $response = $this->actingAs($this->leader)
            ->get("/workspace/group/{$this->group->id}/handover");

        $response->assertStatus(200);
        $response->assertSee('Digital Handover');
        $response->assertSee('Kesiapan Handover');
        $response->assertSee('Profil Desa Terstruktur');
        $response->assertSee('Katalog UMKM Digital');
        $response->assertSee('Direktori Wisata Desa');
        $response->assertSee('Peta Digital Interaktif');
    }

    public function test_readiness_score_calculation(): void
    {
        $handoverService = app(HandoverService::class);
        $score = $handoverService->calculateReadiness($this->group);

        // For the fully seeded Sukamaju village & group, readiness should be 100%
        $this->assertEquals(100, $score);
    }

    public function test_can_execute_digital_handover_and_finalize(): void
    {
        // Set group to ACTIVE first to test execution flow
        $this->group->update(['status' => 'ACTIVE']);

        $handoverData = [
            'village_admin_id' => $this->villageAdmin->id,
            'title' => 'Serah Terima Resmi Digital Village OS Sukamaju',
            'notes' => 'Aset website, direktori UMKM, dan peta digital diserahkan penuh ke Sekretaris Desa.',
            'handover_date' => now()->toDateString(),
            'confirm_finalize' => '1',
        ];

        $response = $this->actingAs($this->leader)
            ->post("/workspace/group/{$this->group->id}/handover/execute", $handoverData);

        $response->assertRedirect();
        
        // Assert group is now locked/completed
        $this->assertEquals('COMPLETED', $this->group->fresh()->status);

        // Assert handover package created
        $package = HandoverPackage::where('kkn_group_id', $this->group->id)->firstOrFail();
        $this->assertEquals('COMPLETED', $package->status);
        $this->assertEquals($this->villageAdmin->id, $package->village_admin_id);
        $this->assertEquals(100, $package->readiness_score);

        // Assert village admin is linked
        $this->assertDatabaseHas('village_admins', [
            'village_id' => $this->village->id,
            'user_id' => $this->villageAdmin->id,
            'is_active' => 1,
        ]);
    }

    public function test_can_view_official_handover_certificate(): void
    {
        $package = HandoverPackage::where('kkn_group_id', $this->group->id)->firstOrFail();

        // View internal certificate
        $response = $this->actingAs($this->leader)
            ->get("/workspace/group/{$this->group->id}/handover/{$package->id}/certificate");

        $response->assertStatus(200);
        $response->assertSee('BERITA ACARA SERAH TERIMA ASET DIGITAL DESA');
        $response->assertSee('Desa Sukamaju');
        $response->assertSee($this->leader->name);
        $response->assertSee($this->villageAdmin->name);

        // View public village handover page
        $publicResponse = $this->get("/desa/{$this->village->slug}/handover");
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Digital Handover');
        $publicResponse->assertSee('Aset Digital yang Diserahterimakan');
    }
}
