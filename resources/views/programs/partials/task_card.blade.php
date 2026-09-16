<div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-xs hover:shadow-md transition text-xs space-y-2">
    <div class="flex items-center justify-between">
        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold 
            {{ $task->priority === 'URGENT' ? 'bg-rose-100 text-rose-800' : ($task->priority === 'HIGH' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700') }}">
            {{ $task->priority }}
        </span>

        @if($task->due_date)
            <span class="text-[10px] text-slate-400 font-medium">
                {{ $task->due_date->format('d M') }}
            </span>
        @endif
    </div>

    <h4 class="font-bold text-slate-900 leading-snug">{{ $task->title }}</h4>

    @if($task->description)
        <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">{{ $task->description }}</p>
    @endif

    <div class="pt-2 border-t border-slate-100 flex items-center justify-between text-[11px]">
        <span class="text-slate-500 truncate max-w-[120px]" title="{{ $task->assignee->name ?? 'Belum ada PJ' }}">
            👤 {{ $task->assignee->name ?? 'Belum ada PJ' }}
        </span>
    </div>

    <!-- Quick Status Change Controls -->
    @if(!$isLocked)
        <div class="pt-2 flex items-center justify-between gap-1 border-t border-slate-50">
            @if($prevStatus)
                <form action="{{ route('group.programs.tasks.status', ['group' => $group->id, 'program' => $program->id, 'task' => $task->id]) }}" method="POST" class="w-1/2">
                    @csrf
                    <input type="hidden" name="status" value="{{ $prevStatus }}">
                    <button type="submit" class="w-full py-1 text-[10px] font-semibold text-slate-500 hover:text-slate-800 hover:bg-slate-100 rounded-lg transition text-left px-1.5">
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
                    <button type="submit" class="w-full py-1 text-[10px] font-bold text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition text-right px-1.5">
                        {{ $nextLabel }}
                    </button>
                </form>
            @endif
        </div>
    @endif
</div>

