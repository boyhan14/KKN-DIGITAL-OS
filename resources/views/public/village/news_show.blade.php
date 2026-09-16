@extends('layouts.public', ['title' => $article->title, 'metaDescription' => $article->excerpt ?? Str::limit(strip_tags($article->content), 150)])

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white border-b border-slate-200 py-10">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-6">
            <a href="{{ route('public.village.home', $village->slug) }}" class="hover:text-emerald-700">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.village.news', $village->slug) }}" class="hover:text-emerald-700">Warta Desa</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold truncate">{{ Str::limit($article->title, 40) }}</span>
        </nav>

        <!-- Header Info -->
        <div class="space-y-4">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                {{ $article->category }}
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 leading-tight">
                {{ $article->title }}
            </h1>
            <div class="flex items-center space-x-3 text-xs text-slate-500 pt-2 border-t border-slate-200/80">
                <div class="w-8 h-8 rounded-full bg-emerald-700 text-white flex items-center justify-center font-bold text-xs">
                    {{ substr($article->author->name ?? 'Admin', 0, 1) }}
                </div>
                <div>
                    <span class="font-bold text-slate-800 block">{{ $article->author->name ?? 'Redaksi Desa' }}</span>
                    <span>Dipublikasikan {{ $article->published_at ? \Carbon\Carbon::parse($article->published_at)->isoFormat('dddd, D MMMM Y') : $article->created_at->isoFormat('D MMMM Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<article class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        @if($article->cover_image)
            <div class="rounded-3xl overflow-hidden shadow-md mb-10 border border-slate-200 aspect-16/9 bg-slate-100">
                <img src="{{ $article->cover_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Content Body -->
        <div class="prose prose-slate lg:prose-lg max-w-none leading-relaxed text-slate-700 whitespace-pre-line">
            {{ $article->content }}
        </div>

        <!-- Share & Actions -->
        <div class="mt-12 pt-8 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Bagikan Warta:</span>
                @php
                    $shareUrl = urlencode(request()->fullUrl());
                    $shareText = urlencode($article->title . " — Portal Desa " . $village->name);
                @endphp
                <a href="https://wa.me/?text={{ $shareText }}%20{{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold flex items-center space-x-1.5 transition">
                    <span>WhatsApp</span>
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ $shareText }}&url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-1.5 rounded-xl bg-sky-50 hover:bg-sky-100 text-sky-800 text-xs font-bold flex items-center space-x-1.5 transition">
                    <span>Twitter / X</span>
                </a>
            </div>

            <a href="{{ route('public.village.news', $village->slug) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-700 flex items-center">
                <span>← Kembali ke Semua Berita</span>
            </a>
        </div>

        <!-- Related Articles -->
        @if($relatedArticles->isNotEmpty())
            <div class="mt-16 pt-12 border-t border-slate-200">
                <h3 class="text-2xl font-black text-slate-900 mb-6">Warta Terkait Lainnya</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $related)
                        <a href="{{ route('public.village.news.show', [$village->slug, $related->slug]) }}" class="group block bg-slate-50 rounded-2xl p-4 border border-slate-200 hover:border-emerald-300 transition">
                            <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block mb-1">{{ $related->category }}</span>
                            <h4 class="text-sm font-bold text-slate-900 group-hover:text-emerald-700 line-clamp-2 transition mb-2">{{ $related->title }}</h4>
                            <span class="text-[11px] text-slate-400 block">{{ \Carbon\Carbon::parse($related->published_at ?? $related->created_at)->isoFormat('D MMM Y') }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</article>
@endsection

