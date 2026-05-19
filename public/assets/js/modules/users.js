// //  Importar helper para peticiones POST
// import { post } from "../core/api.js";

// //  Importar sistema de eventos (tu arquitectura)
// import { Events } from "../core/events.js";

// /* =========================================================
//    🔹 VALIDACIÓN DE USERNAME (frontend + backend)
// ========================================================= */
// export function initUserValidation() {
//   const input = document.getElementById("username");
//   if (!input) return; //  si no existe, no hace nada

//   let timeout; // para controlar debounce (evitar muchas peticiones)

//   input.addEventListener("input", () => {
//     clearTimeout(timeout);

//     // NORMALIZAR INPUT
//     input.value = input.value.toLowerCase().replace(/\s/g, "");

//     const username = input.value;

//     // Obtener contenedor de mensaje
//     const msg = document.getElementById("username-msg");
//     if (!msg) return;

//     /* =============================
//            VALIDACIONES LOCALES
//         ============================== */

//     // mínimo
//     if (username.length < 4) {
//       showMsg(msg, "Mínimo 4 caracteres", "error");
//       input.dataset.exists = "true";
//       return;
//     }

//     // máximo
//     if (username.length > 10) {
//       showMsg(msg, "Máximo 10 caracteres", "error");
//       input.dataset.exists = "true";
//       return;
//     }

//     // formato (solo letras, números y _)
//     const regex = /^[a-z0-9_]+$/;

//     if (!regex.test(username)) {
//       showMsg(msg, "Solo letras, números y _", "error");
//       input.dataset.exists = "true";
//       return;
//     }

//     //  Mostrar estado de carga
//     showMsg(msg, "Verificando...", "loading");

//     /* =============================
//             VALIDACIÓN EN BACKEND
//         ============================== */

//     timeout = setTimeout(async () => {
//       try {
//         const res = await post("/api/users/check-username", { username });

//         if (!res || !res.success) {
//           showMsg(msg, "Error al validar", "error");
//           return;
//         }

//         if (res.exists) {
//           showMsg(msg, "❌ Usuario ya existe", "error");
//           input.dataset.exists = "true";
//         } else {
//           showMsg(msg, "✔️ Disponible", "success");
//           input.dataset.exists = "false";
//         }
//       } catch (error) {
//         console.error(error);
//         showMsg(msg, "Error de conexión", "error");
//       }
//     }, 400); // 🔹 debounce (400ms)
//   });
// }

// /* =========================================================
//     VALIDACIÓN DE PASSWORD
// ========================================================= */
// export function initPasswordValidation() {
//   const input = document.getElementById("password");
//   if (!input) return;

//   const msg = document.getElementById("password-msg");
//   if (!msg) return;

//   input.addEventListener("input", () => {
//     const value = input.value;

//     // vacío
//     if (value.length === 0) {
//       msg.textContent = "";
//       input.classList.remove("input-error");
//       return;
//     }

//     // mínimo
//     if (value.length < 4) {
//       msg.textContent = "Mínimo 4 caracteres";
//       msg.style.color = "red";
//       input.classList.add("input-error");
//       input.dataset.valid = "false";
//     } else {
//       msg.textContent = "✔️ Password válido";
//       msg.style.color = "lime";
//       input.classList.remove("input-error");
//       input.dataset.valid = "true";
//     }
//   });
// }

// /* =====================================
//    🔹 BLOQUEAR ENVÍO SI HAY ERRORES
// ======================================== */
// export function initUserFormValidation() {
//   const form = document.querySelector("form");
//   if (!form) return;

//   const username = document.getElementById("username");
//   const password = document.getElementById("password");

//   form.addEventListener("submit", (e) => {
//     // verificar username
//     if (username && username.dataset.exists === "true") {
//       e.preventDefault();
//       alert("El usuario ya existe o es inválido");
//       return;
//     }

//     // verificar password
//     if (password && password.dataset.valid === "false") {
//       e.preventDefault();
//       alert("El password no es válido");
//       return;
//     }
//   });
// }

// /* =========================================================
//    🔹 HELPER PARA MENSAJES
// ========================================================= */
// function showMsg(el, text, type) {
//   el.textContent = text;

//   // reset clases
//   el.className = "input-msg";

//   if (type === "error") {
//     el.style.color = "red";
//   }

//   if (type === "success") {
//     el.style.color = "lime";
//   }

//   if (type === "loading") {
//     el.style.color = "var(--primary)";
//     el.classList.add("loading");
//   }
// }

// /* =========================================================
//    🔹 TOGGLE ESTADO (LISTADO)
// ========================================================= */
// export function initUserToggle() {
//   document.addEventListener("click", async (e) => {
//     // if (!e.target.classList.contains("estado-toggle")) return;

