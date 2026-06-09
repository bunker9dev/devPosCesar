// =========================================================
// MODULE: SUPPLIERS (PRO FIXED)
// =========================================================

import { post } from "../core/api.js";
import { Events } from "../core/events.js";
import { showMsg } from "../core/utils.js";

// =========================================================
// TOGGLE ESTADO
// =========================================================
function initSupplierToggle() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".toggle-supplier");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    if (!id || !url) return;

    // 🔒 evitar doble click
    if (btn.classList.contains("loading")) return;
    btn.classList.add("loading");

    try {
      const res = await post(url, { id });

      // 🔥 VALIDACIÓN CORRECTA
      if (!res || res.ok !== true) {
        throw new Error(res?.error || "Error al cambiar estado");
      }

      const estado = parseInt(res.estado);

      // =========================
      // UI UPDATE
      // =========================
      btn.dataset.estado = estado;

      btn.classList.remove("active", "inactive");

      if (estado === 1) {
        btn.classList.add("active");
        btn.textContent = btn.dataset.labelActive || "Activo";
      } else {
        btn.classList.add("inactive");
        btn.textContent = btn.dataset.labelInactive || "Inactivo";
      }

      // =========================
      // EVENTO GLOBAL
      // =========================
      Events.emit("suppliers:updated", { id, estado });
    } catch (err) {
      console.error(err);

      Events.emit("alerts:show", {
        type: "error",
        message: err.message || "Error al cambiar estado",
      });
    } finally {
      btn.classList.remove("loading");
    }
  });
}

// =========================================================
// DELETE
// =========================================================
let deleteInit = false;

function initSupplierDelete() {
  if (deleteInit) return;
  deleteInit = true;

  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;
    const name = btn.dataset.name;

    if (!confirm(`¿Eliminar proveedor "${name}"?`)) return;

    // evita doble click
    if (btn.classList.contains("loading")) return;
    btn.classList.add("loading");

    try {
      const res = await post(url, { id });

      if (!res || res.ok !== true) {
        throw new Error(res?.error || "Error al eliminar");
      }

      location.reload();
    } catch (err) {
      console.error(err);

      Events.emit("alerts:show", {
        type: "error",
        message: err.message || "Error al eliminar",
      });
    } finally {
      btn.classList.remove("loading");
    }
  });
}

// =========================================================
// RESTORE
// =========================================================
function initSupplierRestore() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    try {
      const res = await post(url, { id });

      if (!res || res.ok !== true) {
        throw new Error(res?.error || "Error al eliminar");
      }

      location.reload();
    } catch (err) {
      Events.emit("alerts:show", {
        type: "error",
        message: err.message || "Error al restaurar",
      });
    }
  });
}

// =========================================================
// VALIDACIÓN NIT (AJAX)
// =========================================================
function initSupplierValidation() {
  const input = document.getElementById("nit");
  const msg = document.getElementById("nit-msg");

  if (!input || !msg) return;

  let timeout;

  input.dataset.exists = "false";

  input.addEventListener("input", () => {
    clearTimeout(timeout);

    const nit = input.value.trim().toLowerCase();
    input.value = nit;

    if (nit.length < 5) {
      showMsg(msg, "Mínimo 5 caracteres", "error");
      input.dataset.exists = "true";
      return;
    }

    showMsg(msg, "Verificando...", "loading");

    timeout = setTimeout(async () => {
      try {
        const res = await post("/suppliers/check-nit", { nit });

        if (!res.ok) throw new Error();

        if (res.exists) {
          showMsg(msg, "❌ NIT ya registrado", "error");
          input.dataset.exists = "true";
        } else {
          showMsg(msg, "✔️ Disponible", "success");
          input.dataset.exists = "false";
        }
      } catch {
        showMsg(msg, "Error de validación", "error");
        input.dataset.exists = "true";
      }
    }, 400);
  });
}

// =========================================================
// VALIDACIÓN SUBMIT
// =========================================================
function initFormValidation() {
  const form = document.querySelector(".form-suppliers");
  const input = document.getElementById("nit");

  if (!form || !input) return;

  form.addEventListener("submit", (e) => {
    if (input.dataset.exists === "true") {
      e.preventDefault();

      Events.emit("alerts:show", {
        type: "error",
        message: "El NIT ya está registrado",
      });

      return;
    }

    if (!input.value.trim()) {
      e.preventDefault();

      Events.emit("alerts:show", {
        type: "error",
        message: "El NIT es obligatorio",
      });
    }
  });
}

// =========================================================
// INIT EVENTS
// =========================================================
Events.on("suppliers:index", () => {
  initSupplierToggle();
  initSupplierDelete();
  initSupplierRestore();
});

Events.on("suppliers:form", () => {
  initSupplierValidation();
  initFormValidation();
});
