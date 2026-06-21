import { Events } from "../core/events.js";
import { initDataTable } from "./table.js";

let purchasesIndexInitialized = false;
let deletePurchaseId = null;

export function notify(message, type = "success") {
    Events.emit("alerts:show", { type, message });
}

export async function safeFetch(url, options) {
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

function initDeleteModal() {
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-delete-purchase");
        if (!btn) return;

        deletePurchaseId = btn.dataset.id;

        const msg = document.getElementById("deletePurchaseMessage");
        if (msg) msg.textContent = `¿Eliminar la compra "${btn.dataset.doc}"?`;

        document.getElementById("modalDeletePurchase")?.classList.remove("hidden");
    });
}

function initConfirmDelete() {
    const btn = document.getElementById("btnConfirmDeletePurchase");
    if (!btn) return;

    btn.addEventListener("click", async () => {
        if (!deletePurchaseId) return;

        const data = await safeFetch(`${window.BASE_URL}/purchases/delete`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: deletePurchaseId }),
        });

        document.getElementById("modalDeletePurchase").classList.add("hidden");

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al eliminar", "error");
            return;
        }

        notify("Compra eliminada", "success");
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

        notify("Compra restaurada", "success");
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

// ======================================================
// MODAL DE PROVEEDOR RÁPIDO (reutilizado en create.php y show.php)
// ======================================================
export function initQuickSupplier(onCreated) {
    const btnOpen = document.getElementById("btnOpenQuickSupplier");
    const modal = document.getElementById("modalQuickSupplier");
    const form = document.getElementById("formQuickSupplier");

    btnOpen?.addEventListener("click", () => {
        modal?.classList.remove("hidden");
    });

    form?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const data = await safeFetch(`${window.BASE_URL}/purchases/quick-supplier`, {
            method: "POST",
            body: new FormData(form),
        });

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al crear proveedor", "error");
            return;
        }

        modal?.classList.add("hidden");
        form.reset();
        notify(`Proveedor "${data.supplier.nombre}" creado`, "success");

        if (onCreated) onCreated(data.supplier);
    });
}

Events.on("purchases:index", () => {
    if (purchasesIndexInitialized) return;
    purchasesIndexInitialized = true;

    initDataTable("#tablaPurchases");
    initDeleteModal();
    initConfirmDelete();
    initRestore();
    initCloseModals();
});