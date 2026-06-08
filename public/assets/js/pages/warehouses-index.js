import {
  initWarehouseToggle,
  initWarehouseDelete,
  initWarehouseRestore,
  initWarehouseEdit
} from "../modules/warehouses.js";

// =========================================================
// 📄 PAGE: WAREHOUSES INDEX
// =========================================================

import { Events } from "../core/events.js";

// 🔥 IMPORTAR MÓDULO (IMPORTANTE PARA QUE SE EJECUTE)
import "../modules/warehouses.js";

// (opcional si usas helper de tablas)
import "../modules/table.js"; // o tu initDataTable si lo tienes separado

// =========================================================
// 🚀 INIT PAGE
// =========================================================
document.addEventListener("DOMContentLoaded", () => {

  // =============================
  // 🔥 INICIALIZAR MÓDULO
  // =============================
  Events.emit("warehouses:index");

  // =============================
  // 📊 DATATABLE (SI LO USAS)
  // =============================
  if (window.$ && $("#tablaWarehouses").length) {

    $("#tablaWarehouses").DataTable({
      responsive: true,
      autoWidth: false,
      pageLength: 10,
      order: [[1, "desc"]],

      columnDefs: [
        { targets: 0, orderable: false, className: "control" }
      ],

      language: {
        search: "Buscar:",
        lengthMenu: "Mostrar _MENU_ registros",
        info: "Mostrando _START_ a _END_ de _TOTAL_",
        paginate: {
          next: "→",
          previous: "←"
        }
      }
    });
  }

});


// =========================================================
// INIT MODULE
// =========================================================
Events.on("warehouses:index", () => {
  console.log("INIT WAREHOUSES");

  initWarehouseToggle();
  initWarehouseDelete();
  initWarehouseRestore();
  initWarehouseEdit();
});