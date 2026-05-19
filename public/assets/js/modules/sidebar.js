import { Events } from "../core/events.js";

export function initSidebar() {
  const btn = document.getElementById("toggleSidebar");
  const sidebar = document.querySelector(".sidebar");
  const overlay = document.getElementById("sidebarOverlay");

  if (!btn || !sidebar) {
    console.log("Sidebar no encontrado");
    return;
  }

  console.log("Sidebar INIT OK");

  btn.addEventListener("click", () => {
    if (window.innerWidth <= 768) {
      sidebar.classList.toggle("active");

      if (overlay) {
        overlay.classList.toggle("active");
      }
    } else {
      sidebar.classList.toggle("collapsed");
    }
  });

  if (overlay) {
    overlay.addEventListener("click", (e) => {
      e.stopPropagation();
      sidebar.classList.remove("active");
      overlay.classList.remove("active");
    });
  }

  
}

Events.on("sidebar:init", () => {
  initSidebar();
});
