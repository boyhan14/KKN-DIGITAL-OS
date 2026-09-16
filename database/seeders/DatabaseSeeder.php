<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Campus;
use App\Models\CampusMember;
use App\Models\KknProgram;
use App\Models\Village;
use App\Models\VillageAdmin;
use App\Models\VillageProfile;
use App\Models\VillageFacility;
use App\Models\KknGroup;
use App\Models\GroupMember;
use App\Models\Program;
use App\Models\ProgramTask;
use App\Models\Umkm;
use App\Models\UmkmProduct;
use App\Models\TourismPlace;
use App\Models\MapLocation;
use App\Models\Event;
use App\Models\Article;
use App\Models\Album;
use App\Models\MediaItem;
use App\Models\ProgramDocument;
use App\Models\ImpactMetric;
use App\Models\HandoverPackage;
use App\Models\HandoverItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // 1. Seed Core Users across All Roles
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@example.com',
            'password' => $password,
            'role' => 'SUPER_ADMIN',
            'phone' => '081100000001',
            'bio' => 'Pengawas dan pengelola pusat platform KKN Digital Village OS.',
        ]);

        $campusAdmin = User::create([
            'name' => 'Dr. Ir. Hendro Prabowo, M.T.',
            'email' => 'campus@example.com',
            'password' => $password,
            'role' => 'CAMPUS_ADMIN',
            'phone' => '081100000002',
            'bio' => 'Koordinator Pusat Pengabdian Masyarakat & KKN Lembaga Penelitian dan Pengabdian kepada Masyarakat (LPPM).',
        ]);

        $supervisor = User::create([
            'name' => 'Prof. Dr. Rina Kusuma, S.Kom., M.Cs.',
            'email' => 'supervisor@example.com',
            'password' => $password,
            'role' => 'SUPERVISOR',
            'faculty' => 'Fakultas Ilmu Komputer',
            'major' => 'Sistem Informasi',
            'phone' => '081100000003',
            'bio' => 'Dosen Pembimbing Lapangan (DPL) spesialisasi Transformasi Digital Pedesaan & Smart Village.',
        ]);

        $groupLeader = User::create([
            'name' => 'Bintang Pratama',
            'email' => 'leader@example.com',
            'password' => $password,
            'role' => 'GROUP_LEADER',
            'student_id' => '2023101001',
            'faculty' => 'Fakultas Ilmu Komputer',
            'major' => 'Teknik Informatika',
            'skills' => json_encode(['Web Development', 'Digital Marketing', 'Project Management']),
            'phone' => '081100000004',
            'bio' => 'Ketua Kelompok KKN Desa Sukamaju, penggerak program digitalisasi UMKM dan sistem desa.',
        ]);

        $student = User::create([
            'name' => 'Siti Annisa Rahmawati',
            'email' => 'student@example.com',
            'password' => $password,
            'role' => 'STUDENT',
            'student_id' => '2023101002',
            'faculty' => 'Fakultas Ekonomi dan Bisnis',
            'major' => 'Manajemen Bisnis',
            'skills' => json_encode(['Financial Planning', 'Branding', 'Content Creation']),
            'phone' => '081100000005',
            'bio' => 'Anggota Tim KKN divisi Perekonomian & Pendampingan Pelaku Usaha Lokal.',
        ]);

        // Additional Students to complete a realistic KKN squad
        $student2 = User::create([
            'name' => 'Fajar Nugraha',
            'email' => 'fajar@example.com',
            'password' => $password,
            'role' => 'STUDENT',
            'student_id' => '2023101003',
            'faculty' => 'Fakultas Pertanian',
            'major' => 'Agroteknologi',
            'skills' => json_encode(['Urban Farming', 'Waste Management', 'GIS Mapping']),
            'phone' => '081100000006',
        ]);

        $student3 = User::create([
            'name' => 'Dewi Safitri',
            'email' => 'dewi@example.com',
            'password' => $password,
            'role' => 'STUDENT',
            'student_id' => '2023101004',
            'faculty' => 'Fakultas Ilmu Kesehatan',
            'major' => 'Kesehatan Masyarakat',
            'skills' => json_encode(['Health Education', 'Nutrition Screening', 'Posyandu Revitalization']),
            'phone' => '081100000007',
        ]);

        $villageAdmin = User::create([
            'name' => 'Bapak Suryana, S.Sos (Kepala Desa)',
            'email' => 'village@example.com',
            'password' => $password,
            'role' => 'VILLAGE_ADMIN',
            'phone' => '081100000008',
            'bio' => 'Kepala Desa Sukamaju, memimpin penyelenggaraan pemerintahan dan pelayanan masyarakat desa.',
        ]);

        $umkmUser = User::create([
            'name' => 'Pak Joko Widodo (Pemilik Kopi Sukamaju)',
            'email' => 'umkm@example.com',
            'password' => $password,
            'role' => 'UMKM_OWNER',
            'phone' => '081234567890',
            'bio' => 'Ketua Paguyuban Petani Kopi dan Pelaku UMKM Kopi Lereng Sukamaju.',
        ]);

        // 2. Primary Campus & Affiliation
        $campus = Campus::create([
            'name' => 'Universitas Indonesia Mandiri',
            'slug' => 'uim',
            'address' => 'Jl. Boulevard Kampus Mandiri No. 1, Jawa Barat',
            'contact_email' => 'lppm@kampusmandiri.ac.id',
            'website' => 'https://kampusmandiri.ac.id',
        ]);

        CampusMember::create(['campus_id' => $campus->id, 'user_id' => $campusAdmin->id, 'role' => 'CAMPUS_ADMIN']);
        CampusMember::create(['campus_id' => $campus->id, 'user_id' => $supervisor->id, 'role' => 'SUPERVISOR']);
        CampusMember::create(['campus_id' => $campus->id, 'user_id' => $groupLeader->id, 'role' => 'STUDENT']);
        CampusMember::create(['campus_id' => $campus->id, 'user_id' => $student->id, 'role' => 'STUDENT']);
        CampusMember::create(['campus_id' => $campus->id, 'user_id' => $student2->id, 'role' => 'STUDENT']);
        CampusMember::create(['campus_id' => $campus->id, 'user_id' => $student3->id, 'role' => 'STUDENT']);

        // 3. KKN Program Batch
        $kknProgram = KknProgram::create([
            'campus_id' => $campus->id,
            'name' => 'KKN Tematik Digitalisasi Desa Periode Semester Ganjil',
            'year' => '2025/2026',
            'period' => 'Semester Ganjil',
            'start_date' => now()->subDays(45)->toDateString(),
            'end_date' => now()->addDays(15)->toDateString(),
            'status' => 'ACTIVE',
            'description' => 'Program KKN Tematik berfokus pada hilirisasi digital produk UMKM, pemetaan pariwisata, revitalisasi pelayanan warga, serta penyerahan sistem terpadu kepada aparatur desa.',
        ]);

        // 4. Showcase Village: Desa Sukamaju
        $village = Village::create([
            'campus_id' => $campus->id,
            'kkn_program_id' => $kknProgram->id,
            'name' => 'Sukamaju',
            'slug' => 'sukamaju',
            'district' => 'Cisarua',
            'regency' => 'Bogor',
            'province' => 'Jawa Barat',
            'theme' => 'modern',
            'cover_image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1600&auto=format&fit=crop',
            'head_name' => 'Bapak H. Suryana, S.Sos',
            'contact' => '0812-3456-7890',
            'email' => 'pemdes@sukamaju.desa.id',
            'is_active' => true,
        ]);

        VillageAdmin::create([
            'village_id' => $village->id,
            'user_id' => $villageAdmin->id,
            'is_active' => true,
            'assigned_at' => now()->subDays(30),
        ]);

        // Detailed Village Profile
        VillageProfile::create([
            'village_id' => $village->id,
            'vision' => 'Mewujudkan Desa Sukamaju yang Mandiri, Sejahtera, Berdaya Saing, dan Unggul Berbasis Kearifan Lokal serta Transformasi Digital.',
            'mission' => "1. Meningkatkan tata kelola pemerintahan desa yang bersih, transparan, dan berbasis digital.\n2. Mengembangkan ekonomi kerakyatan melalui digitalisasi UMKM dan pariwisata terpadu.\n3. Meningkatkan kualitas layanan kesehatan warga, balita, dan lansia.\n4. Menjaga kelestarian lingkungan hidup dan bentang alam pedesaan.",
            'history' => 'Desa Sukamaju didirikan pada tahun 1952 oleh para sesepuh yang bergotong-royong membuka perkebunan kopi dan teh di lereng bukit Cisarua. Nama Sukamaju diambil dari harapan agar masyarakatnya senantiasa suka dan giat untuk maju.',
            'geography' => 'Terletak pada ketinggian 850 mdpl di lereng pegunungan dengan udara sejuk bersuhu rata-rata 20-25°C. Wilayah didominasi oleh perkebunan hortikultura, persawahan terasering, dan hutan lindung mata air.',
            'demographics_summary' => "Total Penduduk: 4.850 Jiwa (Laki-laki: 2.420, Perempuan: 2.430). Jumlah KK: 1.280. Jumlah Dusun/RW: 6 RW, 24 RT. Mayoritas mata pencaharian adalah petani hortikultura, kopi, peternak sapi perah, dan pelaku UMKM olahan pangan.",
            'economic_profile' => 'Perekonomian didorong oleh sektor agribisnis (sayur mayur & kopi arabika), kerajinan bambu, olahan susu perah, serta destinasi wisata air terjun dan panorama alam.',
            'status' => 'PUBLISHED',
        ]);

        // Village Public Facilities
        $facilities = [
            ['name' => 'Balai Desa & Sentra Pelayanan Sukamaju', 'category' => 'GOVERNMENT', 'address' => 'Jl. Raya Desa Sukamaju No. 12', 'lat' => -6.6912, 'lng' => 106.9451, 'desc' => 'Pusat administrasi kependudukan dan balai musyawarah warga.'],
            ['name' => 'Puskesmas Pembantu (Pustu) Sukamaju', 'category' => 'HEALTH', 'address' => 'Jl. Sehat Warga No. 3', 'lat' => -6.6925, 'lng' => 106.9460, 'desc' => 'Layanan rawat jalan, imunisasi balita, dan pos kesehatan desa siaga 24 jam.'],
            ['name' => 'SD Negeri 01 Sukamaju', 'category' => 'EDUCATION', 'address' => 'Jl. Pendidikan No. 7', 'lat' => -6.6905, 'lng' => 106.9438, 'desc' => 'Sekolah dasar percontohan ramah anak dan literasi sains.'],
            ['name' => 'Masjid Jami’ Al-Barokah', 'category' => 'WORSHIP', 'address' => 'Jl. Al-Barokah RT 02 RW 01', 'lat' => -6.6898, 'lng' => 106.9472, 'desc' => 'Masjid utama desa dengan kapasitas 1.000 jamaah dan pusat pengajian warga.'],
            ['name' => 'Bank Sampah & Rumah Daur Ulang Mandiri', 'category' => 'PUBLIC', 'address' => 'Jl. Lingkungan Asri RT 04 RW 02', 'lat' => -6.6938, 'lng' => 106.9421, 'desc' => 'Fasilitas pemilahan sampah organik dan anorganik binaan program KKN.'],
            ['name' => 'Lapangan Olahraga Gelora Sukamaju', 'category' => 'PUBLIC', 'address' => 'Kompleks Balai Warga', 'lat' => -6.6918, 'lng' => 106.9485, 'desc' => 'Lapangan sepak bola mini, voli, dan arena senam kebugaran lansia.'],
        ];

        foreach ($facilities as $fac) {
            VillageFacility::create([
                'village_id' => $village->id,
                'name' => $fac['name'],
                'category' => $fac['category'],
                'address' => $fac['address'],
                'latitude' => $fac['lat'],
                'longitude' => $fac['lng'],
                'description' => $fac['desc'],
            ]);

            MapLocation::create([
                'village_id' => $village->id,
                'title' => $fac['name'],
                'category' => 'FACILITY',
                'description' => $fac['desc'],
                'latitude' => $fac['lat'],
                'longitude' => $fac['lng'],
            ]);
        }

        // 5. KKN Group for Desa Sukamaju
        $group = KknGroup::create([
            'kkn_program_id' => $kknProgram->id,
            'village_id' => $village->id,
            'supervisor_id' => $supervisor->id,
            'leader_id' => $groupLeader->id,
            'group_name' => 'Kelompok KKN 14 — Desa Sukamaju',
            'group_code' => 'KKN-14-SUKAMAJU',
            'start_date' => now()->subDays(45)->toDateString(),
            'end_date' => now()->addDays(15)->toDateString(),
            'status' => 'ACTIVE',
        ]);

        GroupMember::create(['kkn_group_id' => $group->id, 'user_id' => $groupLeader->id, 'role' => 'LEADER', 'contribution_notes' => 'Koordinator tim']);
        GroupMember::create(['kkn_group_id' => $group->id, 'user_id' => $student->id, 'role' => 'MEMBER', 'contribution_notes' => 'Divisi UMKM']);
        GroupMember::create(['kkn_group_id' => $group->id, 'user_id' => $student2->id, 'role' => 'MEMBER', 'contribution_notes' => 'Divisi Lingkungan & GIS']);
        GroupMember::create(['kkn_group_id' => $group->id, 'user_id' => $student3->id, 'role' => 'MEMBER', 'contribution_notes' => 'Divisi Kesehatan']);

        // 6. 10 Published UMKMs & 30 Products
        $umkmData = [
            [
                'name' => 'Kopi Lereng Sukamaju',
                'owner' => 'Pak Joko Widodo',
                'category' => 'FOOD',
                'phone' => '081234567890',
                'image' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=800&auto=format&fit=crop',
                'desc' => 'Biji kopi arabika dan robusta pilihan dipetik dari lereng ketinggian 850 mdpl Desa Sukamaju dengan metode olah alami (natural & honey process) yang menghasilkan aroma manis karamel khas Nusantara.',
                'address' => 'Kampung Legok Nyenang RT 01 RW 03',
                'lat' => -6.6940, 'lng' => 106.9410,
                'products' => [
                    ['name' => 'Kopi Arabika Specialty Sukamaju 200g', 'desc' => 'Biji kopi sangrai medium roast dengan tasting note jeruk mandarin, brown sugar, dan cokelat manis.', 'price' => 75000],
                    ['name' => 'Kopi Robusta Premium Cisarua 250g', 'desc' => 'Kopi bubuk aroma kuat berkarakter bold cocok untuk kopi tubruk atau racikan es kopi susu kekinian.', 'price' => 45000],
                    ['name' => 'Cold Brew Botol Siap Minum 250ml', 'desc' => 'Ekstrak seduh dingin 14 jam tanpa ampas, rendah asam, dan menyegarkan saat dinikmati dingin.', 'price' => 22000],
                ]
            ],
            [
                'name' => 'Keripik Singkong Renyah Bu Ani',
                'owner' => 'Ibu Ani Suryani',
                'category' => 'FOOD',
                'phone' => '081398765432',
                'image' => 'https://images.unsplash.com/photo-1566478989037-eec170784d0b?q=80&w=800&auto=format&fit=crop',
                'desc' => 'Olahan keripik singkong mentega gurih tanpa pengawet dengan potongan tipis ekstra renyah dan bumbu rempah tradisional warisan keluarga turun temurun.',
                'address' => 'Jl. Kebun Singkong RT 03 RW 01',
                'lat' => -6.6908, 'lng' => 106.9442,
                'products' => [
                    ['name' => 'Keripik Singkong Balado Daun Jeruk 150g', 'desc' => 'Sensasi pedas manis berpadu wangi daun jeruk segar.', 'price' => 18000],
                    ['name' => 'Keripik Singkong Original Gurih Asin 150g', 'desc' => 'Renyah renyah dengan taburan garam gurih dan bawang putih.', 'price' => 15000],
                    ['name' => 'Keripik Singkong Keju Bakar 150g', 'desc' => 'Varian kekinian rasa keju manis legit digemari anak muda.', 'price' => 20000],
                ]
            ],
            [
                'name' => 'Madu Hutan Murni Lestari',
                'owner' => 'Kang Dadang',
                'category' => 'FOOD',
                'phone' => '085712349988',
                'image' => 'https://images.unsplash.com/photo-1587049352846-4a222e784d38?q=80&w=800&auto=format&fit=crop',
                'desc' => 'Madu murni alami yang dipanen langsung dari sarang lebah pohon hutan lindung Sukamaju tanpa pemanasan buatan (raw honey) sehingga enzim dan khasiat kesehatannya utuh.',
                'address' => 'Kampung Hutan Lebah RT 02 RW 04',
                'lat' => -6.6965, 'lng' => 106.9380,
                'products' => [
                    ['name' => 'Madu Odeng Liar Asli Botol Kaca 500ml', 'desc' => 'Madu lebah liar hutan dengan khasiat daya tahan tubuh optimal.', 'price' => 135000],
                    ['name' => 'Madu Nektar Kopi Cisarua 250ml', 'desc' => 'Madu hasil lebah yang menghisap nektar bunga kopi beraroma floral.', 'price' => 80000],
                    ['name' => 'Propolis Lebah Alami Tetes 15ml', 'desc' => 'Ekstrak propolis konsentrat tinggi untuk imunitas tubuh.', 'price' => 65000],
                ]
            ],
            [
                'name' => 'Kerajinan Anyaman Bambu Sukamaju',
                'owner' => 'Pak Maryono',
                'category' => 'CRAFT',
                'phone' => '081299887766',
                'image' => 'https://images.unsplash.com/photo-1590736969955-71cc94801759?q=80&w=800&auto=format&fit=crop',
                'desc' => 'Kerajinan tangan ramah lingkungan berbahan bambu tali pilihan karya kelompok perajin sepuh desa, menghasilkan perabot estetik bernilai seni tinggi.',
                'address' => 'Dusun Anyaman Bambu RT 04 RW 02',
                'lat' => -6.6920, 'lng' => 106.9470,
                'products' => [
                    ['name' => 'Besek Bambu Hantaran / Souvenir Set isi 5', 'desc' => 'Wadah anyaman bambu rapi ramah lingkungan untuk hajatan.', 'price' => 35000],
                    ['name' => 'Tas Jinjing Bambu Kombinasi Kulit Estetik', 'desc' => 'Tas fashion anyaman bambu elegan cocok untuk bepergian santai.', 'price' => 120000],
                    ['name' => 'Tampah Bambu Tradisional Diameter 50cm', 'desc' => 'Anyaman rapat kuat untuk penampi beras atau sajian tumpeng.', 'price' => 40000],
                ]
            ],
            [
                'name' => 'Batik Tulis Motif Daun Teh',
                'owner' => 'Ibu Endang S.',
                'category' => 'FASHION',
                'phone' => '081822334455',
                'image' => 'https://images.unsplash.com/photo-1607604276583-eef5d076aa5f?q=80&w=800&auto=format&fit=crop',
                'desc' => 'Karya batik tulis tangan asli dengan corak motif flora pegunungan dan pucuk daun teh khas Desa Sukamaju menggunakan pewarna alami ramah lingkungan.',
                'address' => 'Sanggar Batik Cisarua Indah RT 01 RW 01',
                'lat' => -6.6895, 'lng' => 106.9458,
                'products' => [
                    ['name' => 'Kain Batik Tulis Katun Primissima 2.2m', 'desc' => 'Kain batik motif pucuk daun teh warna cokelat soga alami.', 'price' => 350000],
                    ['name' => 'Kemeja Batik Pria Lengan Panjang Eksklusif', 'desc' => 'Kemeja batik furing halus jahitan butik berkelas.', 'price' => 420000],
                    ['name' => 'Selendang Batik Sutra Halus', 'desc' => 'Aksen elegan untuk busana formal atau cinderamata resmi.', 'price' => 210000],
                ]
            ],
            [
                'name' => 'Sambal Uleg Roa & Bawang Mak Siti',
                'owner' => 'Mak Siti Salamah',
                'category' => 'FOOD',
                'phone' => '087811223344',
                'image' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=800&auto=format&fit=crop',
                'desc' => 'Sambal olahan rumahan higienis tanpa MSG berlebih, dikemas dalam jar steril kedap udara dengan rempah segar hasil kebun warga desa.',
                'address' => 'Gang Dapur Mak Siti No. 5',
                'lat' => -6.6915, 'lng' => 106.9430,
                'products' => [
                    ['name' => 'Sambal Bawang Pedas Nampol 150g', 'desc' => 'Perpaduan cabai rawit merah segar dan bawang merah desa.', 'price' => 28000],
                    ['name' => 'Sambal Ikan Roa Asap Gurih 150g', 'desc' => 'Gurihnya ikan asap pilihan dalam racikan pedas nikmat.', 'price' => 38000],
                    ['name' => 'Sambal Ijo Teri Medan 150g', 'desc' => 'Sambal cabe hijau wangi minyak kelapa dengan taburan teri renyah.', 'price' => 30000],
                ]
            ],
            [
                'name' => 'Susu Sapi Segar Barokah Cisarua',
                'owner' => 'Pak Hendra Gunawan',
                'category' => 'FOOD',
                'phone' => '085244556677',
                'image' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?q=80&w=800&auto=format&fit=crop',
                'desc' => 'Susu murni dari peternakan sapi perah lokal yang higienis, diperah tiap pagi dan sore untuk menjamin kesegaran dan gizi kalsium tinggi.',
                'address' => 'Peternakan Hijau Blok B No. 3',
                'lat' => -6.6950, 'lng' => 106.9465,
                'products' => [
                    ['name' => 'Susu Murni Pasteurisasi 1 Liter', 'desc' => 'Susu sapi murni segar tanpa tambahan pengawet atau gula.', 'price' => 20000],
                    ['name' => 'Yoghurt Minuman Buah Segar 250ml', 'desc' => 'Minuman probiotik sehat varian stroberi dan mangga harum manis.', 'price' => 15000],
                    ['name' => 'Keju Mozzarella Homemade Lokal 200g', 'desc' => 'Keju leleh legit cocok untuk pizza rumahan atau roti panggang.', 'price' => 45000],
                ]
            ],
            [
                'name' => 'Bibit Tanaman & Pupuk Kompos Asri',
                'owner' => 'Kang Asep Saepudin',
                'category' => 'AGRICULTURE',
                'phone' => '082199001122',
                'image' => 'https://images.unsplash.com/photo-1466692476868-aef1dfb1e735?q=80&w=800&auto=format&fit=crop',
                'desc' => 'Pusat pembibitan sayuran organik, tanaman hias pekarangan, serta produksi pupuk kompos kaya hara hasil fermentasi sisa daun kebun.',
                'address' => 'Kebun Bibit Lestari RT 05 RW 02',
                'lat' => -6.6970, 'lng' => 106.9440,
                'products' => [
                    ['name' => 'Paket 10 Macam Benih Sayur Rumah Tangga', 'desc' => 'Bibit cabai, tomat, bayam, kangkung, terong, dan sawi.', 'price' => 25000],
                    ['name' => 'Pupuk Kompos Organik Matang 5kg', 'desc' => 'Kompos fermentasi kaya mikroorganisme penyubur media tanam.', 'price' => 18000],
                    ['name' => 'Tanaman Hias Monstera Pot Keramik', 'desc' => 'Tanaman indoor sehat daun membelah cantik untuk dekorasi ruang.', 'price' => 85000],
                ]
            ],
            [
                'name' => 'Bolu Pisang & Roti Manis Mbak Dewi',
                'owner' => 'Mbak Dewi Anggraini',
                'category' => 'CULINARY',
                'phone' => '081377889900',
                'image' => 'https://images.unsplash.com/photo-1509440159596-0249088772ff?q=80&w=800&auto=format&fit=crop',
                'desc' => 'Aneka olahan kue basah dan roti lembut memanfaatkan pisang raja lokal yang manis legit, dipanggang setiap pagi hangat langsung dari oven.',
                'address' => 'Perumahan Desa Asri Blok C-2',
                'lat' => -6.6902, 'lng' => 106.9425,
                'products' => [
                    ['name' => 'Bolu Pisang Raja Panggang Wangi Loyang 22cm', 'desc' => 'Tekstur lembut beraroma butter dan taburan keju cheddar.', 'price' => 50000],
                    ['name' => 'Roti Sobek Cokelat Lumer Keju isi 6', 'desc' => 'Roti empuk serat lembut tahan empuk tanpa pengawet buatan.', 'price' => 30000],
                    ['name' => 'Pie Susu Renyah Mini isi 10 Pcs', 'desc' => 'Kulit pie renyah dengan isian fla susu manis gurih lumer di mulut.', 'price' => 28000],
                ]
            ],
            [
                'name' => 'Pande Besi & Alat Pertanian Sukamaju',
                'owner' => 'Pak Slamet Riyadi',
                'category' => 'SERVICE',
                'phone' => '085611223388',
                'image' => 'https://images.unsplash.com/photo-1504917599217-d4dc5ebe6122?q=80&w=800&auto=format&fit=crop',
                'desc' => 'Bilah tajam perkakas kebun dan alat pertanian tradisional buatan tangan empu besi desa dengan baja per berkualitas tempaan matang.',
                'address' => 'Bengkel Pande Besi RT 02 RW 03',
                'lat' => -6.6932, 'lng' => 106.9405,
                'products' => [
                    ['name' => 'Cangkul Baja Tempa Gagang Kayu Jati', 'desc' => 'Cangkul kuat tahan batu untuk pengolahan lahan sawah kebun.', 'price' => 95000],
                    ['name' => 'Sabit Pemotong Rumput & Padi Baja Tajam', 'desc' => 'Bilah melengkung ergonomis tajam awet untuk memanen.', 'price' => 55000],
                    ['name' => 'Golok Tebas Serbaguna Sarung Kayu Mahoni', 'desc' => 'Golok kerja kebun tebas ranting kuat dan kokoh.', 'price' => 110000],
                ]
            ],
        ];

        foreach ($umkmData as $item) {
            $createdUmkm = Umkm::create([
                'village_id' => $village->id,
                'kkn_group_id' => $group->id,
                'user_id' => $umkmUser->id,
                'business_name' => $item['name'],
                'slug' => Str::slug($item['name']),
                'owner_name' => $item['owner'],
                'category' => $item['category'],
                'description' => $item['desc'],
                'phone' => $item['phone'],
                'whatsapp' => $item['phone'],
                'cover_image' => $item['image'],
                'address' => $item['address'],
                'latitude' => $item['lat'],
                'longitude' => $item['lng'],
                'status' => 'PUBLISHED',
            ]);

            foreach ($item['products'] as $prod) {
                UmkmProduct::create([
                    'umkm_id' => $createdUmkm->id,
                    'name' => $prod['name'],
                    'slug' => Str::slug($prod['name']),
                    'description' => $prod['desc'],
                    'price' => $prod['price'],
                    'image' => $item['image'],
                    'is_available' => true,
                ]);
            }

            MapLocation::create([
                'village_id' => $village->id,
                'title' => $createdUmkm->business_name,
                'category' => 'UMKM',
                'description' => $createdUmkm->description,
                'latitude' => $createdUmkm->latitude,
                'longitude' => $createdUmkm->longitude,
            ]);
        }

        // 7. 5 Published Tourism Spots
        $tourismPlaces = [
            [
                'name' => 'Curug Sukamaju Indah',
                'category' => 'NATURE',
                'image' => 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Air terjun bertingkat dengan ketinggian 25 meter yang dikelilingi hutan pinus rindang dan bebatuan alami. Menyediakan kolam pemandian alami air jernih pegunungan, jalur trekking sejuk, dan spot foto instagramable.',
                'ticket_price' => 15000,
                'hours' => '07.30 - 17.00 WIB',
                'address' => 'Kampung Hutan Atas RT 01 RW 05',
                'lat' => -6.6985, 'lng' => 106.9350,
            ],
            [
                'name' => 'Puncak Bukit Hijau Camping Ground',
                'category' => 'ADVENTURE',
                'image' => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Area perkemahan di punggung bukit dengan pemandangan 360 derajat lanskap perbukitan Cisarua dan gemerlap lampu kota malam hari. Tempat terbaik menikmati matahari terbit (sunrise) berlatar siluet Gunung Salak.',
                'ticket_price' => 25000,
                'hours' => 'Buka 24 Jam (Reservasi)',
                'address' => 'Puncak Bukit Sukamaju RT 03 RW 05',
                'lat' => -6.6998, 'lng' => 106.9320,
            ],
            [
                'name' => 'Kampung Edukasi Pertanian Organik',
                'category' => 'CULTURE',
                'image' => 'https://images.unsplash.com/photo-1576085898323-218337e3e43c?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Wahana wisata edukasi untuk keluarga dan pelajar mengenai cara menanam sayur tanpa pestisida kimia, petik stroberi langsung dari kebun, dan workshop pembuatan pupuk kompos ramah lingkungan.',
                'ticket_price' => 20000,
                'hours' => '08.00 - 16.00 WIB',
                'address' => 'Blok Lembah Sayur RT 02 RW 02',
                'lat' => -6.6930, 'lng' => 106.9490,
            ],
            [
                'name' => 'Rumah Budaya & Sanggar Gamelan Sukamaju',
                'category' => 'CULTURE',
                'image' => 'https://images.unsplash.com/photo-1570784332176-fdd73da66f03?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Pusat konservasi seni dan tradisi Sunda yang menyajikan pertunjukan tarian tradisional jaipong, latihan gamelan salendro, dan galeri kerajinan wayang golek peninggalan tetua kampung.',
                'ticket_price' => 10000,
                'hours' => '09.00 - 17.00 WIB (Selasa - Minggu)',
                'address' => 'Kampung Adat RT 01 RW 01',
                'lat' => -6.6885, 'lng' => 106.9460,
            ],
            [
                'name' => 'Pasar Wisata Kuliner Akhir Pekan',
                'category' => 'CULINARY',
                'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1000&auto=format&fit=crop',
                'desc' => 'Pusat jajanan tradisional desa yang hanya digelar tiap hari Sabtu dan Minggu pagi di tepi sawah. Menyajikan aneka bubur sumsum, serabi kocor, bajigur, nasi liwet kastrol, dan camilan khas Sunda tempo dulu.',
                'ticket_price' => 0,
                'hours' => 'Sabtu & Minggu: 06.00 - 12.00 WIB',
                'address' => 'Tepi Sawah Blok Tengah RW 03',
                'lat' => -6.6910, 'lng' => 106.9448,
            ],
        ];

        foreach ($tourismPlaces as $place) {
            $createdTourism = TourismPlace::create([
                'village_id' => $village->id,
                'kkn_group_id' => $group->id,
                'name' => $place['name'],
                'slug' => Str::slug($place['name']),
                'category' => $place['category'],
                'description' => $place['desc'],
                'cover_image' => $place['image'],
                'ticket_price' => $place['ticket_price'],
                'opening_hours' => $place['hours'],
                'address' => $place['address'],
                'latitude' => $place['lat'],
                'longitude' => $place['lng'],
                'status' => 'PUBLISHED',
            ]);

            MapLocation::create([
                'village_id' => $village->id,
                'title' => $createdTourism->name,
                'category' => 'TOURISM',
                'description' => $createdTourism->description,
                'latitude' => $createdTourism->latitude,
                'longitude' => $createdTourism->longitude,
            ]);
        }

        // 8. 6 KKN Work Programs Across Sectors with Kanban Tasks
        $workPrograms = [
            [
                'title' => 'Digitalisasi Katalog & Pemberdayaan Pasar UMKM Desa',
                'category' => 'ECONOMY',
                'desc' => 'Pendataan terpadu 10 UMKM unggulan desa, pemotretan produk profesional, pembuatan profil digital, serta integrasi pemesanan langsung melalui WhatsApp.',
                'objective' => 'Meningkatkan omset dan jangkauan pasar digital pelaku UMKM desa hingga ke luar wilayah.',
                'target' => '150 Pelaku Usaha & Pengrajin',
                'status' => 'COMPLETED',
                'tasks' => [
                    ['title' => 'Survei dan wawancara kebutuhan 10 pelaku UMKM', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Sesi foto produk dan penyusunan deskripsi copywriting', 'status' => 'DONE', 'priority' => 'MEDIUM'],
                    ['title' => 'Input data katalog produk ke sistem KKN Digital Village OS', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Pelatihan cara merespons pesanan dan pembuatan QRIS UMKM', 'status' => 'DONE', 'priority' => 'HIGH'],
                ]
            ],
            [
                'title' => 'Revitalisasi Posyandu & Edukasi Pencegahan Stunting Balita',
                'category' => 'HEALTH',
                'desc' => 'Pemeriksaan status gizi balita, pemberian makanan tambahan (PMT) bergizi tinggi berbahan pangan lokal, serta penyuluhan gizi 1.000 hari pertama kehidupan (HPK).',
                'objective' => 'Menurunkan risiko stunting dan meningkatkan kesadaran pola makan bergizi bagi ibu hamil dan balita.',
                'target' => '320 Ibu Hamil & Balita',
                'status' => 'COMPLETED',
                'tasks' => [
                    ['title' => 'Koordinasi dengan bidan desa dan kader posyandu', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Penyusunan booklet menu gizi seimbang berbahan pangan desa', 'status' => 'DONE', 'priority' => 'MEDIUM'],
                    ['title' => 'Pelaksanaan posyandu serentak dan demonstrasi masak MP-ASI', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Pencatatan data kesehatan balita ke rekap digital desa', 'status' => 'DONE', 'priority' => 'MEDIUM'],
                ]
            ],
            [
                'title' => 'Bimbingan Belajar Literasi Sains & Digital untuk Siswa SD',
                'category' => 'EDUCATION',
                'desc' => 'Program pengajaran ekstrakurikuler interaktif meliputi pengenalan internet sehat, dasar komputer, eksperimen sains sederhana, dan penguatan literasi membaca anak.',
                'objective' => 'Membangun minat belajar anak-anak desa terhadap teknologi dan sains.',
                'target' => '210 Siswa SD & Remaja Desa',
                'status' => 'COMPLETED',
                'tasks' => [
                    ['title' => 'Pertemuan izin kurikulum dengan Kepala SDN 01 Sukamaju', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Pengadaan 100 buku bacaan anak untuk pojok literasi desa', 'status' => 'DONE', 'priority' => 'MEDIUM'],
                    ['title' => 'Pelaksanaan kelas sains mingguan dan internet bijak', 'status' => 'DONE', 'priority' => 'MEDIUM'],
                    ['title' => 'Lomba cerdas cermat anak tingkat desa', 'status' => 'DONE', 'priority' => 'LOW'],
                ]
            ],
            [
                'title' => 'Pemetaan Geospasial Spasial & Pemasangan Papan Informasi Wisata',
                'category' => 'INFRASTRUCTURE',
                'desc' => 'Pemetaan koordinat GPS seluruh sarana umum, batas dusun, dan destinasi wisata desa serta pengadaan papan petunjuk jalan kayu artistik.',
                'objective' => 'Memudahkan navigasi wisatawan dan pengunjung balai desa.',
                'target' => '450 Pengunjung & Wisatawan',
                'status' => 'COMPLETED',
                'tasks' => [
                    ['title' => 'Survei koordinat lintang-bujur 20 titik penting desa', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Input data spasial ke peta interaktif Leaflet/OSM', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Produksi dan pemasangan 8 tiang plang penunjuk arah kayu', 'status' => 'DONE', 'priority' => 'MEDIUM'],
                ]
            ],
            [
                'title' => 'Penguatan Bank Sampah & Pelatihan Daur Ulang Plastik',
                'category' => 'ENVIRONMENT',
                'desc' => 'Pelatihan pemilahan sampah organik untuk pakan maggot/kompos dan pembuatan ecobrick dari sampah plastik kemasan bersama ibu-ibu PKK.',
                'objective' => 'Menciptakan lingkungan desa bebas sampah liar dan bernilai ekonomi sirkular.',
                'target' => '180 Warga Lingkungan',
                'status' => 'COMPLETED',
                'tasks' => [
                    ['title' => 'Sosialisasi pemilahan sampah rumah tangga di balai RW', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Workshop pembuatan ecobrick dan kerajinan vas plastik', 'status' => 'DONE', 'priority' => 'MEDIUM'],
                    ['title' => 'Penyusunan SOP penimbangan dan buku tabungan bank sampah', 'status' => 'DONE', 'priority' => 'HIGH'],
                ]
            ],
            [
                'title' => 'Pengembangan Portal Desa Resmi & Pelatihan Admin Desa Mandiri',
                'category' => 'DIGITALIZATION',
                'desc' => 'Pembangunan website resmi Desa Sukamaju, pelatihan teknis bagi perangkat desa untuk memperbarui berita, UMKM, dan agenda secara berkelanjutan.',
                'objective' => 'Menjamin keberlanjutan sistem melalui proses serah terima digital resmi (Digital Handover).',
                'target' => 'Pemerintah Desa Sukamaju',
                'status' => 'COMPLETED',
                'tasks' => [
                    ['title' => 'Setup website resmi dan domain publik desa', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Penyusunan modul panduan operasional admin desa (SOP)', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Pelatihan tatap muka pengelolaan sistem bersama perangkat desa', 'status' => 'DONE', 'priority' => 'HIGH'],
                    ['title' => 'Pelaksanaan seremoni Berita Acara Serah Terima (Handover)', 'status' => 'DONE', 'priority' => 'HIGH'],
                ]
            ],
        ];

        foreach ($workPrograms as $prog) {
            $createdProgram = Program::create([
                'kkn_group_id' => $group->id,
                'village_id' => $village->id,
                'leader_id' => $groupLeader->id,
                'title' => $prog['title'],
                'slug' => Str::slug($prog['title']),
                'category' => $prog['category'],
                'description' => $prog['desc'],
                'objective' => $prog['objective'],
                'target_audience' => $prog['target'],
                'status' => $prog['status'],
                'start_date' => now()->subDays(40)->toDateString(),
                'end_date' => now()->subDays(5)->toDateString(),
            ]);

            foreach ($prog['tasks'] as $task) {
                ProgramTask::create([
                    'program_id' => $createdProgram->id,
                    'kkn_group_id' => $group->id,
                    'assignee_id' => $student->id,
                    'title' => $task['title'],
                    'description' => 'Tugas implementasi bagian dari program kerja: ' . $createdProgram->title,
                    'status' => $task['status'],
                    'priority' => $task['priority'],
                    'due_date' => now()->subDays(10)->toDateString(),
                ]);
            }
        }

        // 9. 5 Events
        $events = [
            [
                'title' => 'Sosialisasi & Launching Website Resmi Portal Desa Sukamaju',
                'desc' => 'Peresmian peluncuran website resmi desa dan portal UMKM bersama Kepala Desa, Dosen Pembimbing, dan tokoh masyarakat.',
                'date' => now()->addDays(3)->toDateString(),
                'location' => 'Aula Utama Balai Desa Sukamaju',
                'organizer' => 'Pemerintah Desa Sukamaju & Tim KKN 14',
            ],
            [
                'title' => 'Pelatihan Foto Produk & Pemasaran WhatsApp Business UMKM',
                'desc' => 'Praktik langsung pemotretan produk menggunakan smartphone dan trik closing penjualan online via WhatsApp Business.',
                'date' => now()->addDays(7)->toDateString(),
                'location' => 'Pendopo Sanggar Budaya Sukamaju',
                'organizer' => 'Divisi Ekonomi Kreatif KKN',
            ],
            [
                'title' => 'Aksi Bersih Curug & Penanaman 1.000 Pohon Penghijauan',
                'desc' => 'Gerakan gotong royong warga pembersihan aliran sungai dan penanaman bibit pohon buah di kawasan resapan air.',
                'date' => now()->addDays(12)->toDateString(),
                'location' => 'Kawasan Wisata Curug Sukamaju Indah',
                'organizer' => 'Karang Taruna & Divisi Lingkungan KKN',
            ],
            [
                'title' => 'Posyandu Terpadu & Konseling Pencegahan Stunting',
                'desc' => 'Pemeriksaan rutin tumbuh kembang bayi, imunisasi, dan pembagian paket susu formula serta bubur kacang hijau.',
                'date' => now()->subDays(8)->toDateString(),
                'location' => 'Puskesmas Pembantu Sukamaju',
                'organizer' => 'Kader Posyandu Dahlia & Divisi Kesehatan KKN',
            ],
            [
                'title' => 'Lokakarya Awal & Pemaparan Program Kerja KKN Mahasiswa',
                'desc' => 'Pemaparan 6 pilar program pengabdian mahasiswa kepada Badan Permusyawaratan Desa (BPD) dan ketua RT/RW.',
                'date' => now()->subDays(42)->toDateString(),
                'location' => 'Balai Desa Sukamaju',
                'organizer' => 'Tim KKN Kelompok 14',
            ],
        ];

        foreach ($events as $ev) {
            Event::create([
                'village_id' => $village->id,
                'kkn_group_id' => $group->id,
                'title' => $ev['title'],
                'slug' => Str::slug($ev['title']),
                'description' => $ev['desc'],
                'date' => $ev['date'],
                'location' => $ev['location'],
                'organizer' => $ev['organizer'],
                'status' => 'PUBLISHED',
            ]);
        }

        // 10. 10 Articles / Warta Desa
        $articles = [
            [
                'title' => 'Transformasi Digital Desa Sukamaju: Melangkah Menuju Smart Village Berkelanjutan',
                'cat' => 'VILLAGE',
                'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Kolaborasi sinergis antara perguruan tinggi dan pemerintah desa menghasilkan portal publik terpadu dan digitalisasi potensi lokal.',
                'content' => "Perkembangan teknologi informasi kini tidak lagi hanya menjadi milik wilayah perkotaan. Melalui kolaborasi antara Pemerintah Desa Sukamaju dan Tim Mahasiswa Kuliah Kerja Nyata (KKN) Universitas Indonesia Mandiri, Desa Sukamaju resmi mengadopsi platform KKN Digital Village OS.\n\nSistem ini dirancang untuk menjawab tantangan tata kelola informasi publik, pendataan UMKM, pemetaan destinasi wisata, serta transparansi kegiatan desa. Dengan adanya portal resmi ini, masyarakat desa dan publik luas kini dapat mengakses beragam layanan dan potensi desa secara mudah langsung dari gawai pintar mereka.\n\nKepala Desa Sukamaju, Bapak H. Suryana, S.Sos mengapresiasi tinggi inisiatif ini. 'Kehadiran adik-adik mahasiswa KKN membuktikan bahwa pengabdian akademik dapat meninggalkan warisan digital nyata yang terus hidup dan berdaya guna bagi desa kami,' ungkap beliau dalam sambutannya.",
            ],
            [
                'title' => 'Kopi Lereng Sukamaju Tembus Pasar Digital dan Raih Antusiasme Pecinta Kopi Ibu Kota',
                'cat' => 'UMKM',
                'image' => 'https://images.unsplash.com/photo-1447933601403-0c6688de566e?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Dengan kemasan modern dan etalase digital resmi desa, produk kopi arabika lokal Sukamaju mulai diminati kafe-kafe perkotaan.',
                'content' => "Petani kopi lereng Desa Sukamaju patut berbangga. Produk kopi specialty olahan kelompok tani kini memiliki katalog digital terverifikasi lengkap dengan tautan pesanan langsung via WhatsApp di portal resmi desa.\n\nSebelumnya, para petani hanya menjual ceri kopi basah ke tengkulak dengan harga rendah. Melalui pendampingan mahasiswa KKN divisi ekonomi, mereka dibekali teknik roasting standar kafe, pengemasan food-grade bersegel katup udara, dan pembuatan akun WhatsApp Business.\n\nHasilnya, pesanan dari berbagai kedai kopi independen di Bogor dan Jakarta mulai mengalir deras, mengangkat pendapatan petani kopi desa hingga 40%.",
            ],
            [
                'title' => 'Edukasi Gizi dan Dapur Sehat: Posyandu Dahlia Sukamaju Intensifkan Pencegahan Stunting',
                'cat' => 'VILLAGE',
                'image' => 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Inovasi menu makanan pendamping ASI (MP-ASI) berbasis kelor dan ikan nila lokal berhasil meningkatkan nafsu makan balita desa.',
                'content' => "Kesehatan ibu dan anak merupakan pilar utama pembangunan sumber daya manusia desa. Posyandu Dahlia Desa Sukamaju bersama mahasiswa KKN divisi kesehatan sukses menyelenggarakan lokakarya Dapur Sehat Atasi Stunting (DASHAT).\n\nKegiatan ini diikuti oleh lebih dari 50 ibu balita dan kader posyandu. Materi yang dibagikan mencakup cara mengolah daun kelor dan ikan air tawar lokal menjadi nugget dan puding bergizi tinggi yang disukai anak-anak.\n\nBidan Desa Sukamaju menegaskan bahwa pencegahan stunting paling efektif dimulai dari ketelatenan orang tua dalam memberikan asupan gizi seimbang serta menjaga sanitasi air bersih lingkungan rumah.",
            ],
            [
                'title' => 'Menikmati Kesegaran Alami Curug Sukamaju Indah di Ujung Akhir Pekan',
                'cat' => 'TOURISM',
                'image' => 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Rekomendasi destinasi wisata alam keluarga dengan air terjun jernih berhawa sejuk di tengah rindangnya pepohonan pinus.',
                'content' => "Bagi Anda yang penat dengan hiruk pikuk kesibukan kota, Curug Sukamaju Indah menawarkan ketenangan alami yang tiada tara. Terletak hanya 15 menit dari jalan utama Cisarua, wisata alam ini menyajikan gemericik air terjun setinggi 25 meter yang jatuh ke kolam batu alami.\n\nKawasan ini telah dilengkapi fasilitas terawat seperti saung istirahat bambu, kamar mandi bersih, serta warung jajanan warga yang menyajikan kopi hangat dan jagung bakar manis.\n\nKini rute menuju Curug Sukamaju telah terpetakan dengan akurat di Peta Digital Interaktif website desa, memudahkan para pelancong luar kota menemukan lokasinya tanpa khawatir tersesat.",
            ],
            [
                'title' => 'Gerakan Pilah Sampah dari Rumah: Bank Sampah Mandiri Sukamaju Resmi Beroperasi',
                'cat' => 'VILLAGE',
                'image' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Warga desa antusias menyetorkan sampah plastik dan kardus untuk ditukarkan menjadi saldo tabungan sembako.',
                'content' => "Mengatasi problem sampah pedesaan memerlukan pendekatan sirkular yang menguntungkan masyarakat. Pemerintah Desa Sukamaju bersama tim KKN resmi meresmikan operasional Bank Sampah Mandiri bertempat di Dusun 2.\n\nSistem tabungan sampah ini memungkinkan warga menukarkan sampah anorganik terpilah seperti botol PET, kardus, dan kaleng dengan buku tabungan digital. Saldo tabungan dapat dicairkan menjelang hari raya atau ditukar dengan kupon sembako.\n\nInovasi ini diharapkan mampu menekan kebiasaan membakar sampah plastik di pekarangan dan menumbuhkan kesadaran ekologis warga sejak dini.",
            ],
            [
                'title' => 'Mengenalkan Dunia Sains dan Internet Cerdas bagi Generasi Penerus Desa',
                'cat' => 'EDUCATION',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Murid-murid SDN 01 Sukamaju antusias mencoba eksperimen gunung berapi mini dan belajar cara memilah informasi positif di internet.',
                'content' => "Keceriaan terpancar dari wajah puluhan siswa kelas 4 hingga 6 SDN 01 Sukamaju saat tim mahasiswa KKN menggelar kelas eksperimen sains interaktif.\n\nSelain mempraktikkan reaksi kimia sederhana yang menyenangkan, anak-anak juga diajarkan etika berinternet, menjaga kerahasiaan data pribadi, serta cara memanfaatkan ponsel pintar untuk belajar ilmu pengetahuan bukan sekadar bermain game.\n\nKepala Sekolah SDN 01 Sukamaju menyampaikan rasa terima kasih atas kehadiran mahasiswa yang mampu menghadirkan metode belajar variatif dan memotivasi anak-anak desa untuk bermimpi kuliah di perguruan tinggi.",
            ],
            [
                'title' => 'Anyaman Bambu Tradisional Sukamaju: Dari Dapur Nenek Menjadi Suvenir Eksklusif',
                'cat' => 'UMKM',
                'image' => 'https://images.unsplash.com/photo-1590736969955-71cc94801759?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Sentuhan desain modern mengangkat derajat anyaman besek bambu lokal menjadi paket cinderamata hotel dan pernikahan.',
                'content' => "Kerajinan anyaman bambu merupakan keahlian turun temurun warga Dusun Anyaman Desa Sukamaju. Dahulu, anyaman hanya dibuat untuk keperluan wadah dapur sederhana seperti tampah dan besek ikan asin.\n\nMelalui program rebranding KKN, produk anyaman dikembangkan menjadi tas jinjing estetik, tempat tisu hotel, dan kemasan hantaran ramah lingkungan. Produk ini kini telah dipamerkan dalam katalog digital desa dan siap menerima pesanan partai besar dari seluruh Indonesia.",
            ],
            [
                'title' => 'Gotong Royong Perbaikan Saluran Irigasi Tersier Menyambut Musim Tanam',
                'cat' => 'VILLAGE',
                'image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Aparatur desa bersama kelompok tani bahu membahu membersihkan sedimentasi saluran air guna memastikan pasokan air sawah lancar.',
                'content' => "Tradisi gotong royong sambatan tetap terjaga erat di Desa Sukamaju. Menjelang musim tanam padi, puluhan petani bersama mahasiswa KKN turun ke saluran irigasi tersier sepanjang 1,5 kilometer untuk membersihkan endapan lumpur dan rumput liar.\n\nKelancaran pasokan air dari mata air pegunungan sangat menentukan keberhasilan panen padi sawah terasering seluas 60 hektar yang menjadi lumbung pangan utama warga.",
            ],
            [
                'title' => 'Wisata Akhir Pekan: Meriahnya Pasar Kuliner Tradisional Tepi Sawah',
                'cat' => 'TOURISM',
                'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Menikmati kudapan jadul seperti serabi kocor dan bajigur hangat sambil memandang pemandangan hijau sawah terasering.',
                'content' => "Pasar Wisata Kuliner Akhir Pekan Sukamaju menjadi magnet baru bagi warga lokal maupun wisatawan luar daerah. Buka setiap Sabtu dan Minggu pagi, puluhan lapak pedagang menyajikan hidangan tradisional yang menggugah selera dengan harga sangat terjangkau.\n\nMenariknya, para pedagang kini telah difasilitasi papan QRIS pembayaran nontunai sehingga pengunjung tidak perlu repot mencari uang kembalian receh.",
            ],
            [
                'title' => 'Serah Terima Digital Handover KKN Sukamaju: Warisan Aset Teknologi yang Terus Hidup',
                'cat' => 'KKN',
                'image' => 'https://images.unsplash.com/photo-1450133064473-71024230f91b?q=80&w=1000&auto=format&fit=crop',
                'excerpt' => 'Penandatanganan Berita Acara Serah Terima menandai peralihan pengelolaan sistem KKN Digital Village OS sepenuhnya ke Pemerintah Desa.',
                'content' => "Program KKN Tematik mahasiswa di Desa Sukamaju resmi ditutup dengan seremoni Digital Handover. Berbeda dengan program KKN konvensional yang kerap meninggalkan website mati setelah mahasiswa pulang, KKN Digital Village OS memastikan seluruh akun admin, data UMKM, dan modul panduan telah diserahkan dan dikuasai oleh aparatur desa.\n\nDengan kesiapan sistem mencapai 100%, Pemerintah Desa Sukamaju kini mandiri memutakhirkan warta desa, menerima pesanan UMKM warga, dan mempromosikan pariwisata berkelanjutan untuk generasi mendatang.",
            ],
        ];

        foreach ($articles as $art) {
            Article::create([
                'village_id' => $village->id,
                'kkn_group_id' => $group->id,
                'author_id' => $student->id,
                'title' => $art['title'],
                'slug' => Str::slug($art['title']),
                'category' => $art['cat'],
                'excerpt' => $art['excerpt'],
                'content' => $art['content'],
                'cover_image' => $art['image'],
                'status' => 'PUBLISHED',
                'published_at' => now()->subDays(rand(1, 25)),
            ]);
        }

        // 11. Photo Album & Media Items
        $album1 = Album::create([
            'village_id' => $village->id,
            'kkn_group_id' => $group->id,
            'album_name' => 'Dokumentasi Program Kerja KKN 14',
            'slug' => 'dokumentasi-program-kerja-kkn-14',
            'description' => 'Foto pelaksanaan program edukasi gizi, pelatihan UMKM, dan kerja bakti.',
        ]);

        $album2 = Album::create([
            'village_id' => $village->id,
            'kkn_group_id' => $group->id,
            'album_name' => 'Pesona Panorama & Potensi Wisata Alam',
            'slug' => 'pesona-panorama-potensi-wisata-alam',
            'description' => 'Koleksi dokumentasi keindahan alam Curug Sukamaju, perbukitan, dan kebun teh.',
        ]);

        $mediaList = [
            [
                'album_id' => $album1->id, 
                'caption' => 'Mahasiswa KKN memotret kemasan kopi di pendopo desa.',
                'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1000&auto=format&fit=crop'
            ],
            [
                'album_id' => $album1->id, 
                'caption' => 'Penimbangan dan konsultasi gizi bersama ibu-ibu warga Dusun 1.',
                'image' => 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?q=80&w=1000&auto=format&fit=crop'
            ],
            [
                'album_id' => $album1->id, 
                'caption' => 'Siswa SDN 01 Sukamaju antusias mencoba percobaan sains.',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?q=80&w=1000&auto=format&fit=crop'
            ],
            [
                'album_id' => $album2->id, 
                'caption' => 'Pesona air terjun alami dengan kolam air jernih.',
                'image' => 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?q=80&w=1000&auto=format&fit=crop'
            ],
            [
                'album_id' => $album2->id, 
                'caption' => 'Matahari terbit dengan panorama Gunung Salak dari puncak bukit.',
                'image' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1000&auto=format&fit=crop'
            ],
            [
                'album_id' => $album2->id, 
                'caption' => 'Hamparan hijau padi sawah terasering di bawah kabut pagi.',
                'image' => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=1000&auto=format&fit=crop'
            ],
        ];

        foreach ($mediaList as $m) {
            MediaItem::create([
                'album_id' => $m['album_id'],
                'kkn_group_id' => $group->id,
                'file_path' => $m['image'],
                'file_name' => 'foto_dokumentasi.jpg',
                'file_type' => 'IMAGE',
                'caption' => $m['caption'],
            ]);
        }

        // 12. Program Documents (Reports, SOP, Guidebooks)
        ProgramDocument::create([
            'kkn_group_id' => $group->id,
            'title' => 'Laporan Akhir Pelaksanaan KKN Tematik Desa Sukamaju',
            'file_path' => '/documents/laporan_akhir_kkn_sukamaju.pdf',
            'file_type' => 'PDF',
            'file_size' => 2048576,
            'visibility' => 'PUBLIC',
        ]);

        ProgramDocument::create([
            'kkn_group_id' => $group->id,
            'title' => 'Buku Panduan Operasional (SOP) Administrator Portal Desa',
            'file_path' => '/documents/buku_panduan_admin_desa.pdf',
            'file_type' => 'PDF',
            'file_size' => 1024576,
            'visibility' => 'PUBLIC',
        ]);

        // 13. Impact Metrics
        $impacts = [
            ['cat' => 'UMKM', 'name' => 'UMKM Terdata & Tervalidasi', 'target' => 10, 'achieved' => 10, 'unit' => 'Unit UMKM'],
            ['cat' => 'UMKM', 'name' => 'Produk UMKM Terkatalog Online', 'target' => 25, 'achieved' => 30, 'unit' => 'Produk'],
            ['cat' => 'TOURISM', 'name' => 'Destinasi Wisata Terpublikasi', 'target' => 5, 'achieved' => 5, 'unit' => 'Destinasi'],
            ['cat' => 'TOURISM', 'name' => 'Titik Lokasi Terpetakan di Peta Spasial', 'target' => 15, 'achieved' => 21, 'unit' => 'Titik Koordinat'],
            ['cat' => 'GENERAL', 'name' => 'Program Kerja KKN Tuntas 100%', 'target' => 6, 'achieved' => 6, 'unit' => 'Program Kerja'],
            ['cat' => 'GENERAL', 'name' => 'Warga Penerima Manfaat Langsung', 'target' => 1000, 'achieved' => 1420, 'unit' => 'Warga'],
        ];

        foreach ($impacts as $imp) {
            ImpactMetric::create([
                'kkn_group_id' => $group->id,
                'village_id' => $village->id,
                'category' => $imp['cat'],
                'metric_name' => $imp['name'],
                'baseline' => 0,
                'target' => $imp['target'],
                'achieved' => $imp['achieved'],
                'unit' => $imp['unit'],
                'description' => 'Tercapai optimal melalui sinergi mahasiswa dan aparatur desa.',
            ]);
        }

        // 14. Handover Package & Items (Signature Feature: 100% Ready)
        $package = HandoverPackage::create([
            'village_id' => $village->id,
            'kkn_group_id' => $group->id,
            'title' => 'Digital Village Handover Package Desa Sukamaju',
            'notes' => 'Seluruh aset digital, akun kredensial administrator, basis data produk warga, peta interaktif, dan pedoman operasional telah diserahkan penuh kepada Pemerintah Desa Sukamaju.',
            'readiness_score' => 100,
            'handover_date' => now()->subDays(2)->toDateString(),
            'village_admin_id' => $villageAdmin->id,
            'status' => 'DRAFT',
            'completed_at' => null,
        ]);

        $handoverItems = [
            ['cat' => 'WEBSITE', 'title' => 'Profil Desa & Struktur Pemerintahan', 'notes' => 'Visi misi, demografi kependudukan, dan riwayat sejarah desa telah diverifikasi.'],
            ['cat' => 'UMKM', 'title' => 'Katalog 10 UMKM & 30 Produk Lokal', 'notes' => 'Basis data pelaku usaha dan produk lokal terhubung langsung ke WhatsApp.'],
            ['cat' => 'TOURISM', 'title' => '5 Destinasi Wisata Terpublikasi', 'notes' => 'Informasi jam buka, fasilitas, harga tiket, dan rute navigasi wisata.'],
            ['cat' => 'WEBSITE', 'title' => 'Peta Digital Spasial 21 Titik Lokasi', 'notes' => 'Titik fasilitas umum dan UMKM telah terplot akurat di peta Leaflet.'],
            ['cat' => 'ADMIN_ACCESS', 'title' => 'Hak Akses Administrator Desa Mandiri', 'notes' => 'Akun login admin desa (village@example.com) aktif dan telah diuji coba.'],
            ['cat' => 'DOCUMENTATION', 'title' => 'Buku Panduan Operasional (SOP) & Video Manual', 'notes' => 'Panduan tertulis tata kelola update konten dan pemeliharaan website.'],
            ['cat' => 'IMPACT', 'title' => 'Laporan Akhir 6 Program Pengabdian KKN', 'notes' => 'Seluruh program kerja selesai 100% dan dinilai oleh Dosen Pembimbing.'],
        ];

        foreach ($handoverItems as $hItem) {
            HandoverItem::create([
                'handover_package_id' => $package->id,
                'category' => $hItem['cat'],
                'title' => $hItem['title'],
                'notes' => $hItem['notes'],
                'status' => 'COMPLETED',
            ]);
        }

        // 15. Seed 4 Additional Villages to Demonstrate Multi-Tenancy
        $extraVillages = [
            ['name' => 'Berkah Mandiri', 'slug' => 'berkah-mandiri', 'district' => 'Megamendung', 'regency' => 'Bogor', 'theme' => 'nature'],
            ['name' => 'Mekar Jaya', 'slug' => 'mekar-jaya', 'district' => 'Rancabungur', 'regency' => 'Bogor', 'theme' => 'modern'],
            ['name' => 'Ciburial', 'slug' => 'ciburial', 'district' => 'Cimenyan', 'regency' => 'Bandung', 'theme' => 'heritage'],
            ['name' => 'Sumber Harapan', 'slug' => 'sumber-harapan', 'district' => 'Ngablak', 'regency' => 'Magelang', 'theme' => 'nature'],
        ];

        foreach ($extraVillages as $eVillage) {
            $extra = Village::create([
                'campus_id' => $campus->id,
                'name' => $eVillage['name'],
                'slug' => $eVillage['slug'],
                'district' => $eVillage['district'],
                'regency' => $eVillage['regency'],
                'province' => 'Jawa Barat',
                'theme' => $eVillage['theme'],
                'is_active' => true,
            ]);

            VillageProfile::create([
                'village_id' => $extra->id,
                'vision' => 'Menjadikan Desa ' . $eVillage['name'] . ' desa percontohan agrowisata dan kemandirian pangan.',
                'mission' => "1. Mendorong pemberdayaan petani lokal.\n2. Mengembangkan sarana prasarana digital desa.",
                'history' => 'Desa ' . $eVillage['name'] . ' memiliki sejarah panjang kearifan agraris Nusantara.',
                'demographics_summary' => 'Penduduk agraris produktif dengan potensi pertanian dan perkebunan terpadu.',
                'economic_profile' => 'Pertanian hortikultura dan peternakan rakyat.',
                'status' => 'PUBLISHED',
            ]);

            // Add sample UMKM and Tourism for each
            $sampleUmkm = Umkm::create([
                'village_id' => $extra->id,
                'business_name' => 'Keripik Tempe Desa ' . $eVillage['name'],
                'slug' => 'keripik-tempe-' . $eVillage['slug'],
                'owner_name' => 'Pak Budi',
                'category' => 'FOOD',
                'description' => 'Keripik tempe gurih renyah khas Desa ' . $eVillage['name'],
                'phone' => '081298765432',
                'address' => 'Dusun 1 RT 02 RW 01',
                'latitude' => -6.7000,
                'longitude' => 106.9500,
                'status' => 'PUBLISHED',
            ]);

            UmkmProduct::create([
                'umkm_id' => $sampleUmkm->id,
                'name' => 'Keripik Tempe Renyah Gurih 200g',
                'slug' => 'keripik-tempe-200g-' . $eVillage['slug'],
                'description' => 'Keripik tempe kedelai lokal gurih tanpa bahan pengawet.',
                'price' => 15000,
                'is_available' => true,
            ]);

            TourismPlace::create([
                'village_id' => $extra->id,
                'name' => 'Taman Wisata Hijau ' . $eVillage['name'],
                'slug' => 'taman-wisata-hijau-' . $eVillage['slug'],
                'category' => 'NATURE',
                'description' => 'Taman rekreasi hijau keluarga dengan kolam pancing dan kebun bunga.',
                'ticket_price' => 10000,
                'opening_hours' => '08.00 - 17.00 WIB',
                'address' => 'Jl. Wisata Alam No. 5',
                'latitude' => -6.7020,
                'longitude' => 106.9520,
                'status' => 'PUBLISHED',
            ]);
        }
    }
}
