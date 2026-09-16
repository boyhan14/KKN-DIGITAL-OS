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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
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
                'nav_bg' => 'bg-emerald-950/90 backdrop-blur-xl text-white border-b border-emerald-900/60',
                'accent_btn' => 'bg-amber-600 hover:bg-amber-700 text-white shadow-md shadow-amber-600/20',
                'badge' => 'bg-emerald-100 text-emerald-800',
                'footer_bg' => 'bg-stone-900 text-stone-300',
            ],
            'heritage' => [
                'nav_bg' => 'bg-amber-950/90 backdrop-blur-xl text-white border-b border-amber-900/60',
                'accent_btn' => 'bg-amber-600 hover:bg-amber-700 text-white shadow-md shadow-amber-600/20',
                'badge' => 'bg-amber-100 text-amber-900',
                'footer_bg' => 'bg-stone-950 text-stone-300',
            ],
            default => [
                'nav_bg' => 'bg-white/90 backdrop-blur-xl text-slate-800 border-b border-slate-200/80 shadow-xs',
                'accent_btn' => 'bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white shadow-md shadow-emerald-600/20',
                'badge' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
                'footer_bg' => 'bg-slate-900 text-slate-300',
            ]
        };
    @endphp
</head>
<body class="min-h-full flex flex-col bg-[#f8fafc] text-slate-800 antialiased" x-data="{ mobileMenuOpen: false }">

    <!-- Top Announcement / Handover Bar with Shimmer Effect -->
    <div class="relative-shimmer bg-gradient-to-r from-emerald-900 via-teal-900 to-emerald-950 text-white text-xs py-2 px-4 font-medium flex items-center justify-between border-b border-emerald-800/40">
        <div class="max-w-7xl mx-auto flex items-center justify-center space-x-2.5">
            @if($village->isHandedOver())
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full bg-emerald-400/20 text-emerald-200 border border-emerald-400/30 text-[11px] font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 radar-ping"></span>
                    <span>✓ Terverifikasi Digital Handover</span>
                </span>
                <span class="hidden sm:inline text-slate-200">Aset digital resmi dikelola Pemerintah Desa {{ $village->name }} bersama {{ $village->campus->name ?? 'Perguruan Tinggi' }}</span>
                <span class="sm:hidden text-slate-200">Portal Resmi Desa {{ $village->name }}</span>
            @else
                <span class="inline-flex items-center space-x-1 px-2.5 py-0.5 rounded-full bg-amber-400/20 text-amber-200 border border-amber-400/30 text-[11px] font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    <span>Program KKN Aktif</span>
                </span>
                <span class="hidden sm:inline text-slate-200">Portal digitalisasi kolaborasi Mahasiswa KKN & Pemerintah Desa {{ $village->name }}</span>
                <span class="sm:hidden text-slate-200">KKN Digital Desa {{ $village->name }}</span>
            @endif
        </div>
        <a href="{{ route('landing') }}" class="hidden md:inline-flex items-center space-x-1 text-[11px] text-emerald-300 hover:text-white transition font-medium">
            <span>KKN Digital Village OS</span>
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>

    <!-- Public Village Navigation Bar -->
    <nav class="sticky top-0 z-40 transition-all duration-200 {{ $themeClasses['nav_bg'] }}">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Village Identity Logo -->
                <a href="{{ route('public.village.home', $village->slug) }}" class="flex items-center space-x-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-black text-xl shadow-md shadow-emerald-600/20 group-hover:scale-105 transition-transform duration-200">
                        {{ substr($village->name, 0, 1) }}
                    </div>
                    <div>
                        <span class="block text-xl font-black tracking-tight {{ $theme === 'modern' ? 'text-slate-900' : 'text-white' }}">
                            Desa {{ $village->name }}
                        </span>
                        <span class="block text-xs font-semibold text-emerald-600 tracking-wide">
                            Kec. {{ $village->district }}, Kab. {{ $village->regency }}
                        </span>
                    </div>
                </a>

                <!-- Desktop Links with Active Indicators -->
                <div class="hidden lg:flex items-center space-x-1 text-sm font-bold">
                    <a href="{{ route('public.village.home', $village->slug) }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('public.village.home') ? 'text-emerald-700 bg-emerald-50/90 shadow-xs' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100/80' }}">Beranda</a>
                    <a href="{{ route('public.village.about', $village->slug) }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('public.village.about') ? 'text-emerald-700 bg-emerald-50/90 shadow-xs' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100/80' }}">Profil Desa</a>
                    <a href="{{ route('public.village.umkm', $village->slug) }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('public.village.umkm*') ? 'text-emerald-700 bg-emerald-50/90 shadow-xs' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100/80' }}">UMKM</a>
                    <a href="{{ route('public.village.tourism', $village->slug) }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('public.village.tourism') ? 'text-emerald-700 bg-emerald-50/90 shadow-xs' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100/80' }}">Wisata</a>
                    <a href="{{ route('public.village.map', $village->slug) }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('public.village.map') ? 'text-emerald-700 bg-emerald-50/90 shadow-xs' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100/80' }}">Peta</a>
                    <a href="{{ route('public.village.events', $village->slug) }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('public.village.events') ? 'text-emerald-700 bg-emerald-50/90 shadow-xs' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100/80' }}">Agenda</a>
                    <a href="{{ route('public.village.news', $village->slug) }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('public.village.news*') ? 'text-emerald-700 bg-emerald-50/90 shadow-xs' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100/80' }}">Berita</a>
                    <a href="{{ route('public.village.gallery', $village->slug) }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('public.village.gallery') ? 'text-emerald-700 bg-emerald-50/90 shadow-xs' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100/80' }}">Galeri</a>
                    <a href="{{ route('public.village.kkn', $village->slug) }}" class="px-3.5 py-2 rounded-xl transition {{ request()->routeIs('public.village.kkn') ? 'text-emerald-700 bg-emerald-50/90 shadow-xs' : 'text-slate-600 hover:text-emerald-700 hover:bg-slate-100/80' }}">KKN & Impact</a>
                </div>

                <!-- Right Action Buttons -->
                <div class="hidden sm:flex items-center space-x-3">
                    <a href="{{ route('public.village.contact', $village->slug) }}" class="btn-shimmer px-4 py-2.5 rounded-xl text-xs font-extrabold {{ $themeClasses['accent_btn'] }} transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <span>Kontak Desa</span>
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex items-center lg:hidden">
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="p-2.5 rounded-xl text-slate-700 hover:bg-slate-100 transition">
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
             class="lg:hidden border-b border-slate-200 bg-white/95 backdrop-blur-xl px-4 pt-2 pb-6 space-y-1 shadow-xl"
             style="display: none;">
            <a href="{{ route('public.village.home', $village->slug) }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Beranda</a>
            <a href="{{ route('public.village.about', $village->slug) }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Profil Desa</a>
            <a href="{{ route('public.village.umkm', $village->slug) }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Direktori UMKM</a>
            <a href="{{ route('public.village.tourism', $village->slug) }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Potensi Wisata</a>
            <a href="{{ route('public.village.map', $village->slug) }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Peta Digital</a>
            <a href="{{ route('public.village.events', $village->slug) }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Agenda Kegiatan</a>
            <a href="{{ route('public.village.news', $village->slug) }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Berita Desa</a>
            <a href="{{ route('public.village.gallery', $village->slug) }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Galeri Foto</a>
            <a href="{{ route('public.village.kkn', $village->slug) }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Dokumentasi KKN</a>
            <a href="{{ route('public.village.impact', $village->slug) }}" class="block px-3 py-2 rounded-xl text-sm font-semibold text-slate-700 hover:bg-slate-100">Impact Dashboard</a>
            <a href="{{ route('public.village.contact', $village->slug) }}" class="block px-3 py-2.5 rounded-xl text-sm font-bold text-emerald-700 bg-emerald-50">Kontak & Lokasi Balai Desa</a>
        </div>
    </nav>

    <!-- Page Body -->
    <main class="flex-1">
        @yield('content')
        {{ $slot ?? '' }}
    </main>

    <!-- Floating WhatsApp Village Assistance FAB (Delightful Micro-Interaction) -->
    <div class="fixed bottom-6 right-6 z-50 flex items-center group">
        <div class="hidden md:block mr-3 px-3 py-1.5 rounded-xl bg-slate-900/90 backdrop-blur-md text-white text-xs font-semibold shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
            Layanan Warga Desa {{ $village->name }}
        </div>
        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $village->contact ?? '6281234567890') }}?text={{ urlencode('Halo Pemerintah Desa ' . $village->name . ', saya ingin bertanya mengenai layanan dan informasi desa.') }}" 
           target="_blank" 
           rel="noopener noreferrer"
           aria-label="WhatsApp Bantuan Desa"
           class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-500 text-white flex items-center justify-center shadow-xl shadow-emerald-500/30 hover:scale-110 active:scale-95 transition-all duration-300 relative">
            <span class="absolute -inset-1 rounded-2xl bg-emerald-500/30 radar-ping pointer-events-none"></span>
            <!-- WhatsApp Vector Icon -->
            <svg class="w-7 h-7 relative z-10" fill="currentColor" viewBox="0 0 24 24">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
        </a>
    </div>

    <!-- Public Village Footer -->
    <footer class="{{ $themeClasses['footer_bg'] }} pt-16 pb-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-10">
                
                <!-- Col 1: Village Identity -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-black text-lg shadow-md shadow-emerald-500/20">
                            {{ substr($village->name, 0, 1) }}
                        </div>
                        <div>
                            <span class="text-xl font-extrabold text-white block">Pemerintah Desa {{ $village->name }}</span>
                            <span class="text-xs text-emerald-400 font-semibold">Portal Informasi & Digitalisasi Resmi Desa</span>
                        </div>
                    </div>
                    <p class="text-sm text-slate-400 max-w-md leading-relaxed font-normal">
                        {{ $village->description ?? ('Website resmi Desa ' . $village->name . '. Dihadirkan sebagai sarana transparansi informasi, promosi UMKM lokal, direktori wisata, serta digital presence berkelanjutan.') }}
                    </p>
                    <div class="text-xs text-slate-500 pt-2 space-y-1">
                        <div>📍 Balai Desa: {{ $village->district }}, {{ $village->regency }}, {{ $village->province }} {{ $village->postal_code }}</div>
                        <div>📞 Kontak Resmi: {{ $village->contact ?? 'Tersedia di jam kerja kantor desa' }}</div>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4 text-emerald-400">Navigasi Utama</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400 font-medium">
                        <li><a href="{{ route('public.village.about', $village->slug) }}" class="hover:text-emerald-400 transition">Profil & Sejarah</a></li>
                        <li><a href="{{ route('public.village.umkm', $village->slug) }}" class="hover:text-emerald-400 transition">Direktori UMKM Desa</a></li>
                        <li><a href="{{ route('public.village.tourism', $village->slug) }}" class="hover:text-emerald-400 transition">Destinasi Wisata</a></li>
                        <li><a href="{{ route('public.village.map', $village->slug) }}" class="hover:text-emerald-400 transition">Peta Interaktif GIS</a></li>
                        <li><a href="{{ route('public.village.news', $village->slug) }}" class="hover:text-emerald-400 transition">Kabar & Berita Desa</a></li>
                        <li><a href="{{ route('public.village.events', $village->slug) }}" class="hover:text-emerald-400 transition">Agenda & Kegiatan Warga</a></li>
                    </ul>
                </div>

                <!-- Col 3: Handover & Academic Continuity -->
                <div>
                    <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4 text-emerald-400">Aset & Kolaborasi KKN</h4>
                    <div class="p-4 rounded-2xl bg-slate-800/80 border border-slate-700/80 space-y-3">
                        <div class="text-xs text-emerald-400 font-bold flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 radar-ping"></span>
                            <span>{{ $village->campus->name ?? 'Kolaborasi Perguruan Tinggi' }}</span>
                        </div>
                        <p class="text-xs text-slate-300 leading-relaxed font-normal">
                            Website ini dibangun melalui program Kuliah Kerja Nyata (KKN) dan telah diwariskan secara penuh ke aparatur desa melalui Berita Acara resmi.
                        </p>
                        <a href="{{ route('public.village.handover', $village->slug) }}" class="inline-flex items-center text-xs font-bold text-emerald-400 hover:text-emerald-300 transition group">
                            <span>Lihat Sertifikat Handover</span>
                            <svg class="w-3.5 h-3.5 ml-1 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Copyright & Platform Credit -->
            <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} Pemerintah Desa {{ $village->name }}. Hak Cipta Dilindungi.</p>
                <p class="mt-2 sm:mt-0 flex items-center space-x-1">
                    <span>Didukung oleh platform</span>
                    <a href="{{ route('landing') }}" class="font-bold text-emerald-400 hover:text-emerald-300 transition">KKN Digital Village OS</a>
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
