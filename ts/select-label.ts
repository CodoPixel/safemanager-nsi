(function () {
  const preview = document.querySelector("#preview-label-color") as HTMLDivElement;
  const select = document.querySelector("#select-label") as HTMLSelectElement;

  select.addEventListener("change", (e: Event) => {
    const target = e.target as HTMLSelectElement;
    const newvalue = target.value;
    const option = select.querySelector("option[value='" + newvalue + "']") as HTMLOptionElement;
    const color = option.dataset.color;
    if (color) {
      preview.style.backgroundColor = color;
    } else {
      // we want to avoid the error
      (preview.style as any).backgroundColor = null; // reinitialize the value to its default one
    }
  });
})();
