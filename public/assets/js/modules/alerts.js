
/* ===== ALERTAS DINÁMICAS ===== */

import { Events } from '../core/events.js';

export function showToast(message, type = "success") {

    const container = document.getElementById("toast-container");
    if (!container) return;

    const toast = document.createElement("div");
    toast.className = `toast ${type}`;
    toast.textContent = message;

    container.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

// 🔥 EVENTO GLOBAL PARA TOAST (SIEMPRE)
Events.on("alerts:init", () => {

    // 🔥 TOAST DESDE PHP (FLASH)
    if (window.APP_FLASH?.success) {
        showToast(window.APP_FLASH.success, "success");
    }

    if (window.APP_FLASH?.error) {
        showToast(window.APP_FLASH.error, "error");
    }

    // 🔹 ALERTAS DEL DASHBOARD (opcional)
    const alertsContainer = document.getElementById("alerts");

    if (alertsContainer) {

        const alertsData = [
            "12 productos con stock crítico",
            "8 productos por vencer",
            "3 pedidos pendientes"
        ];

        alertsData.forEach(alert => {
            let div = document.createElement("div");
            div.classList.add("alert");
            div.innerText = alert;
            alertsContainer.appendChild(div);
        });
    }

});