import { Events } from "../core/events.js";

async function safeFetch(url, options) {
  try {
    const response = await fetch(url, options);
    const text = await response.text();

    let data;
    try {
      data = JSON.parse(text);
    } catch (e) {
      console.error("❌ Respuesta inválida:", text);
      return null;
    }

    return data;
  } catch (error) {
    console.error(error);
    return null;
  }
}

function notify(type, message) {
  Events.emit("alerts:show", { type, message });
}

document.addEventListener("DOMContentLoaded", () => {

    const tableElement = $("#tablaFabricTypes");

    if ($.fn.DataTable.isDataTable(tableElement)) {
        tableElement.DataTable().destroy();
    }

    const table = tableElement.DataTable({
        responsive: true,
        pageLength: 10,
        order: [[1, "desc"]],
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_",
            paginate: { next: "→", previous: "←" }
        }
    });

    // ============================
    // CREATE
    // ============================
    const form = document.querySelector("#formCreateType");

    if (form) {
        form.addEventListener("submit", async (e) => {
            e.preventDefault();

            const data = await safeFetch(form.action, {
                method: "POST",
                body: new FormData(form)
            });

            if (!data) return;

            if (!data.ok) {
                notify("error", data.error || "Error al crear");
                return;
            }

            form.reset();
            notify("success", "Tipo de tela creado");
            location.reload();
        });
    }

    // ============================
    // TOGGLE — actualiza en sitio, sin recargar
    // ============================
    document.addEventListener("click", async (e) => {
        const el = e.target.closest(".toggle-type");
        if (!el) return;

        const data = await safeFetch(`${window.BASE_URL}/fabric-types/toggle`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: el.dataset.id })
        });

        if (!data) return;

        if (!data.ok) {
            notify("error", data.error || "Error al cambiar estado");
            return;
        }

        const estado = parseInt(data.estado);
        el.dataset.estado = estado;
        el.classList.remove("active", "inactive", "deleted");

        if (estado === 1) {
            el.classList.add("active");
            el.textContent = "Activo";
        } else {
            el.classList.add("inactive");
            el.textContent = "Inactivo";
        }

        notify("success", "Estado actualizado");
    });

    // ============================
    // EDIT — abrir modal
    // ============================
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-edit");
        if (!btn) return;

        const modal = document.getElementById("modalEditType");
        const inputId = document.getElementById("editTypeId");
        const inputName = document.getElementById("editTypeName");

        if (!modal || !inputId || !inputName) {
            console.error("❌ Modal de edición no encontrado");
            return;
        }

        inputId.value = btn.dataset.id;
        inputName.value = btn.dataset.name;

        modal.classList.remove("hidden");
    });

    // ============================
    // UPDATE — actualiza en sitio, sin recargar
    // ============================
    const formEdit = document.getElementById("formEditType");

    if (formEdit) {
        formEdit.addEventListener("submit", async (e) => {
            e.preventDefault();

            const id = document.getElementById("editTypeId").value;
            const nombre = document.getElementById("editTypeName").value;

            const data = await safeFetch(`${window.BASE_URL}/fabric-types/update`, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({ id, nombre })
            });

            if (!data) return;

            if (!data.ok) {
                notify("error", data.error || "Error al actualizar");
                return;
            }

            const row = document.querySelector(`tr[data-id="${id}"]`);
            const cell = row?.querySelector('td[data-label="Nombre"]');
            if (cell) cell.textContent = nombre;

            document.getElementById("modalEditType").classList.add("hidden");
            notify("success", "Tipo de tela actualizado");
        });
    }

    // ============================
    // DELETE — abrir modal de confirmación
    // ============================
    let deleteTypeId = null;
    let deleteTypeUrl = null;
    let deleteTypeRow = null;

    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-delete");
        if (!btn) return;

        deleteTypeId = btn.dataset.id;
        deleteTypeUrl = btn.dataset.url;
        deleteTypeRow = btn.closest("tr");

        const msg = document.getElementById("deleteTypeMessage");
        const modal = document.getElementById("modalDeleteType");

        if (msg) {
            msg.textContent = `¿Eliminar el tipo de tela "${btn.dataset.name}"?`;
        }

        if (modal) {
            modal.classList.remove("hidden");
        }
    });

    // ============================
    // DELETE — confirmar (sin recarga completa)
    // ============================
    const btnConfirmDelete = document.getElementById("btnConfirmDeleteType");

    if (btnConfirmDelete) {
        btnConfirmDelete.addEventListener("click", async () => {
            if (!deleteTypeId) return;

            const data = await safeFetch(deleteTypeUrl, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({ id: deleteTypeId })
            });

            document.getElementById("modalDeleteType").classList.add("hidden");

            if (!data) return;

            if (!data.ok) {
                notify("error", data.error || "Error al eliminar");
                return;
            }

            const badge = deleteTypeRow?.querySelector(".estado-toggle");
            if (badge) {
                badge.textContent = "Eliminado";
                badge.classList.remove("active", "inactive");
                badge.classList.add("deleted");
            }

            const actions = deleteTypeRow?.querySelector('td[data-label="Acciones"]');
            if (actions) actions.innerHTML = "";

            notify("success", "Tipo de tela eliminado");

            deleteTypeId = null;
            deleteTypeUrl = null;
            deleteTypeRow = null;
        });
    }

    // ============================
    // RESTORE
    // ============================
    document.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-restore");
        if (!btn) return;

        const data = await safeFetch(btn.dataset.url, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: btn.dataset.id })
        });

        if (!data) return;

        if (!data.ok) {
            notify("error", data.error || "Error al restaurar");
            return;
        }

        notify("success", "Tipo de tela restaurado");
        location.reload();
    });

    // ============================
    // CERRAR MODALES
    // ============================
    document.addEventListener("click", (e) => {
        if (e.target.matches(".modal-overlay") || e.target.matches(".btn-cancel")) {
            document.querySelectorAll(".modal").forEach((m) => m.classList.add("hidden"));
        }
    });

});