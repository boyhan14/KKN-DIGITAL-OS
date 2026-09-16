<x-layouts.public :village="$village" :title="'Portal Resmi Pemerintah Desa ' . $village->name">
    <div class="space-y-16 lg:space-y-24 pb-20">
        
        <!-- Cinematic Panoramic Hero Section -->
        <section class="relative min-h-[580px] lg:min-h-[640px] flex items-center justify-center overflow-hidden bg-slate-950 text-white">
            <!-- Background Photography with Parallax-like Depth -->
            <div class="absolute inset-0 z-0">
                <img src="{{ $village->cover_image ?? 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1600&auto=format&fit=crop' }}" 
                     alt="Panorama Desa {{ $village->name }}" 
                     class="w-full h-full object-cover object-center scale-105 filter brightness-90 transform hover:scale-100 transition duration-1000 ease-out">
                <!-- Multi-layer Gradient Overlay for Pristine Contrast -->
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/75 to-slate-900/40"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-emerald-950/30 via-transparent to-transparent"></div>
            </div>

            <!-- Content Container -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10 text-center">
                
                <!-- Official Governance Badges -->
                <div class="flex flex-wrap items-center justify-center gap-2 mb-6">
                    <span class="inline-flex items-center space-x-2 px-3.5 py-1.5 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-xs font-bold backdrop-blur-md">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>Portal Resmi Pemerintah Desa {{ $village->name }}</span>
                    </span>
                    <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-full bg-white/10 text-slate-200 border border-white/15 text-xs font-semibold backdrop-blur-md">
                        <span>🇮🇩 Kec. {{ $village->district }}, Kab. {{ $village->regency }}</span>
                    </span>
                </div>

                <!-- Hero Title -->
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight leading-[1.1] max-w-4xl mx-auto drop-shadow-sm">
                    Harmoni Alam, Sentra UMKM, & Transparansi <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-emerald-200">Desa {{ $village->name }}</span>
                </h1>

                <!-- Hero Description -->
                <p class="mt-6 text-base sm:text-lg text-slate-300 max-w-2xl mx-auto leading-relaxed font-normal drop-shadow-xs">
                    {{ $village->description ?? ('Pusat informasi publik terpadu, direktori potensi ekonomi warga, destinasi wisata alam pegunungan, dan wujud nyata digitalisasi berkelanjutan Desa ' . $village->name . '.') }}
                </p>

                <!-- Quick Action Buttons -->
                <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('public.village.umkm', $village->slug) }}" 
                       class="px-7 py-3.5 rounded-2xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-extrabold text-sm shadow-lg shadow-emerald-500/25 hover:scale-102 transition duration-200">
                        Jelajahi UMKM Lokal
                    </a>
                    <a href="{{ route('public.village.tourism', $village->slug) }}" 
                       class="px-7 py-3.5 rounded-2xl bg-white/15 hover:bg-white/25 text-white font-bold text-sm border border-white/20 backdrop-blur-md shadow-sm hover:scale-102 transition duration-200">
                        Destinasi Wisata
                    </a>
                    <a href="{{ route('public.village.map', $village->slug) }}" 
                       class="px-7 py-3.5 rounded-2xl bg-white/15 hover:bg-white/25 text-white font-bold text-sm border border-white/20 backdrop-blur-md shadow-sm hover:scale-102 transition duration-200">
                        Peta Interaktif
                    </a>
                </div>

                <!-- Quick Stats Strip -->
                <div class="mt-14 max-w-4xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 text-center">
                    <div class="p-4 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <span class="text-2xl sm:text-3xl font-black text-emerald-400 block">{{ $village->publishedUmkms->count() }}</span>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider mt-0.5 block">UMKM Terdaftar</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <span class="text-2xl sm:text-3xl font-black text-teal-300 block">{{ $village->publishedTourismPlaces->count() }}</span>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider mt-0.5 block">Destinasi Wisata</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <span class="text-2xl sm:text-3xl font-black text-amber-300 block">{{ $impact['programs_completed'] ?? 6 }}</span>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider mt-0.5 block">Program Kerja</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-white/10 border border-white/10 backdrop-blur-md">
                        <span class="text-2xl sm:text-3xl font-black text-white block">{{ $impact['beneficiaries'] ?? 1500 }}+</span>
                        <span class="text-[11px] font-bold text-slate-300 uppercase tracking-wider mt-0.5 block">Warga Terlayani</span>
                    </div>
                </div>

            </div>
        </section>

        <!-- Floating Glassmorphic Quick-Access Service Dock -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-10 sm:-mt-14 relative z-20">
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                <a href="{{ route('public.village.umkm', $village->slug) }}" 
                   class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center group">
                    <div class="w-11 h-11 mx-auto rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl mb-2 group-hover:bg-emerald-600 group-hover:text-white transition">
                        🛍️
                    </div>
                    <span class="font-black text-xs text-slate-900 block group-hover:text-emerald-700 transition">Katalog UMKM</span>
                    <span class="text-[10px] text-slate-500">Pesan Langsung WA</span>
                </a>

                <a href="{{ route('public.village.tourism', $village->slug) }}" 
                   class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center group">
                    <div class="w-11 h-11 mx-auto rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl mb-2 group-hover:bg-teal-600 group-hover:text-white transition">
                        🏞️
                    </div>
                    <span class="font-black text-xs text-slate-900 block group-hover:text-teal-700 transition">Destinasi Wisata</span>
                    <span class="text-[10px] text-slate-500">Pesona Alam Desa</span>
                </a>

                <a href="{{ route('public.village.map', $village->slug) }}" 
                   class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center group">
                    <div class="w-11 h-11 mx-auto rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl mb-2 group-hover:bg-blue-600 group-hover:text-white transition">
                        🗺️
                    </div>
                    <span class="font-black text-xs text-slate-900 block group-hover:text-blue-700 transition">Peta Digital</span>
                    <span class="text-[10px] text-slate-500">Sebaran Fasilitas</span>
                </a>

                <a href="{{ route('public.village.news', $village->slug) }}" 
                   class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center group">
                    <div class="w-11 h-11 mx-auto rounded-xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-xl mb-2 group-hover:bg-indigo-600 group-hover:text-white transition">
                        📰
                    </div>
                    <span class="font-black text-xs text-slate-900 block group-hover:text-indigo-700 transition">Kabar & Warta</span>
                    <span class="text-[10px] text-slate-500">Informasi Desa</span>
                </a>

                <a href="{{ route('public.village.handover', $village->slug) }}" 
                   class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center group border-amber-200/80">
                    <div class="w-11 h-11 mx-auto rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl mb-2 group-hover:bg-amber-600 group-hover:text-white transition">
                        📜
                    </div>
                    <span class="font-black text-xs text-slate-900 block group-hover:text-amber-700 transition">Sertifikat KKN</span>
                    <span class="text-[10px] text-slate-500">Digital Handover</span>
                </a>

                <a href="{{ route('public.village.about', $village->slug) }}" 
                   class="p-4 sm:p-5 rounded-2xl bg-white border border-slate-200/80 shadow-md hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center group">
                    <div class="w-11 h-11 mx-auto rounded-xl bg-purple-50 text-purple-700 flex items-center justify-center text-xl mb-2 group-hover:bg-purple-600 group-hover:text-white transition">
                        🏛️
                    </div>
                    <span class="font-black text-xs text-slate-900 block group-hover:text-purple-700 transition">Profil & Balai</span>
                    <span class="text-[10px] text-slate-500">Visi & Struktur</span>
                </a>
            </div>
        </section>

        <!-- Featured UMKM Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block">Ekonomi Kreatif & Kerajinan</span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">Produk Unggulan UMKM Desa</h2>
                </div>
                <a href="{{ route('public.village.umkm', $village->slug) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center space-x-1 group">
                    <span>Lihat Semua {{ $village->publishedUmkms->count() }} UMKM</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($featuredUmkms as $u)
                    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:border-emerald-500/60 hover:shadow-xl transition-all duration-300 group">
                        <div>
                            <!-- Cover Photo with Badge -->
                            <div class="h-48 w-full overflow-hidden relative bg-slate-100">
                                <img src="{{ $u->cover_image ?? 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=800&auto=format&fit=crop' }}" 
                                     alt="{{ $u->business_name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
                                
                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider">
                                    {{ $u->category }}
                                </span>
                                
                                <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-emerald-600/90 backdrop-blur-md text-white text-[10px] font-bold">
                                    ✓ Terverifikasi
                                </span>

                                <span class="absolute bottom-2.5 left-3 text-[11px] font-semibold text-white drop-shadow-sm">
                                    {{ $u->products->count() }} Katalog Produk
                                </span>
                            </div>

                            <!-- Card Body -->
                            <div class="p-5">
                                <h3 class="text-lg font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition">
                                    <a href="{{ route('public.village.umkm.show', [$village->slug, $u->slug]) }}">
                                        {{ $u->business_name }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 flex items-center space-x-1">
                                    <span>👤 Pemilik:</span>
                                    <span class="font-semibold text-slate-700">{{ $u->owner_name }}</span>
                                </p>
                                <p class="text-xs text-slate-600 mt-2 line-clamp-2 leading-relaxed">
                                    {{ $u->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="p-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <a href="{{ route('public.village.umkm.show', [$village->slug, $u->slug]) }}" 
                               class="font-bold text-emerald-700 hover:text-emerald-900">
                                Detail & Menu →
                            </a>
                            @if($u->whatsapp_link)
                                <a href="{{ $u->whatsapp_link }}" target="_blank" 
                                   class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-xs transition flex items-center space-x-1.5">
                                    <span>💬 Chat WA</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center text-xs text-slate-500">
                        Belum ada UMKM yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Featured Tourism Section -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
                <div>
                    <span class="text-xs font-bold text-teal-700 uppercase tracking-widest block">Pesona Alam & Budaya</span>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">Destinasi Wisata Desa</h2>
                </div>
                <a href="{{ route('public.village.tourism', $village->slug) }}" class="text-xs font-bold text-teal-700 hover:text-teal-800 flex items-center space-x-1 group">
                    <span>Lihat Semua Wisata</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse($featuredTourism as $t)
                    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:border-teal-500/60 hover:shadow-xl transition-all duration-300 group">
                        <div>
                            <!-- Cover Photo -->
                            <div class="h-52 w-full overflow-hidden relative bg-slate-100">
                                <img src="{{ $t->cover_image ?? 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?q=80&w=1000&auto=format&fit=crop' }}" 
                                     alt="{{ $t->name }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out">
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent"></div>

                                <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider">
                                    {{ $t->category }}
                                </span>

                                <span class="absolute top-3 right-3 px-3 py-1 rounded-full bg-teal-600/95 backdrop-blur-md text-white text-xs font-black shadow-xs">
                                    {{ $t->ticket_price > 0 ? 'Rp ' . number_format($t->ticket_price, 0, ',', '.') : 'Gratis' }}
                                </span>

                                <div class="absolute bottom-3 left-3 text-xs text-white/90 drop-shadow-xs flex items-center space-x-1">
                                    <span>🕒 {{ $t->opening_hours ?? 'Buka Setiap Hari' }}</span>
                                </div>
                            </div>

                            <!-- Card Body -->
                            <div class="p-5">
                                <h3 class="text-lg font-black text-slate-900 leading-snug group-hover:text-teal-700 transition">
                                    <a href="{{ route('public.village.tourism', $village->slug) }}">
                                        {{ $t->name }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">
                                    {{ $t->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="p-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <a href="{{ route('public.village.tourism', $village->slug) }}" class="font-bold text-teal-700 hover:text-teal-900">
                                Detail & Rute Lokasi →
                            </a>
                            <a href="{{ route('public.village.map', $village->slug) }}" class="text-[11px] font-semibold text-slate-500 hover:text-slate-800">
                                📍 Buka di Peta
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 text-center text-xs text-slate-500">
                        Belum ada destinasi wisata yang dipublikasikan.
                    </div>
                @endforelse
            </div>
        </section>

        <!-- Latest News & Upcoming Events -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            <!-- Latest News (2 Cols) -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <div>
                        <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-widest block">Informasi Terpadu</span>
                        <h3 class="text-xl font-black text-slate-900">Kabar & Berita Desa</h3>
                    </div>
                    <a href="{{ route('public.village.news', $village->slug) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center space-x-1">
                        <span>Semua Kabar →</span>
                    </a>
                </div>

                <div class="space-y-4">
                    @foreach($latestArticles as $art)
                        <div class="p-4 sm:p-5 rounded-3xl bg-white border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-center gap-4 hover:border-emerald-500/60 hover:shadow-md transition group">
                            <!-- Thumbnail -->
                            <div class="w-full sm:w-36 h-28 shrink-0 rounded-2xl overflow-hidden relative bg-slate-100">
                                <img src="{{ $art->cover_image ?? 'https://images.unsplash.com/photo-1531482615713-2afd69097998?q=80&w=800&auto=format&fit=crop' }}" 
                                     alt="{{ $art->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>

                            <!-- Text Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2 text-[10px] text-slate-400 mb-1">
                                    <span class="font-bold text-emerald-700 uppercase">{{ $art->category }}</span>
                                    <span>&bull;</span>
                                    <span>{{ $art->published_at ? $art->published_at->translatedFormat('d M Y') : date('d M Y') }}</span>
                                </div>
                                <h4 class="text-base font-bold text-slate-900 group-hover:text-emerald-700 transition leading-snug line-clamp-1">
                                    <a href="{{ route('public.village.news.show', [$village->slug, $art->slug]) }}">
                                        {{ $art->title }}
                                    </a>
                                </h4>
                                <p class="text-xs text-slate-600 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $art->excerpt }}
                                </p>
                            </div>

                            <!-- Action -->
                            <a href="{{ route('public.village.news.show', [$village->slug, $art->slug]) }}" 
                               class="shrink-0 px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-700 font-bold text-xs transition self-end sm:self-center">
                                Baca →
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Upcoming Events (1 Col) -->
            <div class="space-y-6">
                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <div>
                        <span class="text-[10px] font-bold text-emerald-700 uppercase tracking-widest block">Kalender Warga</span>
                        <h3 class="text-xl font-black text-slate-900">Agenda Kegiatan</h3>
                    </div>
                    <a href="{{ route('public.village.events', $village->slug) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800">Semua Agenda →</a>
                </div>

                <div class="space-y-3">
                    @forelse($upcomingEvents as $ev)
                        <div class="p-4 rounded-2xl bg-white border border-slate-200/80 shadow-xs space-y-1 hover:border-emerald-400/60 transition">
                            <span class="text-[10px] font-bold text-emerald-700 uppercase block">
                                📅 {{ \Carbon\Carbon::parse($ev->date)->translatedFormat('d M Y') }}
                            </span>
                            <h4 class="text-sm font-bold text-slate-900 leading-snug">{{ $ev->title }}</h4>
                            <p class="text-xs text-slate-500 line-clamp-1">📍 {{ $ev->location }}</p>
                        </div>
                    @empty
                        <div class="p-6 text-center text-xs text-slate-400 bg-white rounded-2xl border border-slate-100">
                            Belum ada agenda terdekat.
                        </div>
                    @endforelse
                </div>
            </div>

        </section>

        <!-- Map Teaser Banner -->
        <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="p-8 sm:p-12 rounded-3xl bg-gradient-to-r from-slate-900 via-emerald-950 to-slate-900 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl relative overflow-hidden">
                <div class="space-y-2 relative z-10">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider">Pemetaan Spasial Desa {{ $village->name }}</span>
                    <h3 class="text-2xl sm:text-3xl font-black tracking-tight">Peta Digital & Sebaran Potensi Desa</h3>
                    <p class="text-xs sm:text-sm text-slate-300 max-w-xl leading-relaxed">
                        Temukan titik lokasi balai desa, sekolah, posyandu, sentra UMKM, dan spot wisata alam pada peta spasial digital interaktif.
                    </p>
                </div>
                <a href="{{ route('public.village.map', $village->slug) }}" 
                   class="relative z-10 shrink-0 px-8 py-4 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-black text-sm shadow-lg shadow-emerald-500/20 transition hover:scale-102">
                    Buka Peta Interaktif Desa →
                </a>
            </div>
        </section>

    </div>
</x-layouts.public>
