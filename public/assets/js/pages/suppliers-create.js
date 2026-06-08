// =========================================================
// PAGE: SUPPLIERS CREATE
// =========================================================

import { initSuppliers } from "../modules/suppliers.js";

document.addEventListener("DOMContentLoaded", () => {
    initSuppliers();

    // =====================================================
    // VALIDACIÓN FINAL ANTES DE SUBMIT
    // =====================================================
    const form = document.querySelector(".form-suppliers");
    if (!form) return;

    form.addEventListener("submit", (e) => {
        let valid = true;

        // 🔥 NIT
        const nit = document.getElementById("nit");
        if (nit && nit.dataset.exists === "true") {
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
            btn.textContent = "Guardando...";
        }
    });
});