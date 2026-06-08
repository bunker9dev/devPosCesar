import { Events } from "../core/events.js";

// IMPORTAR EL MÓDULO 
import "../modules/users.js";

document.addEventListener("DOMContentLoaded", () => {

    // flash messages
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

    // 
    Events.emit("users:create");
});