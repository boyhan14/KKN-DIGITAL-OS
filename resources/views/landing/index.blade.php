<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KKN Digital Village OS — Dari Program KKN, Menjadi Digitalisasi Desa</title>
    <meta name="description" content="Platform multi-tenant premium yang mengubah program KKN mahasiswa menjadi ekosistem digital desa terstruktur: website publik resmi, katalog UMKM WhatsApp, peta interaktif GIS, dan sertifikasi digital handover berkelanjutan.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased selection:bg-emerald-600 selection:text-white" 
      x-data="{ mobileNav: false, activeTab: 'portal', faqOpen: null }">

    <!-- Ambient Glowing Gradient Orbs (Background Glow) -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-40 left-1/2 -translate-x-1/2 w-[900px] h-[500px] bg-gradient-to-tr from-emerald-200/40 via-teal-100/30 to-emerald-300/20 rounded-full animate-pulse-glow"></div>
        <div class="absolute top-[800px] -left-40 w-[600px] h-[500px] bg-gradient-to-r from-teal-200/30 to-emerald-100/20 rounded-full blur-3xl"></div>
        <div class="absolute top-[1600px] -right-40 w-[600px] h-[500px] bg-gradient-to-l from-emerald-200/30 to-teal-100/20 rounded-full blur-3xl"></div>
    </div>

    <!-- Announcement Bar -->
    <div class="relative z-50 bg-gradient-to-r from-emerald-800 via-teal-700 to-emerald-900 text-white text-xs font-semibold py-2.5 px-4 text-center shadow-xs">
        <div class="max-w-7xl mx-auto flex items-center justify-center space-x-2">
            <span class="px-2 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-black uppercase tracking-wider">Inovasi KKN 2025</span>
            <span class="truncate">Transformasi program KKN konvensional menjadi aset digital desa mandiri dan berdaya guna berkelanjutan.</span>
            <a href="#masalah" class="hidden sm:inline-flex items-center underline hover:text-emerald-200 font-bold ml-2">
                Pelajari Selengkapnya &rarr;
            </a>
        </div>
    </div>

    <!-- Floating Glassmorphic Navbar -->
    <nav class="sticky top-0 z-50 bg-white/85 backdrop-blur-xl border-b border-slate-200/80 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.03)]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo -->
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-black shadow-md shadow-emerald-600/25 group-hover:scale-105 transition duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <span class="font-black text-xl text-slate-900 tracking-tight block leading-none">Digital Village OS</span>
                        <span class="text-[11px] font-bold text-emerald-700 tracking-wide uppercase">KKN to Smart Village</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center space-x-8 text-sm font-bold text-slate-600">
                    <a href="#fitur" class="hover:text-emerald-700 transition">6 Pilar Solusi</a>
                    <a href="#demo-live" class="hover:text-emerald-700 transition">Live Preview</a>
                    <a href="#masalah" class="hover:text-emerald-700 transition">Mengapa Berbeda?</a>
                    <a href="#desa-binaan" class="hover:text-emerald-700 transition">Desa Binaan</a>
                    <a href="#faq" class="hover:text-emerald-700 transition">FAQ</a>
                    <a href="{{ route('public.village.home', 'sukamaju') }}" class="px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-300/80 hover:bg-emerald-100 hover:border-emerald-400 transition font-extrabold text-xs shadow-2xs flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                        <span>Demo Sukamaju</span>
                    </a>
                </div>

                <!-- Right Actions -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-600/25 transition hover:scale-102 flex items-center space-x-1.5">
                            <span>Buka Workspace</span>
                            <span>&rarr;</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-slate-700 hover:text-emerald-700 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-600/25 transition hover:scale-102">
                            Mulai KKN Sekarang
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger Button -->
                <div class="md:hidden">
                    <button @click="mobileNav = !mobileNav" class="p-2 text-slate-700 hover:text-slate-900 rounded-lg hover:bg-slate-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Nav Drawer -->
        <div x-show="mobileNav" class="md:hidden border-b border-slate-200 bg-white/95 backdrop-blur-xl px-4 py-4 space-y-2 text-sm font-bold shadow-xl" style="display: none;">
            <a href="#fitur" @click="mobileNav = false" class="block py-2 text-slate-700">6 Pilar Solusi</a>
            <a href="#demo-live" @click="mobileNav = false" class="block py-2 text-slate-700">Live Preview</a>
            <a href="#masalah" @click="mobileNav = false" class="block py-2 text-slate-700">Mengapa Berbeda?</a>
            <a href="#desa-binaan" @click="mobileNav = false" class="block py-2 text-slate-700">Desa Binaan</a>
            <a href="#faq" @click="mobileNav = false" class="block py-2 text-slate-700">FAQ</a>
            <a href="{{ route('public.village.home', 'sukamaju') }}" class="block py-2 text-emerald-700 font-black">🌟 Jelajahi Demo Desa Sukamaju</a>
            <div class="pt-3 border-t border-slate-100 flex flex-col space-y-2">
                <a href="{{ route('login') }}" class="text-center py-2 text-slate-700 font-bold">Masuk</a>
                <a href="{{ route('register') }}" class="text-center py-2.5 bg-emerald-600 text-white font-bold rounded-xl shadow-xs">Mulai KKN</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative overflow-hidden pt-12 pb-24 lg:pt-20 lg:pb-36 z-10">
        
        <!-- Subtle Pattern Backdrop -->
        <div class="absolute inset-0 bg-[radial-gradient(#0596690f_1px,transparent_1px)] [background-size:24px_24px] pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center">
            
            <!-- Top Hero Badge -->
            <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-emerald-50 text-emerald-900 text-xs font-black border border-emerald-200/80 mb-8 shadow-xs hover:border-emerald-400 transition cursor-default">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-ping"></span>
                <span>KKN Management + Digital Village Workspace + Public Portal</span>
            </div>

            <!-- Main Impact Heading -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight leading-[1.12] max-w-5xl mx-auto text-slate-900">
                Dari Program KKN, Menjadi <br class="hidden sm:inline">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-800">
                    Digitalisasi Desa yang Hidup.
                </span>
            </h1>

            <!-- Subtitle -->
            <p class="mt-6 text-base sm:text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed font-normal">
                Platform GovTech yang mengubah seluruh aktivitas observasi, pendataan UMKM, pemetaan potensi spasial, dan laporan KKN mahasiswa menjadi <strong>aset sistem desa terintegrasi</strong> yang tetap aktif dan diwariskan seutuhnya kepada aparatur desa.
            </p>

            <!-- Dual Action Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('public.village.home', 'sukamaju') }}" 
                   class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-base shadow-xl shadow-emerald-600/25 hover:scale-102 transition duration-300 flex items-center justify-center space-x-2.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Eksplorasi Demo Sukamaju</span>
                </a>

                <a href="#demo-live" 
                   class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-base border border-slate-300/90 shadow-sm flex items-center justify-center space-x-2 transition duration-300 hover:scale-102">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Lihat Simulasi Sistem Live</span>
                </a>
            </div>

            <!-- Trust Bar / Key Statistics -->
            <div class="mt-16 pt-10 border-t border-slate-200/80 max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 text-center">
                <div class="p-6 rounded-3xl bg-white/80 border border-slate-200 shadow-xs backdrop-blur-sm hover:border-emerald-500/50 hover:shadow-md transition">
                    <div class="text-3xl sm:text-4xl font-black text-slate-900">{{ $stats['total_villages'] > 0 ? $stats['total_villages'] : '5' }}</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Desa Terhubung</div>
                </div>
                <div class="p-6 rounded-3xl bg-white/80 border border-slate-200 shadow-xs backdrop-blur-sm hover:border-emerald-500/50 hover:shadow-md transition">
                    <div class="text-3xl sm:text-4xl font-black text-emerald-700">{{ $stats['total_umkm'] > 0 ? $stats['total_umkm'] : '10' }}+</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Katalog UMKM Aktif</div>
                </div>
                <div class="p-6 rounded-3xl bg-white/80 border border-slate-200 shadow-xs backdrop-blur-sm hover:border-emerald-500/50 hover:shadow-md transition">
                    <div class="text-3xl sm:text-4xl font-black text-slate-900">{{ $stats['total_programs'] > 0 ? $stats['total_programs'] : '6' }}</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Program Tuntas</div>
                </div>
                <div class="p-6 rounded-3xl bg-white/80 border border-slate-200 shadow-xs backdrop-blur-sm hover:border-emerald-500/50 hover:shadow-md transition">
                    <div class="text-3xl sm:text-4xl font-black text-teal-700">100%</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Garansi Handover</div>
                </div>
            </div>

            <!-- Eye-Pleasing 3D Floating Hero Showcase Composite -->
            <div class="mt-20 relative max-w-6xl mx-auto">
                
                <!-- Floating Bubble 1: WhatsApp Checkout (Top Left) -->
                <div class="hidden lg:flex absolute -top-8 -left-6 z-30 animate-float p-4 rounded-2xl glass-card text-left max-w-xs shadow-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold text-lg shrink-0 shadow-md shadow-emerald-500/20">
                            💬
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">Pesanan WhatsApp Masuk</span>
                            <h5 class="text-xs font-extrabold text-slate-900 leading-tight">2x Kopi Arabika Sukamaju</h5>
                            <span class="text-[11px] font-mono text-slate-500">Rp 150.000 • Langsung ke Pemilik</span>
                        </div>
                    </div>
                </div>

                <!-- Floating Bubble 2: Map Spasial GIS (Top Right) -->
                <div class="hidden lg:flex absolute -top-6 -right-6 z-30 animate-float-delayed p-4 rounded-2xl glass-card text-left max-w-xs shadow-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-teal-500 text-white flex items-center justify-center font-bold text-lg shrink-0 shadow-md shadow-teal-500/20">
                            📍
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-teal-700 uppercase tracking-wider block">Pemetaan Spasial GIS</span>
                            <h5 class="text-xs font-extrabold text-slate-900 leading-tight">21 Titik Koordinat Aktif</h5>
                            <span class="text-[11px] text-slate-500">Fasilitas, Posko KKN, & Spot Wisata</span>
                        </div>
                    </div>
                </div>

                <!-- Floating Bubble 3: Digital Handover Certified (Bottom Right) -->
                <div class="hidden lg:flex absolute -bottom-8 -right-8 z-30 animate-float p-4 rounded-2xl glass-card text-left max-w-xs shadow-xl">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-lg shrink-0 shadow-md shadow-amber-500/20">
                            📜
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-amber-700 uppercase tracking-wider block">Berita Acara BA-KKN</span>
                            <h5 class="text-xs font-extrabold text-slate-900 leading-tight">Handover 100% Selesai</h5>
                            <span class="text-[11px] text-slate-500">Aset diserahterimakan ke Desa</span>
                        </div>
                    </div>
                </div>

                <!-- Floating Bubble 4: Tim KKN Squad (Bottom Left) -->
                <div class="hidden lg:flex absolute -bottom-8 -left-6 z-30 animate-float-delayed p-4 rounded-2xl glass-card text-left max-w-xs shadow-xl">
                    <div class="flex items-center space-x-3">
                        <div class="flex -space-x-2 overflow-hidden shrink-0">
                            <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-emerald-700 text-white font-bold text-xs flex items-center justify-center">B</div>
                            <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-teal-600 text-white font-bold text-xs flex items-center justify-center">S</div>
                            <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-indigo-600 text-white font-bold text-xs flex items-center justify-center">F</div>
                        </div>
                        <div>
                            <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-wider block">Tim KKN Terpadu</span>
                            <h5 class="text-xs font-extrabold text-slate-900 leading-tight">Kelompok 14 Sukamaju</h5>
                            <span class="text-[11px] text-slate-500">Dosen Pembimbing & 4 Mahasiswa</span>
                        </div>
                    </div>
                </div>

                <!-- Main Desktop Canvas Window Frame -->
                <div class="rounded-3xl border border-slate-300 bg-white shadow-2xl overflow-hidden p-2 sm:p-4 transition hover:shadow-[0_30px_70px_-15px_rgba(5,150,105,0.15)]">
                    
                    <!-- Top Window Chrome -->
                    <div class="px-4 py-3 bg-slate-100/90 rounded-2xl border border-slate-200 flex items-center justify-between text-xs mb-3">
                        <div class="flex items-center space-x-2">
                            <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                        </div>
                        <div class="px-6 py-1 rounded-xl bg-white border border-slate-200 font-mono text-[11px] text-slate-600 max-w-md w-full truncate shadow-2xs">
                            https://desakita.id/desa/sukamaju
                        </div>
                        <div class="text-[10px] text-emerald-700 font-bold flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>OFFICIAL PORTAL</span>
                        </div>
                    </div>

                    <!-- Inner Hero Preview Content Image -->
                    <div class="rounded-2xl overflow-hidden relative border border-slate-200 aspect-16/9 sm:aspect-21/9 max-h-[480px]">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1600&auto=format&fit=crop" 
                             alt="Desa Sukamaju Live" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent p-6 sm:p-12 flex flex-col justify-end text-left">
                            <div class="inline-flex items-center space-x-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-emerald-300 text-xs font-bold w-fit mb-2">
                                <span>Kecamatan Cisarua, Kabupaten Bogor</span>
                            </div>
                            <h3 class="text-2xl sm:text-4xl font-black text-white">Website Resmi Desa Sukamaju</h3>
                            <p class="text-xs sm:text-base text-slate-200 max-w-2xl mt-2 leading-relaxed">
                                Dilengkapi katalog 10 UMKM kopi dan keripik, direktori 5 destinasi wisata alam, peta digital, dan berita terkini hasil kolaborasi mahasiswa KKN.
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </header>

    <!-- Bento Grid Section: 6 Pilar Solusi ("Sangat Wah & Premium") -->
    <section id="fitur" class="py-20 lg:py-28 bg-slate-50 border-t border-slate-200 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-extrabold uppercase tracking-wider border border-emerald-300/80">
                    6 Pilar Digitalisasi Desa
                </span>
                <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-4 tracking-tight">
                    Ekosistem Lengkap dari Posko Hingga Balai Desa
                </h2>
                <p class="text-sm sm:text-base text-slate-600 mt-3 leading-relaxed">
                    Setiap modul dirancang spesifik untuk mengatasi kelemahan program pengabdian masyarakat di Indonesia.
                </p>
            </div>

            <!-- Bento Asymmetric Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Bento 1: Portal Publik (Col-Span 2) -->
                <div class="md:col-span-2 rounded-3xl bg-white border border-slate-200/90 p-8 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl font-black mb-6 group-hover:scale-110 transition">
                            🌐
                        </div>
                        <span class="text-xs font-extrabold text-emerald-700 uppercase tracking-wider block">Pilar 1 — Citra Digital Desa</span>
                        <h3 class="text-2xl font-black text-slate-900 mt-1">Portal Resmi Publik Desa Otomatis</h3>
                        <p class="text-sm text-slate-600 mt-3 leading-relaxed max-w-xl">
                            Begitu data observasi mahasiswa dimasukkan, sistem langsung mengkompilasinya menjadi portal website desa responsif, SEO-ready, dan siap diakses masyarakat luas tanpa perlu keahlian coding.
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 grid grid-cols-3 gap-4 text-center">
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <span class="font-extrabold text-slate-900 block text-sm">Responsif</span>
                            <span class="text-[11px] text-slate-500">HP, Tablet, & PC</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <span class="font-extrabold text-slate-900 block text-sm">SEO Ready</span>
                            <span class="text-[11px] text-slate-500">Terindeks Google</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl">
                            <span class="font-extrabold text-slate-900 block text-sm">3 Tema Desa</span>
                            <span class="text-[11px] text-slate-500">Modern, Alam, Budaya</span>
                        </div>
                    </div>
                </div>

                <!-- Bento 2: Direktori UMKM WhatsApp (Col-Span 1) -->
                <div class="rounded-3xl bg-white border border-slate-200/90 p-8 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center text-2xl font-black mb-6 group-hover:scale-110 transition">
                            🛍️
                        </div>
                        <span class="text-xs font-extrabold text-teal-700 uppercase tracking-wider block">Pilar 2 — Ekonomi Warga</span>
                        <h3 class="text-xl font-black text-slate-900 mt-1">Katalog UMKM & Pesan WhatsApp</h3>
                        <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                            Bantu usaha warga menjual produk unggulan secara online dengan tombol pesan langsung ke WhatsApp tanpa potongan komisi sepeser pun.
                        </p>
                    </div>

                    <div class="mt-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-center justify-between text-xs">
                        <span class="font-bold text-emerald-900">Direct WhatsApp</span>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-600 text-white text-[10px] font-bold">0% Komisi</span>
                    </div>
                </div>

                <!-- Bento 3: Peta Spasial GIS (Col-Span 1) -->
                <div class="rounded-3xl bg-white border border-slate-200/90 p-8 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center text-2xl font-black mb-6 group-hover:scale-110 transition">
                            🗺️
                        </div>
                        <span class="text-xs font-extrabold text-indigo-700 uppercase tracking-wider block">Pilar 3 — Pemetaan Wilayah</span>
                        <h3 class="text-xl font-black text-slate-900 mt-1">Peta Digital & Titik Potensi Spasial</h3>
                        <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                            Tandai fasilitas pelayanan, posyandu, sentra UMKM, dan spot wisata desa hanya dengan mengklik langsung pada peta atau menggunakan GPS perangkat.
                        </p>
                    </div>

                    <div class="mt-6 p-4 rounded-2xl bg-indigo-50 border border-indigo-200 text-xs font-bold text-indigo-900 flex items-center justify-between">
                        <span>Leaflet Interactive</span>
                        <span class="text-[10px] font-mono text-indigo-700">Auto-GPS Sync</span>
                    </div>
                </div>

                <!-- Bento 4: Kanban & Workspace (Col-Span 2) -->
                <div class="md:col-span-2 rounded-3xl bg-white border border-slate-200/90 p-8 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-2xl font-black mb-6 group-hover:scale-110 transition">
                            📋
                        </div>
                        <span class="text-xs font-extrabold text-blue-700 uppercase tracking-wider block">Pilar 4 — Manajemen Kerja Mahasiswa</span>
                        <h3 class="text-2xl font-black text-slate-900 mt-1">Papan Kanban Kerja & Review Dosen DPL</h3>
                        <p class="text-sm text-slate-600 mt-3 leading-relaxed max-w-xl">
                            Pantau pembagian tugas harian mahasiswa, unggah bukti luaran kegiatan, dan review langsung oleh Dosen Pembimbing Lapangan secara transparan sebelum disetujui tampil ke publik.
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 grid grid-cols-4 gap-2 text-center text-xs">
                        <div class="p-2.5 bg-slate-50 rounded-xl font-bold text-slate-600">TODO</div>
                        <div class="p-2.5 bg-blue-50 rounded-xl font-bold text-blue-700">IN PROGRESS</div>
                        <div class="p-2.5 bg-amber-50 rounded-xl font-bold text-amber-700">REVIEW DPL</div>
                        <div class="p-2.5 bg-emerald-50 rounded-xl font-bold text-emerald-800">DONE</div>
                    </div>
                </div>

                <!-- Bento 5: AI Drafting Assistant (Col-Span 1) -->
                <div class="rounded-3xl bg-white border border-slate-200/90 p-8 shadow-sm hover:shadow-xl transition duration-300 flex flex-col justify-between group">
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-700 flex items-center justify-center text-2xl font-black mb-6 group-hover:scale-110 transition">
                            ✨
                        </div>
                        <span class="text-xs font-extrabold text-purple-700 uppercase tracking-wider block">Pilar 5 — Akselerasi Konten</span>
                        <h3 class="text-xl font-black text-slate-900 mt-1">AI Drafting Assistant</h3>
                        <p class="text-xs text-slate-600 mt-3 leading-relaxed">
                            Bantuan kecerdasan buatan untuk menyusun narasi sejarah desa, visi-misi, deskripsi program kerja, hingga ringkasan capaian dampak dalam hitungan detik.
                        </p>
                    </div>

                    <div class="mt-6 p-4 rounded-2xl bg-purple-50 border border-purple-200 text-xs font-bold text-purple-900 flex items-center justify-between">
                        <span>One-Click Generator</span>
                        <span class="text-[10px] bg-purple-600 text-white px-2 py-0.5 rounded-md">Smart Prompt</span>
                    </div>
                </div>

                <!-- Bento 6: Digital Handover 100% (Col-Span 2) -->
                <div class="md:col-span-2 rounded-3xl bg-gradient-to-br from-emerald-700 via-teal-800 to-emerald-900 text-white p-8 shadow-xl flex flex-col justify-between group relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                    <div>
                        <div class="w-12 h-12 rounded-2xl bg-white/20 text-white flex items-center justify-center text-2xl font-black mb-6 group-hover:scale-110 transition">
                            📜
                        </div>
                        <span class="text-xs font-black text-emerald-200 uppercase tracking-wider block">Pilar 6 — Keberlanjutan Sistem (Signature Feature)</span>
                        <h3 class="text-2xl font-black text-white mt-1">Digital Handover & Sertifikasi BA-KKN</h3>
                        <p class="text-sm text-emerald-100 mt-3 leading-relaxed max-w-xl">
                            Menjamin kepemilikan operasional website desa diserahkan seutuhnya kepada aparatur desa dengan Berita Acara resmi, modul panduan, dan akun admin mandiri sebelum mahasiswa ditarik ke kampus.
                        </p>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/20 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center space-x-2 text-xs font-bold text-emerald-200">
                            <span class="text-base">✓</span>
                            <span>Kesiapan Handover 100% Tervalidasi</span>
                        </div>
                        <a href="{{ route('public.village.home', 'sukamaju') }}" class="px-5 py-2.5 rounded-xl bg-white text-emerald-900 hover:bg-emerald-50 font-black text-xs transition shadow-sm self-start sm:self-auto">
                            Lihat Contoh Handover →
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Interactive Live Simulator Section (Tabs) -->
    <section id="demo-live" class="py-20 lg:py-28 bg-white relative z-10 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black uppercase tracking-wider border border-emerald-300">
                    Interactive Live Architecture
                </span>
                <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-4 tracking-tight">
                    Simulasi 3 Lapisan Ekosistem Desa
                </h2>
                <p class="text-sm sm:text-base text-slate-600 mt-3 leading-relaxed">
                    Klik tab di bawah untuk melihat bagaimana sistem menghubungkan pengunjung publik, ruang kerja tim KKN, hingga seremoni serah terima desa.
                </p>

                <!-- Interactive Tab Switcher -->
                <div class="mt-8 inline-flex p-1.5 rounded-2xl bg-slate-100 border border-slate-200 shadow-inner">
                    <button @click="activeTab = 'portal'" 
                            :class="activeTab === 'portal' ? 'bg-white text-emerald-800 font-black shadow-md' : 'text-slate-600 hover:text-slate-900 font-bold'"
                            class="px-5 py-3 rounded-xl text-xs sm:text-sm transition flex items-center space-x-2 cursor-pointer">
                        <span>🌐 1. Portal Publik Desa</span>
                    </button>
                    <button @click="activeTab = 'workspace'" 
                            :class="activeTab === 'workspace' ? 'bg-white text-emerald-800 font-black shadow-md' : 'text-slate-600 hover:text-slate-900 font-bold'"
                            class="px-5 py-3 rounded-xl text-xs sm:text-sm transition flex items-center space-x-2 cursor-pointer">
                        <span>📋 2. Workspace & Kanban</span>
                    </button>
                    <button @click="activeTab = 'handover'" 
                            :class="activeTab === 'handover' ? 'bg-white text-emerald-800 font-black shadow-md' : 'text-slate-600 hover:text-slate-900 font-bold'"
                            class="px-5 py-3 rounded-xl text-xs sm:text-sm transition flex items-center space-x-2 cursor-pointer">
                        <span>📜 3. Sertifikat Handover</span>
                    </button>
                </div>
            </div>

            <!-- Simulated Browser Window Frame -->
            <div class="rounded-3xl border border-slate-300 bg-white shadow-2xl overflow-hidden">
                
                <!-- Browser Bar -->
                <div class="px-6 py-3.5 bg-slate-100 border-b border-slate-200 flex items-center justify-between text-xs">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                    </div>
                    <div class="px-6 py-1 rounded-xl bg-white border border-slate-200 font-mono text-[11px] text-slate-600 max-w-md w-full text-center truncate shadow-2xs">
                        <span x-show="activeTab === 'portal'">https://desakita.id/desa/sukamaju</span>
                        <span x-show="activeTab === 'workspace'" style="display: none;">https://desakita.id/workspace/group/1/programs</span>
                        <span x-show="activeTab === 'handover'" style="display: none;">https://desakita.id/desa/sukamaju/handover</span>
                    </div>
                    <div class="text-[10px] text-emerald-700 font-mono font-black flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>INTERACTIVE PREVIEW</span>
                    </div>
                </div>

                <!-- Tab 1: Portal Publik View Preview -->
                <div x-show="activeTab === 'portal'" class="p-6 sm:p-10 space-y-8">
                    <div class="rounded-2xl overflow-hidden relative border border-slate-200 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1600&auto=format&fit=crop" 
                             alt="Desa Sukamaju Live" class="w-full h-72 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/50 to-transparent p-6 sm:p-10 flex flex-col justify-end">
                            <span class="text-xs text-emerald-400 font-bold uppercase tracking-wider">Portal Resmi Terintegrasi</span>
                            <h3 class="text-2xl sm:text-3xl font-black text-white mt-1">Pemerintah Desa Sukamaju</h3>
                            <p class="text-xs sm:text-sm text-slate-200 max-w-lg mt-1 leading-relaxed">Website desa responsif dengan etalase 10 UMKM kopi, keripik, madu, dan anyaman bambu terhubung pesan WhatsApp langsung.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center space-x-4 hover:bg-emerald-50/50 transition">
                            <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=200&auto=format&fit=crop" class="w-16 h-16 rounded-2xl object-cover shadow-sm">
                            <div>
                                <h4 class="text-sm font-extrabold text-slate-900">Kopi Lereng Sukamaju</h4>
                                <span class="text-xs text-emerald-700 font-bold block">Arabika Specialty 200g</span>
                                <span class="text-[11px] text-slate-500 mt-0.5 block">Pesan langsung via WhatsApp</span>
                            </div>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center space-x-4 hover:bg-emerald-50/50 transition">
                            <img src="https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?q=80&w=200&auto=format&fit=crop" class="w-16 h-16 rounded-2xl object-cover shadow-sm">
                            <div>
                                <h4 class="text-sm font-extrabold text-slate-900">Curug Sukamaju Indah</h4>
                                <span class="text-xs text-teal-700 font-bold block">Wisata Air Terjun 25m</span>
                                <span class="text-[11px] text-slate-500 mt-0.5 block">Tiket Masuk: Rp 15.000</span>
                            </div>
                        </div>

                        <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center space-x-4 hover:bg-emerald-50/50 transition">
                            <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-3xl shadow-sm">🗺️</div>
                            <div>
                                <h4 class="text-sm font-extrabold text-slate-900">Peta Spasial GIS</h4>
                                <span class="text-xs text-emerald-700 font-bold block">21 Titik Koordinat Aktif</span>
                                <span class="text-[11px] text-slate-500 mt-0.5 block">Fasilitas, SD, Posyandu, UMKM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Workspace KKN Preview -->
                <div x-show="activeTab === 'workspace'" class="p-6 sm:p-10 space-y-6" style="display: none;">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <span class="text-xs text-emerald-700 font-bold uppercase tracking-wider">Kelompok KKN 14 — Desa Sukamaju</span>
                            <h3 class="text-xl font-black text-slate-900 mt-0.5">Kanban Program Kerja Digitalisasi UMKM</h3>
                        </div>
                        <span class="px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-extrabold border border-emerald-300">
                            Progres: 100% Tuntas
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <span class="font-bold text-slate-600 block">TODO (0)</span>
                            <div class="p-3.5 rounded-xl bg-white text-slate-400 border border-slate-200 shadow-2xs">Semua tugas awal telah tuntas.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-blue-50/60 border border-blue-200 space-y-2">
                            <span class="font-bold text-blue-800 block">IN PROGRESS (0)</span>
                            <div class="p-3.5 rounded-xl bg-white text-slate-400 border border-slate-200 shadow-2xs">Tidak ada tanggungan tugas.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-amber-50/60 border border-amber-200 space-y-2">
                            <span class="font-bold text-amber-800 block">REVIEW DPL (0)</span>
                            <div class="p-3.5 rounded-xl bg-white text-slate-400 border border-slate-200 shadow-2xs">Semua luaran disetujui Dosen.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 space-y-2">
                            <span class="font-bold text-emerald-800 block">DONE (4)</span>
                            <div class="p-3.5 rounded-xl bg-white border border-emerald-200 text-slate-800 font-bold shadow-2xs">✓ Sesi foto produk 10 UMKM</div>
                            <div class="p-3.5 rounded-xl bg-white border border-emerald-200 text-slate-800 font-bold shadow-2xs">✓ Integrasi WhatsApp & QRIS</div>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Handover Certificate Preview -->
                <div x-show="activeTab === 'handover'" class="p-6 sm:p-10 text-center space-y-4" style="display: none;">
                    <div class="max-w-lg mx-auto p-8 rounded-3xl bg-slate-50 border border-amber-300 shadow-xl space-y-4">
                        <div class="w-16 h-16 mx-auto rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-3xl shadow-sm">📜</div>
                        <h4 class="text-lg font-black text-slate-900">BERITA ACARA SERAH TERIMA ASET DIGITAL</h4>
                        <p class="text-xs text-slate-600 leading-relaxed max-w-md mx-auto">
                            Aset website resmi, database 10 UMKM lokal, peta GIS terpadu, dan akun admin mandiri resmi diserahkan kepada Pemerintah Desa Sukamaju.
                        </p>
                        <div class="pt-4 border-t border-slate-200 flex items-center justify-around text-xs text-slate-600">
                            <div>Ketua KKN<br><strong class="text-slate-900">Bintang P.</strong></div>
                            <div>Dosen DPL<br><strong class="text-slate-900">Prof. Rina K.</strong></div>
                            <div>Kepala Desa<br><strong class="text-slate-900">H. Suryana</strong></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Problem vs Solution Comparison Section -->
    <section id="masalah" class="py-20 lg:py-28 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-black text-emerald-700 uppercase tracking-widest block">Paradigma Baru KKN Indonesia</span>
                <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-3 tracking-tight">
                    Mengapa KKN Konvensional Sering Menjadi Sia-Sia?
                </h2>
                <p class="text-sm sm:text-base text-slate-600 mt-3 leading-relaxed">
                    Setiap tahun ratusan ribu mahasiswa diterjunkan ke desa. Namun setelah penarikan mahasiswa, nyaris tidak ada jejak teknologi yang bertahan di desa.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                
                <!-- Red Pain Point Card -->
                <div class="p-8 sm:p-12 rounded-3xl bg-rose-50/70 border border-rose-200 shadow-sm space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-rose-600 text-white flex items-center justify-center font-black text-xl shadow-md shadow-rose-600/20">✗</div>
                        <div>
                            <h3 class="text-2xl font-black text-rose-950">KKN Konvensional Biasa</h3>
                            <span class="text-xs text-rose-700 font-semibold">Pola Lama yang Terulang Tiap Periode</span>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm text-slate-700 leading-relaxed">
                        <li class="flex items-start">
                            <span class="text-rose-600 font-black mr-3 text-lg leading-none">•</span>
                            <span><strong>Laporan Berakhir Menjadi Pajangan Rak:</strong> Data potensi desa dicetak tebal menjadi tumpukan kertas yang tak pernah dibaca kembali oleh perangkat desa.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-rose-600 font-black mr-3 text-lg leading-none">•</span>
                            <span><strong>Website Gratisan Mati & Terlantar:</strong> Dibuat di platform blog gratis, domain kedaluwarsa setelah 2 bulan, dan password terkunci di email pribadi mahasiswa.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-rose-600 font-black mr-3 text-lg leading-none">•</span>
                            <span><strong>UMKM Desa Tak Berkelanjutan:</strong> Foto produk hanya ditempel di spanduk posko tanpa sistem katalog online yang bisa menerima pesanan terus-menerus.</span>
                        </li>
                    </ul>
                </div>

                <!-- Emerald Solution Card -->
                <div class="p-8 sm:p-12 rounded-3xl bg-emerald-50/80 border-2 border-emerald-300 shadow-md space-y-6">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-emerald-600 text-white flex items-center justify-center font-black text-xl shadow-md shadow-emerald-600/20">✓</div>
                        <div>
                            <h3 class="text-2xl font-black text-emerald-950">Dengan KKN Digital Village OS</h3>
                            <span class="text-xs text-emerald-700 font-extrabold">Transformasi Menjadi Smart Village Mandiri</span>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm text-slate-700 leading-relaxed">
                        <li class="flex items-start">
                            <span class="text-emerald-700 font-black mr-3 text-lg leading-none">•</span>
                            <span><strong>Otomatis Melahirkan Portal Resmi Desa:</strong> Hasil observasi mahasiswa langsung tersusun menjadi portal publik desa dengan tampilan modern dan SEO optimal.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-700 font-black mr-3 text-lg leading-none">•</span>
                            <span><strong>Etalase UMKM Terhubung WhatsApp:</strong> Pengunjung dapat langsung memesan produk warga secara cepat via WhatsApp tanpa potongan biaya sepeser pun.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-700 font-black mr-3 text-lg leading-none">•</span>
                            <span><strong>Garansi Digital Handover 100%:</strong> Kepemilikan website dialihkan resmi ke aparatur desa lengkap dengan modul panduan dan Berita Acara BA-KKN.</span>
                        </li>
                    </ul>
                </div>

            </div>

        </div>
    </section>

    <!-- Multi-Tenant Showcase Villages Section -->
    <section id="desa-binaan" class="py-20 lg:py-28 bg-white border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-black text-emerald-700 uppercase tracking-widest block">Multi-Tenant Ecosystem</span>
                    <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-1 tracking-tight">Desa Binaan & Digital Showcase</h2>
                </div>
                <p class="text-sm text-slate-600 max-w-md">
                    Setiap desa memiliki portal terisolasi, tema unik, dan basis data mandiri yang dapat dikelola secara mandiri oleh aparatur desa.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Sukamaju Showcase -->
                <div class="rounded-3xl bg-white border-2 border-emerald-500 p-6 shadow-md hover:shadow-2xl transition duration-300 space-y-4 flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="h-44 rounded-2xl overflow-hidden relative shadow-xs">
                            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-2.5 right-2.5 px-3 py-1 rounded-full bg-emerald-600 text-white font-black text-[10px] shadow-sm">
                                🌟 Showcase Utama
                            </span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">Desa Sukamaju</h3>
                        <p class="text-xs text-slate-600 line-clamp-2">Cisarua, Bogor. Sentra kopi arabika pegunungan, curug alami, dan kerajinan anyaman bambu.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'sukamaju') }}" class="w-full py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs text-center transition shadow-xs">
                        Buka Portal Sukamaju &rarr;
                    </a>
                </div>

                <!-- Berkah Mandiri -->
                <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-xs hover:shadow-xl transition duration-300 space-y-4 flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="h-44 rounded-2xl overflow-hidden relative shadow-xs">
                            <img src="https://images.unsplash.com/photo-1596401057633-54a8fe8ef647?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-2.5 right-2.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] border border-slate-200">
                                Desa Binaan
                            </span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">Desa Berkah Mandiri</h3>
                        <p class="text-xs text-slate-600 line-clamp-2">Lembang, Bandung Barat. Agrowisata sayur mayur dan peternakan sapi perah terpadu.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'berkah-mandiri') }}" class="w-full py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs text-center transition">
                        Buka Portal Berkah &rarr;
                    </a>
                </div>

                <!-- Mekar Jaya -->
                <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-xs hover:shadow-xl transition duration-300 space-y-4 flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="h-44 rounded-2xl overflow-hidden relative shadow-xs">
                            <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-2.5 right-2.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] border border-slate-200">
                                Desa Binaan
                            </span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">Desa Mekar Jaya</h3>
                        <p class="text-xs text-slate-600 line-clamp-2">Tarogong Kaler, Garut. Kerajinan kulit, dodol tradisional, dan sumber air panas.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'mekar-jaya') }}" class="w-full py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs text-center transition">
                        Buka Portal Mekar Jaya &rarr;
                    </a>
                </div>

                <!-- Ciburial -->
                <div class="rounded-3xl bg-white border border-slate-200 p-6 shadow-xs hover:shadow-xl transition duration-300 space-y-4 flex flex-col justify-between group">
                    <div class="space-y-3">
                        <div class="h-44 rounded-2xl overflow-hidden relative shadow-xs">
                            <img src="https://images.unsplash.com/photo-1576085898323-218337e3e43c?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <span class="absolute top-2.5 right-2.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] border border-slate-200">
                                Desa Binaan
                            </span>
                        </div>
                        <h3 class="text-xl font-black text-slate-900">Desa Ciburial</h3>
                        <p class="text-xs text-slate-600 line-clamp-2">Cimenyan, Bandung. Wisata tebing keraton, kebun pinus rindang, dan kopi bukit.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'ciburial') }}" class="w-full py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs text-center transition">
                        Buka Portal Ciburial &rarr;
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- Testimonials / Stakeholder Quotes -->
    <section id="testimoni" class="py-20 lg:py-28 bg-slate-50 border-t border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-black text-emerald-700 uppercase tracking-widest block">Dampak Nyata di Lapangan</span>
                <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-2 tracking-tight">Dipercaya Kampus, Dosen, dan Aparatur Desa</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4 hover:shadow-lg transition">
                    <div class="flex items-center space-x-1 text-amber-400 text-sm">★★★★★</div>
                    <p class="text-sm text-slate-600 leading-relaxed italic">
                        "Dengan KKN Digital Village OS, kami sebagai pemerintah desa tidak perlu menyewa vendor ratusan juta. Hasil kerja mahasiswa langsung jadi website resmi yang siap kami kelola terus."
                    </p>
                    <div class="pt-4 border-t border-slate-100 flex items-center space-x-3.5">
                        <div class="w-11 h-11 rounded-full bg-emerald-600 text-white flex items-center justify-center font-black text-sm shadow-xs">S</div>
                        <div>
                            <span class="font-bold text-sm text-slate-900 block">Bapak H. Suryana, S.Sos</span>
                            <span class="text-xs text-emerald-700 font-semibold">Kepala Desa Sukamaju</span>
                        </div>
                    </div>
                </div>

                <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4 hover:shadow-lg transition">
                    <div class="flex items-center space-x-1 text-amber-400 text-sm">★★★★★</div>
                    <p class="text-sm text-slate-600 leading-relaxed italic">
                        "Sebagai DPL, saya bisa mereview produk UMKM, warta desa, dan tugas harian mahasiswa dari satu dashboard tanpa harus menagih via WhatsApp setiap malam."
                    </p>
                    <div class="pt-4 border-t border-slate-100 flex items-center space-x-3.5">
                        <div class="w-11 h-11 rounded-full bg-teal-600 text-white flex items-center justify-center font-black text-sm shadow-xs">R</div>
                        <div>
                            <span class="font-bold text-sm text-slate-900 block">Prof. Dr. Rina Kusuma</span>
                            <span class="text-xs text-teal-700 font-semibold">Dosen Pembimbing Lapangan</span>
                        </div>
                    </div>
                </div>

                <div class="p-8 rounded-3xl bg-white border border-slate-200 shadow-sm space-y-4 hover:shadow-lg transition">
                    <div class="flex items-center space-x-1 text-amber-400 text-sm">★★★★★</div>
                    <p class="text-sm text-slate-600 leading-relaxed italic">
                        "Kopi lereng kami sekarang ada fotonya, ada deskripsinya, dan orang Jakarta langsung chat WhatsApp pesan cold brew dan biji sangrai. Sangat membantu penjualan warga!"
                    </p>
                    <div class="pt-4 border-t border-slate-100 flex items-center space-x-3.5">
                        <div class="w-11 h-11 rounded-full bg-amber-600 text-white flex items-center justify-center font-black text-sm shadow-xs">J</div>
                        <div>
                            <span class="font-bold text-sm text-slate-900 block">Pak Joko Widodo</span>
                            <span class="text-xs text-amber-700 font-semibold">Pemilik Kopi Lereng Sukamaju</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Accordion Section -->
    <section id="faq" class="py-20 lg:py-28 bg-white border-t border-slate-200">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-xs font-black text-emerald-700 uppercase tracking-widest block">Pertanyaan Umum</span>
                <h2 class="text-3xl sm:text-5xl font-black text-slate-900 mt-2 tracking-tight">Kerap Ditanyakan seputar Platform</h2>
            </div>

            <div class="space-y-4">
                
                <!-- FAQ Item 1 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer" @click="faqOpen = faqOpen === 1 ? null : 1">
                    <div class="flex items-center justify-between">
                        <h4 class="font-extrabold text-slate-900 text-base">Apakah website desa tetap aktif setelah periode KKN mahasiswa selesai?</h4>
                        <span class="text-emerald-700 font-black text-xl" x-text="faqOpen === 1 ? '−' : '+'"></span>
                    </div>
                    <div x-show="faqOpen === 1" class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3" style="display: none;">
                        <strong>Ya, 100% tetap aktif dan hidup.</strong> Melalui fitur Digital Handover, kepemilikan dan hak akses pengelolaan website secara otomatis diserahkan kepada akun aparatur desa yang didaftarkan, lengkap dengan buku panduan tertulis.
                    </div>
                </div>

                <!-- FAQ Item 2 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer" @click="faqOpen = faqOpen === 2 ? null : 2">
                    <div class="flex items-center justify-between">
                        <h4 class="font-extrabold text-slate-900 text-base">Bagaimana cara UMKM desa menerima pesanan dari publik?</h4>
                        <span class="text-emerald-700 font-black text-xl" x-text="faqOpen === 2 ? '−' : '+'"></span>
                    </div>
                    <div x-show="faqOpen === 2" class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3" style="display: none;">
                        Pengunjung website publik desa dapat langsung mengklik tombol <em>"💬 Pesan via WhatsApp"</em> pada produk yang diinginkan. Pesan template otomatis akan terkirim langsung ke nomor WhatsApp pemilik usaha tanpa potongan komisi.
                    </div>
                </div>

                <!-- FAQ Item 3 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 cursor-pointer" @click="faqOpen = faqOpen === 3 ? null : 3">
                    <div class="flex items-center justify-between">
                        <h4 class="font-extrabold text-slate-900 text-base">Apakah platform ini bisa digunakan oleh beberapa perguruan tinggi sekaligus?</h4>
                        <span class="text-emerald-700 font-black text-xl" x-text="faqOpen === 3 ? '−' : '+'"></span>
                    </div>
                    <div x-show="faqOpen === 3" class="mt-3 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-200/60 pt-3" style="display: none;">
                        Ya. KKN Digital Village OS dibangun dengan arsitektur <strong>Multi-Tenant</strong>. Setiap kampus memiliki ruang lingkup program tersendiri, dan setiap desa binaan memiliki database, tema tampilan, dan alamat subdomain/slug yang terisolasi.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Grand Bottom Call To Action Banner -->
    <section class="py-24 bg-gradient-to-br from-emerald-800 via-teal-900 to-emerald-950 text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-white/15 via-transparent to-transparent opacity-80 pointer-events-none"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 relative z-10">
            <span class="px-4 py-1.5 rounded-full bg-white/10 text-emerald-200 text-xs font-bold border border-white/20">Siap Mulai Mengabdi?</span>
            <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                Wujudkan Pengabdian KKN Berkelanjutan untuk Desa Indonesia
            </h2>
            <p class="text-sm sm:text-base text-emerald-100 max-w-xl mx-auto leading-relaxed">
                Bergabunglah bersama ribuan mahasiswa dan puluhan desa yang telah bertransformasi menjadi Smart Village mandiri.
            </p>
            <div class="pt-6 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('public.village.home', 'sukamaju') }}" 
                   class="px-8 py-4 rounded-2xl bg-white text-emerald-950 hover:bg-emerald-50 font-black text-sm shadow-xl hover:scale-102 transition duration-300">
                    Buka Portal Publik Desa Sukamaju &rarr;
                </a>
                <a href="{{ route('login') }}" 
                   class="px-8 py-4 rounded-2xl bg-emerald-900/80 hover:bg-emerald-900 text-white font-bold text-sm border border-emerald-400/40 transition hover:scale-102">
                    Masuk Akun Pengguna
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 text-xs py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-6">
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-500 flex items-center justify-center text-slate-950 font-black text-sm shadow-sm">
                    D
                </div>
                <div>
                    <span class="font-black text-white text-sm block">KKN Digital Village OS</span>
                    <span class="text-[11px] text-slate-500">Platform Digitalisasi Desa Berbasis Program KKN</span>
                </div>
            </div>
            
            <div class="flex items-center space-x-2 text-[11px] text-slate-400">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>Semua Sistem Beroperasi Normal</span>
            </div>

            <div class="flex items-center space-x-6 text-slate-400">
                <a href="{{ route('public.village.home', 'sukamaju') }}" class="hover:text-emerald-400 transition">Desa Sukamaju</a>
                <a href="{{ route('login') }}" class="hover:text-emerald-400 transition">Login</a>
                <a href="{{ route('register') }}" class="hover:text-emerald-400 transition">Register</a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 pt-6 border-t border-slate-800/80 text-center text-slate-500 text-[11px]">
            &copy; {{ date('Y') }} KKN Digital Village OS. Dirancang untuk Mendukung Tridharma Perguruan Tinggi & Kemandirian Digital Desa Nusantara.
        </div>
    </footer>

</body>
</html>
