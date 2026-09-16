<?php

namespace App\Http\Controllers;

use App\Models\KknGroup;
use App\Services\KknProgressService;
use App\Services\TenantService;
use Illuminate\Http\Request;

class KknGroupController extends Controller
{
    protected KknProgressService $progressService;
    protected TenantService $tenantService;

    public function __construct(KknProgressService $progressService, TenantService $tenantService)
    {
        $this->progressService = $progressService;
        $this->tenantService = $tenantService;
    }

    public function workspace(KknGroup $group)
    {
        $group->load([
            'village.profile',
            'programs.tasks',
            'supervisor',
            'leader',
            'members',
            'activityLogs.user',
            'handoverPackages'
        ]);

        $progressData = $this->progressService->calculateProgress($group);

        $taskCounts = [
            'todo' => $group->tasks()->where('status', 'TODO')->count(),
            'in_progress' => $group->tasks()->where('status', 'IN_PROGRESS')->count(),
            'review' => $group->tasks()->where('status', 'REVIEW')->count(),
            'done' => $group->tasks()->where('status', 'DONE')->count(),
        ];

        $recentLogs = $group->activityLogs()->with('user')->latest()->take(8)->get();
        $isLocked = $group->status === 'COMPLETED';

        return view('group.workspace', compact('group', 'progressData', 'taskCounts', 'recentLogs', 'isLocked'));
    }

    public function members(KknGroup $group)
    {
        $group->load(['members', 'supervisor', 'leader', 'village']);
        
        $user = auth()->user();
        $isSuperAdmin = $user->isSuperAdmin();
        $isCampusAdmin = $user->isCampusAdmin();
        $isSupervisor = $user->isSupervisor() || $user->id === $group->supervisor_id;
        $isGroupLeader = $user->isGroupLeader() || $user->id === $group->leader_id || $group->members()->where('users.id', $user->id)->wherePivot('role', 'LEADER')->exists();
        $isVillageAdmin = $user->isVillageAdmin();
        
        $canManageMembers = ($isSuperAdmin || $isCampusAdmin || $isGroupLeader) && $group->status !== 'COMPLETED';

        $existingMemberIds = $group->members->pluck('id')->toArray();
        $availableStudents = \App\Models\User::whereIn('role', ['STUDENT', 'GROUP_LEADER'])
            ->whereNotIn('id', $existingMemberIds)
            ->orderBy('name')
            ->get();

        return view('group.members', compact(
            'group',
            'canManageMembers',
            'isGroupLeader',
            'isSupervisor',
            'isCampusAdmin',
            'isVillageAdmin',
            'availableStudents'
        ));
    }

