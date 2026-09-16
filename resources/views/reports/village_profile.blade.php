<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Profil Desa & UMKM — Desa {{ $village->name }}</title>
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
            Cetak Profil Desa (PDF)
        </button>
    </div>

    <div class="max-w-4xl mx-auto bg-white p-8 sm:p-16 rounded-3xl shadow-lg border border-slate-200 space-y-8">
        <div class="text-center border-b-2 border-slate-900 pb-6">
            <h1 class="text-2xl font-black uppercase text-slate-900">PROFIL DESA & DIREKTORI POTENSI LOKAL</h1>
            <h2 class="text-base font-bold text-emerald-800 uppercase mt-1">DESA {{ strtoupper($village->name) }}</h2>
            <p class="text-xs text-slate-500 mt-1">Kec. {{ $village->district }}, Kab. {{ $village->regency }}, Prov. {{ $village->province }}</p>
        </div>

        <section class="space-y-2">
            <h3 class="font-black text-slate-900 uppercase border-b border-slate-200 pb-1">1. Gambaran Umum & Sejarah</h3>
            <p class="text-justify text-slate-700">{{ $village->profile->history ?? 'Data sejarah desa belum dicatat.' }}</p>
        </section>

        <section class="space-y-2">
            <h3 class="font-black text-slate-900 uppercase border-b border-slate-200 pb-1">2. Visi & Misi</h3>
            <div><strong>Visi:</strong> <p class="italic text-slate-700">"{{ $village->profile->vision ?? '-' }}"</p></div>
            <div class="mt-2"><strong>Misi:</strong> <p class="whitespace-pre-line text-slate-700">{{ $village->profile->mission ?? '-' }}</p></div>
        </section>

        <section class="space-y-3">
            <h3 class="font-black text-slate-900 uppercase border-b border-slate-200 pb-1">3. Direktori UMKM Desa</h3>
            <div class="divide-y divide-slate-100">
                @foreach($village->publishedUmkms as $u)
                    <div class="py-3">
                        <div class="font-bold text-slate-900">{{ $u->business_name }} ({{ $u->category }})</div>
                        <div class="text-[11px] text-slate-500">Pemilik: {{ $u->owner_name }} | WA: {{ $u->whatsapp ?? '-' }}</div>
                        <p class="text-[11px] text-slate-600 mt-1">{{ $u->description }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="space-y-3">
            <h3 class="font-black text-slate-900 uppercase border-b border-slate-200 pb-1">4. Potensi Wisata</h3>
            <div class="divide-y divide-slate-100">
                @foreach($village->publishedTourismPlaces as $t)
                    <div class="py-3">
                        <div class="font-bold text-slate-900">{{ $t->name }} ({{ $t->category }})</div>
                        <div class="text-[11px] text-slate-500">HTM: Rp {{ number_format($t->ticket_price, 0, ',', '.') }} | Jam Buka: {{ $t->opening_hours }}</div>
                        <p class="text-[11px] text-slate-600 mt-1">{{ $t->description }}</p>
                    </div>
                @endforeach
            </div>
        </section>
    </div>

</body>
</html>

