<x-layouts.app :pageHeading="'Dashboard Dosen Pembimbing Lapangan (DPL)'">
    <div class="space-y-8" x-data="{ reviewModal: false, activeReview: { type: '', id: 0, title: '', action: 'APPROVE' } }">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">Monitoring & Validasi Kelompok Bimbingan</h2>
                <p class="text-xs text-slate-500 mt-1">Pantau kemajuan harian mahasiswa dan validasi konten sebelum tayang di portal publik desa.</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center space-x-1.5 px-3.5 py-1.5 rounded-2xl bg-amber-50 text-amber-900 font-extrabold text-xs border border-amber-200 shadow-xs">
                    <span class="w-2 h-2 rounded-full bg-amber-500 radar-ping"></span>
                    <span>{{ $totalPending }} Konten Menunggu Review</span>
                </span>
            </div>
        </div>

        <!-- Supervised Groups Cards -->
        <div>
            <h3 class="text-base font-black text-slate-900 mb-4 tracking-tight">Kelompok KKN Bimbingan Anda</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($groups as $group)
                    @php
                        $prog = $groupProgress[$group->id]['total'] ?? 0;
                    @endphp
                    <div class="card-lift p-6 rounded-3xl bg-white border border-slate-200/80 shadow-md flex flex-col justify-between group">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-mono font-extrabold text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200">
                                    {{ $group->group_code }}
                                </span>
                                <span class="text-xs font-black {{ $prog >= 80 ? 'text-emerald-600' : 'text-slate-700' }}">
                                    {{ $prog }}% Selesai
                                </span>
                            </div>
                        <h4 class="text-lg font-black text-slate-900">{{ $group->group_name }}</h4>
                        <p class="text-xs text-slate-500 mt-0.5">
                            Lokasi: <span class="font-bold text-slate-700">Desa {{ $group->village->name ?? '-' }}</span> ({{ $group->village->regency ?? '' }})
                        </p>

                        <!-- Progress Bar -->
                        <div class="w-full bg-slate-100 rounded-full h-2 mt-4 overflow-hidden">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-500 h-2 rounded-full transition-all duration-500" style="width: {{ $prog }}%"></div>
                        </div>

                        <!-- Mini Stats -->
                        <div class="grid grid-cols-3 gap-2 mt-4 pt-4 border-t border-slate-100 text-center text-xs">
                            <div>
                                <span class="block font-black text-slate-900">{{ $group->programs->count() }}</span>
                                <span class="text-[10px] text-slate-500">Program</span>
                            </div>
                            <div>
                                <span class="block font-black text-emerald-600">{{ $group->umkms->count() }}</span>
                                <span class="text-[10px] text-slate-500">UMKM</span>
                            </div>
                            <div>
                                <span class="block font-black text-slate-900">{{ $group->members->count() }}</span>
                                <span class="text-[10px] text-slate-500">Mahasiswa</span>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                            <span class="text-slate-500">Ketua: <strong class="text-slate-700">{{ $group->leader->name ?? '-' }}</strong></span>
                            <a href="{{ route('group.workspace', $group->id) }}" class="font-bold text-emerald-600 hover:text-emerald-700">
                                Buka Workspace →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-8 rounded-2xl bg-white border border-slate-200 text-center text-sm text-slate-500">
                        Belum ada kelompok yang ditugaskan ke Anda.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pending Review Items Queue -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xs overflow-hidden">
            <div class="p-6 border-b border-slate-200 flex items-center justify-between">
                <div>
                    <h3 class="text-base font-bold text-slate-900">Antrean Verifikasi Konten Publik Desa</h3>
                    <p class="text-xs text-slate-500">Validasi kebenaran data UMKM, artikel, dan destinasi wisata sebelum dipublikasikan ke publik.</p>
                </div>
            </div>

            @if($totalPending === 0)
                <div class="p-12 text-center">
                    <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-700">Tidak ada konten yang menunggu persetujuan!</p>
                    <p class="text-xs text-slate-500 mt-1">Semua data yang diajukan mahasiswa telah diproses.</p>
                </div>
            @else
                <div class="divide-y divide-slate-100 text-xs">
                    
                    <!-- UMKM Pending -->
                    @foreach($pendingUmkms as $u)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/80 transition">
                            <div class="flex items-start space-x-3">
                                <div class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 font-bold uppercase text-[10px] shrink-0 mt-0.5">
                                    UMKM
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $u->business_name }}</h4>
                                    <p class="text-slate-500 text-xs mt-0.5">Pemilik: {{ $u->owner_name }} | Kategori: {{ $u->category }} | Telp: {{ $u->whatsapp ?? '-' }}</p>
                                    <p class="text-slate-600 text-xs mt-1 line-clamp-1">{{ $u->description }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 shrink-0">
                                <button @click="reviewModal = true; activeReview = { type: 'umkm', id: {{ $u->id }}, title: '{{ addslashes($u->business_name) }}', action: 'APPROVE' }" 
                                        class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                                    ✓ Setujui & Publikasikan
                                </button>
                                <button @click="reviewModal = true; activeReview = { type: 'umkm', id: {{ $u->id }}, title: '{{ addslashes($u->business_name) }}', action: 'REJECT' }" 
                                        class="px-3.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition">
                                    ✗ Minta Revisi
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <!-- Tourism Pending -->
                    @foreach($pendingTourism as $t)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/80 transition">
                            <div class="flex items-start space-x-3">
                                <div class="px-2.5 py-1 rounded-lg bg-teal-100 text-teal-800 font-bold uppercase text-[10px] shrink-0 mt-0.5">
                                    WISATA
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $t->name }}</h4>
                                    <p class="text-slate-500 text-xs mt-0.5">Kategori: {{ $t->category }} | HTM: Rp {{ number_format($t->ticket_price, 0, ',', '.') }}</p>
                                    <p class="text-slate-600 text-xs mt-1 line-clamp-1">{{ $t->description }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 shrink-0">
                                <button @click="reviewModal = true; activeReview = { type: 'tourism', id: {{ $t->id }}, title: '{{ addslashes($t->name) }}', action: 'APPROVE' }" 
                                        class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                                    ✓ Setujui & Publikasikan
                                </button>
                                <button @click="reviewModal = true; activeReview = { type: 'tourism', id: {{ $t->id }}, title: '{{ addslashes($t->name) }}', action: 'REJECT' }" 
                                        class="px-3.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition">
                                    ✗ Minta Revisi
                                </button>
                            </div>
                        </div>
                    @endforeach

                    <!-- Articles Pending -->
                    @foreach($pendingArticles as $a)
                        <div class="p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/80 transition">
                            <div class="flex items-start space-x-3">
                                <div class="px-2.5 py-1 rounded-lg bg-indigo-100 text-indigo-800 font-bold uppercase text-[10px] shrink-0 mt-0.5">
                                    BERITA
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $a->title }}</h4>
                                    <p class="text-slate-500 text-xs mt-0.5">Kategori: {{ $a->category }} | Penulis: {{ $a->author->name ?? '-' }}</p>
                                    <p class="text-slate-600 text-xs mt-1 line-clamp-1">{{ $a->excerpt }}</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 shrink-0">
                                <button @click="reviewModal = true; activeReview = { type: 'article', id: {{ $a->id }}, title: '{{ addslashes($a->title) }}', action: 'APPROVE' }" 
                                        class="px-3.5 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition">
                                    ✓ Setujui & Publikasikan
                                </button>
                                <button @click="reviewModal = true; activeReview = { type: 'article', id: {{ $a->id }}, title: '{{ addslashes($a->title) }}', action: 'REJECT' }" 
                                        class="px-3.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-bold text-xs transition">
                                    ✗ Minta Revisi
                                </button>
                            </div>
                        </div>
                    @endforeach

                </div>
            @endif
        </div>

        <!-- Approval / Rejection Modal -->
        <div x-show="reviewModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
            <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-slate-200" @click.away="reviewModal = false">
                <h3 class="text-lg font-bold text-slate-900 mb-1" x-text="activeReview.action === 'APPROVE' ? 'Konfirmasi Persetujuan Konten' : 'Permintaan Revisi Konten'"></h3>
                <p class="text-xs text-slate-500 mb-4" x-text="'Item: ' + activeReview.title"></p>
                
                <form action="{{ route('supervisor.review') }}" method="POST" class="space-y-4 text-xs">
                    @csrf
                    <input type="hidden" name="type" :value="activeReview.type">
                    <input type="hidden" name="id" :value="activeReview.id">
                    <input type="hidden" name="action" :value="activeReview.action">

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Catatan / Ulasan Pembimbing</label>
                        <textarea name="comments" rows="3" placeholder="Tuliskan catatan arahan bimbingan atau alasan revisi..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs"></textarea>
                    </div>

                    <div class="flex justify-end space-x-2 pt-2">
                        <button type="button" @click="reviewModal = false" class="px-4 py-2 rounded-xl bg-slate-100 text-slate-700 font-bold">Batal</button>
                        <button type="submit" 
                                :class="activeReview.action === 'APPROVE' ? 'bg-emerald-600 hover:bg-emerald-700 text-white' : 'bg-rose-600 hover:bg-rose-700 text-white'"
                                class="px-5 py-2 rounded-xl font-bold transition"
                                x-text="activeReview.action === 'APPROVE' ? 'Setujui & Publikasikan' : 'Kirim Catatan Revisi'">
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.app>

