<aside class="w-64 bg-gradient-to-b from-slate-900 to-slate-800 text-white min-h-screen">

    @php
        $user = Auth::user();
        $role = $user->role->name ?? '';
    @endphp

    <!-- USER HEADER (CLICK TO TOGGLE) -->
    <div x-data="{ open:false }" class="px-5 py-4 border-b border-slate-700">
        <button
            @click="open = !open"
            class="flex items-center gap-3 w-full focus:outline-none"
        >
            <!-- Avatar -->
            @if($user->avatar)
        <img src="{{ asset('storage/'.$user->avatar) }}"
         class="w-11 h-11 rounded-full object-cover">
@else
        <div class="w-11 h-11 rounded-full bg-blue-600 flex items-center justify-center text-lg font-bold">
        {{ strtoupper(substr($user->name,0,1)) }}
            </div>
@endif

            <!-- Name & Role -->
            <div class="flex-1 text-left">
                <div class="text-sm font-semibold">{{ $user->name }}</div>
                <div class="text-xs text-slate-400 capitalize">{{ $role }}</div>
            </div>

            <!-- Arrow -->
            <svg
                class="w-4 h-4 text-slate-400 transition-transform"
                :class="{ 'rotate-180': open }"
                fill="none"
                stroke="currentColor"
                stroke-width="2"
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
            </svg>
        </button>

        <!-- DROPDOWN -->
        <div
            x-show="open"
    x-transition:enter="transition ease-out duration-150"
    x-transition:enter-start="opacity-0 scale-95"
    x-transition:enter-end="opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-100"
    x-transition:leave-start="opacity-100 scale-100"
    x-transition:leave-end="opacity-0 scale-95"
    @click.outside="open=false"
    class="mt-3 bg-slate-800 rounded-lg overflow-hidden text-sm"
        >
            <a href="{{ route('profile.show') }}"
            class="flex items-center gap-2 px-4 py-2 hover:bg-blue-600/20 rounded">
            👤 Profil
            </a>

            <form method="POST" action="{{ route('logout') }}" class="p-2">
                @csrf
                <button
                    type="submit"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white py-2 rounded-full font-semibold transition"
                >
                    Logout
                </button>
            </form>
        </div>
    </div>

    <!-- MENU -->
    <nav class="mt-4 space-y-1 text-sm px-3">

        {{-- MENU KARYAWAN --}}
        @if($role === 'karyawan')
            <a href="/karyawan/dashboard"
               class="menu {{ request()->is('karyawan/dashboard') ? 'menu-active' : '' }}">
                🏠 Dashboard
            </a>

            <a href="/karyawan/attendance"
               class="menu {{ request()->is('karyawan/attendance*') ? 'menu-active' : '' }}">
                📅 Presensi Saya
            </a>

            <a href="/karyawan/slip-gaji"
               class="menu {{ request()->is('karyawan/slip-gaji*') ? 'menu-active' : '' }}">
                💰 Slip Gaji
            </a>

            <a href="/karyawan/password"
               class="menu {{ request()->is('karyawan/password*') ? 'menu-active' : '' }}">
                🔐 Ganti Password
            </a>

            <a href="{{ route('karyawan.cuti.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition
                {{ request()->routeIs('karyawan.cuti.*') 
                ? 'bg-blue-600 text-white shadow'
                : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                <span>📝</span>
                <span>Pengajuan Cuti</span>
            </a>
        @endif

        {{-- MENU HRD --}}
    @if($role === 'hrd')

    <a href="{{ route('hrd.dashboard') }}"
       class="menu {{ request()->is('hrd/dashboard') ? 'menu-active' : '' }}">
        🏠 Dashboard
    </a>

    <a href="{{ route('hrd.employees.index') }}"
       class="menu {{ request()->is('hrd/employees*') ? 'menu-active' : '' }}">
        👥 Data Karyawan
    </a>

    <a href="{{ route('hrd.rfid.index') }}"
       class="menu {{ request()->is('hrd/rfid*') ? 'menu-active' : '' }}">
        💳 Registrasi RFID
    </a>

    <a href="{{ route('hrd.attendance.index') }}"
       class="menu {{ request()->is('hrd/attendance*') ? 'menu-active' : '' }}">
        📅 Rekap Presensi
    </a>

    <a href="{{ route('hrd.cuti.index') }}" 
        class="menu {{ request()->routeIs('hrd.cuti.*') ? 'active' : '' }}">
        📄 Pengajuan Cuti
    </a>

    @endif

    {{-- MENU FINANCE --}}
@if(auth()->user()->role->name == 'finance')

    <a href="{{ route('finance.dashboard') }}"
       class="menu {{ request()->routeIs('finance.dashboard') ? 'active' : '' }}">
        📊 Dashboard
    </a>

    <a href="{{ route('finance.payroll.index') }}"
       class="menu {{ request()->routeIs('finance.payroll.index') ? 'active' : '' }}">
        📄 Payroll Bulanan
    </a>

    <a href="{{ route('finance.payroll.history') }}"
       class="menu {{ request()->routeIs('finance.payroll.history') ? 'active' : '' }}">
        📁 Riwayat Payroll
    </a>

@endif

    {{-- MENU ADMIN --}}
@if(auth()->user()->role->name == 'admin')

    <a href="{{ route('admin.dashboard') }}"
       class="menu {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        🛠 Dashboard
    </a>

    <a href="{{ route('admin.users') }}"
       class="menu {{ request()->routeIs('admin.users') ? 'active' : '' }}">
        👥 Manajemen User
    </a>

    <a href="{{ route('admin.employees') }}"
       class="menu {{ request()->routeIs('admin.employees') ? 'active' : '' }}">
        📋 Approval Karyawan
    </a>

    <a href="{{ route('admin.payroll') }}"
       class="menu {{ request()->routeIs('admin.payroll') ? 'active' : '' }}">
        💰 Approval Payroll
    </a>

    <a href="{{ route('admin.audit') }}"
       class="menu {{ request()->routeIs('admin.audit') ? 'active' : '' }}">
        📑 Audit Log
    </a>

@endif


        {{-- Nanti admin / hrd / finance tinggal copy pola ini --}}
    </nav>
</aside>

<style>
.menu {
    display: block;
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    color: #e5e7eb;
    transition:
        background-color 0.2s ease,
        transform 0.15s ease;
}

.menu:hover {
    background: rgba(255,255,255,0.10);
    transform: translateX(4px);
}

.menu-active {
    background: #2563eb;
    color: white;
    font-weight: 600;
}
</style>

