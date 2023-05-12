window.onload = function () {
    const deleteConfirmation = document.getElementById("delete-confirmation");
    const focusedImageView = document.getElementById("focused-img-view");
    const focusedImage = document.getElementById("focused-img");
    const contrastInput = document.getElementById("contrast-input");

    const minZoom = 0.5;
    const maxZoom = 2.5;
    const zoomFactor = 0.1;
    let currentZoom = 0.5;
 
    document.getElementById("delete-button").onclick = (e) => {
        e.preventDefault();
        deleteConfirmation.classList.remove("d-none");
    }

    document.getElementById("delete-confirm").onclick = () => {
        deleteConfirmation.classList.add("d-none");
    }

    document.getElementById("delete-cancel").onclick = (e) => {
        e.preventDefault();
        deleteConfirmation.classList.add("d-none");
    }

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

    contrastInput.value = 100;
    contrastInput.addEventListener("input", function() {
        focusedImage.style.filter = `contrast(${this.value}%)`;
    });

};