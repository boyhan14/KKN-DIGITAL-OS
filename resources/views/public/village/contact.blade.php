@extends('layouts.public', ['title' => 'Kontak & Pelayanan Warga', 'metaDescription' => 'Hubungi kantor Pemerintah Desa ' . $village->name . ', alamat kantor desa, nomor kontak layanan, dan nomor darurat.'])

@section('content')
<!-- Header -->
<div class="bg-gradient-to-b from-slate-100 to-white border-b border-slate-200 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 mb-3">
            Pelayanan Publik
        </span>
        <h1 class="text-3xl sm:text-4xl font-black text-slate-900 mb-3">
            Kontak & Kantor Desa {{ $village->name }}
        </h1>
        <p class="text-slate-600 max-w-2xl mx-auto text-sm sm:text-base">
            Informasi alamat kantor balai desa, jam pelayanan administrasi, kanal aduan warga, dan kontak darurat.
        </p>
    </div>
</div>

<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            
            <!-- Contact Cards -->
            <div class="space-y-6">
                <!-- Main Office Card -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-xs space-y-4">
                    <h3 class="text-lg font-black text-slate-900 border-b border-slate-100 pb-3">Kantor Balai Desa</h3>

                    <div class="space-y-3 text-sm">
                        <div class="flex items-start space-x-3 text-slate-600">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            <span>{{ $village->profile->address ?? 'Jl. Raya Desa No. 01' }}, Kec. {{ $village->district }}, Kab. {{ $village->regency }}, {{ $village->province }}</span>
                        </div>

                        <div class="flex items-center space-x-3 text-slate-600">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>{{ $village->profile->phone ?? '+62 812-3456-7890' }}</span>
                        </div>

                        <div class="flex items-center space-x-3 text-slate-600">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>{{ $village->profile->email ?? 'kontak@desa.id' }}</span>
                        </div>

                        <div class="flex items-center space-x-3 text-slate-600">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span>Senin - Jumat: 08.00 - 15.30 WIB</span>
                        </div>
                    </div>
                </div>

                <!-- Emergency Contacts -->
                <div class="bg-red-50 rounded-3xl p-6 border border-red-200/80 shadow-xs space-y-4">
                    <h3 class="text-base font-extrabold text-red-900 flex items-center">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-600 mr-2 animate-ping"></span>
                        Nomor Darurat & Siaga Desa
                    </h3>
                    <div class="space-y-3 text-xs">
                        <div class="flex justify-between items-center py-1 border-b border-red-200/60">
                            <span class="text-red-800 font-medium">Bidan Desa / Poskesdes</span>
                            <span class="font-bold text-red-900">0812-9988-1122</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-red-200/60">
                            <span class="text-red-800 font-medium">Babinsa TNI</span>
                            <span class="font-bold text-red-900">0813-2233-4455</span>
                        </div>
                        <div class="flex justify-between items-center py-1 border-b border-red-200/60">
                            <span class="text-red-800 font-medium">Bhabinkamtibmas Polri</span>
                            <span class="font-bold text-red-900">0813-5566-7788</span>
                        </div>
                        <div class="flex justify-between items-center py-1">
                            <span class="text-red-800 font-medium">Mobil Siaga Desa</span>
                            <span class="font-bold text-red-900">0812-7788-9900</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Public Feedback & Consultation Form -->
            <div class="lg:col-span-2 bg-white rounded-3xl p-8 border border-slate-200 shadow-xs space-y-6">
                <div>
                    <h3 class="text-2xl font-black text-slate-900">Kirim Pesan / Aspirasi Warga</h3>
                    <p class="text-slate-500 text-sm mt-1">Sampaikan aspirasi, pertanyaan seputar administrasi, atau masukan untuk pembangunan Desa {{ $village->name }}.</p>
                </div>

                <form onsubmit="event.preventDefault(); alert('Terima kasih! Pesan atau aspirasi Anda telah terkirim ke sistem pelayanan desa.'); this.reset();" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nama Lengkap</label>
                            <input type="text" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" placeholder="Nama Anda">
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Nomor WhatsApp</label>
                            <input type="tel" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" placeholder="08123456789">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Topik Aspirasi / Layanan</label>
                        <select class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-hidden bg-white">
                            <option>Layanan Surat & Administrasi Kependudukan</option>
                            <option>Pertanyaan Usaha & UMKM Desa</option>
                            <option>Saran & Masukan Pembangunan Fasilitas</option>
                            <option>Informasi Program KKN Mahasiswa</option>
                            <option>Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">Isi Pesan / Aspirasi</label>
                        <textarea rows="5" required class="w-full px-4 py-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:outline-hidden" placeholder="Tuliskan pesan atau kebutuhan Anda secara jelas..."></textarea>
                    </div>

                    <button type="submit" class="px-6 py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold rounded-2xl text-sm shadow-md hover:shadow-lg transition">
                        Kirim Pesan ke Balai Desa →
                    </button>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection

