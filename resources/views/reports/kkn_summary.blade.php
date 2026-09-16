<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Akhir KKN — {{ $group->group_name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .page-break { page-break-after: always; }
        }
    </style>
</head>
<body class="bg-slate-100 p-4 sm:p-12 text-slate-900 leading-relaxed text-xs">

    <!-- Action Bar -->
    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('group.reports.index', $group->id) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-700">
            ← Kembali ke Menu Laporan
        </a>
        <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md transition flex items-center space-x-1.5">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>Cetak Dokumen Laporan (PDF)</span>
        </button>
    </div>

    <!-- Main Report Sheet -->
    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-16 rounded-3xl shadow-lg border border-slate-200 print-border space-y-10">
        
        <!-- Cover Header -->
        <div class="text-center border-b-2 border-slate-900 pb-8">
            <h2 class="text-xs font-bold uppercase tracking-widest text-emerald-800">{{ $village->campus->name ?? 'PERGURUAN TINGGI' }}</h2>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 uppercase mt-2">LAPORAN AKHIR KULIAH KERJA NYATA (KKN)</h1>
            <h3 class="text-sm font-bold text-slate-700 uppercase mt-1">PROGRAM PEMBERDAYAAN & DIGITALISASI DESA {{ strtoupper($village->name) }}</h3>
            
            <div class="mt-6 inline-block p-4 rounded-2xl bg-slate-50 border border-slate-200 text-left text-[11px] space-y-1">
                <div>Kelompok: <strong>{{ $group->group_name }} ({{ $group->group_code }})</strong></div>
                <div>Lokasi: Desa {{ $village->name }}, Kec. {{ $village->district }}, Kab. {{ $village->regency }}</div>
                <div>Dosen Pembimbing Lapangan: <strong>{{ $group->supervisor->name ?? '-' }}</strong></div>
                <div>Ketua Kelompok: <strong>{{ $group->leader->name ?? '-' }}</strong></div>
                <div>Tahun Pelaksanaan: {{ date('Y') }}</div>
            </div>
        </div>

        <!-- BAB 1: PENDAHULUAN -->
        <section class="space-y-2">
            <h2 class="text-sm font-black text-slate-900 uppercase border-b border-slate-200 pb-1">BAB 1. PENDAHULUAN</h2>
            <p class="text-justify text-slate-700">
                Program Kuliah Kerja Nyata (KKN) merupakan wujud nyata pengabdian kepada masyarakat yang diselenggarakan oleh perguruan tinggi. Pada periode ini, tim KKN mengusung konsep <em>Digital Village Workspace</em> di Desa {{ $village->name }}, yang tidak hanya menjalankan observasi lapangan semata, melainkan mengkonversikan setiap data UMKM, potensi wisata, dan kegiatan desa menjadi aset digital terstruktur yang siap diteruskan pengelolaannya oleh masyarakat desa setempat.
            </p>
        </section>

        <!-- BAB 2: KONDISI DESA -->
        <section class="space-y-2">
            <h2 class="text-sm font-black text-slate-900 uppercase border-b border-slate-200 pb-1">BAB 2. KONDISI & PROFIL DESA</h2>
            <p class="text-justify text-slate-700">
                Desa {{ $village->name }} terletak di Kecamatan {{ $village->district }}, Kabupaten {{ $village->regency }}, Provinsi {{ $village->province }}.
            </p>
            @if($village->profile)
                <div class="space-y-2 mt-2">
                    <div>
                        <strong class="text-slate-900">Visi Desa:</strong>
                        <p class="text-slate-700 italic">"{{ $village->profile->vision ?? '-' }}"</p>
                    </div>
                    <div>
                        <strong class="text-slate-900">Sejarah Singkat:</strong>
                        <p class="text-slate-700 text-justify">{{ $village->profile->history ?? '-' }}</p>
                    </div>
                    <div>
                        <strong class="text-slate-900">Potensi Ekonomi & Wilayah:</strong>
                        <p class="text-slate-700 text-justify">{{ $village->profile->economic_profile ?? '-' }}</p>
                    </div>
                </div>
            @endif
        </section>

        <!-- BAB 3: PROGRAM KERJA -->
        <section class="space-y-3">
            <h2 class="text-sm font-black text-slate-900 uppercase border-b border-slate-200 pb-1">BAB 3. PROGRAM KERJA KKN</h2>
            <table class="w-full text-left border border-slate-200">
                <thead class="bg-slate-50 text-[11px] font-bold border-b border-slate-200">
                    <tr>
                        <th class="p-2">No</th>
                        <th class="p-2">Nama Program Kerja</th>
                        <th class="p-2">Kategori</th>
                        <th class="p-2">Sasaran & Target</th>
                        <th class="p-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[11px]">
                    @foreach($group->programs as $idx => $p)
                        <tr>
                            <td class="p-2 font-bold">{{ $idx + 1 }}</td>
                            <td class="p-2 font-bold text-slate-900">{{ $p->title }}</td>
                            <td class="p-2">{{ $p->category }}</td>
                            <td class="p-2">{{ $p->objective ?? '-' }}</td>
                            <td class="p-2 font-semibold text-emerald-700">{{ $p->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>

        <!-- BAB 4: PELAKSANAAN & AKTIVITAS -->
        <section class="space-y-2">
            <h2 class="text-sm font-black text-slate-900 uppercase border-b border-slate-200 pb-1">BAB 4. PELAKSANAAN KEGIATAN</h2>
            <p class="text-justify text-slate-700">
                Seluruh program kerja dilaksanakan secara terkoordinasi dengan memanfaatkan papan Kanban operasional. Dari total tugas yang direncanakan, seluruh anggota aktif membagi peran dalam pendataan pelaku UMKM, inventarisasi potensi pariwisata desa, pendampingan warga, serta pelatihan pemanfaatan portal website desa.
            </p>
        </section>

        <!-- BAB 5: OUTPUT & LUARAN DIGITAL -->
        <section class="space-y-2">
            <h2 class="text-sm font-black text-slate-900 uppercase border-b border-slate-200 pb-1">BAB 5. OUTPUT & LUARAN DIGITAL</h2>
            <div class="grid grid-cols-2 gap-4 p-4 rounded-xl bg-slate-50 border border-slate-200 text-slate-800">
                <div>
                    <div>• Website Resmi Desa: <strong>{{ url('/desa/' . $village->slug) }}</strong></div>
                    <div>• Direktori UMKM Digital: <strong>{{ $village->publishedUmkms->count() }} Usaha Terdaftar</strong></div>
                    <div>• Katalog Produk: <strong>{{ $impact['products_listed'] }} Produk Aktif</strong></div>
                </div>
                <div>
                    <div>• Destinasi Wisata: <strong>{{ $village->publishedTourismPlaces->count() }} Objek Terdata</strong></div>
                    <div>• Titik Peta Digital: <strong>{{ $village->mapLocations->count() }} Fasilitas & Spot</strong></div>
                    <div>• Status Serah Terima: <strong>{{ $village->isHandedOver() ? 'Digital Handover Selesai' : 'Siap Handover' }}</strong></div>
                </div>
            </div>
        </section>

        <!-- BAB 6: IMPACT -->
        <section class="space-y-2">
            <h2 class="text-sm font-black text-slate-900 uppercase border-b border-slate-200 pb-1">BAB 6. DAMPAK (IMPACT) & PENERIMA MANFAAT</h2>
            <p class="text-justify text-slate-700">
                Berdasarkan metrik indikator kinerja terukur, program KKN di Desa {{ $village->name }} telah menjangkau kurang lebih <strong>{{ $impact['beneficiaries'] }} warga penerima manfaat</strong>, meningkatkan visibilitas produk UMKM desa secara daring, dan memberikan kemudahan akses informasi publik bagi masyarakat.
            </p>
        </section>

        <!-- BAB 7: DOKUMENTASI -->
        <section class="space-y-3">
            <h2 class="text-sm font-black text-slate-900 uppercase border-b border-slate-200 pb-1">BAB 7. ARSIP DOKUMENTASI KEGIATAN</h2>
            <p class="text-slate-700">
                Dokumentasi kegiatan tersimpan secara digital dalam repositori sistem KKN Digital Village OS dan dapat diakses publik melalui galeri portal desa.
            </p>
        </section>

        <!-- BAB 8: KESIMPULAN & PENUTUP -->
        <section class="space-y-2">
            <h2 class="text-sm font-black text-slate-900 uppercase border-b border-slate-200 pb-1">BAB 8. KESIMPULAN & REKOMENDASI</h2>
            <p class="text-justify text-slate-700">
                Pelaksanaan KKN di Desa {{ $village->name }} telah berhasil mentransformasi kegiatan pengabdian mahasiswa menjadi aset digital yang berkesinambungan. Direkomendasikan kepada aparatur desa untuk secara rutin memperbarui agenda kegiatan dan direktori UMKM melalui akun Village Admin yang telah diserahkan.
            </p>
        </section>

        <!-- Signature Page -->
        <div class="mt-12 pt-8 border-t border-slate-300 grid grid-cols-2 gap-8 text-center">
            <div>
                <span class="text-slate-500 block mb-16">Disusun oleh,<br>Ketua Kelompok KKN</span>
                <span class="font-bold underline block text-slate-900">{{ $group->leader->name ?? 'Mahasiswa KKN' }}</span>
                <span class="text-[10px] text-slate-500">NIM. {{ $group->leader->student_id ?? '-' }}</span>
            </div>
            <div>
                <span class="text-slate-500 block mb-16">Disetujui oleh,<br>Dosen Pembimbing Lapangan</span>
                <span class="font-bold underline block text-slate-900">{{ $group->supervisor->name ?? 'DPL KKN' }}</span>
                <span class="text-[10px] text-slate-500">{{ $village->campus->name ?? 'Perguruan Tinggi' }}</span>
            </div>
        </div>

    </div>

</body>
</html>

