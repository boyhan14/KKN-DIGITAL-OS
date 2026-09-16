<x-layouts.app :pageHeading="'Struktur Tim & Anggota — ' . $group->group_name">
    <div x-data="{ 
        addModalOpen: false, 
        editModalOpen: false,
        activeTab: 'existing',
        editMemberId: null,
        editMemberName: '',
        editRole: 'MEMBER',
        editNotes: '',
        openEdit(id, name, role, notes) {
            this.editMemberId = id;
            this.editMemberName = name;
            this.editRole = role;
            this.editNotes = notes;
            this.editModalOpen = true;
        }
    }" class="space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase tracking-wider">
                        Tim Pelaksana Lapangan
                    </span>
                    <span class="text-xs text-slate-400">•</span>
                    <span class="text-xs font-semibold text-slate-600">Kode: {{ $group->group_code }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">Struktur Tim Mahasiswa & DPL</h2>
                <p class="text-xs text-slate-500 mt-0.5">Tata kelola pembagian peran divisi pengabdian masyarakat di Desa {{ $group->village->name ?? '-' }}.</p>
            </div>
            
            <div class="flex items-center gap-3">
                @if($canManageMembers)
                    <button @click="addModalOpen = true" type="button" class="btn-shimmer px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md shadow-emerald-600/20 transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        <span>+ Tambah Anggota Mahasiswa</span>
                    </button>
                @endif
                <a href="{{ route('group.workspace', $group->id) }}" class="inline-flex items-center text-xs font-bold text-slate-600 hover:text-emerald-600 px-3 py-2 rounded-xl bg-white border border-slate-200">
                    ← Ke Workspace
                </a>
            </div>
        </div>

        <!-- Role Context Banner: Visually Explaining Permissions -->
        @if($canManageMembers)
            <div class="p-5 rounded-3xl bg-gradient-to-r from-emerald-950 via-slate-900 to-teal-950 text-white border border-emerald-500/30 shadow-lg relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="relative z-10 flex items-start space-x-4">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-500/20 border border-emerald-400/40 flex items-center justify-center text-emerald-300 text-xl font-black shrink-0">
                        👑
                    </div>
                    <div class="flex-1 text-xs">
                        <div class="flex items-center space-x-2">
                            <h3 class="font-extrabold text-white text-sm">Akses Khusus: Administrator & Ketua Kelompok</h3>
                            <span class="px-2 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-mono text-[10px] font-bold border border-emerald-400/30">FULL ACCESS</span>
                        </div>
                        <p class="text-slate-300 mt-1 leading-relaxed">
                            Sebagai Ketua Kelompok atau Admin LPPM, Anda berwenang penuh untuk <strong>menambah anggota baru</strong>, <strong>menetapkan pembagian divisi kerja</strong>, <strong>mengubah peran ketua/anggota</strong>, serta <strong>mengeluarkan anggota</strong> dari formasi tim.
                        </p>
                    </div>
                </div>
            </div>
        @elseif($isSupervisor)
            <div class="p-5 rounded-3xl bg-gradient-to-r from-purple-950 via-slate-900 to-indigo-950 text-white border border-purple-500/30 shadow-lg relative overflow-hidden">
                <div class="relative z-10 flex items-start space-x-4">
                    <div class="w-10 h-10 rounded-2xl bg-purple-500/20 border border-purple-400/40 flex items-center justify-center text-purple-300 text-xl font-black shrink-0">
                        🎓
                    </div>
                    <div class="flex-1 text-xs">
                        <h3 class="font-extrabold text-white text-sm">Mode Pengawasan DPL (Dosen Pembimbing Lapangan)</h3>
                        <p class="text-slate-300 mt-1 leading-relaxed">
                            Anda bertindak sebagai pembimbing akademik untuk seluruh mahasiswa di kelompok ini. Anda dapat meninjau keaktifan kontribusi divisi dan mengevaluasi kinerja program kerja di Desa {{ $group->village->name ?? '-' }}.
                        </p>
                    </div>
                </div>
            </div>
        @elseif($isVillageAdmin)
            <div class="p-5 rounded-3xl bg-gradient-to-r from-amber-950 via-slate-900 to-yellow-950 text-white border border-amber-500/30 shadow-lg relative overflow-hidden">
                <div class="relative z-10 flex items-start space-x-4">
                    <div class="w-10 h-10 rounded-2xl bg-amber-500/20 border border-amber-400/40 flex items-center justify-center text-amber-300 text-xl font-black shrink-0">
                        🏛️
                    </div>
                    <div class="flex-1 text-xs">
                        <h3 class="font-extrabold text-white text-sm">Delegasi Mahasiswa KKN di Desa {{ $group->village->name ?? '-' }}</h3>
                        <p class="text-slate-300 mt-1 leading-relaxed">
                            Pemerintah Desa dapat memanfaatkan kontak langsung (WhatsApp/Email) di bawah untuk berkoordinasi dengan Ketua Kelompok maupun anggota divisi terkait kegiatan pendampingan masyarakat.
                        </p>
                    </div>
                </div>
            </div>
        @else
            <div class="p-4 rounded-2xl bg-cyan-50/80 border border-cyan-200 text-cyan-950 text-xs flex items-start space-x-3">
                <div class="w-7 h-7 rounded-xl bg-cyan-600 text-white flex items-center justify-center font-bold text-xs shrink-0">
                    ℹ️
                </div>
                <div>
                    <strong class="font-bold text-cyan-900">Mode Anggota Tim Mahasiswa:</strong>
                    <span class="text-cyan-800 ml-1">
                        Anda terdaftar sebagai pelaksana lapangan. Penambahan anggota, alokasi divisi tugas, dan struktur formasi kelompok dikoordinasikan langsung oleh <strong>Ketua Kelompok</strong> atau <strong>LPPM Kampus</strong>.
                    </span>
                </div>
            </div>
        @endif

        <!-- Supervisor Card -->
        @if($group->supervisor)
            <div class="p-6 rounded-3xl bg-slate-900 text-white shadow-lg border border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-400 flex items-center justify-center text-white font-black text-2xl shadow-md">
                        {{ substr($group->supervisor->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="flex items-center space-x-2">
                            <span class="text-[10px] font-mono font-extrabold px-2 py-0.5 rounded-md bg-emerald-500/20 text-emerald-300 uppercase tracking-wider border border-emerald-500/30">
                                Dosen Pembimbing Lapangan (DPL)
                            </span>
                        </div>
                        <h3 class="text-lg font-black text-white mt-1">{{ $group->supervisor->name }}</h3>
                        <p class="text-xs text-slate-300 mt-0.5 flex items-center space-x-3">
                            <span>📧 {{ $group->supervisor->email }}</span>
                            @if($group->supervisor->phone)
                                <span>📞 {{ $group->supervisor->phone }}</span>
                            @endif
                        </p>
                    </div>
                </div>
                
                @if($group->supervisor->phone)
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $group->supervisor->phone) }}" target="_blank" class="px-4 py-2 rounded-xl bg-emerald-600/20 hover:bg-emerald-600/30 text-emerald-300 border border-emerald-500/30 font-bold text-xs transition flex items-center space-x-2 shrink-0">
                        <span>💬 Chat DPL</span>
                    </a>
                @endif
            </div>
        @endif

        <!-- Students Roster Grid -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-black text-slate-900">Mahasiswa Pelaksana ({{ $group->members->count() }} Orang)</h3>
                    <p class="text-xs text-slate-500">Daftar personil mahasiswa yang bertugas melaksanakan program kerja di lapangan.</p>
                </div>
                @if($canManageMembers)
                    <button @click="addModalOpen = true" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">
                        + Tambah Baru
                    </button>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($group->members as $member)
                    <div class="card-lift p-5 rounded-3xl bg-white border border-slate-200/80 shadow-md flex flex-col justify-between relative overflow-hidden group">
                        <!-- Top Decor Accent -->
                        @if($member->pivot->role === 'LEADER')
                            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-emerald-500 via-teal-400 to-emerald-600"></div>
                        @endif

                        <div>
                            <!-- Badge Header -->
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] font-mono px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-700 font-extrabold border border-slate-200/60">
                                    {{ $member->student_id ?? 'NIM Belum Ada' }}
                                </span>
                                
                                @if($member->pivot->role === 'LEADER')
                                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-900 text-[10px] font-black flex items-center space-x-1 border border-emerald-200">
                                        <span>👑</span>
                                        <span>Ketua Kelompok</span>
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">
                                        Anggota
                                    </span>
                                @endif
                            </div>

                            <h4 class="text-base font-black text-slate-900 tracking-tight">{{ $member->name }}</h4>
                            <p class="text-xs text-emerald-800 font-bold mt-0.5">
                                {{ $member->major ?? 'Program Studi' }} {{ $member->faculty ? '• ' . $member->faculty : '' }}
                            </p>
                            
                            <!-- Division Notes -->
                            <div class="mt-3 p-3 rounded-2xl bg-slate-50/80 border border-slate-200/70">
                                <span class="text-[9px] font-extrabold text-slate-400 uppercase tracking-wider block mb-0.5">Penugasan Divisi / Peran</span>
                                <p class="text-xs text-slate-800 font-semibold">
                                    {{ $member->pivot->contribution_notes ?? 'Belum ditentukan divisi tugas' }}
                                </p>
                            </div>
                        </div>

                        <!-- Card Footer / Actions -->
                        <div class="mt-5 pt-3 border-t border-slate-100 flex flex-col gap-2.5">
                            <div class="text-[11px] text-slate-400 flex items-center justify-between">
                                <span class="truncate">{{ $member->email }}</span>
                                <span class="font-mono text-slate-600">{{ $member->phone ?? '-' }}</span>
                            </div>

                            <!-- Action Bar tailored by Role -->
                            @if($canManageMembers)
                                <div class="flex items-center gap-2 pt-2 border-t border-slate-100/60">
                                    <button 
                                        @click="openEdit({{ $member->id }}, '{{ addslashes($member->name) }}', '{{ $member->pivot->role }}', '{{ addslashes($member->pivot->contribution_notes ?? '') }}')" 
                                        type="button" 
                                        class="flex-1 py-1.5 px-3 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-700 hover:text-emerald-800 font-bold text-[11px] transition text-center"
                                    >
                                        ✏️ Edit Divisi/Peran
                                    </button>

                                    <form action="{{ route('group.members.destroy', ['group' => $group->id, 'member' => $member->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin mengeluarkan {{ addslashes($member->name) }} dari kelompok?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-[11px] transition" title="Keluarkan dari kelompok">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            @elseif($isVillageAdmin && $member->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone) }}" target="_blank" class="w-full py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-[11px] text-center transition flex items-center justify-center space-x-1">
                                    <span>💬 Hubungi via WhatsApp</span>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 rounded-3xl bg-white border border-slate-200 text-center space-y-3">
                        <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-400 mx-auto flex items-center justify-center text-xl">
                            👥
                        </div>
                        <h4 class="text-base font-bold text-slate-700">Belum ada anggota mahasiswa</h4>
                        <p class="text-xs text-slate-400 max-w-sm mx-auto">Kelompok KKN ini belum memiliki formasi mahasiswa. Klik tombol tambah anggota di atas untuk menetapkan mahasiswa.</p>
                        @if($canManageMembers)
                            <button @click="addModalOpen = true" class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-bold text-xs shadow-md">
                                + Tambah Anggota Sekarang
                            </button>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

        <!-- MODAL 1: Tambah Anggota Mahasiswa (Ketua / LPPM Only) -->
        @if($canManageMembers)
            <div x-show="addModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="addModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="addModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
                    
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="addModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-200">
                        
                        <div class="p-6 sm:p-8 space-y-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center text-xl font-bold">
                                        ➕
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-black text-slate-900">Tambah Anggota Mahasiswa</h3>
                                        <p class="text-xs text-slate-500">Tetapkan mahasiswa baru ke kelompok {{ $group->group_name }}</p>
                                    </div>
                                </div>
                                <button @click="addModalOpen = false" type="button" class="text-slate-400 hover:text-slate-600">✕</button>
                            </div>

                            <!-- Mode Switcher -->
                            <div class="flex p-1 rounded-xl bg-slate-100 text-xs font-bold">
                                <button @click="activeTab = 'existing'" type="button" :class="activeTab === 'existing' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-1.5 rounded-lg transition">
                                    Pilih Mahasiswa Terdaftar
                                </button>
                                <button @click="activeTab = 'new'" type="button" :class="activeTab === 'new' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-700'" class="flex-1 py-1.5 rounded-lg transition">
                                    Daftarkan Mahasiswa Baru
                                </button>
                            </div>

                            <form action="{{ route('group.members.store', $group->id) }}" method="POST" class="space-y-4 text-xs">
                                @csrf

                                <!-- Tab 1: Existing Student -->
                                <div x-show="activeTab === 'existing'" class="space-y-3">
                                    <label class="block font-bold text-slate-700">Pilih Akun Mahasiswa</label>
                                    @if($availableStudents->isEmpty())
                                        <div class="p-3 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-[11px]">
                                            Tidak ada mahasiswa bebas kelompok. Silakan gunakan tab <strong>"Daftarkan Mahasiswa Baru"</strong> untuk menginput profil anggota baru.
                                        </div>
                                    @else
                                        <select name="user_id" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white font-medium">
                                            <option value="">-- Pilih Mahasiswa --</option>
                                            @foreach($availableStudents as $s)
                                                <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->student_id ?? 'NIM' }}) — {{ $s->major ?? 'Umum' }}</option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>

                                <!-- Tab 2: New Student -->
                                <div x-show="activeTab === 'new'" class="space-y-3">
                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Nama Lengkap Mahasiswa *</label>
                                        <input type="text" name="new_name" placeholder="cth: Rahmat Hidayat" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">Alamat Email *</label>
                                            <input type="email" name="new_email" placeholder="rahmat@univ.ac.id" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                                        </div>
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">NIM *</label>
                                            <input type="text" name="new_student_id" placeholder="202401004" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">Program Studi</label>
                                            <input type="text" name="new_major" placeholder="Ilmu Komputer" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                                        </div>
                                        <div>
                                            <label class="block font-bold text-slate-700 mb-1">Fakultas</label>
                                            <input type="text" name="new_faculty" placeholder="Fakultas Teknik" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                                        </div>
                                    </div>
                                </div>

                                <!-- Common Fields: Role & Division -->
                                <div class="pt-2 border-t border-slate-100 space-y-3">
                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Peran Struktural *</label>
                                        <select name="role" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs bg-white">
                                            <option value="MEMBER">Anggota Mahasiswa</option>
                                            <option value="LEADER">Ketua Kelompok (Koordinator Utama)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block font-bold text-slate-700 mb-1">Divisi / Penugasan Kerja</label>
                                        <input type="text" name="contribution_notes" placeholder="cth: Divisi UMKM & Ekonomi Kreatif" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                                        
                                        <!-- Division Presets Quick Tags -->
                                        <div class="flex flex-wrap gap-1.5 mt-2">
                                            <span class="text-[10px] text-slate-400 font-semibold self-center">Pilihan cepat:</span>
                                            <button type="button" @click="$el.closest('form').querySelector('[name=contribution_notes]').value = 'Divisi UMKM & Ekonomi Kreatif'" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-emerald-100 text-slate-700 text-[10px] font-bold">UMKM</button>
                                            <button type="button" @click="$el.closest('form').querySelector('[name=contribution_notes]').value = 'Divisi Web GIS & Lingkungan'" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-emerald-100 text-slate-700 text-[10px] font-bold">Web GIS</button>
                                            <button type="button" @click="$el.closest('form').querySelector('[name=contribution_notes]').value = 'Divisi Pariwisata & Media Publikasi'" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-emerald-100 text-slate-700 text-[10px] font-bold">Wisata/Media</button>
                                            <button type="button" @click="$el.closest('form').querySelector('[name=contribution_notes]').value = 'Sekretaris & Administrasi Tim'" class="px-2 py-0.5 rounded-md bg-slate-100 hover:bg-emerald-100 text-slate-700 text-[10px] font-bold">Sekretaris</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 flex items-center justify-end space-x-3">
                                    <button @click="addModalOpen = false" type="button" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-md shadow-emerald-600/20">
                                        Simpan Anggota
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MODAL 2: Edit Divisi & Peran Anggota -->
            <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="editModalOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>
                    
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                    <div x-show="editModalOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full border border-slate-200">
                        
                        <div class="p-6 sm:p-8 space-y-5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center text-xl font-bold">
                                        ✏️
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-black text-slate-900">Perbarui Peran / Divisi</h3>
                                        <p class="text-xs text-slate-500" x-text="'Mahasiswa: ' + editMemberName"></p>
                                    </div>
                                </div>
                                <button @click="editModalOpen = false" type="button" class="text-slate-400 hover:text-slate-600">✕</button>
                            </div>

                            <form :action="'{{ url('/workspace/group/' . $group->id . '/members') }}/' + editMemberId" method="POST" class="space-y-4 text-xs">
                                @csrf
                                @method('PUT')

                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Peran Struktural *</label>
                                    <select name="role" x-model="editRole" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs bg-white">
                                        <option value="MEMBER">Anggota</option>
                                        <option value="LEADER">Ketua Kelompok (Koordinator Utama)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block font-bold text-slate-700 mb-1">Penugasan Divisi / Catatan Kontribusi</label>
                                    <input type="text" name="contribution_notes" x-model="editNotes" placeholder="cth: Divisi UMKM, Divisi Kesehatan, dsb." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                                </div>

                                <div class="pt-4 flex items-center justify-end space-x-3">
                                    <button @click="editModalOpen = false" type="button" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold hover:bg-slate-200">
                                        Batal
                                    </button>
                                    <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-md shadow-emerald-600/20">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
</x-layouts.app>
