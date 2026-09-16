<?php

namespace App\Http\Controllers;

use App\Models\KknGroup;
use App\Models\ProgramDocument;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function index(KknGroup $group)
    {
        $documents = $group->documents()->with('program')->latest()->get();
        $programs = $group->programs;
        $isLocked = $group->status === 'COMPLETED';

        $user = auth()->user();
        $isMember = $group->members()->where('users.id', $user->id)->exists() || $user->isSuperAdmin();
        $canUploadDocument = $isMember && !$isLocked;

        return view('documents.index', compact('group', 'documents', 'programs', 'isLocked', 'canUploadDocument'));
    }

    public function store(Request $request, KknGroup $group)
    {
        if ($group->status === 'COMPLETED') {
            abort(403, 'Kelompok KKN telah selesai / di-handover.');
        }

        $user = auth()->user();
        $isMember = $group->members()->where('users.id', $user->id)->exists();
        if (!$isMember && !$user->isSuperAdmin()) {
            abort(403, 'Hanya mahasiswa anggota kelompok KKN yang dapat mengunggah dokumen luaran. Dosen Pembimbing bertindak sebagai evaluator.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'program_id' => 'nullable|exists:programs,id',
            'visibility' => 'required|in:PUBLIC,INTERNAL,PRIVATE',
            'file_path' => 'nullable|string',
            'file_type' => 'nullable|string|max:50',
        ]);

        $doc = ProgramDocument::create([
            'program_id' => $validated['program_id'] ?? null,
            'kkn_group_id' => $group->id,
            'title' => $validated['title'],
            'file_path' => $validated['file_path'] ?? 'documents/laporan-kkn-digital.pdf',
            'file_type' => $validated['file_type'] ?? 'PDF',
            'file_size' => 2048000,
            'visibility' => $validated['visibility'],
        ]);

        ActivityLog::create([
            'kkn_group_id' => $group->id,
            'village_id' => $group->village_id,
            'user_id' => auth()->id(),
            'action' => 'uploaded_document',
            'description' => "Mengunggah dokumen luaran: {$doc->title}",
            'created_at' => now(),
        ]);

        return back()->with('success', 'Dokumen berhasil diunggah ke repositori.');
    }

    public function destroy(KknGroup $group, ProgramDocument $document)
    {
        if ($group->status === 'COMPLETED') {
            abort(403, 'Kelompok KKN telah selesai / di-handover.');
        }

        $user = auth()->user();
        $isMember = $group->members()->where('users.id', $user->id)->exists();
        if (!$isMember && !$user->isSuperAdmin()) {
            abort(403, 'Hanya mahasiswa anggota kelompok KKN yang dapat menghapus dokumen.');
        }

        $document->delete();
        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
