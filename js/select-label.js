(function () {
  const preview = document.querySelector("#preview-label-color");
  const select = document.querySelector("#select-label");

  select.addEventListener("change", (e) => {
    const newvalue = e.target.value;
    const color = select.querySelector("option[value='" + newvalue + "']").dataset.color;
    if (color) {
      preview.style.backgroundColor = color;
    } else {
      preview.style.backgroundColor = null; // reinitialize the value to its default one
    }
  });
})();
