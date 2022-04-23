"use strict";
const generatePasswordModalForNewConnection = new GeneratePasswordModal({
    onGeneration: function (password) {
        const passwordInput = document.querySelector("#password-for-connection");
        passwordInput.value = password.plainPassword;
    },
});
function generatePasswordForNewConnection() {
    generatePasswordModalForNewConnection.open();
}
