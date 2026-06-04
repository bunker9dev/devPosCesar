import { Events } from "../core/events.js";
import { post } from "../core/api.js";

// =========================================================
// TOGGLE ESTADO (PRO)
// =========================================================
function initSupplierToggle() {
  document.addEventListener("click", async (e) => {
    const el = e.target.closest(".toggle-supplier");
    if (!el) return;

    const estadoActual = parseInt(el.dataset.estado);
    if (estadoActual === 0) return; // 🔒 no tocar eliminados

    if (el.classList.contains("loading")) return;

    const id = el.dataset.id;
    const url = el.dataset.url;

    if (!id || !url) return;

    el.classList.add("loading");
    el.style.opacity = "0.6";
    el.style.pointerEvents = "none";

    try {
      const res = await post(url, { id });

      if (!res?.ok || typeof res.estado === "undefined") {
        throw new Error("Respuesta inválida");
      }

      const estado = parseInt(res.estado);
      el.dataset.estado = estado;

      // 🔥 TEXTO CONTROLADO POR FRONT
      let texto = "";
      if (estado === 1) texto = "Activo";
      else if (estado === 2) texto = "Inactivo";
      else texto = "Eliminado";

      el.textContent = texto;

      // 🔥 CLASES
      el.classList.remove("active", "inactive", "deleted");

      if (estado === 1) el.classList.add("active");
      else if (estado === 2) el.classList.add("inactive");
      else el.classList.add("deleted");

      Events.emit("suppliers:updated", { id, estado });

    } catch (err) {
      console.error(err);

      Events.emit("alerts:show", {
        type: "error",
        message: err.message || "Error al cambiar estado",
      });
    } finally {
      el.classList.remove("loading");
      el.style.opacity = "";
      el.style.pointerEvents = "";
    }
  });
}

// =========================================================
// DELETE (PRO)
// =========================================================
function initSupplierDelete() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".delete");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    const row = btn.closest("tr");

    // 🔥 nombre dinámico
    const nameCell = row.querySelector('td[data-label="Proveedor"]');
    const name = nameCell ? nameCell.textContent.trim() : "proveedor";

    if (!confirm(`¿Eliminar "${name}"?`)) return;

    try {
      const res = await post(url, { id });

      if (!res?.ok) throw new Error(res.error);

      const badge = row.querySelector(".estado-toggle");

      // 🔥 estado eliminado
      badge.dataset.estado = 0;
      badge.textContent = "Eliminado";

      badge.classList.remove("active", "inactive");
      badge.classList.add("deleted");

      // 🔥 limpiar acciones
      const actions = row.querySelector("td:last-child");
      actions.innerHTML = `
        <button 
          class="btn-restore"
          data-id="${id}"
          data-url="${url.replace("delete", "restore")}">
          Restaurar
        </button>
      `;

      Events.emit("alerts:show", {
        type: "success",
        message: "Proveedor eliminado",
      });

      Events.emit("suppliers:updated", { id, estado: 0 });

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
// RESTORE (PRO)
// =========================================================
function initSupplierRestore() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    const row = btn.closest("tr");

    try {
      const res = await post(url, { id });

      if (!res?.ok) throw new Error(res.error);

      const badge = row.querySelector(".estado-toggle");

      badge.dataset.estado = 1;
      badge.textContent = "Activo";

      badge.classList.remove("deleted", "inactive");
      badge.classList.add("active");

      // 🔥 restaurar acciones
      const actions = row.querySelector("td:last-child");

      actions.innerHTML = `
        <button 
          class="btn-action delete"
          data-id="${id}"
          data-url="${url.replace("restore", "delete")}"
          data-entity="proveedor">
          Eliminar
        </button>
      `;

      Events.emit("alerts:show", {
        type: "success",
        message: "Proveedor restaurado",
      });

      Events.emit("suppliers:updated", { id, estado: 1 });

    } catch (err) {
      console.error(err);

      Events.emit("alerts:show", {
        type: "error",
        message: err.message || "Error al restaurar",
      });
    }
  });
}

// =========================================================
// INIT
// =========================================================
Events.on("suppliers:index", () => {
  console.log("INIT SUPPLIERS PRO");

  initSupplierToggle();
  initSupplierDelete();
  initSupplierRestore();
});