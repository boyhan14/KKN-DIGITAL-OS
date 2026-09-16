<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk — KKN Digital Village OS</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-b from-slate-50 to-emerald-50/40">

    <div class="w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <a href="{{ route('landing') }}" class="inline-flex items-center space-x-2.5 group">
                <div class="w-12 h-12 rounded-2xl bg-emerald-600 flex items-center justify-center text-white font-black text-xl shadow-lg shadow-emerald-600/25 group-hover:scale-105 transition">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
            </a>
            <h1 class="mt-4 text-2xl font-extrabold text-slate-900 tracking-tight">Masuk ke Workspace</h1>
            <p class="text-xs text-slate-500 mt-1">KKN Digital Village OS — Kolaborasi Digital Mahasiswa & Desa</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white p-8 rounded-3xl border border-slate-200 shadow-xl shadow-slate-200/50">
            @if($errors->any())
                <div class="mb-5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'student@example.com') }}" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Password</label>
                    </div>
                    <input type="password" id="password" name="password" value="password" required 
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 outline-hidden transition">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 text-slate-600">
                        <input type="checkbox" name="remember" class="rounded-sm border-slate-300 text-emerald-600 focus:ring-emerald-500">
                        <span>Ingat saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-md shadow-emerald-600/20 transition">
                    Masuk ke Workspace
                </button>
            </form>

            <!-- Quick Demo Accounts Switcher -->
            <div class="mt-6 pt-6 border-t border-slate-100 text-xs">
                <span class="font-bold text-slate-700 block mb-2">Akun Demo (Password: <code class="bg-slate-100 px-1 py-0.5 rounded text-emerald-700 font-semibold">password</code>):</span>
                <div class="grid grid-cols-2 gap-1.5 text-[11px]">
                    <button type="button" onclick="fillForm('campus@example.com')" class="p-1.5 rounded-lg bg-slate-50 hover:bg-emerald-50 text-left border border-slate-200">
                        <strong>Admin Kampus</strong>
                    </button>
                    <button type="button" onclick="fillForm('supervisor@example.com')" class="p-1.5 rounded-lg bg-slate-50 hover:bg-emerald-50 text-left border border-slate-200">
                        <strong>Dosen (DPL)</strong>
                    </button>
                    <button type="button" onclick="fillForm('leader@example.com')" class="p-1.5 rounded-lg bg-slate-50 hover:bg-emerald-50 text-left border border-slate-200">
                        <strong>Ketua KKN</strong>
                    </button>
                    <button type="button" onclick="fillForm('student@example.com')" class="p-1.5 rounded-lg bg-slate-50 hover:bg-emerald-50 text-left border border-slate-200">
                        <strong>Mahasiswa KKN</strong>
                    </button>
                    <button type="button" onclick="fillForm('village@example.com')" class="p-1.5 rounded-lg bg-slate-50 hover:bg-emerald-50 text-left border border-slate-200">
                        <strong>Admin Desa</strong>
                    </button>
                    <button type="button" onclick="fillForm('superadmin@example.com')" class="p-1.5 rounded-lg bg-slate-50 hover:bg-emerald-50 text-left border border-slate-200">
                        <strong>Super Admin</strong>
                    </button>
                </div>
            </div>
        </div>

        <p class="text-center text-xs text-slate-500 mt-6">
            Belum memiliki akun? <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700">Daftar sekarang</a>
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

