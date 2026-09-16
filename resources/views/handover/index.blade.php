<x-layouts.app :pageHeading="'Digital Handover — Desa ' . $village->name">
    <div class="space-y-8">
        
        <!-- Header & Signature Explanation -->
        <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-r from-amber-950 via-slate-900 to-emerald-950 text-white relative overflow-hidden shadow-xl">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30 text-xs font-bold">
                        Signature Feature: Digital Village Continuity
                    </span>
                    <h2 class="text-2xl sm:text-3xl font-black mt-2 tracking-tight">Digital Handover Engine</h2>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl leading-relaxed">
                        Mekanisme serah terima resmi seluruh aset digital (website desa, direktori UMKM, potensi wisata, dan peta interaktif) dari kelompok KKN kepada Pemerintah Desa.
                    </p>
                </div>

                <div class="text-right shrink-0">
                    <span class="text-xs text-slate-400 block">Skor Kesiapan Handover</span>
                    <span class="text-4xl sm:text-5xl font-black text-amber-400">{{ $readinessScore }}%</span>
                </div>
            </div>

            @if($package && $package->status === 'COMPLETED')
                <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs">
                    <span class="text-emerald-300 font-bold flex items-center space-x-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Handover Telah Berhasil Diselesaikan pada {{ $package->completed_at ? $package->completed_at->format('d M Y') : '' }}</span>
                    </span>
                    <a href="{{ route('group.handover.certificate', ['group' => $group->id, 'package' => $package->id]) }}" class="px-4 py-2 rounded-xl bg-white text-slate-900 font-bold shadow-md hover:bg-slate-100 transition">
                        Cetak Berita Acara Handover 📄
                    </a>
                </div>
            @endif
        </div>

        <!-- Handover Checklist Section -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
            <h3 class="text-base font-bold text-slate-900 mb-2">Checklist Kesiapan Aset Digital (Handover Readiness)</h3>
            <p class="text-xs text-slate-500 mb-6">Pastikan seluruh luaran KKN telah diverifikasi sebelum melakukan alih kelola permanen ke aparatur desa.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                @foreach($checklist as $item)
                    <div class="p-4 rounded-2xl border {{ $item['status'] === 'COMPLETED' ? 'border-emerald-200 bg-emerald-50/40' : 'border-amber-200 bg-amber-50/40' }} flex items-start space-x-3">
                        <div class="w-6 h-6 rounded-full {{ $item['status'] === 'COMPLETED' ? 'bg-emerald-600 text-white' : 'bg-amber-500 text-white' }} flex items-center justify-center text-xs font-bold shrink-0 mt-0.5">
                            {{ $item['status'] === 'COMPLETED' ? '✓' : '!' }}
                        </div>
                        <div>
                            <div class="flex items-center space-x-2">
                                <h4 class="font-bold text-slate-900 text-sm">{{ $item['title'] }}</h4>
                                <span class="px-1.5 py-0.5 rounded-sm text-[9px] font-bold uppercase {{ $item['status'] === 'COMPLETED' ? 'bg-emerald-200 text-emerald-900' : 'bg-amber-200 text-amber-900' }}">
                                    {{ $item['status'] }}
                                </span>
                            </div>
                            <p class="text-slate-600 text-[11px] mt-1 leading-relaxed">{{ $item['description'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Handover Execution Form -->
        @if(!$isLocked)
            <div class="bg-white rounded-3xl border border-slate-200 shadow-xs p-6 sm:p-8">
                <h3 class="text-base font-bold text-slate-900 mb-2">Finalisasi & Serah Terima Aset Digital</h3>
                <p class="text-xs text-slate-500 mb-6">
                    Memilih akun perangkat desa yang akan menerima hak kelola. Setelah diserahkan, hak tulis mahasiswa akan dikunci dan kepemilikan operasional website resmi menjadi milik Desa {{ $village->name }}.
                </p>

                <form action="{{ route('group.handover.execute', $group->id) }}" method="POST" class="space-y-4 text-xs max-w-xl">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Judul Berita Acara Handover</label>
                        <input type="text" name="title" required value="Berita Acara Serah Terima Aset Digital Desa {{ $village->name }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Penerima Kuasa (Perangkat / Admin Desa)</label>
                        <select name="village_admin_id" required class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="">Pilih Akun Perangkat Desa</option>
                            @foreach($villageUsers as $vu)
                                <option value="{{ $vu->id }}">{{ $vu->name }} ({{ $vu->email }}) — {{ $vu->role }}</option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-slate-400 mt-1">Akun yang dipilih otomatis akan memiliki hak akses penuh mengelola portal desa setelah serah terima.</p>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tanggal Serah Terima</label>
                        <input type="date" name="handover_date" required value="{{ now()->toDateString() }}" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Catatan Serah Terima / Pesan untuk Desa</label>
                        <textarea name="notes" rows="3" class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed" placeholder="Catatan panduan singkat, rekomendasi kelanjutan program, dan pesan penutup KKN...">Serah terima aset digital desa hasil program kerja KKN resmi diserahkan kepada Pemerintah Desa Sukamaju untuk diteruskan pengelolaannya.</textarea>
                    </div>

                    <div class="p-4 rounded-2xl bg-amber-50 border border-amber-200">
                        <label class="flex items-start space-x-3 cursor-pointer">
                            <input type="checkbox" name="confirm_finalize" value="1" required class="mt-0.5 rounded-sm border-amber-400 text-emerald-600">
                            <span class="text-xs text-amber-950 font-medium leading-relaxed">
                                Saya menyatakan bahwa data telah diverifikasi bersama Dosen Pembimbing dan Pemerintah Desa. Dengan mencentang ini, kelompok KKN resmi menyelesaikan tugas operasional dan menyerahkan kendali penuh ke desa.
                            </span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="px-8 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-extrabold text-xs shadow-lg shadow-emerald-600/25 transition">
                            Eksekusi Digital Handover & Terbitkan Berita Acara
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-emerald-50 rounded-3xl border border-emerald-200 p-6 sm:p-8 text-xs text-emerald-950 flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-sm">Status: Handover Telah Diselesaikan</h4>
                    <p class="text-slate-600 mt-1">Aset digital telah diwariskan ke Desa {{ $village->name }}.</p>
                </div>
                @if($package)
                    <a href="{{ route('group.handover.certificate', ['group' => $group->id, 'package' => $package->id]) }}" class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-bold hover:bg-emerald-700 transition">
                        Buka Dokumen Berita Acara Handover →
                    </a>
                @endif
            </div>
        @endif

    </div>
</x-layouts.app>

