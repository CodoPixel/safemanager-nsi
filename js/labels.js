(function () {
  const allLabels = document.querySelectorAll(".label");
  for (let label of allLabels) {
    label.style.backgroundColor = label.dataset.color;
  }
})();
