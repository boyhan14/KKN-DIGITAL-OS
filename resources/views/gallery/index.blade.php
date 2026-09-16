<x-layouts.app :pageHeading="'Galeri & Dokumentasi — Desa ' . $village->name">
    <div class="space-y-8" x-data="{ albumModal: false, mediaModal: false, activeAlbumId: null }">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Galeri Foto & Dokumentasi Kegiatan</h2>
                <p class="text-xs text-slate-500 mt-1">Arsip visual kegiatan pengabdian mahasiswa KKN dan dokumentasi panorama desa.</p>
            </div>
            
            <div class="flex items-center space-x-2">
                @if(!$isLocked)
                    <button @click="albumModal = true" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Buat Album Baru</span>
                    </button>
                @endif
                <a href="{{ route('public.village.gallery', $village->slug) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center space-x-1">
                    <span>Lihat Galeri Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>

        <!-- Albums & Photos Display -->
        <div class="space-y-8">
            @forelse($albums as $album)
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4 mb-6">
                        <div>
                            <h3 class="text-lg font-black text-slate-900">{{ $album->album_name }}</h3>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $album->description ?? 'Dokumentasi foto kegiatan' }}</p>
                        </div>
                        @if(!$isLocked)
                            <button @click="mediaModal = true; activeAlbumId = {{ $album->id }}" class="px-3.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold text-xs border border-emerald-200 transition">
                                + Tambah Foto
                            </button>
                        @endif
                    </div>

                    @if($album->mediaItems->isEmpty())
                        <p class="text-xs text-slate-400 italic py-4">Belum ada foto dalam album ini.</p>
                    @else
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($album->mediaItems as $media)
                                <div class="group relative rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 aspect-4/3 flex flex-col justify-end p-3 shadow-xs">
                                    <img src="{{ $media->file_path }}" alt="{{ $media->caption }}" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                                    <div class="relative z-10 text-white text-xs">
                                        <p class="font-bold line-clamp-1">{{ $media->caption ?? 'Dokumentasi KKN' }}</p>
                                        <span class="text-[10px] text-slate-300 block">📷 {{ $media->photographer ?? 'Tim Dokumentasi' }}</span>
                                    </div>
                                    @if(!$isLocked)
                                        <form action="{{ route('village.gallery.media.destroy', ['village' => $village->id, 'album' => $album->id, 'media' => $media->id]) }}" method="POST" class="absolute top-2 right-2 z-20" onsubmit="return confirm('Hapus foto ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-6 h-6 rounded-full bg-slate-900/60 hover:bg-rose-600 text-white flex items-center justify-center text-xs font-bold transition">&times;</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-12 rounded-3xl bg-white border border-slate-200 text-center">
                    <p class="text-sm font-bold text-slate-700">Belum ada album galeri.</p>
                    <p class="text-xs text-slate-500 mt-1">Buat album untuk mengorganisasi dokumentasi kegiatan KKN di desa.</p>
                </div>
            @endforelse
        </div>

        <!-- Add Album Modal -->
        <div x-show="albumModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="albumModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Buat Album Galeri Baru</h3>
                <form action="{{ route('village.gallery.albums.store', $village->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Album</label>
                        <input type="text" name="album_name" required placeholder="Contoh: Sosialisasi & Pelatihan UMKM Sukamaju" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Album</label>
                        <textarea name="description" rows="2" placeholder="Catatan singkat mengenai dokumentasi album..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="albumModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Album</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Add Media Modal -->
        <div x-show="mediaModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="mediaModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Foto ke Album</h3>
                <form :action="'{{ url('workspace/village') }}/{{ $village->id }}/gallery/albums/' + activeAlbumId + '/media'" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Caption / Keterangan Foto</label>
                        <input type="text" name="caption" required placeholder="Contoh: Pendampingan branding produk batik" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">URL Foto / Path Gambar</label>
                        <input type="text" name="file_path" value="https://images.unsplash.com/photo-1596405835972-237e89cb7d5d?w=800&auto=format&fit=crop&q=80" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Fotografer / Pengambil</label>
                            <input type="text" name="photographer" value="{{ auth()->user()->name }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Tanggal Foto</label>
                            <input type="date" name="date" value="{{ now()->toDateString() }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="mediaModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Foto</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app>

