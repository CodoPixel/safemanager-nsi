"use strict";
(function () {
    const presentation = document.querySelector(".presentation");
    const images = document.querySelectorAll(".container-image");
    const leftButton = document.querySelector("#left");
    const rightButton = document.querySelector("#right");
    const previewImage = document.querySelector("#preview-image");
    const closeButton = document.querySelector("#cross");
    // The index of the image that had the focus
    // before opening the presentation (considered as a modal)
    let indexOfFocusedImage = 0;
    let currentPos = 0;
    let tabPos = 0;
    const focusableElements = [leftButton, rightButton, closeButton];
    images.forEach((image, index) => {
        image.addEventListener("click", () => {
            launchPresentationWith(index);
        });
    });
    function isPresentationOpen() {
        return presentation.classList.contains("open");
    }
    function closePresentation() {
        presentation.classList.remove("open");
        presentation.setAttribute("aria-hidden", "true");
        images[indexOfFocusedImage].focus(); // we put the focus back where it was
    }
    function setImage() {
        const img = images[currentPos].querySelector("img");
        if (img) {
            const src = img.getAttribute("src");
            if (src) {
                previewImage.setAttribute("src", src);
            }
        }
    }
    function previous() {
        currentPos -= 1;
        setImage();
        checkForLimits();
    }
    function next() {
        currentPos += 1;
        setImage();
        checkForLimits();
    }
    /**
     * Checks whether the current position is the first image or the last one.
     */
    function checkForLimits() {
        if (currentPos === 0) {
            leftButton.setAttribute("disabled", "true");
        }
        else {
            if (leftButton.hasAttribute("disabled")) {
                leftButton.removeAttribute("disabled");
            }
        }
        if (currentPos === images.length - 1) {
            rightButton.setAttribute("disabled", "true");
        }
        else {
            if (rightButton.hasAttribute("disabled")) {
                rightButton.removeAttribute("disabled");
            }
        }
    }
    /**
     * Creates a bigger screen in which the user can see all his images one by one.
     * @param {number} index The index of the image to start with.
     */
    function launchPresentationWith(index) {
        indexOfFocusedImage = index;
        currentPos = index;
        setImage();
        presentation.setAttribute("aria-hidden", "false");
        presentation.classList.add("open");
        checkForLimits();
        if (currentPos === 0) {
            rightButton.focus();
        }
        else {
            leftButton.focus();
        }
    }
    closeButton.addEventListener("click", closePresentation);
    leftButton.addEventListener("click", previous);
    rightButton.addEventListener("click", next);
    window.addEventListener("keyup", (event) => {
        if (isPresentationOpen()) {
            // if this is the Escape key, we need to close the presentation
            if (event.key === "Escape" || event.key === "Esc") {
                closePresentation();
            }
            else if (event.key === "ArrowLeft") {
                if (currentPos > 0) {
                    previous();
                }
            }
            else if (event.key === "ArrowRight") {
                if (currentPos < images.length - 1) {
                    next();
                }
            }
        }
    });
    window.addEventListener("keydown", (event) => {
        if (isPresentationOpen()) {
            if (event.key === "Tab") {
                if (event.shiftKey) {
                    tabPos--;
                    if (tabPos === 1 && rightButton.hasAttribute("disabled"))
                        tabPos--;
                    if (tabPos === 0 && leftButton.hasAttribute("disabled"))
                        tabPos--;
                    if (tabPos < 0)
                        tabPos = focusableElements.length - 1;
                }
                else {
                    tabPos++;
                    if (tabPos === focusableElements.length)
                        tabPos = 0;
                    if (tabPos === 1 && rightButton.hasAttribute("disabled"))
                        tabPos++;
                    if (tabPos === 0 && leftButton.hasAttribute("disabled"))
                        tabPos++;
                }
                event.preventDefault();
                focusableElements[tabPos].focus();
            }
        }
    });
})();
