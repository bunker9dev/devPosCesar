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
// ESTADO EN MEMORIA — los lotes viven aquí hasta "Cerrar compra"
// =========================================================
let lotesPendientes = [];

document.addEventListener("DOMContentLoaded", () => {

    // =====================================================
    // MOSTRAR/OCULTAR PLAZO DE DÍAS
    // =====================================================
    const condicionPago = document.getElementById("headerCondicionPago");
    const plazoDiasGroup = document.getElementById("headerPlazoDiasGroup");

    function togglePlazo() {
        const esCredito = condicionPago.value === "credito";
        plazoDiasGroup.style.display = esCredito ? "block" : "none";
    }

    condicionPago?.addEventListener("change", togglePlazo);
    togglePlazo();

    // =====================================================
    // MODAL DE PROVEEDOR RÁPIDO
    // =====================================================
    const btnOpenQuickSupplier = document.getElementById("btnOpenQuickSupplier");
    const modalQuickSupplier = document.getElementById("modalQuickSupplier");
    const formQuickSupplier = document.getElementById("formQuickSupplier");

    btnOpenQuickSupplier?.addEventListener("click", () => {
        modalQuickSupplier?.classList.remove("hidden");
    });

    formQuickSupplier?.addEventListener("submit", async (e) => {
        e.preventDefault();

        const data = await safeFetch(`${window.BASE_URL}/purchases/quick-supplier`, {
            method: "POST",
            body: new FormData(formQuickSupplier),
        });

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al crear proveedor", "error");
            return;
        }

        modalQuickSupplier?.classList.add("hidden");
        formQuickSupplier.reset();
        notify(`Proveedor "${data.supplier.nombre}" creado`, "success");

        const select = document.getElementById("headerSupplierId");
        const option = document.createElement("option");
        option.value = data.supplier.id;
        option.textContent = data.supplier.nombre;
        option.selected = true;
        select.appendChild(option);
    });

    document.addEventListener("click", (e) => {
        if (e.target.matches(".modal-overlay") || e.target.matches(".btn-cancel")) {
            document.querySelectorAll(".modal").forEach((m) => m.classList.add("hidden"));
        }
    });

    // =====================================================
    // AGREGAR LOTE A LA LISTA EN MEMORIA
    // =====================================================
    const btnAgregarLote = document.getElementById("btnAgregarLote");

    btnAgregarLote?.addEventListener("click", () => {

        const tipoSelect = document.getElementById("loteFabricType");
        const colorSelect = document.getElementById("loteFabricColor");
        const warehouseSelect = document.getElementById("loteWarehouse");
        const metrajeInput = document.getElementById("loteMetraje");
        const cantidadInput = document.getElementById("loteCantidad");
        const precioInput = document.getElementById("lotePrecio");

        const tipoOption = tipoSelect.selectedOptions[0];
        const colorOption = colorSelect.selectedOptions[0];
        const warehouseOption = warehouseSelect.selectedOptions[0];

        // ============================
        // VALIDACIÓN BÁSICA
        // ============================
        if (!tipoSelect.value || !colorSelect.value || !warehouseSelect.value) {
            notify("Selecciona tipo de tela, color y bodega", "error");
            return;
        }

        const metraje = parseFloat(metrajeInput.value);
        const cantidad = parseInt(cantidadInput.value, 10);

        if (!metraje || metraje <= 0) {
            notify("El metraje debe ser mayor a cero", "error");
            return;
        }

        if (!cantidad || cantidad < 1 || cantidad > 200) {
            notify("La cantidad debe estar entre 1 y 200", "error");
            return;
        }

        const precio = precioInput && precioInput.value !== "" ? parseFloat(precioInput.value) : null;

        const lote = {
            fabric_type_id: tipoSelect.value,
            fabric_color_id: colorSelect.value,
            warehouse_id: warehouseSelect.value,
            tipo_nombre: tipoOption.dataset.nombre,
            color_nombre: colorOption.dataset.nombre,
            warehouse_nombre: warehouseOption.dataset.nombre,
            tipo_codigo: tipoOption.dataset.codigo,
            color_codigo: colorOption.dataset.codigo,
            metraje_por_rollo: metraje,
            cantidad: cantidad,
            precio_compra: precio,
        };

        lotesPendientes.push(lote);
        renderLotes();

        // Limpiar el mini-formulario para el siguiente lote
        tipoSelect.value = "";
        colorSelect.value = "";
        warehouseSelect.value = "";
        metrajeInput.value = "";
        cantidadInput.value = "1";
        if (precioInput) precioInput.value = "";

        notify("Tela agregada a la compra", "success");
    });

    // =====================================================
    // RENDERIZAR LA TABLA DE LOTES PENDIENTES
    // =====================================================
    function renderLotes() {
        const tbody = document.getElementById("lotesPendientesBody");
        const totalEstimadoEl = document.getElementById("totalEstimado");
        const canViewPrice = !!document.getElementById("lotePrecio") || !!totalEstimadoEl;

        tbody.innerHTML = "";

        if (lotesPendientes.length === 0) {
            const colspan = canViewPrice ? 8 : 6;
            tbody.innerHTML = `<tr id="emptyLotesRow"><td colspan="${colspan}" class="empty-state">Todavía no has agregado ninguna tela.</td></tr>`;
            if (totalEstimadoEl) totalEstimadoEl.textContent = "$0.00";
            return;
        }

        let totalEstimado = 0;

        lotesPendientes.forEach((lote, index) => {
            const subtotal = lote.precio_compra ? lote.metraje_por_rollo * lote.cantidad * lote.precio_compra : null;

            if (subtotal) totalEstimado += subtotal;

            const tr = document.createElement("tr");

            let rowHtml = `
                <td>${lote.tipo_nombre}</td>
                <td>${lote.color_nombre}</td>
                <td>${lote.warehouse_nombre}</td>
                <td>${lote.metraje_por_rollo}</td>
                <td>${lote.cantidad}</td>
            `;

            if (canViewPrice) {
                rowHtml += `
                    <td>${lote.precio_compra ? '$' + lote.precio_compra.toFixed(2) : '-'}</td>
                    <td>${subtotal ? '$' + subtotal.toFixed(2) : '-'}</td>
                `;
            }

            rowHtml += `
                <td>
                    <button type="button" class="btn-action delete btn-quitar-lote" data-index="${index}">
                        Quitar
                    </button>
                </td>
            `;

            tr.innerHTML = rowHtml;
            tbody.appendChild(tr);
        });

        if (totalEstimadoEl) {
            totalEstimadoEl.textContent = '$' + totalEstimado.toFixed(2);
        }
    }

    // =====================================================
    // QUITAR UN LOTE DE LA LISTA
    // =====================================================
    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-quitar-lote");
        if (!btn) return;

        const index = parseInt(btn.dataset.index, 10);
        lotesPendientes.splice(index, 1);
        renderLotes();
    });

    // =====================================================
    // CERRAR COMPRA — ENVÍA TODO DE UNA SOLA VEZ
    // =====================================================
    const btnCerrarCompra = document.getElementById("btnCerrarCompra");

    btnCerrarCompra?.addEventListener("click", async () => {

        const supplierId = document.getElementById("headerSupplierId").value;
        const numeroDocumento = document.getElementById("headerNumeroDocumento").value.trim();
        const fecha = document.getElementById("headerFecha").value;
        const condicionPago = document.getElementById("headerCondicionPago").value;
        const plazoDias = document.getElementById("headerPlazoDias")?.value || "";
        const observaciones = document.getElementById("headerObservaciones").value.trim();

        if (!supplierId) {
            notify("Selecciona un proveedor", "error");
            return;
        }

        if (!numeroDocumento) {
            notify("El número de documento es obligatorio", "error");
            return;
        }

        if (!fecha) {
            notify("La fecha de compra es obligatoria", "error");
            return;
        }

        if (condicionPago === "credito" && !plazoDias) {
            notify("Selecciona el plazo de pago", "error");
            return;
        }

        if (lotesPendientes.length === 0) {
            notify("Agrega al menos una tela antes de cerrar la compra", "error");
            return;
        }

        btnCerrarCompra.disabled = true;
        btnCerrarCompra.textContent = "Guardando...";

        const formData = new FormData();
        formData.append("supplier_id", supplierId);
        formData.append("numero_documento", numeroDocumento);
        formData.append("fecha", fecha);
        formData.append("condicion_pago", condicionPago);
        formData.append("plazo_dias", plazoDias);
        formData.append("observaciones", observaciones);
        formData.append("lotes_json", JSON.stringify(lotesPendientes));

        const data = await safeFetch(`${window.BASE_URL}/purchases/store`, {
            method: "POST",
            body: formData,
        });

        btnCerrarCompra.disabled = false;
        btnCerrarCompra.textContent = "Cerrar compra";

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al crear la compra", "error");
            return;
        }

        notify(`Compra creada con ${data.total_rollos} rollo(s)`, "success");

        setTimeout(() => {
            window.location.href = `${window.BASE_URL}/purchases/show?id=${data.purchase_id}`;
        }, 1200);
    });

});