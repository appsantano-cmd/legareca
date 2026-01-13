<div class="step-content" data-step="2">
    <h3>Step 2 – Divisi & Jabatan</h3>

    <div class="form-group">
        <label for="divisi_jabatan">Divisi / Jabatan *</label>
        <input
            type="text"
            id="divisi_jabatan"
            name="divisi_jabatan"
            required
            placeholder="Contoh: HRD / Supervisor, Marketing / Staff"
            value="{{ old('divisi_jabatan') }}"
            oninput="hideError('divisi_jabatan')"
        >
        <div class="error-text" id="divisi_jabatan_error"></div>
    </div>

    <div class="nav-buttons">
        <button type="button" class="btn-prev">← Kembali</button>
        <button type="button" class="btn-next">Lanjut →</button>
    </div>
</div>