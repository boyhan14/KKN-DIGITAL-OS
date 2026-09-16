<x-layouts.app :pageHeading="'Edit Artikel: ' . $article->title">
    <div class="max-w-3xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Perbarui Artikel / Berita Desa</h2>
            <a href="{{ route('village.articles.index', $village->id) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-600">
                ← Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
            <form action="{{ route('village.articles.update', ['village' => $village->id, 'article' => $article->id]) }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Judul Berita</label>
                    <input type="text" name="title" value="{{ old('title', $article->title) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                    <select name="category" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                        <option value="NEWS" {{ $article->category === 'NEWS' ? 'selected' : '' }}>Berita Umum</option>
                        <option value="KKN" {{ $article->category === 'KKN' ? 'selected' : '' }}>Kabar KKN & Pengabdian</option>
                        <option value="UMKM" {{ $article->category === 'UMKM' ? 'selected' : '' }}>Kisah Sukses UMKM</option>
                        <option value="TOURISM" {{ $article->category === 'TOURISM' ? 'selected' : '' }}>Pariwisata & Budaya</option>
                        <option value="ANNOUNCEMENT" {{ $article->category === 'ANNOUNCEMENT' ? 'selected' : '' }}>Pengumuman Resmi</option>
                        <option value="EDUCATION" {{ $article->category === 'EDUCATION' ? 'selected' : '' }}>Pendidikan & Literasi</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Ringkasan (Excerpt)</label>
                    <textarea name="excerpt" rows="2" class="w-full p-3 rounded-xl border border-slate-300 text-xs">{{ old('excerpt', $article->excerpt) }}</textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Isi Lengkap Artikel</label>
                    <textarea name="content" rows="10" required class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed">{{ old('content', $article->content) }}</textarea>
                </div>

                @if(!$isLocked)
                    <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                        <a href="{{ route('village.articles.index', $village->id) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-md shadow-emerald-600/20">
                            Perbarui Artikel
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-layouts.app>

