(function () {
  // ----
  // switches
  // ----

  const switches = document.querySelectorAll(".switch") as NodeListOf<HTMLButtonElement>;
  switches.forEach((e) => {
    e.addEventListener("click", () => {
      toggle(e);
    });
  });

  function toggle(element: HTMLButtonElement) {
    element.classList.toggle("on");
    const dataName = element.dataset.name;
    const input = document.querySelector("input[name='" + dataName + "']") as HTMLInputElement;
    if (element.classList.contains("on")) {
      input.value = "true";
    } else {
      input.value = "false";
    }
  }
})();
