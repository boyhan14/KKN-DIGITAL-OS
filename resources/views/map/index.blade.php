<x-layouts.app :pageHeading="'Peta Digital Interaktif — Desa ' . $village->name">
    <div class="space-y-6" 
         x-data="{ 
             locationModal: false, 
             currentLat: '{{ $village->latitude ?? -6.6912 }}', 
             currentLng: '{{ $village->longitude ?? 106.9451 }}',
             locationTitle: '',
             locationCategory: 'FACILITY',
             locationDesc: '',
             openModal(lat, lng) {
                 if (lat) this.currentLat = lat;
                 if (lng) this.currentLng = lng;
                 this.locationModal = true;
                 this.$nextTick(() => {
                     const input = document.getElementById('location-title-input');
                     if (input) input.focus();
                 });
             },
             useCurrentLocation() {
                 if (navigator.geolocation) {
                     navigator.geolocation.getCurrentPosition((pos) => {
                         this.currentLat = pos.coords.latitude.toFixed(7);
                         this.currentLng = pos.coords.longitude.toFixed(7);
                         alert('Koordinat GPS Anda berhasil diambil: ' + this.currentLat + ', ' + this.currentLng);
                     }, (err) => {
                         alert('Gagal mengambil lokasi GPS: ' + err.message);
                     });
                 } else {
                     alert('Browser Anda tidak mendukung Geolocation.');
                 }
             }
         }"
         @open-location-modal.window="openModal($event.detail.lat, $event.detail.lng)"
    >
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Peta Digital & Titik Potensi Desa</h2>
                <p class="text-xs text-slate-500 mt-1">Pemetaan sebaran UMKM, destinasi wisata, balai desa, fasilitas pelayanan, dan posko KKN.</p>
            </div>
            
            <div class="flex items-center space-x-2">
                @if(!$isLocked)
                    <button type="button" @click="openModal()" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center space-x-1.5 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>+ Tambah Titik Peta</span>
                    </button>
                @endif
                <a href="{{ route('public.village.map', $village->slug) }}" target="_blank" class="px-3.5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center space-x-1">
                    <span>Lihat Peta Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>

        <!-- Quick Interactive Hint Bar -->
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-emerald-900 text-xs flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div class="flex items-center space-x-2.5">
                <span class="text-xl">📍</span>
                <div>
                    <strong class="font-bold">Cara Tambah Titik:</strong> Cukup <strong>klik di sembarang tempat pada peta</strong>, popup formulir otomatis muncul untuk memberi nama lokasi dan menyimpannya.
                </div>
            </div>
            @if(!$isLocked)
                <button type="button" @click="openModal()" class="shrink-0 px-3 py-1.5 rounded-lg bg-emerald-600/10 hover:bg-emerald-600/20 text-emerald-800 font-bold text-xs transition text-center cursor-pointer">
                    Input Manual / GPS
                </button>
            @endif
        </div>

        <!-- Interactive Map Container -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden relative">
            <div id="village-map" class="w-full h-[550px] z-10 cursor-crosshair"></div>
            <div class="absolute top-4 right-4 z-20 bg-white/90 backdrop-blur-md px-3.5 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-700 shadow-sm flex items-center space-x-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Total Titik Terdata: {{ count($markers) }}</span>
            </div>
        </div>

        <!-- Custom Locations Table with Delete Action -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Titik Lokasi Khusus Desa ({{ $customLocations->count() }} Ditambahkan)</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Daftar titik lokasi yang ditambahkan mahasiswa KKN atau perangkat desa.</p>
                </div>
            </div>

            @if($customLocations->isEmpty())
                <div class="text-center py-8">
                    <p class="text-xs text-slate-400">Belum ada titik khusus manual. Klik sembarang area pada peta di atas untuk menambahkan titik baru.</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 text-xs">
                    @foreach($customLocations as $loc)
                        <div class="p-3.5 rounded-2xl bg-slate-50 hover:bg-slate-100/80 border border-slate-200/80 flex items-start justify-between gap-2 transition">
                            <div>
                                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-emerald-800">
                                    {{ $loc->category }}
                                </span>
                                <h4 class="font-bold text-slate-900 mt-1.5">{{ $loc->title }}</h4>
                                @if($loc->description)
                                    <p class="text-[11px] text-slate-500 mt-0.5 line-clamp-1">{{ $loc->description }}</p>
                                @endif
                                <span class="text-[10px] text-slate-400 font-mono mt-1.5 block">
                                    {{ number_format($loc->latitude, 5) }}, {{ number_format($loc->longitude, 5) }}
                                </span>
                            </div>

                            @if(!$isLocked)
                                <form action="{{ route('village.map.destroy', [$village->id, $loc->id]) }}" method="POST" onsubmit="return confirm('Hapus titik peta {{ addslashes($loc->title) }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 hover:bg-rose-50 font-bold p-1.5 rounded-lg transition" title="Hapus titik">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Add Location Modal -->
        <div x-show="locationModal" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" 
             style="display: none;"
             @keydown.escape.window="locationModal = false">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="locationModal = false">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 mb-4">
                    <div>
                        <h3 class="text-lg font-black text-slate-900">Beri Nama & Simpan Titik Peta</h3>
                        <p class="text-xs text-slate-500">Isi identitas tempat untuk titik yang dipilih di peta</p>
                    </div>
                    <button type="button" @click="locationModal = false" class="text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center font-bold text-lg cursor-pointer">✕</button>
                </div>

                <form action="{{ route('village.map.store', $village->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Tempat / Lokasi <span class="text-rose-500">*</span></label>
                        <input type="text" id="location-title-input" name="title" required x-model="locationTitle" placeholder="Contoh: Balai Warga RW 03 / Posko KKN 22 / Sentra Kopi" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori Lokasi</label>
                        <select name="category" x-model="locationCategory" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none">
                            <option value="FACILITY">🏛️ Fasilitas Umum / Pelayanan</option>
                            <option value="OFFICE">🏢 Balai Desa / Kantor Dusun</option>
                            <option value="UMKM">🛍️ Sentra / Usaha UMKM</option>
                            <option value="TOURISM">🏞️ Objek / Wisata Desa</option>
                            <option value="KKN_PROGRAM">⛺ Posko / Titik Program KKN</option>
                            <option value="OTHER">📍 Lainnya</option>
                        </select>
                    </div>

                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-200/80 space-y-2">
                        <div class="text-[11px] font-bold text-slate-600 flex items-center justify-between">
                            <span>Koordinat Peta Terpilih:</span>
                            <span class="text-emerald-700 font-mono text-[10px] bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">Terisi Otomatis</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-0.5">Latitude</label>
                                <input type="text" name="latitude" required x-model="currentLat" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs font-mono bg-white">
                            </div>
                            <div>
                                <label class="block text-[10px] text-slate-500 mb-0.5">Longitude</label>
                                <input type="text" name="longitude" required x-model="currentLng" class="w-full px-2.5 py-1.5 rounded-lg border border-slate-300 text-xs font-mono bg-white">
                            </div>
                        </div>

                        <button type="button" @click="useCurrentLocation()" class="w-full py-1.5 rounded-lg bg-white hover:bg-slate-100 text-slate-700 font-bold border border-slate-200 transition flex items-center justify-center space-x-1 cursor-pointer">
                            <span>📍 Ambil Dari Sensor GPS Saya</span>
                        </button>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Tambahan (Opsional)</label>
                        <textarea name="description" x-model="locationDesc" rows="2" placeholder="Contoh: Buka jam 08.00-16.00 WIB, tempat pengolahan madu lebah..." class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-none"></textarea>
                    </div>

                    <div class="flex items-center justify-end space-x-2 pt-3 border-t border-slate-100">
                        <button type="button" @click="locationModal = false" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition cursor-pointer">
                            Batal
                        </button>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold transition shadow-md shadow-emerald-600/20 cursor-pointer flex items-center space-x-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Simpan Titik Peta</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    @push('scripts')
    <script>
        // Global handler accessible from popup buttons
        window.openAddLocationModal = function(lat, lng) {
            window.dispatchEvent(new CustomEvent('open-location-modal', {
                detail: { lat: lat, lng: lng }
            }));
        };

        document.addEventListener('DOMContentLoaded', function () {
            const centerLat = {{ $village->latitude ?? -6.6912 }};
            const centerLng = {{ $village->longitude ?? 106.9451 }};

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

            // Interactive Click to Add Point:
            let tempMarker = null;
            map.on('click', function(e) {
                const clickedLat = e.latlng.lat.toFixed(7);
                const clickedLng = e.latlng.lng.toFixed(7);

                if (tempMarker) {
                    map.removeLayer(tempMarker);
                }

                tempMarker = L.marker([e.latlng.lat, e.latlng.lng], {
                    opacity: 0.95
                }).addTo(map);

                const popupHtml = `
                    <div style="font-family: inherit; text-align: center; padding: 4px; min-width: 200px;">
                        <span style="font-size: 10px; font-weight: 800; color: #059669; text-transform: uppercase; letter-spacing: 0.5px;">📍 Titik Baru Terpilih</span>
                        <div style="font-family: monospace; font-size: 11px; color: #475569; margin: 4px 0 8px; background: #f8fafc; padding: 4px; border-radius: 6px; border: 1px solid #e2e8f0;">
                            ${clickedLat}, ${clickedLng}
                        </div>
                        <button type="button" onclick="window.openAddLocationModal('${clickedLat}', '${clickedLng}')" style="display: inline-flex; align-items: center; justify-content: center; width: 100%; padding: 8px 12px; background: #059669; color: #ffffff; border: none; border-radius: 10px; font-weight: 800; font-size: 12px; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(5, 150, 105, 0.25);">
                            ✍️ Beri Nama & Simpan
                        </button>
                    </div>
                `;

                tempMarker.bindPopup(popupHtml).openPopup();

                // Automatically trigger the modal immediately on click
                window.openAddLocationModal(clickedLat, clickedLng);
            });
        });
    </script>
    @endpush
</x-layouts.app>
