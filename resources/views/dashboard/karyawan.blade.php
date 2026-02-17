<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard Karyawan
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Info Selamat Datang -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <p class="text-lg font-semibold">
                        Selamat datang, {{ auth()->user()->name }}
                    </p>
                    <p class="text-sm text-gray-600">
                        Anda login sebagai <strong>Karyawan</strong>
                    </p>
                </div>
            </div>

            <!-- Menu Karyawan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <!-- Kehadiran -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-2">Kehadiran</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Lihat riwayat presensi harian Anda.
                    </p>
                    <a href="#"
                       class="inline-block text-blue-600 hover:underline">
                        Lihat Kehadiran
                    </a>
                </div>

                <!-- Slip Gaji -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-2">Slip Gaji</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Lihat dan unduh slip gaji bulanan.
                    </p>
                    <a href="#"
                       class="inline-block text-blue-600 hover:underline">
                        Lihat Slip Gaji
                    </a>
                </div>

                <!-- Ubah Password -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-lg mb-2">Keamanan Akun</h3>
                    <p class="text-sm text-gray-600 mb-4">
                        Ubah password akun Anda secara berkala.
                    </p>
                    <a href="{{ route('profile.edit') }}"
                       class="inline-block text-blue-600 hover:underline">
                        Ubah Password
                    </a>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
