// /* ===== ALERTAS DINÁMICAS ===== */

// export function initAlerts() {
//     const alertsContainer = document.getElementById("alerts");
//     if (!alertsContainer) return;

//     const alertsData = [
//         "12 productos con stock crítico",
//         "8 productos por vencer",
//         "3 pedidos pendientes"
//     ];

//     alertsData.forEach(alert => {
//         let div = document.createElement("div");
//         div.classList.add("alert");
//         div.innerText = alert;
//         alertsContainer.appendChild(div);
//     });
// }

/* ===== ALERTAS DINÁMICAS ===== */

import { Events } from '../core/events.js';

Events.on("alerts:init", () => {

    const alertsContainer = document.getElementById("alerts");
    if (!alertsContainer) return;

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

});
