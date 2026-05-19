export function initSidebar() {

    const btn = document.getElementById("toggleSidebar");
    const sidebar = document.querySelector(".sidebar");
    const overlay = document.getElementById("sidebarOverlay");

    if (!btn || !sidebar) return;

    btn.addEventListener("click", () => {

        // 🔥 MOBILE
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle("active");
            overlay.classList.toggle("active");
        } 
        // 🔥 DESKTOP
        else {
            sidebar.classList.toggle("collapsed");
        }
    });

    // 🔥 cerrar al hacer click fuera
    if (overlay) {
        overlay.addEventListener("click", () => {
            sidebar.classList.remove("active");
            overlay.classList.remove("active");
        });
    }
}