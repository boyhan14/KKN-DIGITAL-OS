@extends('layouts.public', ['title' => 'Sertifikat Digital Handover Desa', 'metaDescription' => 'Berita acara dan sertifikat serah terima digitalisasi desa dari tim KKN kepada Pemerintah Desa ' . $village->name])

@section('content')
<div class="bg-slate-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <div class="flex items-center justify-between">
            <a href="{{ route('public.village.home', $village->slug) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-700 flex items-center">
                <span>← Kembali ke Portal Desa</span>
            </a>
            <button onclick="window.print()" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-xs font-bold transition flex items-center shadow-xs">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>

        <!-- Formal Certificate Frame -->
        <div class="bg-white rounded-3xl p-8 sm:p-14 border-8 border-emerald-900 shadow-xl relative overflow-hidden print:border-4 print:p-8">
            <!-- Decorative corner elements -->
            <div class="absolute top-0 left-0 w-16 h-16 border-t-8 border-l-8 border-amber-600"></div>
            <div class="absolute top-0 right-0 w-16 h-16 border-t-8 border-r-8 border-amber-600"></div>
            <div class="absolute bottom-0 left-0 w-16 h-16 border-b-8 border-l-8 border-amber-600"></div>
            <div class="absolute bottom-0 right-0 w-16 h-16 border-b-8 border-r-8 border-amber-600"></div>

            <div class="text-center space-y-4">
                <span class="inline-block px-4 py-1 rounded-full text-[11px] font-black uppercase tracking-widest bg-emerald-100 text-emerald-900">
                    BERITA ACARA & PIAGAM SERAH TERIMA
                </span>
                <h1 class="text-2xl sm:text-4xl font-black text-slate-900 tracking-tight">
                    DIGITAL VILLAGE HANDOVER
                </h1>
                <p class="text-xs uppercase font-bold tracking-widest text-slate-400">
                    NOMOR: BAST/KKN-OS/{{ date('Y') }}/{{ strtoupper(substr($village->slug, 0, 4)) }}-001
                </p>
            </div>

            <div class="mt-8 space-y-6 text-slate-700 text-sm leading-relaxed text-justify">
                <p>
                    Pada hari ini secara resmi telah diselesaikan dan diserahterimakan seluruh hasil program kerja digitalisasi, platform sistem informasi, basis data potensi desa, dan instrumen publikasi digital antara Tim Kuliah Kerja Nyata (KKN) <strong>{{ $village->campus->name ?? 'Perguruan Tinggi' }}</strong> kepada <strong>Pemerintah Desa {{ $village->name }}</strong>, Kecamatan {{ $village->district }}, Kabupaten {{ $village->regency }}, Provinsi {{ $village->province }}.
                </p>

                <!-- Handover Items Summary Box -->
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200 space-y-3">
                    <h3 class="font-extrabold text-slate-900 text-xs uppercase tracking-wider">Aset Digital yang Diserahterimakan:</h3>
                    <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-xs">
                        <li class="flex items-center text-emerald-800 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2 shrink-0"></span>
                            Portal Resmi Publik Desa (SEO & Mobile Ready)
                        </li>
                        <li class="flex items-center text-emerald-800 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2 shrink-0"></span>
                            Basis Data & Katalog Produk UMKM Warga Desa
                        </li>
                        <li class="flex items-center text-emerald-800 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2 shrink-0"></span>
                            Peta Spasial Digital Fasilitas & Destinasi Desa
                        </li>
                        <li class="flex items-center text-emerald-800 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2 shrink-0"></span>
                            Hak Akses Administrator Desa Mandiri
                        </li>
                        <li class="flex items-center text-emerald-800 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2 shrink-0"></span>
                            Panduan Operasional & Dokumentasi Sistem
                        </li>
                        <li class="flex items-center text-emerald-800 font-medium">
                            <span class="w-2 h-2 rounded-full bg-emerald-600 mr-2 shrink-0"></span>
                            Laporan Capaian Dampak Pengabdian KKN
                        </li>
                    </ul>
                </div>

                <p class="text-xs text-slate-600">
                    Dengan ditandatanganinya berita acara ini, pengelolaan operasional, pemutakhiran data informasi, dan pemanfaatan website resmi desa beralih sepenuhnya menjadi wewenang Pemerintah Desa didampingi tim perguruan tinggi secara berkelanjutan.
                </p>
            </div>

            <!-- Signatures Section -->
            <div class="mt-12 pt-8 border-t border-slate-200 grid grid-cols-2 sm:grid-cols-3 gap-6 text-center text-xs">
                <div class="space-y-12">
                    <span class="block text-slate-500 font-semibold">Pihak Pertama<br>(Ketua Kelompok KKN)</span>
                    <div>
                        <span class="block font-black text-slate-900 underline">{{ $village->activeGroup()->leader->name ?? 'Ketua Kelompok KKN' }}</span>
                        <span class="text-slate-400 text-[11px]">Mahasiswa KKN</span>
                    </div>
                </div>

                <div class="space-y-12">
                    <span class="block text-slate-500 font-semibold">Mengetahui<br>(Dosen Pembimbing Lapangan)</span>
                    <div>
                        <span class="block font-black text-slate-900 underline">{{ $village->activeGroup()->supervisor->name ?? 'DPL KKN' }}</span>
                        <span class="text-slate-400 text-[11px]">{{ $village->campus->name ?? 'Perguruan Tinggi' }}</span>
                    </div>
                </div>

                <div class="space-y-12 col-span-2 sm:col-span-1">
                    <span class="block text-slate-500 font-semibold">Pihak Kedua<br>(Kepala Desa / Pemerintah Desa)</span>
                    <div>
                        <span class="block font-black text-slate-900 underline">Kepala Desa {{ $village->name }}</span>
                        <span class="text-slate-400 text-[11px]">Pemerintah Desa</span>
                    </div>
                </div>
            </div>

            <!-- Verification Badge -->
            <div class="mt-12 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-400 gap-2">
                <span>Terverifikasi secara kriptografis oleh KKN Digital Village OS Platform</span>
                <span class="font-mono text-slate-500">HASH: {{ hash('sha256', $village->id . $village->slug . ($village->handed_over_at ?? 'uncompleted')) }}</span>
            </div>
        </div>

    </div>
</div>
@endsection

