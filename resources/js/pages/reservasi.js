<script src="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css"></script>;
// Mobile Menu Toggle
document.addEventListener("DOMContentLoaded", function () {
    const mobileMenuBtn = document.getElementById("mobileMenuBtn");
    const mobileMenu = document.getElementById("mobileMenu");

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener("click", function () {
            mobileMenu.classList.toggle("hidden");
        });

        // Close mobile menu when clicking outside
        document.addEventListener("click", function (event) {
            if (
                !mobileMenu.contains(event.target) &&
                !mobileMenuBtn.contains(event.target) &&
                !mobileMenu.classList.contains("hidden")
            ) {
                mobileMenu.classList.add("hidden");
            }
        });
    }

    // Booking Modal Script
    const bookingModal = document.getElementById("bookingModal");

    if (bookingModal) {
        bookingModal.addEventListener("show.bs.modal", function (event) {
            const button = event.relatedTarget;
            const roomType = button.getAttribute("data-room");
            const roomPrice = button.getAttribute("data-price");

            const modalTitle = bookingModal.querySelector(".modal-title");
            const modalRoomType = bookingModal.querySelector("#roomType");
            const modalRoomPrice = bookingModal.querySelector("#roomPrice");

            modalTitle.innerHTML = `<i class="fas fa-bed me-2"></i>Booking ${roomType}`;
            modalRoomType.value = roomType;
            modalRoomPrice.value = formatRupiah(roomPrice);
        });
    }

    function formatRupiah(angka) {
        return "Rp " + Number(angka).toLocaleString("id-ID");
    }

    const checkInInput = document.getElementById("checkIn");
    const checkOutInput = document.getElementById("checkOut");

    if (checkInInput && checkOutInput) {
        checkInInput.addEventListener("change", function () {
            const tomorrow = new Date(this.value);
            tomorrow.setDate(tomorrow.getDate() + 1);
            const nextDay = tomorrow.toISOString().split("T")[0];
            checkOutInput.min = nextDay;

            if (
                checkOutInput.value &&
                new Date(checkOutInput.value) < tomorrow
            ) {
                checkOutInput.value = nextDay;
            }
        });
    }

    const bookingForm = document.getElementById("bookingForm");
    if (bookingForm) {
        bookingForm.addEventListener("submit", function (e) {
            e.preventDefault();

            const roomType = document.getElementById("roomType").value;
            const checkIn = document.getElementById("checkIn").value;
            const checkOut = document.getElementById("checkOut").value;
            const guests = document.getElementById("guests").value;
            const rooms = document.getElementById("rooms").value;
            const fullName = document.getElementById("fullName").value;
            const phone = document.getElementById("phone").value;
            const email = document.getElementById("email").value;
            const specialRequest =
                document.getElementById("specialRequest").value;

            const message =
                `*RESERVASI LEGARECA INN*%0A%0A` +
                `*Detail Reservasi:*%0A` +
                `Tipe Kamar: ${roomType}%0A` +
                `Check-in: ${formatDate(checkIn)}%0A` +
                `Check-out: ${formatDate(checkOut)}%0A` +
                `Jumlah Kamar: ${rooms} kamar%0A` +
                `Jumlah Tamu: ${guests} orang%0A%0A` +
                `*Data Pemesan:*%0A` +
                `Nama: ${fullName}%0A` +
                `WhatsApp: ${phone}%0A` +
                `Email: ${email}%0A` +
                `Permintaan Khusus: ${specialRequest || "Tidak ada"}%0A%0A` +
                `_Terima kasih atas reservasi Anda. Tim kami akan menghubungi Anda untuk konfirmasi lebih lanjut._`;

            window.open(
                `https://wa.me/6281234567890?text=${message}`,
                "_blank",
            );

            const modal = bootstrap.Modal.getInstance(bookingModal);
            modal.hide();

            bookingForm.reset();
        });
    }

    function formatDate(dateString) {
        const date = new Date(dateString);
        const options = {
            weekday: "long",
            year: "numeric",
            month: "long",
            day: "numeric",
        };
        return date.toLocaleDateString("id-ID", options);
    }
});
