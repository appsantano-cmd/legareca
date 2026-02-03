<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You — Le Gareca Space</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-pink-100 flex justify-center min-h-screen pt-20 md:pt-32">

    <a href="/screening"
        class="absolute top-4 left-4 text-sm font-bold bg-[#F87171] px-4 py-2 rounded-full shadow hover:opacity-80 transition"
        style="font-family: Arial Black, Arial, sans-serif;">
        Home
    </a>

    <div class="text-center px-6">
        <!-- Decorative paw prints -->
        <div class="mt-1 flex justify-center space-x-8">
            <!-- Perbandingan 1.27:1 -->
            <img src="/logo.png" alt="logo" class="w-90 h-48 object-contain">
            <!-- 80x64px (ratio 1.25:1) -->
        </div>

        <!-- Check icon -->
        <div class="mt-6 flex justify-center">
            <div class="bg-orange-200 w-12 h-12 flex items-center justify-center rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 11.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <!-- Text -->
        <p class="text-gray-800 mt-6 leading-relaxed text-[22px] sm:text-[20px] md:text-[24px]"
            style="font-family: 'Arial Black', Arial, Helvetica, sans-serif; font-weight: 900; -webkit-text-stroke: 0.6px black;">
            Terima kasih sudah <br>
            melengkapi data anabul Anda. <br>
            Enjoy Le Gareca Space!
        </p>

        <div class="mt-6 flex justify-center">
            <a href="{{ route('screening.review-data') }}"
                class="bg-[#F87171] text-white px-6 py-3 rounded-full shadow-lg
               text-sm md:text-base font-bold
               hover:bg-[#ef4444] hover:scale-105 transition duration-200"
                style="font-family: Arial Black, Arial, sans-serif;">
                Review Data
            </a>
        </div>
    </div>

    <!-- Paw decoration (optional) -->
    <div class="absolute top-4 right-4 opacity-100 text-2xl">
        <img src="/paw.png" alt="logo" class="w-12 h-12 object-contain">
    </div>

</body>

</html>
