window.onload = () => {
    // DOM elements
    const imageView = document.querySelector("#img-view");
    const focusedImageView = document.querySelector("#focused-img-view");
    const focusedImage = document.querySelector("#focused-img");
    const exitButton = document.querySelector("#exit-button");
    const contrastInput = document.querySelector("#contrast-input");

    // variables
    const minZoom = 0.5;
    const maxZoom = 2.5;
    const zoomFactor = 0.1;
    let currentZoom = 0.5;

    initImageView();
    initFocusedImageView();
    initZoom();

    // ================================================================================
    // INIT FUNCTIONS
    // ================================================================================

    function initImageView() {
        imageView.addEventListener("click", function (e) {
            e.preventDefault();
            openFocusedImageViewer();
        });
    }

    function initFocusedImageView() {
        contrastInput.value = 100;
        contrastInput.addEventListener("input", function (e) {
            console.log(this.value);
            e.preventDefault();
            focusedImage.style.filter = `contrast(${this.value}%)`;
        });

        exitButton.addEventListener("click", function (e) {
            e.preventDefault();
            closeFocusedImageViewer();
        });
    }

    function initZoom() {
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
    }

    // ================================================================================
    // UTILITIES
    // ================================================================================

    function openFocusedImageViewer() {
        focusedImageView.classList.remove("d-none");
    }

    function closeFocusedImageViewer() {
        focusedImageView.classList.add("d-none");
        focusedImage.style.filter = "";
    }
}