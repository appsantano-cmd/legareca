<div class="step-header">
    <h2>Perkiraan Peserta</h2>
    <p>Estimasi jumlah peserta untuk keperluan persiapan venue.</p>
</div>

<div class="form-group">
    <label for="perkiraan_peserta">Jumlah Peserta *</label>
    <input type="number" id="perkiraan_peserta" name="perkiraan_peserta"
        value="{{ old('perkiraan_peserta', $formData['perkiraan_peserta'] ?? '') }}" placeholder="Contoh: 100"
        min="1" max="10000" required>
    <div class="error-message" id="perkiraan_peserta_error"></div>
</div>

<div class="step-action">
    <button type="button" class="btn-back">Kembali</button>
    <button type="button" class="btn-next">Selanjutnya</button>
</div>
