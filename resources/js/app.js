import "./bootstrap";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import idLocale from "@fullcalendar/core/locales/id"; // Import Bahasa Indonesia

// let selectedDates = [];
document.addEventListener("DOMContentLoaded", function () {
    let calendarEl = document.getElementById("calendar");

    if (calendarEl) {
        let calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: "dayGridMonth",
            locale: "id",
            selectable: true,
            events: bookedDates.map((booking) => ({
                title: `Booked ${booking.service.name}`,
                start: booking.tanggal_booking,
                color: booking.service_id == 1 ? "red" : "blue", // Warna merah untuk menandai tanggal yang sudah dibooking
                textColor: "white",
                classNames: ["text-xs"], // Kelas CSS untuk teks kecil
            })),
            dateClick: function (info) {
                let selectedDate = info.dateStr;

                // Cek apakah tanggal sudah ada di daftar
                // if (selectedDates.includes(selectedDate)) {
                //     // Hapus tanggal jika sudah dipilih sebelumnya (toggle)
                //     selectedDates = selectedDates.filter(
                //         (date) => date !== selectedDate
                //     );
                // } else {
                //     // Tambahkan tanggal baru ke daftar
                //     selectedDates.push(selectedDate);
                // }

                // console.log(selectedDates);

                // Cek apakah PS4 sudah dibooking
                let isBookedPS4 = bookedDates.some(
                    (booking) =>
                        booking.tanggal_booking === selectedDate &&
                        booking.service_id == 1
                );

                // Cek apakah PS5 sudah dibooking
                let isBookedPS5 = bookedDates.some(
                    (booking) =>
                        booking.tanggal_booking === selectedDate &&
                        booking.service_id == 2
                );
                // Log untuk debugging
                // console.log("Tanggal dipilih:", selectedDate);
                // console.log("PS4 booked:", isBookedPS4);
                // console.log("PS5 booked:", isBookedPS5);

                if (isBookedPS4 && isBookedPS5) {
                    alert(
                        "Tanggal ini untuk PS4 dan PS5 Sudah booking. Silakan pilih tanggal lain."
                    );
                } else {
                    document.getElementById("tanggal_booking").value =
                        selectedDate;
                    // document.getElementById("tanggal_booking").value =
                    // selectedDates;
                }
            },
        });

        calendar.render();
    }
});
