<div class="step-content" data-step="1">
    <h3>Step 1 – Data Karyawan</h3>

    <div class="form-group">
        <label for="nama_karyawan">Nama Lengkap Karyawan *</label>
        <input
            type="text"
            id="nama_karyawan"
            name="nama_karyawan"
            required
            placeholder="Masukkan nama lengkap karyawan"
            value="{{ old('nama_karyawan') }}"
            oninput="hideError('nama_karyawan')"
        >
        <div class="error-text" id="nama_karyawan_error"></div>
    </div>

    <button type="button" class="btn-next">Lanjut →</button>
</div>
