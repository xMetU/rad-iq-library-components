window.onload = function () {
    // clear alerts after 5 seconds
    setTimeout(function () {
        try {
            document.getElementById("system-message-container").remove();
        } catch (e) { }
    }, 5000);

}