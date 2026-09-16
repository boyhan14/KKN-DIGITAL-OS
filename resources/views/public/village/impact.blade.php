@extends('layouts.public', ['title' => 'Laporan Dampak & Capaian KKN', 'metaDescription' => 'Statistik dan indikator capaian pengabdian mahasiswa KKN terhadap pembangunan Desa ' . $village->name])

@section('content')
<!-- Header -->
<div class="relative bg-emerald-950 text-white py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-900 text-emerald-300 border border-emerald-800 mb-4">
            Pengukuran Dampak Terbuka
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4">
            Dampak & Transformasi Digital Desa {{ $village->name }}
        </h1>
        <p class="text-lg text-emerald-200 max-w-2xl mx-auto font-light leading-relaxed">
            Transparansi angka, capaian program, dan dampak langsung terhadap perekonomian dan kesejahteraan warga desa.
        </p>
    </div>
</div>

<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Big Metric Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs text-center space-y-2">
                <span class="text-4xl sm:text-5xl font-black text-emerald-700 tracking-tight">{{ $impact['umkm_count'] ?? 0 }}</span>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-500">UMKM Terdata & Digital</span>
                <span class="text-[11px] text-emerald-600 font-medium block">+ {{ $impact['products_count'] ?? 0 }} Katalog Produk</span>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs text-center space-y-2">
                <span class="text-4xl sm:text-5xl font-black text-teal-700 tracking-tight">{{ $impact['tourism_count'] ?? 0 }}</span>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-500">Destinasi Wisata Terpublikasi</span>
                <span class="text-[11px] text-teal-600 font-medium block">Terdokumentasi & Terverifikasi</span>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs text-center space-y-2">
                <span class="text-4xl sm:text-5xl font-black text-amber-600 tracking-tight">{{ $impact['programs_count'] ?? 0 }}</span>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-500">Program Kerja KKN</span>
                <span class="text-[11px] text-amber-600 font-medium block">6 Sektor Pembangunan</span>
            </div>

            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs text-center space-y-2">
                <span class="text-4xl sm:text-5xl font-black text-blue-700 tracking-tight">{{ number_format($impact['beneficiaries_count'] ?? 0) }}</span>
                <span class="block text-xs font-bold uppercase tracking-wider text-slate-500">Penerima Manfaat</span>
                <span class="text-[11px] text-blue-600 font-medium block">Warga & Pelaku Usaha Desa</span>
            </div>
        </div>

        <!-- SDG Alignment Banner -->
        <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-xs space-y-6">
            <h3 class="text-xl font-black text-slate-900">Penyelarasan dengan Tujuan Pembangunan Berkelanjutan (SDGs Desa)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200/80">
                    <span class="text-xs font-bold text-amber-800 uppercase tracking-wider block mb-1">SDG 8</span>
                    <h4 class="font-black text-slate-900 text-sm mb-1">Pekerjaan Layak & Pertumbuhan Ekonomi</h4>
                    <p class="text-xs text-slate-600">Digitalisasi pemasaran UMKM desa untuk perluasan pasar dan peningkatan omset warga lokal.</p>
                </div>
                <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80">
                    <span class="text-xs font-bold text-emerald-800 uppercase tracking-wider block mb-1">SDG 9</span>
                    <h4 class="font-black text-slate-900 text-sm mb-1">Industri, Inovasi & Infrastruktur</h4>
                    <p class="text-xs text-slate-600">Pembangunan portal desa terpadu, pemetaan GIS spasial sarana prasarana, serta arsip digital.</p>
                </div>
                <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200/80">
                    <span class="text-xs font-bold text-blue-800 uppercase tracking-wider block mb-1">SDG 11</span>
                    <h4 class="font-black text-slate-900 text-sm mb-1">Desa Ramah Lingkungan & Berkelanjutan</h4>
                    <p class="text-xs text-slate-600">Pelestarian destinasi alam dan budaya desa yang bertanggung jawab melalui promosi pariwisata berkelanjutan.</p>
                </div>
            </div>
        </div>

        <!-- Call to Action Handover -->
        <div class="bg-gradient-to-r from-emerald-800 to-teal-800 rounded-3xl p-8 sm:p-10 text-white flex flex-col sm:flex-row items-center justify-between gap-6 shadow-md">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-200 block mb-1">Keberlanjutan Sistem</span>
                <h3 class="text-2xl font-black">Digital Handover: Dari Program Menjadi Aset Desa</h3>
                <p class="text-sm text-emerald-100 mt-2 max-w-xl">
                    Seluruh basis data, website resmi, katalog produk, dan dokumentasi program diserahterimakan secara resmi kepada Pemerintah Desa {{ $village->name }} agar terus dikelola secara mandiri.
                </p>
            </div>
            <a href="{{ route('public.village.handover', $village->slug) }}" class="shrink-0 px-6 py-3.5 bg-white text-emerald-900 hover:bg-emerald-50 rounded-2xl font-black text-sm shadow-md transition">
                Lihat Serah Terima →
            </a>
        </div>

    </div>
</div>
@endsection

