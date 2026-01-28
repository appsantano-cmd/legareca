<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Booking Venue</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #6f4e37, #8b5e3c);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .card {
            background: #fff;
            width: 100%;
            max-width: 540px;
            padding: 40px;
            border-radius: 18px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, .25);
            position: relative;
        }

        /* LOGO */
        .logo-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo {
            max-width: 150px;
            height: auto;
            display: inline-block;
        }

        /* SCREEN */
        .screen {
            display: none;
            animation: fadeSlide .45s ease forwards;
        }

        .screen.active {
            display: block;
        }

        @keyframes fadeSlide {
            from {
                opacity: 0;
                transform: translateY(16px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* INTRO SCREEN STYLING */
        #intro h1 {
            color: #5a3823;
            margin-bottom: 12px;
            text-align: center;
        }

        #intro p {
            font-size: 14px;
            color: #555;
            line-height: 1.7;
            text-align: center;
            margin: 0 auto 20px;
            max-width: 400px;
        }

        h3 {
            color: #5a3823;
            text-align: left;
            margin-bottom: 18px;
        }

        .info-box {
            background: #eef6ff;
            border-left: 4px solid #3b82f6;
            padding: 14px;
            border-radius: 8px;
            margin: 20px 0 30px;
            text-align: left;
            font-size: 14px;
        }

        /* STEP INDICATOR */
        .step-indicator {
            position: relative;
            display: flex;
            justify-content: space-between;
            margin-bottom: 32px;
            padding: 0 6px;
        }

        .step-indicator::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 6px;
            right: 6px;
            height: 3px;
            background: #e5e7eb;
            transform: translateY(-50%);
            z-index: 0;
        }

        .step-progress {
            position: absolute;
            top: 50%;
            left: 6px;
            height: 3px;
            background: #6f4e37;
            transform: translateY(-50%);
            z-index: 1;
            width: 0%;
            transition: width .3s ease;
        }

        .step {
            position: relative;
            z-index: 2;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #e6d0be;
            color: #5a3823;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
        }

        .step.active {
            background: #6f4e37;
            color: #fff;
        }

        /* STEP CONTENT */
        .step-header {
            margin-bottom: 22px;
            text-align: left;
        }

        .step-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: #5a3823;
            margin-bottom: 6px;
        }

        .step-header p {
            font-size: 14px;
            color: #6b7280;
            margin: 0;
        }

        .form-group {
            margin-bottom: 22px;
            text-align: left;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
            display: block;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            font-size: 14px;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #6f4e37;
            box-shadow: 0 0 0 3px rgba(111, 78, 55, .15);
        }

        /* ACTION BUTTONS */
        .step-action {
            margin-top: 30px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .step-action.single {
            display: block;
        }

        .btn-back,
        .btn-next,
        .btn-submit {
            padding: 15px;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .btn-back {
            background: #f3f4f6;
            color: #374151;
        }

        .btn-back:hover {
            background: #e5e7eb;
        }

        .btn-next {
            background: #6f4e37;
            color: #fff;
        }

        .btn-next:hover {
            opacity: .9;
        }

        .btn-submit {
            background: #5a3823;
            color: #fff;
        }

        .btn-submit:hover {
            opacity: .9;
        }

        /* FORM SCREEN STYLING */
        #form-screen h1 {
            color: #5a3823;
            margin-bottom: 12px;
            text-align: center;
        }

        #form-screen p {
            font-size: 14px;
            color: #555;
            line-height: 1.7;
        }

        /* CONFIRMATION STEP STYLING */
        .confirmation-summary {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            margin: 20px 0;
            border: 1px solid #e5e7eb;
        }

        .data-item {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .data-item:last-child {
            border-bottom: none;
        }

        .data-label {
            font-weight: 600;
            color: #374151;
        }

        .data-label .edit-link {
            margin-left: 10px;
            color: #6f4e37;
            text-decoration: none;
            font-size: 12px;
            font-weight: normal;
            cursor: pointer;
        }

        .data-label .edit-link:hover {
            text-decoration: underline;
        }

        .data-value {
            color: #6b7280;
            text-align: right;
            max-width: 60%;
            word-break: break-word;
        }

        .confirmation-note {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 14px;
            color: #92400e;
        }

        /* SUCCESS MESSAGE */
        .success-message {
            text-align: center;
            padding: 30px 0;
        }

        .success-icon {
            font-size: 48px;
            color: #10b981;
            margin-bottom: 15px;
        }

        .success-message h2 {
            color: #5a3823;
            margin-bottom: 10px;
        }

        .success-message p {
            color: #6b7280;
            margin-bottom: 20px;
        }

        .btn-home {
            background: #6f4e37;
            color: #fff;
            padding: 12px 24px;
            border-radius: 12px;
            border: none;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: inline-block;
        }

        .btn-home:hover {
            opacity: .9;
        }

        /* Durasi Fields */
        .durasi-fields {
            margin-top: 15px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
        }

        .durasi-fields .form-group {
            margin-bottom: 15px;
        }

        .durasi-fields .form-group:last-child {
            margin-bottom: 0;
        }

        /* Error Message */
        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 5px;
            display: none;
        }

        .form-group.error input,
        .form-group.error select {
            border-color: #dc2626;
        }

        /* Date Range Container */
        .date-range-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        @media (max-width: 480px) {
            .card {
                padding: 20px;
            }

            .step {
                width: 28px;
                height: 28px;
                font-size: 14px;
            }

            .date-range-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div class="card">
        <!-- LOGO -->
        <div class="logo-container">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="logo">
        </div>

        <!-- INTRO -->
        <div class="screen active" id="intro">
            <h1>Booking Venue</h1>
            <p>Silakan isi formulir berikut untuk melakukan pemesanan venue.</p>

            <div class="info-box">
                <strong>Ketentuan Booking:</strong>
                <ol style="margin:8px 0 0 18px;">
                    <li>Data harus diisi dengan benar</li>
                    <li>Jadwal menyesuaikan ketersediaan venue</li>
                    <li>Tim kami akan melakukan konfirmasi</li>
                </ol>
            </div>

            <div class="step-action single">
                <button type="button" class="btn-next" onclick="startBooking()">Mulai Booking</button>
            </div>
        </div>

        <!-- FORM -->
        <form method="POST" action="{{ route('venue.submit') }}" id="booking-form">
            @csrf
            <input type="hidden" name="step" id="stepInput" value="{{ $currentStep ?? 1 }}">
            <input type="hidden" name="duration_value" id="duration_value">

            <!-- Hidden fields untuk submit final -->
            <input type="hidden" name="nama_pemesan" id="hidden_nama_pemesan">
            <input type="hidden" name="nomer_wa" id="hidden_nomer_wa">
            <input type="hidden" name="email" id="hidden_email">
            <input type="hidden" name="venue" id="hidden_venue">
            <input type="hidden" name="jenis_acara" id="hidden_jenis_acara">
            <input type="hidden" name="tanggal_acara" id="hidden_tanggal_acara">
            <input type="hidden" name="hari_acara" id="hidden_hari_acara">
            <input type="hidden" name="tahun_acara" id="hidden_tahun_acara">
            <input type="hidden" name="jam_acara" id="hidden_jam_acara">
            <input type="hidden" name="durasi_type" id="hidden_durasi_type">
            <input type="hidden" name="durasi_jam" id="hidden_durasi_jam">
            <input type="hidden" name="durasi_hari" id="hidden_durasi_hari">
            <input type="hidden" name="durasi_minggu" id="hidden_durasi_minggu">
            <input type="hidden" name="durasi_bulan" id="hidden_durasi_bulan">
            <input type="hidden" name="tanggal_mulai" id="hidden_tanggal_mulai">
            <input type="hidden" name="tanggal_selesai" id="hidden_tanggal_selesai">
            <input type="hidden" name="jam_mulai" id="hidden_jam_mulai">
            <input type="hidden" name="jam_selesai" id="hidden_jam_selesai">
            <input type="hidden" name="perkiraan_peserta" id="hidden_perkiraan_peserta">

            <div class="screen" id="form-screen">
                <h1>Booking Venue</h1>

                <!-- Success Message -->
                @if (session('success'))
                    <div class="success-message">
                        <div class="success-icon">✅</div>
                        <h2>Booking Berhasil!</h2>
                        <p>{{ session('success') }}</p>
                        <button type="button" class="btn-home" onclick="resetBooking()">Kembali ke Awal</button>
                    </div>
                @else
                    <div class="step-indicator">
                        <div class="step-progress" id="step-progress"></div>
                        @for ($i = 1; $i <= 9; $i++)
                            <div class="step" id="step-dot-{{ $i }}">{{ $i }}</div>
                        @endfor
                    </div>

                    <h3 id="step-title">Step {{ $currentStep ?? 1 }} –
                        @php
                            $titles = [
                                1 => 'Nama Pemesan',
                                2 => 'Nomor WhatsApp',
                                3 => 'Email',
                                4 => 'Pilihan Venue',
                                5 => 'Jenis Acara',
                                6 => 'Waktu Acara',
                                7 => 'Durasi Acara',
                                8 => 'Perkiraan Peserta',
                                9 => 'Konfirmasi',
                            ];
                        @endphp
                        {{ $titles[$currentStep ?? 1] ?? '' }}
                    </h3>

                    <div id="step-1">@include('venue.partials.step-1-nama-pemesan')</div>
                    <div id="step-2">@include('venue.partials.step-2-nomer-wa')</div>
                    <div id="step-3">@include('venue.partials.step-3-email')</div>
                    <div id="step-4">@include('venue.partials.step-4-pilihan-venue')</div>
                    <div id="step-5">@include('venue.partials.step-5-jenis-acara')</div>
                    <div id="step-6">@include('venue.partials.step-6-waktu-acara')</div>
                    <div id="step-7">@include('venue.partials.step-7-durasi-acara')</div>
                    <div id="step-8">@include('venue.partials.step-8-perkiraan-peserta')</div>
                    <div id="step-9">@include('venue.partials.step-9-konfirmasi')</div>

                @endif
            </div>
        </form>
    </div>

    <script>
        // ===============================
        // GLOBAL VARIABLES
        // ===============================
        let currentStep = {{ $currentStep ?? 1 }};
        const totalSteps = 9;

        // Object untuk menyimpan data sementara
        let bookingData = {
            nama_pemesan: '',
            nomer_wa: '',
            email: '',
            venue: '',
            jenis_acara: '',
            tanggal_acara: '',
            hari_acara: '',
            tahun_acara: '',
            jam_acara: '',
            durasi_type: '',
            durasi_jam: '',
            durasi_hari: '',
            durasi_minggu: '',
            durasi_bulan: '',
            tanggal_mulai: '',
            tanggal_selesai: '',
            jam_mulai: '',
            jam_selesai: '',
            perkiraan_peserta: ''
        };

        // ===============================
        // FORM NAVIGATION FUNCTIONS (CLIENT-SIDE)
        // ===============================
        function startBooking() {
            // Sembunyikan intro screen dengan animasi
            const introScreen = document.getElementById('intro');
            introScreen.style.opacity = '0';
            introScreen.style.transform = 'translateY(20px)';
            introScreen.style.transition = 'opacity 0.5s ease, transform 0.5s ease';

            setTimeout(() => {
                introScreen.style.display = 'none';

                // Tampilkan form screen
                const formScreen = document.getElementById('form-screen');
                formScreen.style.display = 'block';
                formScreen.style.opacity = '0';
                formScreen.style.transform = 'translateY(20px)';

                // Trigger reflow
                formScreen.offsetHeight;

                // Animate in
                setTimeout(() => {
                    formScreen.style.opacity = '1';
                    formScreen.style.transform = 'translateY(0)';
                    formScreen.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                }, 50);

                // Tampilkan step 1
                showStep(1);

            }, 500);
        }

        function showStep(step) {
            // Simpan data step sebelumnya
            collectCurrentStepData();

            // Sembunyikan semua step dengan animasi
            for (let i = 1; i <= totalSteps; i++) {
                const stepElement = document.getElementById('step-' + i);
                if (stepElement) {
                    if (stepElement.style.display !== 'none') {
                        stepElement.style.opacity = '0';
                        stepElement.style.transform = 'translateY(10px)';
                        stepElement.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

                        setTimeout(() => {
                            stepElement.style.display = 'none';
                        }, 300);
                    }
                }

                // Update step indicator
                const stepDot = document.getElementById('step-dot-' + i);
                if (stepDot) {
                    stepDot.classList.remove('active');
                }
            }

            // Tampilkan step yang aktif dengan animasi
            setTimeout(() => {
                const currentStepElement = document.getElementById('step-' + step);
                if (currentStepElement) {
                    currentStepElement.style.display = 'block';
                    currentStepElement.style.opacity = '0';
                    currentStepElement.style.transform = 'translateY(10px)';

                    // Trigger reflow
                    currentStepElement.offsetHeight;

                    // Animate in
                    setTimeout(() => {
                        currentStepElement.style.opacity = '1';
                        currentStepElement.style.transform = 'translateY(0)';
                        currentStepElement.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                    }, 50);
                }

                // Aktifkan step dot
                const currentStepDot = document.getElementById('step-dot-' + step);
                if (currentStepDot) {
                    setTimeout(() => {
                        currentStepDot.classList.add('active');
                    }, 300);
                }

                // Update judul step
                updateStepTitle(step);

                // Update progress bar
                updateProgressBar(step);

                // Update current step
                currentStep = step;

                // Update hidden input untuk step (untuk session)
                const stepInput = document.getElementById('stepInput');
                if (stepInput) {
                    stepInput.value = step;
                }

            }, 300);
        }

        function updateStepTitle(step) {
            const titles = [
                '', 'Nama Pemesan', 'Nomor WhatsApp', 'Email',
                'Pilihan Venue', 'Jenis Acara', 'Waktu Acara',
                'Durasi Acara', 'Perkiraan Peserta', 'Konfirmasi'
            ];

            const stepTitleElement = document.getElementById('step-title');
            if (stepTitleElement && titles[step]) {
                stepTitleElement.innerText = `Step ${step} – ${titles[step]}`;
            }
        }

        function updateProgressBar(step) {
            const progress = ((step - 1) / (totalSteps - 1)) * 100;
            const stepProgressElement = document.getElementById('step-progress');
            if (stepProgressElement) {
                stepProgressElement.style.width = progress + '%';
            }
        }

        // ===============================
        // VALIDATION FUNCTIONS
        // ===============================
        function showError(inputId, message) {
            const input = document.getElementById(inputId);
            const errorDiv = document.getElementById(inputId + '_error');

            if (input) {
                input.classList.add('input-error');
            }

            if (errorDiv) {
                errorDiv.textContent = message;
                errorDiv.style.display = 'block';
            }
        }

        function hideError(inputId) {
            const input = document.getElementById(inputId);
            const errorDiv = document.getElementById(inputId + '_error');

            if (input) {
                input.classList.remove('input-error');
            }

            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        }

        function validateStep(step) {
            let isValid = true;

            // Reset semua error terlebih dahulu
            document.querySelectorAll('.error-message').forEach(el => {
                el.style.display = 'none';
            });
            document.querySelectorAll('.form-group').forEach(el => {
                el.classList.remove('error');
            });
            document.querySelectorAll('.input-error').forEach(el => {
                el.classList.remove('input-error');
            });

            switch (step) {
                case 1:
                    const nama = document.getElementById('nama_pemesan');
                    if (!nama?.value.trim()) {
                        showError('nama_pemesan', 'Nama pemesan wajib diisi');
                        isValid = false;
                    } else if (nama.value.trim().length < 3) {
                        showError('nama_pemesan', 'Nama pemesan minimal 3 karakter');
                        isValid = false;
                    }
                    break;

                case 2:
                    const wa = document.getElementById('nomer_wa');
                    const waRegex = /^08[0-9]{9,12}$/;
                    if (!wa?.value.trim()) {
                        showError('nomer_wa', 'Nomor WhatsApp wajib diisi');
                        isValid = false;
                    } else if (!waRegex.test(wa.value.trim())) {
                        showError('nomer_wa', 'Nomor WhatsApp harus diawali 08 dan 11-14 digit');
                        isValid = false;
                    }
                    break;

                case 3:
                    const email = document.getElementById('email');
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!email?.value.trim()) {
                        showError('email', 'Email wajib diisi');
                        isValid = false;
                    } else if (!emailRegex.test(email.value.trim())) {
                        showError('email', 'Email tidak valid');
                        isValid = false;
                    }
                    break;

                case 4:
                    const venue = document.getElementById('venue');
                    if (!venue?.value) {
                        showError('venue', 'Pilih venue terlebih dahulu');
                        isValid = false;
                    }
                    break;

                case 5:
                    const jenisAcara = document.getElementById('jenis_acara');
                    if (!jenisAcara?.value.trim()) {
                        showError('jenis_acara', 'Jenis acara wajib diisi');
                        isValid = false;
                    } else if (jenisAcara.value.trim().length < 3) {
                        showError('jenis_acara', 'Jenis acara minimal 3 karakter');
                        isValid = false;
                    }
                    break;

                case 6:
                    const tanggal = document.getElementById('tanggal_acara');
                    const jam = document.getElementById('jam_acara');

                    if (!tanggal?.value) {
                        showError('tanggal_acara', 'Tanggal acara wajib diisi');
                        isValid = false;
                    } else if (new Date(tanggal.value) < new Date().setHours(0, 0, 0, 0)) {
                        showError('tanggal_acara', 'Tanggal tidak boleh di masa lalu');
                        isValid = false;
                    }

                    if (!jam?.value) {
                        showError('jam_acara', 'Jam acara wajib diisi');
                        isValid = false;
                    }
                    break;

                case 7:
                    const durasiType = document.getElementById('durasi_type');
                    if (!durasiType?.value) {
                        showError('durasi_type', 'Pilih tipe durasi terlebih dahulu');
                        isValid = false;
                    } else {
                        if (durasiType.value === 'jam') {
                            const jamMulai = document.getElementById('jam_mulai');
                            const jamSelesai = document.getElementById('jam_selesai');

                            if (!jamMulai?.value) {
                                showError('jam_mulai', 'Jam mulai wajib diisi');
                                isValid = false;
                            }
                            if (!jamSelesai?.value) {
                                showError('jam_selesai', 'Jam selesai wajib diisi');
                                isValid = false;
                            }
                            if (jamMulai?.value && jamSelesai?.value && jamMulai.value >= jamSelesai.value) {
                                showError('jam_selesai', 'Jam selesai harus setelah jam mulai');
                                isValid = false;
                            }
                        } else if (durasiType.value === 'hari') {
                            const tglMulai = document.getElementById('tanggal_mulai_hari');
                            const tglSelesai = document.getElementById('tanggal_selesai_hari');

                            if (!tglMulai?.value) {
                                showError('tanggal_mulai_hari', 'Tanggal mulai wajib diisi');
                                isValid = false;
                            }
                            if (!tglSelesai?.value) {
                                showError('tanggal_selesai_hari', 'Tanggal selesai wajib diisi');
                                isValid = false;
                            }
                            if (tglMulai?.value && tglSelesai?.value) {
                                const start = new Date(tglMulai.value);
                                const end = new Date(tglSelesai.value);
                                if (start >= end) {
                                    showError('tanggal_selesai_hari', 'Tanggal selesai harus setelah tanggal mulai');
                                    isValid = false;
                                }
                                const diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
                                if (diffDays > 7) {
                                    showError('tanggal_selesai_hari', 'Maksimal durasi adalah 7 hari');
                                    isValid = false;
                                }
                            }
                        } else if (durasiType.value === 'minggu') {
                            const minggu = document.getElementById('durasi_minggu');
                            if (!minggu?.value || minggu.value < 1 || minggu.value > 4) {
                                showError('durasi_minggu', 'Durasi minggu harus 1-4 minggu (maksimal 1 bulan)');
                                isValid = false;
                            }
                        } else if (durasiType.value === 'bulan') {
                            const bulan = document.getElementById('durasi_bulan');
                            if (!bulan?.value || bulan.value < 1 || bulan.value > 12) {
                                showError('durasi_bulan', 'Durasi bulan harus 1-12 bulan (maksimal 1 tahun)');
                                isValid = false;
                            }
                        }
                    }
                    break;

                case 8:
                    const peserta = document.getElementById('perkiraan_peserta');
                    if (!peserta?.value) {
                        showError('perkiraan_peserta', 'Jumlah peserta wajib diisi');
                        isValid = false;
                    } else if (peserta.value < 1 || peserta.value > 10000) {
                        showError('perkiraan_peserta', 'Jumlah peserta antara 1-10000');
                        isValid = false;
                    }
                    break;
            }

            return isValid;
        }

        // ===============================
        // HELPER FUNCTIONS
        // ===============================
        function collectCurrentStepData() {
            switch (currentStep) {
                case 1:
                    bookingData.nama_pemesan = document.getElementById('nama_pemesan')?.value || '';
                    break;
                case 2:
                    bookingData.nomer_wa = document.getElementById('nomer_wa')?.value || '';
                    break;
                case 3:
                    bookingData.email = document.getElementById('email')?.value || '';
                    break;
                case 4:
                    bookingData.venue = document.getElementById('venue')?.value || '';
                    break;
                case 5:
                    bookingData.jenis_acara = document.getElementById('jenis_acara')?.value || '';
                    break;
                case 6:
                    bookingData.tanggal_acara = document.getElementById('tanggal_acara')?.value || '';
                    if (bookingData.tanggal_acara) {
                        const date = new Date(bookingData.tanggal_acara);
                        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                        bookingData.hari_acara = days[date.getDay()];
                        bookingData.tahun_acara = date.getFullYear();
                    }
                    bookingData.jam_acara = document.getElementById('jam_acara')?.value || '';
                    break;
                case 7:
                    bookingData.durasi_type = document.getElementById('durasi_type')?.value || '';

                    if (bookingData.durasi_type === 'jam') {
                        bookingData.jam_mulai = document.getElementById('jam_mulai')?.value || '';
                        bookingData.jam_selesai = document.getElementById('jam_selesai')?.value || '';
                        if (bookingData.jam_mulai && bookingData.jam_selesai) {
                            const start = new Date('1970-01-01T' + bookingData.jam_mulai);
                            const end = new Date('1970-01-01T' + bookingData.jam_selesai);
                            const diffHours = (end - start) / (1000 * 60 * 60);
                            bookingData.durasi_jam = diffHours;
                        }
                    } else if (bookingData.durasi_type === 'hari') {
                        bookingData.tanggal_mulai = document.getElementById('tanggal_mulai_hari')?.value || '';
                        bookingData.tanggal_selesai = document.getElementById('tanggal_selesai_hari')?.value || '';
                        if (bookingData.tanggal_mulai && bookingData.tanggal_selesai) {
                            const start = new Date(bookingData.tanggal_mulai);
                            const end = new Date(bookingData.tanggal_selesai);
                            const diffDays = Math.ceil((end - start) / (1000 * 60 * 60 * 24)) + 1;
                            bookingData.durasi_hari = diffDays;
                        }
                    } else if (bookingData.durasi_type === 'minggu') {
                        bookingData.durasi_minggu = document.getElementById('durasi_minggu')?.value || '';
                    } else if (bookingData.durasi_type === 'bulan') {
                        bookingData.durasi_bulan = document.getElementById('durasi_bulan')?.value || '';
                    }
                    break;
                case 8:
                    bookingData.perkiraan_peserta = document.getElementById('perkiraan_peserta')?.value || '';
                    break;
            }

            // Update hidden fields untuk session
            updateHiddenFields();
        }

        function updateHiddenFields() {
            document.getElementById('hidden_nama_pemesan').value = bookingData.nama_pemesan;
            document.getElementById('hidden_nomer_wa').value = bookingData.nomer_wa;
            document.getElementById('hidden_email').value = bookingData.email;
            document.getElementById('hidden_venue').value = bookingData.venue;
            document.getElementById('hidden_jenis_acara').value = bookingData.jenis_acara;
            document.getElementById('hidden_tanggal_acara').value = bookingData.tanggal_acara;
            document.getElementById('hidden_hari_acara').value = bookingData.hari_acara;
            document.getElementById('hidden_tahun_acara').value = bookingData.tahun_acara;
            document.getElementById('hidden_jam_acara').value = bookingData.jam_acara;
            document.getElementById('hidden_durasi_type').value = bookingData.durasi_type;
            document.getElementById('hidden_durasi_jam').value = bookingData.durasi_jam;
            document.getElementById('hidden_durasi_hari').value = bookingData.durasi_hari;
            document.getElementById('hidden_durasi_minggu').value = bookingData.durasi_minggu;
            document.getElementById('hidden_durasi_bulan').value = bookingData.durasi_bulan;
            document.getElementById('hidden_tanggal_mulai').value = bookingData.tanggal_mulai;
            document.getElementById('hidden_tanggal_selesai').value = bookingData.tanggal_selesai;
            document.getElementById('hidden_jam_mulai').value = bookingData.jam_mulai;
            document.getElementById('hidden_jam_selesai').value = bookingData.jam_selesai;
            document.getElementById('hidden_perkiraan_peserta').value = bookingData.perkiraan_peserta;
        }

        function collectDataForConfirmation() {
            collectCurrentStepData();
            updateConfirmationDisplay();
        }

        function updateConfirmationDisplay() {
            // Format waktu acara
            let waktuAcaraDisplay = '-';
            if (bookingData.tanggal_acara && bookingData.hari_acara && bookingData.jam_acara) {
                const date = new Date(bookingData.tanggal_acara);
                const formattedDate = date.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                });
                const formattedTime = bookingData.jam_acara.substring(0, 5);
                waktuAcaraDisplay = `${bookingData.hari_acara}, ${formattedDate}, ${formattedTime}`;
            }

            // Format durasi
            let durasiDisplay = '-';
            if (bookingData.durasi_type) {
                switch (bookingData.durasi_type) {
                    case 'jam':
                        if (bookingData.durasi_jam) {
                            durasiDisplay = `${bookingData.durasi_jam} jam`;
                            if (bookingData.jam_mulai && bookingData.jam_selesai) {
                                durasiDisplay +=
                                    ` (${bookingData.jam_mulai.substring(0,5)} - ${bookingData.jam_selesai.substring(0,5)})`;
                            }
                        }
                        break;
                    case 'hari':
                        if (bookingData.durasi_hari) {
                            durasiDisplay = `${bookingData.durasi_hari} hari`;
                            if (bookingData.tanggal_mulai && bookingData.tanggal_selesai) {
                                const startDate = formatDateShort(bookingData.tanggal_mulai);
                                const endDate = formatDateShort(bookingData.tanggal_selesai);
                                durasiDisplay += ` (${startDate} - ${endDate})`;
                            }
                        }
                        break;
                    case 'minggu':
                        if (bookingData.durasi_minggu) {
                            durasiDisplay = `${bookingData.durasi_minggu} minggu`;
                        }
                        break;
                    case 'bulan':
                        if (bookingData.durasi_bulan) {
                            durasiDisplay = `${bookingData.durasi_bulan} bulan`;
                        }
                        break;
                }
            }

            // Update semua data di tampilan konfirmasi
            const elements = {
                'confirm-nama': bookingData.nama_pemesan || '-',
                'confirm-wa': bookingData.nomer_wa || '-',
                'confirm-email': bookingData.email || '-',
                'confirm-venue': bookingData.venue || '-',
                'confirm-jenis-acara': bookingData.jenis_acara || '-',
                'confirm-waktu-acara': waktuAcaraDisplay,
                'confirm-durasi': durasiDisplay,
                'confirm-peserta': bookingData.perkiraan_peserta ? bookingData.perkiraan_peserta + ' orang' : '-'
            };

            Object.entries(elements).forEach(([id, value]) => {
                const element = document.getElementById(id);
                if (element) {
                    element.textContent = value;
                }
            });
        }

        function formatDateShort(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short'
            });
        }

        function editStep(step) {
            showStep(step);
        }

        function resetBooking() {
            window.location.href = "{{ route('venue.index') }}";
        }

        function submitFinal() {
            // Kumpulkan semua data terlebih dahulu
            collectDataForConfirmation();
            updateHiddenFields();

            // Submit form untuk step 9 (konfirmasi)
            document.getElementById('stepInput').value = 9;
            document.getElementById('booking-form').submit();
        }

        function showDurasiFields() {
            const durasiType = document.getElementById('durasi_type')?.value;

            // Sembunyikan semua field durasi
            document.querySelectorAll('.durasi-fields').forEach(field => {
                field.style.display = 'none';
            });

            // Tampilkan field yang sesuai
            if (durasiType) {
                const field = document.getElementById(`durasi-${durasiType}-fields`);
                if (field) {
                    field.style.display = 'block';
                }
            }
        }

        function updateHariTahun() {
            const tanggalInput = document.getElementById('tanggal_acara');
            const hariInput = document.getElementById('hari_acara');
            const tahunInput = document.getElementById('tahun_acara');

            if (tanggalInput.value) {
                const date = new Date(tanggalInput.value);
                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const dayName = days[date.getDay()];

                hariInput.value = dayName;
                tahunInput.value = date.getFullYear();
            } else {
                hariInput.value = '';
                tahunInput.value = '';
            }
        }

        // ===============================
        // EVENT LISTENERS (CLIENT-SIDE NAVIGATION)
        // ===============================
        document.addEventListener('click', function(e) {
            // Next button
            if (e.target.classList.contains('btn-next')) {
                if (validateStep(currentStep)) {
                    if (currentStep < totalSteps) {
                        const nextStep = currentStep + 1;
                        if (nextStep === 9) {
                            collectDataForConfirmation();
                        }
                        showStep(nextStep);
                    }
                }
                e.preventDefault();
            }

            // Previous button
            if (e.target.classList.contains('btn-back')) {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
                }
                e.preventDefault();
            }

            // Submit button (hanya di step 9)
            if (e.target.classList.contains('btn-submit')) {
                submitFinal();
                e.preventDefault();
            }

            // Edit link di konfirmasi
            if (e.target.classList.contains('edit-link')) {
                const step = parseInt(e.target.getAttribute('data-step') || e.target.parentElement.getAttribute(
                    'data-step'));
                if (step) {
                    editStep(step);
                }
                e.preventDefault();
            }
        });

        // ===============================
        // INITIALIZATION
        // ===============================
        document.addEventListener('DOMContentLoaded', function() {
            @if (!session('success'))
                // Jika bukan halaman success, tampilkan step yang sesuai
                if (document.getElementById('form-screen').classList.contains('active')) {
                    showStep(currentStep);
                }
            @endif

            // Isi form dengan data dari session jika ada
            @if (isset($formData))
                @foreach ($formData as $key => $value)
                    @if (!in_array($key, ['step', '_token', 'duration_value']))
                        const {{ $key }}Input = document.getElementById('{{ $key }}');
                        if ({{ $key }}Input && "{{ $value }}" !== "") {
                            {{ $key }}Input.value = "{{ old($key, $value) }}";
                            bookingData.{{ $key }} = "{{ $value }}";
                        }
                    @endif
                @endforeach

                // Update hidden fields
                updateHiddenFields();

                // Update tampilan konfirmasi jika di step 9
                if (currentStep === 9) {
                    updateConfirmationDisplay();
                }
            @endif

            // Set up date validation
            const tanggalAcaraInput = document.getElementById('tanggal_acara');
            if (tanggalAcaraInput) {
                const today = new Date();
                tanggalAcaraInput.min = today.toISOString().split('T')[0];

                // Tambahkan event listener untuk update hari dan tahun
                tanggalAcaraInput.addEventListener('change', function() {
                    updateHariTahun();
                });
            }

            // Set up durasi fields toggle
            const durasiTypeSelect = document.getElementById('durasi_type');
            if (durasiTypeSelect) {
                durasiTypeSelect.addEventListener('change', function() {
                    showDurasiFields();
                });
                // Inisialisasi tampilan awal
                showDurasiFields();
            }

            // Set up date range validation for hari durasi
            const tanggalMulaiHari = document.getElementById('tanggal_mulai_hari');
            const tanggalSelesaiHari = document.getElementById('tanggal_selesai_hari');

            if (tanggalMulaiHari && tanggalSelesaiHari) {
                tanggalMulaiHari.addEventListener('change', function() {
                    if (this.value) {
                        const minDate = new Date(this.value);
                        minDate.setDate(minDate.getDate() + 1);
                        tanggalSelesaiHari.min = minDate.toISOString().split('T')[0];

                        if (tanggalSelesaiHari.value && new Date(tanggalSelesaiHari.value) <= new Date(this
                                .value)) {
                            tanggalSelesaiHari.value = minDate.toISOString().split('T')[0];
                        }
                    }
                });
            }
        });
    </script>

</body>

</html>
