<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\Umkm;
use App\Models\Village;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicVillagePortalTest extends TestCase
{
    use RefreshDatabase;

    protected bool $seed = true;

    public function test_can_view_public_village_home_page(): void
    {
        $response = $this->get('/desa/sukamaju');

        $response->assertStatus(200);
        $response->assertSee('Desa Sukamaju');
        $response->assertSee('Produk Unggulan UMKM Desa');
        $response->assertSee('Curug Sukamaju Indah');
    }

    public function test_can_view_public_about_page(): void
    {
        $response = $this->get('/desa/sukamaju/tentang');

        $response->assertStatus(200);
        $response->assertSee('Visi Desa');
        $response->assertSee('Misi Pembangunan Desa');
        $response->assertSee('Fasilitas Pelayanan Desa');
    }

    public function test_can_view_public_umkm_directory_and_filter(): void
    {
        $response = $this->get('/desa/sukamaju/umkm');

        $response->assertStatus(200);
        $response->assertSee('Katalog Produk');
        $response->assertSee('Kopi Lereng Sukamaju');

        // Search query
        $searchResponse = $this->get('/desa/sukamaju/umkm?q=Kopi');
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Kopi Lereng Sukamaju');
    }

    public function test_can_view_public_umkm_detail_page(): void
    {
        $umkm = Umkm::where('slug', 'kopi-lereng-sukamaju')->first();
        $this->assertNotNull($umkm);

        $response = $this->get("/desa/sukamaju/umkm/{$umkm->slug}");

        $response->assertStatus(200);
        $response->assertSee('Kopi Lereng Sukamaju');
        $response->assertSee('Chat via WhatsApp');
        $response->assertSee('Kopi Arabika Specialty Sukamaju 200g');
    }

    public function test_can_view_public_tourism_page(): void
    {
        $response = $this->get('/desa/sukamaju/wisata');

        $response->assertStatus(200);
        $response->assertSee('Curug Sukamaju Indah');
        $response->assertSee('Puncak Bukit Hijau Camping Ground');
    }

    public function test_can_view_public_interactive_map_page(): void
    {
        $response = $this->get('/desa/sukamaju/peta');

        $response->assertStatus(200);
        $response->assertSee('Peta Digital Interaktif Desa Sukamaju');
        $response->assertSee('leaflet-village-map');
    }

    public function test_can_view_public_events_page(): void
    {
        $response = $this->get('/desa/sukamaju/agenda');

        $response->assertStatus(200);
        $response->assertSee('Agenda Mendatang');
        $response->assertSee('Launching Website Resmi');
    }

    public function test_can_view_public_news_archive_and_detail(): void
    {
        $response = $this->get('/desa/sukamaju/warta');

        $response->assertStatus(200);
        $response->assertSee('Warta Desa Sukamaju');

        $article = Article::where('village_id', 1)->where('status', 'PUBLISHED')->first();
        $this->assertNotNull($article);

        $detailResponse = $this->get("/desa/sukamaju/warta/{$article->slug}");
        $detailResponse->assertStatus(200);
        $detailResponse->assertSee($article->title);
    }

    public function test_can_view_public_gallery_page(): void
    {
        $response = $this->get('/desa/sukamaju/galeri');

        $response->assertStatus(200);
        $response->assertSee('Album Desa Sukamaju');
        $response->assertSee('Dokumentasi Program Kerja KKN 14');
    }

    public function test_can_view_public_kkn_documentation_page(): void
    {
        $response = $this->get('/desa/sukamaju/kkn');

        $response->assertStatus(200);
        $response->assertSee('Dokumentasi KKN Desa Sukamaju');
        $response->assertSee('Kelompok KKN 14 — Desa Sukamaju');
        $response->assertSee('Bintang Pratama');
    }

    public function test_can_view_public_impact_metrics_page(): void
    {
        $response = $this->get('/desa/sukamaju/dampak');

        $response->assertStatus(200);
        $response->assertSee('Transformasi Digital Desa Sukamaju');
        $response->assertSee('SDG 8');
        $response->assertSee('Digital Handover');
    }

    public function test_can_view_public_handover_certificate_page(): void
    {
        $response = $this->get('/desa/sukamaju/handover');

        $response->assertStatus(200);
        $response->assertSee('DIGITAL VILLAGE HANDOVER');
        $response->assertSee('BERITA ACARA');
    }

    public function test_can_view_public_contact_page(): void
    {
        $response = $this->get('/desa/sukamaju/kontak');

        $response->assertStatus(200);
        $response->assertSee('Kantor Desa Sukamaju');
        $response->assertSee('Nomor Darurat');
    }

    public function test_invalid_village_slug_returns_404(): void
    {
        $response = $this->get('/desa/desa-tidak-ada-999');

        $response->assertStatus(404);
    }
}
