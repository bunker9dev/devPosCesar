// // =========================================================
// //  WAREHOUSES MODULE (PRO)
// // =========================================================

// import { Events } from "../core/events.js";
// import { post } from "../core/api.js";

// // =========================================================
// //  TOGGLE ESTADO
// // =========================================================
// export function initWarehouseToggle() {
//   document.addEventListener("click", async (e) => {
//     const el = e.target.closest(".estado-toggle");
//     if (!el) return;

//     const estadoActual = parseInt(el.dataset.estado);
//     if (estadoActual === 0) return;

//     const id = el.dataset.id;
//     const url = el.dataset.url; //

//     try {
//       const res = await post(url, { id });

//       if (!res.ok) throw new Error(res.error);

//       el.dataset.estado = res.estado;

//       el.classList.remove("active", "inactive");

//       if (res.estado == 1) {
//         el.classList.add("active");
//         el.textContent = el.dataset.labelActive || "Activo";
//       } else {
//         el.classList.add("inactive");
//         el.textContent = el.dataset.labelInactive || "Inactivo";
//       }

//       if (window.$ && $.fn.DataTable.isDataTable("#tablaWarehouses")) {
//         const table = $("#tablaWarehouses").DataTable();
//         const row = table.row(el.closest("tr"));

//         row.invalidate().draw(false);
//       }
//     } catch (err) {
//       console.error(err);
//     }
//   });
// }

// // =========================================================
// // DELETE
// // =========================================================
// export function initWarehouseDelete() {
//   document.addEventListener("click", async (e) => {
//     const btn = e.target.closest(".btn-delete");
//     if (!btn) return;

//     const id = btn.dataset.id;
//     const url = btn.dataset.url;

//     try {
//       const res = await post(url, { id });

//       if (!res.ok) throw new Error(res.error);

//       location.reload(); // simple por ahora
//     } catch (err) {
//       console.error(err);
//     }
//   });
// }

// // =========================================================
// // RESTORE
// // =========================================================
// export function initWarehouseRestore() {
//   document.addEventListener("click", async (e) => {
//     const btn = e.target.closest(".btn-restore");
//     if (!btn) return;

//     const id = btn.dataset.id;
//     const url = btn.dataset.url;

//     try {
//       const res = await post(url, { id });

//       if (!res.ok) throw new Error(res.error);

//       location.reload();
//     } catch (err) {
//       console.error(err);
//     }
//   });
// }

// // =========================================================
// // EDIT
// // =========================================================
// export function initWarehouseEdit() {
//   document.addEventListener("click", (e) => {
//     const btn = e.target.closest(".btn-edit-warehouse");
//     if (!btn) return;

//     Events.emit("warehouses:edit", {
//       id: btn.dataset.id,
//       nombre: btn.dataset.name,
//       ubicacion: btn.dataset.ubicacion,
//     });
//   });
// }


import { post } from "../core/api.js";
import { updateBadgeState } from "../core/ui.js";
import { Events } from "../core/events.js";

// ================================
// TOGGLE
// ================================
function initToggle() {
  document.addEventListener("click", async (e) => {
    const el = e.target.closest(".estado-toggle");
    if (!el) return;

    const id = el.dataset.id;
    const url = el.dataset.url;

    if (parseInt(el.dataset.estado) === 0) return;

    try {
      const res = await post(url, { id });

      if (!res || res.ok !== true) {
        throw new Error(res?.error || "Error");
      }

      updateBadgeState(el, res.estado);

    } catch (err) {
      Events.emit("alerts:show", {
        type: "error",
        message: err.message,
      });
    }
  });
}

// ================================
// RESTORE
// ================================
function initRestore() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    const row = btn.closest("tr");
    const badge = row.querySelector(".estado-toggle");

    try {
      const res = await post(url, { id });

      if (!res || res.ok !== true) {
        throw new Error(res?.error || "Error");
      }

      updateBadgeState(badge, 1);

      row.classList.remove("deleted");

    } catch (err) {
      Events.emit("alerts:show", {
        type: "error",
        message: err.message,
      });
    }
  });
}

// ================================
// INIT
// ================================
export function initWarehouses() {
  initToggle();
  initRestore();
}