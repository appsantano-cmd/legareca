<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screening Anabul</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fbeaec] min-h-screen flex items-center justify-center px-5 py-10">

    <form action="{{ route('screening.submitOwner') }}" method="POST" id="ownerForm">
        @csrf

        <h1 class="text-3xl md:text-4xl font-bold text-[#4a2c2a] mb-2">
            Nama Pemilik <span class="text-red-500">*</span>
        </h1>

        <input type="text" id="ownerName" name="owner" placeholder="Masukkan nama kamu"
            class="w-full px-6 py-4 rounded-full border border-gray-300 shadow-sm text-gray-700">

        <p id="ownerError" class="text-red-500 text-sm mt-2 mb-6 hidden">Wajib diisi</p>


        <h2 class="text-3xl md:text-4xl font-bold text-[#4a2c2a] mb-2 mt-8">
            Berapa jumlah anabul? <span class="text-red-500">*</span>
        </h2>

        <input type="number" id="petCount" name="count" placeholder="Masukkan jumlah anabul" min="1"
            oninput="this.value = this.value.replace(/[^0-9]/g, '')"
            class="w-full px-6 py-4 rounded-full border border-gray-300 shadow-sm text-gray-700">

        <p id="countError" class="text-red-500 text-sm mt-2 mb-10 hidden">Wajib diisi</p>


        <div class="text-center">
            <button type="submit" id="nextBtn"
                class="bg-[#ff6b6b] hover:bg-[#ff5252] text-white font-bold text-xl px-12 py-4 rounded-full shadow-lg transition transform hover:scale-105">
                Next →
            </button>
        </div>
    </form>

    <script>
        document.getElementById('ownerForm').addEventListener('submit', function (e) {
            e.preventDefault();
            let valid = true;

            const owner = document.getElementById('ownerName');
            const count = document.getElementById('petCount');
            const ownerError = document.getElementById('ownerError');
            const countError = document.getElementById('countError');

            if (owner.value.trim() === "") {
                ownerError.classList.remove("hidden");
                valid = false;
            } else {
                ownerError.classList.add("hidden");
            }

            if (count.value.trim() === "" || parseInt(count.value) <= 0) {
                countError.classList.remove("hidden");
                valid = false;
            } else {
                countError.classList.add("hidden");
            }

            if (valid) {
                e.target.submit();
            }
        });
    </script>



</body>

</html>