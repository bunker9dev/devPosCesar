/* ===== ALERTAS DINÁMICAS (GLOBAL SYSTEM) ===== */

import { Events } from '../core/events.js';

//  CREAR TOAST
export function showToast(message, type = "success") {

    const container = document.getElementById("toast-container");
    if (!container) return;

    const toast = document.createElement("div");
    toast.className = `toast ${type}`;
    toast.textContent = message;

    container.appendChild(toast);

    //  animación entrada
    requestAnimationFrame(() => {
        toast.style.opacity = "1";
        toast.style.transform = "translateY(0)";
    });

    //  auto eliminar
    setTimeout(() => {
        toast.style.opacity = "0";
        toast.style.transform = "translateY(-10px)";

        setTimeout(() => toast.remove(), 300);
    }, 3000);
}


// EVENTO GLOBAL DESDE JS (TIEMPO REAL)
Events.on("alerts:show", ({ message, type = "success" }) => {
    showToast(message, type);
});


// INICIALIZACIÓN GLOBAL
Events.on("alerts:init", () => {

    // 🔹 FLASH DESDE PHP
    if (window.APP_FLASH?.success) {
        showToast(window.APP_FLASH.success, "success");
    }

    if (window.APP_FLASH?.error) {
        showToast(window.APP_FLASH.error, "error");
    }

    // 🔹 ALERTAS DASHBOARD (OPCIONAL)
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