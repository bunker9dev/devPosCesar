import { Events } from "../core/events.js";

function initSupplierCreate() {

  const nombre = document.getElementById("nombre");
  const telefono = document.getElementById("telefono");

  const nombreMsg = document.getElementById("nombre-msg");
  const telMsg = document.getElementById("telefono-msg");

  // =========================
  // NOMBRE
  // =========================
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

  // =========================
  // TELÉFONO
  // =========================
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

Events.on("suppliers:create", initSupplierCreate);