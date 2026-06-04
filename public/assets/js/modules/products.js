// ================================
// IMPORTS
// ================================
import { Events } from "../core/events.js";
import { post } from "../core/api.js";
import { initDataTable } from "./inventory.js";

// ================================
// EDIT MODAL (PRO)
// ================================
function initEditModal() {
  const modal = document.getElementById("modalEditType");
  const input = document.getElementById("editTypeName");
  const idInput = document.getElementById("editTypeId");
  const form = document.getElementById("formEditType");
  const cancel = document.getElementById("btnCancelEdit");

  if (!modal) return;

  let currentRow = null; // 🔥 referencia REAL

  // ================================
  // ABRIR MODAL
  // ================================
  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-edit");
    if (!btn) return;

    currentRow = btn.closest("tr");

    idInput.value = btn.dataset.id;
    input.value = btn.dataset.name;

    const nameCell = currentRow.querySelector('td[data-label="Nombre"]');
    input.value = nameCell ? nameCell.textContent.trim() : "";

    form.dataset.url = btn.dataset.url;

    modal.classList.remove("hidden");
    input.focus();
  });

  // ================================
  // CERRAR
  // ================================
  cancel?.addEventListener("click", () => {
    modal.classList.add("hidden");
    currentRow = null;
  });

  // ================================
  // SUBMIT
  // ================================
  form?.addEventListener("submit", async (e) => {
    e.preventDefault();

    const id = idInput.value;
    const nombre = input.value.trim();
    const url = form.dataset.url;

    if (!nombre || !url) return;

    try {
      const res = await fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ id, nombre }),
      });

      const data = await res.json();

      if (data.success) {
        Events.emit("alerts:show", {
          type: "success",
          message: data.message,
        });

        modal.classList.add("hidden");

        // 🔥 actualizar fila REAL
        if (currentRow) {
          const cell = currentRow.querySelector('td[data-label="Nombre"]');
          if (cell) cell.textContent = nombre;
        }

        currentRow = null;
      } else {
        throw new Error(data.message);
      }
    } catch (err) {
      Events.emit("alerts:show", {
        type: "error",
        message: err.message,
      });
    }
  });
}

// ================================
// DELETE (PRO)
// ================================
function initDelete() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    const row = btn.closest("tr");

    // 🔥 nombre REAL desde DOM
    const nameCell = row.querySelector('td[data-label="Nombre"]');
    const name = nameCell ? nameCell.textContent.trim() : "registro";

    const entity = btn.dataset.entity || "elemento";

    if (
      !confirm(
        `¿Eliminar ${entity} "${name}"?\nEsta acción no se puede deshacer.`,
      )
    )
      return;

    try {
      const res = await post(url, { id });

      if (!res.ok) throw new Error(res.error);

      const badge = row.querySelector(".badge");

      if (badge) {
        badge.textContent = badge.dataset.labelDeleted || "Eliminado";
        badge.classList.remove("active", "inactive");
        badge.classList.add("deleted");
      }

      const actions = row.querySelector("td:last-child");
      actions.innerHTML = ``;

      Events.emit("alerts:show", {
        type: "success",
        message: "Registro eliminado",
      });
    } catch (err) {
      Events.emit("alerts:show", {
        type: "error",
        message: err.message || "Error al eliminar",
      });
    }
  });
}

// ================================
// RESTORE (PRO)
// ================================
function initRestore() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    const row = btn.closest("tr");

    try {
      const res = await post(url, { id });

      if (!res.ok) throw new Error(res.error);

      const badge = row.querySelector(".badge");

      if (badge) {
        badge.textContent = badge.dataset.labelActive || "Activo";
        badge.classList.remove("deleted", "inactive");
        badge.classList.add("active");
      }

      const actions = row.querySelector("td:last-child");

      actions.innerHTML = `
        <button
          class="btn-delete"
          data-id="${id}"
          data-url="${url.replace("restore", "delete")}">
          Eliminar
        </button>
      `;

      row.classList.remove("deleted");

      Events.emit("alerts:show", {
        type: "success",
        message: "Registro restaurado",
      });
    } catch (err) {
      Events.emit("alerts:show", {
        type: "error",
        message: err.message || "Error al restaurar",
      });
    }
  });
}

// ================================
// TOGGLE WAREHOUSE
// ================================
function initWarehouseToggle() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".toggle-warehouse");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    try {
      const res = await post(url, { id });

      if (!res.ok) throw new Error(res.error);

      location.reload();
    } catch (err) {
      Events.emit("alerts:show", {
        type: "error",
        message: err.message || "Error al cambiar estado",
      });
    }
  });
}

// ================================
// INIT
// ================================
document.addEventListener("DOMContentLoaded", () => {
  console.log("INIT PRODUCTS OK");

  initDataTable("#tablaFabricTypes", "tipos");
  initDataTable("#tablaColors", "colores");

  initEditModal();
  initDelete();
  initRestore();
  initWarehouseToggle();
});
