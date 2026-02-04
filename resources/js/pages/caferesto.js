//<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>;
document.addEventListener("DOMContentLoaded", function () {
    console.log("Cafe Resto page loaded");

    // Table Selection from Cards
    const tableButtons = document.querySelectorAll("[data-table-type]");
    const tableTypeSelect = document.getElementById("tableType");

    if (tableButtons.length > 0 && tableTypeSelect) {
        tableButtons.forEach((button) => {
            button.addEventListener("click", function () {
                const tableType = this.getAttribute("data-table-type");
                console.log("Selected table:", tableType);
                tableTypeSelect.value = tableType;

                const modal = new bootstrap.Modal(
                    document.getElementById("reservationModal"),
                );
                modal.show();

                setTimeout(() => {
                    tableTypeSelect.focus();
                }, 500);
            });
        });
    }

    // Set default values for form
    function setDefaultFormValues() {
        // Set default date to tomorrow
        const dateInput = document.getElementById("date");
        if (dateInput) {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const tomorrowFormatted = tomorrow.toISOString().split("T")[0];
            dateInput.min = today.toISOString().split("T")[0];
            dateInput.value = tomorrowFormatted;
        }

        // Set default time to 18:00
        const timeSelect = document.getElementById("time");
        if (timeSelect) {
            timeSelect.value = "18:00";
        }

        // Set default guests to 2
        const guestsSelect = document.getElementById("guests");
        if (guestsSelect) {
            guestsSelect.value = "2";
        }
    }

    // Form Validation
    function validateForm() {
        let isValid = true;
        let firstInvalidElement = null;

        // Reset all invalid states
        document.querySelectorAll(".is-invalid").forEach((el) => {
            el.classList.remove("is-invalid");
        });

        // Check required fields
        document
            .querySelectorAll("#reservationForm [required]")
            .forEach((input) => {
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
                        if (!firstInvalidElement) firstInvalidElement = input;
                    }
                }

                // Phone validation
                if (input.name === "phone" && input.value.trim()) {
                    const phoneRegex = /^[0-9]{10,15}$/;
                    const phoneValue = input.value.trim().replace(/\D/g, "");
                    if (!phoneRegex.test(phoneValue)) {
                        isValid = false;
                        input.classList.add("is-invalid");
                        if (!firstInvalidElement) firstInvalidElement = input;
                    }
                }

                // Date validation (cannot be past date)
                if (input.type === "date" && input.value) {
                    const selectedDate = new Date(input.value);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);

                    if (selectedDate < today) {
                        isValid = false;
                        input.classList.add("is-invalid");
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

    // Submit button click handler
    const submitBtn = document.getElementById("submitReservationBtn");
    const reservationForm = document.getElementById("reservationForm");

    if (submitBtn && reservationForm) {
        submitBtn.addEventListener("click", async function (e) {
            e.preventDefault();
            console.log("Submit button clicked");

            // Collect form data for debugging
            const formData = new FormData(reservationForm);
            const formDataObj = {};
            formData.forEach((value, key) => {
                formDataObj[key] = value;
            });
            console.log("Form data to be submitted:", formDataObj);

            // Validate form
            if (!validateForm()) {
                Swal.fire({
                    icon: "error",
                    title: "Data Tidak Valid",
                    text: "Mohon periksa kembali data yang Anda masukkan.",
                    confirmButtonColor: "#e17055",
                    confirmButtonText: "Mengerti",
                });
                return false;
            }

            const loadingIndicator = document.getElementById("loading");
            const successMessage = document.getElementById("successMessage");
            const errorMessage = document.getElementById("errorMessage");

            // Show loading, hide messages
            this.disabled = true;
            this.innerHTML =
                '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
            loadingIndicator.classList.remove("d-none");
            successMessage.classList.add("d-none");
            errorMessage.classList.add("d-none");

            // Get CSRF token
            const csrfToken = document.querySelector(
                'meta[name="csrf-token"]',
            )?.content;
            console.log("CSRF Token:", csrfToken);

            if (!csrfToken) {
                console.error("CSRF token not found!");
                alert("CSRF token tidak ditemukan. Silakan refresh halaman.");
                return false;
            }

            // Prepare data for submission
            const data = {
                _token: csrfToken,
                name: document.getElementById("name").value,
                phone: document.getElementById("phone").value,
                email: document.getElementById("email").value,
                date: document.getElementById("date").value,
                time: document.getElementById("time").value,
                guests: document.getElementById("guests").value,
                table_type: document.getElementById("tableType").value,
                special_request:
                    document.getElementById("special_request").value,
            };

            console.log("Data to send:", data);

            try {
                const postUrl = "/cafe-resto/reservation";
                console.log("Sending POST request to:", postUrl);

                const response = await fetch(postUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                        "X-Requested-With": "XMLHttpRequest",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify(data),
                });

                console.log("Response status:", response.status);

                let responseData;
                try {
                    responseData = await response.json();
                    console.log("Response data:", responseData);
                } catch (jsonError) {
                    console.error("JSON parse error:", jsonError);
                    const text = await response.text();
                    console.error("Response text:", text);
                    throw new Error("Invalid JSON response from server");
                }

                // Hide loading indicator
                loadingIndicator.classList.add("d-none");
                this.disabled = false;
                this.innerHTML =
                    '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi Sekarang';

                if (responseData.success) {
                    // Show success message
                    document.getElementById("successText").textContent =
                        responseData.message;
                    successMessage.classList.remove("d-none");

                    // Scroll to success message
                    successMessage.scrollIntoView({ behavior: "smooth" });

                    // Reset form
                    reservationForm.reset();
                    setDefaultFormValues();

                    // Redirect to WhatsApp after 2 seconds
                    setTimeout(() => {
                        if (responseData.whatsapp_url) {
                            console.log(
                                "Opening WhatsApp URL:",
                                responseData.whatsapp_url,
                            );
                            window.open(responseData.whatsapp_url, "_blank");
                        }

                        // Close modal after 3 seconds
                        setTimeout(() => {
                            const modal = bootstrap.Modal.getInstance(
                                document.getElementById("reservationModal"),
                            );
                            if (modal) {
                                modal.hide();
                            }
                        }, 3000);
                    }, 2000);
                } else {
                    // Show error message
                    let errorText =
                        responseData.message ||
                        "Terjadi kesalahan. Silakan coba lagi.";
                    if (responseData.errors) {
                        errorText = "Periksa kesalahan berikut: \n";
                        for (const [key, messages] of Object.entries(
                            responseData.errors,
                        )) {
                            errorText += `• ${messages.join(", ")}\n`;
                        }
                    }
                    document.getElementById("errorText").textContent =
                        errorText;
                    errorMessage.classList.remove("d-none");

                    // Scroll to error message
                    errorMessage.scrollIntoView({ behavior: "smooth" });
                }
            } catch (error) {
                console.error("Fetch error:", error);
                loadingIndicator.classList.add("d-none");
                this.disabled = false;
                this.innerHTML =
                    '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi Sekarang';

                document.getElementById("errorText").textContent =
                    "Terjadi kesalahan jaringan. Silakan coba lagi atau hubungi kami via WhatsApp.";
                errorMessage.classList.remove("d-none");
                errorMessage.scrollIntoView({ behavior: "smooth" });
            }

            return false;
        });
    }

    // Real-time validation for form fields
    if (reservationForm) {
        reservationForm
            .querySelectorAll("input, select, textarea")
            .forEach((input) => {
                input.addEventListener("blur", function () {
                    if (this.hasAttribute("required") && !this.value.trim()) {
                        this.classList.add("is-invalid");
                    } else {
                        this.classList.remove("is-invalid");
                    }

                    // Email validation
                    if (this.type === "email" && this.value.trim()) {
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailRegex.test(this.value.trim())) {
                            this.classList.add("is-invalid");
                        } else {
                            this.classList.remove("is-invalid");
                        }
                    }

                    // Phone validation and formatting
                    if (this.name === "phone" && this.value.trim()) {
                        // Format phone number
                        let value = this.value.replace(/\D/g, "");
                        if (value.startsWith("0")) {
                            value = "62" + value.substring(1);
                        }
                        if (value.length > 0 && !value.startsWith("62")) {
                            value = "62" + value;
                        }
                        value = value.substring(0, 15);
                        this.value = value;

                        const phoneRegex = /^[0-9]{10,15}$/;
                        if (!phoneRegex.test(value)) {
                            this.classList.add("is-invalid");
                        } else {
                            this.classList.remove("is-invalid");
                        }
                    }
                });
            });
    }

    // Modal events
    const reservationModal = document.getElementById("reservationModal");
    if (reservationModal) {
        // When modal is shown
        reservationModal.addEventListener("shown.bs.modal", function () {
            console.log("Modal shown");
            setDefaultFormValues();

            // Auto-focus on first input
            setTimeout(() => {
                const firstInput = document.querySelector("#tableType");
                if (firstInput) {
                    firstInput.focus();
                }
            }, 300);
        });

        // When modal is hidden
        reservationModal.addEventListener("hidden.bs.modal", function () {
            console.log("Modal closed, resetting form");

            // Reset form
            if (reservationForm) {
                reservationForm.reset();
                setDefaultFormValues();
            }

            // Reset all states
            document.getElementById("loading").classList.add("d-none");
            document.getElementById("successMessage").classList.add("d-none");
            document.getElementById("errorMessage").classList.add("d-none");

            // Reset submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML =
                    '<i class="fas fa-paper-plane me-2"></i>Kirim Reservasi Sekarang';
            }

            // Remove invalid classes
            document.querySelectorAll(".is-invalid").forEach((el) => {
                el.classList.remove("is-invalid");
            });
        });
    }

    // Initialize form values
    setDefaultFormValues();

    // Debug info
    console.log("Submit button ID:", submitBtn ? "found" : "not found");
    console.log("Form ID:", reservationForm ? "found" : "not found");
    console.log("POST URL should be: /cafe-resto/reservation");
});
