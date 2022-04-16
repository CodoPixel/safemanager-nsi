(function () {
  const allLabels = document.querySelectorAll(".label") as NodeListOf<HTMLDivElement>;
  for (let label of Array.from(allLabels)) {
    const color = label.dataset.color;
    if (color) {
      label.style.backgroundColor = color;
    }
  }
})();
