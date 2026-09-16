@extends('layouts.public', ['title' => 'Dokumentasi & Program KKN', 'metaDescription' => 'Rekam jejak program kerja dan tim mahasiswa KKN di Desa ' . $village->name])

@section('content')
<!-- Header -->
<div class="relative bg-emerald-900 text-white py-16 overflow-hidden">
    <div class="absolute inset-0 opacity-15 bg-[radial-gradient(#fff_1px,transparent_1px)] [background-size:16px_16px]"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-800 text-emerald-200 border border-emerald-700/60 mb-4">
            Pengabdian Perguruan Tinggi
        </span>
        <h1 class="text-3xl sm:text-5xl font-black tracking-tight mb-4">
            Dokumentasi KKN Desa {{ $village->name }}
        </h1>
        <p class="text-lg text-emerald-100 max-w-2xl mx-auto font-light leading-relaxed">
            Sinergi mahasiswa, dosen pembimbing, dan masyarakat dalam membangun desa berdaya saing berbasis teknologi dan potensi lokal.
        </p>
    </div>
</div>

<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        @if(!$group)
            <div class="bg-white rounded-3xl p-12 border border-slate-200 text-center max-w-lg mx-auto">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Informasi KKN Belum Tersedia</h3>
                <p class="text-slate-500 text-sm">Kelompok KKN untuk desa ini belum dihubungkan atau periode penugasan belum dimulai.</p>
            </div>
        @else
            <!-- Group Overview Card -->
            <div class="bg-white rounded-3xl border border-slate-200 p-8 shadow-xs">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                    <div>
                        <div class="flex items-center space-x-2 text-xs font-bold text-emerald-700 uppercase tracking-wider mb-2">
                            <span>{{ $village->campus->name ?? 'Perguruan Tinggi' }}</span>
                            <span>•</span>
                            <span>{{ $group->kknProgram->name ?? 'KKN Tematik Digitalisasi' }}</span>
                        </div>
                        <h2 class="text-3xl font-black text-slate-900">{{ $group->name }}</h2>
                        <p class="text-slate-600 text-sm mt-1">
                            Periode Penugasan: {{ \Carbon\Carbon::parse($group->start_date)->isoFormat('D MMMM Y') }} — {{ \Carbon\Carbon::parse($group->end_date)->isoFormat('D MMMM Y') }}
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-4 py-2 rounded-2xl text-xs font-black uppercase tracking-wider {{ $group->status === 'COMPLETED' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                            Status: {{ $group->status === 'COMPLETED' ? 'SELESAI (SERAH TERIMA)' : 'AKTIF BERJALAN' }}
                        </span>
                        @if($handover)
                            <a href="{{ route('public.village.handover', $village->slug) }}" class="px-4 py-2 bg-emerald-700 hover:bg-emerald-800 text-white rounded-2xl text-xs font-bold transition flex items-center shadow-xs">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Sertifikat Digital Handover</span>
                            </a>
                        @endif
                    </div>
                </div>

                @if($supervisor)
                    <div class="mt-6 pt-6 border-t border-slate-100 flex items-center space-x-3 text-sm">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-800 font-bold flex items-center justify-center shrink-0">
                            {{ substr($supervisor->name, 0, 1) }}
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-bold block uppercase tracking-wider">Dosen Pembimbing Lapangan (DPL)</span>
                            <span class="font-extrabold text-slate-800">{{ $supervisor->name }}</span>
                            <span class="text-xs text-slate-500">({{ $supervisor->email }})</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Work Programs -->
            <section class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900">Program Kerja & Intervensi KKN</h3>
                        <p class="text-slate-500 text-sm">Program pengabdian masyarakat yang diimplementasikan di Desa {{ $village->name }}</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-slate-200 text-slate-700 rounded-full">
                        {{ $programs->count() }} Program
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($programs as $prog)
                        <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-xs flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[11px] font-bold uppercase tracking-wider px-3 py-1 rounded-full bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        {{ $prog->category }}
                                    </span>
                                    <span class="text-xs font-extrabold text-emerald-700">
                                        {{ $prog->progress_percentage }}% Selesai
                                    </span>
                                </div>
                                <h4 class="text-lg font-bold text-slate-900 mb-2">{{ $prog->name }}</h4>
                                <p class="text-slate-600 text-sm leading-relaxed">{{ $prog->description }}</p>
                            </div>

                            <div class="mt-6 pt-4 border-t border-slate-100">
                                <div class="w-full bg-slate-100 rounded-full h-2 mb-3 overflow-hidden">
                                    <div class="bg-emerald-600 h-2 rounded-full transition-all duration-500" style="width: {{ $prog->progress_percentage }}%"></div>
                                </div>
                                <div class="flex items-center justify-between text-xs text-slate-500">
                                    <span>Penanggung Jawab: <strong class="text-slate-700">{{ $prog->leader->name ?? 'Tim KKN' }}</strong></span>
                                    <span>{{ $prog->target_beneficiaries ? $prog->target_beneficiaries . ' Penerima Manfaat' : '' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <!-- Student Roster -->
            <section class="space-y-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-black text-slate-900">Susunan Tim Mahasiswa KKN</h3>
                        <p class="text-slate-500 text-sm">Daftar mahasiswa pelaksana pengabdian dari berbagai program studi</p>
                    </div>
                    <span class="text-xs font-bold px-3 py-1 bg-slate-200 text-slate-700 rounded-full">
                        {{ $members->count() }} Anggota
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($members as $member)
                        @php
                            $user = $member->user ?? $member;
                            $roleName = $member->pivot->role ?? ($member->role_in_group ?? ($user->id === $group->leader_id ? 'LEADER' : 'MEMBER'));
                        @endphp
                        <div class="bg-white rounded-3xl border border-slate-200 p-5 shadow-xs flex items-center space-x-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-emerald-600 to-teal-500 text-white font-black text-xl flex items-center justify-center shrink-0 shadow-sm">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center space-x-2">
                                    <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-full {{ $roleName === 'LEADER' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-600' }}">
                                        {{ $roleName }}
                                    </span>
                                </div>
                                <h4 class="font-extrabold text-slate-900 text-sm truncate mt-1">{{ $user->name }}</h4>
                                <p class="text-xs text-slate-500 truncate">{{ $user->major ?? 'Program Sarjana' }}</p>
                                <p class="text-[11px] text-slate-400 font-mono">{{ $user->student_id ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

    </div>
</div>
@endsection
