import { post } from "../core/api.js";

export function initUserValidation() {
  const input = document.getElementById("username");
  if (!input) return;

  let timeout;

  input.addEventListener("input", () => {
    clearTimeout(timeout);

    // NORMALIZAR
    input.value = input.value.toLowerCase().replace(/\s/g, "");

    const username = input.value;
    const msg = input.parentNode.querySelector(".input-msg");

    // VALIDACIONES LOCALES

    // mínimo
    if (username.length < 4) {
      showMsg(msg, "Mínimo 4 caracteres", "error");
      input.dataset.exists = "true";
      return;
    }

    // máximo
    if (username.length > 10) {
      showMsg(msg, "Máximo 10 caracteres", "error");
      input.dataset.exists = "true";
      return;
    }

    // formato
    const regex = /^[a-z0-9_]+$/;

    if (!regex.test(username)) {
      showMsg(msg, "Solo letras, números y _", "error");
      input.dataset.exists = "true";
      return;
    }

    // LOADER
    showMsg(msg, "Verificando...", "loading");

    //  VALIDACIÓN BD
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
    }, 400);
  });
}

export function initPasswordValidation() {

    const input = document.getElementById("password");
    if (!input) return;

    const msg = input.parentNode.querySelector(".input-msg");

    input.addEventListener("input", () => {

        const value = input.value;

        if (value.length === 0) {
            msg.textContent = "";
            input.classList.remove("input-error");
            return;
        }

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



// helper
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
