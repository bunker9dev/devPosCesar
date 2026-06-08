// =========================================================
// IMPORTS
// =========================================================
import { Events } from "../core/events.js";
import { post } from "../core/api.js";
import { showToast } from "./alerts.js";

// =========================================================
//  DATATABLE
// =========================================================
export function initTablaUsuarios() {
  const tabla = document.getElementById("tablaUsuarios");
  if (!tabla) return;

  const isMobile = window.matchMedia("(max-width: 460px)").matches;

  if ($.fn.DataTable.isDataTable("#tablaUsuarios")) {
    $("#tablaUsuarios").DataTable().destroy();
  }

  new DataTable("#tablaUsuarios", {
    responsive: isMobile
      ? false
      : {
          details: {
            type: "column",
            target: 0,
          },
        },

    autoWidth: false,

    columnDefs: [
      { className: "dtr-control", orderable: false, targets: 0 },
      { responsivePriority: 1, targets: 1 },
      { responsivePriority: 2, targets: 2 },
      { responsivePriority: 3, targets: 3 },
      { responsivePriority: 100, targets: 7 },
      { responsivePriority: 99, targets: 4 },
      { responsivePriority: 98, targets: 6 },
      { responsivePriority: 97, targets: 5 },
    ],

    order: [[1, "asc"]],

    dom: "Bfrtip",

    buttons: [
      { extend: "excel", text: "Excel" },
      { extend: "pdf", text: "PDF" },
      { extend: "print", text: "Print" },
    ],

    language: {
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: "Mostrando _START_ a _END_ de _TOTAL_ usuarios",
      paginate: {
        next: "→",
        previous: "←",
      },
    },
  });
}

// =========================================================
//  VALIDACIÓN USERNAME
// =========================================================
export function initUserValidation() {
  const input = document.getElementById("username");
  if (!input) return;

  const msg = document.getElementById("username-msg");
  if (!msg) return;

  let timeout = null;

  input.addEventListener("input", () => {
    clearTimeout(timeout);

    // 🔥 normalizar
    input.value = input.value.toLowerCase().replace(/\s/g, "");
    const username = input.value;

    // 🔥 validaciones locales
    if (username.length < 4) {
      showMsg(msg, "Mínimo 4 caracteres", "error");
      input.dataset.exists = "true";
      return;
    }

    if (username.length > 20) {
      showMsg(msg, "Máximo 20 caracteres", "error");
      input.dataset.exists = "true";
      return;
    }

    const regex = /^[a-z0-9_]+$/;

    if (!regex.test(username)) {
      showMsg(msg, "Solo letras, números y _", "error");
      input.dataset.exists = "true";
      return;
    }

    // 🔥 feedback inmediato
    showMsg(msg, "Verificando...", "loading");

    // 🔥 debounce
    timeout = setTimeout(async () => {
      try {
        const res = await post("/users/check-username", { username });

        // 🔥 validar respuesta
        if (!res || typeof res.exists === "undefined") {
          showMsg(msg, "Error al validar", "error");
          input.dataset.exists = "true";
          return;
        }

        // 🔥 resultado
        if (res.exists) {
          showMsg(msg, "❌ Usuario ya existe", "error");
          input.dataset.exists = "true";
        } else {
          showMsg(msg, "✔️ Disponible", "success");
          input.dataset.exists = "false";
        }
      } catch (error) {
        console.error(error);
        showMsg(msg, "Error de conexión", "error");
        input.dataset.exists = "true";
      }
    }, 400);
  });
}

// =========================================================
//  PASSWORD
// =========================================================
export function initPasswordValidation() {
  const input = document.getElementById("password");
  if (!input) return;

  const msg = input.parentElement.querySelector(".input-msg");

  input.addEventListener("input", () => {
    const value = input.value;

    if (value.length === 0) {
      msg.textContent = "";
      input.dataset.valid = "true";
      input.classList.remove("input-error");
      return;
    }

    if (value.length < 6) {
      msg.textContent = "Mínimo 6 caracteres";
      msg.style.color = "red";
      input.dataset.valid = "false";
      input.classList.add("input-error");
    } else {
      msg.textContent = "✔ Password válido";
      msg.style.color = "lime";
      input.dataset.valid = "true";
      input.classList.remove("input-error");
    }
  });
}

// =========================================================
//  FORM VALIDATION
// =========================================================
export function initUserFormValidation() {
  const form = document.querySelector(".form-users");
  if (!form) return;

  const username = document.getElementById("username");
  const password = document.getElementById("password");

  form.addEventListener("submit", (e) => {
    if (username && username.dataset.exists === "true") {
      e.preventDefault();

      Events.emit("alerts:show", {
        type: "error",
        message: "El usuario ya existe o es inválido",
      });

      return;
    }

    if (password && password.dataset.valid === "false") {
      e.preventDefault();

      Events.emit("alerts:show", {
        type: "error",
        message: "El password no es válido",
      });
    }
  });
}

