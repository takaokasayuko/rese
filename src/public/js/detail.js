const reservationDate = document.getElementById("reservationDate");
const reservationTime = document.getElementById("reservationTime");
const reservationNumber = document.getElementById("reservationNumber");

const displayDate = document.getElementById("displayDate");
const displayTime = document.getElementById("displayTime");
const displayNumber = document.getElementById("displayNumber");

window.addEventListener("DOMContentLoaded", function () {
    displayTime.textContent = reservationTime.value;
    displayNumber.textContent = reservationNumber.value + "人";
});

reservationDate.addEventListener("input", function () {
    displayDate.textContent = reservationDate.value;
});

reservationTime.addEventListener("change", function () {
    displayTime.textContent = reservationTime.value;
});

reservationNumber.addEventListener("change", function () {
    displayNumber.textContent = reservationNumber.value + "人";
});
