<x-layouts.app :pageHeading="'Laporan KKN & Ekspor — ' . $group->group_name">
    <div class="space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Pusat Laporan & Ekspor PDF</h2>
                <p class="text-xs text-slate-500 mt-1">Ekspor dokumen resmi KKN terstruktur: Laporan Akhir KKN (Bab 1 - 8), Profil Desa, dan Laporan Dampak.</p>
            </div>
            <a href="{{ route('group.workspace', $group->id) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-600">
                ← Kembali ke Workspace
            </a>
        </div>

        <!-- Available Report Templates Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Report 1: KKN Executive Summary (Bab 1 - 8) -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex flex-col justify-between hover:border-emerald-500/60 transition">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-800 flex items-center justify-center font-black text-sm mb-4">
                        📄
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">Laporan Akhir KKN (Bab 1 - 8)</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Laporan komprehensif memuat Pendahuluan, Profil Desa, Program Kerja, Pelaksanaan, Output, Impact, Dokumentasi Foto, dan Kesimpulan.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('group.reports.kkn_summary', $group->id) }}" target="_blank" class="w-full py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow-xs transition inline-flex items-center justify-center space-x-1">
                        <span>Buka & Cetak Laporan PDF ↗</span>
                    </a>
                </div>
            </div>

            <!-- Report 2: Village Profile Report -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex flex-col justify-between hover:border-emerald-500/60 transition">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center font-black text-sm mb-4">
                        🏛️
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">Buku Profil Desa & UMKM</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Kompilasi sejarah desa, visi misi, fasilitas umum, daftar pelaku UMKM lokal, dan direktori potensi pariwisata.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('group.reports.village_profile', $group->id) }}" target="_blank" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-xs transition inline-flex items-center justify-center space-x-1">
                        <span>Buka Dokumen Profil ↗</span>
                    </a>
                </div>
            </div>

            <!-- Report 3: Impact Report -->
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs flex flex-col justify-between hover:border-emerald-500/60 transition">
                <div>
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center font-black text-sm mb-4">
                        📊
                    </div>
                    <h3 class="text-base font-extrabold text-slate-900">Laporan Capaian & Dampak (Impact)</h3>
                    <p class="text-xs text-slate-600 mt-2 leading-relaxed">
                        Rekapitulasi angka penerima manfaat, program kerja selesai, produk UMKM terdaftar, dan metrik IKU KKN.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-slate-100">
                    <a href="{{ route('group.reports.impact', $group->id) }}" target="_blank" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs shadow-xs transition inline-flex items-center justify-center space-x-1">
                        <span>Buka Laporan Impact ↗</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</x-layouts.app>

