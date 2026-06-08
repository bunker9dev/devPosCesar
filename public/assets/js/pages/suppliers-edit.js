// =========================================================
// PAGE: SUPPLIERS EDIT
// =========================================================

import { initSuppliers } from "../modules/suppliers.js";
import { post } from "../core/api.js";

document.addEventListener("DOMContentLoaded", () => {
    initSuppliers();

    const form = document.querySelector(".form-suppliers");
    if (!form) return;

    const nitInput = document.getElementById("nit");
    const nitMsg = document.getElementById("nit-msg");

    // 🔥 ID ACTUAL DEL REGISTRO (CLAVE)
    const supplierId = form.dataset.id;

    let timeout;

    // =====================================================
    // VALIDACIÓN NIT (IGNORANDO EL MISMO ID)
    // =====================================================
    nitInput?.addEventListener("input", () => {
        clearTimeout(timeout);

        const nit = nitInput.value.trim().toLowerCase();
        nitInput.value = nit;

        if (!nitMsg) return;

        if (nit.length < 5) {
            showMsg(nitMsg, "Mínimo 5 caracteres", "error");
            nitInput.dataset.exists = "true";
            return;
        }

        showMsg(nitMsg, "Verificando...", "loading");

        timeout = setTimeout(async () => {
            try {
                const res = await post("/api/suppliers/check-nit", {
                    nit,
                    id: supplierId // 🔥 IGNORA ESTE REGISTRO
                });

                if (!res || !res.success) {
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

        // 🔥 NIT duplicado
        if (nitInput && nitInput.dataset.exists === "true") {
            valid = false;
            showToast("El NIT ya está registrado", "error");
        }

        // 🔥 NOMBRE
        const nombre = document.getElementById("nombre");
        if (nombre && nombre.value.trim().length < 2) {
            valid = false;
            showToast("El nombre es obligatorio (mínimo 2 caracteres)", "error");
        }

        // 🔥 TELÉFONO
        const telefono = document.getElementById("telefono");
        if (telefono && telefono.value.trim().length > 0 && telefono.value.trim().length < 7) {
            valid = false;
            showToast("Teléfono inválido", "error");
        }

        if (!valid) {
            e.preventDefault();
            return;
        }

        // 🔥 UX: bloquear botón
        const btn = form.querySelector("button[type='submit']");
        if (btn) {
            btn.disabled = true;
            btn.textContent = "Actualizando...";
        }
    });
});