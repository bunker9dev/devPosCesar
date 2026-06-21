import { Events } from "../core/events.js";

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

document.addEventListener("DOMContentLoaded", () => {

    document.getElementById("btnApprovePedido")?.addEventListener("click", async (e) => {
        const id = e.target.dataset.id;

        const data = await safeFetch(`${window.BASE_URL}/pedidos/approve`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id }),
        });

        if (!data) return;
        if (!data.ok) { notify(data.error || "Error al aprobar", "error"); return; }

        notify("Pedido aprobado", "success");
        location.reload();
    });

    document.querySelectorAll(".btn-mark-pedido").forEach((btn) => {
        btn.addEventListener("click", async () => {
            const id = btn.dataset.id;
            const estado = btn.dataset.estado;

            const data = await safeFetch(`${window.BASE_URL}/pedidos/mark-as`, {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: new URLSearchParams({ id, estado }),
            });

            if (!data) return;
            if (!data.ok) { notify(data.error || "Error al actualizar", "error"); return; }

            notify(`Pedido marcado como ${estado}`, "success");
            location.reload();
        });
    });

});