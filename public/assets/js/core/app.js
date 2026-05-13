
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
   Events.emit("alerts:init");

});