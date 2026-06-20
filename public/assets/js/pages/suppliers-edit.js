import { Events } from "../core/events.js";
import "../modules/suppliers.js";
import { post } from "../core/api.js";

function notify(message, type = "success") {
    Events.emit("alerts:show", { type, message });
}

document.addEventListener("DOMContentLoaded", () => {

    Events.emit("suppliers:form");

    const form = document.querySelector(".form-suppliers");
    if (!form) return;

    const nitInput = document.getElementById("nit");
    const nitMsg = document.getElementById("nit-msg");
    const supplierId = form.dataset.id;

    let timeout;

    function showMsg(el, text, type) {
        if (!el) return;
        el.textContent = text;
        el.className = `input-msg ${type}`;
    }

    // =====================================================
    // VALIDACIÓN NIT (ignorando el propio registro)
    // =====================================================
    nitInput?.addEventListener("input", () => {
        clearTimeout(timeout);

        const nit = nitInput.value.trim().toLowerCase();
        nitInput.value = nit;

        if (nit.length < 5) {
            showMsg(nitMsg, "Mínimo 5 caracteres", "error");
            nitInput.dataset.exists = "true";
            return;
        }

        showMsg(nitMsg, "Verificando...", "loading");

        timeout = setTimeout(async () => {
            try {
                const res = await post("/suppliers/check-nit", {
                    nit,
                    id: supplierId
                });

                if (!res || !res.ok) {
                    showMsg(nitMsg, "Error al validar", "error");
                    return;
                }

                if (res.exists) {
                    showMsg(nitMsg, "❌ NIT ya registrado", "error");
                    nitInput.dataset.exists = "true";
                    nitInput.classList.add("input-error");
                    nitInput.classList.remove("input-success");
                } else {
                    showMsg(nitMsg, "✔️ Disponible", "success");
                    nitInput.dataset.exists = "false";
                    nitInput.classList.add("input-success");
                    nitInput.classList.remove("input-error");
                }

            } catch {
                showMsg(nitMsg, "Error de conexión", "error");
            }
        }, 400);
    });

    // =====================================================
    // VALIDACIÓN FINAL ANTES DE SUBMIT
    // =====================================================
    form.addEventListener("submit", (e) => {
        let valid = true;

        if (nitInput && nitInput.dataset.exists === "true") {
            valid = false;
            notify("El NIT ya está registrado", "error");
        }

        const nombre = document.getElementById("nombre");
        if (nombre && nombre.value.trim().length < 2) {
            valid = false;
            notify("El nombre es obligatorio (mínimo 2 caracteres)", "error");
        }

        const telefono = document.getElementById("telefono");
        if (telefono && telefono.value.trim().length > 0 && telefono.value.trim().length < 7) {
            valid = false;
            notify("Teléfono inválido", "error");
        }

        if (!valid) {
            e.preventDefault();
            return;
        }

        const btn = form.querySelector("button[type='submit']");
        if (btn) {
            btn.disabled = true;
            btn.textContent = "Actualizando...";
        }
    });
});