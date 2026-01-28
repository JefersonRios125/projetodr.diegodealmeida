const burger = document.querySelector(".menu_hamburguer");
const menu_lateral = document.querySelector(".menu_lateral");
const overlay = document.querySelector(".overlay");
const body = document.querySelector("body");

function abrirMenu() {
  menu_lateral.classList.toggle("menu_lateral_ativo");
  overlay.classList.toggle("overlay_ativo");
  body.classList.toggle("no_scroll");
}