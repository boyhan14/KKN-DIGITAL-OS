<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Dampak KKN — Desa {{ $village->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; } @media print { .no-print { display: none !important; } }</style>
</head>
<body class="bg-slate-100 p-4 sm:p-12 text-slate-900 leading-relaxed text-xs">

    <div class="max-w-4xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('group.reports.index', $group->id) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-700">
            ← Kembali
        </a>
        <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-xs shadow-md transition">
            Cetak Laporan Dampak (PDF)
        </button>
    </div>

    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-16 rounded-3xl shadow-lg border border-slate-200 space-y-8">
        <div class="text-center border-b-2 border-slate-900 pb-6">
            <h1 class="text-2xl font-black uppercase text-slate-900">LAPORAN CAPAIAN & DAMPAK (IMPACT) PROGRAM KKN</h1>
            <h2 class="text-base font-bold text-emerald-800 uppercase mt-1">LOKASI: DESA {{ strtoupper($village->name) }}</h2>
            <p class="text-xs text-slate-500 mt-1">Kelompok: {{ $group->group_name }} ({{ $group->group_code }}) &bull; Periode {{ date('Y') }}</p>
        </div>

        <!-- Big Counters -->
        <div class="grid grid-cols-4 gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center">
            <div>
                <span class="text-2xl font-black text-emerald-700 block">{{ $impact['beneficiaries'] }}</span>
                <span class="text-[10px] text-slate-500 font-semibold uppercase">Penerima Manfaat</span>
            </div>
            <div>
                <span class="text-2xl font-black text-slate-900 block">{{ $impact['umkm_digitized'] }}</span>
                <span class="text-[10px] text-slate-500 font-semibold uppercase">UMKM Terdata</span>
            </div>
            <div>
                <span class="text-2xl font-black text-slate-900 block">{{ $impact['products_listed'] }}</span>
                <span class="text-[10px] text-slate-500 font-semibold uppercase">Produk Terkatalog</span>
            </div>
            <div>
                <span class="text-2xl font-black text-emerald-700 block">{{ $impact['programs_completed'] }} / {{ $impact['total_programs'] }}</span>
                <span class="text-[10px] text-slate-500 font-semibold uppercase">Proker Selesai</span>
            </div>
        </div>

        <!-- Detailed Metrics Table -->
        <section class="space-y-3">
            <h3 class="font-black text-slate-900 uppercase border-b border-slate-200 pb-1">Daftar Indikator Kinerja Utama (IKU) KKN</h3>
            <table class="w-full text-left border border-slate-200">
                <thead class="bg-slate-50 text-[11px] font-bold border-b border-slate-200">
                    <tr>
                        <th class="p-2">No</th>
                        <th class="p-2">Nama Indikator</th>
                        <th class="p-2">Kategori</th>
                        <th class="p-2">Baseline</th>
                        <th class="p-2">Target</th>
                        <th class="p-2">Capaian (Achieved)</th>
                        <th class="p-2">% Capaian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-[11px]">
                    @foreach($impact['metrics'] as $idx => $m)
                        <tr>
                            <td class="p-2 font-bold">{{ $idx + 1 }}</td>
                            <td class="p-2 font-bold text-slate-900">{{ $m->metric_name }}</td>
                            <td class="p-2">{{ $m->category }}</td>
                            <td class="p-2">{{ $m->baseline }} {{ $m->unit }}</td>
                            <td class="p-2">{{ $m->target }} {{ $m->unit }}</td>
                            <td class="p-2 font-bold text-emerald-700">{{ $m->achieved }} {{ $m->unit }}</td>
                            <td class="p-2 font-bold">{{ $m->progressPercentage() }}%</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </div>

</body>
</html>

