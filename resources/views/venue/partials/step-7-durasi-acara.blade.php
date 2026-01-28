<div class="step-header">
    <h2>Durasi Acara</h2>
    <p>Tentukan durasi penggunaan venue.</p>
</div>

<div class="form-group">
    <label for="durasi_type">Tipe Durasi *</label>
    <select id="durasi_type" name="durasi_type" required>
        <option value="">-- Pilih Tipe Durasi --</option>
        <option value="jam" {{ old('durasi_type', $formData['durasi_type'] ?? '') == 'jam' ? 'selected' : '' }}>Jam
        </option>
        <option value="hari" {{ old('durasi_type', $formData['durasi_type'] ?? '') == 'hari' ? 'selected' : '' }}>Hari
        </option>
        <option value="minggu" {{ old('durasi_type', $formData['durasi_type'] ?? '') == 'minggu' ? 'selected' : '' }}>
            Minggu</option>
        <option value="bulan" {{ old('durasi_type', $formData['durasi_type'] ?? '') == 'bulan' ? 'selected' : '' }}>
            Bulan</option>
    </select>
    <div class="error-message" id="durasi_type_error"></div>
</div>

<!-- Durasi Jam -->
<div id="durasi-jam-fields" class="durasi-fields"
    style="display: {{ old('durasi_type', $formData['durasi_type'] ?? '') == 'jam' ? 'block' : 'none' }};">
    <div class="form-group">
        <label for="jam_mulai">Jam Mulai *</label>
        <input type="time" id="jam_mulai" name="jam_mulai"
            value="{{ old('jam_mulai', $formData['jam_mulai'] ?? '') }}">
        <div class="error-message" id="jam_mulai_error"></div>
    </div>
    <div class="form-group">
        <label for="jam_selesai">Jam Selesai *</label>
        <input type="time" id="jam_selesai" name="jam_selesai"
            value="{{ old('jam_selesai', $formData['jam_selesai'] ?? '') }}">
        <div class="error-message" id="jam_selesai_error"></div>
    </div>
</div>

<!-- Durasi Hari -->
<div id="durasi-hari-fields" class="durasi-fields"
    style="display: {{ old('durasi_type', $formData['durasi_type'] ?? '') == 'hari' ? 'block' : 'none' }};">
    <div class="form-group">
        <label for="tanggal_mulai_hari">Tanggal Mulai *</label>
        <input type="date" id="tanggal_mulai_hari" name="tanggal_mulai_hari"
            value="{{ old('tanggal_mulai_hari', $formData['tanggal_mulai'] ?? '') }}">
        <div class="error-message" id="tanggal_mulai_hari_error"></div>
    </div>
    <div class="form-group">
        <label for="tanggal_selesai_hari">Tanggal Selesai *</label>
        <input type="date" id="tanggal_selesai_hari" name="tanggal_selesai_hari"
            value="{{ old('tanggal_selesai_hari', $formData['tanggal_selesai'] ?? '') }}">
        <div class="error-message" id="tanggal_selesai_hari_error"></div>
    </div>
</div>

<!-- Durasi Minggu -->
<div id="durasi-minggu-fields" class="durasi-fields"
    style="display: {{ old('durasi_type', $formData['durasi_type'] ?? '') == 'minggu' ? 'block' : 'none' }};">
    <div class="form-group">
        <label for="durasi_minggu">Jumlah Minggu *</label>
        <input type="number" id="durasi_minggu" name="durasi_minggu"
            value="{{ old('durasi_minggu', $formData['durasi_minggu'] ?? '') }}" placeholder="1-4 minggu"
            min="1" max="4">
        <div class="error-message" id="durasi_minggu_error"></div>
        <small>Maksimal 4 minggu (1 bulan)</small>
    </div>
</div>

<!-- Durasi Bulan -->
<div id="durasi-bulan-fields" class="durasi-fields"
    style="display: {{ old('durasi_type', $formData['durasi_type'] ?? '') == 'bulan' ? 'block' : 'none' }};">
    <div class="form-group">
        <label for="durasi_bulan">Jumlah Bulan *</label>
        <input type="number" id="durasi_bulan" name="durasi_bulan"
            value="{{ old('durasi_bulan', $formData['durasi_bulan'] ?? '') }}" placeholder="1-12 bulan" min="1"
            max="12">
        <div class="error-message" id="durasi_bulan_error"></div>
        <small>Maksimal 12 bulan (1 tahun)</small>
    </div>
</div>

<div class="step-action">
    <button type="button" class="btn-back">Kembali</button>
    <button type="button" class="btn-next">Selanjutnya</button>
</div>
