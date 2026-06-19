/* ===== SISTEMAS DE ALERTAS ===== */

import { Events } from './events.js';

/**
 * TOAST GLOBAL
 */
function showToast(message, type = "success") {

    const container = document.getElementById("toast-container");
    if (!container) return;

    const toast = document.createElement("div");
    toast.className = `toast ${type}`;
    toast.textContent = message;

    container.appendChild(toast);

    // entrada suave
    requestAnimationFrame(() => {
        toast.style.opacity = "1";
        toast.style.transform = "translateY(0)";
    });

    // auto remove
    setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "translateY(-10px)";
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/**
 * EVENTO GLOBAL (USO PRINCIPAL)
 */
Events.on("alerts:show", ({ message, type = "success" }) => {
    showToast(message, type);
});

/**
 * FLASH PHP (AUTO INIT)
 */
Events.on("alerts:init", () => {

    const flash = window.APP_FLASH || {};

    if (flash.success) {
        showToast(flash.success, "success");
    }

    if (flash.error) {
        showToast(flash.error, "error");
    }
});