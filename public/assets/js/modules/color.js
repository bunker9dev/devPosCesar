// =========================================================
// IMPORTS
// =========================================================
import { Events } from "../core/events.js";

// =========================================================
// STATE
// =========================================================
let deleteColorId = null;
let deleteColorRow = null;
let colorsInitialized = false;

// =========================================================
// HELPERS
// =========================================================
function notify(message, type = "success") {
  Events.emit("alerts:show", { type, message });
}

async function safeFetch(url, options) {
  try {
    const response = await fetch(url, options);
    const text = await response.text();

    let data;
    try {
      data = JSON.parse(text);
    } catch (e) {
      console.error("❌ Respuesta inválida:", text);
      notify("Error del servidor", "error");
      return null;
    }

    if (!response.ok) {
      notify(data.error || `Error HTTP ${response.status}`, "error");
      return null;
    }

    return data;
  } catch (error) {
    console.error(error);
    notify("Error de conexión", "error");
    return null;
  }
}

// =========================================================
// CREATE COLOR
// =========================================================
function initColorCreate() {
  const form = document.getElementById("formCreateColor");
  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const nombre = form.querySelector("[name='nombre']").value;

    const data = await safeFetch("/fabric-colors/store", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `nombre=${encodeURIComponent(nombre)}`,
    });

    if (!data) return;

    if (!data.ok) {
      notify(data.error || "Error", "error");
      return;
    }

    notify("Color creado", "success");
    location.reload();
  });
}

// =========================================================
// TOGGLE COLOR 
// =========================================================
function initColorToggle() {
  document.addEventListener("click", async (e) => {
    const el = e.target.closest(".toggle-color");
    if (!el) return;

    const id = el.dataset.id;

    const data = await safeFetch("/fabric-colors/toggle", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${id}`,
    });

    if (!data) return;

    if (!data.ok) {
      notify(data.error || "Error al cambiar estado", "error");
      return;
    }

    const estado = parseInt(data.estado);

    el.dataset.estado = estado;
    el.classList.remove("active", "inactive", "deleted");

    if (estado === 1) {
      el.classList.add("active");
      el.textContent = "Activo";
    } else {
      el.classList.add("inactive");
      el.textContent = "Inactivo";
    }

    notify("Estado actualizado", "success");
  });
}

// =========================================================
// EDIT MODAL
// =========================================================
function initColorEdit() {
  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-edit");
    if (!btn) return;

    const modal = document.getElementById("modalEditColor");
    const inputId = document.getElementById("editColorId");
    const inputName = document.getElementById("editColorName");

    if (!modal || !inputId || !inputName) {
      console.error("❌ Modal edit no encontrado");
      return;
    }

    inputId.value = btn.dataset.id;
    inputName.value = btn.dataset.name;

    modal.classList.remove("hidden");
  });
}

// =========================================================
// UPDATE COLOR
// =========================================================
function initColorUpdate() {
  const form = document.getElementById("formEditColor");
  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const id = document.getElementById("editColorId").value;
    const nombre = document.getElementById("editColorName").value;

    const data = await safeFetch(`/fabric-colors/update`, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${id}&nombre=${encodeURIComponent(nombre)}`,
    });

    if (!data) return;

    if (!data.ok) {
      notify(data.error || "Error", "error");
      return;
    }

    const row = document.querySelector(`tr[data-id="${id}"]`);
    const cell = row?.querySelector('td[data-label="Color"]');
    if (cell) cell.textContent = nombre;

    document.getElementById("modalEditColor").classList.add("hidden");
    notify("Color actualizado", "success");
  });
}

// =========================================================
// DELETE MODAL
// =========================================================
function initColorDeleteModal() {
  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    deleteColorId = btn.dataset.id;
    deleteColorRow = btn.closest("tr");

    const msg = document.getElementById("deleteColorMessage");
    const modal = document.getElementById("modalDeleteColor");

    if (msg) {
      msg.textContent = `¿Eliminar color ${btn.dataset.name}?`;
    }

    if (modal) {
      modal.classList.remove("hidden");
    }
  });
}

// =========================================================
// CONFIRM DELETE 
// =========================================================
function initConfirmDelete() {
  const btn = document.getElementById("btnConfirmDeleteColor");
  if (!btn) return;

  btn.addEventListener("click", async () => {
    if (!deleteColorId) return;

    const data = await safeFetch(`/fabric-colors/delete`, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${deleteColorId}`,
    });

    document.getElementById("modalDeleteColor").classList.add("hidden");

    if (!data) return;

    if (!data.ok) {
      notify(data.error || "Error al eliminar", "error");
      return;
    }

    if (deleteColorRow) {
      const badge = deleteColorRow.querySelector(".toggle-color, .badge");
      if (badge) {
        badge.outerHTML = `<span class="badge deleted">Eliminado</span>`;
      }

      const actions = deleteColorRow.querySelector('td[data-label="Acciones"]');
      if (actions) actions.innerHTML = "";

      deleteColorRow.classList.add("deleted");
    }

    notify("Color eliminado", "success");

    deleteColorId = null;
    deleteColorRow = null;
  });
}

// =========================================================
// RESTORE — ahora actualiza en sitio, sin recargar
// =========================================================
function initColorRestore() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    const data = await safeFetch(btn.dataset.url, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: `id=${btn.dataset.id}`,
    });

    if (!data) return;

    if (!data.ok) {
      notify(data.error || "Error al restaurar", "error");
      return;
    }

    notify("Color restaurado", "success");
    location.reload();
  });
}

// =========================================================
// CLOSE MODALS
// =========================================================
function initCloseModals() {
  document.addEventListener("click", (e) => {
    if (e.target.matches(".modal-overlay") || e.target.matches(".btn-cancel")) {
      document.querySelectorAll(".modal").forEach((m) => {
        m.classList.add("hidden");
      });
    }
  });
}

// =========================================================
// INIT (con guard contra doble inicialización)
// =========================================================
Events.on("colors:index", () => {
  if (colorsInitialized) return;
  colorsInitialized = true;

  initColorCreate();
  initColorToggle();
  initColorEdit();
  initColorUpdate();
  initColorDeleteModal();
  initConfirmDelete();
  initColorRestore();
  initCloseModals();
});