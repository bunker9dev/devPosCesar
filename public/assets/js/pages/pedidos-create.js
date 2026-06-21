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

let itemsPendientes = [];

document.addEventListener("DOMContentLoaded", () => {

    document.getElementById("btnAgregarItem")?.addEventListener("click", () => {
        const tipoSelect = document.getElementById("itemFabricType");
        const colorSelect = document.getElementById("itemFabricColor");
        const cantidadInput = document.getElementById("itemCantidad");
        const unidadSelect = document.getElementById("itemUnidad");
        const notaInput = document.getElementById("itemNota");

        if (!tipoSelect.value || !colorSelect.value) {
            notify("Selecciona tipo de tela y color", "error");
            return;
        }

        const cantidad = parseFloat(cantidadInput.value);

        if (!cantidad || cantidad <= 0) {
            notify("La cantidad debe ser mayor a cero", "error");
            return;
        }

        itemsPendientes.push({
            fabric_type_id: tipoSelect.value,
            fabric_color_id: colorSelect.value,
            tipo_nombre: tipoSelect.selectedOptions[0].dataset.nombre,
            color_nombre: colorSelect.selectedOptions[0].dataset.nombre,
            cantidad: cantidad,
            unidad: unidadSelect.value,
            nota: notaInput.value.trim(),
        });

        renderItems();

        tipoSelect.value = "";
        colorSelect.value = "";
        cantidadInput.value = "";
        notaInput.value = "";

        notify("Tela agregada al pedido", "success");
    });

    function renderItems() {
        const tbody = document.getElementById("itemsPendientesBody");
        tbody.innerHTML = "";

        if (itemsPendientes.length === 0) {
            tbody.innerHTML = `<tr id="emptyItemsRow"><td colspan="6" class="empty-state">Todavía no has agregado ninguna tela.</td></tr>`;
            return;
        }

        itemsPendientes.forEach((item, index) => {
            const tr = document.createElement("tr");
            tr.innerHTML = `
                <td>${item.tipo_nombre}</td>
                <td>${item.color_nombre}</td>
                <td>${item.cantidad}</td>
                <td>${item.unidad === 'rollos' ? 'Rollos' : 'Metros'}</td>
                <td>${item.nota || '-'}</td>
                <td><button type="button" class="btn-action delete btn-quitar-item" data-index="${index}">Quitar</button></td>
            `;
            tbody.appendChild(tr);
        });
    }

    document.addEventListener("click", (e) => {
        const btn = e.target.closest(".btn-quitar-item");
        if (!btn) return;
        itemsPendientes.splice(parseInt(btn.dataset.index, 10), 1);
        renderItems();
    });

    document.getElementById("btnGuardarPedido")?.addEventListener("click", async () => {
        const supplierId = document.getElementById("headerSupplierId").value;
        const fecha = document.getElementById("headerFecha").value;
        const observaciones = document.getElementById("headerObservaciones").value.trim();

        if (!supplierId) { notify("Selecciona un proveedor", "error"); return; }
        if (!fecha) { notify("La fecha es obligatoria", "error"); return; }
        if (itemsPendientes.length === 0) { notify("Agrega al menos una tela", "error"); return; }

        const btn = document.getElementById("btnGuardarPedido");
        btn.disabled = true;
        btn.textContent = "Guardando...";

        const formData = new FormData();
        formData.append("supplier_id", supplierId);
        formData.append("fecha_solicitud", fecha);
        formData.append("observaciones", observaciones);
        formData.append("items_json", JSON.stringify(itemsPendientes));

        const data = await safeFetch(`${window.BASE_URL}/pedidos/store`, {
            method: "POST",
            body: formData,
        });

        btn.disabled = false;
        btn.textContent = "Guardar pedido";

        if (!data) return;

        if (!data.ok) {
            notify(data.error || "Error al crear el pedido", "error");
            return;
        }

        notify(`Pedido ${data.consecutivo} creado`, "success");

        setTimeout(() => {
            window.location.href = `${window.BASE_URL}/pedidos/show?id=${data.id}`;
        }, 1000);
    });

});