<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\KknGroup;
use App\Models\ProgramTask;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index(KknGroup $group)
    {
        $programs = $group->programs()->with(['leader', 'tasks'])->latest()->get();
        $isLocked = $group->status === 'COMPLETED';

        return view('programs.index', compact('group', 'programs', 'isLocked'));
    }

    public function show(KknGroup $group, Program $program)
    {
        $program->load(['leader', 'members', 'tasks.assignee', 'documents', 'impactMetrics']);
        $isLocked = $group->status === 'COMPLETED';

        // Kanban columns
        $tasksTodo = $program->tasks->where('status', 'TODO');
        $tasksInProgress = $program->tasks->where('status', 'IN_PROGRESS');
        $tasksReview = $program->tasks->where('status', 'REVIEW');
        $tasksDone = $program->tasks->where('status', 'DONE');

        return view('programs.show', compact('group', 'program', 'tasksTodo', 'tasksInProgress', 'tasksReview', 'tasksDone', 'isLocked'));
    }

    public function store(Request $request, KknGroup $group)
    {
        if ($group->status === 'COMPLETED') {
            abort(403, 'Kelompok KKN telah selesai / di-handover.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'objective' => 'nullable|string',
            'target_audience' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'budget' => 'nullable|numeric',
            'priority' => 'required|in:LOW,MEDIUM,HIGH,URGENT',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($validated['title']);

        $program = Program::create([
            'kkn_group_id' => $group->id,
            'village_id' => $group->village_id,
            'leader_id' => auth()->id(),
            'title' => $validated['title'],
            'slug' => $slug,
            'category' => $validated['category'],
            'objective' => $validated['objective'] ?? null,
            'target_audience' => $validated['target_audience'] ?? null,
            'location' => $validated['location'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'budget' => $validated['budget'] ?? 0,
            'priority' => $validated['priority'],
            'description' => $validated['description'] ?? null,
            'status' => 'PLANNED',
        ]);

        ActivityLog::create([
            'kkn_group_id' => $group->id,
            'village_id' => $group->village_id,
            'user_id' => auth()->id(),
            'action' => 'created_program',
            'description' => "Menambahkan program kerja baru: {$program->title}",
            'created_at' => now(),
        ]);

        return redirect()->route('group.programs.show', ['group' => $group->id, 'program' => $program->id])
            ->with('success', 'Program Kerja berhasil dibuat.');
    }

    public function updateStatus(Request $request, KknGroup $group, Program $program)
    {
        $validated = $request->validate([
            'status' => 'required|in:PLANNED,ONGOING,COMPLETED,CANCELLED',
        ]);

        $program->update(['status' => $validated['status']]);

        ActivityLog::create([
            'kkn_group_id' => $group->id,
            'village_id' => $group->village_id,
            'user_id' => auth()->id(),
            'action' => 'updated_program_status',
            'description' => "Mengubah status program '{$program->title}' menjadi {$validated['status']}",
            'created_at' => now(),
        ]);

        return back()->with('success', 'Status program kerja diperbarui.');
    }

    public function storeTask(Request $request, KknGroup $group, Program $program)
    {
        if ($group->status === 'COMPLETED') {
            abort(403, 'Akses tulis terkunci.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'assignee_id' => 'nullable|exists:users,id',
            'priority' => 'required|in:LOW,MEDIUM,HIGH,URGENT',
            'status' => 'required|in:TODO,IN_PROGRESS,REVIEW,DONE',
            'due_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $task = ProgramTask::create([
            'program_id' => $program->id,
            'kkn_group_id' => $group->id,
            'assignee_id' => $validated['assignee_id'] ?? null,
            'title' => $validated['title'],
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'due_date' => $validated['due_date'] ?? null,
            'description' => $validated['description'] ?? null,
        ]);

        return back()->with('success', 'Tugas baru berhasil ditambahkan.');
    }

    public function updateTaskStatus(Request $request, KknGroup $group, Program $program, ProgramTask $task)
    {
        $validated = $request->validate([
            'status' => 'required|in:TODO,IN_PROGRESS,REVIEW,DONE',
        ]);

        $task->update(['status' => $validated['status']]);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'task' => $task]);
        }

        return back()->with('success', 'Status tugas diperbarui.');
    }
}
