<x-layouts.app :pageHeading="'Edit Wisata: ' . $tourism->name">
    <div class="max-w-2xl mx-auto space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-slate-900">Perbarui Destinasi Wisata</h2>
            <a href="{{ route('village.tourism.index', $village->id) }}" class="text-xs font-bold text-slate-600 hover:text-emerald-600">
                ← Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
            <form action="{{ route('village.tourism.update', ['village' => $village->id, 'tourism' => $tourism->id]) }}" method="POST" class="space-y-4 text-xs">
                @csrf

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Nama Tempat Wisata</label>
                    <input type="text" name="name" value="{{ old('name', $tourism->name) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                        <select name="category" class="w-full px-3.5 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="NATURE" {{ $tourism->category === 'NATURE' ? 'selected' : '' }}>Wisata Alam (Nature)</option>
                            <option value="CULTURE" {{ $tourism->category === 'CULTURE' ? 'selected' : '' }}>Wisata Budaya</option>
                            <option value="CULINARY" {{ $tourism->category === 'CULINARY' ? 'selected' : '' }}>Kuliner</option>
                            <option value="CRAFT" {{ $tourism->category === 'CRAFT' ? 'selected' : '' }}>Kerajinan</option>
                            <option value="HISTORY" {{ $tourism->category === 'HISTORY' ? 'selected' : '' }}>Sejarah</option>
                            <option value="RELIGIOUS" {{ $tourism->category === 'RELIGIOUS' ? 'selected' : '' }}>Religi</option>
                            <option value="ADVENTURE" {{ $tourism->category === 'ADVENTURE' ? 'selected' : '' }}>Petualangan</option>
                            <option value="OTHER" {{ $tourism->category === 'OTHER' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Harga Tiket Masuk (HTM) Rp</label>
                        <input type="number" name="ticket_price" value="{{ old('ticket_price', $tourism->ticket_price) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Deskripsi & Daya Tarik</label>
                    <textarea name="description" rows="4" class="w-full p-3 rounded-xl border border-slate-300 text-xs leading-relaxed">{{ old('description', $tourism->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Jam Operasional</label>
                        <input type="text" name="opening_hours" value="{{ old('opening_hours', $tourism->opening_hours) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kontak Pengelola</label>
                        <input type="text" name="contact" value="{{ old('contact', $tourism->contact) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Alamat / Lokasi</label>
                    <input type="text" name="address" value="{{ old('address', $tourism->address) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-300 text-xs">
                </div>

                @if(!$isLocked)
                    <div class="pt-4 flex justify-end space-x-2 border-t border-slate-100">
                        <a href="{{ route('village.tourism.index', $village->id) }}" class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</a>
                        <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-md shadow-emerald-600/20">
                            Perbarui Data Wisata
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-layouts.app>

