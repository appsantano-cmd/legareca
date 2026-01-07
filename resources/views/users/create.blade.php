<h2>Tambah User Karyawan</h2>

@if ($errors->any())
    <ul style="color:red">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@endif

<form method="POST" action="{{ route('users.store') }}">
    @csrf

    <label>Nama</label><br>
    <input type="text" name="name" value="{{ old('name') }}" required>
    <br><br>

    <label>Email</label><br>
    <input type="email" name="email" value="{{ old('email') }}" required>
    <br><br>

    <label>Password</label><br>
    <input type="password" name="password" required>
    <br><br>

    <label>Konfirmasi Password</label><br>
    <input type="password" name="password_confirmation" required>
    <br><br>

    <label>Role</label><br>
    <select name="role" required>
        <option value="">-- Pilih Role --</option>

        @if(auth()->user()->isDeveloper())
            <option value="developer" {{ old('role')=='developer' ? 'selected' : '' }}>
                Developer
            </option>
        @endif

        <option value="admin" {{ old('role')=='admin' ? 'selected' : '' }}>
            Admin
        </option>

        <option value="staff" {{ old('role')=='staff' ? 'selected' : '' }}>
            Staff
        </option>
    </select>

    <br><br>

    <button type="submit">Simpan</button>
    <a href="{{ route('users.index') }}">Batal</a>
</form>
