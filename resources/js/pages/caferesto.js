/**
 * Cafe Resto Reservation System
 * File: public/js/cafe-resto.js
 */

class CafeRestoReservation {
    constructor() {
        this.init();
    }

    init() {
        console.log("Cafe Resto Reservation System Initialized");
        
        // Initialize when DOM is loaded
        document.addEventListener("DOMContentLoaded", () => {
            this.setupEventListeners();
            this.setDefaultFormValues();
            this.debugInfo();
        });
    }

    setupEventListeners() {
        // Table selection from cards
        this.setupTableSelection();
        
        // Form submission
        this.setupFormSubmission();
        
        // Modal events
        this.setupModalEvents();
        
        // Real-time validation
        this.setupRealTimeValidation();
    }

    setupTableSelection() {
        const tableButtons = document.querySelectorAll("[data-table-type]");
        const tableTypeSelect = document.getElementById("tableType");

        if (tableButtons.length > 0 && tableTypeSelect) {
            tableButtons.forEach((button) => {
                button.addEventListener("click", () => {
                    const tableType = button.getAttribute("data-table-type");
                    console.log("Selected table:", tableType);
                    tableTypeSelect.value = tableType;

                    const modal = new bootstrap.Modal(
                        document.getElementById("reservationModal")
                    );
                    modal.show();
                });
            });
        }
    }

    setDefaultFormValues() {
        // Set default date to tomorrow
        const dateInput = document.getElementById("date");
        if (dateInput) {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowFormatted = tomorrow.toISOString().split("T")[0];
            dateInput.min = today.toISOString().split("T")[0];
            if (!dateInput.value) {
                dateInput.value = tomorrowFormatted;
            }
        }

        // Set default time to 18:00 if not set
        const timeSelect = document.getElementById("time");
        if (timeSelect && !timeSelect.value) {
            timeSelect.value = "18:00";
        }

        // Set default guests to 2 if not set
        const guestsSelect = document.getElementById("guests");
        if (guestsSelect && !guestsSelect.value) {
            guestsSelect.value = "2";
        }
    }

    formatPhoneNumber(phone) {
        if (!phone) return '';
        
        // Remove all non-numeric characters
        phone = phone.replace(/\D/g, '');
        
        // If starts with 0, replace with 62
        if (phone.startsWith('0')) {
            phone = '62' + phone.substring(1);
        }
        
        // Ensure starts with 62
        if (!phone.startsWith('62')) {
            phone = '62' + phone;
        }
        
        return phone.substring(0, 15); // Max 15 digits
    }

