window.onload = function () {
    // Makes the images redirect to the focused image view when clicked
    const tableBody = document.getElementById("attempts");
    
    tableBody.querySelectorAll(".row").forEach((row) => {
        row.addEventListener("click", function () {
            data = row.id.split('-');
            window.location.href = `?task=Display.summary&quizId=${data[0]}&attemptNumber=${data[1]}`;
        });
    });
};