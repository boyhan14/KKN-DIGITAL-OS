<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Workspace' }} — KKN Digital Village OS</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="h-full antialiased text-slate-800 bg-slate-50 flex flex-col md:flex-row" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Backdrop -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 md:hidden" 
         @click="sidebarOpen = false" 
         style="display: none;"></div>

    <!-- Sidebar Navigation -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
           class="fixed inset-y-0 left-0 z-50 w-72 bg-emerald-950 text-white flex flex-col transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:inset-auto md:w-68 shrink-0 shadow-xl md:shadow-none">
        
        <!-- Brand Header -->
        <div class="p-5 border-b border-emerald-900/60 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center space-x-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-400 flex items-center justify-center text-white font-bold shadow-md shadow-emerald-500/20 group-hover:scale-105 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div>
                    <span class="font-extrabold text-lg tracking-tight text-white block leading-tight">Digital Village</span>
                    <span class="text-xs font-semibold text-emerald-400 tracking-wider uppercase">KKN OS</span>
                </div>
            </a>
            <button class="md:hidden text-slate-400 hover:text-white" @click="sidebarOpen = false">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <!-- Role Badge & Active Context -->
        <div class="px-5 py-3 bg-emerald-900/30 border-b border-emerald-900/40 text-xs">
            <div class="flex items-center justify-between">
                <span class="text-emerald-300/80 font-medium">Role:</span>
                <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-semibold border border-emerald-500/30">
                    {{ auth()->user()->role ?? 'USER' }}
                </span>
            </div>
            <div class="mt-1.5 truncate text-slate-300 font-medium">
                {{ auth()->user()->name }}
            </div>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-1 text-sm">
            @php
                $activeGroup = app(\App\Services\TenantService::class)->getUserGroup(auth()->user());
                $activeVillage = app(\App\Services\TenantService::class)->getUserVillage(auth()->user());
                $groupId = $activeGroup?->id;
                $villageId = $activeVillage?->id;
            @endphp

            @if(auth()->user()->isSuperAdmin() || auth()->user()->isCampusAdmin())
                <div class="px-3 pt-2 pb-1 text-xs font-semibold text-emerald-400/80 tracking-wider uppercase">Kampus</div>
                <a href="{{ route('campus.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('campus.dashboard') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                    Dashboard Kampus
                </a>
            @endif

            @if(auth()->user()->isSuperAdmin() || auth()->user()->isSupervisor())
                <div class="px-3 pt-3 pb-1 text-xs font-semibold text-emerald-400/80 tracking-wider uppercase">Dosen Pembimbing</div>
                <a href="{{ route('supervisor.dashboard') }}" class="flex items-center px-3 py-2.5 rounded-lg transition {{ request()->routeIs('supervisor.dashboard') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Antrean Review & Bimbingan
                </a>
            @endif

            @if($groupId)
                <div class="px-3 pt-3 pb-1 text-xs font-semibold text-emerald-400/80 tracking-wider uppercase">Kelompok KKN</div>
                <a href="{{ route('group.workspace', $groupId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('group.workspace') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    Overview Workspace
                </a>
                <a href="{{ route('group.programs.index', $groupId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('group.programs.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    Program Kerja & Kanban
                </a>
                <a href="{{ route('group.impact.index', $groupId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('group.impact.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    Impact Dashboard
                </a>
                <a href="{{ route('group.handover.index', $groupId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('group.handover.*') ? 'bg-amber-600 text-white font-semibold shadow-sm' : 'text-amber-300 hover:bg-amber-900/30' }}">
                    <svg class="w-5 h-5 mr-3 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                    Digital Handover
                </a>
                <a href="{{ route('group.documents.index', $groupId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('group.documents.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Repositori Luaran & Dokumen
                </a>
                <a href="{{ route('group.reports.index', $groupId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('group.reports.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Laporan KKN (PDF/Print)
                </a>
                <a href="{{ route('group.members', $groupId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('group.members') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    Anggota Kelompok
                </a>
            @endif

            @if($villageId)
                <div class="px-3 pt-3 pb-1 text-xs font-semibold text-emerald-400/80 tracking-wider uppercase">Data Desa & Digitalisasi</div>
                <a href="{{ route('village.profile.edit', $villageId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('village.profile.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Profil & Fasilitas Desa
                </a>
                <a href="{{ route('village.umkm.index', $villageId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('village.umkm.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    Direktori UMKM & Produk
                </a>
                <a href="{{ route('village.tourism.index', $villageId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('village.tourism.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Potensi Wisata
                </a>
                <a href="{{ route('village.map.index', $villageId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('village.map.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                    Peta Digital Interaktif
                </a>
                <a href="{{ route('village.events.index', $villageId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('village.events.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Agenda Kegiatan
                </a>
                <a href="{{ route('village.articles.index', $villageId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('village.articles.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    Berita & Artikel CMS
                </a>
                <a href="{{ route('village.gallery.index', $villageId) }}" class="flex items-center px-3 py-2 rounded-lg transition {{ request()->routeIs('village.gallery.*') ? 'bg-emerald-600 text-white font-semibold shadow-sm' : 'text-slate-300 hover:bg-emerald-900/40 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Galeri & Dokumentasi
                </a>
            @endif

            @if($activeVillage)
                <div class="pt-4 pb-2 px-3">
                    <a href="{{ route('public.village.home', $activeVillage->slug) }}" target="_blank" class="flex items-center justify-center space-x-2 px-3 py-2 rounded-lg bg-emerald-500/20 text-emerald-300 hover:bg-emerald-500/30 font-medium text-xs border border-emerald-500/30 transition">
                        <span>Lihat Website Publik Desa</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </div>
            @endif
        </nav>

        <!-- Logout Action -->
        <div class="p-4 border-t border-emerald-900/60">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 text-xs font-semibold text-rose-300 hover:text-white bg-rose-950/40 hover:bg-rose-900/60 rounded-lg border border-rose-900/40 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Keluar (Logout)
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Workspace Content Area -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <!-- Top Workspace Bar -->
        <header class="bg-white border-b border-slate-200 h-16 flex items-center justify-between px-4 sm:px-8 shrink-0">
            <div class="flex items-center space-x-3">
                <button class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100" @click="sidebarOpen = true">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-lg sm:text-xl font-bold text-slate-800 tracking-tight flex items-center space-x-2">
                    <span>{{ $pageHeading ?? 'Workspace KKN' }}</span>
                </h1>
            </div>

            <div class="flex items-center space-x-3 sm:space-x-4">
                @if($activeVillage)
                    <span class="hidden sm:inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5"></span>
                        Desa {{ $activeVillage->name }}
                    </span>
                @endif
                <div class="text-right hidden sm:block">
                    <div class="text-xs font-bold text-slate-700 leading-tight">{{ auth()->user()->name }}</div>
                    <div class="text-[11px] text-slate-500">{{ auth()->user()->email }}</div>
                </div>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mx-4 sm:mx-8 mt-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center justify-between shadow-xs">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
            </div>
        @endif

        @if($errors->any())
            <div class="mx-4 sm:mx-8 mt-4 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-xs">
                <div class="font-semibold mb-1">Terdapat beberapa kendala:</div>
                <ul class="list-disc list-inside space-y-0.5 text-xs text-rose-700">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Primary View Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-8 bg-slate-50/50">
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>

