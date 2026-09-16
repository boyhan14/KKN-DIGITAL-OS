<x-layouts.app :pageHeading="'Daftarkan UMKM Baru — Desa ' . $village->name">
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Registrasi Profil UMKM Desa</h2>
            <a href="{{ route('village.umkm.index', $village->id) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-600">
                ← Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
            <form action="{{ route('village.umkm.store', $village->id) }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Usaha / Merk UMKM</label>
                    <input type="text" name="business_name" required placeholder="Contoh: Batik Tulis Sukamaju" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Pemilik Usaha</label>
                        <input type="text" name="owner_name" required placeholder="Ibu Siti Rohmah" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori Usaha</label>
                        <select name="category" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="FOOD">Makanan & Minuman</option>
                            <option value="CRAFT">Kerajinan Tangan (Craft)</option>
                            <option value="AGRICULTURE">Hasil Pertanian / Perkebunan</option>
                            <option value="FASHION">Pakaian & Batik</option>
                            <option value="CULINARY">Kuliner & Oleh-oleh</option>
                            <option value="RETAIL">Toko Kelontong & Ritel</option>
                            <option value="SERVICE">Jasa Lokal</option>
                            <option value="OTHER">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi Usaha & Cerita Produk</label>
                    <textarea name="description" rows="3" placeholder="Jelaskan keunikan produk, bahan baku lokal, proses produksi..." class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Alamat Lengkap / Dusun</label>
                    <input type="text" name="address" placeholder="Dusun II RT 04, Desa Sukamaju" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nomor WhatsApp Pemesanan</label>
                        <input type="text" name="whatsapp" placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Akun Instagram / Medsos</label>
                        <input type="text" name="instagram" placeholder="@batiksukamaju" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>

                <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                    <a href="{{ route('village.umkm.index', $village->id) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-md shadow-emerald-600/20">
                        Simpan Profil UMKM
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

