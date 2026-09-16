<x-layouts.app :pageHeading="'Berita & Artikel CMS — Desa ' . $village->name">
    <div class="space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Pusat Publikasi Berita & Artikel Desa</h2>
                <p class="text-xs text-slate-500 mt-1">CMS terintegrasi untuk publikasi kabar desa, liputan kegiatan KKN, dan pengumuman warga.</p>
            </div>
            
            <div class="flex items-center space-x-2">
                @if(!$isLocked)
                    <a href="{{ route('village.articles.create', $village->id) }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tulis Artikel Baru</span>
                    </a>
                @endif
                <a href="{{ route('public.village.news', $village->slug) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center space-x-1">
                    <span>Lihat Halaman Berita</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>

        <!-- Articles Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($articles as $article)
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex flex-col justify-between hover:border-emerald-500/60 transition">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-[10px] font-bold">
                                {{ $article->category }}
                            </span>
                            @if($article->status === 'PUBLISHED')
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">✓ PUBLISHED</span>
                            @elseif($article->status === 'PENDING_REVIEW')
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">⏳ REVIEW</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">DRAFT</span>
                            @endif
                        </div>

                        <h3 class="text-base font-black text-slate-900 leading-snug">{{ $article->title }}</h3>
                        <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">{{ $article->excerpt }}</p>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                            <span>✍ {{ $article->author->name ?? 'Tim KKN' }}</span>
                            <span>{{ $article->created_at->format('d M Y') }}</span>
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        <a href="{{ route('village.articles.edit', ['village' => $village->id, 'article' => $article->id]) }}" class="font-bold text-emerald-600 hover:text-emerald-700">
                            Edit Artikel →
                        </a>
                        @if($article->status === 'DRAFT' && !$isLocked)
                            <form action="{{ route('village.articles.submit', ['village' => $village->id, 'article' => $article->id]) }}" method="POST">
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
                    <p class="text-sm font-bold text-slate-700">Belum ada berita atau artikel.</p>
                    <p class="text-xs text-slate-500 mt-1">Publikasikan dokumentasi liputan kegiatan KKN dan info desa.</p>
                </div>
            @endforelse
        </div>

    </div>
</x-layouts.app>

