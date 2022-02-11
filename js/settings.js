(function () {
  // ----
  // switches
  // ----

  const switches = document.querySelectorAll(".switch");
  switches.forEach((e, i) => {
    e.addEventListener("click", () => {
      toggle(e);
    });
  });

  function toggle(element) {
    element.classList.toggle("on");
    const dataName = element.dataset.name;
    const input = document.querySelector("input[name='" + dataName + "']");
    if (element.classList.contains("on")) {
      input.value = "true";
    } else {
      input.value = "false";
    }
  }
})();
