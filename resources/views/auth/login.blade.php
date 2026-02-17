<x-guest-layout>
    <div class="bg-white rounded-2xl shadow-xl px-8 py-10">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-2xl font-bold text-slate-800">
                Selamat Datang
            </h1>
            <p class="text-sm text-slate-500 mt-2">
                Silakan masuk untuk mengakses akunmu
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Email
                </label>
                <input
                    type="email"
                    name="email"
                    required
                    autofocus
                    class="w-full rounded-lg border-slate-300 focus:border-blue-600 focus:ring-blue-600"
                    placeholder="email@naufa.com"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">
                    Password
                </label>
                <input
                    type="password"
                    name="password"
                    required
                    class="w-full rounded-lg border-slate-300 focus:border-blue-600 focus:ring-blue-600"
                    placeholder="••••••••"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-slate-300">
                    <span class="text-slate-600">Ingat saya</span>
                </label>
            </div>

            <!-- Button -->
            <button
                type="submit"
                class="w-full py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold transition">
                Login
            </button>
        </form>
        
    <div class="text-center mt-4">
    <a href="{{ route('rfid.scan.page') }}"
       class="text-blue-600 hover:underline text-sm">
        ➜ Scan Presensi RFID
    </a>
    </div>

        <!-- Footer -->
        <div class="mt-8 text-center text-xs text-slate-400">
            © {{ date('Y') }} Naufa Food
        </div>

    </div>
</x-guest-layout>
