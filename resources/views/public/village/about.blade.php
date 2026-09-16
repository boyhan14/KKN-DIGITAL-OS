<x-layouts.public :village="$village" :title="'Profil & Sejarah — Desa ' . $village->name">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16 space-y-12">
        
        <!-- Header -->
        <div class="text-center space-y-3">
            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold uppercase tracking-wider">
                Profil Resmi
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Desa {{ $village->name }}</h1>
            <p class="text-slate-600 text-sm max-w-2xl mx-auto">
                Kecamatan {{ $village->district }}, Kabupaten {{ $village->regency }}, Provinsi {{ $village->province }} {{ $village->postal_code }}
            </p>
        </div>

        <!-- Visi & Misi Card -->
        <div class="p-8 sm:p-10 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-6">
            <div>
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block mb-1">Visi Desa</span>
                <p class="text-lg sm:text-xl font-bold text-slate-900 italic leading-relaxed">
                    "{{ $profile->vision ?? 'Terwujudnya Desa ' . $village->name . ' yang mandiri, sejahtera, dan terdigitalisasi.' }}"
                </p>
            </div>

            <div class="pt-6 border-t border-slate-100">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block mb-2">Misi Pembangunan Desa</span>
                <div class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">
                    {{ $profile->mission ?? '1. Meningkatkan pelayanan publik berbasis digital.' . PHP_EOL . '2. Mengembangkan potensi UMKM lokal dan pariwisata.' }}
                </div>
            </div>
        </div>

        <!-- Sejarah Singkat -->
        <div class="p-8 sm:p-10 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-4">
            <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block">Sejarah & Asal Usul</span>
            <h3 class="text-2xl font-black text-slate-900">Perjalanan Desa {{ $village->name }}</h3>
            <p class="text-sm text-slate-700 leading-relaxed text-justify whitespace-pre-line">
                {{ $profile->history ?? ('Desa ' . $village->name . ' memiliki akar sejarah dan budaya masyarakat yang kuat, dengan tradisi gotong royong yang terus terpelihara.') }}
            </p>
        </div>

        <!-- Geografi & Demografi Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-2">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block">Kondisi Geografis</span>
                <h4 class="text-lg font-bold text-slate-900">Wilayah & Lingkungan</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    {{ $profile->geography ?? 'Wilayah desa didominasi oleh lahan perkebunan, pertanian produktif, serta bentang alam yang asri.' }}
                </p>
            </div>

            <div class="p-6 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-2">
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block">Demografi Singkat</span>
                <h4 class="text-lg font-bold text-slate-900">Penduduk & Mata Pencaharian</h4>
                <p class="text-xs text-slate-600 leading-relaxed">
                    {{ $profile->demographics_summary ?? 'Masyarakat sebagian besar berprofesi sebagai petani, pengrajin UMKM, dan pedagang lokal.' }}
                </p>
            </div>
        </div>

        <!-- Fasilitas Desa -->
        <div class="p-8 sm:p-10 rounded-3xl bg-white border border-slate-200 shadow-xs space-y-6">
            <div>
                <span class="text-xs font-bold text-emerald-700 uppercase tracking-widest block mb-1">Sarana & Prasarana</span>
                <h3 class="text-2xl font-black text-slate-900">Fasilitas Pelayanan Desa</h3>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @forelse($facilities as $fac)
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-1">
                        <span class="px-2 py-0.5 rounded-md bg-white border border-slate-200 text-[10px] font-bold text-slate-700">
                            {{ $fac->category }}
                        </span>
                        <h4 class="font-bold text-slate-900 text-sm mt-1">{{ $fac->name }}</h4>
                        <p class="text-xs text-slate-500 line-clamp-2">{{ $fac->description }}</p>
                        <span class="text-[11px] text-slate-400 block pt-1">📍 {{ $fac->address ?? 'Area Desa' }}</span>
                    </div>
                @empty
                    <div class="col-span-full p-6 text-center text-xs text-slate-500">
                        Daftar fasilitas publik desa sedang dalam pembaruan.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-layouts.public>

