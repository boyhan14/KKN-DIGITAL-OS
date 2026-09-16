<x-layouts.app :pageHeading="'Repositori Dokumen & Luaran — ' . $group->group_name">
    <div class="space-y-8" x-data="{ docModal: false }">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Repositori Dokumen & Luaran KKN</h2>
                <p class="text-xs text-slate-500 mt-1">Arsip dokumen terstruktur: laporan mingguan, materi modul pelatihan UMKM, dan presentasi luaran.</p>
            </div>
            
            @if($canUploadDocument ?? false)
                <button @click="docModal = true" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition flex items-center space-x-1.5 self-start">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Unggah Dokumen Baru</span>
                </button>
            @elseif(auth()->user()->isSupervisor())
                <div class="px-4 py-2 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-semibold flex items-center space-x-2 self-start shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    <span>Mode DPL: Memeriksa & Mengunduh Berkas Luaran Mahasiswa</span>
                </div>
            @endif
        </div>

        <!-- Documents Table -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <h3 class="text-base font-bold text-slate-900">Daftar Dokumen Tersimpan ({{ $documents->count() }} Berkas)</h3>
                <span class="text-xs text-slate-500">Pemisahan hak akses: PUBLIC, INTERNAL, PRIVATE</span>
            </div>

            @if($documents->isEmpty())
                <div class="p-12 text-center text-xs text-slate-500">
                    Belum ada berkas dokumen luaran yang diunggah.
                </div>
            @else
                <div class="divide-y divide-slate-100 text-xs">
                    @foreach($documents as $doc)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/80 transition">
                            <div class="flex items-start space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                    {{ $doc->file_type ?? 'PDF' }}
                                </div>
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <h4 class="text-sm font-bold text-slate-900">{{ $doc->title }}</h4>
                                        <span class="px-2 py-0.5 rounded-md text-[10px] font-bold 
                                            {{ $doc->visibility === 'PUBLIC' ? 'bg-emerald-100 text-emerald-800' : ($doc->visibility === 'PRIVATE' ? 'bg-rose-100 text-rose-800' : 'bg-slate-100 text-slate-700') }}">
                                            {{ $doc->visibility }}
                                        </span>
                                    </div>
                                    <p class="text-slate-500 text-[11px] mt-0.5">
                                        Program: <strong>{{ $doc->program->title ?? 'Umum Kelompok' }}</strong> | Diunggah {{ $doc->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 shrink-0">
                                <a href="{{ asset($doc->file_path) }}" target="_blank" class="px-3.5 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                                    Unduh Berkas ↗
                                </a>
                                @if($canUploadDocument ?? false)
                                    <form action="{{ route('group.documents.destroy', ['group' => $group->id, 'document' => $doc->id]) }}" method="POST" onsubmit="return confirm('Hapus dokumen ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-rose-500 hover:text-rose-700 font-bold">&times;</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Add Document Modal -->
        <div x-show="docModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="docModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Unggah Dokumen Luaran Baru</h3>
                <form action="{{ route('group.documents.store', $group->id) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul Dokumen</label>
                        <input type="text" name="title" required placeholder="Contoh: Modul Pelatihan Pemasaran Digital UMKM Sukamaju" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Terkait Program Kerja</label>
                        <select name="program_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="">Umum (Seluruh KKN)</option>
                            @foreach($programs as $p)
                                <option value="{{ $p->id }}">{{ $p->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Klasifikasi Akses / Visibilitas</label>
                        <select name="visibility" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="INTERNAL">INTERNAL (Hanya Tim KKN & Dosen)</option>
                            <option value="PUBLIC">PUBLIC (Dapat diunduh publik di web desa)</option>
                            <option value="PRIVATE">PRIVATE (Data sensitif / internal terbatas)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Path / URL File</label>
                        <input type="text" name="file_path" value="documents/modul-digitalisasi-umkm.pdf" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="docModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Dokumen</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app>

