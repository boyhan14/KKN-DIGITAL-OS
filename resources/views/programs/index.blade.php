<x-layouts.app :pageHeading="'Program Kerja — ' . $group->group_name">
    <div class="space-y-8" x-data="{ createModal: false, aiLoading: false, titleInput: '', categoryInput: 'DIGITALIZATION', descInput: '', objectiveInput: '' }">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Program Kerja KKN</h2>
                <p class="text-xs text-slate-500 mt-1">Susun rencana aksi, target luaran, dan pantau penyelesaian setiap program kerja di desa.</p>
            </div>
            
            @if(!$isLocked)
                <button @click="createModal = true" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center space-x-2 self-start">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Program Kerja</span>
                </button>
            @endif
        </div>

        <!-- Programs Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($programs as $prog)
                <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex flex-col justify-between hover:border-emerald-500/60 transition">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-[10px] font-bold border border-emerald-200">
                                {{ $prog->category }}
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold {{ $prog->status === 'COMPLETED' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $prog->status }}
                            </span>
                        </div>

                        <h3 class="text-base font-extrabold text-slate-900 leading-snug">{{ $prog->title }}</h3>
                        <p class="text-xs text-slate-600 mt-2 line-clamp-3 leading-relaxed">
                            {{ $prog->description }}
                        </p>

                        @if($prog->objective)
                            <div class="mt-3 p-3 rounded-xl bg-slate-50 border border-slate-100 text-xs">
                                <span class="font-bold text-slate-700 block text-[11px] mb-0.5">Tujuan & Target:</span>
                                <p class="text-slate-600 line-clamp-2">{{ $prog->objective }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                        <span class="font-semibold text-slate-500">{{ $prog->tasks->count() }} Tugas di Kanban</span>
                        <a href="{{ route('group.programs.show', ['group' => $group->id, 'program' => $prog->id]) }}" class="font-bold text-emerald-600 hover:text-emerald-700">
                            Buka Papan Kanban →
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 rounded-3xl bg-white border border-slate-200 text-center">
                    <p class="text-sm font-bold text-slate-700">Belum ada program kerja yang dibuat.</p>
                    <p class="text-xs text-slate-500 mt-1">Klik tombol di atas untuk menambahkan program kerja pertama kelompok Anda.</p>
                </div>
            @endforelse
        </div>

        <!-- Create Program Modal with AI Draft Helper -->
        <div x-show="createModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-xl w-full shadow-2xl border border-slate-200 max-h-[90vh] overflow-y-auto" @click.away="createModal = false">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-slate-900">Tambah Program Kerja Baru</h3>
                    <button @click="createModal = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form action="{{ route('group.programs.store', $group->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul Program Kerja</label>
                        <input type="text" name="title" x-model="titleInput" required placeholder="Contoh: Digitalisasi Katalog dan Pemasaran UMKM Desa" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Bidang / Kategori</label>
                            <select name="category" x-model="categoryInput" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                <option value="DIGITALIZATION">Digitalisasi Desa</option>
                                <option value="ECONOMY">Ekonomi & UMKM</option>
                                <option value="TOURISM">Pariwisata</option>
                                <option value="EDUCATION">Pendidikan</option>
                                <option value="HEALTH">Kesehatan</option>
                                <option value="ENVIRONMENT">Lingkungan</option>
                                <option value="AGRICULTURE">Pertanian</option>
                                <option value="SOCIAL">Sosial Budaya</option>
                                <option value="GOVERNANCE">Tata Kelola</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Prioritas</label>
                            <select name="priority" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                <option value="MEDIUM">Medium</option>
                                <option value="HIGH">Tinggi (High)</option>
                                <option value="URGENT">Mendesak (Urgent)</option>
                                <option value="LOW">Rendah (Low)</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="font-bold text-slate-700">Tujuan & Sasaran Program</label>
                            <!-- AI Drafting Assistant Trigger -->
                            <button type="button" 
                                    @click="
                                        aiLoading = true;
                                        fetch('{{ route('ai.draft') }}', {
                                            method: 'POST',
                                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                                            body: JSON.stringify({ type: 'program_description', title: titleInput, category: categoryInput, objective: objectiveInput })
                                        })
                                        .then(res => res.json())
                                        .then(data => { descInput = data.draft; aiLoading = false; })
                                        .catch(() => { aiLoading = false; });
                                    "
                                    class="text-[11px] font-bold text-emerald-600 hover:text-emerald-700 flex items-center space-x-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span x-text="aiLoading ? 'Menyusun draft...' : '✨ Bantu susun narasi AI'"></span>
                            </button>
                        </div>
                        <input type="text" name="objective" x-model="objectiveInput" placeholder="Contoh: Meningkatkan literasi pemasaran daring 25 pelaku UMKM" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Pelaksanaan</label>
                        <textarea name="description" x-model="descInput" rows="4" placeholder="Uraian langkah kerja program, metode pelatihan, dan pendampingan..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs leading-relaxed"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Tanggal Selesai</label>
                            <input type="date" name="end_date" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="createModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Program</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app>

