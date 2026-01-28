<div class="step-header">
    <h2>Jenis Acara</h2>
    <p>Jelaskan jenis acara yang akan dilaksanakan.</p>
</div>

<div class="form-group">
    <label for="jenis_acara">Jenis Acara *</label>
    <input type="text" id="jenis_acara" name="jenis_acara"
        value="{{ old('jenis_acara', $formData['jenis_acara'] ?? '') }}"
        placeholder="Contoh: Seminar, Pernikahan, Workshop, dll." required>
    <div class="error-message" id="jenis_acara_error"></div>
</div>

<div class="step-action">
    <button type="button" class="btn-back">Kembali</button>
    <button type="button" class="btn-next">Selanjutnya</button>
</div>
