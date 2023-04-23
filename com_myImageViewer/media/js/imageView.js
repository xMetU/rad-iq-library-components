window.onload = function () {
    // Makes the images redirect to the focused image view when clicked
    const tableBody = document.getElementById("images");

    tableBody.querySelectorAll("img").forEach((image) => {
        image.parentElement.onclick = (e) => {
            e.preventDefault();
            window.location.href += `?&task=Display.focusImage&id=${image.id}`;
        }
    });
};