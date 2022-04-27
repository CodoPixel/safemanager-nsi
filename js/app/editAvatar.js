"use strict";
const avatarInput = document.querySelector("#avatar");
function askForImage() {
    avatarInput.click();
}
avatarInput.addEventListener("change", (e) => {
    if (avatarInput.files) {
        const file = avatarInput.files[0];
        console.log("file =", file);
    }
});
