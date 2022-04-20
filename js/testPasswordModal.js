"use strict";
const testButton = document.querySelector("#testpassword-button");
const passwordInput = document.querySelector("#tested-password-input");
const progressBar = document.querySelector(".container-testpassword-modal-progressbar .circular-progress");
testButton.onclick = () => {
    const plainPassword = passwordInput.value;
    const config = guessConfigFromPlainPassword(plainPassword);
    const score = calcScoreOf(config);
    console.log("score =", score);
    animateProgressBar(null, score * 10, 5, true, progressBar);
};
