<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Website Resmi' }} — Desa {{ $village->name }}</title>
    <meta name="description" content="{{ $metaDescription ?? ('Website resmi dan portal digital Desa ' . $village->name . ', ' . $village->district . ', ' . $village->regency . ', ' . $village->province . '. Mengenal potensi UMKM, wisata, dan pembangunan desa.') }}">
    
    <!-- Open Graph SEO -->
    <meta property="og:title" content="{{ $title ?? 'Website Resmi' }} — Desa {{ $village->name }}">
    <meta property="og:description" content="{{ $metaDescription ?? ('Portal informasi publik Desa ' . $village->name) }}">
    <meta property="og:type" content="website">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Leaflet Map Assets -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>

    @php
        $theme = $village->theme ?? 'modern';
        $themeClasses = match($theme) {
            'nature' => [
                'nav_bg' => 'bg-emerald-900 text-white',
                'accent_btn' => 'bg-amber-600 hover:bg-amber-700 text-white',
                'badge' => 'bg-emerald-100 text-emerald-800',
                'footer_bg' => 'bg-stone-900 text-stone-300',
            ],
            'heritage' => [
                'nav_bg' => 'bg-amber-950 text-white',
                'accent_btn' => 'bg-amber-600 hover:bg-amber-700 text-white',
                'badge' => 'bg-amber-100 text-amber-900',
                'footer_bg' => 'bg-stone-950 text-stone-300',
            ],
            default => [
                'nav_bg' => 'bg-white/95 backdrop-blur-md text-slate-800 border-b border-slate-200',
                'accent_btn' => 'bg-emerald-600 hover:bg-emerald-700 text-white shadow-xs',
                'badge' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                'footer_bg' => 'bg-slate-900 text-slate-300',
            ]
        };
    @endphp
