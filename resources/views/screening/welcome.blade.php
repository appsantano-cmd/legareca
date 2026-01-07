<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome VIP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body
    class="bg-gradient-to-r from-[#f8d7da] via-[#fbeaec] to-[#f8d7da] min-h-screen flex items-center justify-center px-6">

    <div class="text-center max-w-3xl w-full">
        <h1 class="text-5xl font-extrabold text-black mb-2">Welcome! VIP</h1>
        <p class="text-xl font-semibold text-gray-700 mb-6">(Very Important Pets)</p>

        <p class="text-lg text-black leading-relaxed mb-12">
            We're excited to care for your furry friend. Please help us get to know them better by answering a few
            questions.
        </p>

        <button onclick="window.location.href='{{ route('screening.agreement') }}'"
            class="bg-[#ff6b6b] hover:bg-[#ff5252] text-white font-semibold text-xl px-12 py-4 rounded-full shadow-lg transition transform hover:scale-105">
            Start
        </button>
    </div>

</body>

</html>