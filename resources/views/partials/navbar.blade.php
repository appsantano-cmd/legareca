<nav class="bg-white shadow px-6 py-4 flex items-center justify-between">
    <div class="flex items-center space-x-3">
        <img src="{{ asset('storage/logo/logo.png') }}" alt="logo" class="h-10">
    </div>

    <div class="space-x-4">
        <a href="{{ route('izin.index') }}" class="text-gray-700 hover:text-blue-600">
            Pengajuan Izin
        </a>
        <a href="{{ route('logout') }}"
           class="text-red-600 hover:underline"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>