function togglePasswordType() {
  const input = document.getElementById("password") as HTMLInputElement;
  const eye = document.getElementById("eye") as HTMLElement;
  if (input.type === "password") {
    input.type = "text";
    eye.classList.replace("fa-eye", "fa-eye-slash");
  } else {
    input.type = "password";
    eye.classList.replace("fa-eye-slash", "fa-eye");
  }
}
