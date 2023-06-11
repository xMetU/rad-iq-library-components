window.onload = function () {
    const form = document.getElementsByTagName("form")[0];

    document.querySelectorAll(".navigator").forEach((button) => {
        button.addEventListener("click", function() {
            form.querySelector("input[name='nextQuestionId']").value = button.id;
            form.submit();
        });
    });

    const focusedImageView = document.getElementById("focused-img-view");
    const focusedImage = document.getElementById("focused-img");
    const contrastInput = document.getElementById("contrast-input");
    const brightnessInput = document.getElementById("brightness-input");

    const minZoom = 0.5;
    const maxZoom = 2.5;
    const zoomFactor = 0.1;

    let currentZoom = 0.5;
    let currentBrightness = 100;
    let currentContrast = 100;

    document.getElementById("open-button").onclick = () => {
        focusedImageView.classList.remove("d-none");
    }

    document.getElementById("exit-button").onclick = () => {
        focusedImageView.classList.add("d-none");
        focusedImage.style.filter = "";
    }

    focusedImage.style.transform = `scale(0.5)`;
    focusedImage.addEventListener("wheel", function (e) {
        e.preventDefault();

        if (e.deltaY < 0) {
            if (currentZoom >= maxZoom) return;
            currentZoom += zoomFactor;
        } else {
            if (currentZoom <= minZoom) return;
            currentZoom -= zoomFactor;
        }

        const { left, top, width, height } = focusedImage.getBoundingClientRect();
        const imageX = ((e.clientX - left) / width) * 100;
        const imageY = ((e.clientY - top) / height) * 100;
        focusedImage.style.transformOrigin = `${imageX}% ${imageY}%`;
        focusedImage.style.transform = `scale(${currentZoom})`;
    });

    brightnessInput.value = currentBrightness;
    brightnessInput.addEventListener("input", function () {
        currentBrightness = this.value;
        focusedImage.style.filter = `brightness(${currentBrightness}%) contrast(${currentContrast}%)`;
    });

    contrastInput.value = currentContrast;
    contrastInput.addEventListener("input", function () {
        currentContrast = this.value;
        focusedImage.style.filter = `brightness(${currentBrightness}%) contrast(${currentContrast}%)`;
    });
}