import { Events } from "../core/events.js";
import { post } from "../core/api.js";

function initSupplierToggle() {
  document.addEventListener("click", async (e) => {

    const el = e.target.closest(".estado-toggle");
    if (!el) return;

    const id = el.dataset.id;

    const res = await post("/suppliers/toggle", { id });

    if (!res.ok) return;

    el.dataset.estado = res.estado;
    el.textContent = res.estado == 1 ? "Activo" : "Inactivo";

    el.classList.toggle("active");
    el.classList.toggle("inactive");
  });
}

Events.on("suppliers:index", () => {
  initSupplierToggle();
});