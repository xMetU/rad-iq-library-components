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

    // Below is literally the same thing as above but for the sub category delete
    const deleteSelectSub = document.getElementById("delete-select-sub");
    const deleteConfirmationSub = document.getElementById("delete-confirmation-sub");

    deleteSelectSub.addEventListener("input", function () {
        deleteConfirmationSub.querySelector("h5").innerHTML = `
            Are you sure you want to remove ${this.selectedOptions[0].textContent}?<br/>This action cannot be undone.
        `;
    });

    document.getElementById("delete-button-sub").onclick = (e) => {
        e.preventDefault();
        if (deleteSelectSub.value == "") {
            deleteSelectSub.reportValidity();
        } else {
            deleteConfirmationSub.classList.remove("d-none");
        }
    }

    document.getElementById("delete-confirm-sub").onclick = () => {
        deleteConfirmationSub.classList.add("d-none");
    }

    document.getElementById("delete-cancel-sub").onclick = (e) => {
        e.preventDefault();
        deleteConfirmationSub.classList.add("d-none");
    }
};