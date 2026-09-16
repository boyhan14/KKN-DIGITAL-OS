<x-layouts.app :pageHeading="'Impact Dashboard — ' . $group->group_name">
    <div class="space-y-8" x-data="{ metricModal: false, updateModal: false, activeMetric: { id: null, name: '', achieved: 0 } }">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Pengukuran Capaian & Dampak (Impact) KKN</h2>
                <p class="text-xs text-slate-500 mt-1">Metrik terukur dari hasil pengabdian masyarakat kelompok di Desa {{ $group->village->name ?? '-' }}.</p>
            </div>
            
            <div class="flex items-center space-x-2">
                @if($canManageImpact ?? false)
                    <button @click="metricModal = true" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        <span>Tambah Indikator Dampak</span>
                    </button>
                @elseif(auth()->user()->isSupervisor())
                    <div class="px-4 py-2.5 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-semibold flex items-center space-x-2 shadow-xs">
                        <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                        <span>Mode DPL: Memantau Capaian Dampak Pengabdian</span>
                    </div>
                @endif
                <a href="{{ route('public.village.impact', $group->village->slug) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center space-x-1">
                    <span>Lihat Laman Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>

        <!-- Big Impact Counters -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Penerima Manfaat</span>
                <span class="text-3xl sm:text-4xl font-black text-emerald-600 mt-1 block">{{ $impactSummary['beneficiaries'] }}</span>
                <span class="text-[11px] text-slate-400 mt-1 block">Warga Desa Terdampak</span>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">UMKM Terdigitalisasi</span>
                <span class="text-3xl sm:text-4xl font-black text-teal-600 mt-1 block">{{ $impactSummary['umkm_digitized'] }}</span>
                <span class="text-[11px] text-slate-400 mt-1 block">{{ $impactSummary['products_listed'] }} Produk Terdaftar</span>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Program Selesai</span>
                <span class="text-3xl sm:text-4xl font-black text-slate-900 mt-1 block">{{ $impactSummary['programs_completed'] }} / {{ $impactSummary['total_programs'] }}</span>
                <span class="text-[11px] text-emerald-600 font-semibold mt-1 block">Program Kerja Lapangan</span>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Wisata & Kegiatan</span>
                <span class="text-3xl sm:text-4xl font-black text-amber-600 mt-1 block">{{ $impactSummary['tourism_promoted'] + $impactSummary['events_organized'] }}</span>
                <span class="text-[11px] text-slate-400 mt-1 block">Spot & Agenda Publik</span>
            </div>
        </div>

        <!-- Custom Metrics Cards -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
            <h3 class="text-base font-bold text-slate-900 mb-6">Indikator Kinerja Utama (IKU) Program KKN</h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($metrics as $metric)
                    @php
                        $rate = $metric->progressPercentage();
                    @endphp
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-emerald-800 uppercase">
                                    {{ $metric->category }}
                                </span>
                                <span class="text-xs font-extrabold {{ $rate >= 100 ? 'text-emerald-600' : 'text-slate-700' }}">
                                    {{ $rate }}%
                                </span>
                            </div>

                            <h4 class="font-bold text-slate-900 text-sm leading-snug">{{ $metric->metric_name }}</h4>
                            <p class="text-xs text-slate-500 mt-1">{{ $metric->description }}</p>

                            <!-- Progress Gauge -->
                            <div class="w-full bg-slate-200 rounded-full h-2 mt-4 overflow-hidden">
                                <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2 rounded-full" style="width: {{ min(100, $rate) }}%"></div>
                            </div>

                            <div class="mt-3 flex items-center justify-between text-xs text-slate-600">
                                <span>Baseline: {{ $metric->baseline }}</span>
                                <span class="font-bold text-slate-900">{{ $metric->achieved }} / {{ $metric->target }} {{ $metric->unit }}</span>
                            </div>
                        </div>

                        @if($canManageImpact ?? false)
                            <div class="mt-4 pt-3 border-t border-slate-200 flex items-center justify-between text-xs">
                                <button @click="updateModal = true; activeMetric = { id: {{ $metric->id }}, name: '{{ addslashes($metric->metric_name) }}', achieved: {{ $metric->achieved }} }" 
                                        class="font-bold text-emerald-600 hover:text-emerald-700">
                                    Update Capaian ✎
                                </button>
                                <form action="{{ route('group.impact.destroy', ['group' => $group->id, 'metric' => $metric->id]) }}" method="POST" onsubmit="return confirm('Hapus metrik ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold">&times;</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="col-span-full p-8 rounded-2xl bg-slate-50 text-center text-xs text-slate-500">
                        Belum ada metrik capaian yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Add Metric Modal -->
        <div x-show="metricModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="metricModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Indikator Capaian Baru</h3>
                <form action="{{ route('group.impact.store', $group->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Indikator</label>
                        <input type="text" name="metric_name" required placeholder="Contoh: Jumlah UMKM Memiliki Katalog Digital" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                            <select name="category" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                <option value="UMKM">UMKM & Ekonomi</option>
                                <option value="TOURISM">Pariwisata</option>
                                <option value="EDUCATION">Edukasi & Pelatihan</option>
                                <option value="HEALTH">Kesehatan</option>
                                <option value="ENVIRONMENT">Lingkungan</option>
                                <option value="GENERAL">Umum</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Satuan (Unit)</label>
                            <input type="text" name="unit" required placeholder="usaha / orang / kegiatan" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Baseline (Awal)</label>
                            <input type="number" name="baseline" value="0" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Target</label>
                            <input type="number" name="target" value="25" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Capaian Saat Ini</label>
                            <input type="number" name="achieved" value="20" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Keterangan Tambahan</label>
                        <textarea name="description" rows="2" placeholder="Catatan tolak ukur..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="metricModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Indikator</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Update Metric Modal -->
        <div x-show="updateModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="updateModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-1">Perbarui Angka Capaian</h3>
                <p class="text-xs text-slate-500 mb-4" x-text="activeMetric.name"></p>
                <form :action="'{{ url('workspace/group') }}/{{ $group->id }}/impact/' + activeMetric.id" method="POST" class="space-y-4 text-xs">
                    @csrf
                    @method('PUT')
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Angka Capaian Terkini</label>
                        <input type="number" name="achieved" x-model="activeMetric.achieved" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Catatan Tambahan (Opsional)</label>
                        <textarea name="description" rows="2" placeholder="Keterangan perkembangan..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="updateModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app>

