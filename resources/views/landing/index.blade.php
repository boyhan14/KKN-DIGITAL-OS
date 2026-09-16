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
<body class="bg-white text-slate-800 antialiased selection:bg-emerald-500 selection:text-white" x-data="{ mobileNav: false, activeTab: 'portal' }">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-white/90 backdrop-blur-xl border-b border-slate-200/80 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                
                <!-- Brand Logo -->
                <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-600 to-teal-500 flex items-center justify-center text-white font-black shadow-md shadow-emerald-600/20 group-hover:scale-105 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <span class="font-extrabold text-xl text-slate-900 tracking-tight block leading-none">Digital Village OS</span>
                        <span class="text-[11px] font-bold text-emerald-700">KKN to Village Digitalization</span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <div class="hidden md:flex items-center space-x-8 text-sm font-semibold text-slate-600">
                    <a href="#masalah" class="hover:text-emerald-700 transition">Problem</a>
                    <a href="#demo-live" class="hover:text-emerald-700 transition">Live Preview</a>
                    <a href="#desa-binaan" class="hover:text-emerald-700 transition">Desa Binaan</a>
                    <a href="#testimoni" class="hover:text-emerald-700 transition">Testimoni</a>
                    <a href="{{ route('public.village.home', 'sukamaju') }}" class="px-3.5 py-1.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200/80 hover:bg-emerald-100 transition font-bold text-xs">
                        🌟 Demo Sukamaju
                    </a>
                </div>

                <!-- Right Actions -->
                <div class="hidden sm:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-600/20 transition hover:scale-102">
                            Buka Workspace →
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-bold text-slate-700 hover:text-emerald-700 transition">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-600/20 transition hover:scale-102">
                            Mulai KKN
                        </a>
                    @endauth
                </div>

                <!-- Mobile Hamburger -->
                <div class="md:hidden">
                    <button @click="mobileNav = !mobileNav" class="p-2 text-slate-600 hover:text-slate-900">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Drawer -->
        <div x-show="mobileNav" class="md:hidden border-b border-slate-200 bg-white px-4 py-4 space-y-2 text-sm font-medium shadow-lg" style="display: none;">
            <a href="#masalah" class="block py-2 text-slate-700 font-semibold">Problem</a>
            <a href="#demo-live" class="block py-2 text-slate-700 font-semibold">Live Preview</a>
            <a href="#desa-binaan" class="block py-2 text-slate-700 font-semibold">Desa Binaan</a>
            <a href="#testimoni" class="block py-2 text-slate-700 font-semibold">Testimoni</a>
            <a href="{{ route('public.village.home', 'sukamaju') }}" class="block py-2 text-emerald-700 font-bold">Jelajahi Demo Desa Sukamaju</a>
            <div class="pt-2 border-t border-slate-100 flex flex-col space-y-2">
                <a href="{{ route('login') }}" class="text-center py-2 text-slate-700 font-bold">Masuk</a>
                <a href="{{ route('register') }}" class="text-center py-2.5 bg-emerald-600 text-white font-bold rounded-xl shadow-xs">Mulai KKN</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative overflow-hidden pt-16 pb-20 lg:pt-24 lg:pb-28 bg-gradient-to-b from-emerald-50/70 via-slate-50/50 to-white border-b border-slate-200/80">
        
        <!-- Subtle Pattern Backdrop -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#0596690a_1px,transparent_1px),linear-gradient(to_bottom,#0596690a_1px,transparent_1px)] bg-[size:32px_32px]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            <!-- Hero Pill Badge -->
            <div class="inline-flex items-center space-x-2 px-4 py-1.5 rounded-full bg-emerald-100/80 text-emerald-900 text-xs font-extrabold border border-emerald-300/60 mb-8 shadow-xs">
                <span class="w-2 h-2 rounded-full bg-emerald-600 animate-pulse"></span>
                <span>Platform KKN Multi-Tenant & Digitalisasi Desa Terpadu di Indonesia</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight leading-[1.15] max-w-5xl mx-auto text-slate-900">
                Dari Program KKN, Menjadi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-700 via-teal-600 to-emerald-800">Digitalisasi Desa.</span>
            </h1>

            <!-- Subtitle -->
            <p class="mt-6 text-lg sm:text-xl text-slate-600 max-w-3xl mx-auto leading-relaxed font-normal">
                Satu platform terintegrasi untuk mengelola seluruh aktivitas KKN mahasiswa, mendata UMKM lokal, memetakan potensi spasial desa, dan otomatis mewariskan website resmi yang tetap hidup setelah mahasiswa ditarik pulang.
            </p>

            <!-- CTA Buttons -->
            <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('public.village.home', 'sukamaju') }}" 
                   class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-base shadow-lg shadow-emerald-600/25 hover:scale-102 transition flex items-center justify-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>Jelajahi Demo Desa Sukamaju</span>
                </a>

                <a href="{{ route('login') }}" 
                   class="w-full sm:w-auto px-8 py-4 rounded-2xl bg-white hover:bg-slate-50 text-slate-800 font-bold text-base border border-slate-300 shadow-xs flex items-center justify-center space-x-2 transition hover:scale-102">
                    <span>Masuk ke Workspace KKN →</span>
                </a>
            </div>

            <!-- Platform Highlights Stats Cards -->
            <div class="mt-16 pt-10 border-t border-slate-200/80 max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 text-center">
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs hover:shadow-md transition">
                    <div class="text-3xl sm:text-4xl font-black text-slate-900">{{ $stats['total_villages'] > 0 ? $stats['total_villages'] : '5' }}</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Desa Terhubung</div>
                </div>
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs hover:shadow-md transition">
                    <div class="text-3xl sm:text-4xl font-black text-emerald-700">{{ $stats['total_umkm'] > 0 ? $stats['total_umkm'] : '10' }}</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">UMKM Terdigitalisasi</div>
                </div>
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs hover:shadow-md transition">
                    <div class="text-3xl sm:text-4xl font-black text-slate-900">{{ $stats['total_programs'] > 0 ? $stats['total_programs'] : '6' }}</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Program Nyata</div>
                </div>
                <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs hover:shadow-md transition">
                    <div class="text-3xl sm:text-4xl font-black text-teal-700">100%</div>
                    <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mt-1">Digital Handover</div>
                </div>
            </div>

        </div>
    </header>

    <!-- Interactive Live Product Showcase Preview Frame -->
    <section id="demo-live" class="py-20 lg:py-28 bg-slate-50 relative z-20 border-b border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-10">
                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold uppercase tracking-wider border border-emerald-200">
                    Interactive Live Architecture
                </span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-3 tracking-tight">
                    Satu Sistem, Tiga Lapisan Ekosistem Desa
                </h2>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                    Klik tab di bawah untuk melihat bagaimana KKN Digital Village OS bekerja menghubungkan mahasiswa, publik warga, dan serah terima perangkat desa.
                </p>

                <!-- Interactive Tab Switcher -->
                <div class="mt-8 inline-flex p-1.5 rounded-2xl bg-white border border-slate-300 shadow-sm">
                    <button @click="activeTab = 'portal'" 
                            :class="activeTab === 'portal' ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                            class="px-5 py-2.5 rounded-xl text-xs transition flex items-center space-x-2 cursor-pointer">
                        <span>🌐 1. Portal Publik Desa</span>
                    </button>
                    <button @click="activeTab = 'workspace'" 
                            :class="activeTab === 'workspace' ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                            class="px-5 py-2.5 rounded-xl text-xs transition flex items-center space-x-2 cursor-pointer">
                        <span>📋 2. Workspace & Kanban</span>
                    </button>
                    <button @click="activeTab = 'handover'" 
                            :class="activeTab === 'handover' ? 'bg-emerald-600 text-white font-bold shadow-sm' : 'text-slate-600 hover:text-slate-900 font-semibold'"
                            class="px-5 py-2.5 rounded-xl text-xs transition flex items-center space-x-2 cursor-pointer">
                        <span>📜 3. Sertifikat Handover</span>
                    </button>
                </div>
            </div>

            <!-- Browser Mockup Window -->
            <div class="rounded-3xl border border-slate-300/80 bg-white shadow-xl overflow-hidden">
                <!-- Browser Header Bar -->
                <div class="px-6 py-3.5 bg-slate-100 border-b border-slate-200 flex items-center justify-between text-xs">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-400"></span>
                        <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                    </div>
                    <div class="px-6 py-1 rounded-lg bg-white border border-slate-200 font-mono text-[11px] text-slate-600 text-center max-w-md w-full truncate shadow-2xs">
                        <span x-show="activeTab === 'portal'">https://desakita.id/desa/sukamaju</span>
                        <span x-show="activeTab === 'workspace'" style="display: none;">https://desakita.id/workspace/group/1/programs</span>
                        <span x-show="activeTab === 'handover'" style="display: none;">https://desakita.id/desa/sukamaju/handover</span>
                    </div>
                    <div class="text-[10px] text-emerald-700 font-mono font-bold flex items-center space-x-1">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span>LIVE SIMULATION</span>
                    </div>
                </div>

                <!-- Tab 1: Portal Publik View Preview -->
                <div x-show="activeTab === 'portal'" class="p-6 sm:p-10 bg-white space-y-8">
                    <div class="rounded-2xl overflow-hidden relative border border-slate-200 shadow-sm">
                        <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1600&auto=format&fit=crop" 
                             alt="Desa Sukamaju Preview" class="w-full h-64 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/50 to-transparent p-6 sm:p-8 flex flex-col justify-end">
                            <span class="text-xs text-emerald-300 font-bold uppercase tracking-wider">Portal Resmi Terintegrasi</span>
                            <h3 class="text-2xl sm:text-3xl font-black text-white mt-1">Pemerintah Desa Sukamaju</h3>
                            <p class="text-xs sm:text-sm text-slate-200 max-w-lg mt-1 leading-relaxed">Website desa responsif dengan etalase 10 UMKM kopi, keripik, madu, dan anyaman bambu terhubung pesan WhatsApp langsung.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center space-x-3.5 hover:bg-emerald-50/50 transition">
                            <img src="https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=200&auto=format&fit=crop" class="w-14 h-14 rounded-xl object-cover shadow-xs">
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Kopi Lereng Sukamaju</h4>
                                <span class="text-[11px] text-emerald-700 font-bold block">Arabika Specialty 200g</span>
                                <span class="text-[10px] text-slate-500">Pesan langsung via WhatsApp</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center space-x-3.5 hover:bg-emerald-50/50 transition">
                            <img src="https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?q=80&w=200&auto=format&fit=crop" class="w-14 h-14 rounded-xl object-cover shadow-xs">
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Curug Sukamaju Indah</h4>
                                <span class="text-[11px] text-teal-700 font-bold block">Wisata Air Terjun 25m</span>
                                <span class="text-[10px] text-slate-500">Tiket Masuk: Rp 15.000</span>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center space-x-3.5 hover:bg-emerald-50/50 transition">
                            <div class="w-14 h-14 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-2xl shadow-xs">🗺️</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">Peta Spasial GIS</h4>
                                <span class="text-[11px] text-emerald-700 font-bold block">21 Titik Koordinat Aktif</span>
                                <span class="text-[10px] text-slate-500">Fasilitas, SD, Posyandu, UMKM</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab 2: Workspace KKN Preview -->
                <div x-show="activeTab === 'workspace'" class="p-6 sm:p-10 bg-white space-y-6" style="display: none;">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div>
                            <span class="text-xs text-emerald-700 font-bold uppercase tracking-wider">Kelompok KKN 14 — Desa Sukamaju</span>
                            <h3 class="text-xl font-black text-slate-900 mt-0.5">Kanban Program Kerja Digitalisasi UMKM</h3>
                        </div>
                        <span class="px-3.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-200">
                            Progres: 100% Selesai
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                            <span class="font-bold text-slate-600 block">TODO (0)</span>
                            <div class="p-3 rounded-xl bg-white text-slate-400 border border-slate-200/80 shadow-2xs">Semua tugas awal telah tuntas.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-blue-50/50 border border-blue-200/70 space-y-2">
                            <span class="font-bold text-blue-700 block">IN PROGRESS (0)</span>
                            <div class="p-3 rounded-xl bg-white text-slate-400 border border-slate-200/80 shadow-2xs">Tidak ada tanggungan tugas.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-amber-50/50 border border-amber-200/70 space-y-2">
                            <span class="font-bold text-amber-700 block">REVIEW DPL (0)</span>
                            <div class="p-3 rounded-xl bg-white text-slate-400 border border-slate-200/80 shadow-2xs">Semua luaran disetujui Dosen.</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-emerald-50/60 border border-emerald-200 space-y-2">
                            <span class="font-bold text-emerald-800 block">DONE (4)</span>
                            <div class="p-3 rounded-xl bg-white border border-emerald-200 text-slate-700 font-medium shadow-2xs">✓ Sesi foto produk 10 UMKM</div>
                            <div class="p-3 rounded-xl bg-white border border-emerald-200 text-slate-700 font-medium shadow-2xs">✓ Integrasi WhatsApp & QRIS</div>
                        </div>
                    </div>
                </div>

                <!-- Tab 3: Handover Certificate Preview -->
                <div x-show="activeTab === 'handover'" class="p-6 sm:p-10 bg-white text-center space-y-4" style="display: none;">
                    <div class="max-w-md mx-auto p-6 rounded-3xl bg-slate-50 border border-amber-300 shadow-lg space-y-3">
                        <div class="w-12 h-12 mx-auto rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center text-2xl shadow-xs">📜</div>
                        <h4 class="text-base font-black text-slate-900">BERITA ACARA SERAH TERIMA ASET DIGITAL</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Aset website, database 10 UMKM, peta GIS, dan akun admin resmi diwariskan ke Pemerintah Desa Sukamaju.
                        </p>
                        <div class="pt-3 border-t border-slate-200 flex items-center justify-around text-[11px] text-slate-600">
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
    <section id="masalah" class="py-20 lg:py-28 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block">Paradigma Baru KKN Indonesia</span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-2 tracking-tight">
                    Mengapa KKN Konvensional Sering Menjadi Sia-Sia?
                </h2>
                <p class="text-sm text-slate-600 mt-3 leading-relaxed">
                    Setiap tahun ratusan ribu mahasiswa diterjunkan ke desa. Namun mengapa setelah penarikan mahasiswa, tidak ada jejak teknologi yang bertahan?
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
                <!-- Red Pain Point Card -->
                <div class="p-8 sm:p-10 rounded-3xl bg-rose-50/70 border border-rose-200 shadow-xs space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-rose-600 text-white flex items-center justify-center font-black text-lg shadow-sm">✗</div>
                        <div>
                            <h3 class="text-xl font-black text-rose-950">KKN Konvensional Biasa</h3>
                            <span class="text-xs text-rose-700 font-medium">Pola Lama yang Terulang Tiap Periode</span>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm text-slate-700">
                        <li class="flex items-start">
                            <span class="text-rose-600 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>Laporan Berakhir di Rak:</strong> Observasi dan data potensi desa dicetak tebal menjadi laporan kertas yang tak pernah dibaca kembali oleh perangkat desa.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-rose-600 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>Website Mahasiswa Mati:</strong> Dibuat di platform blog gratisan, tidak diurus setelah mahasiswa pulang, dan password terkunci di email pribadi.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-rose-600 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>UMKM Bingung Lanjut:</strong> Foto produk hanya ditempel di spanduk posko tanpa sistem katalog digital yang bisa menerima pesanan berkelanjutan.</span>
                        </li>
                    </ul>
                </div>

                <!-- Emerald Solution Card -->
                <div class="p-8 sm:p-10 rounded-3xl bg-emerald-50/70 border border-emerald-200 shadow-xs space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center font-black text-lg shadow-sm">✓</div>
                        <div>
                            <h3 class="text-xl font-black text-emerald-950">Dengan KKN Digital Village OS</h3>
                            <span class="text-xs text-emerald-700 font-bold">Transformasi Menjadi Smart Village Berkelanjutan</span>
                        </div>
                    </div>

                    <ul class="space-y-4 text-sm text-slate-700">
                        <li class="flex items-start">
                            <span class="text-emerald-700 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>Otomatis Lahirkan Portal Desa:</strong> Input observasi mahasiswa langsung tertata menjadi website publik desa resmi dengan foto high-res dan navigasi lengkap.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-700 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>Etalase UMKM Terhubung WhatsApp:</strong> Pembeli bisa memesan produk langsung ke kontak WhatsApp pelaku usaha tanpa potongan komisi.</span>
                        </li>
                        <li class="flex items-start">
                            <span class="text-emerald-700 font-bold mr-2 text-lg leading-none">•</span>
                            <span><strong>Garansi Digital Handover 100%:</strong> Serah terima resmi dengan Berita Acara BA-KKN, modul panduan tertulis, dan akun admin mandiri untuk desa.</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </section>

    <!-- Multi-Tenant Showcase Villages Section -->
    <section id="desa-binaan" class="py-20 lg:py-28 bg-slate-50 border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block">Multi-Tenant Ecosystem</span>
                    <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-1 tracking-tight">Desa Binaan & Digital Showcase</h2>
                </div>
                <p class="text-xs text-slate-600 max-w-md">
                    Setiap desa memiliki portal terisolasi, tema unik, dan basis data terlindungi yang mandiri.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Sukamaju Showcase -->
                <div class="rounded-3xl bg-white border-2 border-emerald-500/80 p-5 shadow-md hover:shadow-xl transition space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="h-40 rounded-2xl overflow-hidden relative shadow-xs">
                            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover">
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full bg-emerald-600 text-white font-extrabold text-[10px] shadow-xs">
                                🌟 Showcase Utama
                            </span>
                        </div>
                        <h3 class="text-lg font-black text-slate-900">Desa Sukamaju</h3>
                        <p class="text-xs text-slate-600 line-clamp-2">Cisarua, Bogor. Sentra kopi arabika pegunungan, curug alami, dan kerajinan bambu.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'sukamaju') }}" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs text-center transition shadow-xs">
                        Buka Portal Sukamaju →
                    </a>
                </div>

                <!-- Berkah Mandiri -->
                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-xs hover:shadow-lg transition space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="h-40 rounded-2xl overflow-hidden relative shadow-xs">
                            <img src="https://images.unsplash.com/photo-1596401057633-54a8fe8ef647?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover">
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] border border-slate-200">
                                Desa Binaan
                            </span>
                        </div>
                        <h3 class="text-lg font-black text-slate-900">Desa Berkah Mandiri</h3>
                        <p class="text-xs text-slate-600 line-clamp-2">Lembang, Bandung Barat. Agrowisata sayur mayur dan peternakan terpadu.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'berkah-mandiri') }}" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs text-center transition">
                        Buka Portal Berkah →
                    </a>
                </div>

                <!-- Mekar Jaya -->
                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-xs hover:shadow-lg transition space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="h-40 rounded-2xl overflow-hidden relative shadow-xs">
                            <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover">
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] border border-slate-200">
                                Desa Binaan
                            </span>
                        </div>
                        <h3 class="text-lg font-black text-slate-900">Desa Mekar Jaya</h3>
                        <p class="text-xs text-slate-600 line-clamp-2">Tarogong Kaler, Garut. Kerajinan kulit, dodol tradisional, dan sumber air panas.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'mekar-jaya') }}" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs text-center transition">
                        Buka Portal Mekar Jaya →
                    </a>
                </div>

                <!-- Ciburial -->
                <div class="rounded-3xl bg-white border border-slate-200 p-5 shadow-xs hover:shadow-lg transition space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="h-40 rounded-2xl overflow-hidden relative shadow-xs">
                            <img src="https://images.unsplash.com/photo-1576085898323-218337e3e43c?q=80&w=800&auto=format&fit=crop" class="w-full h-full object-cover">
                            <span class="absolute top-2.5 right-2.5 px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 font-bold text-[10px] border border-slate-200">
                                Desa Binaan
                            </span>
                        </div>
                        <h3 class="text-lg font-black text-slate-900">Desa Ciburial</h3>
                        <p class="text-xs text-slate-600 line-clamp-2">Cimenyan, Bandung. Wisata tebing keraton, kebun pinus, dan kopi bukit.</p>
                    </div>
                    <a href="{{ route('public.village.home', 'ciburial') }}" class="w-full py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs text-center transition">
                        Buka Portal Ciburial →
                    </a>
                </div>

            </div>

        </div>
    </section>

    <!-- Testimonials / Stakeholder Quotes -->
    <section id="testimoni" class="py-20 lg:py-28 bg-white border-t border-slate-200/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block">Suara dari Lapangan</span>
                <h2 class="text-3xl sm:text-4xl font-black text-slate-900 mt-1">Dipercaya Kampus, Dosen, dan Aparatur Desa</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-7 rounded-3xl bg-slate-50 border border-slate-200/80 shadow-xs space-y-4 hover:shadow-md transition">
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">
                        "Dengan KKN Digital Village OS, kami sebagai pemerintah desa tidak perlu menyewa vendor ratusan juta. Hasil kerja mahasiswa langsung jadi website resmi yang siap kami kelola terus."
                    </p>
                    <div class="pt-4 border-t border-slate-200/60 flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm shadow-xs">S</div>
                        <div>
                            <span class="font-bold text-xs text-slate-900 block">Bapak H. Suryana, S.Sos</span>
                            <span class="text-[11px] text-emerald-700 font-medium">Kepala Desa Sukamaju</span>
                        </div>
                    </div>
                </div>

                <div class="p-7 rounded-3xl bg-slate-50 border border-slate-200/80 shadow-xs space-y-4 hover:shadow-md transition">
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">
                        "Sebagai DPL, saya bisa mereview produk UMKM, warta desa, dan tugas harian mahasiswa dari satu dashboard tanpa harus menagih via WhatsApp setiap malam."
                    </p>
                    <div class="pt-4 border-t border-slate-200/60 flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-sm shadow-xs">R</div>
                        <div>
                            <span class="font-bold text-xs text-slate-900 block">Prof. Dr. Rina Kusuma</span>
                            <span class="text-[11px] text-teal-700 font-medium">Dosen Pembimbing Lapangan</span>
                        </div>
                    </div>
                </div>

                <div class="p-7 rounded-3xl bg-slate-50 border border-slate-200/80 shadow-xs space-y-4 hover:shadow-md transition">
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed italic">
                        "Kopi lereng kami sekarang ada fotonya, ada deskripsinya, dan orang Jakarta langsung chat WhatsApp pesan cold brew dan biji sangrai. Sangat membantu penjualan warga!"
                    </p>
                    <div class="pt-4 border-t border-slate-200/60 flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-amber-600 text-white flex items-center justify-center font-bold text-sm shadow-xs">J</div>
                        <div>
                            <span class="font-bold text-xs text-slate-900 block">Pak Joko Widodo</span>
                            <span class="text-[11px] text-amber-700 font-medium">Pemilik Kopi Lereng Sukamaju</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom Call To Action Banner -->
    <section class="py-20 bg-gradient-to-br from-emerald-800 via-teal-900 to-emerald-950 text-white text-center relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_var(--tw-gradient-stops))] from-white/10 via-transparent to-transparent opacity-60"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 relative z-10">
            <h2 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                Siap Mentransformasi KKN di Kampus & Desa Anda?
            </h2>
            <p class="text-sm sm:text-base text-emerald-100/90 max-w-xl mx-auto leading-relaxed">
                Bergabunglah bersama ribuan mahasiswa dan puluhan desa yang telah merasakan manfaat nyata digitalisasi terpadu.
            </p>
            <div class="pt-4 flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('public.village.home', 'sukamaju') }}" 
                   class="px-8 py-4 rounded-2xl bg-white text-emerald-900 hover:bg-emerald-50 font-black text-sm shadow-xl hover:scale-102 transition">
                    Lihat Langsung Portal Desa Sukamaju →
                </a>
                <a href="{{ route('login') }}" 
                   class="px-8 py-4 rounded-2xl bg-emerald-900/60 hover:bg-emerald-900/90 text-white font-bold text-sm border border-emerald-400/40 transition hover:scale-102">
                    Masuk Akun Pengguna
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 text-xs py-12">
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
