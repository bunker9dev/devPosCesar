export function initSidebar() {

    const btn = document.getElementById("toggleSidebar");
    const sidebar = document.querySelector(".sidebar");

    if (!btn || !sidebar) return;

    btn.addEventListener("click", () => {
        sidebar.classList.toggle("collapsed");
    });

}

import { Events } from "../core/events.js";

Events.on("sidebar:init", () => {
    initSidebar();
});