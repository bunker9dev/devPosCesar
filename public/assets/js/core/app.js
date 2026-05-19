import { Events } from "./events.js";
import { initNavbar } from "../modules/navbar.js";

// IMPORTAR MÓDULOS (eventos)
import "../modules/alerts.js";
import "../modules/users.js";
import '../modules/sidebar.js';

// IMPORTAR PÁGINAS
import "../pages/dashboard.js";
import "../pages/login.js";
import "../modules/tablaVentas.js";

document.addEventListener("DOMContentLoaded", () => {
  initNavbar();

 // sidebar
  Events.emit("sidebar:init");

  // dashboard
  if (document.getElementById("chart")) {
    Events.emit("dashboard:init");
  }

  // login
  if (document.getElementById("alerta-error")) {
    Events.emit("login:init");
  }

  // alerts
  Events.emit("alerts:init");

  // tablas
  if (document.getElementById("tablaVentas")) {
    Events.emit("tablaVentas:init");
  }

  // users
  if (document.getElementById("tablaUsuarios")) {
     
    Events.emit("users:index");
  }

  // Previsualizar imagen
  if (document.querySelector('input[name="imagen"]')) {
    Events.emit("users:edit");
}


});
