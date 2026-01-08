<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome VIP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Custom gradient background */
        .custom-gradient {
            background: linear-gradient(135deg, #f8d7da 0%, #fbeaec 50%, #f8d7da 100%);
        }
    </style>
</head>

<body class="custom-gradient min-h-screen flex items-center justify-center px-6">

    <div class="text-center max-w-3xl w-full">
        <!-- Paw decoration (optional) -->
        <div class="absolute top-4 right-4 opacity-100 text-2xl">
            <img src="/paw.png" alt="logo" class="w-12 h-12 object-contain">
        </div>

        <h1 class="text-5xl md:text-6xl font-extrabold text-black mb-2 tracking-tight">Welcome! VIP</h1>

        <!-- Subtitle with larger font size -->
        <p class="text-2xl md:text-3xl font-bold text-gray-800 mb-6 tracking-wide">
            (Very Important Pets)
        </p>

        <!-- Description text with larger font size -->
        <div class="mb-12 px-4">
            <p class="text-2xl md:text-2xl text-black leading-relaxed font-medium">
                We're excited to care for your furry friend. Please help us get to know them better by answering a few
                questions.
            </p>
        </div>

        <button onclick="window.location.href='{{ route('screening.agreement') }}'"
            class="bg-[#ff6b6b] hover:bg-[#ff5252] text-white font-bold text-xl px-12 py-5 rounded-full shadow-lg transition transform hover:scale-105 active:scale-95">
            Start
        </button>

        <!-- Decorative paw prints -->
        <div class="mt-16 flex justify-center space-x-8  transition-opacity duration-300">
            <!-- Perbandingan 1.27:1 -->
            <img src="/pet.png" alt="Pet Paw" class="w-64 h-48 object-contain transition-transform duration-300">
            <!-- 80x64px (ratio 1.25:1) -->
        </div>
    </div>

</body>

</html>