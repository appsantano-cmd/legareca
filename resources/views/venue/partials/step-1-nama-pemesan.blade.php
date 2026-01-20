<div class="step-header">
    <h2>Data Pemesan</h2>
    <p>Masukkan nama lengkap Anda sebagai pemesan venue.</p>
</div>

<div class="form-group">
    <label for="nama_pemesan">Nama Pemesan *</label>
    <input type="text" id="nama_pemesan" name="nama_pemesan"
        value="{{ old('nama_pemesan', $formData['nama_pemesan'] ?? '') }}" placeholder="Masukkan nama lengkap" required>
    <div class="error-message" id="nama_pemesan_error"></div>
</div>

<div class="step-action">
    <div></div> <!-- Placeholder untuk button back -->
    <button type="button" class="btn-next">Selanjutnya</button>
</div>
