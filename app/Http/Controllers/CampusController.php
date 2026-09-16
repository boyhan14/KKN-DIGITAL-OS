<?php

namespace App\Http\Controllers;

use App\Models\Campus;
use App\Models\KknProgram;
use App\Models\Village;
use App\Models\KknGroup;
use App\Models\User;
use App\Models\GroupMember;
use App\Services\TenantService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CampusController extends Controller
{
    protected TenantService $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function dashboard()
    {
        $campus = $this->tenantService->getUserCampus(auth()->user()) ?? Campus::first();

        $kknPrograms = $campus ? $campus->kknPrograms()->with(['villages', 'groups'])->latest()->get() : collect();
        $villages = $campus ? $campus->villages()->with(['groups', 'profile'])->get() : collect();
        $groups = KknGroup::whereHas('kknProgram', fn($q) => $q->where('campus_id', $campus?->id))
            ->with(['village', 'supervisor', 'leader', 'members'])
            ->get();

        $supervisors = User::where('role', 'SUPERVISOR')->get();
        $students = User::whereIn('role', ['STUDENT', 'GROUP_LEADER'])->get();

        $stats = [
            'total_programs' => $kknPrograms->count(),
            'active_villages' => $villages->count(),
            'total_groups' => $groups->count(),
            'total_students' => $groups->sum(fn($g) => $g->members->count()),
        ];

        return view('campus.dashboard', compact('campus', 'kknPrograms', 'villages', 'groups', 'supervisors', 'students', 'stats'));
    }

    public function storeProgram(Request $request)
    {
        $campus = $this->tenantService->getUserCampus(auth()->user()) ?? Campus::first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'year' => 'required|string|max:10',
            'period' => 'required|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $program = KknProgram::create([
            'campus_id' => $campus->id,
            'name' => $validated['name'],
            'year' => $validated['year'],
            'period' => $validated['period'],
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => 'ACTIVE',
        ]);

        return back()->with('success', "Program KKN '{$program->name}' berhasil dibuat.");
    }

    public function storeVillage(Request $request)
    {
        $campus = $this->tenantService->getUserCampus(auth()->user()) ?? Campus::first();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'province' => 'required|string|max:100',
            'regency' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'head_name' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:50',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'kkn_program_id' => 'nullable|exists:kkn_programs,id',
            'theme' => 'nullable|in:modern,nature,heritage',
        ]);

        $slug = Str::slug($validated['name']);
        if (Village::where('slug', $slug)->exists()) {
            $slug .= '-' . Str::random(4);
        }

        $village = Village::create([
            'campus_id' => $campus->id,
            'kkn_program_id' => $validated['kkn_program_id'] ?? null,
            'name' => $validated['name'],
            'slug' => $slug,
            'province' => $validated['province'],
            'regency' => $validated['regency'],
            'district' => $validated['district'],
            'head_name' => $validated['head_name'] ?? null,
            'contact' => $validated['contact'] ?? null,
            'latitude' => $validated['latitude'] ?? -5.3600000,
            'longitude' => $validated['longitude'] ?? 105.1800000,
            'theme' => $validated['theme'] ?? 'modern',
            'is_active' => true,
        ]);

        // Auto initialize empty profile
        $village->profile()->create([
            'status' => 'DRAFT',
            'history' => 'Sejarah Desa ' . $village->name,
            'vision' => 'Terwujudnya Desa ' . $village->name . ' yang mandiri, sejahtera, dan terdigitalisasi.',
            'mission' => '1. Meningkatkan pelayanan berbasis digital.' . PHP_EOL . '2. Mengembangkan potensi UMKM dan pariwisata lokal.',
        ]);

        return back()->with('success', "Desa '{$village->name}' berhasil ditambahkan ke database.");
    }

    public function storeGroup(Request $request)
    {
        $validated = $request->validate([
            'kkn_program_id' => 'required|exists:kkn_programs,id',
            'village_id' => 'required|exists:villages,id',
            'group_name' => 'required|string|max:255',
            'group_code' => 'required|string|max:50|unique:kkn_groups,group_code',
            'supervisor_id' => 'nullable|exists:users,id',
            'leader_id' => 'nullable|exists:users,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
        ]);

        $group = KknGroup::create($validated);

        if (!empty($validated['leader_id'])) {
            GroupMember::updateOrCreate(
                ['kkn_group_id' => $group->id, 'user_id' => $validated['leader_id']],
                ['role' => 'LEADER']
            );
        }

        return back()->with('success', "Kelompok '{$group->group_name}' berhasil dibentuk.");
    }

    public function assignStudent(Request $request, KknGroup $group)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|in:LEADER,MEMBER',
            'contribution_notes' => 'nullable|string',
        ]);

        GroupMember::updateOrCreate(
            ['kkn_group_id' => $group->id, 'user_id' => $validated['user_id']],
            [
                'role' => $validated['role'],
                'contribution_notes' => $validated['contribution_notes'] ?? null,
            ]
        );

        return back()->with('success', 'Anggota mahasiswa berhasil ditambahkan ke kelompok.');
    }
}
