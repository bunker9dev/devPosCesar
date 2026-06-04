import { Events } from "../core/events.js";

function initSupplierCreate() {
  const form = document.querySelector(".form-users");
  if (!form) return;

  const nombre = document.getElementById("nombre");
  const telefono = document.getElementById("telefono");
  const nit = document.getElementById("nit");

  const nombreMsg = document.getElementById("nombre-msg");
  const telMsg = document.getElementById("telefono-msg");
  const nitMsg = document.getElementById("nit-msg");

  let nitTimeout = null;
  let lastNit = "";

  // =====================================================
  // VALIDAR NOMBRE
  // =====================================================
  function validateNombre() {
    if (!nombre) return true;

    const val = nombre.value.trim();

    if (val.length < 2) {
      nombreMsg.textContent = "Mínimo 2 caracteres";
      nombreMsg.className = "input-msg error";
      nombre.classList.add("input-error");
      return false;
    }

    nombreMsg.textContent = "✔ válido";
    nombreMsg.className = "input-msg success";
    nombre.classList.remove("input-error");

    return true;
  }

  nombre?.addEventListener("input", validateNombre);

  // =====================================================
  // VALIDAR TELÉFONO
  // =====================================================
  telefono?.addEventListener("input", () => {
    const val = telefono.value.trim();

    if (val && val.length < 7) {
      telMsg.textContent = "Teléfono inválido";
      telMsg.className = "input-msg error";
      telefono.classList.add("input-error");
    } else {
      telMsg.textContent = "";
      telefono.classList.remove("input-error");
    }
  });

  // =====================================================
  // VALIDAR NIT (AJAX)
  // =====================================================
  async function validateNit(val) {
    try {
      const res = await fetch(
        `${window.BASE_URL}/suppliers/check-nit?nit=${encodeURIComponent(val)}`
      );

      const data = await res.json();

      if (!res.ok) throw new Error("Error en servidor");

      if (data.exists) {
        nitMsg.textContent = "⚠️ NIT ya registrado";
        nitMsg.className = "input-msg error";

        nit.dataset.valid = "false";
        nit.classList.add("input-error");
        nit.classList.remove("input-success");

        return false;
      } else {
        nitMsg.textContent = "✔ NIT disponible";
        nitMsg.className = "input-msg success";

        nit.dataset.valid = "true";
        nit.classList.add("input-success");
        nit.classList.remove("input-error");

        return true;
      }
    } catch (err) {
      nitMsg.textContent = "Error validando NIT";
      nitMsg.className = "input-msg error";

      nit.dataset.valid = "false";
      return false;
    }
  }

  nit?.addEventListener("input", () => {
    clearTimeout(nitTimeout);

    const val = nit.value.trim();

    if (val.length < 3) {
      nitMsg.textContent = "";
      nit.dataset.valid = "";
      return;
    }

    if (val === lastNit) return;

    nitMsg.textContent = "Validando...";
    nitMsg.className = "input-msg";

    nitTimeout = setTimeout(async () => {
      lastNit = val;
      await validateNit(val);
    }, 400);
  });

  // =====================================================
  // SUBMIT PRO (ANTI DUPLICADOS)
  // =====================================================
  form.addEventListener("submit", async (e) => {
    let valid = true;

    // validar nombre
    if (!validateNombre()) valid = false;

    // 🔥 FORZAR VALIDACIÓN FINAL DEL NIT
    if (nit && nit.value.trim().length >= 3) {
      const ok = await validateNit(nit.value.trim());
      if (!ok) valid = false;
    }

    if (!valid) {
      e.preventDefault();

      Events.emit("alerts:show", {
        type: "error",
        message: "Corrige los errores del formulario",
      });

      return;
    }

    // 🔥 UX: bloquear botón
    const btn = form.querySelector("button[type='submit']");
    if (btn) {
      btn.disabled = true;
      btn.textContent = "Guardando...";
    }
  });
}

// =====================================================
// INIT
// =====================================================
document.addEventListener("DOMContentLoaded", () => {
  initSupplierCreate();
});