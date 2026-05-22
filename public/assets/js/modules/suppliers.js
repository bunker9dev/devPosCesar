console.log("SUPPLIERS MODULE LOADED");

import { Events } from "../core/events.js";
import { post } from "../core/api.js";

// =========================================================
// TOGGLE ESTADO
// =========================================================
function initSupplierToggle() {
  document.addEventListener("click", async (e) => {
    const el = e.target.closest(".estado-toggle");
    if (!el) return;

    const id = el.dataset.id;

    const res = await post("/suppliers/toggle", { id });

    if (!res.ok) return;

    el.dataset.estado = res.estado;
    el.textContent = res.estado == 1 ? "Activo" : "Inactivo";

    el.classList.toggle("active");
    el.classList.toggle("inactive");
  });
}

// =========================================================
// DELETE (SOFT DELETE)
// =========================================================
function initSupplierDelete() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".delete");
    if (!btn) return;

    const id = btn.dataset.id;

    if (!confirm("¿Eliminar proveedor?")) return;

    try {
      const res = await post("/suppliers/delete", { id });

      if (!res.ok) throw new Error(res.error);

      const row = btn.closest("tr");
      const badge = row.querySelector(".estado-toggle");

      // 🔥 actualizar UI
      badge.dataset.estado = 0;
      badge.textContent = "Eliminado";

      badge.classList.remove("active", "inactive");
      badge.classList.add("deleted");

      btn.remove();

      // 🔥 evento global
      Events.emit("suppliers:updated", {
        id,
        estado: 0,
      });
    } catch (err) {
      console.error(err);

      Events.emit("alerts:show", {
        type: "error",
        message: err.message || "Error al eliminar",
      });
    }

    
  });
}

// =========================================================
// INIT MODULE
// =========================================================
Events.on("suppliers:index", () => {
    console.log("INIT SUPPLIERS"); // 👈

  initSupplierToggle();
  initSupplierDelete(); // 🔥 NUEVO
});
