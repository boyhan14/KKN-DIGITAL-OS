<x-layouts.app :pageHeading="'Tambah Destinasi Wisata — Desa ' . $village->name">
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Registrasi Destinasi Wisata Desa</h2>
            <a href="{{ route('village.tourism.index', $village->id) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-600">
                ← Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
            <form action="{{ route('village.tourism.store', $village->id) }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Tempat Wisata</label>
                    <input type="text" name="name" required placeholder="Contoh: Air Terjun Way Lalaan / Puncak Bukit Surya" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                        <select name="category" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="NATURE">Wisata Alam (Nature)</option>
                            <option value="CULTURE">Wisata Budaya & Adat</option>
                            <option value="CULINARY">Wisata Kuliner</option>
                            <option value="CRAFT">Sentra Kerajinan</option>
                            <option value="HISTORY">Situs Sejarah</option>
                            <option value="RELIGIOUS">Wisata Religi</option>
                            <option value="ADVENTURE">Petualangan & Trekking</option>
                            <option value="OTHER">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Harga Tiket Masuk (HTM) Rp</label>
                        <input type="number" name="ticket_price" value="10000" placeholder="0 jika gratis" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi Daya Tarik & Fasilitas</label>
                    <textarea name="description" rows="4" placeholder="Jelaskan keindahan alam, spot foto, fasilitas gazebo/toilet, rute tempuh..." class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Jam Operasional</label>
                        <input type="text" name="opening_hours" value="Setiap Hari, 08.00 - 17.00 WIB" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kontak Pengelola / Pokdarwis</label>
                        <input type="text" name="contact" placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Alamat Lengkap / Rute</label>
                    <input type="text" name="address" placeholder="Dusun Way Lalaan, Desa Sukamaju" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                </div>

                <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                    <a href="{{ route('village.tourism.index', $village->id) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-md shadow-emerald-600/20">
                        Simpan Wisata
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

