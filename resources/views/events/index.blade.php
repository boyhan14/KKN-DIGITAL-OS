<x-layouts.app :pageHeading="'Agenda Kegiatan — Desa ' . $village->name">
    <div class="space-y-8" x-data="{ eventModal: false }">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Agenda Kegiatan & Acara Warga</h2>
                <p class="text-xs text-slate-500 mt-1">Jadwal musyawarah desa, pelatihan UMKM, gotong royong, dan kegiatan KKN.</p>
            </div>
            
            <div class="flex items-center space-x-2">
                @if(!$isLocked)
                    <button @click="eventModal = true" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Kegiatan Baru</span>
                    </button>
                @endif
                <a href="{{ route('public.village.events', $village->slug) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center space-x-1">
                    <span>Lihat Halaman Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>

        <!-- Events List -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex flex-col justify-between hover:border-emerald-500/60 transition">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-bold border border-emerald-200">
                                📅 {{ $event->date->format('d M Y') }}
                            </span>
                            @if($event->status === 'PUBLISHED')
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">✓ PUBLISHED</span>
                            @elseif($event->status === 'PENDING_REVIEW')
                                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold">⏳ REVIEW</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">DRAFT</span>
                            @endif
                        </div>

                        <h3 class="text-base font-black text-slate-900 leading-snug">{{ $event->title }}</h3>
                        <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">{{ $event->description }}</p>

                        <div class="mt-4 pt-3 border-t border-slate-100 space-y-1 text-xs text-slate-500">
                            <div>📍 Lokasi: <strong class="text-slate-700">{{ $event->location ?? 'Balai Desa' }}</strong></div>
                            <div>👥 Penyelenggara: {{ $event->organizer ?? 'Pemerintah Desa / KKN' }}</div>
                        </div>
                    </div>

                    <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                        @if($event->status === 'DRAFT' && !$isLocked)
                            <form action="{{ route('village.events.submit', ['village' => $village->id, 'event' => $event->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-amber-700 hover:text-amber-900 font-bold">
                                    Ajukan Review
                                </button>
                            </form>
                        @else
                            <span></span>
                        @endif

                        @if(!$isLocked)
                            <form action="{{ route('village.events.destroy', ['village' => $village->id, 'event' => $event->id]) }}" method="POST" onsubmit="return confirm('Hapus agenda ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold">Hapus</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 rounded-3xl bg-white border border-slate-200 text-center">
                    <p class="text-sm font-bold text-slate-700">Belum ada agenda kegiatan yang dibuat.</p>
                    <p class="text-xs text-slate-500 mt-1">Tambahkan jadwal kegiatan warga atau program penyuluhan KKN.</p>
                </div>
            @endforelse
        </div>

        <!-- Add Event Modal -->
        <div x-show="eventModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="eventModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Agenda Kegiatan Baru</h3>
                <form action="{{ route('village.events.store', $village->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Kegiatan</label>
                        <input type="text" name="title" required placeholder="Contoh: Pelatihan Foto Produk & Pemasaran Digital UMKM" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tanggal Kegiatan</label>
                        <input type="date" name="date" required value="{{ now()->toDateString() }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Lokasi</label>
                            <input type="text" name="location" placeholder="Balai Desa Sukamaju" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Penyelenggara</label>
                            <input type="text" name="organizer" placeholder="Tim KKN & Karang Taruna" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Kegiatan</label>
                        <textarea name="description" rows="3" placeholder="Uraian agenda, sasaran peserta, dan materi yang disampaikan..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs leading-relaxed"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="eventModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Agenda</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app>

