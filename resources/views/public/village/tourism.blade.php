@extends('layouts.public', ['title' => 'Destinasi Wisata & Budaya', 'metaDescription' => 'Jelajahi potensi wisata alam, budaya, dan kearifan lokal di Desa ' . $village->name])

@section('content')
<!-- Hero Section -->
<div class="relative bg-emerald-900 text-white py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-800 text-emerald-200 border border-emerald-700/60 mb-4">
            Pesona Desa Nusantara
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4">
            Destinasi Wisata & Budaya Desa {{ $village->name }}
        </h1>
        <p class="text-lg text-emerald-100 max-w-2xl mx-auto font-light leading-relaxed">
            Nikmati keindahan lanskap alam, kearifan tradisi, dan keramahan warga desa yang asri dan memikat.
        </p>
    </div>
</div>

<!-- Main Listing Section -->
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Category Filter -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
            <a href="{{ route('public.village.tourism', $village->slug) }}" class="px-5 py-2.5 rounded-full text-sm font-semibold transition {{ !request()->filled('category') ? 'bg-emerald-700 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Semua Kategori
            </a>
            @foreach($categories as $category)
                <a href="{{ route('public.village.tourism', [$village->slug, 'category' => $category]) }}" class="px-5 py-2.5 rounded-full text-sm font-semibold transition {{ request()->query('category') === $category ? 'bg-emerald-700 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>

        @if($tourismPlaces->isEmpty())
            <div class="bg-white rounded-3xl p-12 border border-slate-200 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Destinasi</h3>
                <p class="text-slate-500 text-sm">Destinasi wisata untuk kategori ini belum dipublikasikan atau sedang dalam proses inventarisasi oleh tim KKN.</p>
                @if(request()->filled('category'))
                    <a href="{{ route('public.village.tourism', $village->slug) }}" class="mt-4 inline-block px-4 py-2 bg-emerald-700 text-white text-xs font-semibold rounded-xl hover:bg-emerald-800 transition">
                        Reset Filter
                    </a>
                @endif
            </div>
        @else
            <!-- Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($tourismPlaces as $place)
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col group">
                        <div class="relative aspect-16/10 bg-slate-100 overflow-hidden">
                            <img src="{{ $place->cover_image ?? $place->image_url ?? 'https://images.unsplash.com/photo-1432405972618-c60b0225b8f9?q=80&w=1000&auto=format&fit=crop' }}" 
                                 alt="{{ $place->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-emerald-800 shadow-sm">
                                    {{ $place->category }}
                                </span>
                            </div>
                            <div class="absolute top-4 right-4">
                                <span class="px-3 py-1 rounded-full text-xs font-black bg-teal-600/95 text-white backdrop-blur-md shadow-sm">
                                    {{ $place->ticket_price > 0 ? 'Rp ' . number_format($place->ticket_price, 0, ',', '.') : 'Gratis' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <h2 class="text-xl font-black text-slate-900 mb-2 group-hover:text-emerald-700 transition">
                                    {{ $place->name }}
                                </h2>
                                <p class="text-slate-600 text-sm line-clamp-3 leading-relaxed mb-4">
                                    {{ $place->description }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-slate-100 space-y-3">
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $place->opening_hours ?? 'Setiap Hari' }}
                                    </span>
                                    <span class="font-bold text-emerald-700 text-sm">
                                        {{ $place->ticket_price ? 'Rp ' . number_format($place->ticket_price, 0, ',', '.') : 'Gratis / Donasi' }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-2 pt-2">
                                    @if($place->latitude && $place->longitude)
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $place->latitude }},{{ $place->longitude }}" target="_blank" rel="noopener noreferrer" class="flex-1 py-2.5 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl text-xs font-bold transition">
                                            Rute Google Maps
                                        </a>
                                        <a href="{{ route('public.village.map', $village->slug) }}#spot-{{ $place->id }}" class="px-3 py-2.5 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 rounded-xl text-xs font-bold transition">
                                            Peta Desa
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Lokasi di Desa {{ $village->name }}</span>
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