    public function storeMember(Request $request, KknGroup $group)
    {
        if ($group->status === 'COMPLETED') {
            abort(403, 'Kelompok KKN telah selesai / di-handover.');
        }

        $user = auth()->user();
        $isAuthorized = $user->isSuperAdmin() || $user->isCampusAdmin() || $user->id === $group->leader_id || $group->members()->where('users.id', $user->id)->wherePivot('role', 'LEADER')->exists();
        if (!$isAuthorized) {
            abort(403, 'Hanya Ketua Kelompok atau Admin LPPM Kampus yang berwenang menambahkan anggota.');
        }

        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'new_name' => 'nullable|string|max:255',
            'new_email' => 'nullable|email|unique:users,email',
            'new_student_id' => 'nullable|string|max:50',
            'new_major' => 'nullable|string|max:100',
            'new_faculty' => 'nullable|string|max:100',
            'role' => 'required|in:LEADER,MEMBER',
            'contribution_notes' => 'nullable|string|max:255',
        ]);

        $targetUserId = $validated['user_id'] ?? null;

        // If creating a brand new student
        if (!$targetUserId && !empty($validated['new_name']) && !empty($validated['new_email'])) {
            $newUser = \App\Models\User::create([
                'name' => $validated['new_name'],
                'email' => $validated['new_email'],
                'student_id' => $validated['new_student_id'] ?? 'NIM-' . rand(100000, 999999),
                'major' => $validated['new_major'] ?? 'Umum',
                'faculty' => $validated['new_faculty'] ?? 'Universitas',
                'role' => $validated['role'] === 'LEADER' ? 'GROUP_LEADER' : 'STUDENT',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]);
            $targetUserId = $newUser->id;
        }

        if (!$targetUserId) {
            return back()->with('error', 'Silakan pilih mahasiswa terdaftar atau isi data mahasiswa baru.');
        }

        \App\Models\GroupMember::updateOrCreate(
            ['kkn_group_id' => $group->id, 'user_id' => $targetUserId],
            [
                'role' => $validated['role'],
                'contribution_notes' => $validated['contribution_notes'] ?? null,
            ]
        );

        if ($validated['role'] === 'LEADER') {
            $group->update(['leader_id' => $targetUserId]);
        }

        $targetUser = \App\Models\User::find($targetUserId);

        \App\Models\ActivityLog::create([
            'kkn_group_id' => $group->id,
            'village_id' => $group->village_id,
            'user_id' => $user->id,
            'action' => 'added_group_member',
            'description' => "Menambahkan anggota mahasiswa: {$targetUser->name} ({$validated['role']} — " . ($validated['contribution_notes'] ?? 'Anggota') . ")",
            'created_at' => now(),
        ]);

        return back()->with('success', "Mahasiswa '{$targetUser->name}' berhasil ditambahkan ke kelompok {$group->group_name}.");
    }

    public function updateMember(Request $request, KknGroup $group, $memberId)
    {
        if ($group->status === 'COMPLETED') {
            abort(403, 'Kelompok KKN telah selesai / di-handover.');
        }

        $user = auth()->user();
        $isAuthorized = $user->isSuperAdmin() || $user->isCampusAdmin() || $user->id === $group->leader_id || $group->members()->where('users.id', $user->id)->wherePivot('role', 'LEADER')->exists() || $user->isSupervisor();
        if (!$isAuthorized) {
            abort(403, 'Anda tidak memiliki hak akses mengubah informasi anggota kelompok.');
        }

        $validated = $request->validate([
            'role' => 'required|in:LEADER,MEMBER',
            'contribution_notes' => 'nullable|string|max:255',
        ]);

        $membership = \App\Models\GroupMember::where('kkn_group_id', $group->id)
            ->where('user_id', $memberId)
            ->firstOrFail();

        $membership->update([
            'role' => $validated['role'],
            'contribution_notes' => $validated['contribution_notes'] ?? null,
        ]);

        if ($validated['role'] === 'LEADER') {
            $group->update(['leader_id' => $memberId]);
        } elseif ($group->leader_id == $memberId && $validated['role'] === 'MEMBER') {
            $group->update(['leader_id' => null]);
        }

        $targetUser = \App\Models\User::find($memberId);

        \App\Models\ActivityLog::create([
            'kkn_group_id' => $group->id,
            'village_id' => $group->village_id,
            'user_id' => $user->id,
            'action' => 'updated_group_member',
            'description' => "Memperbarui peran {$targetUser->name} menjadi {$validated['role']} (" . ($validated['contribution_notes'] ?? '-') . ")",
            'created_at' => now(),
        ]);

        return back()->with('success', "Peran dan divisi {$targetUser->name} berhasil diperbarui.");
    }

    public function destroyMember(KknGroup $group, $memberId)
    {
        if ($group->status === 'COMPLETED') {
            abort(403, 'Kelompok KKN telah selesai / di-handover.');
        }

        $user = auth()->user();
        $isAuthorized = $user->isSuperAdmin() || $user->isCampusAdmin() || $user->id === $group->leader_id || $group->members()->where('users.id', $user->id)->wherePivot('role', 'LEADER')->exists();
        if (!$isAuthorized) {
            abort(403, 'Hanya Ketua Kelompok atau Admin LPPM yang berwenang mengeluarkan anggota.');
        }

        // Check if leader trying to delete themselves when sole leader
        if ($memberId == $user->id && $group->members()->wherePivot('role', 'LEADER')->count() <= 1) {
            return back()->with('error', 'Ketua kelompok tidak dapat menghapus diri sendiri sebelum menetapkan ketua baru.');
        }

        $targetUser = \App\Models\User::findOrFail($memberId);

        \App\Models\GroupMember::where('kkn_group_id', $group->id)
            ->where('user_id', $memberId)
            ->delete();

        if ($group->leader_id == $memberId) {
            $group->update(['leader_id' => null]);
        }

        \App\Models\ActivityLog::create([
            'kkn_group_id' => $group->id,
            'village_id' => $group->village_id,
            'user_id' => $user->id,
            'action' => 'removed_group_member',
            'description' => "Mengeluarkan {$targetUser->name} dari kelompok KKN",
            'created_at' => now(),
        ]);

        return back()->with('success', "{$targetUser->name} telah dikeluarkan dari kelompok.");
    }

    public function activity(KknGroup $group)
    {
        $logs = $group->activityLogs()->with('user')->latest()->paginate(20);
        return view('group.activity', compact('group', 'logs'));
    }
}
