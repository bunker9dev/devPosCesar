// export function initLogin() {
//     const alerta = document.getElementById('alerta-error');
//     if (!alerta) return;

//     setTimeout(() => {
//         alerta.style.transition = "opacity 0.5s ease";
//         alerta.style.opacity = "0";

//         setTimeout(() => alerta.remove(), 500);
//     }, 3000);
// }

import { Events } from '../core/events.js';

Events.on("login:init", () => {

    const alerta = document.getElementById('alerta-error');
    if (!alerta) return;

    setTimeout(() => {
        alerta.style.transition = "opacity 0.5s ease";
        alerta.style.opacity = "0";

        setTimeout(() => alerta.remove(), 500);
    }, 3000);

});