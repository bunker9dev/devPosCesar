console.log("USERS JS CARGADO 🔥");

// =========================================================
// IMPORTS
// =========================================================
import { Events } from "../core/events.js";
import { post } from "../core/api.js";


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
//  VALIDACIÓN USERNAME
// =========================================================
export function initUserValidation() {
  const input = document.getElementById("username");
  const msg = document.getElementById("username-msg");

  if (!input || !msg) return;

  let timeout = null;

  input.addEventListener("input", () => {
    clearTimeout(timeout);

    input.value = input.value.toLowerCase().replace(/\s/g, "");
    const username = input.value;

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

    showMsg(msg, "Verificando...", "loading");

    timeout = setTimeout(async () => {
      try {
        const res = await post("/users/check-username", { username });
        // console.log("RESPONSE:", res);

        if (!res || typeof res.exists === "undefined") {
          showMsg(msg, "Error al validar", "error");
          input.dataset.exists = "true";
          return;
        }

        if (res.exists) {
          showMsg(msg, "❌ Usuario ya fue usado", "error");
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
let initialized = false;
export function initUserFormValidation() {
  if (initialized) return;
  initialized = true;
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
//  IMAGE PREVIEW
// =========================================================
export function initImagePreview() {
  const input = document.querySelector('input[name="imagen"]');
  const preview = document.getElementById("preview");

  if (!input || !preview) return;

  // FORZAR CHANGE SI ES MISMO ARCHIVO
  input.addEventListener("click", () => {
    input.value = "";
  });

  input.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (!file) return;

    //  VALIDAR TIPO
    if (!file.type.startsWith("image/")) {
      Events.emit("alerts:show", {
        type: "error",
        message: "El archivo debe ser una imagen",
      });
      input.value = "";
      return;
    }

    //  VALIDAR TAMAÑO
    const maxSize = 2 * 1024 * 1024;

    if (file.size > maxSize) {
      const sizeMB = (file.size / 1024 / 1024).toFixed(2);

      Events.emit("alerts:show", {
        type: "error",
        message: `La imagen pesa ${sizeMB}MB (máx 2MB)`,
      });

      input.value = "";
      return;
    }

    // PREVIEW
    const reader = new FileReader();

    reader.onload = (ev) => {
      preview.src = ev.target.result;
    };

    reader.readAsDataURL(file);
  });

  //  UX: CLICK EN IMAGEN ABRE SELECTOR
  preview.addEventListener("click", () => input.click());
}

// =========================================================
//  TOGGLE
// =========================================================
let toggleInitialized = false;

export function initUserToggle() {
  if (toggleInitialized) return;
  toggleInitialized = true;

  document.addEventListener("click", async (e) => {
    // console.log("INIT VALIDATION 🔥");
    initUserValidation();

    const el = e.target.closest(".toggle-user");
    if (!el) return;

    const id = el.dataset.id;
    const url = el.dataset.url;

    try {
      const response = await fetch(url, {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `id=${id}`,
      });

      const data = await response.json();

      if (!data.ok) {
        showToast(data.error || "Error", "error");
        return;
      }

      const estado = parseInt(data.estado);

      el.dataset.estado = estado;
      el.classList.remove("active", "inactive", "deleted");

      if (estado === 1) {
        el.classList.add("active");
        el.textContent = "Activo";
      } else if (estado === 2) {
        el.classList.add("inactive");
        el.textContent = "Inactivo";
      } else {
        el.classList.add("deleted");
        el.textContent = "Eliminado";
      }
    } catch (error) {
      console.error(error);
      showToast("Error de conexión", "error");
    }
  });
}

// =========================================================
// DELETE USER 
// =========================================================
let deleteInitialized = false;
export function initUserDelete() {
  if (deleteInitialized) return;
  deleteInitialized = true;

  console.log("INIT DELETE 🔥");

  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    console.log("CLICK DELETE 🔥");

    const id = btn.dataset.id;
    const url = btn.dataset.url;
    const name = btn.dataset.name;

    if (!id || !url) return;

    if (!confirm(`¿Eliminar usuario ${name}?`)) return;

    try {
      const response = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${id}`,
      });

      const data = await response.json();
      console.log("RESPUESTA:", data);

      if (!data.ok) {
        showToast(data.error || "Error", "error");
        return;
      }

      const row = btn.closest("tr");

      if (row) {
        row.style.opacity = "0";
        setTimeout(() => row.remove(), 300);
      }

      showToast("Eliminado", "success");
    } catch (err) {
      console.error(err);
    }
  });
}

// =========================================================
// RESTORE USER 
// =========================================================

export function initUserRestore() {
  console.log("INIT RESTORE 🔥");

  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-restore");
    if (!btn) return;

    console.log("CLICK RESTORE 🔥");

    const id = btn.dataset.id;
    const url = btn.dataset.url;

    if (!id || !url) {
      console.error("Falta ID o URL");
      return;
    }

    try {
      const response = await fetch(url, {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: `id=${id}`,
      });

      const data = await response.json();

      console.log("RESPUESTA RESTORE:", data);

      if (!data.ok) {
        alert(data.error || "Error al restaurar");
        return;
      }

      // OPCIÓN SIMPLE: recargar
      location.reload();
    } catch (error) {
      console.error(error);
      alert("Error de conexión");
    }
  });
}

// =========================================================
//  INIT MODULE (EVENT DRIVEN)
// =========================================================
Events.on("users:create", () => {
  initUserValidation();
  initPasswordValidation();
  initUserFormValidation();
  initImagePreview();
});

Events.on("users:edit", () => {
  initUserValidation();
  initPasswordValidation();
  initUserFormValidation();
  initImagePreview();
});

Events.on("users:index", () => {
  console.log("EVENT users:index ");
  initUserToggle();
  initUserDelete();
  initUserRestore()
});
