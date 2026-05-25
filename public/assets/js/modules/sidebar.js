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

  //   document.querySelectorAll(".sidebar-group-toggle").forEach((toggle) => {
  //     toggle.addEventListener("click", () => {
  //       const group = toggle.closest(".sidebar-group");
  //       if (!group) return;

  //       group.classList.toggle("open");
  //       toggle.setAttribute("aria-expanded", group.classList.contains("open") ? "true" : "false");
  //     });
  //   });

  //   btn.addEventListener("click", () => {
  //     if (window.innerWidth <= 768) {
  //       sidebar.classList.toggle("active");

  //       if (overlay) {
  //         overlay.classList.toggle("active");
  //       }
  //     } else {
  //       sidebar.classList.toggle("collapsed");
  //     }
  //   });

  //   if (overlay) {
  //     overlay.addEventListener("click", (e) => {
  //       e.stopPropagation();
  //       sidebar.classList.remove("active");
  //       overlay.classList.remove("active");
  //     });
  //   }

  // }

  document.querySelectorAll(".sidebar-group-toggle").forEach((toggle) => {
    toggle.addEventListener("click", () => {
      const group = toggle.closest(".sidebar-group");
      if (!group) return;

      // expandir sidebar si está colapsado
      if (sidebar.classList.contains("collapsed")) {
        sidebar.classList.remove("collapsed");
      }

      const isOpen = group.classList.contains("open");

      // 👉 SOLO cerrar otros grupos (no todos siempre)
      document.querySelectorAll(".sidebar-group").forEach((g) => {
        if (g !== group) {
          g.classList.remove("open");
          g.querySelector(".sidebar-group-toggle")?.setAttribute(
            "aria-expanded",
            "false",
          );
        }
      });

      // 👉 toggle del actual
      if (isOpen) {
        group.classList.remove("open");
        toggle.setAttribute("aria-expanded", "false");

        localStorage.removeItem("sidebar-open");
      } else {
        group.classList.add("open");
        toggle.setAttribute("aria-expanded", "true");

        localStorage.setItem("sidebar-open", group.dataset.menu);
      }
    });
  });

  // BOTÓN PRINCIPAL SIDEBAR
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

  // OVERLAY (MÓVIL)
  if (overlay) {
    overlay.addEventListener("click", (e) => {
      e.stopPropagation();
      sidebar.classList.remove("active");
      overlay.classList.remove("active");
    });
  }
  const saved = localStorage.getItem("sidebar-open");

  if (saved) {
    document.querySelectorAll(".sidebar-group").forEach((group) => {
      if (group.dataset.menu === saved) {
        group.classList.add("open");

        group
          .querySelector(".sidebar-group-toggle")
          ?.setAttribute("aria-expanded", "true");
      }
    });
  }
}

Events.on("sidebar:init", () => {
  initSidebar();
});
