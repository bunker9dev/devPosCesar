// =========================================================
// 📦 IMPORTS
// =========================================================

// Sistema de eventos global (arquitectura)
import { Events } from "../core/events.js";

// Helper para peticiones HTTP (POST)
import { post } from "../core/api.js";

export function initTablaUsuarios() {
  const tabla = document.getElementById("tablaUsuarios");
  if (!tabla) return;

  const isMobile = window.matchMedia("(max-width: 460px)").matches;

  // 🔥 destruir si ya existe (CLAVE)
  if ($.fn.DataTable.isDataTable("#tablaUsuarios")) {
    $("#tablaUsuarios").DataTable().destroy();
  }

  // 🔥 inicializar
  new DataTable("#tablaUsuarios", {
    /* =====================================================
       🔹 RESPONSIVE HÍBRIDO
    ===================================================== */
    responsive: isMobile
      ? false // 🔥 MOBILE → usamos cards CSS
      : {
          details: {
            type: "column",
            target: 0,
          },
        },

    autoWidth: false,

    /* =====================================================
       🔹 PRIORIDADES DE COLAPSO
    ===================================================== */
    columnDefs: [
      {
        className: "dtr-control",
        orderable: false,
        targets: 0,
      },

      { responsivePriority: 1, targets: 1 }, // ID
      { responsivePriority: 2, targets: 2 }, // Usuario
      { responsivePriority: 3, targets: 3 }, // Nombre

      { responsivePriority: 100, targets: 7 },
      { responsivePriority: 99, targets: 4 },
      { responsivePriority: 98, targets: 6 },
      { responsivePriority: 97, targets: 5 },
    ],

    /* =====================================================
       🔹 ORDEN
    ===================================================== */
    order: [[1, "asc"]],

    /* =====================================================
       🔹 BOTONES
    ===================================================== */
    dom: "Bfrtip",

    buttons: [
      { extend: "excel", text: "Excel" },
      { extend: "pdf", text: "PDF" },
      { extend: "print", text: "Print" },
    ],

    /* =====================================================
       🔹 IDIOMA
    ===================================================== */
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

  console.log("DATATABLE PRO USERS");
}

/* =========================================================
   🔹 EVENT INIT (ARQUITECTURA)
========================================================= */
Events.on("users:index", () => {
  initTablaUsuarios();
});

/* =========================================================
   🔹 RELOAD RESPONSIVE (PRO)
========================================================= */

let resizeTimer;
let lastMode = null;

window.addEventListener("resize", () => {
  clearTimeout(resizeTimer);

  resizeTimer = setTimeout(() => {
    const isMobile = window.matchMedia("(max-width: 460px)").matches;

    // 🔥 SOLO reinicia si cambia de modo (evita lag)
    if (isMobile !== lastMode) {
      lastMode = isMobile;

      console.log("🔄 Cambio de modo → reiniciando tabla");

      initTablaUsuarios();
    }
  }, 300);
});

// =========================================================
// 🔹 VALIDACIÓN DE USERNAME
// =========================================================
export function initUserValidation() {
  const input = document.getElementById("username");
  if (!input) return; // si no existe en la vista, salir

  let timeout; // debounce para evitar muchas peticiones

  input.addEventListener("input", () => {
    clearTimeout(timeout);

    // Normalizar (minúsculas + sin espacios)
    input.value = input.value.toLowerCase().replace(/\s/g, "");
    const username = input.value;

    const msg = document.getElementById("username-msg");
    if (!msg) return;

    // =============================
    // VALIDACIONES LOCALES
    // =============================

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

    // Mostrar estado de carga
    showMsg(msg, "Verificando...", "loading");

    // =============================
    // VALIDACIÓN EN BACKEND
    // =============================
    timeout = setTimeout(async () => {
      try {
        const res = await post("/api/users/check-username", { username });

        if (!res || !res.success) {
          showMsg(msg, "Error al validar", "error");
          return;
        }

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
      }
    }, 400); // debounce
  });
}

// =========================================================
// 🔹 VALIDACIÓN DE PASSWORD
// =========================================================

export function initPasswordValidation() {
  const input = document.getElementById("password");
  if (!input) return;

  // 🔥 buscar el mensaje RELATIVO al input
  const msg = input.parentElement.querySelector(".input-msg");

  input.addEventListener("input", () => {
    const value = input.value;

    // 👉 en EDIT: si está vacío → no validar
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
// BLOQUEAR ENVÍO SI HAY ERRORES
// =========================================================
export function initUserFormValidation() {
  const form = document.querySelector("form");
  if (!form) return;

  const username = document.getElementById("username");
  const password = document.getElementById("password");

  form.addEventListener("submit", (e) => {
    // validar username
    if (username && username.dataset.exists === "true") {
      e.preventDefault();
      alert("El usuario ya existe o es inválido");
      return;
    }

    // validar password
    if (password && password.dataset.valid === "false") {
      e.preventDefault();
      alert("El password no es válido");
      return;
    }
  });
}

// =========================================================
//  TOGGLE DE ESTADO (ACTIVO / INACTIVO)
// =========================================================
function initUserToggle() {
  document.addEventListener("click", async (e) => {
    const el = e.target.closest(".estado-toggle");
    if (!el) return;

    const estadoActual = parseInt(el.dataset.estado);

    if (estadoActual === 0) return;

    if (el.classList.contains("loading")) return;

    const id = el.dataset.id;

    el.classList.add("loading");

    try {
      const res = await post("/users/toggle", { id });

      if (!res.ok) throw new Error(res.error);

      // =============================
      // ACTUALIZAR UI
      // =============================
      el.dataset.estado = res.estado;
      el.textContent = res.estado_texto;

      el.classList.remove("active", "inactive");

      if (res.estado == 1) {
        el.classList.add("active");
      } else {
        el.classList.add("inactive");
      }

      // =============================
      // 🔥 EVENTO GLOBAL (AQUÍ VA)
      // =============================
      Events.emit("users:updated", {
        id,
        estado: res.estado,
      });
    } catch (error) {
      console.error(error);

      Events.emit("alerts:show", {
        type: "error",
        message: error.message || "Error al cambiar estado",
      });
    } finally {
      el.classList.remove("loading");
    }
  });
}

// =========================================================
//  HELPER PARA MENSAJES
// =========================================================
function showMsg(el, text, type) {
  el.textContent = text;

  // reset clases
  el.className = "input-msg";

  if (type === "error") {
    el.style.color = "red";
  }

  if (type === "success") {
    el.style.color = "lime";
  }

  if (type === "loading") {
    el.style.color = "var(--primary)";
    el.classList.add("loading");
  }
}

// =========================================================
//  PREVIEW IMAGENES
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
//  ELIMINAR USUARIOS
// =========================================================

// function initUserDelete() {
//   document.addEventListener("click", async (e) => {

//     const btn = e.target.closest(".delete");
//     if (!btn) return;

//     const id = btn.dataset.id;

//     if (!confirm("¿Eliminar usuario?")) return;

//     try {
//       const res = await post("/users/delete", { id });

//       if (!res.ok) throw new Error(res.error);

//       const row = btn.closest("tr");
//       const badge = row.querySelector(".estado-toggle");

//       // 🔥 actualizar UI (igual que restore pero inverso)
//       badge.dataset.estado = 0;
//       badge.textContent = "Eliminado";

//       badge.classList.remove("active", "inactive");
//       badge.classList.add("deleted");

//       btn.remove(); // quitar botón eliminar

//       // 🔥 opcional: evento global
//       Events.emit("users:updated", {
//         id,
//         estado: 0,
//       });

//     } catch (err) {
//       console.error(err);

//       Events.emit("alerts:show", {
//         type: "error",
//         message: err.message || "Error al eliminar",
//       });
//     }

//   });
// }
function initUserDelete() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".delete");
    if (!btn) return;

    const id = btn.dataset.id;

    // 🔍 DEBUG AQUÍ
    console.log("DELETE ID:", id);

    if (!confirm("¿Eliminar usuario?")) return;

    try {
      // 🔍 DEBUG ANTES DEL POST
      console.log("Enviando petición...");

      const res = await post("/users/delete", { id });

      // 🔍 DEBUG RESPUESTA
      console.log("RESPUESTA:", res);

      if (!res.ok) throw new Error(res.error);

      const row = btn.closest("tr");
      const badge = row.querySelector(".estado-toggle");

      badge.dataset.estado = 0;
      badge.textContent = "Eliminado";

      badge.classList.remove("active", "inactive");
      badge.classList.add("deleted");

      btn.remove();
    } catch (err) {
      console.error("ERROR:", err);
    }
  });
}

// =========================================================
//  RESTAURAR USUARIOS ELIMIDANDOS
// =========================================================

export function initUserRestore() {
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    console.log("CLICK RESTORE"); // 🔥 DEBUG

    const id = btn.dataset.id;

    if (!confirm("¿Restaurar usuario?")) return;

    try {
      const res = await post("/users/restore", { id });

      console.log(res); // 🔥 DEBUG

      if (!res.ok) throw new Error(res.error);

      const row = btn.closest("tr");
      const badge = row.querySelector(".estado-toggle");

      badge.dataset.estado = 2;
      badge.textContent = "Inactivo";

      badge.classList.remove("deleted");
      badge.classList.add("inactive");

      btn.remove();
    } catch (err) {
      console.error(err);
    }
  });
}

// =========================================================
//  INTEGRACIÓN CON EVENTS (ARQUITECTURA)
// =========================================================

// Página: crear usuario
Events.on("users:create", () => {
  initUserValidation();
  initPasswordValidation();
  initUserFormValidation();
});

// Página: listado usuarios
Events.on("users:index", () => {
  console.log("INIT USERS MODULE");

  initTablaUsuarios();
  initUserToggle();
  initUserRestore();
  initUserDelete();
});

//  visualizar imagen
Events.on("users:edit", () => {
  initImagePreview();
});
