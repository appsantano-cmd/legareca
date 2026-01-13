<div class="step-content" data-step="5">
    <h3>Step 5 – Konfirmasi Pengajuan</h3>

    <p class="subtitle">Harap periksa kembali data pengajuan Anda sebelum submit</p>

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

    <div class="form-group">
        <label>Apakah sudah ada karyawan pengganti? *</label>
        <div class="radio-group">
            <label class="radio-item">
                <input type="radio" name="sudah_pengganti" value="ya"
                       onchange="togglePengganti(true)">
                Ya, sudah ada pengganti
            </label>

            <label class="radio-item">
                <input type="radio" name="sudah_pengganti" value="belum"
                       onchange="togglePengganti(false)">
                Belum ada pengganti
            </label>
        </div>
    </div>

    <div id="penggantiFields" style="display:none;">
        <div class="form-group">
            <label>Nama Karyawan Pengganti *</label>
            <input type="text"
                   name="nama_karyawan_pengganti"
                   placeholder="Masukkan nama karyawan pengganti">
        </div>

        <div class="form-group">
            <label>Tanggal Shift Pengganti *</label>
            <input type="date" name="tanggal_shift_pengganti">
        </div>

        <div class="form-group">
            <label>Jam Shift Pengganti *</label>
            <input type="time" name="jam_shift_pengganti">
        </div>
    </div>

    <div class="nav-buttons">
        <button type="button" class="btn-prev">← Kembali</button>
        <button type="submit" class="btn-submit">Submit Pengajuan</button>
    </div>
</div>
