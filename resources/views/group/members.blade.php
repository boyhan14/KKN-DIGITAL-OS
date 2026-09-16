<x-layouts.app :pageHeading="'Anggota Kelompok — ' . $group->group_name">
    <div class="space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Mahasiswa & Dosen Pembimbing</h2>
                <p class="text-xs text-slate-500 mt-1">Struktur tim pelaksana pengabdian masyarakat KKN di Desa {{ $group->village->name ?? '-' }}.</p>
            </div>
            <a href="{{ route('group.workspace', $group->id) }}" class="inline-flex items-center text-xs font-bold text-slate-600 hover:text-emerald-600">
                ← Kembali ke Workspace
            </a>
        </div>

        <!-- Supervisor Card -->
        @if($group->supervisor)
            <div class="p-6 rounded-3xl bg-emerald-950 text-white shadow-md flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-600 flex items-center justify-center text-white font-black text-2xl">
                        {{ substr($group->supervisor->name, 0, 1) }}
                    </div>
                    <div>
                        <span class="text-xs font-bold text-emerald-400 uppercase tracking-wider block">Dosen Pembimbing Lapangan (DPL)</span>
                        <h3 class="text-xl font-bold text-white mt-0.5">{{ $group->supervisor->name }}</h3>
                        <p class="text-xs text-slate-300 mt-0.5">{{ $group->supervisor->email }} | {{ $group->supervisor->phone ?? 'Kontak via email' }}</p>
                    </div>
                </div>
                <span class="hidden sm:inline-flex px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-xs font-semibold border border-emerald-500/30">
                    Pembimbing Resmi
                </span>
            </div>
        @endif

        <!-- Students Roster Grid -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-900">Mahasiswa Kelompok ({{ $group->members->count() }} Orang)</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($group->members as $member)
                    <div class="p-5 rounded-3xl bg-white border border-slate-200 shadow-xs flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <span class="text-[10px] font-mono px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 font-bold">
                                    {{ $member->student_id ?? 'NIM' }}
                                </span>
                                @if($member->pivot->role === 'LEADER')
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">
                                        Ketua Kelompok
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-semibold">
                                        Anggota
                                    </span>
                                @endif
                            </div>

                            <h4 class="text-base font-bold text-slate-900">{{ $member->name }}</h4>
                            <p class="text-xs text-emerald-700 font-medium mt-0.5">
                                {{ $member->major ?? 'Program Studi' }} {{ $member->faculty ? '— ' . $member->faculty : '' }}
                            </p>
                            
                            @if($member->pivot->contribution_notes)
                                <p class="text-xs text-slate-500 mt-2 p-2 rounded-xl bg-slate-50 border border-slate-100 italic">
                                    "{{ $member->pivot->contribution_notes }}"
                                </p>
                            @endif
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 text-[11px] text-slate-400 flex items-center justify-between">
                            <span>{{ $member->email }}</span>
                            <span>{{ $member->phone ?? '-' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 rounded-2xl bg-white border border-slate-200 text-center text-sm text-slate-500">
                        Belum ada anggota mahasiswa yang ditambahkan.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-layouts.app>

