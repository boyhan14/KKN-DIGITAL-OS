@extends('layouts.public', ['title' => 'Destinasi Wisata & Budaya', 'metaDescription' => 'Jelajahi potensi wisata alam, budaya, dan kearifan lokal di Desa ' . $village->name])

@section('content')
<!-- Hero Section with Ambient Glows -->
<div class="relative bg-gradient-to-r from-slate-950 via-emerald-950 to-slate-900 text-white py-20 overflow-hidden">
    <!-- Ambient Lights -->
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl animate-pulse-glow pointer-events-none"></div>
    <div class="absolute -bottom-10 left-1/4 w-80 h-80 bg-emerald-500/20 rounded-full blur-3xl animate-float pointer-events-none"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-flex items-center space-x-1.5 px-4 py-1.5 rounded-full text-xs font-extrabold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 backdrop-blur-md mb-4">
            <span class="w-2 h-2 rounded-full bg-emerald-400 radar-ping"></span>
            <span>Pesona Desa Nusantara</span>
        </span>
        <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight mb-4 drop-shadow-sm">
            Destinasi Wisata & Budaya Desa {{ $village->name }}
        </h1>
        <p class="text-base sm:text-lg text-emerald-100/90 max-w-2xl mx-auto font-normal leading-relaxed">
            Nikmati keindahan lanskap alam, kearifan tradisi, dan keramahan warga desa yang asri dan memikat.
        </p>
    </div>
</div>

<!-- Main Listing Section -->
<div class="py-14 bg-[#f8fafc] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Category Filter Pills -->
        <div class="flex flex-wrap items-center justify-center gap-2.5 mb-12">
            <a href="{{ route('public.village.tourism', $village->slug) }}" class="px-5 py-2.5 rounded-2xl text-xs font-extrabold transition {{ !request()->filled('category') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/80' }}">
                Semua Kategori
            </a>
            @foreach($categories as $category)
                <a href="{{ route('public.village.tourism', [$village->slug, 'category' => $category]) }}" class="px-5 py-2.5 rounded-2xl text-xs font-extrabold transition {{ request()->query('category') === $category ? 'bg-emerald-600 text-white shadow-md shadow-emerald-600/20' : 'bg-white text-slate-700 hover:bg-slate-50 border border-slate-200/80' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>

        @if($tourismPlaces->isEmpty())
            <div class="bg-white rounded-3xl p-12 border border-slate-200 text-center max-w-lg mx-auto shadow-sm">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">
                    🏞️
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Destinasi</h3>
                <p class="text-slate-500 text-xs leading-relaxed">Destinasi wisata untuk kategori ini belum dipublikasikan atau sedang dalam proses inventarisasi oleh tim KKN.</p>
                @if(request()->filled('category'))
                    <a href="{{ route('public.village.tourism', $village->slug) }}" class="mt-4 inline-block px-5 py-2.5 bg-emerald-600 text-white text-xs font-bold rounded-xl hover:bg-emerald-700 transition">
                        Reset Filter
                    </a>
                @endif
            </div>
        @else
            <!-- Tourism Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($tourismPlaces as $place)
                    <div class="card-lift bg-white rounded-3xl border border-slate-200/80 overflow-hidden shadow-md flex flex-col group">
                        <div class="relative aspect-16/10 bg-slate-100 overflow-hidden">
                            <img src="{{ $place->cover_image ?? $place->image_url ?? 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?q=80&w=1000&auto=format&fit=crop' }}" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-transparent to-transparent"></div>
                            
                            <div class="absolute top-4 left-4">
                                <span class="px-3.5 py-1.5 rounded-full text-[10px] font-extrabold uppercase tracking-wider bg-slate-900/80 backdrop-blur-md text-white shadow-sm">
                                    {{ $place->category }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3.5 py-1.5 rounded-full text-xs font-black bg-teal-600/95 text-white backdrop-blur-md shadow-md">
                                    {{ $place->ticket_price > 0 ? 'Rp ' . number_format($place->ticket_price, 0, ',', '.') : 'Gratis' }}
                                </span>
                            </div>
                            <div class="absolute bottom-3.5 left-4 text-xs text-white/95 font-semibold drop-shadow-xs flex items-center space-x-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span>{{ $place->opening_hours ?? 'Buka Setiap Hari' }}</span>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h2 class="text-xl font-black text-slate-900 mb-2 group-hover:text-emerald-700 transition leading-snug">
                                    {{ $place->name }}
                                </h2>
                                <p class="text-slate-600 text-xs line-clamp-3 leading-relaxed mb-4">
                                    {{ $place->description }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center text-slate-500 font-medium">
                                        🕒 {{ $place->opening_hours ?? 'Setiap Hari' }}
                                    </span>
                                    <span class="font-extrabold text-emerald-700">
                                        {{ $place->ticket_price ? 'Rp ' . number_format($place->ticket_price, 0, ',', '.') : 'Gratis / Donasi' }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 pt-2">
                                    @if($place->latitude && $place->longitude)
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $place->latitude }},{{ $place->longitude }}" target="_blank" rel="noopener noreferrer" 
                                           class="flex-1 py-2.5 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition flex items-center justify-center space-x-1">
                                            <span>🗺️ Google Maps</span>
                                        </a>
                                        <a href="{{ route('public.village.map', $village->slug) }}" 
                                           class="px-4 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl text-xs font-bold transition flex items-center space-x-1">
                                            <span>📍 Peta Desa</span>
                                        </a>
                                    @else
                                        <a href="{{ route('public.village.map', $village->slug) }}" 
                                           class="w-full py-2.5 text-center bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl text-xs font-bold transition">
                                            Lihat di Peta Desa
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $tourismPlaces->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
