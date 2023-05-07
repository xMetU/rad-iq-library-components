window.onload = function () {
    const tableBody = document.getElementById("images");

    tableBody.querySelectorAll("form").forEach((form) => {
        // delete button opens the confirm message
        form.querySelector(".delete").onclick = function (e) {
            e.preventDefault();
            openOverlay(form);
        }

        // yes button submits the form and closes it
        form.querySelector(".delete-yes").onclick = function (e) {
            closeOverlay(form);
        }

        // no button closes it without submitting
        form.querySelector(".delete-no").onclick = function (e) {
            e.preventDefault();
            closeOverlay(form);
        }

    });

    // ========== UTILITIES ==========

    function openOverlay(form) {
        form.querySelector(".overlay-background").classList.remove("d-none");
    }

    function closeOverlay(form) {
        form.querySelector(".overlay-background").classList.add("d-none");
    }
};