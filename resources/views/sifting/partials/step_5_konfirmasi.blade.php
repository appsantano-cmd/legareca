<div class="step-content" data-step="5">
    <h3>Step 5 – Konfirmasi Pengajuan</h3>
    
    <p class="subtitle">Harap periksa kembali data pengajuan Anda sebelum submit</p>

    {{-- SUMMARY DATA --}}
    <div class="summary-card">
        <div class="summary-item">
            <strong>Nama Karyawan:</strong>
            <span id="confirm_nama">-</span>
        </div>
        <div class="summary-item">
            <strong>Divisi/Jabatan:</strong>
            <span id="confirm_divisi">-</span>
        </div>
        <div class="summary-item">
            <strong>Shift Asli:</strong>
            <span id="confirm_tanggal_asli">-</span> 
            <span id="confirm_jam_asli">-</span>
        </div>
        <div class="summary-item">
            <strong>Shift Tujuan:</strong>
            <span id="confirm_tanggal_tujuan">-</span>
            <span id="confirm_jam_tujuan">-</span>
        </div>
        <div class="summary-item">
            <strong>Alasan:</strong>
            <span id="confirm_alasan">-</span>
        </div>
    </div>

    {{-- KONFIRMASI PENGGANTI --}}
    <div class="form-group">
        <label>Apakah sudah ada karyawan pengganti? *</label>
        <div class="radio-group">
            <label class="radio-item">
                <input
                    type="radio"
                    name="sudah_pengganti"
                    value="ya"
                    required
                    onchange="togglePengganti(true)"
                    {{ old('sudah_pengganti') == 'ya' ? 'checked' : '' }}
                >
                <span>Ya, sudah ada pengganti</span>
            </label>

            <label class="radio-item">
                <input
                    type="radio"
                    name="sudah_pengganti"
                    value="belum"
                    onchange="togglePengganti(false)"
                    {{ old('sudah_pengganti') == 'belum' ? 'checked' : '' }}
                >
                <span>Belum ada pengganti</span>
            </label>
        </div>
    </div>

    {{-- DETAIL PENGGANTI --}}
    <div id="penggantiFields" style="display: {{ old('sudah_pengganti') == 'ya' ? 'block' : 'none' }};">
        <div class="form-group">
            <label for="tanggal_shift_pengganti">Tanggal Shift Pengganti *</label>
            <input
                type="date"
                name="tanggal_shift_pengganti"
                id="tanggal_shift_pengganti"
                class="input"
                value="{{ old('tanggal_shift_pengganti') }}"
                onchange="hideError('tanggal_shift_pengganti')"
            >
            <div class="error-text" id="tanggal_shift_pengganti_error"></div>
        </div>

        <div class="form-group">
            <label for="jam_shift_pengganti">Jam Shift Pengganti *</label>
            <input
                type="time"
                name="jam_shift_pengganti"
                id="jam_shift_pengganti"
                class="input"
                value="{{ old('jam_shift_pengganti') }}"
                onchange="hideError('jam_shift_pengganti')"
            >
            <div class="error-text" id="jam_shift_pengganti_error"></div>
        </div>
    </div>

    <div class="info-box">
        <p><strong>Informasi:</strong> Pengajuan akan diverifikasi oleh manager dan Anda akan mendapatkan notifikasi via email.</p>
    </div>

    {{-- NAVIGATION BUTTONS --}}
    <div class="nav-buttons">
        <button type="button" class="btn-prev">← Kembali</button>
        <button type="submit" class="btn-submit">
            Submit Pengajuan
        </button>
    </div>
</div>