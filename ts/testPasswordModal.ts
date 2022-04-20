const testButton = document.querySelector("#testpassword-button") as HTMLButtonElement;
const passwordInput = document.querySelector("#tested-password-input") as HTMLInputElement;
const progressBar = document.querySelector(
  ".container-testpassword-modal-progressbar .circular-progress"
) as HTMLElement;

testButton.onclick = () => {
  const plainPassword = passwordInput.value;
  const config = guessConfigFromPlainPassword(plainPassword);
  const score = calcScoreOf(config);
  console.log("score =", score);
  animateProgressBar(null, score * 10, 5, true, progressBar);
};
