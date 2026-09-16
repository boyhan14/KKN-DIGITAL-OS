<x-layouts.app :pageHeading="'Kelola UMKM: ' . $umkm->business_name">
    <div class="space-y-8" x-data="{ productModal: false }">
        
        <!-- Header & Publication Status -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="flex items-center space-x-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-700 text-xs font-bold">{{ $umkm->category }}</span>
                    @if($umkm->status === 'PUBLISHED')
                        <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">✓ PUBLISHED</span>
                    @elseif($umkm->status === 'PENDING_REVIEW')
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">⏳ PENDING REVIEW</span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">DRAFT</span>
                    @endif
                </div>
                <h2 class="text-2xl font-black text-slate-900 mt-2 tracking-tight">{{ $umkm->business_name }}</h2>
                <p class="text-xs text-slate-500 mt-0.5">Pemilik: <strong>{{ $umkm->owner_name }}</strong> | Desa {{ $village->name }}</p>
            </div>

            <div class="flex items-center space-x-2">
                @if(!$isLocked && $umkm->status !== 'PUBLISHED' && $umkm->status !== 'PENDING_REVIEW')
                    <form action="{{ route('village.umkm.submit', ['village' => $village->id, 'umkm' => $umkm->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold text-xs shadow-xs transition">
                            🚀 Ajukan Publikasi ke Dosen
                        </button>
                    </form>
                @endif

                <a href="{{ route('public.village.umkm.show', [$village->slug, $umkm->slug]) }}" target="_blank" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs transition flex items-center space-x-1">
                    <span>Lihat Halaman Publik</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
            </div>
        </div>

        <!-- Two Column Layout: Profile Details & Product Catalog -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Col 1: UMKM Profile Form -->
            <div class="lg:col-span-1 bg-white p-6 rounded-3xl border border-slate-200 shadow-xs space-y-4">
                <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Informasi UMKM</h3>

                <form action="{{ route('village.umkm.update', ['village' => $village->id, 'umkm' => $umkm->id]) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Usaha</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $umkm->business_name) }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Pemilik</label>
                        <input type="text" name="owner_name" value="{{ old('owner_name', $umkm->owner_name) }}" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                            <option value="FOOD" {{ $umkm->category === 'FOOD' ? 'selected' : '' }}>Makanan & Minuman</option>
                            <option value="CRAFT" {{ $umkm->category === 'CRAFT' ? 'selected' : '' }}>Kerajinan (Craft)</option>
                            <option value="AGRICULTURE" {{ $umkm->category === 'AGRICULTURE' ? 'selected' : '' }}>Pertanian & Kebun</option>
                            <option value="FASHION" {{ $umkm->category === 'FASHION' ? 'selected' : '' }}>Fashion & Batik</option>
                            <option value="CULINARY" {{ $umkm->category === 'CULINARY' ? 'selected' : '' }}>Kuliner</option>
                            <option value="RETAIL" {{ $umkm->category === 'RETAIL' ? 'selected' : '' }}>Toko Kelontong</option>
                            <option value="SERVICE" {{ $umkm->category === 'SERVICE' ? 'selected' : '' }}>Jasa</option>
                            <option value="OTHER" {{ $umkm->category === 'OTHER' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi</label>
                        <textarea name="description" rows="3" class="w-full p-2.5 rounded-xl border border-slate-300 text-xs leading-relaxed">{{ old('description', $umkm->description) }}</textarea>
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $umkm->whatsapp) }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Instagram</label>
                        <input type="text" name="instagram" value="{{ old('instagram', $umkm->instagram) }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Alamat</label>
                        <input type="text" name="address" value="{{ old('address', $umkm->address) }}" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>

                    @if(!$isLocked)
                        <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                            Perbarui Profil
                        </button>
                    @endif
                </form>
            </div>

            <!-- Col 2: Product Catalog Manager -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-xs">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">Katalog Produk UMKM</h3>
                            <p class="text-xs text-slate-500">Daftar barang / produk unggulan yang dijual oleh UMKM ini.</p>
                        </div>
                        @if(!$isLocked)
                            <button @click="productModal = true" class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                                + Tambah Produk
                            </button>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @forelse($umkm->products as $product)
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs font-black text-emerald-700">
                                            Rp {{ number_format($product->price, 0, ',', '.') }}
                                        </span>
                                        @if(!$isLocked)
                                            <form action="{{ route('village.umkm.products.destroy', ['village' => $village->id, 'umkm' => $umkm->id, 'product' => $product->id]) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-500 hover:text-rose-700 font-bold text-xs">&times;</button>
                                            </form>
                                        @endif
                                    </div>
                                    <h4 class="font-bold text-slate-900 text-sm">{{ $product->name }}</h4>
                                    <p class="text-xs text-slate-500 mt-1 line-clamp-2">{{ $product->description }}</p>
                                </div>
                                <div class="mt-3 pt-2 border-t border-slate-200/60 text-[10px] text-slate-400">
                                    {{ $product->category ?? 'Umum' }}
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full p-8 rounded-2xl bg-slate-50 text-center text-xs text-slate-500">
                                Belum ada produk yang ditambahkan ke katalog.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>

        <!-- Add Product Modal -->
        <div x-show="productModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="productModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Tambah Produk Baru</h3>
                <form action="{{ route('village.umkm.products.store', ['village' => $village->id, 'umkm' => $umkm->id]) }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Nama Produk</label>
                        <input type="text" name="name" required placeholder="Contoh: Kain Batik Tulis Motif Lada Hitam" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="price" required placeholder="250000" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Kategori Produk</label>
                        <input type="text" name="category" placeholder="Contoh: Pakaian / Makanan Ringan" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs">
                    </div>
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Deskripsi Singkat</label>
                        <textarea name="description" rows="2" placeholder="Bahan, varian rasa, ukuran..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="productModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" class="px-5 py-2 rounded-xl bg-emerald-600 text-white font-bold">Simpan Produk</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app>
