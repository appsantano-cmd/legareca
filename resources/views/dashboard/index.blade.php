<h1>Dashboard</h1>
<p>Login sebagai: {{ auth()->user()->role }}</p>

<ul>
    <li><a href="{{ route('dashboard') }}">Home</a></li>

    @if(auth()->user()->isDeveloper() || auth()->user()->isAdmin())
        <li>
            <strong>User Management</strong>
            <ul>
                <li>
                    <a href="{{ route('users.create') }}">
                        ➕ Tambah User
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if(auth()->user()->isStaff())
        <li>Menu Staff</li>
    @endif
</ul>
