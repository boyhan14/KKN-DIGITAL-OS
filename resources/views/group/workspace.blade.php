<x-layouts.app :pageHeading="$group->group_name . ' — Desa ' . ($group->village->name ?? '')">
    <div class="space-y-8">
        
        <!-- Workspace Banner & Handover Notice -->
        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-emerald-900 via-teal-900 to-emerald-950 text-white relative overflow-hidden shadow-lg">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-400/20 text-emerald-300 border border-emerald-400/30 text-xs font-bold">
                            {{ $group->group_code }}
                        </span>
                        <span class="text-xs text-emerald-300">Desa {{ $group->village->name ?? '-' }} ({{ $group->village->district ?? '' }}, {{ $group->village->regency ?? '' }})</span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black mt-2 tracking-tight">{{ $group->group_name }}</h2>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl">
                        Kelompok KKN resmi bertugas mendampingi digitalisasi desa, pendataan potensi UMKM, pembinaan pariwisata, dan serah terima aset digital desa.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <a href="{{ route('public.village.home', $group->village->slug) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 transition flex items-center space-x-1.5">
                        <span>Lihat Website Desa</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                    <a href="{{ route('group.handover.index', $group->id) }}" class="px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-md transition">
                        Kesiapan Handover ({{ $group->village->handoverReadinessScore() }}%) →
                    </a>
                </div>
            </div>

            @if($isLocked)
                <div class="mt-6 pt-4 border-t border-white/10 text-xs text-amber-200 flex items-center space-x-2">
                    <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <span><strong>Program Selesai / Handover Completed:</strong> Akses tulis operasional telah dialihkan kepada Perangkat Desa. Kelompok KKN dalam mode arsip read-only.</span>
                </div>
            @endif
        </div>

        <!-- Progress Overview & Task Summary -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Progress Card -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Total Kemajuan KKN</h3>
                    <span class="text-2xl font-black text-emerald-600">{{ $progressData['total'] }}%</span>
                </div>

                <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-3 rounded-full transition-all duration-500" style="width: {{ $progressData['total'] }}%"></div>
                </div>

                <!-- Breakdown -->
                <div class="space-y-2 pt-2 text-xs">
                    @foreach($progressData['breakdown'] as $key => $item)
                        <div class="flex items-center justify-between text-slate-600">
                            <span>{{ $item['label'] }}</span>
                            <span class="font-bold text-slate-900">{{ $item['score'] }} / {{ $item['max'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Kanban Task Status Counter -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Status Tugas (Kanban)</h3>
                    <a href="{{ route('group.programs.index', $group->id) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua →</a>
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/80">
                        <span class="text-xs text-slate-500 font-semibold block">TODO</span>
                        <span class="text-2xl font-black text-slate-800">{{ $taskCounts['todo'] }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200/80">
                        <span class="text-xs text-blue-700 font-semibold block">IN PROGRESS</span>
                        <span class="text-2xl font-black text-blue-900">{{ $taskCounts['in_progress'] }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200/80">
                        <span class="text-xs text-amber-700 font-semibold block">REVIEW</span>
                        <span class="text-2xl font-black text-amber-900">{{ $taskCounts['review'] }}</span>
                    </div>
                    <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80">
                        <span class="text-xs text-emerald-700 font-semibold block">DONE</span>
                        <span class="text-2xl font-black text-emerald-900">{{ $taskCounts['done'] }}</span>
                    </div>
                </div>

                <div class="pt-2 text-center">
                    <a href="{{ route('group.programs.index', $group->id) }}" class="w-full inline-block py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition">
                        Buka Papan Kanban Program Kerja
                    </a>
                </div>
            </div>

            <!-- Village Digital Assets Quick Links -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-3 text-xs">
                <h3 class="text-sm font-bold text-slate-900 mb-2">Aset Digital Desa Sukamaju</h3>
                
                <a href="{{ route('village.profile.edit', $group->village_id) }}" class="p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 flex items-center justify-between transition">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="font-bold text-slate-800">Profil & Fasilitas Desa</span>
                    </div>
                    <span class="text-[11px] text-emerald-700 font-semibold">Kelola →</span>
                </a>

                <a href="{{ route('village.umkm.index', $group->village_id) }}" class="p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 flex items-center justify-between transition">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="font-bold text-slate-800">Direktori UMKM ({{ $group->umkms->count() }})</span>
                    </div>
                    <span class="text-[11px] text-emerald-700 font-semibold">Kelola →</span>
                </a>

                <a href="{{ route('village.tourism.index', $group->village_id) }}" class="p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 flex items-center justify-between transition">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="font-bold text-slate-800">Potensi Wisata ({{ $group->tourismPlaces->count() }})</span>
                    </div>
                    <span class="text-[11px] text-emerald-700 font-semibold">Kelola →</span>
                </a>

                <a href="{{ route('village.map.index', $group->village_id) }}" class="p-3 rounded-xl bg-slate-50 hover:bg-emerald-50 border border-slate-200 flex items-center justify-between transition">
                    <div class="flex items-center space-x-2.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span class="font-bold text-slate-800">Peta Digital Interaktif</span>
                    </div>
                    <span class="text-[11px] text-emerald-700 font-semibold">Buka →</span>
                </a>
            </div>

        </div>

        <!-- Programs List -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Program Kerja Lapangan</h3>
                    <p class="text-xs text-slate-500">Daftar agenda program kerja yang dijalankan kelompok.</p>
                </div>
                <a href="{{ route('group.programs.index', $group->id) }}" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition">
                    + Tambah Program
                </a>
            </div>

            @if($group->programs->isEmpty())
                <div class="p-10 text-center text-xs text-slate-500">
                    Belum ada program kerja yang dibuat.
                </div>
            @else
                <div class="divide-y divide-slate-100 text-xs">
                    @foreach($group->programs as $prog)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/80 transition">
                            <div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-700 font-semibold text-[10px]">
                                        {{ $prog->category }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $prog->status === 'COMPLETED' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $prog->status }}
                                    </span>
                                </div>
                                <h4 class="text-sm font-bold text-slate-900 mt-1">{{ $prog->title }}</h4>
                                <p class="text-slate-500 text-xs mt-0.5 line-clamp-1">{{ $prog->description }}</p>
                            </div>
                            <div class="flex items-center space-x-3 shrink-0">
                                <span class="text-slate-500 text-xs">{{ $prog->tasks->count() }} Tugas</span>
                                <a href="{{ route('group.programs.show', ['group' => $group->id, 'program' => $prog->id]) }}" class="px-4 py-1.5 rounded-xl bg-slate-100 hover:bg-emerald-100 text-slate-700 hover:text-emerald-800 font-bold text-xs transition">
                                    Buka Papan Kanban →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Recent Activity Feed -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-bold text-slate-900">Log Aktivitas Terkini</h3>
                <a href="{{ route('group.activity', $group->id) }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700">Lihat Semua →</a>
            </div>

            <div class="space-y-3 text-xs">
                @forelse($recentLogs as $log)
                    <div class="flex items-start space-x-3 p-3 rounded-xl bg-slate-50 border border-slate-100">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                            {{ substr($log->user->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-medium text-slate-800">
                                <strong class="text-slate-900">{{ $log->user->name ?? 'Sistem' }}</strong>: {{ $log->description }}
                            </div>
                            <span class="text-[10px] text-slate-400 mt-0.5 block">
                                {{ $log->created_at->diffForHumans() }}
                            </span>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-400 italic">Belum ada catatan aktivitas.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-layouts.app>

