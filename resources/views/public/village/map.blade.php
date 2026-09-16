@extends('layouts.public', ['title' => 'Peta Digital Interaktif', 'metaDescription' => 'Peta spasial digital fasilitas umum, UMKM, dan potensi wisata Desa ' . $village->name])

@section('content')
<div class="bg-white border-b border-slate-200 py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex items-center space-x-2 text-xs text-slate-500 mb-2">
                    <a href="{{ route('public.village.home', $village->slug) }}" class="hover:text-emerald-700">Beranda</a>
                    <span>/</span>
                    <span class="text-slate-800 font-semibold">Peta Digital Spasial</span>
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Peta Digital Interaktif Desa {{ $village->name }}</h1>
                <p class="text-slate-600 text-sm">Inventarisasi lokasi penting, destinasi wisata, dan sebaran UMKM warga desa.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">
                    Total {{ count($markers) }} Titik Lokasi
                </span>
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="publicVillageMap(@js($markers))">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">
        
        <!-- Sidebar Filter & Place List -->
        <div class="lg:col-span-1 bg-white rounded-3xl border border-slate-200 p-5 shadow-xs space-y-5">
            <div>
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Filter Kategori Titik</h3>
                <div class="flex flex-wrap lg:flex-col gap-1.5">
                    <button @click="filterType = 'all'" :class="filterType === 'all' ? 'bg-emerald-700 text-white font-bold' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs text-left transition flex items-center justify-between">
                        <span>Semua Titik</span>
                        <span class="text-[10px] opacity-75 font-mono" x-text="markers.length"></span>
                    </button>
                    <button @click="filterType = 'umkm'" :class="filterType === 'umkm' ? 'bg-emerald-700 text-white font-bold' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs text-left transition flex items-center justify-between">
                        <span>🏪 UMKM Desa</span>
                        <span class="text-[10px] opacity-75 font-mono" x-text="markers.filter(m => m.type === 'umkm').length"></span>
                    </button>
                    <button @click="filterType = 'tourism'" :class="filterType === 'tourism' ? 'bg-emerald-700 text-white font-bold' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs text-left transition flex items-center justify-between">
                        <span>🌿 Wisata Desa</span>
                        <span class="text-[10px] opacity-75 font-mono" x-text="markers.filter(m => m.type === 'tourism').length"></span>
                    </button>
                    <button @click="filterType = 'facility'" :class="filterType === 'facility' ? 'bg-emerald-700 text-white font-bold' : 'bg-slate-50 text-slate-700 hover:bg-slate-100'" class="px-3.5 py-2 rounded-xl text-xs text-left transition flex items-center justify-between">
                        <span>🏛️ Fasilitas Umum</span>
                        <span class="text-[10px] opacity-75 font-mono" x-text="markers.filter(m => m.type === 'facility').length"></span>
                    </button>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-4">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Daftar Lokasi Terpilih</h3>
                <div class="max-h-96 overflow-y-auto space-y-2 pr-1">
                    <template x-for="item in filteredMarkers" :key="item.id">
                        <div @click="zoomTo(item)" class="p-3 rounded-2xl bg-slate-50 hover:bg-emerald-50 border border-slate-200/80 hover:border-emerald-300 cursor-pointer transition">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full" :class="item.type === 'umkm' ? 'bg-amber-100 text-amber-800' : (item.type === 'tourism' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800')" x-text="item.type"></span>
                            </div>
                            <h4 class="text-xs font-extrabold text-slate-900 truncate" x-text="item.title"></h4>
                            <p class="text-[11px] text-slate-500 line-clamp-1 mt-0.5" x-text="item.description || 'Lokasi terdata di peta desa'"></p>
                        </div>
                    </template>
                </div>
            </div>
        </div>

        <!-- Leaflet Map View -->
        <div class="lg:col-span-3">
            <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-xs relative">
                <div id="leaflet-village-map" class="w-full h-[620px] z-10"></div>
                <div class="absolute bottom-4 left-4 z-20 bg-white/90 backdrop-blur-md px-3 py-2 rounded-xl border border-slate-200 text-[11px] text-slate-600 shadow-sm">
                    💡 Klik salah satu penanda (pin) di peta untuk melihat ringkasan informasi dan petunjuk rute.
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('publicVillageMap', (initialMarkers) => ({
        markers: initialMarkers || [],
        filterType: 'all',
        map: null,
        leafletMarkers: [],

        get filteredMarkers() {
            if (this.filterType === 'all') return this.markers;
            return this.markers.filter(m => m.type === this.filterType);
        },

        init() {
            this.$nextTick(() => {
                this.initMap();
            });

            this.$watch('filterType', () => {
                this.renderMarkers();
            });
        },

        initMap() {
            const defaultLat = this.markers.length > 0 ? this.markers[0].lat : -7.4313;
            const defaultLng = this.markers.length > 0 ? this.markers[0].lng : 110.4267;

            this.map = L.map('leaflet-village-map').setView([defaultLat, defaultLng], 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors | KKN Digital Village OS'
            }).addTo(this.map);

            this.renderMarkers();
        },

        renderMarkers() {
            if (!this.map) return;

            // Clear old markers
            this.leafletMarkers.forEach(m => this.map.removeLayer(m));
            this.leafletMarkers = [];

            const bounds = [];

            this.filteredMarkers.forEach(item => {
                if (!item.lat || !item.lng) return;

                const popupHtml = `
                    <div class="p-1 text-slate-800" style="min-width: 180px;">
                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block">${item.type.toUpperCase()}</span>
                        <h4 class="text-sm font-black text-slate-900 mt-1">${item.title}</h4>
                        <p class="text-xs text-slate-600 mt-1 mb-2">${item.description || ''}</p>
                        <a href="https://www.google.com/maps/search/?api=1&query=${item.lat},${item.lng}" target="_blank" rel="noopener noreferrer" style="color: #047857; font-weight: bold; font-size: 11px; text-decoration: underline;">Buka Rute Navigasi →</a>
                    </div>
                `;

                const marker = L.marker([item.lat, item.lng])
                    .addTo(this.map)
                    .bindPopup(popupHtml);

                this.leafletMarkers.push(marker);
                bounds.push([item.lat, item.lng]);
            });

            if (bounds.length > 0) {
                this.map.fitBounds(bounds, { padding: [50, 50], maxZoom: 16 });
            }
        },

        zoomTo(item) {
            if (!this.map || !item.lat || !item.lng) return;
            this.map.setView([item.lat, item.lng], 17, { animate: true });
            
            const targetMarker = this.leafletMarkers.find(m => {
                const pos = m.getLatLng();
                return Math.abs(pos.lat - item.lat) < 0.0001 && Math.abs(pos.lng - item.lng) < 0.0001;
            });

            if (targetMarker) {
                targetMarker.openPopup();
            }
        }
    }));
});
</script>
@endsection

