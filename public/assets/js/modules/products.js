// ================================
// IMPORTS
// ================================
import { Events } from "../core/events.js";
import { post } from "../core/api.js";
import { initDataTable } from "./inventory.js";

// ================================
// EDIT MODAL (DINÁMICO)
// ================================
function initEditModal() {
  const modal = document.getElementById("modalEditType");
  const input = document.getElementById("editTypeName");
  const idInput = document.getElementById("editTypeId");
  const form = document.getElementById("formEditType");
  const cancel = document.getElementById("btnCancelEdit");

  if (!modal) return;

  // ABRIR MODAL
  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-edit");
    if (!btn) return;

    idInput.value = btn.dataset.id;
    input.value = btn.dataset.name;

    // 🔥 guardar URL dinámica
    form.dataset.url = btn.dataset.url;

    modal.classList.remove("hidden");
    input.focus();
  });

  // CERRAR
  cancel?.addEventListener("click", () => {
    modal.classList.add("hidden");
  });

  // SUBMIT
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

        // actualizar UI
        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (row) {
          const cell = row.querySelector('td[data-label="Nombre"]');
          if (cell) cell.textContent = nombre;
        }
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
// DELETE (DINÁMICO)
// ================================
function initDelete() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    if (!confirm("¿Eliminar registro?")) return;

    try {
      const res = await post(url, { id });

      if (!res.ok) throw new Error(res.error);

      const row = btn.closest("tr");

      // animación
      row.style.opacity = "0";

      setTimeout(() => {
        row.remove();
      }, 300);

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
// RESTORE (DINÁMICO)
// ================================
function initRestore() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    try {
      const res = await post(url, { id });

      if (!res.ok) throw new Error(res.error);

      const row = btn.closest("tr");
      const badge = row.querySelector(".badge");

      if (badge) {
        badge.textContent = "Disponible";
        badge.classList.remove("deleted");
        badge.classList.add("active");
      }

      row.classList.remove("deleted");
      btn.remove();

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
// INIT
// ================================
document.addEventListener("DOMContentLoaded", () => {
  console.log("INIT PRODUCTS OK");

  initDataTable("#tablaFabricTypes", "tipos");
  initDataTable("#tablaColors", "colores");

  initEditModal();
  initDelete();
  initRestore();
});