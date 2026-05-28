import { Events } from "../core/events.js";

export function initDelete() {
  let deleteId = null;
  let deleteUrl = null;
  let deleteRow = null;

  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-delete");
    if (!btn) return;

    deleteId = btn.dataset.id;
    deleteUrl = btn.dataset.url;
    deleteRow = btn.closest("tr");

    const modal = document.getElementById("modalConfirmDelete");
    modal.classList.remove("hidden");
  });

  // 🔥 CONFIRMAR
  document
    .getElementById("btnConfirmDelete")
    ?.addEventListener("click", async () => {
      if (!deleteUrl) return;

      try {
        const res = await fetch(deleteUrl);
        const data = await res.json();

        if (data.success) {
          // 🔥 ANIMACIÓN
          if (deleteRow) {
            deleteRow.style.transition = "all 0.3s ease";
            deleteRow.style.opacity = "0";
            deleteRow.style.transform = "translateX(-20px)";

            setTimeout(() => deleteRow.remove(), 300);
          }

          Events.emit("alerts:show", {
            type: "success",
            message: data.message,
          });
        } else {
          throw new Error(data.message);
        }
      } catch (err) {
        Events.emit("alerts:show", {
          type: "error",
          message: err.message,
        });
      }

      closeDeleteModal();
    });

  // 🔥 CANCELAR
  document
    .getElementById("btnCancelDelete")
    ?.addEventListener("click", closeDeleteModal);

  function closeDeleteModal() {
    document.getElementById("modalConfirmDelete")?.classList.add("hidden");
    deleteId = null;
    deleteUrl = null;
    deleteRow = null;
  }
}
