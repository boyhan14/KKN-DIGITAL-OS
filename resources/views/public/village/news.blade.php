@extends('layouts.public', ['title' => 'Warta & Kabar Desa', 'metaDescription' => 'Berita terkini, publikasi kegiatan, dan informasi pembangunan Desa ' . $village->name])

@section('content')
<!-- Header -->
<div class="bg-gradient-to-b from-slate-100 to-white border-b border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 mb-3">
            Kabar & Informasi Terkini
        </span>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 mb-3">
            Warta Desa {{ $village->name }}
        </h1>
        <p class="text-slate-600 max-w-2xl mx-auto text-sm sm:text-base">
            Publikasi resmi transparansi kegiatan pemerintah desa, warta warga, serta liputan program kerja mahasiswa KKN.
        </p>
    </div>
</div>

<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Category Filter -->
        <div class="flex flex-wrap items-center justify-center gap-2 mb-10">
            <a href="{{ route('public.village.news', $village->slug) }}" class="px-5 py-2.5 rounded-full text-sm font-semibold transition {{ !request()->filled('category') ? 'bg-emerald-700 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                Semua Kategori
            </a>
            @foreach($categories as $category)
                <a href="{{ route('public.village.news', [$village->slug, 'category' => $category]) }}" class="px-5 py-2.5 rounded-full text-sm font-semibold transition {{ request()->query('category') === $category ? 'bg-emerald-700 text-white shadow-sm' : 'bg-white text-slate-700 hover:bg-slate-100 border border-slate-200' }}">
                    {{ $category }}
                </a>
            @endforeach
        </div>

        @if($articles->isEmpty())
            <div class="bg-white rounded-3xl p-12 border border-slate-200 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Artikel</h3>
                <p class="text-slate-500 text-sm">Saat ini belum ada publikasi berita atau artikel pada kategori ini.</p>
                @if(request()->filled('category'))
                    <a href="{{ route('public.village.news', $village->slug) }}" class="mt-4 inline-block px-4 py-2 bg-emerald-700 text-white text-xs font-semibold rounded-xl hover:bg-emerald-800 transition">
                        Tampilkan Semua Berita
                    </a>
                @endif
            </div>
        @else
            <!-- News Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($articles as $article)
                    <article class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 flex flex-col group">
                        <a href="{{ route('public.village.news.show', [$village->slug, $article->slug]) }}" class="block relative aspect-16/10 bg-slate-100 overflow-hidden">
                            @if($article->cover_image)
                                <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100 text-sm font-medium">
                                    Dokumentasi Berita
                                </div>
                            @endif
                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/90 backdrop-blur-md text-emerald-800 shadow-sm">
                                    {{ $article->category }}
                                </span>
                            </div>
                        </a>

                        <div class="p-6 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center text-xs text-slate-400 mb-2 space-x-2">
                                    <span>{{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->isoFormat('D MMMM Y') : $article->created_at->isoFormat('D MMMM Y') }}</span>
                                    <span>•</span>
                                    <span>Oleh {{ $article->author->name ?? 'Redaksi Desa' }}</span>
                                </div>
                                <h2 class="text-xl font-extrabold text-slate-900 group-hover:text-emerald-700 transition leading-snug mb-3">
                                    <a href="{{ route('public.village.news.show', [$village->slug, $article->slug]) }}">
                                        {{ $article->title }}
                                    </a>
                                </h2>
                                <p class="text-slate-600 text-sm line-clamp-3 leading-relaxed">
                                    {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                                </p>
                            </div>

                            <div class="pt-5 mt-5 border-t border-slate-100 flex items-center justify-between">
                                <a href="{{ route('public.village.news.show', [$village->slug, $article->slug]) }}" class="text-xs font-bold text-emerald-700 hover:text-emerald-800 flex items-center group-hover:translate-x-1 transition">
                                    <span>Baca Selengkapnya</span>
                                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-12">
                {{ $articles->links() }}
            </div>
        @endif

    </div>
</div>
@endsection

