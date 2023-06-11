window.onload = function () {
    // clear alerts after 5 seconds
    setTimeout(function () {
        try {
            document.getElementById("system-message-container").remove();
        } catch (e) { }
    }, 5000);

    // Catch errors caused when the delete stuff is not rendered (for non-managers)
    try {
        const tableBody = document.getElementById("answers");
        const deleteConfirmation = document.getElementById("delete-confirmation");

        tableBody.querySelectorAll(".delete-button").forEach((deleteButton, i) => {
            deleteButton.onclick = () => {
                deleteConfirmation.querySelector("[name='answerId']").value = deleteButton.id;
                deleteConfirmation.querySelector("h5").innerHTML = `
                    Are you sure you want to remove this answer?<br/>
                    This will adjust all associated user scores.<br/>
                    This action cannot be undone.
                `;
                deleteConfirmation.classList.remove("d-none");
            }
        })

        document.getElementById("delete-confirm").onclick = () => {
            deleteConfirmation.classList.add("d-none");
        }

        document.getElementById("delete-cancel").onclick = (e) => {
            e.preventDefault();
            deleteConfirmation.classList.add("d-none");
        }
    } catch (e) { }

}