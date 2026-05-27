console.log("PRODUCTS JS CARGADO");
import { Events } from "../core/events.js";

/* ================================
   🔥 CLICK GLOBAL (DELETE / RESTORE)
================================ */
document.addEventListener("click", (e) => {

  if (e.target.classList.contains("btn-delete")) {
    const id = e.target.dataset.id;

    if (!confirm("¿Eliminar tipo de tela?")) return;

    window.location.href = `/products/types/delete/${id}`;
  }

  if (e.target.classList.contains("btn-restore")) {
    const id = e.target.dataset.id;

    if (!confirm("¿Restaurar tipo de tela?")) return;

    window.location.href = `/products/types/restore/${id}`;
  }

});


/* ================================
   🔥 DATATABLE SEGURO
================================ */
function safeInitTable() {

  const table = $("#tablaFabricTypes");

  if (!table.length) return;

  // 🔥 evitar doble inicialización
  if ($.fn.DataTable.isDataTable(table)) return;

  table.DataTable({
    responsive: true
  });

}


/* ================================
   🔥 INLINE CREATE
================================ */
function initInlineCreateType() {

  const input = document.getElementById("inputTypeName");
  const form = document.getElementById("formCreateType");

  if (!input || !form) return;

  input.focus();

  input.addEventListener("focus", () => {
    input.select();
  });

  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      form.submit();
    }
  });

  form.addEventListener("submit", () => {
    setTimeout(() => {
      input.value = "";
    }, 100);
  });

}


/* ================================
   🔥 ALERTS (LEGACY)
================================ */
function initAlerts() {

  const alert = document.getElementById("alertMessage");

  if (!alert) return;

  setTimeout(() => {
    alert.style.opacity = "0";
    alert.style.transform = "translateY(-10px)";

    setTimeout(() => alert.remove(), 300);
  }, 2500);

}


/* ================================
   🔥 EDIT MODAL
================================ */
function initEditModal() {

  const modal = document.getElementById("modalEditType");
  const input = document.getElementById("editTypeName");
  const idInput = document.getElementById("editTypeId");
  const form = document.getElementById("formEditType");
  const cancel = document.getElementById("btnCancelEdit");

  if (!modal) return;

  // 🔥 abrir modal
  document.addEventListener("click", (e) => {

    const btn = e.target.closest(".btn-edit-type");

    if (btn) {
      const id = btn.dataset.id;
      const name = btn.dataset.name;

      idInput.value = id;
      input.value = name;

      modal.classList.remove("hidden");
      input.focus();
    }

  });

  // 🔥 cerrar modal
  cancel.addEventListener("click", () => {
    modal.classList.add("hidden");
  });

  // 🔥 submit AJAX
  form.addEventListener("submit", async (e) => {

    e.preventDefault();

    const id = idInput.value;
    const nombre = input.value.trim();

    if (!nombre) return;

    try {

      const res = await fetch("/products/types/update", {
        method: "POST",
        headers: {
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({ id, nombre }),
      });

      const data = await res.json();

      if (data.success) {

        // 🔥 toast
        Events.emit("alerts:show", {
          type: "success",
          message: data.message,
        });

        modal.classList.add("hidden");

        // 🔥 actualizar fila SIN DataTable
        const row = document.querySelector(`tr[data-id="${id}"]`);

        if (row) {

          const cell = row.querySelector('td[data-label="Nombre"]');

          if (cell) {
            cell.textContent = nombre;
          }

          // 🔥 highlight
          row.style.background = "rgba(var(--primary-rgb), 0.2)";

          setTimeout(() => {
            row.style.background = "";
          }, 1500);
        }

      } else {
        throw new Error(data.message);
      }

    } catch (err) {

      Events.emit("alerts:show", {
        type: "error",
        message: err.message,
      });

    }

  });

}


/* ================================
   🔥 INIT GLOBAL
================================ */
Events.on("inventory:types", () => {

  safeInitTable();        // 🔥 FIX CLAVE
  initInlineCreateType();
  initAlerts();
  initEditModal();

});


/* ================================
   🔥 DEBUG (opcional)
================================ */
document.addEventListener("click", (e) => {

  const btn = e.target.closest(".btn-edit-type");

  if (btn) {
    console.log("EDIT CLICK OK", btn.dataset.id);
  }

});