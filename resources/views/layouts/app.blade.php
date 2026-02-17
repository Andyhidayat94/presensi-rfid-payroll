<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Presensi & Payroll')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">
<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('layouts.navigation')

    {{-- MAIN CONTENT --}}
    <div class="flex-1 flex flex-col">

        {{-- HEADER --}}
        <header class="bg-white border-b shadow-sm px-6 py-4 flex justify-between items-center">
            <h1 class="text-lg font-semibold">
                @yield('title', 'Dashboard')
                {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-500">
            @yield('breadcrumb')
        </nav>
            </h1>

            <div class="flex items-center gap-3">
                <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button
        type="submit"
        class="
            inline-flex items-center
            h-9
            px-5
            rounded-full
            bg-blue-600
            text-white
            text-sm
            font-medium
            shadow-sm
            hover:bg-blue-700
            transition
            duration-200
        "
    >
        Logout
    </button>
</form>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>
<footer class="bg-white border-t text-center text-sm text-gray-500 py-4">
    Designed by <span class="font-semibold text-gray-700">Andi Rahman Hidayat</span> © 2026
</footer>
    </div>
</div>
</body>
</html>
