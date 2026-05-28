// ================================
// IMPORTS
// ================================
import { Events } from "../core/events.js";
import { initDataTable } from "./inventory.js";
import { post } from "../core/api.js";

document.addEventListener("click", (e) => {
  const btn = e.target.closest(".btn-restore");
  if (btn) {
    console.log("RESTORE CLICK", btn.dataset.id);
  }
});

// ================================
// INLINE CREATE
// ================================
function initInlineCreateType() {
  const input = document.getElementById("inputTypeName");
  const form = document.getElementById("formCreateType");

  if (!input || !form) return;

  input.focus();

  input.addEventListener("focus", () => input.select());

  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      form.submit();
    }
  });

  form.addEventListener("submit", () => {
    setTimeout(() => (input.value = ""), 100);
  });
}

// ================================
// ALERTS
// ================================
function initAlerts() {
  const alert = document.getElementById("alertMessage");
  if (!alert) return;

  setTimeout(() => {
    alert.style.opacity = "0";
    alert.style.transform = "translateY(-10px)";
    setTimeout(() => alert.remove(), 300);
  }, 2500);
}

// ================================
// EDIT MODAL
// ================================
function initEditModal() {
  const modal = document.getElementById("modalEditType");
  const input = document.getElementById("editTypeName");
  const idInput = document.getElementById("editTypeId");
  const form = document.getElementById("formEditType");
  const cancel = document.getElementById("btnCancelEdit");

  if (!modal) return;

  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-edit-type");

    if (btn) {
      idInput.value = btn.dataset.id;
      input.value = btn.dataset.name;

      modal.classList.remove("hidden");
      input.focus();
    }
  });

  cancel?.addEventListener("click", () => {
    modal.classList.add("hidden");
  });

  form?.addEventListener("submit", async (e) => {
    e.preventDefault();

    const id = idInput.value;
    const nombre = input.value.trim();

    if (!nombre) return;

    try {
      const res = await fetch("/products/types/update", {
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
// DELETE (IGUAL A SUPPLIERS)
// ================================
function initTypeDelete() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    const id = btn.dataset.id;

    if (!confirm("¿Eliminar tipo de tela?")) return;

    try {
      const res = await post("/products/types/delete", { id });

      if (!res.ok) throw new Error(res.error);

      const row = btn.closest("tr");

      row.style.opacity = "0";
      setTimeout(() => row.remove(), 300);

      Events.emit("alerts:show", {
        type: "success",
        message: "Tipo eliminado correctamente",
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

// ================================
// RESTORE TYPES
// ================================
function initTypeRestore() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    const id = btn.dataset.id;

    console.log("RESTORE:", id); // ✅ correcto

    try {
      const res = await post("/products/types/restore", { id });

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
      console.error(err);

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

  initDataTable("#tablaFabricTypes", "tipos de tela");
  initInlineCreateType();
  initAlerts();
  initEditModal();
  initTypeDelete();
  initTypeRestore();
});
