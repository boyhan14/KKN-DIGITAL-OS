<?php

namespace Tests\Feature;

use App\Models\KknGroup;
use App\Models\Umkm;
use App\Models\UmkmProduct;
use App\Models\User;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UmkmManagementTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    protected User $student;
    protected User $supervisor;
    protected User $umkmUser;
    protected Village $village;
    protected KknGroup $group;

    protected function setUp(): void
    {
        parent::setUp();
        $this->student = User::where('email', 'student@example.com')->firstOrFail();
        $this->supervisor = User::where('email', 'supervisor@example.com')->firstOrFail();
        $this->umkmUser = User::where('email', 'umkm@example.com')->firstOrFail();
        $this->village = Village::where('slug', 'sukamaju')->firstOrFail();
        $this->group = KknGroup::firstOrFail();
        $this->group->update(['status' => 'ACTIVE']);
    }

    public function test_can_view_village_umkm_management_page(): void
    {
        $response = $this->actingAs($this->student)
            ->get("/workspace/village/{$this->village->id}/umkm");

        $response->assertStatus(200);
        $response->assertSee('Direktori UMKM');
    }

    public function test_can_view_umkm_create_form(): void
    {
        $response = $this->actingAs($this->student)
            ->get("/workspace/village/{$this->village->id}/umkm/create");

        $response->assertStatus(200);
        $response->assertSee('Daftarkan UMKM Baru');
    }

    public function test_can_create_new_umkm_and_submit_for_review(): void
    {
        $umkmData = [
            'business_name' => 'Sambal Honje Warisan Ibu',
            'owner_name' => 'Ibu Rohayah',
            'category' => 'FOOD',
            'description' => 'Sambal bunga kecombrang dengan terasi bakar khas pegunungan.',
            'address' => 'Kp. Babakan RT 02 RW 04',
            'latitude' => -6.6950,
            'longitude' => 106.9420,
            'phone' => '081234445566',
            'whatsapp' => '081234445566',
            'instagram' => '@sambalhonje.sukamaju',
        ];

        // 1. Create UMKM (status: DRAFT)
        $response = $this->actingAs($this->student)
            ->post("/workspace/village/{$this->village->id}/umkm", $umkmData);

        $umkm = Umkm::where('business_name', 'Sambal Honje Warisan Ibu')->firstOrFail();
        $response->assertRedirect("/workspace/village/{$this->village->id}/umkm/{$umkm->id}/edit");
        $this->assertEquals('DRAFT', $umkm->status);

        // 2. Add product to UMKM
        $productResponse = $this->actingAs($this->student)
            ->post("/workspace/village/{$this->village->id}/umkm/{$umkm->id}/products", [
                'name' => 'Sambal Honje Botol 150g',
                'price' => 28000,
                'description' => 'Sambal pedas wangi kecombrang segar kemasan jar kaca kedap udara.',
                'category' => 'Sambal',
            ]);

        $productResponse->assertRedirect();
        $this->assertDatabaseHas('umkm_products', [
            'umkm_id' => $umkm->id,
            'name' => 'Sambal Honje Botol 150g',
            'price' => 28000,
        ]);

        // 3. Submit UMKM for Supervisor Review
        $submitResponse = $this->actingAs($this->student)
            ->post("/workspace/village/{$this->village->id}/umkm/{$umkm->id}/submit");

        $submitResponse->assertRedirect();
        $this->assertEquals('PENDING_REVIEW', $umkm->fresh()->status);

        // 4. Supervisor sees pending review on Supervisor Dashboard
        $supDashboard = $this->actingAs($this->supervisor)
            ->get('/supervisor/dashboard');

        $supDashboard->assertStatus(200);
        $supDashboard->assertSee('Sambal Honje Warisan Ibu');

        // 5. Supervisor approves UMKM
        $approveResponse = $this->actingAs($this->supervisor)
            ->post('/supervisor/review', [
                'type' => 'umkm',
                'id' => $umkm->id,
                'action' => 'APPROVE',
                'comments' => 'Foto dan deskripsi sangat lengkap. Layak terbit.',
            ]);

        $approveResponse->assertRedirect();
        $this->assertEquals('PUBLISHED', $umkm->fresh()->status);

        // 6. Check that approved UMKM is now accessible on the public village portal
        $publicResponse = $this->get("/desa/{$this->village->slug}/umkm/{$umkm->slug}");
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('Sambal Honje Warisan Ibu');
        $publicResponse->assertSee('Sambal Honje Botol 150g');
        $publicResponse->assertSee('Ibu Rohayah');
    }

    public function test_supervisor_can_reject_umkm_with_feedback(): void
    {
        $umkm = Umkm::create([
            'village_id' => $this->village->id,
            'kkn_group_id' => $this->group->id,
            'user_id' => $this->student->id,
            'business_name' => 'Kerupuk Kulit Super Renyah',
            'slug' => 'kerupuk-kulit-super-renyah',
            'owner_name' => 'Mang Udin',
            'category' => 'FOOD',
            'status' => 'PENDING_REVIEW',
        ]);

        $response = $this->actingAs($this->supervisor)
            ->post('/supervisor/review', [
                'type' => 'umkm',
                'id' => $umkm->id,
                'action' => 'REJECT',
                'comments' => 'Mohon sertakan nomor WhatsApp dan foto produk asli.',
            ]);

        $response->assertRedirect();
        $this->assertEquals('DRAFT', $umkm->fresh()->status);
        $this->assertDatabaseHas('approvals', [
            'approvable_id' => $umkm->id,
            'status' => 'REJECTED',
            'comments' => 'Mohon sertakan nomor WhatsApp dan foto produk asli.',
        ]);
    }
}

