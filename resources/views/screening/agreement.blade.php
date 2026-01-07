<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kesepakatan Pawrents — Le Gareca Space</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-b from-red-50 to-white min-h-screen px-6 py-10">

<div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-6 md:p-10">
    <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-1">Kesepakatan Pawrents di</h1>
    <h2 class="text-2xl font-bold text-center text-red-500 mb-6">Le Gareca Space</h2>

    <section class="space-y-5 text-gray-700 leading-relaxed">
        <div>
            <h3 class="text-xl font-bold text-gray-900">Syarat masuk Le Gareca Space</h3>
            <ul class="list-disc pl-5">
                <li>Anabul harus sehat.</li>
                <li>Anabul wajib bersih dan tidak berbau.</li>
                <li>Wajib memakai tali/harness/kandang.</li>
                <li>Wajib memakai pampers/manner belt.</li>
                <li>Hanya boleh di area outdoor (pet friendly zone).</li>
            </ul>
        </div>

        <div>
            <h3 class="text-xl font-bold text-gray-900">Area Khusus</h3>
            <ul class="list-disc pl-5">
                <li>Zona pet friendly tersedia (outdoor).</li>
                <li>Tidak boleh masuk ke area indoor.</li>
                <li>Tamu tanpa anabul mendapat area terpisah.</li>
            </ul>
        </div>

        <div>
            <h3 class="text-xl font-bold text-gray-900">Kebersihan & Kenyamanan</h3>
            <ul class="list-disc pl-5">
                <li>Pawrents wajib membawa perlengkapan anabul.</li>
                <li>Jika anabul buang kotoran, pemilik wajib membersihkan.</li>
                <li>Anabul tidak boleh naik ke meja/kursi.</li>
                <li>Dilarang memberi makan anabul dengan peralatan restoran.</li>
            </ul>
        </div>

        <div>
            <h3 class="text-xl font-bold text-gray-900">Keamanan</h3>
            <ul class="list-disc pl-5">
                <li>Anabul harus selalu dalam pengawasan.</li>
                <li>Tidak boleh dibiarkan tanpa tali (on-leash).</li>
                <li>Jika mengganggu, manajemen berhak meminta pawrents menenangkan anabul.</li>
                <li>Di area dog park, anabul disarankan tetap memakai leash.</li>
                <li>Khusus anabul yang sudah lolos CGC (Canine Good Citizen), pawrents boleh melepas anabul di dalam area dog park (off-leash).</li>
            </ul>
        </div>

        <div>
            <h3 class="text-xl font-bold text-gray-900">Layanan Restoran</h3>
            <ul class="list-disc pl-5">
                <li>Le Gareca Space menyediakan mangkuk air gratis (bisa request).</li>
                <li>Tersedia day care untuk anabul di Lega Pet Hotel.</li>
                <li>Staff tidak diperbolehkan memegang anabul tanpa izin pawrents.</li>
            </ul>
        </div>

        <div>
            <h3 class="text-xl font-bold text-gray-900">Hak & Tanggung Jawab</h3>
            <ul class="list-disc pl-5">
                <li>Manajemen berhak menolak tamu dengan anabul sakit/agresif.</li>
                <li>Pawrents bertanggung jawab penuh atas anabul.</li>
                <li>Pawrents bertanggung jawab atas kerusakan properti yang disebabkan oleh anabul.</li>
                <li>Manajemen tidak bertanggung jawab atas kelalaian pawrents yang berakibat pada kesehatan anabul.</li>
            </ul>
        </div>
    </section>

    <!-- CHECKBOX PERSETUJUAN -->
    <div class="mt-10 border-t pt-6 text-center">
        <label class="inline-flex items-center space-x-2 cursor-pointer text-gray-700 font-medium text-base">
            <input type="checkbox" id="agreeCheck" class="w-5 h-5 accent-red-500">
            <span>"Sebagai pawrent, saya sudah membaca dan setuju dengan semua kesepakatan di Le Gareca Space. Siap enjoy dan have fun bareng!" </span>
        </label>
    </div>

    <!-- TOMBOL NEXT -->
    <div class="text-center mt-8">
        <button id="nextBtn" onclick="window.location.href='/screening/form'"
            class="bg-red-400 text-white font-bold text-xl px-8 py-3 rounded-full shadow-md transition opacity-60 cursor-not-allowed"
            disabled>
            Next →
        </button>
    </div>
</div>

<!-- SCRIPT ENABLE BUTTON -->
<script>
    const check = document.getElementById('agreeCheck');
    const btn = document.getElementById('nextBtn');

    check.addEventListener('change', function() {
        if (this.checked) {
            btn.disabled = false;
            btn.classList.remove('opacity-60','cursor-not-allowed');
            btn.classList.add('opacity-100','cursor-pointer','hover:scale-105');
        } else {
            btn.disabled = true;
            btn.classList.add('opacity-60','cursor-not-allowed');
            btn.classList.remove('hover:scale-105');
        }
    });
</script>

</body>
</html>
