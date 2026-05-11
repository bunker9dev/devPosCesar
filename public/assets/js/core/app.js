// import { initNavbar } from '../modules/navbar.js';
// import { initAlerts } from '../modules/alerts.js';
// import { initCharts } from '../modules/charts.js';
// import { initRealtime } from '../modules/realtime.js';
// import { initDashboard } from '../pages/dashboard.js';
// import { initLogin } from '../pages/login.js';

// document.addEventListener("DOMContentLoaded", () => {

//     initNavbar();
//     initAlerts();

//     // 🔥 detección automática por página
//     const path = window.location.pathname;

//     if (path.includes("dashboard")) {
//         initCharts();
//         initRealtime();
//         initDashboard();
//     }

//     if (path.includes("login")) {
//         initLogin();
//     }

// });




import { Events } from './events.js';
import { initNavbar } from '../modules/navbar.js';

// 🔹 IMPORTAR MÓDULOS (eventos)
import '../modules/alerts.js';

// 🔹 IMPORTAR PÁGINAS
import '../pages/dashboard.js';
import '../pages/login.js';

document.addEventListener("DOMContentLoaded", () => {

    initNavbar();

    // 🔹 dashboard
    if (document.getElementById('chart')) {
        Events.emit("dashboard:init");
    }

    // 🔹 login
    if (document.getElementById('alerta-error')) {
        Events.emit("login:init");
    }

    // 🔹 alerts
    if (document.getElementById('alerts')) {
        Events.emit("alerts:init");
    }

});