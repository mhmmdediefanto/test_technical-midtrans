import "./bootstrap";
import { Calendar } from "@fullcalendar/core";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import idLocale from "@fullcalendar/core/locales/id"; // Import Bahasa Indonesia

document.addEventListener("DOMContentLoaded", function () {
    let calendarEl = document.getElementById("calendar");

    if (calendarEl) {
        let calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: "dayGridMonth",
            locale: "id",
            selectable: true,
            events: bookedDates.map((booking) => ({
                title: "Booked",
                start: booking.tanggal_booking,
                color: "red", // Warna merah untuk menandai tanggal yang sudah dibooking
                textColor: "white",
            })),
            dateClick: function (info) {
                let selectedDate = info.dateStr;

                // console.log(selectedDate);

                // Cek apakah tanggal sudah dibooking
                let isBooked = bookedDates.some(
                    (booking) => booking.tanggal_booking === selectedDate
                );

                if (isBooked) {
                    alert(
                        "Tanggal ini sudah dibooking. Silakan pilih tanggal lain."
                    );
                } else {
                    document.getElementById("tanggal_booking").value =
                        selectedDate;
                }
            },
        });

        calendar.render();
    }
});
