<x-layouts.app :pageHeading="'Dashboard Kampus — ' . ($campus->name ?? 'Perguruan Tinggi')">
    <div class="space-y-8" x-data="{ programModal: false, villageModal: false, groupModal: false, assignModal: false, selectedGroup: null }">
        
        <!-- Header & Quick Action Buttons -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen KKN & Desa Binaan</h2>
                <p class="text-xs text-slate-500 mt-1">Kelola seluruh program KKN, alokasi desa, kelompok mahasiswa, dan dosen pembimbing.</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <button @click="programModal = true" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-sm transition flex items-center space-x-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Buat Program KKN</span>
                </button>
                <button @click="villageModal = true" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs border border-slate-300 shadow-xs transition flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Tambah Desa</span>
                </button>
                <button @click="groupModal = true" class="px-4 py-2 rounded-xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-xs border border-slate-300 shadow-xs transition flex items-center space-x-1.5">
                    <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span>Bentuk Kelompok</span>
                </button>
            </div>
        </div>

        <!-- Campus Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Program KKN</div>
                <div class="text-2xl font-black text-slate-900 mt-1">{{ $stats['total_programs'] }}</div>
                <div class="text-[11px] text-emerald-600 mt-1 font-semibold">Tahun Aktif 2026</div>
            </div>
            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Desa Binaan</div>
                <div class="text-2xl font-black text-emerald-600 mt-1">{{ $stats['active_villages'] }}</div>
                <div class="text-[11px] text-slate-500 mt-1">Terhubung ke Portal Publik</div>
            </div>
            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kelompok Mahasiswa</div>
                <div class="text-2xl font-black text-teal-600 mt-1">{{ $stats['total_groups'] }}</div>
                <div class="text-[11px] text-slate-500 mt-1">Berjalan Lapangan</div>
            </div>
            <div class="p-5 rounded-2xl bg-white border border-slate-200 shadow-xs">
                <div class="text-xs font-bold text-slate-500 uppercase tracking-wider">Mahasiswa Bertugas</div>
                <div class="text-2xl font-black text-slate-900 mt-1">{{ $stats['total_students'] }}</div>
                <div class="text-[11px] text-slate-500 mt-1">Terdaftar Aktif</div>
            </div>
        </div>

        <!-- Groups & Allocation Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-5 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Daftar Kelompok KKN & Status Lapangan</h3>
                    <p class="text-xs text-slate-500">Monitor kemajuan kelompok dan serah terima aset digital desa.</p>
                </div>
            </div>

            @if($groups->isEmpty())
                <div class="p-12 text-center">
                    <p class="text-sm text-slate-500">Belum ada kelompok KKN yang dibentuk.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 text-slate-600 uppercase font-bold border-b border-slate-200">
                            <tr>
                                <th class="px-5 py-3.5">Kelompok & Kode</th>
                                <th class="px-5 py-3.5">Desa Lokasi</th>
                                <th class="px-5 py-3.5">DPL / Supervisor</th>
                                <th class="px-5 py-3.5">Ketua & Anggota</th>
                                <th class="px-5 py-3.5">Status KKN</th>
                                <th class="px-5 py-3.5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($groups as $group)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-5 py-4 font-bold text-slate-900">
                                        <div class="text-sm font-extrabold text-slate-900">{{ $group->group_name }}</div>
                                        <span class="text-[11px] font-mono text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">
                                            {{ $group->group_code }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-bold text-slate-800">Desa {{ $group->village->name ?? '-' }}</div>
                                        <div class="text-[11px] text-slate-500">{{ $group->village->district ?? '' }}, {{ $group->village->regency ?? '' }}</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($group->supervisor)
                                            <div class="font-medium text-slate-900">{{ $group->supervisor->name }}</div>
                                            <div class="text-[11px] text-slate-500">{{ $group->supervisor->email }}</div>
                                        @else
                                            <span class="text-slate-400 italic">Belum ditugaskan</span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="font-medium text-slate-900">Ketua: {{ $group->leader->name ?? '-' }}</div>
                                        <div class="text-[11px] text-slate-500 font-semibold text-emerald-700">{{ $group->members->count() }} Mahasiswa</div>
                                    </td>
                                    <td class="px-5 py-4">
                                        @if($group->status === 'COMPLETED')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                                                ✓ Selesai & Handover
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                                                Aktif Berjalan
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-4 text-right space-x-2">
                                        <a href="{{ route('group.workspace', $group->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 text-emerald-700 font-bold border border-emerald-200 transition">
                                            Buka Workspace
                                        </a>
                                        <button @click="assignModal = true; selectedGroup = {{ $group->id }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition">
                                            + Anggota
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Participating Villages Section -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-xs p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-900">Desa Binaan & Tautan Portal Publik</h3>
                <span class="text-xs text-slate-500">Otomatis memiliki slug publik siap akses</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($villages as $v)
                    <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50 hover:bg-white hover:border-emerald-500 transition">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Desa {{ $v->name }}</span>
                            <span class="text-[11px] px-2 py-0.5 rounded-full bg-slate-200 text-slate-700 font-semibold">{{ ucfirst($v->theme) }} Theme</span>
                        </div>
                        <p class="text-xs text-slate-600 line-clamp-2 mb-3">
                            {{ $v->district }}, {{ $v->regency }}, {{ $v->province }}
                        </p>
                        <div class="flex items-center justify-between pt-2 border-t border-slate-200 text-xs">
                            <a href="{{ route('village.profile.edit', $v->id) }}" class="font-bold text-slate-700 hover:text-emerald-700">
                                Kelola Data Desa →
                            </a>
                            <a href="{{ route('public.village.home', $v->slug) }}" target="_blank" class="font-bold text-emerald-600 hover:text-emerald-700 flex items-center space-x-1">
                                <span>Website</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal 1: Create Program KKN -->
        <div x-show="programModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl border border-slate-200" @click.away="programModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Buat Program KKN Baru</h3>
                <form action="{{ route('campus.programs.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Program KKN</label>
                        <input type="text" name="name" required placeholder="Contoh: KKN Tematik Digitalisasi Desa 2026" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Tahun</label>
                            <input type="text" name="year" value="2026" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Periode</label>
                            <input type="text" name="period" value="Periode 1" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
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
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi / Sasaran</label>
                        <textarea name="description" rows="3" placeholder="Fokus pengabdian, tujuan, dll." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="programModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Program</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal 2: Add Village -->
        <div x-show="villageModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl border border-slate-200" @click.away="villageModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Desa Binaan Baru</h3>
                <form action="{{ route('campus.villages.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Desa</label>
                        <input type="text" name="name" required placeholder="Contoh: Sukamaju" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Kecamatan</label>
                            <input type="text" name="district" required value="Gedong Tataan" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Kabupaten</label>
                            <input type="text" name="regency" required value="Pesawaran" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Provinsi</label>
                            <input type="text" name="province" required value="Lampung" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Nama Kepala Desa</label>
                            <input type="text" name="head_name" placeholder="Bapak Kepala Desa" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Kontak / WhatsApp Desa</label>
                            <input type="text" name="contact" placeholder="08xxxxxxxxxx" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Pilihan Tema Portal</label>
                            <select name="theme" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                <option value="modern">Modern (Emerald Civic-Tech)</option>
                                <option value="nature">Nature (Earthy Forest)</option>
                                <option value="heritage">Heritage (Warm Cultural)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Program KKN</label>
                            <select name="kkn_program_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                @foreach($kknPrograms as $kp)
                                    <option value="{{ $kp->id }}">{{ $kp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="villageModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Daftarkan Desa</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal 3: Create Group -->
        <div x-show="groupModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl border border-slate-200" @click.away="groupModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Bentuk Kelompok KKN Baru</h3>
                <form action="{{ route('campus.groups.store') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Program KKN</label>
                        <select name="kkn_program_id" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            @foreach($kknPrograms as $kp)
                                <option value="{{ $kp->id }}">{{ $kp->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Desa Penempatan</label>
                        <select name="village_id" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            @foreach($villages as $v)
                                <option value="{{ $v->id }}">Desa {{ $v->name }} ({{ $v->district }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Nama Kelompok</label>
                            <input type="text" name="group_name" required placeholder="Kelompok 01 Sukamaju" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Kode Kelompok</label>
                            <input type="text" name="group_code" required placeholder="KKN-SKM-01" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Dosen Pembimbing (DPL)</label>
                            <select name="supervisor_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                <option value="">Pilih Dosen</option>
                                @foreach($supervisors as $sp)
                                    <option value="{{ $sp->id }}">{{ $sp->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Ketua Kelompok</label>
                            <select name="leader_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                <option value="">Pilih Mahasiswa</option>
                                @foreach($students as $st)
                                    <option value="{{ $st->id }}">{{ $st->name }} ({{ $st->student_id ?? 'Mahasiswa' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="groupModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Bentuk Kelompok</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal 4: Assign Student -->
        <div x-show="assignModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="assignModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Tambahkan Mahasiswa ke Kelompok</h3>
                <form :action="'{{ url('campus/groups') }}/' + selectedGroup + '/assign'" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Pilih Mahasiswa</label>
                        <select name="user_id" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            @foreach($students as $st)
                                <option value="{{ $st->id }}">{{ $st->name }} — {{ $st->student_id ?? 'NIM' }} ({{ $st->major ?? 'Umum' }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Peran di Kelompok</label>
                        <select name="role" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="MEMBER">Anggota</option>
                            <option value="LEADER">Ketua Kelompok</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Catatan Kontribusi / Divisi</label>
                        <input type="text" name="contribution_notes" placeholder="Contoh: Divisi Digitalisasi UMKM" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="assignModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app>

