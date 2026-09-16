<div class="card-lift p-4 rounded-2xl bg-white border border-slate-200/90 shadow-sm text-xs space-y-2.5 group">
    <div class="flex items-center justify-between">
        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold tracking-wider
            {{ $task->priority === 'URGENT' ? 'bg-rose-100 text-rose-800 border border-rose-200' : ($task->priority === 'HIGH' ? 'bg-amber-100 text-amber-800 border border-amber-200' : 'bg-slate-100 text-slate-700 border border-slate-200') }}">
            {{ $task->priority }}
        </span>

        @if($task->due_date)
            <span class="text-[10px] text-slate-400 font-semibold flex items-center space-x-1">
                <span>📅</span>
                <span>{{ $task->due_date->format('d M') }}</span>
            </span>
        @endif
    </div>

    <h4 class="font-extrabold text-slate-900 leading-snug group-hover:text-emerald-700 transition">{{ $task->title }}</h4>

    @if($task->description)
        <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
    @endif

    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
        <div class="flex items-center space-x-1.5 text-slate-600 truncate max-w-[140px]" title="{{ $task->assignee->name ?? 'Belum ada PJ' }}">
            <div class="w-5 h-5 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center text-[10px] font-bold shrink-0">
                {{ substr($task->assignee->name ?? 'U', 0, 1) }}
            </div>
            <span class="truncate font-medium">{{ $task->assignee->name ?? 'Belum ada PJ' }}</span>
        </div>
    </div>

    <!-- Quick Status Change Controls -->
    @if(!$isLocked)
        <div class="pt-2 flex items-center justify-between gap-1 border-t border-slate-100/80">
            @if($prevStatus)
                <form action="{{ route('group.programs.tasks.status', ['group' => $group->id, 'program' => $program->id, 'task' => $task->id]) }}" method="POST" class="w-1/2">
                    @csrf
                    <input type="hidden" name="status" value="{{ $prevStatus }}">
                    <button type="submit" class="w-full py-1 text-[10px] font-bold text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition text-left px-2">
                        {{ $prevLabel }}
                    </button>
                </form>
            @else
                <div class="w-1/2"></div>
            @endif

            @if($nextStatus)
                <form action="{{ route('group.programs.tasks.status', ['group' => $group->id, 'program' => $program->id, 'task' => $task->id]) }}" method="POST" class="w-1/2 text-right">
                    @csrf
                    <input type="hidden" name="status" value="{{ $nextStatus }}">
                    <button type="submit" class="w-full py-1 text-[10px] font-extrabold text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition text-right px-2">
                        {{ $nextLabel }}
                    </button>
                </form>
            @endif
        </div>
    @endif
</div>
