// ================================
// IMPORTS
// ================================
import { Events } from "../core/events.js";
import { post } from "../core/api.js";
import { initDataTable } from "./table.js";

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

  let currentRow = null;

  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-edit");
    if (!btn) return;

    currentRow = btn.closest("tr");

    idInput.value = btn.dataset.id;

    input.value = btn.dataset.name || "";

    form.dataset.url = btn.dataset.url;

    modal.classList.remove("hidden");
    input.focus();
  });

  cancel?.addEventListener("click", () => {
    modal.classList.add("hidden");
    currentRow = null;
  });

  form?.addEventListener("submit", async (e) => {
    e.preventDefault();

    const id = idInput.value;
    const nombre = input.value.trim();
    const url = form.dataset.url;

    if (!nombre || !url) return;

    try {
      const res = await post(url, { id, nombre });

      if (!res || res.ok !== true) {
        throw new Error(res?.error || "Error actualizando");
      }

      Events.emit("alerts:show", {
        type: "success",
        message: "Actualizado correctamente",
      });

      modal.classList.add("hidden");

      if (currentRow) {
        const cell = currentRow.querySelector('td[data-label="Color"]');

        if (cell) {
          const chip = cell.querySelector(".color-chip");

          cell.innerHTML = `
          ${chip ? chip.outerHTML : ""}
          ${nombre}
        `;
        }
      }

      currentRow = null;
    } catch (err) {
      Events.emit("alerts:show", {
        type: "error",
        message: err.message,
      });
    }
  });
}

// ================================
// DELETE 
// ================================
function initDelete() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    const row = btn.closest("tr");

    const nameCell = row.querySelector('td[data-label="Nombre"]');
    const name = nameCell ? nameCell.textContent.trim() : "registro";

    const entity = btn.dataset.entity || "elemento";

    if (!confirm(`¿Eliminar ${entity} "${name}"?`)) return;

    try {
      const res = await post(url, { id });

      if (!res || res.ok !== true) {
        throw new Error(res?.error || "Error eliminando");
      }

      const badge = row.querySelector(".estado-toggle");

      if (badge) {
        badge.textContent = "Eliminado";
        badge.classList.remove("active", "inactive");
        badge.classList.add("deleted");
      }

      const actions = row.querySelector("td:last-child");
      if (actions) actions.innerHTML = "";

      row.classList.add("deleted");

      Events.emit("alerts:show", {
        type: "success",
        message: "Registro eliminado",
      });
    } catch (err) {
      Events.emit("alerts:show", {
        type: "error",
        message: err.message,
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

      if (!res || res.ok !== true) {
        throw new Error(res?.error || "Error restaurando");
      }

      const badge = row.querySelector(".estado-toggle");

      if (badge) {
        badge.dataset.estado = 1;
        badge.textContent = "Activo";

        badge.classList.remove("deleted", "inactive");
        badge.classList.add("active");
      }

      row.classList.remove("deleted");

      // 🔥 reconstrucción correcta de acciones
      const actions = row.querySelector("td:last-child");

      if (actions) {
        actions.innerHTML = `
          <button class="btn-action edit btn-edit"
            data-id="${id}"
            data-url="${BASE_URL}/products/colors/update">
            Editar
          </button>

          <button class="btn-action delete btn-delete"
            data-id="${id}"
            data-url="${BASE_URL}/products/colors/delete"
            data-entity="color">
            Eliminar
          </button>
        `;
      }

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

      if (!res || res.ok !== true) {
        throw new Error(res?.error || "Error");
      }

      btn.dataset.estado = res.estado;

      btn.classList.remove("active", "inactive");

      if (res.estado == 1) {
        btn.classList.add("active");
        btn.textContent = "Activo";
      } else {
        btn.classList.add("inactive");
        btn.textContent = "Inactivo";
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
// INIT CONTROLADO
// ================================
document.addEventListener("DOMContentLoaded", () => {
  // console.log("INIT PRODUCTS OK");


 

  if (document.querySelector("#tablaWarehouses")) {
    initWarehouseToggle();
  }
});
