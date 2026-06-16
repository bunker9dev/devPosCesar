import { Events } from "../core/events.js";

// SOLO importar módulo 
import "../modules/users.js";

document.addEventListener("DOMContentLoaded", () => {
    // console.log("users-create cargado");

    // ================================
    // FLASH MESSAGES
    // ================================
    if (window.APP_FLASH?.success) {
        Events.emit("alerts:show", {
            type: "success",
            message: window.APP_FLASH.success
        });
    }

    if (window.APP_FLASH?.error) {
        Events.emit("alerts:show", {
            type: "error",
            message: window.APP_FLASH.error
        });
    }

    // INICIALIZA TODO EL MÓDULO USERS
    Events.emit("users:create");
});