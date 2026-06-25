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

try {
  const raw = document.getElementById("itemsExistentes")?.textContent || "[]";
  itemsPendientes = JSON.parse(raw);
} catch (e) {
  console.error("Error al cargar items existentes:", e);
}

function renderItems() {
  const tbody = document.getElementById("itemsPendientesBody");
  tbody.innerHTML = "";

  if (itemsPendientes.length === 0) {
    tbody.innerHTML = `<tr><td colspan="6" class="empty-state">No hay telas en este pedido.</td></tr>`;
    return;
  }

  itemsPendientes.forEach((item, index) => {
    const tr = document.createElement("tr");
    tr.innerHTML = `
        <td>${item.tipo_nombre}</td>
        <td>${item.color_nombre}</td>
        <td>${item.cantidad}</td>
        <td>${item.unidad === "rollos" ? "Rollos" : "Metros"}</td>
        <td>${item.nota || "-"}</td>
        <td>
            <button type="button" class="btn-action edit btn-editar-item" data-index="${index}">Editar</button>
            <button type="button" class="btn-action delete btn-quitar-item" data-index="${index}">Quitar</button>
        </td>
    `;
    tbody.appendChild(tr);
  });
}

document.addEventListener("DOMContentLoaded", () => {
  renderItems();

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

    const existente = itemsPendientes.find(
      (item) =>
        item.fabric_type_id === tipoSelect.value &&
        item.fabric_color_id === colorSelect.value &&
        item.unidad === unidadSelect.value,
    );

    if (existente) {
      existente.cantidad = parseFloat(
        (existente.cantidad + cantidad).toFixed(2),
      );
      if (notaInput.value.trim()) {
        existente.nota = existente.nota
          ? existente.nota + " | " + notaInput.value.trim()
          : notaInput.value.trim();
      }
      notify(
        `Se sumó a la tela existente: ahora son ${existente.cantidad} ${unidadSelect.value}`,
        "success",
      );
    } else {
      itemsPendientes.push({
        fabric_type_id: tipoSelect.value,
        fabric_color_id: colorSelect.value,
        tipo_nombre: tipoSelect.selectedOptions[0].dataset.nombre,
        color_nombre: colorSelect.selectedOptions[0].dataset.nombre,
        cantidad: cantidad,
        unidad: unidadSelect.value,
        nota: notaInput.value.trim(),
      });
      notify("Tela agregada al pedido", "success");
    }

    renderItems();

    tipoSelect.value = "";
    colorSelect.value = "";
    cantidadInput.value = "";
    notaInput.value = "";
  });

  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-quitar-item");
    if (!btn) return;
    itemsPendientes.splice(parseInt(btn.dataset.index, 10), 1);
    renderItems();
  });

  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-editar-item");
    if (!btn) return;

    const index = parseInt(btn.dataset.index, 10);
    const item = itemsPendientes[index];

    if (!item) return;

    document.getElementById("itemFabricType").value = item.fabric_type_id;
    document.getElementById("itemFabricColor").value = item.fabric_color_id;
    document.getElementById("itemCantidad").value = item.cantidad;
    document.getElementById("itemUnidad").value = item.unidad;
    document.getElementById("itemNota").value = item.nota || "";

    itemsPendientes.splice(index, 1);
    renderItems();

    notify(
      "Edita los datos y vuelve a dar '+ Agregar tela al pedido'",
      "success",
    );

    document
      .getElementById("itemFabricType")
      ?.scrollIntoView({ behavior: "smooth", block: "center" });
  });

  document
    .getElementById("btnGuardarPedido")
    ?.addEventListener("click", async () => {
      const supplierId = document.getElementById("headerSupplierId").value;
      const fecha = document.getElementById("headerFecha").value;
      const observaciones = document
        .getElementById("headerObservaciones")
        .value.trim();

      if (!supplierId) {
        notify("Selecciona un proveedor", "error");
        return;
      }
      if (!fecha) {
        notify("La fecha es obligatoria", "error");
        return;
      }
      if (itemsPendientes.length === 0) {
        notify("El pedido debe tener al menos una tela", "error");
        return;
      }

      const btn = document.getElementById("btnGuardarPedido");
      btn.disabled = true;
      btn.textContent = "Guardando...";

      const formData = new FormData();
      formData.append("id", window.PEDIDO_ID);
      formData.append("supplier_id", supplierId);
      formData.append("fecha_solicitud", fecha);
      formData.append("observaciones", observaciones);
      formData.append("items_json", JSON.stringify(itemsPendientes));

      const data = await safeFetch(`${window.BASE_URL}/pedidos/update`, {
        method: "POST",
        body: formData,
      });

      btn.disabled = false;
      btn.textContent = "Guardar cambios";

      if (!data) return;

      if (!data.ok) {
        notify(data.error || "Error al actualizar", "error");
        return;
      }

      notify("Pedido actualizado", "success");

      setTimeout(() => {
        window.location.href = `${window.BASE_URL}/pedidos/show?id=${window.PEDIDO_ID}`;
      }, 1000);
    });
});
