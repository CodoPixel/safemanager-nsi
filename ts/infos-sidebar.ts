const angle = document.querySelector("#bottomangle") as HTMLElement;
const menu = document.querySelector("#menu") as HTMLElement;
const sidebar = document.querySelector("#sidebar") as HTMLElement;
const hamburger = document.querySelector(".hamburger") as HTMLButtonElement;
const shader = document.querySelector(".shader") as HTMLDivElement;

function toggleMenu() {
  menu.classList.toggle("hide");
  angle.classList.toggle("rotate-angle");
}
angle.addEventListener("click", toggleMenu);

function toggleSidebar() {
  sidebar.classList.toggle("open");
  hamburger.classList.toggle("cross");
  shader.classList.toggle("open");
}

hamburger.addEventListener("click", toggleSidebar);
