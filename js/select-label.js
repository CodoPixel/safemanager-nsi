"use strict";
(function () {
    const preview = document.querySelector("#preview-label-color");
    const select = document.querySelector("#select-label");
    select.addEventListener("change", (e) => {
        const target = e.target;
        const newvalue = target.value;
        const option = select.querySelector("option[value='" + newvalue + "']");
        const color = option.dataset.color;
        if (color) {
            preview.style.backgroundColor = color;
        }
        else {
            // we want to avoid the error
            preview.style.backgroundColor = null; // reinitialize the value to its default one
        }
    });
})();
