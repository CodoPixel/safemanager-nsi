"use strict";
const angle = document.querySelector("#bottomangle");
const menu = document.querySelector("#menu");
const sidebar = document.querySelector("#sidebar");
const hamburger = document.querySelector(".hamburger");
const shader = document.querySelector(".shader");
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
