<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Anabul — Le Gareca Space</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#fbeaec] min-h-screen flex items-center justify-center px-5 py-10">

    <div class="w-full max-w-4xl text-center">
        <h1 class="text-3xl md:text-4xl font-bold text-[#4a2c2a] mb-8">
            Nama Pet <span class="text-red-500">*</span>
        </h1>

        @php
            $count = request()->query('count');
            $count = is_numeric($count) && $count > 0 ? (int) $count : 1;
            $count = $count > 10 ? 10 : $count; // optional limit
        @endphp

        <form id="petForm" action="{{ route('screening.submitPets') }}" method="POST">
            @csrf

            <div class="overflow-x-auto bg-red-200/40 p-4 rounded-2xl shadow-md">
                <table class="w-full text-gray-800 border-collapse rounded-xl overflow-hidden">
                    <thead class="bg-red-300/50">
                        <tr class="text-lg font-bold">
                            <th class="border p-3">Nama Pet</th>
                            <th class="border p-3">Breed</th>
                            <th class="border p-3">Sex</th>
                            <th class="border p-3">Usia Pet</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @for ($i = 0; $i < $count; $i++)
                            <tr>
                                <td class="border p-2">
                                    <input type="text" name="pets[{{ $i }}][name]" required
                                        class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-300 focus:outline-none">
                                    <p class="text-red-500 text-xs mt-1 hidden error-msg">Wajib diisi</p>
                                </td>
                                <td class="border p-2">
                                    <input type="text" name="pets[{{ $i }}][breed]"
                                        class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-300 focus:outline-none">
                                </td>
                                <td class="border p-2">
                                    <select name="pets[{{ $i }}][sex]" required
                                        class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-300 focus:outline-none">
                                        <option disabled selected>Pilih</option>
                                        <option>Jantan</option>
                                        <option>Betina</option>
                                    </select>
                                </td>
                                <td class="border p-2">
                                    <input type="number" name="pets[{{ $i }}][age]" min="0" required
                                        class="w-full px-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-300 focus:outline-none">
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <div class="text-center mt-10">
                <button type="button" id="submitBtn"
                    class="bg-[#ff6b6b] hover:bg-[#ff5252] text-white font-bold text-xl px-10 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                    Next →
                </button>
            </div>
        </form>
    </div>

    <script>
        const submitBtn = document.getElementById('submitBtn');
        const petForm = document.getElementById('petForm');
        submitBtn.addEventListener('click', () => petForm.submit());
        submitBtn.addEventListener('click', function () {
            let valid = true;

            // hanya validasi Nama Pet di kolom pertama setiap baris
            document.querySelectorAll('input[name*="[name]"]').forEach((input) => {
                const errorMsg = input.parentElement.querySelector('.error-msg');
                if (input.value.trim() === "") {
                    errorMsg.classList.remove('hidden');
                    input.classList.add('border-red-500');
                    valid = false;
                } else {
                    errorMsg.classList.add('hidden');
                    input.classList.remove('border-red-500');
                }
            });

            if (valid) {
                petForm.submit();
            }
        });

        // hide error saat mulai mengetik
        document.querySelectorAll('input[name*="[name]"]').forEach((input) => {
            input.addEventListener('input', function () {
                const errorMsg = input.parentElement.querySelector('.error-msg');
                errorMsg.classList.add('hidden');
                input.classList.remove('border-red-500');
            });
        });
    </script>

</body>

</html>