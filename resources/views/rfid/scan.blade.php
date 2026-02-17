<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Presensi RFID</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-900 via-indigo-800 to-indigo-900 text-white">

<div class="h-full flex flex-col">

    {{-- ================= HEADER ================= --}}
    <header class="flex justify-between items-center px-8 py-4 bg-black/30">
        <div class="flex items-center gap-4">
            {{-- LOGO --}}
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-700 font-bold text-xl">
                LOGO
            </div>
            <h1 class="text-xl font-semibold">Sistem Presensi RFID</h1>
        </div>

        {{-- TANGGAL & JAM --}}
        <div class="text-right">
            <div id="date" class="text-sm opacity-80"></div>
            <div id="clock" class="text-2xl font-mono"></div>
        </div>
    </header>

    {{-- ================= MAIN ================= --}}
    <main class="flex-1 grid grid-cols-3 gap-6 p-6">

        {{-- ===== PANEL SCAN ===== --}}
        <div class="col-span-1 bg-white/10 rounded-2xl p-6 flex flex-col justify-center text-center">
            <h2 class="text-2xl font-bold mb-4">Scan Kartu RFID</h2>

            <input type="text"
                   id="uid_rfid"
                   autofocus
                   placeholder="Tempelkan kartu RFID"
                   class="text-black text-center text-xl px-4 py-3 rounded-xl outline-none">

            <div id="scanMessage" class="mt-6 text-lg font-semibold"></div>

            {{-- DATA KARYAWAN --}}
            <div id="employeeInfo" class="mt-6 hidden">
                <div class="bg-white/20 rounded-xl p-4">
                    <p class="text-lg font-bold" id="empName"></p>
                    <p class="text-sm" id="empNik"></p>
                    <p class="text-sm" id="empJabatan"></p>
                    <p class="mt-2 font-mono text-sm" id="scanTime"></p>
                </div>
            </div>
        </div>

        {{-- ===== RIWAYAT PRESENSI ===== --}}
        <div class="col-span-2 bg-white/10 rounded-2xl p-6 overflow-hidden">
            <h2 class="text-xl font-semibold mb-4">Riwayat Presensi Hari Ini</h2>

            <table class="w-full text-sm">
                <thead class="bg-white/20">
                    <tr>
                        <th class="p-2 text-left">Nama</th>
                        <th class="p-2 text-center">Tanggal</th>
                        <th class="p-2 text-center">Masuk</th>
                        <th class="p-2 text-center">Pulang</th>
                        <th class="p-2 text-center">Status</th>
                    </tr>
                </thead>
                <tbody id="attendanceLog">
                    <tr>
                        <td colspan="5" class="p-4 text-center text-gray-300">
                            Belum ada presensi
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </main>
</div>

{{-- ================= AUDIO ================= --}}
<audio id="beepSuccess" src="https://actions.google.com/sounds/v1/cartoon/clang_and_wobble.ogg"></audio>
<audio id="beepError" src="https://actions.google.com/sounds/v1/alarms/beep_short.ogg"></audio>

<script>
/* ======================
   JAM & TANGGAL REALTIME
====================== */
function updateDateTime() {
    const now = new Date();

    const dateOptions = {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    };

    document.getElementById('date').innerText =
        now.toLocaleDateString('id-ID', dateOptions);

    document.getElementById('clock').innerText =
        now.toLocaleTimeString('id-ID');
}

setInterval(updateDateTime, 1000);
updateDateTime();

/* ======================
   SCAN RFID
====================== */
const input = document.getElementById('uid_rfid');
const message = document.getElementById('scanMessage');
const infoBox = document.getElementById('employeeInfo');

const successSound = document.getElementById('beepSuccess');
const errorSound = document.getElementById('beepError');

input.addEventListener('change', function () {

    fetch("{{ route('rfid.scan.process') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            uid_rfid: this.value
        })
    })
    .then(res => res.json())
    .then(data => {

        input.value = '';

        const now = new Date();
        const tanggal = now.toLocaleDateString('id-ID');

        if (data.status === 'success') {
            successSound.play();
            message.innerHTML = `<span class="text-green-400">${data.message}</span>`;
        } else {
            errorSound.play();
            message.innerHTML = `<span class="text-red-400">${data.message}</span>`;
        }

        if (data.employee) {
            infoBox.classList.remove('hidden');
            document.getElementById('empName').innerText = data.employee.nama;
            document.getElementById('empNik').innerText = data.employee.nik;
            document.getElementById('empJabatan').innerText = data.employee.jabatan;
            document.getElementById('scanTime').innerText =
                tanggal + ' ' + (data.time ?? '');
        }

        if (data.status === 'success') {
            addAttendanceRow(data, tanggal);
        }
    });
});

/* ======================
   TAMBAH RIWAYAT PRESENSI
====================== */
function addAttendanceRow(data, tanggal) {
    const tbody = document.getElementById('attendanceLog');

    const row = `
        <tr class="border-b border-white/20">
            <td class="p-2">${data.employee.nama}</td>
            <td class="p-2 text-center">${tanggal}</td>
            <td class="p-2 text-center">${data.message.includes('masuk') ? data.time : '-'}</td>
            <td class="p-2 text-center">${data.message.includes('pulang') ? data.time : '-'}</td>
            <td class="p-2 text-center">
                <span class="px-2 py-1 rounded-full bg-green-500/20 text-green-300">
                    ${data.message}
                </span>
            </td>
        </tr>
    `;

    tbody.insertAdjacentHTML('afterbegin', row);
}
</script>

</body>
</html>
