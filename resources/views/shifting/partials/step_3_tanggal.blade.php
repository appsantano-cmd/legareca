<div class="step-content" data-step="3">
    <h3>Step 3 – Detail Shift</h3>

    {{-- SHIFT ASLI --}}
    <div class="form-group">
        <label>Shift Asli Karyawan *</label>
        <p class="subtitle">Tanggal dan jam shift yang seharusnya</p>
        
        <div class="form-row">
            <div style="flex: 1">
                <input
                    type="date"
                    name="tanggal_shift_asli"
                    id="tanggal_shift_asli"
                    required
                    value="{{ old('tanggal_shift_asli') }}"
                    onchange="hideError('tanggal_shift_asli')"
                >
                <div class="error-text" id="tanggal_shift_asli_error"></div>
            </div>
            <div style="flex: 1">
                <input
                    type="time"
                    name="jam_shift_asli"
                    id="jam_shift_asli"
                    required
                    value="{{ old('jam_shift_asli') }}"
                    onchange="hideError('jam_shift_asli')"
                >
                <div class="error-text" id="jam_shift_asli_error"></div>
            </div>
        </div>
    </div>

    {{-- SHIFT YANG DIINGINKAN --}}
    <div class="form-group">
        <label>Shift yang Diinginkan *</label>
        <p class="subtitle">Tanggal dan jam untuk tukar shift</p>
        
        <div class="form-row">
            <div style="flex: 1">
                <input
                    type="date"
                    name="tanggal_shift_tujuan"
                    id="tanggal_shift_tujuan"
                    required
                    value="{{ old('tanggal_shift_tujuan') }}"
                    onchange="hideError('tanggal_shift_tujuan')"
                >
                <div class="error-text" id="tanggal_shift_tujuan_error"></div>
            </div>
            <div style="flex: 1">
                <input
                    type="time"
                    name="jam_shift_tujuan"
                    id="jam_shift_tujuan"
                    required
                    value="{{ old('jam_shift_tujuan') }}"
                    onchange="hideError('jam_shift_tujuan')"
                >
                <div class="error-text" id="jam_shift_tujuan_error"></div>
            </div>
        </div>
    </div>

    <div class="nav-buttons">
        <button type="button" class="btn-prev">← Kembali</button>
        <button type="button" class="btn-next">Lanjut →</button>
    </div>
</div>