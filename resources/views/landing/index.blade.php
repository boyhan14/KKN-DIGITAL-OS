<!DOCTYPE html>
<html lang="id" class="h-full scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KKN Digital Village OS — Dari Program KKN, Menjadi Digitalisasi Desa</title>
    <meta name="description" content="Platform multi-tenant yang mengubah program KKN mahasiswa menjadi aset digital terstruktur, website desa publik, direktori UMKM, peta potensi desa, dan digital handover berkelanjutan.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased selection:bg-emerald-500 selection:text-white" x-data="{ mobileNav: false, activeTab: 'portal' }">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-slate-950/80 backdrop-blur-xl border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo -->
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-slate-950 font-black shadow-lg shadow-emerald-500/20 group-hover:scale-105 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <span class="font-extrabold text-xl text-white tracking-tight block leading-none">Digital Village OS</span>
                        <span class="text-[11px] font-semibold text-emerald-400">KKN to Village Digitalization</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-400">
                    <a href="#masalah" class="hover:text-white transition">Problem</a>
                    <a href="#demo-live" class="hover:text-emerald-400 transition">Live Preview</a>
                    <a href="#alur" class="hover:text-white transition">Alur KKN</a>
                    <a href="#fitur" class="hover:text-white transition">Fitur Unggulan</a>
                    <a href="#desa-binaan" class="hover:text-white transition">Desa Binaan</a>
                    <a href="{{ route('public.village.home', 'sukamaju') }}" class="px-3 py-1.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 hover:bg-emerald-500/20 transition font-bold">
                        🌟 Demo Sukamaju
                    </a>
                </div>

                <!-- Right Actions -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-slate-950 font-black text-sm shadow-lg shadow-emerald-500/20 transition hover:scale-102">
                            Buka Workspace →
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-bold text-slate-300 hover:text-white transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-extrabold text-sm shadow-md shadow-emerald-500/20 transition hover:scale-102">
                            Mulai KKN
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger -->
                <div class="md:hidden">
                    <button @click="mobileNav = !mobileNav" class="p-2 text-slate-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="mobileNav" class="md:hidden border-b border-slate-800 bg-slate-950 px-4 py-4 space-y-2 text-sm font-medium" style="display: none;">
            <a href="#masalah" class="block py-2 text-slate-300">Problem</a>
            <a href="#demo-live" class="block py-2 text-slate-300">Live Preview</a>
            <a href="#alur" class="block py-2 text-slate-300">Alur KKN</a>
            <a href="#fitur" class="block py-2 text-slate-300">Fitur Unggulan</a>
            <a href="#desa-binaan" class="block py-2 text-slate-300">Desa Binaan</a>
            <a href="{{ route('public.village.home', 'sukamaju') }}" class="block py-2 text-emerald-400 font-bold">Jelajahi Demo Desa Sukamaju</a>
            <div class="pt-2 border-t border-slate-800 flex flex-col space-y-2">
                <a href="{{ route('login') }}" class="text-center py-2 text-slate-300 font-bold">Masuk</a>
                <a href="{{ route('register') }}" class="text-center py-2.5 bg-emerald-500 text-slate-950 font-black rounded-xl">Mulai KKN</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative overflow-hidden pt-16 pb-24 lg:pt-24 lg:pb-36 bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-emerald-950/40 via-slate-950 to-slate-950 border-b border-slate-800/80">
        
        <!-- Grid Pattern Backdrop -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#80808012_1px,transparent_1px),linear-gradient(to_bottom,#80808012_1px,transparent_1px)] bg-[size:28px_28px] opacity-40"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <!-- Hero Pill Badge -->
            <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-extrabold border border-emerald-500/30 mb-8 backdrop-blur-md shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Platform KKN Multi-Tenant & Digitalisasi Desa No. 1 di Indonesia</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight leading-[1.1] max-w-5xl mx-auto">
                Dari Program KKN, Menjadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-200">Digitalisasi Desa.</span>
            </h1>

            <!-- Subtitle -->
            <p class="mt-6 text-lg sm:text-xl text-slate-300 max-w-3xl mx-auto leading-relaxed font-normal">
                Satu platform terintegrasi untuk mengelola seluruh aktivitas KKN mahasiswa, mendata UMKM lokal, memetakan potensi spasial desa, dan otomatis mewariskan website resmi yang tetap hidup setelah mahasiswa ditarik pulang.
            </p>

            <!-- CTA Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('public.village.home', 'sukamaju') }}" 
                   class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-slate-950 font-black text-base shadow-xl shadow-emerald-500/25 hover:scale-102 transition flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Jelajahi Demo Desa Sukamaju</span>
                </a>

                <a href="{{ route('login') }}" 
                   class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-base border border-slate-700 shadow-md flex items-center justify-center space-x-2 transition hover:scale-102">
                    <span>Masuk ke Workspace KKN →</span>
                </a>
            </div>

            <!-- Platform Highlights Stats -->
            <div class="mt-16 pt-10 border-t border-slate-800/80 max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800/80 backdrop-blur-sm">
                    <div class="text-3xl sm:text-4xl font-black text-white">{{ $stats['total_villages'] > 0 ? $stats['total_villages'] : '5' }}</div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Desa Terhubung</div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800/80 backdrop-blur-sm">
                    <div class="text-3xl sm:text-4xl font-black text-emerald-400">{{ $stats['total_umkm'] > 0 ? $stats['total_umkm'] : '10' }}</div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">UMKM Terdigitalisasi</div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800/80 backdrop-blur-sm">
                    <div class="text-3xl sm:text-4xl font-black text-white">{{ $stats['total_programs'] > 0 ? $stats['total_programs'] : '6' }}</div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Program Nyata</div>
                </div>
                <div class="p-4 rounded-2xl bg-slate-900/50 border border-slate-800/80 backdrop-blur-sm">
                    <div class="text-3xl sm:text-4xl font-black text-amber-400">100%</div>
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mt-1">Digital Handover</div>
                </div>
            </div>

        </div>
    </header>

    <!-- Interactive Live Product Showcase Preview Frame -->
    <section id="demo-live" class="py-20 lg:py-28 bg-slate-900/60 relative z-20 border-b border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-xs font-bold uppercase tracking-wider border border-emerald-500/30">
                    Interactive Live Architecture
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-white mt-3 tracking-tight">
                    Satu Sistem, Tiga Lapisan Ekosistem Desa
                </h2>
                <p class="text-sm text-slate-400 mt-2">
                    Klik tab di bawah untuk melihat bagaimana KKN Digital Village OS bekerja menghubungkan mahasiswa, publik warga, dan serah terima perangkat desa.
                </p>

                <!-- Interactive Tab Switcher -->
                <div class="mt-8 inline-flex p-1.5 rounded-2xl bg-slate-950 border border-slate-800 shadow-xl">
                    <button @click="activeTab = 'portal'" 
                            :class="activeTab === 'portal' ? 'bg-emerald-500 text-slate-950 font-black shadow-md' : 'text-slate-400 hover:text-white font-semibold'"
                            class="px-5 py-2.5 rounded-xl text-xs transition flex items-center space-x-2">
                        <span>🌐 1. Portal Publik Desa</span>
                    </button>
                    <button @click="activeTab = 'workspace'" 
                            :class="activeTab === 'workspace' ? 'bg-emerald-500 text-slate-950 font-black shadow-md' : 'text-slate-400 hover:text-white font-semibold'"
                            class="px-5 py-2.5 rounded-xl text-xs transition flex items-center space-x-2">
                        <span>📋 2. Workspace & Kanban</span>
                    </button>
                    <button @click="activeTab = 'handover'" 
                            :class="activeTab === 'handover' ? 'bg-emerald-500 text-slate-950 font-black shadow-md' : 'text-slate-400 hover:text-white font-semibold'"
                            class="px-5 py-2.5 rounded-xl text-xs transition flex items-center space-x-2">
                        <span>📜 3. Sertifikat Handover</span>
                    </button>
                </div>
            </div>

            <!-- Browser Mockup Window -->
            <div class="rounded-3xl border border-slate-700/80 bg-slate-950 shadow-2xl overflow-hidden">
                <!-- Browser Header Bar -->
                <div class="px-6 py-3.5 bg-slate-900 border-b border-slate-800 flex items-center justify-between text-xs">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-rose-500/80"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-500/80"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-500/80"></span>
                    </div>
                    <div class="px-6 py-1 rounded-lg bg-slate-950 border border-slate-800 font-mono text-[11px] text-slate-400 text-center max-w-md w-full truncate">
                        <span x-show="activeTab === 'portal'">https://desakita.id/desa/sukamaju</span>
                        <span x-show="activeTab === 'workspace'" style="display: none;">https://desakita.id/workspace/group/1/programs</span>
                        <span x-show="activeTab === 'handover'" style="display: none;">https://desakita.id/desa/sukamaju/handover</span>
                    </div>
                    <div class="text-[10px] text-emerald-400 font-mono font-bold">
                        ● LIVE SIMULATION
                    </div>
                </div>

                <!-- Tab 1: Portal Publik View Preview -->
                <div x-show="activeTab === 'portal'" class="p-6 sm:p-10 bg-slate-900/40 space-y-8">
                    <div class="rounded-2xl overflow-hidden relative border border-slate-800">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1600&auto=format&fit=crop" 
                             alt="Desa Sukamaju Preview" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/70 to-transparent p-6 flex flex-col justify-end">
                            <span class="text-xs text-emerald-400 font-bold uppercase">Portal Resmi Terintegrasi</span>
                            <h3 class="text-2xl font-black text-white">Pemerintah Desa Sukamaju</h3>
                            <p class="text-xs text-slate-300 max-w-lg mt-1">Website desa responsif dengan etalase 10 UMKM kopi, keripik, madu, dan anyaman bambu terhubung chat WhatsApp.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center space-x-3">
                            <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=200&auto=format&fit=crop" class="w-14 h-14 rounded-xl object-cover">
                            <div>
                                <h4 class="text-sm font-bold text-white">Kopi Lereng Sukamaju</h4>
                                <span class="text-[11px] text-emerald-400 block">Arabika Specialty 200g</span>
                                <span class="text-[10px] text-slate-500">Pesan langsung via WhatsApp</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center space-x-3">
                            <img src="https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?q=80&w=200&auto=format&fit=crop" class="w-14 h-14 rounded-xl object-cover">
                            <div>
                                <h4 class="text-sm font-bold text-white">Curug Sukamaju Indah</h4>
                                <span class="text-[11px] text-teal-400 block">Wisata Air Terjun 25m</span>
                                <span class="text-[10px] text-slate-500">Tiket Masuk: Rp 15.000</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 flex items-center space-x-3">
                            <div class="w-14 h-14 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-2xl">🗺️</div>
                            <div>
                                <h4 class="text-sm font-bold text-white">Peta Spasial GIS</h4>
                                <span class="text-[11px] text-blue-400 block">21 Titik Koordinat Aktif</span>
                                <span class="text-[10px] text-slate-500">Fasilitas, SD, Posyandu, UMKM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Workspace KKN Preview -->
                <div x-show="activeTab === 'workspace'" class="p-6 sm:p-10 bg-slate-900/40 space-y-6" style="display: none;">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                        <div>
                            <span class="text-xs text-emerald-400 font-semibold">Kelompok KKN 14 — Desa Sukamaju</span>
                            <h3 class="text-xl font-black text-white">Kanban Program Kerja Digitalisasi UMKM</h3>
                        </div>
                        <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-bold">
                            Progres: 100% Selesai
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
                        <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 space-y-2">
                            <span class="font-bold text-slate-400 block">TODO (0)</span>
                            <div class="p-3 rounded-xl bg-slate-950 text-slate-500 border border-slate-800/80">Semua tugas awal telah tuntas.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 space-y-2">
                            <span class="font-bold text-blue-400 block">IN PROGRESS (0)</span>
                            <div class="p-3 rounded-xl bg-slate-950 text-slate-500 border border-slate-800/80">Tidak ada tanggungan tugas.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 space-y-2">
                            <span class="font-bold text-amber-400 block">REVIEW DPL (0)</span>
                            <div class="p-3 rounded-xl bg-slate-950 text-slate-500 border border-slate-800/80">Semua luaran disetujui Dosen.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-slate-900 border border-slate-800 space-y-2">
                            <span class="font-bold text-emerald-400 block">DONE (4)</span>
                            <div class="p-3 rounded-xl bg-slate-950 border border-emerald-500/30 text-slate-300">✓ Sesi foto produk 10 UMKM</div>
                            <div class="p-3 rounded-xl bg-slate-950 border border-emerald-500/30 text-slate-300">✓ Integrasi WhatsApp & QRIS</div>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Handover Certificate Preview -->
                <div x-show="activeTab === 'handover'" class="p-6 sm:p-10 bg-slate-900/40 text-center space-y-4" style="display: none;">
                    <div class="max-w-md mx-auto p-6 rounded-3xl bg-slate-900 border border-amber-500/40 shadow-2xl space-y-3">
                        <div class="w-12 h-12 mx-auto rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center text-2xl">📜</div>
                        <h4 class="text-base font-black text-white">BERITA ACARA SERAH TERIMA ASET DIGITAL</h4>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            Aset website, database 10 UMKM, peta GIS, dan akun admin resmi diwariskan ke Pemerintah Desa Sukamaju.
                        </p>
                        <div class="pt-3 border-t border-slate-800 flex items-center justify-around text-[10px] text-slate-400">
                            <div>Ketua KKN<br><strong class="text-white">Bintang P.</strong></div>
                            <div>Dosen DPL<br><strong class="text-white">Prof. Rina K.</strong></div>
                            <div>Kepala Desa<br><strong class="text-white">H. Suryana</strong></div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Problem vs Solution Comparison Section -->
    <section id="masalah" class="py-20 lg:py-28 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest block">Paradigma Baru KKN Indonesia</span>
                <h2 class="text-3xl sm:text-4xl font-black text-white mt-2 tracking-tight">
                    Mengapa KKN Konvensional Sering Menjadi Sia-Sia?
                </h2>
                <p class="text-sm text-slate-400 mt-3 leading-relaxed">
                    Setiap tahun ratusan ribu mahasiswa diterjunkan ke desa. Namun mengapa setelah penarikan mahasiswa, tidak ada jejak teknologi yang bertahan?
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                <!-- Red Pain Point Card -->
                <div class="p-8 sm:p-10 rounded-3xl bg-rose-950/20 border border-rose-900/60 shadow-lg space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center font-black text-lg">✗</div>
                        <div>
                            <h3 class="text-xl font-black text-rose-200">KKN Konvensional Biasa</h3>
                            <span class="text-xs text-rose-400/80">Pola Lama yang Terulang Tiap Periode</span>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm text-slate-300">
                        <li class="flex items-start">
                            <span class="text-rose-500 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>Laporan Berakhir di Rak:</strong> Observasi dan data potensi desa dicetak tebal menjadi skripsi/laporan yang tak pernah dibaca perangkat desa.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-rose-500 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>Website Mahasiswa Mati:</strong> Dibuat di platform gratisan, domain kedaluwarsa setelah 2 bulan, dan password terkunci di email pribadi mahasiswa.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-rose-500 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>UMKM Bingung Lanjut:</strong> Foto produk hanya ditempel di spanduk posko tanpa sistem katalog yang bisa menerima pesanan berkelanjutan.</span>
                        </li>
                    </ul>
                </div>

                <!-- Emerald Solution Card -->
                <div class="p-8 sm:p-10 rounded-3xl bg-emerald-950/30 border border-emerald-500/40 shadow-xl shadow-emerald-950/40 space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-500 text-slate-950 flex items-center justify-center font-black text-lg">✓</div>
                        <div>
                            <h3 class="text-xl font-black text-emerald-200">Dengan KKN Digital Village OS</h3>
                            <span class="text-xs text-emerald-400 font-semibold">Transformasi Menjadi Smart Village</span>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm text-slate-200">
                        <li class="flex items-start">
                            <span class="text-emerald-400 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>Otomatis Lahirkan Portal Desa:</strong> Input mahasiswa langsung menjadi website publik desa resmi dengan foto high-res dan SEO teroptimasi.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-400 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>Etalase UMKM Mandiri:</strong> Pembeli bisa memesan produk langsung ke WhatsApp pemilik usaha, tanpa potongan komisi marketplace.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-400 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>Garansi Digital Handover 100%:</strong> Serah terima resmi dengan Berita Acara BA-KKN, modul pelatihan, dan akun admin aktif untuk perangkat desa.</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </section>

    <!-- Multi-Tenant Showcase Villages Section -->
    <section id="desa-binaan" class="py-20 lg:py-28 bg-slate-900/40 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest block">Multi-Tenant Ecosystem</span>
                    <h2 class="text-3xl sm:text-4xl font-black text-white mt-1 tracking-tight">Desa Binaan & Digital Showcase</h2>
                </div>
                <p class="text-xs text-slate-400 max-w-md">
                    Setiap desa memiliki portal terisolasi, tema unik, dan basis data terlindungi yang mandiri.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Sukamaju Showcase -->
                <div class="rounded-3xl bg-slate-900 border border-emerald-500/50 p-5 shadow-xl space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="h-36 rounded-2xl overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover">
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full bg-emerald-500 text-slate-950 font-black text-[10px]">
                                100% Handover
                            </span>
                        </div>
                        <h3 class="text-lg font-black text-white">Desa Sukamaju</h3>
                        <p class="text-xs text-slate-400 line-clamp-2">Cisarua, Bogor. Sentra kopi arabika pegunungan, curug alami, dan kerajinan bambu.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'sukamaju') }}" class="w-full py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black text-xs text-center transition">
                        Buka Portal Sukamaju →
                    </a>
                </div>

                <!-- Berkah Mandiri -->
                <div class="rounded-3xl bg-slate-900 border border-slate-800 p-5 shadow-md space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="h-36 rounded-2xl overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1596401057633-54a8fe8ef647?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover">
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 font-bold text-[10px]">
                                Desa Binaan
                            </span>
                        </div>
                        <h3 class="text-lg font-black text-white">Desa Berkah Mandiri</h3>
                        <p class="text-xs text-slate-400 line-clamp-2">Lembang, Bandung Barat. Agrowisata sayur mayur dan peternakan terpadu.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'berkah-mandiri') }}" class="w-full py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs text-center transition">
                        Buka Portal Berkah →
                    </a>
                </div>

                <!-- Mekar Jaya -->
                <div class="rounded-3xl bg-slate-900 border border-slate-800 p-5 shadow-md space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="h-36 rounded-2xl overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover">
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 font-bold text-[10px]">
                                Desa Binaan
                            </span>
                        </div>
                        <h3 class="text-lg font-black text-white">Desa Mekar Jaya</h3>
                        <p class="text-xs text-slate-400 line-clamp-2">Tarogong Kaler, Garut. Kerajinan kulit, dodol tradisional, dan sumber air panas.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'mekar-jaya') }}" class="w-full py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs text-center transition">
                        Buka Portal Mekar Jaya →
                    </a>
                </div>

                <!-- Ciburial -->
                <div class="rounded-3xl bg-slate-900 border border-slate-800 p-5 shadow-md space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="h-36 rounded-2xl overflow-hidden relative">
                            <img src="https://images.unsplash.com/photo-1576085898323-218337e3e43c?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover">
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 font-bold text-[10px]">
                                Desa Binaan
                            </span>
                        </div>
                        <h3 class="text-lg font-black text-white">Desa Ciburial</h3>
                        <p class="text-xs text-slate-400 line-clamp-2">Cimenyan, Bandung. Wisata tebing keraton, kebun pinus, dan kopi bukit.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'ciburial') }}" class="w-full py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-white font-bold text-xs text-center transition">
                        Buka Portal Ciburial →
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- Testimonials / Stakeholder Quotes -->
    <section class="py-20 bg-slate-950 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest block">Suara dari Lapangan</span>
                <h2 class="text-3xl sm:text-4xl font-black text-white mt-1">Dipercaya Kampus, Dosen, dan Aparatur Desa</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-4">
                    <p class="text-xs text-slate-300 leading-relaxed italic">
                        "Dengan KKN Digital Village OS, kami sebagai pemerintah desa tidak perlu menyewa vendor ratusan juta. Hasil kerja mahasiswa langsung jadi website resmi yang siap kami kelola terus."
                    </p>
                    <div class="pt-3 border-t border-slate-800 flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">S</div>
                        <div>
                            <span class="font-bold text-xs text-white block">Bapak H. Suryana, S.Sos</span>
                            <span class="text-[10px] text-emerald-400">Kepala Desa Sukamaju</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-4">
                    <p class="text-xs text-slate-300 leading-relaxed italic">
                        "Sebagai DPL, saya bisa mereview produk UMKM, warta desa, dan tugas harian mahasiswa dari satu dashboard tanpa harus menagih via WhatsApp setiap malam."
                    </p>
                    <div class="pt-3 border-t border-slate-800 flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-sm">R</div>
                        <div>
                            <span class="font-bold text-xs text-white block">Prof. Dr. Rina Kusuma</span>
                            <span class="text-[10px] text-teal-400">Dosen Pembimbing Lapangan</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 rounded-3xl bg-slate-900 border border-slate-800 space-y-4">
                    <p class="text-xs text-slate-300 leading-relaxed italic">
                        "Kopi lereng kami sekarang ada fotonya, ada deskripsinya, dan orang Jakarta langsung chat WhatsApp pesan cold brew dan biji sangrai. Sangat membantu!"
                    </p>
                    <div class="pt-3 border-t border-slate-800 flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-amber-600 text-white flex items-center justify-center font-bold text-sm">J</div>
                        <div>
                            <span class="font-bold text-xs text-white block">Pak Joko Widodo</span>
                            <span class="text-[10px] text-amber-400">Pemilik Kopi Lereng Sukamaju</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom Call To Action -->
    <section class="py-20 bg-gradient-to-b from-slate-950 to-emerald-950/40 border-t border-slate-800 text-center">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                Siap Mentransformasi KKN di Kampus & Desa Anda?
            </h2>
            <p class="text-sm sm:text-base text-slate-300 max-w-xl mx-auto leading-relaxed">
                Bergabunglah bersama ribuan mahasiswa dan puluhan desa yang telah merasakan manfaat nyata digitalisasi terpadu.
            </p>
            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('public.village.home', 'sukamaju') }}" 
                   class="px-8 py-4 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black text-sm shadow-xl shadow-emerald-500/25 hover:scale-102 transition">
                    Lihat Langsung Portal Desa Sukamaju →
                </a>
                <a href="{{ route('login') }}" 
                   class="px-8 py-4 rounded-2xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-sm border border-slate-700 transition hover:scale-102">
                    Masuk Akun Pengguna
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-950 border-t border-slate-800/80 text-slate-400 text-xs py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-500 flex items-center justify-center text-slate-950 font-black text-sm">
                    D
                </div>
                <span class="font-extrabold text-white text-sm">KKN Digital Village OS</span>
            </div>
            <p>&copy; {{ date('Y') }} KKN Digital Village OS Platform. Hak Cipta Dilindungi.</p>
            <div class="flex items-center space-x-6">
                <a href="{{ route('public.village.home', 'sukamaju') }}" class="hover:text-emerald-400 transition">Desa Sukamaju</a>
                <a href="{{ route('login') }}" class="hover:text-emerald-400 transition">Login</a>
                <a href="{{ route('register') }}" class="hover:text-emerald-400 transition">Register</a>
            </div>
        </div>
    </footer>

</body>
</html>
