<?php

namespace Tests\Feature;

use App\Models\Campus;
use App\Models\KknGroup;
use App\Models\Umkm;
use App\Models\User;
use App\Models\Village;
use App\Services\TenantService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected Village $sukamaju;
    protected Village $berkahMandiri;
    protected User $supervisor;
    protected User $villageAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->sukamaju = Village::where('slug', 'sukamaju')->firstOrFail();
        $this->berkahMandiri = Village::where('slug', 'berkah-mandiri')->firstOrFail();
        $this->supervisor = User::where('email', 'supervisor@example.com')->firstOrFail();
        $this->villageAdmin = User::where('email', 'village@example.com')->firstOrFail();
    }

    public function test_village_umkm_directory_isolation(): void
    {
        // Public portal Sukamaju
        $responseSukamaju = $this->get("/desa/{$this->sukamaju->slug}/umkm");
        $responseSukamaju->assertStatus(200);
        $responseSukamaju->assertSee('Kopi Lereng Sukamaju');
        $responseSukamaju->assertDontSee('Keripik Tempe Desa Berkah Mandiri');

        // Public portal Berkah Mandiri
        $responseBerkah = $this->get("/desa/{$this->berkahMandiri->slug}/umkm");
        $responseBerkah->assertStatus(200);
        $responseBerkah->assertSee('Keripik Tempe Desa Berkah Mandiri');
        $responseBerkah->assertDontSee('Kopi Lereng Sukamaju');
    }

    public function test_village_tourism_directory_isolation(): void
    {
        // Public portal Sukamaju
        $responseSukamaju = $this->get("/desa/{$this->sukamaju->slug}/wisata");
        $responseSukamaju->assertStatus(200);
        $responseSukamaju->assertSee('Curug Sukamaju Indah');
        $responseSukamaju->assertDontSee('Taman Wisata Hijau Berkah Mandiri');

        // Public portal Berkah Mandiri
        $responseBerkah = $this->get("/desa/{$this->berkahMandiri->slug}/wisata");
        $responseBerkah->assertStatus(200);
        $responseBerkah->assertSee('Taman Wisata Hijau Berkah Mandiri');
        $responseBerkah->assertDontSee('Curug Sukamaju Indah');
    }

    public function test_supervisor_group_assignment_scoping(): void
    {
        $supervisedGroupIds = $this->supervisor->supervisedGroups()->pluck('id')->toArray();
        $sukamajuGroup = KknGroup::where('village_id', $this->sukamaju->id)->firstOrFail();

        $this->assertContains($sukamajuGroup->id, $supervisedGroupIds);
        $this->assertEquals($this->supervisor->id, $sukamajuGroup->supervisor_id);
    }

    public function test_tenant_service_permissions_enforce_boundaries(): void
    {
        $tenantService = app(TenantService::class);

        // Village admin of Sukamaju can manage Sukamaju
        $canManageSukamaju = $tenantService->canManageVillage($this->villageAdmin, $this->sukamaju);
        $this->assertTrue($canManageSukamaju);

        // Village admin of Sukamaju CANNOT manage Berkah Mandiri
        $canManageBerkah = $tenantService->canManageVillage($this->villageAdmin, $this->berkahMandiri);
        $this->assertFalse($canManageBerkah);
    }
}

