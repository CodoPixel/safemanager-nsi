const generatePasswordModalForNewConnection = new GeneratePasswordModal({
  onGeneration: function (password: GeneratedPassword) {
    const passwordInput = document.querySelector("#password-for-connection") as HTMLInputElement;
    passwordInput.value = password.plainPassword;
  },
});

function generatePasswordForNewConnection() {
  generatePasswordModalForNewConnection.open();
}