// =========================================================
//  TOGGLE
// =========================================================
export function initUserToggle() {
  document.addEventListener("click", async (e) => {
    const el = e.target.closest(".toggle-user");
    if (!el) return;

    const id = el.dataset.id;
    const url = el.dataset.url;

    try {
      const response = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${id}`,
      });

      const data = await response.json();

      if (!data.ok) {
        alert(data.error || "Error");
        return;
      }

      // ESTADO NUEVO
      const estado = parseInt(data.estado);

      // ACTUALIZAR DATASET
      el.dataset.estado = estado;

      // LIMPIAR CLASES
      el.classList.remove("active", "inactive", "deleted");

      // ACTUALIZAR UI
      switch (estado) {
        case 1:
          el.classList.add("active");
          el.textContent = "Activo";
          break;

        case 2:
          el.classList.add("inactive");
          el.textContent = "Inactivo";
          break;

        case 0:
          el.classList.add("deleted");
          el.textContent = "Eliminado";
          break;
      }
    } catch (error) {
      console.error(error);
      alert("Error de conexión");
    }
  });
}
// =========================================================
//  DELETE
// =========================================================
export function initUserDelete() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;
    const name = btn.dataset.name;

    // 🔥 confirmación
    if (!confirm(`¿Eliminar usuario "${name}"?`)) return;

    try {
      const response = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${id}`,
      });

      const data = await response.json();

      if (!data.ok) {
        showToast(data.error || "Error al eliminar", "error");
        return;
      }

      // 🔥 eliminar fila SIN reload
      const row = btn.closest("tr");
      // 🔥 cambiar estado visual en lugar de eliminar fila

      const estadoBadge = row.querySelector(".toggle-user");

      if (estadoBadge) {
        estadoBadge.classList.remove("active", "inactive");
        estadoBadge.classList.add("deleted");
        estadoBadge.textContent = "Eliminado";
      }

      // 🔥 limpiar acciones
      const actions = row.querySelector(".actions");

      if (actions) {
        // 🔥 SOLO SUPER VE RESTORE
        const actions = row.querySelector(".actions");

        if (actions) {
          if (window.USER_PERMISSIONS?.restore) {
            actions.innerHTML = `
        <button class="btn-action restore btn-restore"
            data-id="${id}"
            data-url="${BASE_URL}/users/restore">
            Restaurar
        </button>
    `;
          } else {
            actions.innerHTML = ``;
          }
        }
      }

      showToast("Usuario eliminado", "success");
    } catch (error) {
      console.error(error);
      showToast("Error de conexión", "error");
    }
  });
}

// =========================================================
//  RESTORE
// =========================================================
export function initUserRestore() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    try {
      const res = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${id}`,
      });

      const data = await res.json();

      if (!data.ok) {
        showToast(data.error || "Error", "error");
        return;
      }

      const row = btn.closest("tr");

      // restaurar estado
      const estadoBadge = row.querySelector(".toggle-user");

      if (estadoBadge) {
        estadoBadge.classList.remove("deleted");
        estadoBadge.classList.add("active");
        estadoBadge.textContent = "Activo";
      }

      // restaurar botones
      const actions = row.querySelector(".actions");

      actions.innerHTML = `
                <a href="${BASE_URL}/users/edit?id=${id}" class="btn-action edit">
                    Editar
                </a>
                <button class="btn-action delete btn-delete"
                    data-id="${id}"
                    data-url="${BASE_URL}/users/delete">
                    Eliminar
                </button>
            `;

      showToast("Usuario restaurado", "success");
    } catch (err) {
      console.error(err);
      showToast("Error", "error");
    }
  });
}
// =========================================================
//  IMAGE PREVIEW
// =========================================================
export function initImagePreview() {
  const input = document.querySelector('input[name="imagen"]');
  const preview = document.getElementById("preview");

  if (!input || !preview) return;

  input.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();

    reader.onload = (e) => {
      preview.src = e.target.result;
    };

    reader.readAsDataURL(file);
  });
}

// =========================================================
//  HELPER
// =========================================================
function showMsg(el, text, type) {
  el.textContent = text;
  el.className = "input-msg";

  if (type === "error") el.style.color = "red";
  if (type === "success") el.style.color = "lime";
  if (type === "loading") {
    el.style.color = "var(--primary)";
    el.classList.add("loading");
  }
}

// =========================================================
// EVENTS
// =========================================================
Events.on("users:create", () => {
  initUserValidation();
  initPasswordValidation();
  initUserFormValidation();
});

Events.on("users:index", () => {
  initTablaUsuarios();
  initUserToggle();
  initUserDelete();
  initUserRestore();
});

Events.on("users:edit", () => {
  initImagePreview();
});
