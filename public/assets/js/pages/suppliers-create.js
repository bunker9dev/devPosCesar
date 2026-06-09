// =========================================================
//  PAGE: SUPPLIERS CREATE (PRO - LIMPIO)
// =========================================================

import { Events } from "../core/events.js";
import "../modules/suppliers.js";

// =========================================================
// INIT PAGE
// =========================================================
document.addEventListener("DOMContentLoaded", () => {
  console.log("INIT SUPPLIERS CREATE");

  // 🔥 Inicializa TODO el comportamiento desde el módulo
  // (validación NIT + validación submit)
  Events.emit("suppliers:form");
});