    validateForm() {
        let isValid = true;
        let firstInvalidElement = null;

        // Reset all invalid states
        document.querySelectorAll(".is-invalid").forEach((el) => {
            el.classList.remove("is-invalid");
        });

        // Check required fields
        document.querySelectorAll("#reservationForm [required]").forEach((input) => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add("is-invalid");
                if (!firstInvalidElement) firstInvalidElement = input;
            }

            // Email validation
            if (input.type === "email" && input.value.trim()) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(input.value.trim())) {
                    isValid = false;
                    input.classList.add("is-invalid");
                    const errorDiv = input.nextElementSibling;
                    if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                        errorDiv.textContent = "Format email tidak valid";
                    }
                    if (!firstInvalidElement) firstInvalidElement = input;
                }
            }

            // Phone validation
            if (input.name === "phone" && input.value.trim()) {
                const phoneValue = input.value.trim();
                const numericPhone = phoneValue.replace(/\D/g, '');
                
                if (numericPhone.length < 10 || numericPhone.length > 15) {
                    isValid = false;
                    input.classList.add("is-invalid");
                    const errorDiv = input.nextElementSibling;
                    if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                        errorDiv.textContent = "Nomor WhatsApp harus 10-15 digit";
                    }
                    if (!firstInvalidElement) firstInvalidElement = input;
                }
            }

            // Date validation
            if (input.type === "date" && input.value) {
                const selectedDate = new Date(input.value);
                const today = new Date();
                today.setHours(0, 0, 0, 0);

                if (selectedDate < today) {
                    isValid = false;
                    input.classList.add("is-invalid");
                    const errorDiv = input.nextElementSibling;
                    if (errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                        errorDiv.textContent = "Tanggal tidak boleh hari kemarin";
                    }
                    if (!firstInvalidElement) firstInvalidElement = input;
                }
            }
        });

        // Scroll to first invalid element
        if (firstInvalidElement) {
            firstInvalidElement.scrollIntoView({
                behavior: "smooth",
                block: "center",
            });
            firstInvalidElement.focus();
        }

        return isValid;
    }

    async submitForm(event) {
        event.preventDefault();
        console.log("Submit button clicked");

        // Validate form
        if (!this.validateForm()) {
            this.showSweetAlert("error", "Data Tidak Valid", "Mohon periksa kembali data yang Anda masukkan.");
            return false;
        }

        // Format phone number
        const phoneInput = document.getElementById("phone");
        if (phoneInput) {
            phoneInput.value = this.formatPhoneNumber(phoneInput.value);
        }

        // Collect form data
        const formData = new FormData(document.getElementById("reservationForm"));
        const data = Object.fromEntries(formData.entries());
        
        // Log data for debugging
        console.log("Form data:", data);

        const submitBtn = document.getElementById("submitReservationBtn");
        const loadingIndicator = document.getElementById("loading");
        const successMessage = document.getElementById("successMessage");
        const errorMessage = document.getElementById("errorMessage");

        // Show loading
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
        loadingIndicator.classList.remove("d-none");
        successMessage.classList.add("d-none");
        errorMessage.classList.add("d-none");

        try {
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            
            if (!csrfToken) {
                throw new Error("CSRF token tidak ditemukan");
            }

            // Send to server
            const response = await fetch(this.getFormActionUrl(), {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                    "X-Requested-With": "XMLHttpRequest"
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            console.log("Server response:", result);

            // Hide loading
            loadingIndicator.classList.add("d-none");
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi Sekarang';

            if (result.success) {
                this.handleSuccessResponse(result);
            } else {
                this.handleErrorResponse(result);
            }

        } catch (error) {
            console.error("Error:", error);
            this.handleNetworkError(error);
        }
    }

    getFormActionUrl() {
        // Try to get from form action attribute
        const form = document.getElementById("reservationForm");
        if (form && form.action) {
            return form.action;
        }
        
        // Default URL based on common Laravel routes
        return '/cafe-resto/reservation';
    }

    handleSuccessResponse(result) {
        // Show success message
        const successMessage = document.getElementById("successMessage");
        const successText = document.getElementById("successText");
        
        if (successText) {
            successText.textContent = result.message;
        }
        
        if (successMessage) {
            successMessage.classList.remove("d-none");
            successMessage.scrollIntoView({ behavior: "smooth" });
        }

        // Reset form
        const reservationForm = document.getElementById("reservationForm");
        if (reservationForm) {
            reservationForm.reset();
            this.setDefaultFormValues();
        }

        // Open WhatsApp in new tab after 1 second
        if (result.whatsapp_url) {
            setTimeout(() => {
                window.open(result.whatsapp_url, '_blank', 'noopener,noreferrer');
            }, 1000);
        }

        // Close modal after 4 seconds
        setTimeout(() => {
            const modal = bootstrap.Modal.getInstance(
                document.getElementById("reservationModal")
            );
            if (modal) {
                modal.hide();
            }
        }, 4000);
    }

    handleErrorResponse(result) {
        const errorMessage = document.getElementById("errorMessage");
        const errorText = document.getElementById("errorText");
        
        if (!errorMessage || !errorText) return;

        let errorMessageText = result.message || "Terjadi kesalahan. Silakan coba lagi.";
        
        if (result.errors) {
            errorMessageText = "Periksa kesalahan berikut:<br>";
            for (const [field, messages] of Object.entries(result.errors)) {
                errorMessageText += `• ${messages.join(', ')}<br>`;
            }
        }
        
        errorText.innerHTML = errorMessageText;
        errorMessage.classList.remove("d-none");
        errorMessage.scrollIntoView({ behavior: "smooth" });
    }

    handleNetworkError(error) {
        const submitBtn = document.getElementById("submitReservationBtn");
        const loadingIndicator = document.getElementById("loading");
        const errorMessage = document.getElementById("errorMessage");
        const errorText = document.getElementById("errorText");
        
        loadingIndicator.classList.add("d-none");
        
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi Sekarang';
        }
        
        if (errorText && errorMessage) {
            errorText.textContent = 
                "Terjadi kesalahan jaringan. Silakan coba lagi atau hubungi kami langsung.";
            errorMessage.classList.remove("d-none");
            errorMessage.scrollIntoView({ behavior: "smooth" });
        }
    }

    showSweetAlert(icon, title, text) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
                confirmButtonColor: "#e17055",
                confirmButtonText: "Mengerti",
            });
        } else {
            alert(`${title}: ${text}`);
        }
    }

    setupFormSubmission() {
        const submitBtn = document.getElementById("submitReservationBtn");
        if (submitBtn) {
            submitBtn.addEventListener("click", (e) => this.submitForm(e));
        }
    }

    setupModalEvents() {
        const reservationModal = document.getElementById("reservationModal");
        if (!reservationModal) return;

        // When modal is shown
        reservationModal.addEventListener("shown.bs.modal", () => {
            console.log("Reservation modal shown");
            this.setDefaultFormValues();
        });

        // When modal is hidden
        reservationModal.addEventListener("hidden.bs.modal", () => {
            console.log("Reservation modal closed");
            this.resetModalState();
        });
    }

    resetModalState() {
        // Reset all states
        const loadingIndicator = document.getElementById("loading");
        const successMessage = document.getElementById("successMessage");
        const errorMessage = document.getElementById("errorMessage");
        const submitBtn = document.getElementById("submitReservationBtn");
        
        if (loadingIndicator) loadingIndicator.classList.add("d-none");
        if (successMessage) successMessage.classList.add("d-none");
        if (errorMessage) errorMessage.classList.add("d-none");
        
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi Sekarang';
        }
        
        // Remove invalid classes
        document.querySelectorAll(".is-invalid").forEach((el) => {
            el.classList.remove("is-invalid");
        });
    }

    setupRealTimeValidation() {
        const reservationForm = document.getElementById("reservationForm");
        if (!reservationForm) return;

        reservationForm.querySelectorAll("input, select, textarea").forEach((input) => {
            input.addEventListener("blur", () => {
                if (input.hasAttribute("required") && !input.value.trim()) {
                    input.classList.add("is-invalid");
                } else {
                    input.classList.remove("is-invalid");
                }

                // Email validation
                if (input.type === "email" && input.value.trim()) {
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(input.value.trim())) {
                        input.classList.add("is-invalid");
                    } else {
                        input.classList.remove("is-invalid");
                    }
                }
            });

            // Format phone number on input
            if (input.name === "phone") {
                input.addEventListener("input", () => {
                    // Allow only numbers and +
                    input.value = input.value.replace(/[^\d+]/g, '');
                });
            }
        });
    }

    debugInfo() {
        console.log("Cafe Resto Debug Info:");
        console.log("- Form Element:", document.getElementById("reservationForm") ? "Found" : "Not Found");
        console.log("- Submit Button:", document.getElementById("submitReservationBtn") ? "Found" : "Not Found");
        console.log("- Modal Element:", document.getElementById("reservationModal") ? "Found" : "Not Found");
        console.log("- CSRF Token:", document.querySelector('meta[name="csrf-token"]')?.content ? "Exists" : "Missing");
    }
}

// Initialize the reservation system
const cafeRestoReservation = new CafeRestoReservation();

// Make available globally if needed
window.CafeRestoReservation = cafeRestoReservation;