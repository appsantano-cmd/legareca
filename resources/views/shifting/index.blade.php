<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="theme-color" content="#6b3a1e">
    <meta name="format-detection" content="telephone=no">
    <title>Pengajuan Tukar Shift</title>

    <style>
        /* ===============================
           VARIABLES
        =============================== */
        :root {
            --primary-color: #6b3a1e;
            --secondary-color: #8a5c3a;
            --light-brown: #f5f1ee;
            --text-dark: #333;
            --text-light: #666;
            --border-color: #ddd;
            --error-color: #dc3545;
            --success-color: #28a745;
            --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
            --transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            --border-radius: 16px;
        }

        /* ===============================
           RESET & BASE STYLES
        =============================== */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* ===============================
           SAFE AREA SUPPORT (iOS)
        =============================== */
        body {
            padding-left: env(safe-area-inset-left);
            padding-right: env(safe-area-inset-right);
            padding-top: env(safe-area-inset-top);
            padding-bottom: env(safe-area-inset-bottom);
        }

        /* ===============================
           MOBILE TOUCH OPTIMIZATION
        =============================== */
        button, input, textarea {
            -webkit-tap-highlight-color: transparent;
        }

        input, textarea {
            font-size: 16px; /* Mencegah auto zoom di iOS */
        }

        /* ===============================
           BODY & CONTAINER
        =============================== */
        body {
            margin: 0;
            background: linear-gradient(135deg, #6b3a1e 0%, #8a5c3a 100%);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .container {
            width: 100%;
            max-width: 500px;
            perspective: 1000px;
        }

        /* ===============================
           CARD STYLES
        =============================== */
        .card {
            background: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: var(--transition);
            transform-style: preserve-3d;
        }

        /* ===============================
           ANIMATIONS
        =============================== */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(107, 58, 30, 0.1);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(107, 58, 30, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(107, 58, 30, 0);
            }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
                max-height: 0;
            }
            to {
                opacity: 1;
                transform: translateY(0);
                max-height: 300px;
            }
        }

        @keyframes errorShake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        /* ===============================
           TYPOGRAPHY
        =============================== */
        h2, h3 {
            color: var(--primary-color);
            margin-top: 0;
        }

        h2.title {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
        }

        h3 {
            font-size: 18px;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--light-brown);
        }

        .subtitle {
            color: var(--text-light);
            margin-bottom: 15px;
            font-size: 14px;
            line-height: 1.5;
        }

        /* ===============================
           FORM ELEMENTS
        =============================== */
        .form-group {
            margin-bottom: 25px;
            animation: fadeIn 0.5s ease forwards;
            opacity: 0;
            transform: translateY(10px);
        }

        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        .form-group:nth-child(5) { animation-delay: 0.5s; }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 14px;
        }

        input, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: var(--transition);
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(107, 58, 30, 0.1);
            transform: translateY(-2px);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-row input {
            flex: 1;
        }

        .radio-group {
            display: flex;
            gap: 20px;
            margin: 20px 0;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 10px 15px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: var(--transition);
        }

        .radio-item:hover {
            border-color: var(--primary-color);
            background-color: var(--light-brown);
            transform: translateY(-2px);
        }

        .radio-item input[type="radio"] {
            width: auto;
            margin: 0;
        }

        /* ===============================
           STEP INDICATOR
        =============================== */
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            position: relative;
        }

        .step-indicator::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 2px;
            background-color: var(--border-color);
            z-index: 1;
            transform: translateY(-50%);
        }

        .step-indicator .step {
            position: relative;
            z-index: 2;
            background: white;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            color: var(--text-light);
            border: 2px solid var(--border-color);
            transition: var(--transition);
        }

        .step-indicator .step.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(107, 58, 30, 0.2);
        }

        .step-indicator .step.completed {
            background-color: var(--success-color);
            color: white;
            border-color: var(--success-color);
            transform: scale(1.05);
        }

        /* ===============================
           BUTTONS
        =============================== */
        .btn-start, .btn-next, .btn-submit {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            width: 100%;
            margin-top: 10px;
            position: relative;
            overflow: hidden;
        }

        .btn-start:hover, .btn-next:hover, .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(107, 58, 30, 0.3);
        }

        .btn-prev {
            background: #f8f9fa;
            color: var(--text-dark);
            padding: 12px 30px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: var(--transition);
            width: 100%;
            margin-top: 10px;
        }

        .btn-prev:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .nav-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .nav-buttons button {
            flex: 1;
        }

        /* ===============================
           LAYOUT UTILITIES
        =============================== */
        .center {
            text-align: center;
        }

        /* ===============================
           SPECIFIC COMPONENTS
        =============================== */
        #penggantiFields {
            margin-top: 20px;
            padding: 20px;
            background-color: var(--light-brown);
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--success-color);
            animation: fadeIn 0.5s ease;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid var(--error-color);
            animation: shake 0.5s ease;
        }

        .summary-card {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid var(--primary-color);
            animation: pulse 2s infinite;
        }

        .summary-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            transition: var(--transition);
        }

        .summary-item:hover {
            transform: translateX(5px);
            border-bottom-color: var(--primary-color);
        }

        .summary-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .summary-item strong {
            display: block;
            color: #333;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .summary-item span {
            color: #666;
            display: block;
            word-break: break-word;
            line-height: 1.5;
        }

        .info-box {
            background-color: #e7f3ff;
            border-left: 4px solid #007bff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 14px;
            animation: fadeIn 0.5s ease;
        }

        .info-box p {
            margin: 0;
            color: #0056b3;
        }

        .input-error {
            border-color: var(--error-color) !important;
            animation: errorShake 0.5s ease;
        }

        .error-text {
            color: var(--error-color);
            font-size: 12px;
            margin-top: 5px;
            display: none;
            animation: fadeIn 0.3s ease;
        }

        /* ===============================
           LOGO
        =============================== */
        .logo-wrapper {
            text-align: center;
            margin-bottom: 20px;
            animation: fadeIn 0.8s ease;
        }

        .logo-img {
            max-width: 140px;
            width: 100%;
            height: auto;
            transition: var(--transition);
        }

        .logo-img:hover {
            transform: scale(1.05);
        }

        /* ===============================
           STEP CONTENT
        =============================== */
        .step-content {
            display: none;
            animation: fadeIn 0.4s ease forwards;
        }

        .step-content.active {
            display: block;
        }

        /* ===============================
           RESPONSIVE DESIGN
        =============================== */
        @media (max-width: 480px) {
            .card {
                padding: 20px;
                border-radius: 12px;
            }
            
            .form-row {
                flex-direction: column;
                gap: 10px;
            }
            
            .radio-group {
                flex-direction: column;
                gap: 10px;
            }
            
            .step-indicator .step {
                width: 30px;
                height: 30px;
                font-size: 12px;
            }
            
            h2.title {
                font-size: 20px;
            }
        }

        @media (max-width: 360px) {
            .card {
                padding: 16px;
                border-radius: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <!-- LOGO HEADER -->
            <div class="logo-wrapper">
                <img src="/logo.png" alt="Logo Perusahaan" class="logo-img">
            </div>
            
            {{-- ================= START SCREEN ================= --}}
            <div id="start-screen" class="center">
                <h2>Pengajuan Tukar Shift</h2><br>
                
                <div class="info-box">
                    <p>
                        <strong>Ketentuan Pengajuan:</strong><br>
                        1. Harus diajukan minimal 1 hari sebelum shift<br>
                        2. Harus mendapat persetujuan manager<br>
                        3. Pastikan sudah ada pengganti atau koordinasi dengan tim<br>
                    </p>
                </div>

                <button type="button" class="btn-start" onclick="startForm()">
                    Mulai Pengajuan
                </button>
            </div>

            {{-- ================= FLASH MESSAGES ================= --}}
            @if(session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif

            @if($errors->any())
                <div class="error-message">
                    <ul style="margin-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ================= FORM SCREEN ================= --}}
            <div id="form-screen" style="display:none">
                {{-- STEP INDICATOR --}}
                <div class="step-indicator" id="stepIndicator">
                    <div class="step active" data-step="1">1</div>
                    <div class="step" data-step="2">2</div>
                    <div class="step" data-step="3">3</div>
                    <div class="step" data-step="4">4</div>
                    <div class="step" data-step="5">5</div>
                </div>

                <form method="POST" action="{{ route('shifting.submit') }}" id="shiftingForm">
                    @csrf

                    {{-- STEP 1 --}}
                    @include('shifting.partials.step_1_nama')

                    {{-- STEP 2 --}}
                    @include('shifting.partials.step_2_divisi')

                    {{-- STEP 3 --}}
                    @include('shifting.partials.step_3_tanggal')

                    {{-- STEP 4 --}}
                    @include('shifting.partials.step_4_alasan')

                    {{-- STEP 5 --}}
                    @include('shifting.partials.step_5_konfirmasi')
                </form>
            </div>
        </div>
    </div>

    <script>
        // ===============================
        // GLOBAL VARIABLES
        // ===============================
        let currentStep = 1;
        const steps = document.querySelectorAll('.step-content[data-step]');

        // ===============================
        // FORM NAVIGATION FUNCTIONS
        // ===============================
        function startForm() {
            currentStep = 1;
            document.getElementById('start-screen').style.display = 'none';
            document.getElementById('form-screen').style.display = 'block';
            showStep(currentStep);
        }

        function showStep(step) {
            // Hide current step with fade out
            const currentStepContent = document.querySelector('.step-content[data-step="' + currentStep + '"]');
            
            if (currentStepContent) {
                currentStepContent.style.opacity = '0';
                currentStepContent.style.transform = 'translateY(10px)';
                
                setTimeout(() => {
                    currentStepContent.classList.remove('active');
                    currentStepContent.style.display = 'none';
                    
                    // Show new step
                    const targetStep = document.querySelector('.step-content[data-step="' + step + '"]');
                    if (targetStep) {
                        targetStep.style.display = 'block';
                        targetStep.style.opacity = '0';
                        targetStep.style.transform = 'translateY(10px)';
                        
                        // Trigger reflow
                        targetStep.offsetHeight;
                        
                        targetStep.classList.add('active');
                        
                        // Fade in
                        setTimeout(() => {
                            targetStep.style.opacity = '1';
                            targetStep.style.transform = 'translateY(0)';
                            targetStep.style.transition = 'opacity 0.4s ease, transform 0.4s ease';
                        }, 50);
                    }
                    
                    // Update step indicator
                    updateStepIndicator(step);
                    
                }, 300);
            }
            
            currentStep = step;
        }

        function updateStepIndicator(currentStep) {
            const steps = document.querySelectorAll('.step-indicator .step');
            steps.forEach((stepEl) => {
                stepEl.classList.remove('active', 'completed');
                const stepNumber = parseInt(stepEl.getAttribute('data-step'));
                
                if (stepNumber < currentStep) {
                    stepEl.classList.add('completed');
                } else if (stepNumber === currentStep) {
                    setTimeout(() => {
                        stepEl.classList.add('active');
                    }, 300);
                }
            });
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
            document.querySelectorAll('.error-text').forEach(el => {
                el.style.display = 'none';
            });
            document.querySelectorAll('.input-error').forEach(el => {
                el.classList.remove('input-error');
            });
            
            switch(step) {
                case 1:
                    const nama = document.getElementById('nama_karyawan');
                    if (!nama.value.trim()) {
                        showError('nama_karyawan', 'Nama karyawan wajib diisi');
                        isValid = false;
                    }
                    break;
                    
                case 2:
                    const divisi = document.getElementById('divisi_jabatan');
                    if (!divisi.value.trim()) {
                        showError('divisi_jabatan', 'Divisi/jabatan wajib diisi');
                        isValid = false;
                    }
                    break;
                    
                case 3:
                    const tanggalAsli = document.getElementById('tanggal_shift_asli');
                    const jamAsli = document.getElementById('jam_shift_asli');
                    const tanggalTujuan = document.getElementById('tanggal_shift_tujuan');
                    const jamTujuan = document.getElementById('jam_shift_tujuan');
                    
                    if (!tanggalAsli.value) {
                        showError('tanggal_shift_asli', 'Tanggal shift asli wajib diisi');
                        isValid = false;
                    }
                    if (!jamAsli.value) {
                        showError('jam_shift_asli', 'Jam shift asli wajib diisi');
                        isValid = false;
                    }
                    if (!tanggalTujuan.value) {
                        showError('tanggal_shift_tujuan', 'Tanggal shift tujuan wajib diisi');
                        isValid = false;
                    }
                    if (!jamTujuan.value) {
                        showError('jam_shift_tujuan', 'Jam shift tujuan wajib diisi');
                        isValid = false;
                    }
                    
                    // Additional date validations
                    if (tanggalAsli.value && tanggalTujuan.value) {
                        const today = new Date();
                        today.setHours(0, 0, 0, 0);
                        const shiftAsliDate = new Date(tanggalAsli.value);
                        
                        if (shiftAsliDate <= today) {
                            showError('tanggal_shift_asli', 'Tanggal shift asli harus minimal 1 hari dari sekarang');
                            isValid = false;
                        }
                        
                        const tujuanDate = new Date(tanggalTujuan.value);
                        if (tujuanDate <= shiftAsliDate) {
                            showError('tanggal_shift_tujuan', 'Tanggal shift tujuan harus setelah tanggal shift asli');
                            isValid = false;
                        }
                    }
                    break;
                    
                case 4:
                    const alasan = document.getElementById('alasan');
                    if (!alasan.value.trim()) {
                        showError('alasan', 'Alasan pengajuan wajib diisi');
                        isValid = false;
                    } else if (alasan.value.trim().length < 10) {
                        showError('alasan', 'Alasan pengajuan minimal 10 karakter');
                        isValid = false;
                    }
                    break;
                    
                case 5:
                    const radioButtons = document.querySelectorAll('input[name="sudah_pengganti"]:checked');
                    if (radioButtons.length === 0) {
                        alert('Harap pilih apakah sudah ada pengganti atau belum');
                        isValid = false;
                    } else {
                        const selectedValue = radioButtons[0].value;
                        if (selectedValue === 'ya') {
                            const tanggalPengganti = document.getElementById('tanggal_shift_pengganti');
                            const jamPengganti = document.getElementById('jam_shift_pengganti');
                            if (!tanggalPengganti.value) {
                                showError('tanggal_shift_pengganti', 'Tanggal shift pengganti wajib diisi');
                                isValid = false;
                            }
                            if (!jamPengganti.value) {
                                showError('jam_shift_pengganti', 'Jam shift pengganti wajib diisi');
                                isValid = false;
                            }
                        }
                    }
                    break;
            }
            
            return isValid;
        }

        // ===============================
        // HELPER FUNCTIONS
        // ===============================
        function togglePengganti(isVisible) {
            const fields = document.getElementById('penggantiFields');
            const tanggalInput = document.getElementById('tanggal_shift_pengganti');
            const jamInput = document.getElementById('jam_shift_pengganti');
            
            if (isVisible) {
                fields.style.display = 'block';
                tanggalInput.required = true;
                jamInput.required = true;
                // Trigger animation
                fields.style.animation = 'slideDown 0.5s ease';
            } else {
                fields.style.animation = '';
                fields.style.opacity = '0';
                fields.style.transform = 'translateY(-20px)';
                fields.style.maxHeight = '0';
                fields.style.overflow = 'hidden';
                fields.style.transition = 'all 0.5s ease';
                
                setTimeout(() => {
                    fields.style.display = 'none';
                }, 500);
                
                tanggalInput.required = false;
                jamInput.required = false;
                tanggalInput.value = '';
                jamInput.value = '';
                hideError('tanggal_shift_pengganti');
                hideError('jam_shift_pengganti');
            }
        }

        function formatDate(dateString) {
            if (!dateString || dateString === '-') return '-';
            const date = new Date(dateString);
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            return date.toLocaleDateString('id-ID', options);
        }

        function fillConfirmation() {
            const formData = {
                nama: document.getElementById('nama_karyawan')?.value || '-',
                divisi: document.getElementById('divisi_jabatan')?.value || '-',
                tanggalAsli: document.getElementById('tanggal_shift_asli')?.value || '-',
                jamAsli: document.getElementById('jam_shift_asli')?.value || '-',
                tanggalTujuan: document.getElementById('tanggal_shift_tujuan')?.value || '-',
                jamTujuan: document.getElementById('jam_shift_tujuan')?.value || '-',
                alasan: document.getElementById('alasan')?.value || '-'
            };

            // Update confirmation elements
            document.getElementById('confirm_nama').innerText = formData.nama;
            document.getElementById('confirm_divisi').innerText = formData.divisi;
            document.getElementById('confirm_tanggal_asli').innerText = formatDate(formData.tanggalAsli);
            document.getElementById('confirm_jam_asli').innerText = formData.jamAsli || '-';
            document.getElementById('confirm_tanggal_tujuan').innerText = formatDate(formData.tanggalTujuan);
            document.getElementById('confirm_jam_tujuan').innerText = formData.jamTujuan || '-';
            document.getElementById('confirm_alasan').innerText = formData.alasan;
        }

        // ===============================
        // EVENT LISTENERS
        // ===============================
        document.addEventListener('click', function(e) {
            // Next button
            if (e.target.classList.contains('btn-next')) {
                if (validateStep(currentStep)) {
                    if (currentStep < steps.length) {
                        const nextStep = currentStep + 1;
                        if (nextStep === 5) {
                            fillConfirmation();
                        }
                        showStep(nextStep);
                    }
                }
            }
            
            // Previous button
            if (e.target.classList.contains('btn-prev')) {
                if (currentStep > 1) {
                    showStep(currentStep - 1);
                }
            }
        });

        // Form submission
        document.getElementById('shiftingForm')?.addEventListener('submit', function(e) {
            if (!validateStep(5)) {
                e.preventDefault();
                return false;
            }
            
            // Show loading state
            const submitBtn = this.querySelector('.btn-submit');
            if (submitBtn) {
                submitBtn.innerHTML = '<span class="loading-text">Mengirim...</span>';
                submitBtn.disabled = true;
                submitBtn.style.background = 'linear-gradient(135deg, #8a5c3a 0%, #6b3a1e 100%)';
                submitBtn.style.animation = 'pulse 1s infinite';
            }
            
            return true;
        });

        // ===============================
        // INITIALIZATION
        // ===============================
        document.addEventListener('DOMContentLoaded', function() {
            // Set min date for all date inputs
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const minDate = tomorrow.toISOString().split('T')[0];
            
            document.querySelectorAll('input[type="date"]').forEach(input => {
                input.min = minDate;
            });
            
            // Set up date validation between tanggal asli and tujuan
            const tanggalAsliInput = document.getElementById('tanggal_shift_asli');
            const tanggalTujuanInput = document.getElementById('tanggal_shift_tujuan');
            
            if (tanggalAsliInput && tanggalTujuanInput) {
                tanggalAsliInput.addEventListener('change', function() {
                    if (this.value) {
                        const asliDate = new Date(this.value);
                        const nextDay = new Date(asliDate);
                        nextDay.setDate(nextDay.getDate() + 1);
                        tanggalTujuanInput.min = nextDay.toISOString().split('T')[0];
                        
                        if (tanggalTujuanInput.value && new Date(tanggalTujuanInput.value) <= asliDate) {
                            tanggalTujuanInput.value = '';
                        }
                    }
                });
            }
            
            // Initialize pengganti toggle based on old data
            const sudahPengganti = "{{ old('sudah_pengganti') }}";
            if (sudahPengganti === 'ya') {
                togglePengganti(true);
            }
        });
    </script>
</body>
</html>