(function () {
  const hamburger = document.querySelector(".hamburger");
  const sidebar = document.querySelector("#sidebar");
  const shader = document.querySelector("#shader");

  function isSidebarOpen() {
    return hamburger.classList.contains("cross");
  }

  function toggle() {
    if (isSidebarOpen()) {
      close();
    } else {
      open();
    }
  }

  function close() {
    hamburger.classList.remove("cross");
    sidebar.classList.remove("open");
    shader.classList.remove("open");
    hamburger.setAttribute("aria-expanded", "false");
    hamburger.setAttribute("title", "Ouvrir le menu");
  }

  function open() {
    hamburger.classList.add("cross");
    sidebar.classList.add("open");
    shader.classList.add("open");
    hamburger.setAttribute("aria-expanded", "true");
    hamburger.setAttribute("title", "Fermer le menu");
  }

  hamburger.addEventListener("click", toggle);
  shader.addEventListener("click", close);
  window.addEventListener("scroll", () => {
    if (isSidebarOpen()) {
      close();
    }
  });
})();
