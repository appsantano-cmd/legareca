<div class="step-header">
    <h2>Email Pemesan</h2>
    <p>Email akan digunakan untuk mengirim invoice dan dokumen.</p>
</div>

<div class="form-group">
    <label for="email">Email *</label>
    <input type="email" id="email" name="email" value="{{ old('email', $formData['email'] ?? '') }}"
        placeholder="contoh@email.com" required>
    <div class="error-message" id="email_error"></div>
</div>

<div class="step-action">
    <button type="button" class="btn-back">Kembali</button>
    <button type="button" class="btn-next">Selanjutnya</button>
</div>
