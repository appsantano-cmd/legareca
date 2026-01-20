<div class="step-header">
    <h2>Kontak WhatsApp</h2>
    <p>Nomor WhatsApp akan digunakan untuk konfirmasi booking.</p>
</div>

<div class="form-group">
    <label for="nomer_wa">Nomor WhatsApp *</label>
    <input type="tel" id="nomer_wa" name="nomer_wa" value="{{ old('nomer_wa', $formData['nomer_wa'] ?? '') }}"
        placeholder="Contoh: 081234567890" required>
    <div class="error-message" id="nomer_wa_error"></div>
</div>

<div class="step-action">
    <button type="button" class="btn-back">Kembali</button>
    <button type="button" class="btn-next">Selanjutnya</button>
</div>
