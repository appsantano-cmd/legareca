<div class="step-header">
    <h2>Pilih Venue</h2>
    <p>Pilih venue yang ingin Anda booking.</p>
</div>

<div class="form-group">
    <label for="venue">Venue *</label>
    <select id="venue" name="venue" required>
        <option value="">-- Pilih Venue --</option>
        <option value="Ballroom Utama"
            {{ old('venue', $formData['venue'] ?? '') == 'Ballroom Utama' ? 'selected' : '' }}>Ballroom Utama</option>
        <option value="Meeting Room A"
            {{ old('venue', $formData['venue'] ?? '') == 'Meeting Room A' ? 'selected' : '' }}>Meeting Room A</option>
        <option value="Meeting Room B"
            {{ old('venue', $formData['venue'] ?? '') == 'Meeting Room B' ? 'selected' : '' }}>Meeting Room B</option>
        <option value="Open Space Garden"
            {{ old('venue', $formData['venue'] ?? '') == 'Open Space Garden' ? 'selected' : '' }}>Open Space Garden
        </option>
        <option value="Conference Hall"
            {{ old('venue', $formData['venue'] ?? '') == 'Conference Hall' ? 'selected' : '' }}>Conference Hall</option>
        <option value="Auditorium" {{ old('venue', $formData['venue'] ?? '') == 'Auditorium' ? 'selected' : '' }}>
            Auditorium</option>
    </select>
    <div class="error-message" id="venue_error"></div>
</div>

<div class="step-action">
    <button type="button" class="btn-back">Kembali</button>
    <button type="button" class="btn-next">Selanjutnya</button>
</div>
