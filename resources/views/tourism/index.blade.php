<x-layouts.app :pageHeading="'Potensi Wisata — Desa ' . $village->name">
    <div class="space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Destinasi Wisata & Potensi Alam</h2>
                <p class="text-xs text-slate-500 mt-1">Dokumentasi objek wisata alam, budaya, dan kuliner Desa {{ $village->name }}.</p>
            </div>
            
            <div class="flex items-center space-x-2">
                @if(!$isLocked)
                    <a href="{{ route('village.tourism.create', $village->id) }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Wisata Baru</span>
                    </a>
                @endif
                <a href="{{ route('public.village.tourism', $village->slug) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center space-x-1">
                    <span>Lihat Halaman Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>

        <!-- Tourism Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($tourismPlaces as $tour)
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex flex-col justify-between hover:border-emerald-500/60 transition">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-teal-50 text-teal-800 text-[10px] font-bold border border-teal-200">
                                {{ $tour->category }}
                            </span>
                            @if($tour->status === 'PUBLISHED')
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">✓ PUBLISHED</span>
                            @elseif($tour->status === 'PENDING_REVIEW')
                                <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">⏳ REVIEW</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">DRAFT</span>
                            @endif
                        </div>

                        <h3 class="text-lg font-black text-slate-900 leading-snug">{{ $tour->name }}</h3>
                        <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">{{ $tour->description }}</p>

                        <div class="mt-4 pt-3 border-t border-slate-100 space-y-1 text-xs text-slate-500">
                            <div>🕒 {{ $tour->opening_hours ?? 'Setiap Hari' }}</div>
                            <div class="font-bold text-slate-800">
                                HTM: {{ $tour->ticket_price > 0 ? 'Rp ' . number_format($tour->ticket_price, 0, ',', '.') : 'Gratis' }}
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <a href="{{ route('village.tourism.edit', ['village' => $village->id, 'tourism' => $tour->id]) }}" class="font-bold text-emerald-600 hover:text-emerald-700">
                            Edit Data Wisata →
                        </a>
                        @if($tour->status === 'DRAFT' && !$isLocked)
                            <form action="{{ route('village.tourism.submit', ['village' => $village->id, 'tourism' => $tour->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-amber-700 hover:text-amber-900 font-bold">
                                    Ajukan Review
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 rounded-3xl bg-white border border-slate-200 text-center">
                    <p class="text-sm font-bold text-slate-700">Belum ada potensi wisata yang didata.</p>
                    <p class="text-xs text-slate-500 mt-1">Daftarkan objek wisata lokal desa agar tampil di direktori dan peta.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-layouts.app>

