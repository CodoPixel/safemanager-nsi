"use strict";
(function () {
    const preview = document.querySelector("#preview-label-color");
    const select = document.querySelector("#select-label");
    function getSelectedColor() {
        const option = select.querySelector("option[value='" + select.value + "']");
        return option.dataset.color;
    }
    function updatePreview() {
        const color = getSelectedColor();
        if (color) {
            preview.style.backgroundColor = color;
        }
        else {
            // we want to avoid the error
            preview.style.backgroundColor = null; // reinitialize the value to its default one
        }
    }
    window.addEventListener("load", updatePreview);
    select.addEventListener("change", updatePreview);
})();
