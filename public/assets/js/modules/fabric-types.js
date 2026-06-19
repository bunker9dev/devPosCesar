import { Events } from "../core/events.js";

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
            paginate: {
                next: "→",
                previous: "←"
            }
        }
    });

    const form = document.querySelector("#formCreateType");

    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const res = await fetch(form.action, {
            method: "POST",
            body: new FormData(form)
        });

        const data = await res.json();

        if (!data.ok) {
            Events.emit("alerts:show", {
                type: "error",
                message: data.error || "Error"
            });
            return;
        }

        form.reset();

        // ✔ mejor que reload
        table.ajax ? table.ajax.reload(null, false) : location.reload();

        Events.emit("alerts:show", {
            type: "success",
            message: "Tipo de tela creado"
        });
    });

    // DELETE
    document.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-delete");
        if (!btn) return;

        const res = await fetch(btn.dataset.url, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({ id: btn.dataset.id })
        });

        const data = await res.json();

        if (data.ok) location.reload();
    });

    // TOGGLE
    document.addEventListener("click", async (e) => {
        const el = e.target.closest(".toggle-type");
        if (!el) return;

        const res = await fetch(`${window.BASE_URL}/fabric-types/toggle`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({ id: el.dataset.id })
        });

        const data = await res.json();

        if (data.ok) location.reload();
    });

});