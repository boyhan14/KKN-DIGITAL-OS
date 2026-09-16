<x-layouts.app :pageHeading="'Tulis Berita Baru — Desa ' . $village->name">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Tulis Kabar / Liputan Kegiatan Desa</h2>
            <a href="{{ route('village.articles.index', $village->id) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-600">
                ← Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
            <form action="{{ route('village.articles.store', $village->id) }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul Berita / Artikel</label>
                    <input type="text" name="title" required placeholder="Contoh: Mahasiswa KKN Bersama Warga Sukamaju Resmikan Direktori Digital UMKM Desa" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                    <select name="category" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                        <option value="NEWS">Berita Umum</option>
                        <option value="KKN">Kabar KKN & Pengabdian</option>
                        <option value="UMKM">Kisah Sukses UMKM</option>
                        <option value="TOURISM">Pariwisata & Budaya</option>
                        <option value="ANNOUNCEMENT">Pengumuman Resmi Desa</option>
                        <option value="EDUCATION">Pendidikan & Literasi</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ringkasan Berita (Excerpt)</label>
                    <textarea name="excerpt" rows="2" placeholder="1-2 kalimat pengantar yang menarik pembaca..." class="w-full p-3 rounded-xl border border-slate-300 text-xs"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Isi Lengkap Artikel</label>
                    <textarea name="content" rows="8" required placeholder="Tuliskan berita lengkap dengan gaya penulisan 5W+1H yang profesional..." class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed"></textarea>
                </div>

                <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                    <a href="{{ route('village.articles.index', $village->id) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-md shadow-emerald-600/20">
                        Simpan Artikel (Draft)
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

