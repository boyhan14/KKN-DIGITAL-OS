@extends('layouts.public', ['title' => 'Agenda & Kegiatan Warga', 'metaDescription' => 'Jadwal agenda kegiatan kemasyarakatan, budaya, dan program kerja KKN di Desa ' . $village->name])

@section('content')
<!-- Header -->
<div class="bg-gradient-to-b from-slate-100 to-white border-b border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 mb-3">
            Kalender Kegiatan
        </span>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 mb-3">
            Agenda & Kegiatan Desa {{ $village->name }}
        </h1>
        <p class="text-slate-600 max-w-2xl mx-auto text-sm sm:text-base">
            Informasi terkini jadwal acara desa, gotong royong, posyandu, pelatihan UMKM, dan kegiatan program KKN mahasiswa.
        </p>
    </div>
</div>

<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Upcoming Events Section -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 flex items-center">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 mr-2.5 animate-pulse"></span>
                        Agenda Mendatang
                    </h2>
                    <p class="text-slate-500 text-xs mt-0.5">Kegiatan yang akan diselenggarakan dalam waktu dekat</p>
                </div>
                <span class="text-xs font-bold px-3 py-1 bg-emerald-50 text-emerald-800 rounded-full border border-emerald-200">
                    {{ $upcomingEvents->count() }} Agenda
                </span>
            </div>

            @if($upcomingEvents->isEmpty())
                <div class="bg-white rounded-3xl p-8 border border-slate-200 text-center text-slate-500">
                    <p>Saat ini belum ada agenda mendatang yang dijadwalkan.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($upcomingEvents as $event)
                        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs hover:shadow-md transition flex flex-col md:flex-row md:items-center gap-6">
                            <!-- Date Box -->
                            <div class="shrink-0 w-24 h-24 rounded-2xl bg-emerald-700 text-white flex flex-col items-center justify-center text-center shadow-sm">
                                <span class="text-xs uppercase font-bold tracking-wider opacity-80">{{ \Carbon\Carbon::parse($event->date)->isoFormat('MMM') }}</span>
                                <span class="text-3xl font-black">{{ \Carbon\Carbon::parse($event->date)->format('d') }}</span>
                                <span class="text-[10px] opacity-75">{{ \Carbon\Carbon::parse($event->date)->format('Y') }}</span>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 space-y-2">
                                <div class="flex flex-wrap items-center gap-2">
                                    <span class="text-xs font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $event->category ?? 'Kegiatan Desa' }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-black text-slate-900">{{ $event->title }}</h3>
                                <p class="text-slate-600 text-sm leading-relaxed">{{ $event->description }}</p>

                                <div class="flex flex-wrap items-center gap-4 text-xs text-slate-500 pt-2">
                                    @if($event->time)
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $event->time }} WIB
                                        </span>
                                    @endif
                                    @if($event->location)
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{ $event->location }}
                                        </span>
                                    @endif
                                    @if($event->organizer)
                                        <span class="flex items-center text-slate-600 font-medium">
                                            Penyelenggara: {{ $event->organizer }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </section>

        <!-- Past Events Section -->
        @if($pastEvents->isNotEmpty())
            <section class="pt-6 border-t border-slate-200">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">Dokumentasi Agenda Selesai</h2>
                        <p class="text-slate-500 text-xs mt-0.5">Arsip kegiatan yang telah sukses dilaksanakan</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-slate-200 text-slate-700 rounded-full">
                        {{ $pastEvents->count() }} Kegiatan Selesai
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($pastEvents as $event)
                        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-xs opacity-85 hover:opacity-100 transition">
                            <div class="flex items-center justify-between text-xs text-slate-500 mb-2">
                                <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($event->date)->isoFormat('D MMMM Y') }}</span>
                                <span class="px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-semibold text-[10px]">Selesai</span>
                            </div>
                            <h4 class="font-black text-slate-900 text-base mb-1">{{ $event->title }}</h4>
                            <p class="text-xs text-slate-500 line-clamp-2">{{ $event->description }}</p>
                            @if($event->location)
                                <div class="mt-3 pt-3 border-t border-slate-100 text-[11px] text-slate-400 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $event->location }}
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

    </div>
</div>
@endsection

