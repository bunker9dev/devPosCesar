import { Events } from "../core/events.js";
import { initDataTable } from "./table.js";

let rollsInitialized = false;
let deleteLoteId = null;

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

function initEdit() {
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-edit-lote");
        if (!btn) return;

        document.getElementById("editLoteId").value = btn.dataset.id;
        document.getElementById("editLoteWarehouse").value = btn.dataset.warehouse;
        document.getElementById("editLotePrecio").value = btn.dataset.precio || "";

        document.getElementById("modalEditLote")?.classList.remove("hidden");
    });
}

function initUpdate() {
    const form = document.getElementById("formEditLote");
    if (!form) return;

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const id = document.getElementById("editLoteId").value;
        const warehouse_id = document.getElementById("editLoteWarehouse").value;
        const precio_compra = document.getElementById("editLotePrecio").value;

        const data = await safeFetch(`${window.BASE_URL}/rolls/update`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id, warehouse_id, precio_compra }),
        });

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al actualizar", "error");
            return;
        }

        document.getElementById("modalEditLote").classList.add("hidden");
        notify("Lote actualizado", "success");
        location.reload();
    });
}

function initDeleteModal() {
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-delete-lote");
        if (!btn) return;

        deleteLoteId = btn.dataset.id;

        const msg = document.getElementById("deleteLoteMessage");
        if (msg) msg.textContent = `¿Eliminar el lote "${btn.dataset.codigo}"?`;

        document.getElementById("modalDeleteLote")?.classList.remove("hidden");
    });
}

function initConfirmDelete() {
    const btn = document.getElementById("btnConfirmDeleteLote");
    if (!btn) return;

    btn.addEventListener("click", async () => {
        if (!deleteLoteId) return;

        const data = await safeFetch(`${window.BASE_URL}/rolls/delete`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: deleteLoteId }),
        });

        document.getElementById("modalDeleteLote").classList.add("hidden");

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al eliminar", "error");
            return;
        }

        notify("Lote eliminado", "success");
        location.reload();
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

        notify("Lote restaurado", "success");
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

Events.on("rolls:index", () => {
    if (rollsInitialized) return;
    rollsInitialized = true;

    initDataTable("#tablaRolls");
    initEdit();
    initUpdate();
    initDeleteModal();
    initConfirmDelete();
    initRestore();
    initCloseModals();
});