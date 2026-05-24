import { Events } from "../core/events.js";

function initSupplierCreate() {

  const nombre = document.getElementById("nombre");
  const telefono = document.getElementById("telefono");
  const nit = document.getElementById("nit");

  const nombreMsg = document.getElementById("nombre-msg");
  const telMsg = document.getElementById("telefono-msg");
  const nitMsg = document.getElementById("nit-msg");

  const form = document.querySelector("form");

  let nitTimeout = null;
  let lastNit = "";

  // =========================
  // NOMBRE
  // =========================
  if (nombre) {
    nombre.addEventListener("input", () => {
      const val = nombre.value.trim();

      if (val.length < 2) {
        nombreMsg.textContent = "Mínimo 2 caracteres";
        nombreMsg.className = "input-msg error";
      } else {
        nombreMsg.textContent = "✔ válido";
        nombreMsg.className = "input-msg success";
      }
    });
  }

  // =========================
  // TELÉFONO
  // =========================
  if (telefono) {
    telefono.addEventListener("input", () => {
      const val = telefono.value.trim();

      if (val && val.length < 7) {
        telMsg.textContent = "Teléfono inválido";
        telMsg.className = "input-msg error";
      } else {
        telMsg.textContent = "";
      }
    });
  }

  // =========================
  // NIT (AJAX)
  // =========================
  if (nit) {
    nit.addEventListener("input", () => {

      clearTimeout(nitTimeout);

      const val = nit.value.trim();

      if (val.length < 3) {
        nitMsg.textContent = "";
        nit.dataset.valid = "";
        return;
      }

      // 🔥 evitar repetir misma consulta
      if (val === lastNit) return;

      nitMsg.textContent = "Validando...";
      nitMsg.className = "input-msg";

      nitTimeout = setTimeout(() => {

        const id = form?.querySelector('input[name="id"]')?.value || "";
        const idParam = id ? `&id=${encodeURIComponent(id)}` : "";

        fetch(`${BASE_URL}/suppliers/check-nit?nit=${encodeURIComponent(val)}${idParam}`)
          .then(res => {
            if (!res.ok) throw new Error("HTTP error");
            return res.json();
          })
          .then(data => {

            lastNit = val;

            if (data.exists) {
              nitMsg.textContent = "⚠️ NIT ya registrado";
              nitMsg.className = "input-msg error";
              nit.dataset.valid = "false";

              nit.classList.add("input-error");
              nit.classList.remove("input-success");

            } else {
              nitMsg.textContent = "✔ NIT disponible";
              nitMsg.className = "input-msg success";
              nit.dataset.valid = "true";

              nit.classList.add("input-success");
              nit.classList.remove("input-error");
            }

          })
          .catch(() => {
            nitMsg.textContent = "Error validando";
            nitMsg.className = "input-msg error";
            nit.dataset.valid = "false";

            nit.classList.add("input-error");
            nit.classList.remove("input-success");
          });

      }, 400);

    });
  }

  // =========================
  // BLOQUEAR SUBMIT
  // =========================
  if (form) {
    form.addEventListener("submit", (e) => {

      if (nit && nit.dataset.valid === "false") {
        e.preventDefault();

        nitMsg.textContent = "Corrige el NIT antes de guardar";
        nitMsg.className = "input-msg error";

        nit.classList.add("input-error");
      }

    });
  }

}

// 🔥 EVENTO GLOBAL
Events.on("suppliers:create", initSupplierCreate);
