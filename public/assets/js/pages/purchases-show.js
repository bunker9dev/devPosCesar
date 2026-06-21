import { Events } from "../core/events.js";
import { notify, safeFetch } from "../modules/purchases.js";

document.addEventListener("DOMContentLoaded", () => {

    // ============================
    // ASIGNAR VALOR
    // ============================
    const formSetPrice = document.getElementById("formSetPrice");

    formSetPrice?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const id = document.getElementById("setPriceId").value;
        const total = document.getElementById("setPriceTotal").value;

        const data = await safeFetch(`${window.BASE_URL}/purchases/set-price`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ id, total }),
        });

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al asignar valor", "error");
            return;
        }

        notify("Valor asignado correctamente", "success");
        location.reload();
    });

    // ============================
    // REGISTRAR PAGO
    // ============================
    const formPayment = document.getElementById("formRegisterPayment");

    formPayment?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const purchase_id = document.getElementById("paymentPurchaseId").value;
        const fecha_pago = document.getElementById("paymentFecha").value;
        const monto = document.getElementById("paymentMonto").value;
        const metodo_pago = document.getElementById("paymentMetodo").value;
        const referencia = document.getElementById("paymentReferencia").value;

        const data = await safeFetch(`${window.BASE_URL}/purchases/register-payment`, {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams({ purchase_id, fecha_pago, monto, metodo_pago, referencia }),
        });

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al registrar el pago", "error");
            return;
        }

        notify("Pago registrado correctamente", "success");
        location.reload();
    });

});