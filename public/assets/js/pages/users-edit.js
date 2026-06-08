// =========================================================
// Página: Users Edit
// =========================================================

import { Events } from "../core/events.js";

//  SOLO DISPARA EL EVENTO
document.addEventListener("DOMContentLoaded", () => {
    Events.emit("users:edit");
});