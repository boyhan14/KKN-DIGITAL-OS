<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Handover — Desa {{ $village->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .print-border { border: 2px solid #000 !important; }
        }
    </style>
</head>
<body class="bg-slate-100 p-4 sm:p-12 text-slate-900">

    <!-- Action Bar -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('group.handover.index', $group->id) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-700">
            ← Kembali ke Workspace
        </a>
        <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Cetak Dokumen / Simpan PDF</span>
        </button>
    </div>

    <!-- Official Certificate Document Page -->
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-16 rounded-3xl shadow-lg border border-slate-200 print-border">
        
        <!-- Header Kop Surat -->
        <div class="border-b-4 border-double border-slate-900 pb-6 text-center">
            <div class="flex items-center justify-center space-x-4 mb-2">
                <div class="w-14 h-14 rounded-2xl bg-emerald-800 text-white font-black text-2xl flex items-center justify-center">
                    {{ substr($village->name, 0, 1) }}
                </div>
                <div class="text-left">
                    <h2 class="text-xs font-bold text-emerald-800 uppercase tracking-wider">{{ $village->campus->name ?? 'PERGURUAN TINGGI' }}</h2>
                    <h1 class="text-xl sm:text-2xl font-black text-slate-900 uppercase">PEMERINTAH DESA {{ strtoupper($village->name) }}</h1>
                    <p class="text-xs text-slate-600 font-medium">Kecamatan {{ $village->district }}, Kabupaten {{ $village->regency }}, Provinsi {{ $village->province }}</p>
                </div>
            </div>
            <div class="mt-4 pt-2 border-t border-slate-200 text-xs font-mono font-bold tracking-widest uppercase">
                BERITA ACARA SERAH TERIMA ASET DIGITAL DESA (DIGITAL HANDOVER)
            </div>
            <div class="text-[11px] text-slate-500 mt-0.5">
                Nomor: BA-KKN/{{ date('Y') }}/{{ $group->group_code }}/{{ $village->slug }}
            </div>
        </div>

        <!-- Body Content -->
        <div class="mt-8 space-y-4 text-xs leading-relaxed text-slate-800 text-justify">
            <p>
                Pada hari ini, <strong>{{ $package->handover_date ? $package->handover_date->translatedFormat('l, d F Y') : now()->translatedFormat('l, d F Y') }}</strong>, bertempat di Kantor Balai Desa {{ $village->name }}, telah dilaksanakan serah terima aset digital hasil pelaksanaan Kuliah Kerja Nyata (KKN) antara:
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200">
                <div>
                    <span class="font-bold text-slate-900 block mb-1">PIHAK PERTAMA (Yang Menyerahkan):</span>
                    <div>Nama: <strong>{{ $leader->name ?? ($group->leader->name ?? 'Ketua Kelompok') }}</strong></div>
                    <div>Peran: Ketua Kelompok KKN ({{ $group->group_name }})</div>
                    <div>Perguruan Tinggi: {{ $village->campus->name ?? '-' }}</div>
                </div>
                <div>
                    <span class="font-bold text-slate-900 block mb-1">PIHAK KEDUA (Yang Menerima):</span>
                    <div>Nama: <strong>{{ $villageAdmin->name ?? ($village->head_name ?? 'Perangkat Desa') }}</strong></div>
                    <div>Peran: Perangkat / Administrator Desa {{ $village->name }}</div>
                    <div>Instansi: Pemerintah Desa {{ $village->name }}</div>
                </div>
            </div>

            <p>
                PIHAK PERTAMA menyerahkan kepada PIHAK KEDUA, dan PIHAK KEDUA menerima dengan baik seluruh aset digital hasil pengabdian KKN dengan status <strong>Kesiapan Handover {{ $package->readiness_score }}%</strong>, yang mencakup komponen sebagai berikut:
            </p>

            <div class="p-4 rounded-xl border border-slate-200 space-y-2">
                <div class="font-bold text-slate-900">Rincian Paket Aset Digital yang Diserahkan:</div>
                <ul class="list-disc list-inside space-y-1 text-slate-700">
                    <li><strong>Portal Publik Desa Resmi:</strong> Website desa aktif dengan tautan publik <code class="font-bold text-emerald-800">{{ url('/desa/' . $village->slug) }}</code></li>
                    <li><strong>Direktori UMKM & Katalog Produk Digital:</strong> {{ $village->publishedUmkms->count() }} profil usaha lokal dengan integrasi kontak pemesanan langsung via WhatsApp.</li>
                    <li><strong>Direktori Destinasi Wisata Desa:</strong> {{ $village->publishedTourismPlaces->count() }} objek potensi alam & budaya beserta jam buka dan informasi tiket.</li>
                    <li><strong>Peta Digital Interaktif Desa:</strong> Titik koordinat balai desa, fasilitas pelayanan umum, UMKM, dan lokasi program kerja.</li>
                    <li><strong>Arsip Laporan & Dokumentasi Digital:</strong> Dokumen luaran program kerja, modul pelatihan masyarakat, dan galeri foto kegiatan.</li>
                    <li><strong>Hak Kelola Administrator (Village Admin):</strong> Akun operasional aktif untuk staf desa agar terus memperbarui berita, UMKM, dan agenda warga.</li>
                </ul>
            </div>

            <p>
                Dengan ditandatanganinya Berita Acara ini, kepemilikan dan pengelolaan operasional portal desa secara resmi beralih kepada Pemerintah Desa {{ $village->name }}. Hak akses tulis mahasiswa KKN dialihkan ke mode arsip (read-only) untuk menjamin kesinambungan digitalisasi desa secara mandiri.
            </p>
        </div>

        <!-- Signature Boxes (3 Signatories) -->
        <div class="mt-14 pt-8 border-t border-slate-200 grid grid-cols-3 gap-6 text-center text-xs">
            <div>
                <span class="text-slate-500 block mb-16">PIHAK PERTAMA,<br>Ketua Kelompok KKN</span>
                <span class="font-bold underline block text-slate-900">{{ $leader->name ?? ($group->leader->name ?? 'Mahasiswa KKN') }}</span>
                <span class="text-[10px] text-slate-500">NIM. {{ $leader->student_id ?? '-' }}</span>
            </div>

            <div>
                <span class="text-slate-500 block mb-16">MENGETAHUI,<br>Dosen Pembimbing Lapangan</span>
                <span class="font-bold underline block text-slate-900">{{ $supervisor->name ?? ($group->supervisor->name ?? 'Dosen Pembimbing') }}</span>
                <span class="text-[10px] text-slate-500">{{ $village->campus->name ?? 'DPL Kampus' }}</span>
            </div>

            <div>
                <span class="text-slate-500 block mb-16">PIHAK KEDUA,<br>Pemerintah Desa {{ $village->name }}</span>
                <span class="font-bold underline block text-slate-900">{{ $villageAdmin->name ?? ($village->head_name ?? 'Perangkat Desa') }}</span>
                <span class="text-[10px] text-slate-500">Pemerintah Desa {{ $village->name }}</span>
            </div>
        </div>

        <!-- Footer Seal -->
        <div class="mt-12 text-center text-[10px] text-slate-400 border-t border-slate-100 pt-4">
            Dokumen sah diterbitkan melalui platform KKN Digital Village OS &bull; Kode Verifikasi: {{ md5($package->id . $package->handover_date) }}
        </div>
    </div>

</body>
</html>

