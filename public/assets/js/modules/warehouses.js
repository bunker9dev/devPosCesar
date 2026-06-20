import { Events } from "../core/events.js";

let warehousesInitialized = false;
let deleteWarehouseId = null;
let deleteWarehouseRow = null;

function notify(message, type = "success") {
    Events.emit("alerts:show", { type, message });
}

async function safeFetch(url, options) {
    try {
        const response = await fetch(url, options);
        const text = await response.text();

        let data;
        try {
            data = JSON.parse(text);
        } catch (e) {
            console.error("❌ Respuesta inválida:", text);
            notify("Error del servidor", "error");
            return null;
        }

        return data;
    } catch (error) {
        console.error(error);
        notify("Error de conexión", "error");
        return null;
    }
}

function initToggle() {
    document.addEventListener("click", async (e) => {
        const el = e.target.closest(".estado-toggle");
        if (!el) return;

        const data = await safeFetch(el.dataset.url, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: el.dataset.id }),
        });

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al cambiar estado", "error");
            return;
        }

        const estado = parseInt(data.estado);
        el.dataset.estado = estado;
        el.classList.remove("active", "inactive");
        el.classList.add(estado === 1 ? "active" : "inactive");
        el.textContent = estado === 1 ? "Activo" : "Inactivo";

        notify("Estado actualizado", "success");
    });
}

function initEdit() {
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-edit-warehouse");
        if (!btn) return;

        const modal = document.getElementById("modalEditWarehouse");
        document.getElementById("editWarehouseId").value = btn.dataset.id;
        document.getElementById("editWarehouseName").value = btn.dataset.name;
        document.getElementById("editWarehouseUbicacion").value = btn.dataset.ubicacion || "";

        modal?.classList.remove("hidden");
    });
}

function initUpdate() {
    const form = document.getElementById("formEditWarehouse");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const id = document.getElementById("editWarehouseId").value;
        const nombre = document.getElementById("editWarehouseName").value;
        const ubicacion = document.getElementById("editWarehouseUbicacion").value;

        const data = await safeFetch(`${window.BASE_URL}/warehouses/update`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id, nombre, ubicacion }),
        });

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al actualizar", "error");
            return;
        }

        const row = document.querySelector(`tr[data-id="${id}"]`);
        if (row) {
            const nombreCell = row.querySelector('td[data-label="Nombre"]');
            const ubicacionCell = row.querySelector('td[data-label="Ubicación"]');
            if (nombreCell) nombreCell.textContent = nombre;
            if (ubicacionCell) ubicacionCell.textContent = ubicacion || "-";
        }

        document.getElementById("modalEditWarehouse").classList.add("hidden");
        notify("Bodega actualizada", "success");
    });
}

function initDeleteModal() {
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-delete-warehouse");
        if (!btn) return;

        deleteWarehouseId = btn.dataset.id;
        deleteWarehouseRow = btn.closest("tr");

        const msg = document.getElementById("deleteWarehouseMessage");
        if (msg) msg.textContent = `¿Eliminar la bodega "${btn.dataset.name}"?`;

        document.getElementById("modalDeleteWarehouse")?.classList.remove("hidden");
    });
}

function initConfirmDelete() {
    const btn = document.getElementById("btnConfirmDeleteWarehouse");
    if (!btn) return;

    btn.addEventListener("click", async () => {
        if (!deleteWarehouseId) return;

        const data = await safeFetch(`${window.BASE_URL}/warehouses/delete`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: deleteWarehouseId }),
        });

        document.getElementById("modalDeleteWarehouse").classList.add("hidden");

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al eliminar", "error");
            return;
        }

        if (deleteWarehouseRow) {
            const badge = deleteWarehouseRow.querySelector(".estado-toggle");
            if (badge) badge.outerHTML = `<span class="badge deleted">Eliminado</span>`;

            const actions = deleteWarehouseRow.querySelector('td[data-label="Acciones"]');
            if (actions) actions.innerHTML = "";

            deleteWarehouseRow.classList.add("deleted");
        }

        notify("Bodega eliminada", "success");
        deleteWarehouseId = null;
        deleteWarehouseRow = null;
    });
}

function initRestore() {
    document.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-restore");
        if (!btn) return;

        const data = await safeFetch(btn.dataset.url, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: btn.dataset.id }),
        });

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al restaurar", "error");
            return;
        }

        notify("Bodega restaurada", "success");
        location.reload();
    });
}

function initCloseModals() {
    document.addEventListener("click", (e) => {
        if (e.target.matches(".modal-overlay") || e.target.matches(".btn-cancel")) {
            document.querySelectorAll(".modal").forEach((m) => m.classList.add("hidden"));
        }
    });
}

Events.on("warehouses:index", () => {
    if (warehousesInitialized) return;
    warehousesInitialized = true;

    initToggle();
    initEdit();
    initUpdate();
    initDeleteModal();
    initConfirmDelete();
    initRestore();
    initCloseModals();
});