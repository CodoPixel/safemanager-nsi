"use strict";
function animateProgressBar(start = null, end = 100, speed = 50, on10 = false, progressBar) {
    if (progressBar == null) {
        throw new Error("The progress bar does not exist on the page.");
    }
    const valueContainer = progressBar.querySelector(".value-container");
    start ??= parseInt(progressBar.hasAttribute("data-progress")
        ? progressBar.getAttribute("data-progress")
        : "0", 10);
    if (start == end)
        return;
    progressBar.setAttribute("data-progress", end.toString());
    const isMovingForward = start < end;
    const progress = setInterval(() => {
        if (isMovingForward) {
            start++;
        }
        else {
            start--;
        }
        valueContainer.textContent = on10 ? Math.floor(start / 10).toString() : `${start}%`;
        progressBar.style.background = `conic-gradient(
        #4d5bf9 ${start * 3.6}deg,
        #cadcff ${start * 3.6}deg
      )`;
        if (start == end) {
            clearInterval(progress);
        }
    }, speed);
}
