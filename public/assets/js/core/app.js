import { Events } from "./events.js";
import { initNavbar } from "../modules/navbar.js";


// IMPORTAR MÓDULOS (eventos)
import "../modules/alerts.js";
import "../modules/users.js";
import '../modules/sidebar.js';

// IMPORTAR PÁGINAS
import "../pages/dashboard.js";
import "../pages/login.js";
import "../modules/table.js";
import "../modules/suppliers.js";
import "../modules/inventory.js";
import "../modules/products.js";

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
  if (document.getElementById("table")) {
    Events.emit("table:init");
  }

  // users
  if (document.getElementById("tablaUsuarios")) {
     
    Events.emit("users:index");
  }

  // Previsualizar imagen
  if (document.querySelector('input[name="imagen"]')) {
    Events.emit("users:edit");
}

// ##########################
// Proveedores - suppliers
// ##########################
if (document.getElementById("tablaSuppliers")) {
    Events.emit("suppliers:index");
}

// suppliers create
if (document.getElementById("nombre")) {
    Events.emit("suppliers:create");
}

if (document.getElementById("tablaRolls")) {
  Events.emit("inventory:rolls");
}

if (document.getElementById("tablaProducts")) {
  Events.emit("inventory:products");
}

if (document.getElementById("tablaFabricTypes")) {
  Events.emit("inventory:types");
}

if (document.getElementById("tablaFabricColors")) {
  Events.emit("inventory:colors");
}

if (document.getElementById("tablaMovements")) {
  Events.emit("inventory:movements");
}

if (document.getElementById("tablaPurchases")) {
  Events.emit("inventory:purchases");
}


});
