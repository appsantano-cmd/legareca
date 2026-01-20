<div class="step-header">
    <h2>Waktu Acara</h2>
    <p>Tentukan tanggal dan jam acara Anda.</p>
</div>

<input type="hidden" id="hari_acara" name="hari_acara" value="{{ old('hari_acara', $formData['hari_acara'] ?? '') }}">
<input type="hidden" id="tahun_acara" name="tahun_acara" value="{{ old('tahun_acara', $formData['tahun_acara'] ?? '') }}">

<div class="form-group">
    <label for="tanggal_acara">Tanggal Acara *</label>
    <input type="date" id="tanggal_acara" name="tanggal_acara"
        value="{{ old('tanggal_acara', $formData['tanggal_acara'] ?? '') }}" required>
    <div class="error-message" id="tanggal_acara_error"></div>
</div>

<div class="form-group">
    <label for="jam_acara">Jam Acara *</label>
    <input type="time" id="jam_acara" name="jam_acara" value="{{ old('jam_acara', $formData['jam_acara'] ?? '') }}"
        required>
    <div class="error-message" id="jam_acara_error"></div>
</div>

<div class="step-action">
    <button type="button" class="btn-back">Kembali</button>
    <button type="button" class="btn-next">Selanjutnya</button>
</div>
