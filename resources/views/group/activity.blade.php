<x-layouts.app :pageHeading="'Log Aktivitas — ' . $group->group_name">
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Riwayat Aktivitas Kelompok</h2>
                <p class="text-xs text-slate-500 mt-1">Audit trail lengkap mengenai aktivitas dan kontribusi setiap anggota di lapangan.</p>
            </div>
            <a href="{{ route('group.workspace', $group->id) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-600">
                ← Kembali ke Workspace
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6">
            <div class="space-y-4">
                @forelse($logs as $log)
                    <div class="flex items-start space-x-3 p-4 rounded-2xl bg-slate-50 border border-slate-100">
                        <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold text-xs shrink-0 mt-0.5">
                            {{ substr($log->user->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="font-bold text-slate-900">{{ $log->user->name ?? 'Sistem' }}</span>
                                <span class="text-[10px] text-slate-400">{{ $log->created_at->format('d M Y, H:i') }} WIB</span>
                            </div>
                            <p class="text-slate-700 mt-1">{{ $log->description }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 italic text-center py-8">Belum ada riwayat aktivitas yang tercatat.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-layouts.app>

