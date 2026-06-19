console.log("APP JS CARGADO 🔥");

import { Events } from "./events.js";
import { initNavbar } from "../modules/navbar.js";

// ==========================
// CORE MODULES
// ==========================
import "../modules/sidebar.js";
import "../pages/dashboard.js";
import "../pages/login.js";
import "../modules/table.js";
import "../modules/products.js";

// ==========================
// FABRIC TYPES (INCLUIDO)
// ==========================
import "../modules/fabric-types.js";

document.addEventListener("DOMContentLoaded", () => {

  initNavbar();

  // ==========================
  // CORE SYSTEM
  // ==========================
  Events.emit("sidebar:init");
  Events.emit("alerts:init");

  // ==========================
  // PÁGINAS BASE
  // ==========================
  if (document.getElementById("chart")) {
    Events.emit("dashboard:init");
  }

  if (document.getElementById("alerta-error")) {
    Events.emit("login:init");
  }

  if (document.getElementById("table")) {
    Events.emit("table:init");
  }

  // ==========================
  // USERS
  // ==========================
  if (document.getElementById("tablaUsuarios")) {
    Events.emit("users:index");
  }

  if (document.querySelector('input[name="imagen"]')) {
    Events.emit("users:edit");
  }

  // ==========================
  // SUPPLIERS
  // ==========================
  if (document.getElementById("tablaSuppliers")) {
    Events.emit("suppliers:index");
  }

  if (document.getElementById("nombre")) {
    Events.emit("suppliers:create");
  }

  // ==========================
  // INVENTORY MODULES
  // ==========================
  if (document.getElementById("tablaRolls")) {
    Events.emit("inventory:rolls");
  }

  if (document.getElementById("tablaProducts")) {
    Events.emit("inventory:products");
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