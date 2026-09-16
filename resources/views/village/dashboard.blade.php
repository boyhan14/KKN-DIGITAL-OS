<x-layouts.app :pageHeading="'Dashboard Pemerintahan Desa ' . $village->name">
    <div class="space-y-8">
        
        <!-- Executive Banner for Village Admin -->
        <div class="relative-shimmer p-7 sm:p-9 rounded-3xl bg-gradient-to-r from-amber-950 via-slate-900 to-emerald-950 text-white relative overflow-hidden shadow-2xl border border-amber-500/30">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-amber-500/20 rounded-full blur-3xl animate-pulse-glow pointer-events-none"></div>
            <div class="absolute -left-20 -bottom-20 w-80 h-80 bg-emerald-500/15 rounded-full blur-3xl animate-float pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center space-x-2">
                        <span class="px-3 py-1 rounded-full bg-amber-500/20 text-amber-300 border border-amber-400/30 text-xs font-mono font-extrabold flex items-center space-x-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-400 radar-ping"></span>
                            <span>KANTOR BALAI DESA</span>
                        </span>
                        <span class="text-xs text-amber-200/90 font-medium">Kecamatan {{ $village->district ?? '-' }}, Kabupaten {{ $village->regency ?? '-' }}</span>
                    </div>

                    <h2 class="text-2xl sm:text-4xl font-black mt-2 tracking-tight">Pemerintah Desa {{ $village->name }}</h2>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1 max-w-2xl leading-relaxed">
                        Pusat kendali administrasi aset digital desa, validasi potensi ekonomi UMKM warga, promosi pariwisata, serta pemantauan program pengabdian masyarakat KKN.
                    </p>
                </div>

                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3 shrink-0">
                    <a href="{{ route('public.village.home', $village->slug) }}" target="_blank" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 transition flex items-center space-x-2 shadow-sm">
                        <span>Buka Portal Publik</span>
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                    <a href="{{ route('village.profile.edit', $village->id) }}" class="btn-shimmer px-5 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs shadow-lg shadow-amber-500/20 transition flex items-center space-x-1.5">
                        <span>⚙️ Kelola Profil Balai Desa</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <!-- Role Badge Notice -->
            <div class="mt-6 pt-4 border-t border-white/10 flex items-center justify-between text-xs text-amber-200">
                <span class="flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span><strong>Akses Pemerintah Desa:</strong> Anda mengelola aset digital resmi Desa {{ $village->name }}.</span>
                </span>
                <span class="font-mono text-[11px] text-slate-300">Tema Desa: <strong class="text-amber-300 uppercase">{{ $village->theme ?? 'nature' }}</strong></span>
            </div>
        </div>

        <!-- 4 Quick Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <a href="{{ route('village.umkm.index', $village->id) }}" class="card-lift p-5 sm:p-6 rounded-3xl bg-white border border-slate-200/80 shadow-md block group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-extrabold text-emerald-700 uppercase tracking-wider">Ekonomi Warga</span>
                    <span class="text-xl group-hover:scale-110 transition">🛍️</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $umkmCount }}</div>
                <div class="text-xs text-slate-500 font-medium mt-1">UMKM Warga Terdaftar →</div>
            </a>

            <a href="{{ route('village.tourism.index', $village->id) }}" class="card-lift p-5 sm:p-6 rounded-3xl bg-white border border-slate-200/80 shadow-md block group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-extrabold text-teal-700 uppercase tracking-wider">Potensi Wisata</span>
                    <span class="text-xl group-hover:scale-110 transition">🌄</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $tourismCount }}</div>
                <div class="text-xs text-slate-500 font-medium mt-1">Destinasi Wisata Desa →</div>
            </a>

            <a href="{{ route('village.map.index', $village->id) }}" class="card-lift p-5 sm:p-6 rounded-3xl bg-white border border-slate-200/80 shadow-md block group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-extrabold text-blue-700 uppercase tracking-wider">Geografis GIS</span>
                    <span class="text-xl group-hover:scale-110 transition">📍</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $mapCount }}</div>
                <div class="text-xs text-slate-500 font-medium mt-1">Titik Fasilitas & Peta →</div>
            </a>

            <a href="{{ route('village.articles.index', $village->id) }}" class="card-lift p-5 sm:p-6 rounded-3xl bg-white border border-slate-200/80 shadow-md block group">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-[10px] font-extrabold text-amber-700 uppercase tracking-wider">Informasi Publik</span>
                    <span class="text-xl group-hover:scale-110 transition">📰</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $articleCount }}</div>
                <div class="text-xs text-slate-500 font-medium mt-1">Warta & Berita Terbit →</div>
            </a>
        </div>

        <!-- Middle Section: Handover Certificate & KKN Active Delegation -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Handover & Digital Certificate Card -->
            <div class="card-lift p-6 sm:p-8 rounded-3xl bg-white border border-slate-200/80 shadow-md space-y-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-extrabold text-amber-700 uppercase tracking-wider">Keberlanjutan Sistem</span>
                        @if($isHandedOver)
                            <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold border border-emerald-300 flex items-center space-x-1">
                                <span>✓</span>
                                <span>RESMI DITERIMA DESA</span>
                            </span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-[10px] font-extrabold border border-amber-300">
                                DALAM PROSES KKN
                            </span>
                        @endif
                    </div>

                    <h3 class="text-lg font-black text-slate-900">Status Serah Terima Digital (Handover)</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Aset digital (katalog produk UMKM, peta wilayah, dan portal publik) resmi diserahkan kepada aparatur desa agar tetap berkelanjutan setelah program mahasiswa selesai.
                    </p>

                    <!-- Progress Gauge -->
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-700">Kesiapan Dokumen & Aset</span>
                            <span class="font-black text-amber-600 text-sm">{{ $handoverScore }}%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden p-0.5 border border-slate-200/60">
                            <div class="bg-gradient-to-r from-amber-500 to-emerald-500 h-full rounded-full transition-all duration-700" style="width: {{ $handoverScore }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    @if($handoverPackage)
                        <a href="{{ route('group.handover.certificate', ['group' => $handoverPackage->kkn_group_id, 'package' => $handoverPackage->id]) }}" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs shadow-md transition flex items-center space-x-1.5">
                            <span>📜 Buka Berita Acara & Piagam Resmi</span>
                            <span>→</span>
                        </a>
                    @else
                        <span class="text-xs text-slate-400 italic">Berita acara belum difinalisasi oleh tim KKN.</span>
                    @endif
                </div>
            </div>

            <!-- Active KKN Student Delegation Card -->
            <div class="card-lift p-6 sm:p-8 rounded-3xl bg-white border border-slate-200/80 shadow-md space-y-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-[10px] font-extrabold text-blue-700 uppercase tracking-wider">Mitra Akademik</span>
                        <span class="text-xs font-bold text-slate-400">{{ $activeGroup->group_code ?? 'KKN-14' }}</span>
                    </div>

                    <h3 class="text-lg font-black text-slate-900">Delegasi Mahasiswa KKN yang Bertugas</h3>
                    <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                        Kelompok mahasiswa pengabdian masyarakat yang ditugaskan oleh universitas untuk mendampingi digitalisasi di Desa {{ $village->name }}.
                    </p>

                    @if($activeGroup)
                        <div class="mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-200/80 space-y-2 text-xs">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Nama Kelompok:</span>
                                <strong class="text-slate-900">{{ $activeGroup->group_name }}</strong>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Ketua Kelompok:</span>
                                <strong class="text-emerald-700">{{ $activeGroup->leader->name ?? 'Belum ditentukan' }}</strong>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Dosen Pembimbing (DPL):</span>
                                <strong class="text-slate-900">{{ $activeGroup->supervisor->name ?? 'Belum ditentukan' }}</strong>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500 font-medium">Jumlah Mahasiswa:</span>
                                <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 font-extrabold text-[10px]">
                                    {{ $activeGroup->members->count() }} Orang
                                </span>
                            </div>
                        </div>
                    @else
                        <div class="mt-4 p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-500 italic">
                            Belum ada kelompok KKN aktif yang diplot ke desa ini.
                        </div>
                    @endif
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('village.delegation', $village->id) }}" class="px-4 py-2 rounded-xl bg-slate-100 hover:bg-emerald-50 text-slate-800 hover:text-emerald-800 font-bold text-xs transition flex items-center space-x-1.5">
                        <span>👥 Lihat Struktur & Kontak Delegasi</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

        </div>

        <!-- Action Center: Quick Links for Village Administrators -->
        <div class="p-6 sm:p-8 rounded-3xl bg-white border border-slate-200/80 shadow-md">
            <h3 class="text-base font-black text-slate-900 mb-1">Aksi Cepat Tata Kelola Desa</h3>
            <p class="text-xs text-slate-500 mb-6">Pintasan praktis untuk memperbarui informasi dan aset desa secara mandiri.</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs">
                <a href="{{ route('village.profile.edit', $village->id) }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-amber-50/70 border border-slate-200/80 hover:border-amber-300 transition block group">
                    <span class="text-2xl mb-2 block group-hover:scale-110 transition">🏛️</span>
                    <strong class="text-slate-900 group-hover:text-amber-900 font-extrabold block">Profil & Fasilitas</strong>
                    <span class="text-slate-500 text-[11px] mt-0.5 block">Ubah visi, misi, sejarah, & fasilitas balai</span>
                </a>

                <a href="{{ route('village.umkm.create', $village->id) }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-emerald-50/70 border border-slate-200/80 hover:border-emerald-300 transition block group">
                    <span class="text-2xl mb-2 block group-hover:scale-110 transition">🛍️</span>
                    <strong class="text-slate-900 group-hover:text-emerald-900 font-extrabold block">+ Tambah UMKM Warga</strong>
                    <span class="text-slate-500 text-[11px] mt-0.5 block">Daftarkan produk usaha baru warga desa</span>
                </a>

                <a href="{{ route('village.tourism.create', $village->id) }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-teal-50/70 border border-slate-200/80 hover:border-teal-300 transition block group">
                    <span class="text-2xl mb-2 block group-hover:scale-110 transition">🌄</span>
                    <strong class="text-slate-900 group-hover:text-teal-900 font-extrabold block">+ Tambah Destinasi</strong>
                    <span class="text-slate-500 text-[11px] mt-0.5 block">Publikasikan spot wisata & agrowisata</span>
                </a>

                <a href="{{ route('village.articles.create', $village->id) }}" class="p-4 rounded-2xl bg-slate-50 hover:bg-blue-50/70 border border-slate-200/80 hover:border-blue-300 transition block group">
                    <span class="text-2xl mb-2 block group-hover:scale-110 transition">✍️</span>
                    <strong class="text-slate-900 group-hover:text-blue-900 font-extrabold block">+ Terbitkan Warta</strong>
                    <span class="text-slate-500 text-[11px] mt-0.5 block">Tulis kabar pengumuman / agenda desa</span>
                </a>
            </div>
        </div>

    </div>
</x-layouts.app>
