<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Screening</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#fbeaec] min-h-screen flex items-center justify-center px-5 py-10">

<div class="w-full max-w-3xl bg-white p-8 rounded-2xl shadow-md">
    <h1 class="text-3xl font-bold text-center text-[#4a2c2a] mb-2">Hasil Screening</h1>
    <p class="text-center text-gray-600 mb-6">Diisi oleh <b>pawrent</b> berdasarkan hasil screening dari staff</p>

    @php
        $count = session('count', 1);
        $pets  = session('pets', []);
    @endphp

    <form id="screeningForm" action="{{ route('screening.submitResult') }}" method="POST">
        @csrf

        @foreach([
            'vaksin'  => 'Status Vaksin',
            'kutu'    => 'Kutu',
            'jamur'   => 'Jamur',
            'birahi'  => 'Birahi',
            'kulit'   => 'Kulit',
            'telinga' => 'Telinga',
            'riwayat' => 'Riwayat Kesehatan'
        ] as $key => $label)

            <h2 class="text-xl font-bold text-[#4a2c2a] mt-6 mb-3 text-center">{{ $label }}</h2>

            @for ($i = 0; $i < $count; $i++)
                @php $petName = $pets[$i]['name'] ?? 'Pet ' . ($i+1); @endphp

                <div class="mb-4">
                    <label class="block font-semibold text-gray-800 mb-1">
                        {{ $label }} — {{ $petName }} <span class="text-red-500">*</span>
                    </label>

                    @if($key === 'riwayat')
                        <select name="pets[{{ $i }}][{{ $key }}]"
                            class="w-full px-4 py-2 rounded-full border border-gray-300">
                            <option disabled selected>Pilih</option>
                            <option value="Sehat">Sehat</option>
                            <option value="Pasca terapi">Pasca terapi</option>
                            <option value="Sedang terapi">Sedang terapi</option>
                        </select>
                    @elseif($key === 'vaksin')
                        <select name="pets[{{ $i }}][{{ $key }}]"
                            class="w-full px-4 py-2 rounded-full border border-gray-300">
                            <option disabled selected>Pilih</option>
                            <option value="Belum">Belum</option>
                            <option value="Belum lengkap">Belum lengkap</option>
                            <option value="Sudah lengkap">Sudah lengkap</option>
                        </select>
                    @elseif(in_array($key, ['kutu', 'jamur', 'kulit', 'telinga']))
                        <select name="pets[{{ $i }}][{{ $key }}]"
                            class="w-full px-4 py-2 rounded-full border border-gray-300">
                            <option disabled selected>Pilih</option>
                            <option value="Negatif">Negatif</option>
                            <option value="Positif">Positif</option>
                            <option value="Negatif 2">Negatif 2</option>
                            <option value="Positif 3">Positif 3</option>
                        </select>
                    @elseif($key === 'birahi')
                        <select name="pets[{{ $i }}][{{ $key }}]"
                            class="w-full px-4 py-2 rounded-full border border-gray-300">
                            <option disabled selected>Pilih</option>
                            <option value="Negatif">Negatif</option>
                            <option value="Positif">Positif</option>
                        </select>
                    @endif

                    <p class="text-red-500 text-xs mt-1 hidden error-msg">Wajib diisi</p>
                </div>
            @endfor

        @endforeach

        <div class="text-center mt-8">
            <button type="button" id="nextBtn"
                class="bg-[#ff6b6b] hover:bg-[#ff5252] text-white font-bold text-xl px-10 py-3 rounded-full shadow-lg transition transform hover:scale-105">
                Next →
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('nextBtn').addEventListener('click', () => {
    let valid = true;

    document.querySelectorAll('#screeningForm select, #screeningForm textarea').forEach(input => {
        const error = input.parentElement.querySelector('.error-msg');
        if (!input.value || input.value.trim() === "") {
            error.classList.remove('hidden');
            input.classList.add('border-red-500');
            valid = false;
        } else {
            error.classList.add('hidden');
            input.classList.remove('border-red-500');
        }
    });

    if (valid) document.getElementById('screeningForm').submit();
});

document.querySelectorAll('#screeningForm select, #screeningForm textarea').forEach(input => {
    input.addEventListener('input', () => {
        input.parentElement.querySelector('.error-msg').classList.add('hidden');
        input.classList.remove('border-red-500');
    });
});
</script>

</body>
</html>
