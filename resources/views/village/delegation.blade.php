<x-layouts.app :pageHeading="'Delegasi Mahasiswa KKN — Desa ' . $village->name">
    <div class="space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-extrabold uppercase tracking-wider">
                        Aparatur Pemerintah Desa
                    </span>
                    <span class="text-xs text-slate-400">•</span>
                    <span class="text-xs font-semibold text-slate-600">Desa {{ $village->name }}</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight mt-1">Delegasi Mahasiswa KKN & Dosen Pembimbing</h2>
                <p class="text-xs text-slate-500 mt-0.5">Daftar personil mahasiswa pengabdian masyarakat yang bertugas di Desa {{ $village->name }} untuk memudahkan koordinasi aparatur desa.</p>
            </div>
            
            <a href="{{ route('village.dashboard', $village->id) }}" class="inline-flex items-center text-xs font-bold text-slate-600 hover:text-amber-600 px-3 py-2 rounded-xl bg-white border border-slate-200">
                ← Kembali ke Dashboard Desa
            </a>
        </div>

        @if(!$activeGroup)
            <div class="p-12 rounded-3xl bg-white border border-slate-200 text-center space-y-3">
                <span class="text-3xl">👥</span>
                <h3 class="text-base font-bold text-slate-700">Belum Ada Delegasi KKN</h3>
                <p class="text-xs text-slate-400">Saat ini belum ada kelompok KKN aktif yang teralokasi ke Desa {{ $village->name }}.</p>
            </div>
        @else
            <!-- DPL Supervisor Card -->
            @if($activeGroup->supervisor)
                <div class="p-6 rounded-3xl bg-slate-900 text-white shadow-xl border border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-amber-500 to-emerald-400 flex items-center justify-center text-white font-black text-2xl shadow-md">
                            {{ substr($activeGroup->supervisor->name, 0, 1) }}
                        </div>
                        <div>
                            <span class="text-[10px] font-mono font-extrabold px-2.5 py-0.5 rounded-md bg-amber-500/20 text-amber-300 uppercase tracking-wider border border-amber-500/30">
                                Dosen Pembimbing Lapangan (DPL)
                            </span>
                            <h3 class="text-lg font-black text-white mt-1">{{ $activeGroup->supervisor->name }}</h3>
                            <p class="text-xs text-slate-300 mt-0.5">
                                <span>📧 {{ $activeGroup->supervisor->email }}</span>
                                @if($activeGroup->supervisor->phone)
                                    <span class="ml-3">📞 {{ $activeGroup->supervisor->phone }}</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($activeGroup->supervisor->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $activeGroup->supervisor->phone) }}" target="_blank" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-md transition flex items-center space-x-2 shrink-0">
                            <span>💬 Hubungi DPL via WhatsApp</span>
                        </a>
                    @endif
                </div>
            @endif

            <!-- Students Delegation Roster -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h3 class="text-base font-black text-slate-900">Mahasiswa KKN Bertugas ({{ $activeGroup->members->count() }} Orang)</h3>
                        <p class="text-xs text-slate-500">Kelompok: {{ $activeGroup->group_name }} ({{ $activeGroup->group_code }})</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($activeGroup->members as $member)
                        <div class="card-lift p-5 rounded-3xl bg-white border border-slate-200/80 shadow-md flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] font-mono px-2.5 py-0.5 rounded-lg bg-slate-100 text-slate-700 font-extrabold">
                                        {{ $member->student_id ?? 'NIM' }}
                                    </span>
                                    
                                    @if($member->pivot->role === 'LEADER')
                                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-900 text-[10px] font-black flex items-center space-x-1 border border-emerald-200">
                                            <span>👑</span>
                                            <span>Ketua Kelompok</span>
                                        </span>
                                    @else
                                        <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold">
                                            Anggota Tim
                                        </span>
                                    @endif
                                </div>

                                <h4 class="text-base font-black text-slate-900">{{ $member->name }}</h4>
                                <p class="text-xs text-amber-800 font-bold mt-0.5">
                                    {{ $member->major ?? 'Program Studi' }} {{ $member->faculty ? '• ' . $member->faculty : '' }}
                                </p>

                                <div class="mt-3 p-3 rounded-2xl bg-amber-50/50 border border-amber-100">
                                    <span class="text-[9px] font-extrabold text-amber-800 uppercase tracking-wider block mb-0.5">Penugasan Lapangan</span>
                                    <p class="text-xs text-slate-800 font-semibold">
                                        {{ $member->pivot->contribution_notes ?? 'Divisi Umum KKN' }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 pt-3 border-t border-slate-100 flex flex-col gap-2">
                                <div class="text-[11px] text-slate-400 flex items-center justify-between">
                                    <span class="truncate">{{ $member->email }}</span>
                                    <span class="font-mono text-slate-600">{{ $member->phone ?? '-' }}</span>
                                </div>

                                @if($member->phone)
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $member->phone) }}" target="_blank" class="w-full py-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 font-bold text-xs text-center transition flex items-center justify-center space-x-1.5 border border-emerald-200">
                                        <span>💬 Hubungi via WhatsApp</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</x-layouts.app>
