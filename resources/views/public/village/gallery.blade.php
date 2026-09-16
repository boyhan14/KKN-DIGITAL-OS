@extends('layouts.public', ['title' => 'Galeri & Dokumentasi Foto', 'metaDescription' => 'Koleksi dokumentasi foto kegiatan masyarakat, panorama alam, dan program KKN di Desa ' . $village->name])

@section('content')
<!-- Header -->
<div class="bg-gradient-to-b from-slate-100 to-white border-b border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 mb-3">
            Arsip Visual Desa
        </span>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 mb-3">
            Galeri & Album Desa {{ $village->name }}
        </h1>
        <p class="text-slate-600 max-w-2xl mx-auto text-sm sm:text-base">
            Dokumentasi foto kegiatan masyarakat, pesona bentang alam, serta rekam jejak pengabdian mahasiswa KKN.
        </p>
    </div>
</div>

<div class="py-12 bg-slate-50 min-h-screen" x-data="{ selectedImage: null, selectedCaption: '' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        
        @if($albums->isEmpty())
            <div class="bg-white rounded-3xl p-12 border border-slate-200 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Album Foto</h3>
                <p class="text-slate-500 text-sm">Dokumentasi foto sedang dipersiapkan dan diunggah oleh pengelola portal.</p>
            </div>
        @else
            @foreach($albums as $album)
                <div class="space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b border-slate-200 pb-4 gap-2">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900">{{ $album->title }}</h2>
                            <p class="text-slate-500 text-sm mt-1">{{ $album->description ?? 'Dokumentasi kegiatan resmi desa' }}</p>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 bg-white text-slate-700 rounded-full border border-slate-200 self-start sm:self-auto">
                            {{ $album->mediaItems->count() }} Foto
                        </span>
                    </div>

                    @if($album->mediaItems->isEmpty())
                        <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center text-slate-400 text-xs">
                            Belum ada foto yang dimasukkan ke album ini.
                        </div>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                            @foreach($album->mediaItems as $media)
                                <div @click="selectedImage = '{{ $media->file_url }}'; selectedCaption = '{{ addslashes($media->caption ?? $album->title) }}'" class="group relative aspect-square bg-slate-200 rounded-2xl overflow-hidden cursor-pointer shadow-xs hover:shadow-md transition">
                                    <img src="{{ $media->file_url }}" alt="{{ $media->caption ?? $album->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent opacity-0 group-hover:opacity-100 transition p-4 flex flex-col justify-end">
                                        <p class="text-white text-xs font-semibold line-clamp-2">{{ $media->caption ?? $album->title }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        @endif

    </div>

    <!-- Lightbox Modal -->
    <div x-show="selectedImage" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-black/90 backdrop-blur-md flex items-center justify-center p-4" 
         style="display: none;"
         @keydown.escape.window="selectedImage = null">
        
        <button @click="selectedImage = null" class="absolute top-6 right-6 text-white/80 hover:text-white p-2 rounded-full bg-white/10 hover:bg-white/20 transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="max-w-4xl max-h-[85vh] flex flex-col items-center" @click.outside="selectedImage = null">
            <img :src="selectedImage" class="max-w-full max-h-[75vh] object-contain rounded-2xl shadow-2xl">
            <p class="text-white/90 text-sm mt-4 text-center font-medium" x-text="selectedCaption"></p>
        </div>
    </div>
</div>
@endsection