//     // const el = e.target;
//     const el = e.target.closest(".estado-toggle");
//     if (!el) return;

//     const id = el.dataset.id;
//     const estadoActual = parseInt(el.dataset.estado);
//     const nuevoEstado = estadoActual === 1 ? 0 : 1;

//     // feedback visual
//     el.classList.add("loading");

//     try {
//       const res = await post("/users/toggle", {
//         id,
//         estado: nuevoEstado,
//       });

//       if (!res || !res.ok) {
//         throw new Error("Error backend");
//       }

//       // actualizar UI
//       el.dataset.estado = nuevoEstado;
//       el.textContent = nuevoEstado ? "Activo" : "Inactivo";

//       el.classList.toggle("active");
//       el.classList.toggle("inactive");

//       // 🔥 emitir evento global
//       Events.emit("users:updated", { id, estado: nuevoEstado });
//     } catch (error) {
//       console.error(error);
//       alert("Error al cambiar estado");
//     } finally {
//       el.classList.remove("loading");
//     }
//   });
// }

// /* ==========================
//    🔹 INTEGRACIÓN CON EVENTS
// ============================ */

// Events.on("users:create", () => {
//   initUserValidation();
//   initPasswordValidation();
//   initUserFormValidation();
// });

// Events.on("users:index", () => {
//   initUserToggle();
// });

// =========================================================
// 📦 IMPORTS
// =========================================================

// Helper para peticiones HTTP (POST)
import { post } from "../core/api.js";

// Sistema de eventos global (arquitectura)
import { Events } from "../core/events.js";

/* =========================================================
   🔹 DATATABLE PRO USUARIOS
========================================================= */
export function initTablaUsuarios() {
  const tabla = document.getElementById("tablaUsuarios");
  if (!tabla) return;

  new DataTable("#tablaUsuarios", {

    // 🔥 RESPONSIVE HÍBRIDO
    responsive: window.innerWidth > 460
      ? {
          details: {
            type: "column",
            target: 0,
          },
        }
      : false,

    autoWidth: false,

    columnDefs: [
      {
        className: "dtr-control",
        orderable: false,
        targets: 0,
      },

      { responsivePriority: 1, targets: 1 },
      { responsivePriority: 2, targets: 2 },
      { responsivePriority: 3, targets: 3 },

      { responsivePriority: 100, targets: 4 }, // foto primero en ocultar
      { responsivePriority: 4, targets: 5 },
      { responsivePriority: 5, targets: 6 },
      { responsivePriority: 6, targets: 7 },
    ],

    // 🔥 FIX
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

  console.log("DATATABLE PRO USERS");
}

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

    if (username.length > 10) {
      showMsg(msg, "Máximo 10 caracteres", "error");
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

  const msg = document.getElementById("password-msg");
  if (!msg) return;

  input.addEventListener("input", () => {
    const value = input.value;

    // campo vacío
    if (value.length === 0) {
      msg.textContent = "";
      input.classList.remove("input-error");
      return;
    }

    // mínimo
    if (value.length < 4) {
      msg.textContent = "Mínimo 4 caracteres";
      msg.style.color = "red";
      input.classList.add("input-error");
      input.dataset.valid = "false";
    } else {
      msg.textContent = "✔️ Password válido";
      msg.style.color = "lime";
      input.classList.remove("input-error");
      input.dataset.valid = "true";
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
export function initUserToggle() {
  document.addEventListener("click", async (e) => {
    // detectar click incluso en hijos (mejor práctica)
    const el = e.target.closest(".estado-toggle");
    if (!el) return;

    // evitar múltiples clicks mientras procesa
    if (el.classList.contains("loading")) return;

    const id = el.dataset.id;
    const estadoActual = parseInt(el.dataset.estado);
    const nuevoEstado = estadoActual === 1 ? 0 : 1;

    // feedback visual
    el.classList.add("loading");

    try {
      const res = await post("/users/toggle", {
        id,
        estado: nuevoEstado,
      });

      if (!res || !res.ok) {
        throw new Error("Error backend");
      }

      // =============================
      // ACTUALIZAR UI
      // =============================
      el.dataset.estado = nuevoEstado;
      el.textContent = nuevoEstado ? "Activo" : "Inactivo";

      el.classList.toggle("active");
      el.classList.toggle("inactive");

      // =============================
      // EVENTO GLOBAL
      // =============================
      Events.emit("users:updated", {
        id,
        estado: nuevoEstado,
      });
    } catch (error) {
      console.error(error);

      // usar sistema de alertas (mejor que alert)
      Events.emit("alerts:show", {
        type: "error",
        message: "Error al cambiar estado",
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

  initTablaUsuarios(); //
  initUserToggle();
});

//  visualizar imagen
Events.on("users:edit", () => {
  initImagePreview();
});
