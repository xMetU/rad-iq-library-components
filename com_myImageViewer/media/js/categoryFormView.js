window.onload = function () {
    // clear alerts after 5 seconds
    setTimeout(function() {
        try {
            document.getElementById("system-message-container").remove();
        } catch (e) {}
    }, 5000);

    const deleteSelect = document.getElementById("delete-select");
    const deleteConfirmation = document.getElementById("delete-confirmation");

    deleteSelect.addEventListener("input", function() {
        deleteConfirmation.querySelector("h5").innerHTML = `
            Are you sure you want to remove ${this.selectedOptions[0].textContent}?<br/>This action cannot be undone.
        `;
    });

    document.getElementById("delete-button").onclick = (e) => {
        e.preventDefault();
        if (deleteSelect.value == "") {
            deleteSelect.reportValidity();
        } else {
            deleteConfirmation.classList.remove("d-none");
        }
    }

    document.getElementById("delete-confirm").onclick = () => {
        deleteConfirmation.classList.add("d-none");
    }

    document.getElementById("delete-cancel").onclick = (e) => {
        e.preventDefault();
        deleteConfirmation.classList.add("d-none");
    }
};