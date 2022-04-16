"use strict";
function togglePasswordType() {
    const input = document.getElementById("password");
    const eye = document.getElementById("eye");
    if (input.type === "password") {
        input.type = "text";
        eye.classList.replace("fa-eye", "fa-eye-slash");
    }
    else {
        input.type = "password";
        eye.classList.replace("fa-eye-slash", "fa-eye");
    }
}
