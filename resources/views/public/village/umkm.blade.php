<x-layouts.public :village="$village" :title="'Direktori UMKM — Desa ' . $village->name">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 space-y-10">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <span class="px-3.5 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold uppercase tracking-wider">
                🛍️ Ekonomi Kreatif & Sentra Usaha Warga
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Direktori UMKM Desa {{ $village->name }}</h1>
            <p class="text-slate-600 text-sm max-w-xl mx-auto leading-relaxed">
                Temukan dan dukung produk lokal berkualitas karya warga Desa {{ $village->name }}. Terhubung langsung dengan pengrajin dan petani melalui WhatsApp tanpa perantara.
            </p>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 sm:p-6 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Category Badges -->
            <div class="flex items-center space-x-2 overflow-x-auto w-full sm:w-auto pb-2 sm:pb-0 text-xs">
                <a href="{{ route('public.village.umkm', $village->slug) }}" 
                   class="px-4 py-2.5 rounded-xl font-bold transition whitespace-nowrap {{ !request('category') ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                    Semua Kategori
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('public.village.umkm', ['slug' => $village->slug, 'category' => $cat]) }}" 
                       class="px-4 py-2.5 rounded-xl font-bold transition whitespace-nowrap {{ request('category') === $cat ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <!-- Search Form -->
            <form action="{{ route('public.village.umkm', $village->slug) }}" method="GET" class="w-full sm:w-80">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama usaha atau produk..." 
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-xs focus:ring-2 focus:ring-emerald-500 outline-hidden bg-slate-50 focus:bg-white transition">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </form>
        </div>

        <!-- UMKM Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($umkms as $u)
                <div class="rounded-3xl bg-white border border-slate-200/80 shadow-xs overflow-hidden flex flex-col justify-between hover:border-emerald-500/60 hover:shadow-xl transition-all duration-300 group">
                    <div>
                        <!-- Cover Photo -->
                        <div class="h-48 w-full overflow-hidden relative bg-slate-100">
                            <img src="{{ $u->cover_image ?? 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?q=80&w=800&auto=format&fit=crop' }}" 
                                 alt="{{ $u->business_name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500 ease-out">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent"></div>
                            
                            <span class="absolute top-3 left-3 px-2.5 py-1 rounded-full bg-slate-900/80 backdrop-blur-md text-white text-[10px] font-extrabold uppercase tracking-wider">
                                {{ $u->category }}
                            </span>
                            
                            <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-emerald-600/90 backdrop-blur-md text-white text-[10px] font-bold">
                                ✓ Terverifikasi Desa
                            </span>

                            <span class="absolute bottom-2.5 left-3 text-[11px] font-semibold text-white drop-shadow-sm">
                                📦 {{ $u->products->count() }} Katalog Produk
                            </span>
                        </div>

                        <!-- Content -->
                        <div class="p-5">
                            <h3 class="text-xl font-black text-slate-900 leading-snug group-hover:text-emerald-700 transition">
                                <a href="{{ route('public.village.umkm.show', [$village->slug, $u->slug]) }}">
                                    {{ $u->business_name }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 mt-1 flex items-center space-x-1">
                                <span>👤 Pemilik:</span>
                                <strong class="text-slate-800">{{ $u->owner_name }}</strong>
                            </p>
                            <p class="text-xs text-slate-600 mt-2.5 line-clamp-2 leading-relaxed">
                                {{ $u->description }}
                            </p>
                            
                            @if($u->address)
                                <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-400 line-clamp-1 flex items-center space-x-1">
                                    <span>📍</span>
                                    <span>{{ $u->address }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Footer Actions -->
                    <div class="p-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <a href="{{ route('public.village.umkm.show', [$village->slug, $u->slug]) }}" 
                           class="font-bold text-emerald-700 hover:text-emerald-900">
                            Lihat Menu Produk →
                        </a>
                        @if($u->whatsapp_link)
                            <a href="{{ $u->whatsapp_link }}" target="_blank" 
                               class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-xs transition flex items-center space-x-1.5">
                                <span>💬 Pesan WhatsApp</span>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full p-16 text-center text-slate-500 bg-white rounded-3xl border border-slate-200">
                    <span class="text-3xl block mb-2">🔍</span>
                    <p class="font-bold text-slate-700">Tidak ada UMKM yang cocok dengan pencarian Anda.</p>
                    <p class="text-xs text-slate-400 mt-1">Coba gunakan kata kunci lain atau reset filter kategori.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $umkms->links() }}
        </div>

    </div>
</x-layouts.public>
