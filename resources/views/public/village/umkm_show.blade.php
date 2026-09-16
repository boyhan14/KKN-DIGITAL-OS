@extends('layouts.public', ['title' => $umkm->business_name, 'metaDescription' => Str::limit($umkm->description, 150)])

@section('content')
<div class="bg-gradient-to-b from-slate-100 to-white border-b border-slate-200 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-6">
            <a href="{{ route('public.village.home', $village->slug) }}" class="hover:text-emerald-700">Beranda</a>
            <span>/</span>
            <a href="{{ route('public.village.umkm', $village->slug) }}" class="hover:text-emerald-700">Katalog UMKM</a>
            <span>/</span>
            <span class="text-slate-800 font-semibold truncate">{{ $umkm->business_name }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl p-8 border border-slate-200 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-4 mb-4">
                        <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-50 text-emerald-800 border border-emerald-200">
                            {{ $umkm->category }}
                        </span>
                        @if($umkm->status === 'PUBLISHED')
                            <span class="inline-flex items-center text-xs font-semibold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200">
                                <svg class="w-4 h-4 mr-1 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                UMKM Terverifikasi KKN Desa
                            </span>
                        @endif
                    </div>

                    <h1 class="text-3xl sm:text-4xl font-black text-slate-900 mb-4">{{ $umkm->business_name }}</h1>
                    <p class="text-slate-600 text-lg leading-relaxed whitespace-pre-line">{{ $umkm->description }}</p>

                    @if($umkm->address)
                        <div class="mt-6 pt-6 border-t border-slate-100 flex items-start space-x-3 text-slate-600 text-sm">
                            <svg class="w-5 h-5 text-slate-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $umkm->address }}</span>
                        </div>
                    @endif
                </div>

                <!-- Product Catalog Section -->
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h2 class="text-2xl font-black text-slate-900">Katalog Produk & Layanan</h2>
                            <p class="text-slate-600 text-sm">Dukung ekonomi warga lokal dengan memesan langsung ke pelaku usaha.</p>
                        </div>
                        <span class="text-xs font-bold px-3 py-1 bg-slate-200 text-slate-700 rounded-full">
                            {{ $umkm->products->count() }} Produk Tersedia
                        </span>
                    </div>

                    @if($umkm->products->isEmpty())
                        <div class="bg-white rounded-2xl p-8 border border-slate-200 text-center text-slate-500">
                            <p>Belum ada produk spesifik yang ditambahkan. Hubungi pemilik UMKM untuk informasi ketersediaan produk.</p>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            @foreach($umkm->products as $product)
                                <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between">
                                    <div class="relative aspect-video bg-slate-100 overflow-hidden">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100 text-sm font-medium">
                                                Foto Produk Belum Tersedia
                                            </div>
                                        @endif
                                        @if(!$product->is_available)
                                            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-xs flex items-center justify-center text-white font-bold text-sm">
                                                Stok Habis
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-5 flex-1 flex flex-col justify-between">
                                        <div>
                                            <h3 class="text-lg font-bold text-slate-900">{{ $product->name }}</h3>
                                            <p class="text-xs text-slate-500 line-clamp-2 mt-1">{{ $product->description }}</p>
                                        </div>
                                        <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                                            <div>
                                                <span class="text-xs text-slate-400 block font-medium">Harga</span>
                                                <span class="text-lg font-black text-emerald-700">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                            </div>
                                            @if($product->is_available && $umkm->phone)
                                                @php
                                                    $cleanPhone = preg_replace('/[^0-9]/', '', $umkm->phone);
                                                    if(str_starts_with($cleanPhone, '0')) {
                                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                                    }
                                                    $waProductText = urlencode("Halo {$umkm->owner_name}, saya melihat produk '{$product->name}' di website resmi Desa {$village->name}. Apakah masih tersedia dan bisa saya pesan?");
                                                @endphp
                                                <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waProductText }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl inline-flex items-center shadow-xs transition">
                                                    Pesan WA
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar Info & Direct Contact Card -->
            <div class="space-y-6">
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-6">
                    <h3 class="text-lg font-extrabold text-slate-900 border-b border-slate-100 pb-3">Informasi Kontak Pemilik</h3>

                    <div class="space-y-4 text-sm">
                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Pemilik Usaha</span>
                            <span class="font-bold text-slate-800 text-base">{{ $umkm->owner_name }}</span>
                        </div>

                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Nomor Telepon / WhatsApp</span>
                            <span class="font-bold text-slate-800">{{ $umkm->phone ?? 'Tidak dicantumkan' }}</span>
                        </div>

                        @if($umkm->latitude && $umkm->longitude)
                            <div>
                                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider block">Koordinat Peta</span>
                                <span class="font-mono text-xs text-slate-600">{{ $umkm->latitude }}, {{ $umkm->longitude }}</span>
                            </div>
                        @endif
                    </div>

                    @if($umkm->phone)
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $umkm->phone);
                            if(str_starts_with($cleanPhone, '0')) {
                                $cleanPhone = '62' . substr($cleanPhone, 1);
                            }
                            $waMessage = urlencode("Halo {$umkm->owner_name}, saya mengetahui usaha '{$umkm->business_name}' dari website resmi Desa {$village->name}. Saya ingin bertanya tentang produk dan layanan Anda.");
                        @endphp
                        <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waMessage }}" target="_blank" rel="noopener noreferrer" class="w-full py-3.5 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-2xl flex items-center justify-center space-x-2 shadow-md hover:shadow-lg transition">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.771-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.299.144.347.491 1.2.534 1.288.043.088.072.19.014.305-.058.115-.087.187-.174.289-.087.102-.182.228-.26.305-.087.087-.178.182-.077.355.101.174.449.741.964 1.201.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.102-.115.434-.506.549-.68.116-.173.232-.144.39-.086s1.011.477 1.184.564.289.13.332.203c.044.072.044.419-.1 1.024z"/></svg>
                            <span>Chat via WhatsApp</span>
                        </a>
                    @endif

                    @if($umkm->latitude && $umkm->longitude)
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $umkm->latitude }},{{ $umkm->longitude }}" target="_blank" rel="noopener noreferrer" class="w-full py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-2xl flex items-center justify-center space-x-2 transition text-sm">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            <span>Buka di Google Maps</span>
                        </a>
                    @endif
                </div>

                <!-- KKN Digitalization Badge -->
                <div class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-3xl p-6 border border-emerald-200/70 text-xs text-slate-600 space-y-3">
                    <div class="flex items-center space-x-2 text-emerald-800 font-bold">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        <span>Pendampingan Digital KKN</span>
                    </div>
                    <p>Profil UMKM ini telah didigitalkan melalui program kerja KKN Mahasiswa untuk memperluas jangkauan pasar dan mendukung ekonomi desa mandiri.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

