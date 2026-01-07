<h2>Manajemen User</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if(auth()->user()->isDeveloper() || auth()->user()->isAdmin())
    <a href="{{ route('users.create') }}">
        ➕ Tambah User
    </a>
@endif

<br><br>

<table border="1" cellpadding="8" cellspacing="0">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->isDeveloper())
                        <strong>Developer</strong>
                    @elseif($user->isAdmin())
                        Admin
                    @else
                        Staff
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Belum ada user</td>
            </tr>
        @endforelse
    </tbody>
</table>
