window.onload = function () {
    // clear alerts after 5 seconds
    setTimeout(function() {
        try {
            document.getElementById("system-message-container").remove();
        } catch (e) {}
    }, 5000);
    
    // Makes the images redirect to the focused image view when clicked
    const tableBody = document.getElementById("images");

    tableBody.querySelectorAll("img").forEach((image) => {
        image.parentElement.addEventListener("click", function (e) {
            e.preventDefault();
            window.location.href = `?task=Display.imageDetails&id=${image.id}`;
        });
    });
};