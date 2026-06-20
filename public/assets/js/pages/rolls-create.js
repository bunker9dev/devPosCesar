import { Events } from "../core/events.js";

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

function pad(value, size) {
    return String(value).padStart(size, "0");
}

function extractNumeric(codigo) {
    const match = String(codigo || "").match(/(\d+)$/);
    return match ? match[1] : "0";
}

// =========================================================
// VISTA PREVIA EN VIVO DEL CÓDIGO DE LOTE
// =========================================================
function updateCodePreview() {
    const preview = document.getElementById("lotePreview");
    const hint = document.getElementById("rollPreviewHint");
    if (!preview) return;

    const supplierSelect = document.getElementById("createSupplier");
    const fechaInput = document.getElementById("createFechaCompra");
    const tipoSelect = document.getElementById("createFabricType");
    const colorSelect = document.getElementById("createFabricColor");
    const metrajeInput = document.getElementById("createMetraje");

    const supplierId = supplierSelect?.value;
    const fecha = fechaInput?.value; // YYYY-MM-DD
    const tipoOption = tipoSelect?.selectedOptions[0];
    const colorOption = colorSelect?.selectedOptions[0];
    const metrajeRaw = metrajeInput?.value;

    if (!supplierId || !fecha || !tipoOption?.value || !colorOption?.value || !metrajeRaw) {
        preview.value = "";
        if (hint) hint.textContent = "";
        return;
    }

    const proveedorPart = pad(supplierId, 3);
    const fechaPart = fecha.replace(/-/g, "");

    const tipoPart = pad(extractNumeric(tipoOption.dataset.codigo), 3);
    const colorPart = pad(extractNumeric(colorOption.dataset.codigo), 3);

    const metraje = parseFloat(metrajeRaw) || 0;
    const metrosEnteros = Math.floor(metraje);
    const centimetros = Math.round((metraje - metrosEnteros) * 100);

    const metrosPart = pad(metrosEnteros, 3);
    const cmPart = pad(centimetros, 2);

    const loteCodigo = proveedorPart + fechaPart + tipoPart + colorPart + metrosPart + cmPart;

    preview.value = loteCodigo;

    // if (hint) {
    //     hint.textContent = `El primer rollo de este lote sería: ${loteCodigo}0001`;
    // }
   
}

document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("formCreateRoll");
    if (!form) return;

    ["createSupplier", "createFechaCompra", "createFabricType", "createFabricColor", "createMetraje"]
        .forEach((id) => {
            document.getElementById(id)?.addEventListener("input", updateCodePreview);
            document.getElementById(id)?.addEventListener("change", updateCodePreview);
        });

    form.addEventListener("submit", async (e) => {
        e.preventDefault();

        const data = await safeFetch(`${window.BASE_URL}/rolls/store`, {
            method: "POST",
            body: new FormData(form),
        });

        if (!data) return;

        // CONFLICTO: ya existe un lote idéntico
        if (data.conflict) {
            const confirmar = confirm(data.message);
            if (!confirmar) return;

            const formData = new FormData(form);
            formData.append("confirm_merge", "1");

            const data2 = await safeFetch(`${window.BASE_URL}/rolls/store`, {
                method: "POST",
                body: formData,
            });

            if (!data2 || !data2.ok) {
                notify(data2?.error || "Error al agregar al lote existente", "error");
                return;
            }

            notify(`Se agregaron ${data2.codes.length} rollo(s) al lote ${data2.lote_codigo}`, "success");
            setTimeout(() => (window.location.href = `${window.BASE_URL}/rolls`), 1200);
            return;
        }

        if (!data.ok) {
            notify(data.error || "Error al crear rollo(s)", "error");
            return;
        }

        notify(`Se creó el lote ${data.lote_codigo} con ${data.codes.length} rollo(s)`, "success");
        setTimeout(() => (window.location.href = `${window.BASE_URL}/rolls`), 1200);
    });
});