import { initDataTable } from "./table.js";

// =========================================================
// HELPERS
// =========================================================
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

document.addEventListener("DOMContentLoaded", () => {

    const tableElement = $("#tablaFabricTypes");

    if ($.fn.DataTable.isDataTable(tableElement)) {
        tableElement.DataTable().destroy();
    }

    const table = initDataTable("#tablaFabricTypes");

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
                alert(data.error || "Error");
                return;
            }

            form.reset();
            table.ajax ? table.ajax.reload(null, false) : location.reload();
        });
    }

    // ============================
    // TOGGLE
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
            alert(data.error || "Error al cambiar estado");
            return;
        }

        location.reload();
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
    // UPDATE — enviar edición
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
                alert(data.error || "Error al actualizar");
                return;
            }

            document.getElementById("modalEditType").classList.add("hidden");
            location.reload();
        });
    }

    // ============================
    // DELETE — abrir modal de confirmación
    // ============================
    let deleteTypeId = null;
    let deleteTypeUrl = null;

    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-delete");
        if (!btn) return;

        deleteTypeId = btn.dataset.id;
        deleteTypeUrl = btn.dataset.url;

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
    // DELETE — confirmar
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

            if (!data) return;

            if (!data.ok) {
                alert(data.error || "Error al eliminar");
                return;
            }

            location.reload();
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
            alert(data.error || "Error al restaurar");
            return;
        }

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