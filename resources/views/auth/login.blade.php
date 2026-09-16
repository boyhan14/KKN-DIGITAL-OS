<!DOCTYPE html>
<html lang="id" class="h-full bg-[#f8fafc]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — KKN Digital Village OS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-full flex items-center justify-center p-4 sm:p-6 bg-[#f8fafc] relative overflow-x-hidden antialiased text-slate-800" x-data="{ selectedRole: 'student@example.com' }">

    <!-- Ambient Aurora Light Background -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
        <div class="absolute -top-40 -left-40 w-[550px] h-[550px] bg-gradient-to-tr from-emerald-400/25 to-teal-300/20 rounded-full blur-3xl animate-pulse-glow"></div>
        <div class="absolute top-1/3 -right-40 w-[500px] h-[500px] bg-gradient-to-bl from-cyan-400/20 to-indigo-400/15 rounded-full blur-3xl animate-float"></div>
        <div class="absolute -bottom-40 left-1/3 w-[600px] h-[600px] bg-gradient-to-tr from-emerald-300/15 to-amber-300/15 rounded-full blur-3xl animate-float-delayed"></div>
        
        <!-- Subtle Mesh Pattern -->
        <div class="absolute inset-0 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:24px_24px] opacity-60"></div>
    </div>

    <!-- Floating Micro Badges (Decorations on Desktop) -->
    <div class="hidden lg:block absolute left-12 top-24 animate-float z-10 pointer-events-none">
        <div class="glass-card-premium px-4 py-3 rounded-2xl shadow-lg flex items-center space-x-3 border border-emerald-100">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 radar-ping"></span>
            <div>
                <div class="text-[11px] font-extrabold text-slate-900">Desa Sukamaju Live</div>
                <div class="text-[10px] text-emerald-600 font-semibold">10 UMKM • 21 Titik GIS</div>
            </div>
        </div>
    </div>

    <div class="hidden lg:block absolute right-12 bottom-20 animate-float-delayed z-10 pointer-events-none">
        <div class="glass-card-premium px-4 py-3 rounded-2xl shadow-lg flex items-center space-x-3 border border-teal-100">
            <div class="w-8 h-8 rounded-xl bg-teal-50 flex items-center justify-center text-teal-600 font-bold text-sm">
                📜
            </div>
            <div>
                <div class="text-[11px] font-extrabold text-slate-900">Berita Acara Digital</div>
                <div class="text-[10px] text-teal-600 font-semibold">Kesiapan Handover 100%</div>
            </div>
        </div>
    </div>

    <!-- Main Login Card Container -->
    <div class="w-full max-w-md relative z-10 my-8">
        
        <!-- Top Brand Pill -->
        <div class="text-center mb-6">
            <a href="{{ route('landing') }}" class="inline-flex items-center space-x-3 group">
                <div class="w-13 h-13 rounded-2xl bg-gradient-to-tr from-emerald-600 via-teal-600 to-emerald-500 flex items-center justify-center text-white font-black text-2xl shadow-xl shadow-emerald-600/30 group-hover:scale-105 group-hover:rotate-1 transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="text-left">
                    <span class="font-extrabold text-xl tracking-tight text-slate-900 block leading-tight">Digital Village</span>
                    <span class="text-[11px] font-bold text-emerald-600 tracking-wider uppercase">KKN Workspace OS</span>
                </div>
            </a>
            <h1 class="mt-4 text-2xl font-black text-slate-900 tracking-tight">Selamat Datang Kembali</h1>
            <p class="text-xs text-slate-500 mt-1">Masuk untuk mengelola workspace KKN dan digitalisasi desa</p>
        </div>

        <!-- Glassmorphism Card -->
        <div class="glass-card-premium p-7 sm:p-8 rounded-3xl border border-white/90 shadow-2xl relative">
            
            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-2xl bg-rose-50/90 border border-rose-200 text-xs text-rose-700 font-semibold flex items-center space-x-2">
                    <svg class="w-4 h-4 text-rose-500 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                        </div>
                        <input type="email" id="email" name="email" value="{{ old('email', 'student@example.com') }}" required 
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200/90 bg-white/90 text-sm font-medium text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition shadow-xs">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-[11px] font-extrabold text-slate-700 uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" id="password" name="password" value="password" required 
                               class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200/90 bg-white/90 text-sm font-medium text-slate-900 focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition shadow-xs">
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center space-x-2 text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span class="font-medium text-slate-600">Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit" class="btn-shimmer w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-emerald-600 via-emerald-500 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-extrabold text-sm shadow-lg shadow-emerald-600/25 active:scale-98 transition duration-200 flex items-center justify-center space-x-2">
                    <span>Masuk ke Workspace</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
            </form>

            <!-- 1-Click Fast Demo Accounts Switcher -->
            <div class="mt-6 pt-5 border-t border-slate-200/70 text-xs">
                <div class="flex items-center justify-between mb-2.5">
                    <span class="font-extrabold text-slate-800 text-[11px] uppercase tracking-wider">⚡ 1-Click Demo Login</span>
                    <span class="text-[10px] text-slate-400 font-mono">Password: password</span>
                </div>
                
                <div class="grid grid-cols-2 gap-2 text-[11px]">
                    <button type="button" @click="selectedRole = 'student@example.com'; fillForm('student@example.com')" 
                            :class="selectedRole === 'student@example.com' ? 'border-emerald-500 bg-emerald-50/80 text-emerald-900 font-bold shadow-xs' : 'border-slate-200/80 bg-white/70 text-slate-700 hover:bg-slate-50'"
                            class="p-2 rounded-xl text-left border transition flex items-center space-x-2 group">
                        <span class="w-5 h-5 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs shrink-0">🎓</span>
                        <div class="truncate">
                            <span class="block leading-tight font-bold">Mahasiswa KKN</span>
                            <span class="text-[9px] text-slate-400 block truncate">student@example.com</span>
                        </div>
                    </button>

                    <button type="button" @click="selectedRole = 'leader@example.com'; fillForm('leader@example.com')" 
                            :class="selectedRole === 'leader@example.com' ? 'border-emerald-500 bg-emerald-50/80 text-emerald-900 font-bold shadow-xs' : 'border-slate-200/80 bg-white/70 text-slate-700 hover:bg-slate-50'"
                            class="p-2 rounded-xl text-left border transition flex items-center space-x-2 group">
                        <span class="w-5 h-5 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center text-xs shrink-0">⭐</span>
                        <div class="truncate">
                            <span class="block leading-tight font-bold">Ketua Tim KKN</span>
                            <span class="text-[9px] text-slate-400 block truncate">leader@example.com</span>
                        </div>
                    </button>

                    <button type="button" @click="selectedRole = 'supervisor@example.com'; fillForm('supervisor@example.com')" 
                            :class="selectedRole === 'supervisor@example.com' ? 'border-emerald-500 bg-emerald-50/80 text-emerald-900 font-bold shadow-xs' : 'border-slate-200/80 bg-white/70 text-slate-700 hover:bg-slate-50'"
                            class="p-2 rounded-xl text-left border transition flex items-center space-x-2 group">
                        <span class="w-5 h-5 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center text-xs shrink-0">👨‍🏫</span>
                        <div class="truncate">
                            <span class="block leading-tight font-bold">Dosen (DPL)</span>
                            <span class="text-[9px] text-slate-400 block truncate">supervisor@example.com</span>
                        </div>
                    </button>

                    <button type="button" @click="selectedRole = 'village@example.com'; fillForm('village@example.com')" 
                            :class="selectedRole === 'village@example.com' ? 'border-emerald-500 bg-emerald-50/80 text-emerald-900 font-bold shadow-xs' : 'border-slate-200/80 bg-white/70 text-slate-700 hover:bg-slate-50'"
                            class="p-2 rounded-xl text-left border transition flex items-center space-x-2 group">
                        <span class="w-5 h-5 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center text-xs shrink-0">🏛️</span>
                        <div class="truncate">
                            <span class="block leading-tight font-bold">Pemerintah Desa</span>
                            <span class="text-[9px] text-slate-400 block truncate">village@example.com</span>
                        </div>
                    </button>

                    <button type="button" @click="selectedRole = 'campus@example.com'; fillForm('campus@example.com')" 
                            :class="selectedRole === 'campus@example.com' ? 'border-emerald-500 bg-emerald-50/80 text-emerald-900 font-bold shadow-xs' : 'border-slate-200/80 bg-white/70 text-slate-700 hover:bg-slate-50'"
                            class="p-2 rounded-xl text-left border transition flex items-center space-x-2 group">
                        <span class="w-5 h-5 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center text-xs shrink-0">🏫</span>
                        <div class="truncate">
                            <span class="block leading-tight font-bold">LPPM Kampus</span>
                            <span class="text-[9px] text-slate-400 block truncate">campus@example.com</span>
                        </div>
                    </button>

                    <button type="button" @click="selectedRole = 'superadmin@example.com'; fillForm('superadmin@example.com')" 
                            :class="selectedRole === 'superadmin@example.com' ? 'border-emerald-500 bg-emerald-50/80 text-emerald-900 font-bold shadow-xs' : 'border-slate-200/80 bg-white/70 text-slate-700 hover:bg-slate-50'"
                            class="p-2 rounded-xl text-left border transition flex items-center space-x-2 group">
                        <span class="w-5 h-5 rounded-lg bg-rose-100 text-rose-700 flex items-center justify-center text-xs shrink-0">⚡</span>
                        <div class="truncate">
                            <span class="block leading-tight font-bold">Super Admin</span>
                            <span class="text-[9px] text-slate-400 block truncate">superadmin@example.com</span>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <p class="text-center text-xs text-slate-500 mt-6">
            Belum memiliki akun? <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 underline">Daftar sekarang</a>
            <span class="mx-2">•</span>
            <a href="{{ route('landing') }}" class="text-slate-500 hover:text-slate-800 font-medium">← Beranda Utama</a>
        </p>
    </div>

    <script>
        function fillForm(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
        }
    </script>
</body>
</html>
