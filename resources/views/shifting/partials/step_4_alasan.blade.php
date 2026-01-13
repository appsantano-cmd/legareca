<div class="step-content" data-step="4">
    <h3>Step 4 – Alasan Pengajuan</h3>

    <div class="form-group">
        <label for="alasan">Alasan Pengajuan Tukar Shift *</label>
        <p class="subtitle">Jelaskan alasan pengajuan secara detail (minimal 10 karakter)</p>
        <textarea
            id="alasan"
            name="alasan"
            rows="5"
            required
            placeholder="Tuliskan alasan pengajuan tukar shift secara detail..."
            oninput="hideError('alasan'); document.getElementById('charCount').textContent = this.value.length;"
        >{{ old('alasan') }}</textarea>
        <div style="text-align: right; margin-top: 5px; font-size: 12px; color: #666;">
            <span id="charCount">{{ strlen(old('alasan', '')) }}</span> / 1000 karakter
        </div>
        <div class="error-text" id="alasan_error"></div>
    </div>

    <div class="nav-buttons">
        <button type="button" class="btn-prev">← Kembali</button>
        <button type="button" class="btn-next">Lanjut →</button>
    </div>
</div>