</head>
<body class="min-h-full flex flex-col bg-slate-50 text-slate-800" x-data="{ mobileMenuOpen: false }">

    <!-- Top Announcement / Handover Bar -->
    <div class="bg-gradient-to-r from-emerald-800 via-teal-800 to-emerald-900 text-white text-xs py-2 px-4 text-center font-medium flex items-center justify-between">
        <div class="max-w-7xl mx-auto flex items-center justify-center space-x-2">
            @if($village->isHandedOver())
                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-400/20 text-emerald-200 border border-emerald-400/30 text-[11px] font-semibold">
                    ✓ Terverifikasi Digital Handover
                </span>
                <span>Aset digital resmi dikelola Pemerintah Desa {{ $village->name }} bersama {{ $village->campus->name ?? 'Perguruan Tinggi' }}</span>
            @else
                <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-200 border border-amber-400/30 text-[11px] font-semibold">
                    Program KKN Aktif
                </span>
                <span>Portal digitalisasi kolaborasi Mahasiswa KKN & Pemerintah Desa {{ $village->name }}</span>
            @endif
        </div>
        <a href="{{ route('landing') }}" class="hidden md:inline-block text-[11px] text-emerald-200/80 hover:text-white underline">
            KKN Digital Village OS
        </a>
    </div>

    <!-- Public Village Navigation Bar -->
    <nav class="sticky top-0 z-40 transition shadow-xs {{ $themeClasses['nav_bg'] }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Village Identity Logo -->
                <a href="{{ route('public.village.home', $village->slug) }}" class="flex items-center space-x-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-emerald-700 flex items-center justify-center text-white font-black text-xl shadow-md group-hover:scale-105 transition">
                        {{ substr($village->name, 0, 1) }}
                    </div>
                    <div>
                        <span class="block text-xl font-extrabold tracking-tight {{ $theme === 'modern' ? 'text-slate-900' : 'text-white' }}">
                            Desa {{ $village->name }}
                        </span>
                        <span class="block text-xs font-semibold text-emerald-600 tracking-wide">
                            Kec. {{ $village->district }}, Kab. {{ $village->regency }}
                        </span>
                    </div>
                </a>

                <!-- Desktop Links -->
                <div class="hidden lg:flex items-center space-x-1 text-sm font-semibold">
                    <a href="{{ route('public.village.home', $village->slug) }}" class="px-3 py-2 rounded-lg transition {{ request()->routeIs('public.village.home') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100' }}">Beranda</a>
                    <a href="{{ route('public.village.about', $village->slug) }}" class="px-3 py-2 rounded-lg transition {{ request()->routeIs('public.village.about') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100' }}">Profil Desa</a>
                    <a href="{{ route('public.village.umkm', $village->slug) }}" class="px-3 py-2 rounded-lg transition {{ request()->routeIs('public.village.umkm*') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100' }}">UMKM</a>
                    <a href="{{ route('public.village.tourism', $village->slug) }}" class="px-3 py-2 rounded-lg transition {{ request()->routeIs('public.village.tourism') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100' }}">Wisata</a>
                    <a href="{{ route('public.village.map', $village->slug) }}" class="px-3 py-2 rounded-lg transition {{ request()->routeIs('public.village.map') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100' }}">Peta</a>
                    <a href="{{ route('public.village.events', $village->slug) }}" class="px-3 py-2 rounded-lg transition {{ request()->routeIs('public.village.events') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100' }}">Agenda</a>
                    <a href="{{ route('public.village.news', $village->slug) }}" class="px-3 py-2 rounded-lg transition {{ request()->routeIs('public.village.news*') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100' }}">Berita</a>
                    <a href="{{ route('public.village.gallery', $village->slug) }}" class="px-3 py-2 rounded-lg transition {{ request()->routeIs('public.village.gallery') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100' }}">Galeri</a>
                    <a href="{{ route('public.village.kkn', $village->slug) }}" class="px-3 py-2 rounded-lg transition {{ request()->routeIs('public.village.kkn') ? 'text-emerald-700 bg-emerald-50' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100' }}">KKN & Impact</a>
                </div>

                <!-- Right Action Buttons -->
                <div class="hidden sm:flex items-center space-x-3">
                    <a href="{{ route('public.village.contact', $village->slug) }}" class="px-4 py-2 rounded-xl text-sm font-semibold {{ $themeClasses['accent_btn'] }} transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Kontak Desa</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden">
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="lg:hidden border-b border-slate-200 bg-white px-4 pt-2 pb-6 space-y-1 shadow-lg"
             style="display: none;">
            <a href="{{ route('public.village.home', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-100">Beranda</a>
            <a href="{{ route('public.village.about', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-100">Profil Desa</a>
            <a href="{{ route('public.village.umkm', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-100">Direktori UMKM</a>
            <a href="{{ route('public.village.tourism', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-100">Potensi Wisata</a>
            <a href="{{ route('public.village.map', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-100">Peta Digital</a>
            <a href="{{ route('public.village.events', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-100">Agenda Kegiatan</a>
            <a href="{{ route('public.village.news', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-100">Berita Desa</a>
            <a href="{{ route('public.village.gallery', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-100">Galeri Foto</a>
            <a href="{{ route('public.village.kkn', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-100">Dokumentasi KKN</a>
            <a href="{{ route('public.village.impact', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-100">Impact Dashboard</a>
            <a href="{{ route('public.village.contact', $village->slug) }}" class="block px-3 py-2 rounded-lg text-base font-medium text-emerald-700 font-bold bg-emerald-50">Kontak & Lokasi Balai Desa</a>
        </div>
    </nav>

    <!-- Page Body -->
    <main class="flex-1">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Public Village Footer -->
    <footer class="{{ $themeClasses['footer_bg'] }} pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                
                <!-- Col 1: Village Identity -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white font-black text-lg">
                            {{ substr($village->name, 0, 1) }}
                        </div>
                        <div>
                            <span class="text-xl font-bold text-white block">Pemerintah Desa {{ $village->name }}</span>
                            <span class="text-xs text-emerald-400">Portal Informasi & Digitalisasi Resmi Desa</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 max-w-md leading-relaxed">
                        {{ $village->description ?? ('Website resmi Desa ' . $village->name . '. Dihadirkan sebagai sarana transparansi informasi, promosi UMKM lokal, direktori wisata, serta digital presence berkelanjutan.') }}
                    </p>
                    <div class="text-xs text-slate-500 pt-2 space-y-1">
                        <div>Alamat Balai Desa: {{ $village->district }}, {{ $village->regency }}, {{ $village->province }} {{ $village->postal_code }}</div>
                        <div>Kontak Resmi: {{ $village->contact ?? 'Tersedia di jam kerja kantor desa' }}</div>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li><a href="{{ route('public.village.about', $village->slug) }}" class="hover:text-emerald-400 transition">Profil & Sejarah</a></li>
                        <li><a href="{{ route('public.village.umkm', $village->slug) }}" class="hover:text-emerald-400 transition">Direktori UMKM Desa</a></li>
                        <li><a href="{{ route('public.village.tourism', $village->slug) }}" class="hover:text-emerald-400 transition">Destinasi Wisata</a></li>
                        <li><a href="{{ route('public.village.map', $village->slug) }}" class="hover:text-emerald-400 transition">Peta Interaktif Desa</a></li>
                        <li><a href="{{ route('public.village.news', $village->slug) }}" class="hover:text-emerald-400 transition">Kabar & Berita Desa</a></li>
                        <li><a href="{{ route('public.village.events', $village->slug) }}" class="hover:text-emerald-400 transition">Agenda & Kegiatan Warga</a></li>
                    </ul>
                </div>

                <!-- Col 3: Handover & Academic Continuity -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4">Aset & Kolaborasi KKN</h4>
                    <div class="p-4 rounded-xl bg-slate-800/60 border border-slate-700/60 space-y-3">
                        <div class="text-xs text-emerald-400 font-semibold">
                            {{ $village->campus->name ?? 'Kolaborasi Perguruan Tinggi' }}
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Website ini dibangun melalui program Kuliah Kerja Nyata (KKN) dan telah diwariskan secara penuh ke aparatur desa.
                        </p>
                        <a href="{{ route('public.village.handover', $village->slug) }}" class="inline-flex items-center text-xs font-bold text-emerald-400 hover:text-emerald-300">
                            <span>Lihat Sertifikat Handover</span>
                            <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Platform Credit -->
            <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Pemerintah Desa {{ $village->name }}. Hak Cipta Dilindungi.</p>
                <p class="mt-2 sm:mt-0 flex items-center space-x-1">
                    <span>Didukung oleh platform</span>
                    <a href="{{ route('landing') }}" class="font-bold text-emerald-400 hover:text-emerald-300">KKN Digital Village OS</a>
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
