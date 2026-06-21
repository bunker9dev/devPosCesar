import { Events } from "../core/events.js";
import { initDataTable } from "../modules/table.js";

function notify(message, type = "success") {
    Events.emit("alerts:show", { type, message });
}

async function safeFetch(url, options) {
    try {
        const response = await fetch(url, options);
        const text = await response.text();
        try {
            return JSON.parse(text);
        } catch (e) {
            notify("Error del servidor", "error");
            return null;
        }
    } catch (error) {
        notify("Error de conexión", "error");
        return null;
    }
}

let deletePedidoId = null;

document.addEventListener("DOMContentLoaded", () => {
    initDataTable("#tablaPedidos");

    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-delete-pedido");
        if (btn) {
            deletePedidoId = btn.dataset.id;
            document.getElementById("deletePedidoMessage").textContent = `¿Eliminar el pedido "${btn.dataset.consecutivo}"?`;
            document.getElementById("modalDeletePedido")?.classList.remove("hidden");
            return;
        }

        if (e.target.matches(".modal-overlay") || e.target.matches(".btn-cancel")) {
            document.querySelectorAll(".modal").forEach((m) => m.classList.add("hidden"));
        }
    });

    document.getElementById("btnConfirmDeletePedido")?.addEventListener("click", async () => {
        const data = await safeFetch(`${window.BASE_URL}/pedidos/delete`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: deletePedidoId }),
        });

        document.getElementById("modalDeletePedido").classList.add("hidden");

        if (!data) return;
        if (!data.ok) { notify(data.error || "Error al eliminar", "error"); return; }

        notify("Pedido eliminado", "success");
        location.reload();
    });

    document.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-restore");
        if (!btn) return;

        const data = await safeFetch(btn.dataset.url, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id: btn.dataset.id }),
        });

        if (!data) return;
        if (!data.ok) { notify(data.error || "Error al restaurar", "error"); return; }

        notify("Pedido restaurado", "success");
        location.reload();
    });
});