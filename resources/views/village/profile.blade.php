<x-layouts.app :pageHeading="'Profil & Data Desa ' . $village->name">
    <div class="space-y-8" x-data="{ facilityModal: false, aiLoading: false, historyInput: '{{ addslashes($profile->history ?? '') }}', visionInput: '{{ addslashes($profile->vision ?? '') }}' }">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Profil & Informasi Desa {{ $village->name }}</h2>
                <p class="text-xs text-slate-500 mt-1">Data ini ditampilkan secara terbuka di website publik untuk mengenalkan sejarah, visi misi, dan fasilitas desa.</p>
            </div>
            
            <div class="flex items-center space-x-2">
                @if($profile->status === 'PUBLISHED')
                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold border border-emerald-300">
                        ✓ Terpublikasi di Website Desa
                    </span>
                @elseif($profile->status === 'PENDING_REVIEW')
                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold border border-amber-300">
                        ⏳ Menunggu Review Pembimbing
                    </span>
                @else
                    @if(!$isLocked)
                        <form action="{{ route('village.profile.submit', $village->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs shadow-xs transition">
                                🚀 Ajukan Review ke Dosen
                            </button>
                        </form>
                    @endif
                @endif

                <a href="{{ route('public.village.about', $village->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center space-x-1">
                    <span>Lihat Tampilan Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>

        <!-- Village Profile Form -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
            <form action="{{ route('village.profile.update', $village->id) }}" method="POST" class="space-y-6 text-xs">
                @csrf

                <!-- Theme Selection -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                    <label class="block font-bold text-slate-800 mb-1">Pilihan Tema Visual Website Publik Desa</label>
                    <p class="text-slate-500 text-[11px] mb-3">Tentukan nuansa desain visual yang paling mencerminkan identitas Desa {{ $village->name }}.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <label class="p-3 rounded-xl border {{ $village->theme === 'modern' ? 'border-emerald-600 bg-emerald-50/50' : 'border-slate-200 bg-white' }} flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="theme" value="modern" {{ $village->theme === 'modern' ? 'checked' : '' }} class="text-emerald-600">
                            <div>
                                <span class="font-bold text-slate-900 block">Modern Civic</span>
                                <span class="text-[10px] text-slate-500">Hijau emerald bersih & kontemporer</span>
                            </div>
                        </label>
                        <label class="p-3 rounded-xl border {{ $village->theme === 'nature' ? 'border-emerald-600 bg-emerald-50/50' : 'border-slate-200 bg-white' }} flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="theme" value="nature" {{ $village->theme === 'nature' ? 'checked' : '' }} class="text-emerald-600">
                            <div>
                                <span class="font-bold text-slate-900 block">Nature Green</span>
                                <span class="text-[10px] text-slate-500">Nuansa hutan & agraris alami</span>
                            </div>
                        </label>
                        <label class="p-3 rounded-xl border {{ $village->theme === 'heritage' ? 'border-emerald-600 bg-emerald-50/50' : 'border-slate-200 bg-white' }} flex items-center space-x-3 cursor-pointer">
                            <input type="radio" name="theme" value="heritage" {{ $village->theme === 'heritage' ? 'checked' : '' }} class="text-emerald-600">
                            <div>
                                <span class="font-bold text-slate-900 block">Cultural Heritage</span>
                                <span class="text-[10px] text-slate-500">Nuansa hangat terakota & adat</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Vision & Mission -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Visi Desa</label>
                        <textarea name="vision" rows="3" class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed" placeholder="Visi pembangunan desa...">{{ old('vision', $profile->vision) }}</textarea>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Misi Desa</label>
                        <textarea name="mission" rows="3" class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed" placeholder="1. Misi kesatu&#10;2. Misi kedua...">{{ old('mission', $profile->mission) }}</textarea>
                    </div>
                </div>

                <!-- History with AI Assistant -->
                <div>
                    <div class="flex items-center justify-between mb-1">
                        <label class="font-bold text-slate-800">Sejarah Singkat Desa</label>
                        <button type="button" 
                                @click="
                                    aiLoading = true;
                                    fetch('{{ route('ai.draft') }}', {
                                        method: 'POST',
                                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                        body: JSON.stringify({ type: 'village_profile', village_name: '{{ $village->name }}', history: historyInput })
                                    })
                                    .then(res => res.json())
                                    .then(data => { historyInput = data.draft; aiLoading = false; })
                                    .catch(() => { aiLoading = false; });
                                "
                                class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700 flex items-center space-x-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            <span x-text="aiLoading ? 'Menyusun...' : '✨ Bantu buat deskripsi AI'"></span>
                        </button>
                    </div>
                    <textarea name="history" x-model="historyInput" rows="4" class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed" placeholder="Asal usul desa, tokoh pendiri, perkembangan...">{{ old('history', $profile->history) }}</textarea>
                </div>

                <!-- Geography & Demographics -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Kondisi Geografis & Wilayah</label>
                        <textarea name="geography" rows="3" class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed" placeholder="Batas wilayah, luas desa, topografi...">{{ old('geography', $profile->geography) }}</textarea>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-800 mb-1">Ringkasan Demografi (Aman Publik)</label>
                        <textarea name="demographics_summary" rows="3" class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed" placeholder="Estimasi populasi, jumlah dusun/RT, mata pencaharian utama warga...">{{ old('demographics_summary', $profile->demographics_summary) }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-800 mb-1">Profil Potensi Ekonomi Desa</label>
                    <textarea name="economic_profile" rows="3" class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed" placeholder="Komoditas unggulan pertanian, kerajinan lokal, peluang investasi...">{{ old('economic_profile', $profile->economic_profile) }}</textarea>
                </div>

                @if(!$isLocked)
                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition">
                            Simpan Perubahan Profil
                        </button>
                    </div>
                @endif
            </form>
        </div>

        <!-- Village Facilities Section -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Fasilitas & Layanan Publik Desa</h3>
                    <p class="text-xs text-slate-500">Sekolah, puskesmas, balai desa, tempat ibadah, dan sarana umum.</p>
                </div>
                @if(!$isLocked)
                    <button @click="facilityModal = true" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                        + Tambah Fasilitas
                    </button>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($facilities as $fac)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-slate-700">
                                    {{ $fac->category }}
                                </span>
                                @if(!$isLocked)
                                    <form action="{{ route('village.facilities.destroy', ['village' => $village->id, 'facility' => $fac->id]) }}" method="POST" onsubmit="return confirm('Hapus fasilitas ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-500 hover:text-rose-700 text-xs font-bold">&times;</button>
                                    </form>
                                @endif
                            </div>
                            <h4 class="font-bold text-slate-900 text-sm">{{ $fac->name }}</h4>
                            <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $fac->description }}</p>
                        </div>
                        <div class="mt-3 pt-2 border-t border-slate-200/60 text-[11px] text-slate-400">
                            {{ $fac->address ?? 'Area Desa' }}
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 rounded-2xl bg-slate-50 text-center text-xs text-slate-500">
                        Belum ada fasilitas desa yang didata.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Add Facility Modal -->
        <div x-show="facilityModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="facilityModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Fasilitas Desa</h3>
                <form action="{{ route('village.facilities.store', $village->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Fasilitas</label>
                        <input type="text" name="name" required placeholder="Contoh: Balai Pertemuan Desa / Puskesmas Pembantu" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="GOVERNMENT">Pemerintahan</option>
                            <option value="HEALTH">Kesehatan</option>
                            <option value="EDUCATION">Pendidikan</option>
                            <option value="WORSHIP">Tempat Ibadah</option>
                            <option value="PUBLIC">Fasilitas Umum</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Alamat / Lokasi</label>
                        <input type="text" name="address" placeholder="Dusun I, Desa Sukamaju" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="description" rows="2" placeholder="Informasi layanan, jam buka, dll." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="facilityModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Fasilitas</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app>

