<x-layouts.app :pageHeading="'Kanban: ' . $program->title">
    <div class="space-y-8" x-data="{ taskModal: false, selectedCol: 'TODO' }">
        
        <!-- Program Header & Details -->
        <div class="glass-card-premium p-6 sm:p-8 rounded-3xl border border-slate-200/80 shadow-md">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 text-xs font-extrabold border border-emerald-200">
                            {{ $program->category }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-extrabold {{ $program->status === 'COMPLETED' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $program->status }}
                        </span>
                        <span class="text-xs text-slate-500 font-semibold">Prioritas: <strong class="text-slate-800">{{ $program->priority }}</strong></span>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2 tracking-tight">{{ $program->title }}</h2>
                    <p class="text-xs sm:text-sm text-slate-600 mt-1 max-w-3xl leading-relaxed">{{ $program->description }}</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    @if(!$isLocked)
                        <!-- Program Completion Status Toggle -->
                        @if($canManageTasks || auth()->user()->isSupervisor() || auth()->user()->isSuperAdmin())
                            <form action="{{ route('group.programs.status', ['group' => $group->id, 'program' => $program->id]) }}" method="POST">
                                @csrf
                                @if($program->status !== 'COMPLETED')
                                    <input type="hidden" name="status" value="COMPLETED">
                                    <button type="submit" class="btn-shimmer px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition">
                                        ✓ Tandai Proker Selesai
                                    </button>
                                @else
                                    <input type="hidden" name="status" value="ONGOING">
                                    <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition">
                                        Buka Kembali Proker
                                    </button>
                                @endif
                            </form>
                        @endif

                        @if($canManageTasks ?? false)
                            <button @click="taskModal = true; selectedCol = 'TODO'" class="px-4 py-2.5 rounded-xl bg-slate-950 hover:bg-slate-800 text-white font-bold text-xs transition flex items-center space-x-1.5 shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Tambah Tugas</span>
                            </button>
                        @elseif(auth()->user()->isSupervisor())
                            <div class="px-3.5 py-2 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs font-bold flex items-center space-x-1.5 shadow-xs">
                                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                                <span>DPL Monitoring</span>
                            </div>
                        @endif
                    @endif
                </div>
            </div>

            <!-- Program Target & Meta -->
            @if($program->objective)
                <div class="mt-5 pt-4 border-t border-slate-100 flex flex-wrap items-center gap-6 text-xs text-slate-600">
                    <div>
                        <span class="font-extrabold text-slate-800">Sasaran:</span> {{ $program->objective }}
                    </div>
                    <div>
                        <span class="font-extrabold text-slate-800">PJ / Leader:</span> {{ $program->leader->name ?? '-' }}
                    </div>
                    @if($program->start_date && $program->end_date)
                        <div>
                            <span class="font-extrabold text-slate-800">Periode:</span> {{ $program->start_date->format('d M') }} — {{ $program->end_date->format('d M Y') }}
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Kanban Board (4 Columns) -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-base font-black text-slate-900 tracking-tight">Papan Tugas Kanban</h3>
                    <p class="text-xs text-slate-500">Pindahkan tugas antar kolom untuk memperbarui progres tim secara kolaboratif</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                
                <!-- Col 1: TODO -->
                <div class="bg-slate-100/80 p-4 rounded-3xl border border-slate-200/90 flex flex-col min-h-[520px] shadow-xs">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-slate-400"></span>
                            <span class="text-xs font-black text-slate-700 uppercase tracking-wider">TODO</span>
                        </div>
                        <span class="text-xs font-black px-2.5 py-0.5 rounded-full bg-white text-slate-700 border border-slate-200 shadow-xs">
                            {{ $tasksTodo->count() }}
                        </span>
                    </div>

                    <div class="space-y-3 flex-1 overflow-y-auto">
                        @foreach($tasksTodo as $task)
                            @include('programs.partials.task_card', ['task' => $task, 'nextStatus' => 'IN_PROGRESS', 'nextLabel' => 'Kerjakan →', 'prevStatus' => null])
                        @endforeach
                    </div>

                    @if($canManageTasks ?? false)
                        <button @click="taskModal = true; selectedCol = 'TODO'" class="mt-3 w-full py-2.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 text-xs font-bold border border-slate-200/90 transition shadow-xs">
                            + Tambah Tugas
                        </button>
                    @endif
                </div>

                <!-- Col 2: IN PROGRESS -->
                <div class="bg-blue-50/60 p-4 rounded-3xl border border-blue-200/80 flex flex-col min-h-[520px] shadow-xs">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-blue-500 radar-ping"></span>
                            <span class="text-xs font-black text-blue-900 uppercase tracking-wider">IN PROGRESS</span>
                        </div>
                        <span class="text-xs font-black px-2.5 py-0.5 rounded-full bg-white text-blue-800 border border-blue-200 shadow-xs">
                            {{ $tasksInProgress->count() }}
                        </span>
                    </div>

                    <div class="space-y-3 flex-1 overflow-y-auto">
                        @foreach($tasksInProgress as $task)
                            @include('programs.partials.task_card', ['task' => $task, 'nextStatus' => 'REVIEW', 'nextLabel' => 'Ajukan Review →', 'prevStatus' => 'TODO', 'prevLabel' => '← Kembali ke TODO'])
                        @endforeach
                    </div>
                </div>

                <!-- Col 3: REVIEW -->
                <div class="bg-amber-50/60 p-4 rounded-3xl border border-amber-200/80 flex flex-col min-h-[520px] shadow-xs">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 animate-pulse"></span>
                            <span class="text-xs font-black text-amber-900 uppercase tracking-wider">REVIEW</span>
                        </div>
                        <span class="text-xs font-black px-2.5 py-0.5 rounded-full bg-white text-amber-800 border border-amber-200 shadow-xs">
                            {{ $tasksReview->count() }}
                        </span>
                    </div>

                    <div class="space-y-3 flex-1 overflow-y-auto">
                        @foreach($tasksReview as $task)
                            @include('programs.partials.task_card', ['task' => $task, 'nextStatus' => 'DONE', 'nextLabel' => 'Selesaikan ✓', 'prevStatus' => 'IN_PROGRESS', 'prevLabel' => '← Perlu Revisi'])
                        @endforeach
                    </div>
                </div>

                <!-- Col 4: DONE -->
                <div class="bg-emerald-50/60 p-4 rounded-3xl border border-emerald-200/80 flex flex-col min-h-[520px] shadow-xs">
                    <div class="flex items-center justify-between mb-3 px-1">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span class="text-xs font-black text-emerald-900 uppercase tracking-wider">DONE</span>
                        </div>
                        <span class="text-xs font-black px-2.5 py-0.5 rounded-full bg-white text-emerald-800 border border-emerald-200 shadow-xs">
                            {{ $tasksDone->count() }}
                        </span>
                    </div>

                    <div class="space-y-3 flex-1 overflow-y-auto">
                        @foreach($tasksDone as $task)
                            @include('programs.partials.task_card', ['task' => $task, 'nextStatus' => null, 'prevStatus' => 'REVIEW', 'prevLabel' => '← Buka Review'])
                        @endforeach
                    </div>
                </div>

            </div>
        </div>

        <!-- Create Task Modal -->
        <div x-show="taskModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="taskModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Tugas Baru</h3>
                <form action="{{ route('group.programs.tasks.store', ['group' => $group->id, 'program' => $program->id]) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="status" :value="selectedCol">
                    
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul Tugas</label>
                        <input type="text" name="title" required placeholder="Contoh: Pembuatan foto produk & wawancara pemilik UMKM" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Penanggung Jawab (Assignee)</label>
                        <select name="assignee_id" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="">Pilih Anggota</option>
                            @foreach($group->members as $mb)
                                <option value="{{ $mb->id }}">{{ $mb->name }} ({{ $mb->student_id ?? 'NIM' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Prioritas</label>
                            <select name="priority" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                                <option value="MEDIUM">Medium</option>
                                <option value="HIGH">Tinggi (High)</option>
                                <option value="URGENT">Mendesak</option>
                                <option value="LOW">Rendah</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Tenggat Waktu</label>
                            <input type="date" name="due_date" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Tambahan</label>
                        <textarea name="description" rows="2" placeholder="Catatan detail..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                    </div>

                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="taskModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Tugas</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app>

