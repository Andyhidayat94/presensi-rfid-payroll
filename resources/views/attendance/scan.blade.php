<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Scan Presensi RFID</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto text-center">

        <input type="text"
               id="uid_rfid"
               class="border p-3 w-full text-center text-lg"
               placeholder="Tempel kartu RFID..."
               autofocus>

        <div id="result" class="mt-6"></div>

    </div>

<script>
document.getElementById('uid_rfid').addEventListener('change', function () {
    fetch('/rfid/scan', {
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
        document.getElementById('result').innerHTML = `
            <h3>${data.message}</h3>
            ${data.employee ? `
                <p>Nama: ${data.employee.nama}</p>
                <p>NIK: ${data.employee.nik}</p>
                <p>Jabatan: ${data.employee.jabatan}</p>
                <p>Waktu: ${data.time}</p>
            ` : ''}
        `;
        document.getElementById('uid_rfid').value = '';
    });
});
</script>
</x-app-layout>
