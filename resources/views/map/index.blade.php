<x-layouts.app :pageHeading="'Peta Digital Interaktif — Desa ' . $village->name">
    <div class="space-y-6" x-data="{ locationModal: false }">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Peta Digital & Titik Potensi Desa</h2>
                <p class="text-xs text-slate-500 mt-1">Pemetaan sebaran UMKM, destinasi wisata, balai desa, dan fasilitas pelayanan masyarakat.</p>
            </div>
            
            <div class="flex items-center space-x-2">
                @if(!$isLocked)
                    <button @click="locationModal = true" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Titik Peta</span>
                    </button>
                @endif
                <a href="{{ route('public.village.map', $village->slug) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center space-x-1">
                    <span>Lihat Peta Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>

        <!-- Interactive Map Container -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div id="village-map" class="w-full h-[550px] z-10"></div>
        </div>

        <!-- Custom Locations Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <h3 class="text-base font-bold text-slate-900 mb-4">Daftar Titik Lokasi Peta ({{ count($markers) }} Titik)</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 text-xs">
                @foreach($markers as $m)
                    <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200/80 flex items-start justify-between">
                        <div>
                            <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-emerald-800">
                                {{ $m['category_label'] }}
                            </span>
                            <h4 class="font-bold text-slate-900 mt-1">{{ $m['title'] }}</h4>
                            <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">{{ $m['description'] }}</p>
                            <span class="text-[10px] text-slate-400 font-mono mt-1 block">
                                Lat: {{ number_format($m['lat'], 4) }}, Lng: {{ number_format($m['lng'], 4) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Add Location Modal -->
        <div x-show="locationModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="locationModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Titik Lokasi Peta</h3>
                <form action="{{ route('village.map.store', $village->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Lokasi / Tempat</label>
                        <input type="text" name="title" required placeholder="Contoh: Sanggar Seni Tari Sukamaju" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="FACILITY">Fasilitas Umum</option>
                            <option value="OFFICE">Kantor Desa / Dusun</option>
                            <option value="UMKM">Sentra UMKM</option>
                            <option value="TOURISM">Spot Wisata</option>
                            <option value="KKN_PROGRAM">Lokasi Posko / Kegiatan KKN</option>
                            <option value="OTHER">Lainnya</option>
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Latitude</label>
                            <input type="text" name="latitude" required value="{{ $village->latitude ?? -5.3600000 }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Longitude</label>
                            <input type="text" name="longitude" required value="{{ $village->longitude ?? 105.1800000 }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                        </div>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="description" rows="2" placeholder="Catatan fasilitas / jam kunjungan..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="locationModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Titik</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const centerLat = {{ $village->latitude ?? -5.3600000 }};
            const centerLng = {{ $village->longitude ?? 105.1800000 }};

            const map = L.map('village-map').setView([centerLat, centerLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            const markers = @json($markers);

            markers.forEach(function(m) {
                const marker = L.marker([m.lat, m.lng]).addTo(map);
                
                let popupContent = `
                    <div style="font-family: inherit; font-size: 12px; line-height: 1.4; max-width: 220px;">
                        <span style="font-size: 10px; font-weight: bold; color: #047857; text-transform: uppercase;">${m.category_label}</span>
                        <h4 style="font-size: 13px; font-weight: 800; margin: 2px 0 4px 0; color: #0f172a;">${m.title}</h4>
                        <p style="color: #64748b; font-size: 11px; margin: 0 0 6px 0;">${m.description || ''}</p>
                        ${m.whatsapp ? `<a href="${m.whatsapp}" target="_blank" style="display: inline-block; font-size: 10px; font-weight: bold; color: #059669; text-decoration: none;">💬 Chat WhatsApp &rarr;</a>` : ''}
                    </div>
                `;

                marker.bindPopup(popupContent);
            });
        });
    </script>
    @endpush
</x-layouts.app>

