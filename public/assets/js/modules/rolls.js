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
  document.addEventListener("click", async (e) => {
    const btn = e.target.closest(".btn-edit-lote");
    if (!btn) return;

    const data = await safeFetch(
      `${window.BASE_URL}/rolls/edit-data?id=${btn.dataset.id}`,
      {
        method: "GET",
      },
    );

    if (!data) return;

    if (!data.ok) {
      notify(data.error || "Error al cargar el lote", "error");
      return;
    }

    const lote = data.lote;

    document.getElementById("editLoteId").value = lote.id;
    document.getElementById("editLoteCodigoActual").textContent = lote.codigo;
    document.getElementById("editLoteFabricType").value = lote.fabric_type_id;
    document.getElementById("editLoteFabricColor").value = lote.fabric_color_id;
    document.getElementById("editLoteSupplier").value = lote.supplier_id;
    document.getElementById("editLoteWarehouse").value = lote.warehouse_id;
    document.getElementById("editLoteFecha").value = lote.fecha_compra;
    document.getElementById("editLoteMetraje").value = lote.metraje_por_rollo;

    // Solo si el campo existe (depende del permiso view_price)
    const precioInput = document.getElementById("editLotePrecio");
    if (precioInput) {
      precioInput.value = lote.precio_compra || "";
    }

    document.getElementById("modalEditLote")?.classList.remove("hidden");
  });
}

function initUpdate() {
  const form = document.getElementById("formEditLote");
  if (!form) return;

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const payload = {
      id: document.getElementById("editLoteId").value,
      fabric_type_id: document.getElementById("editLoteFabricType").value,
      fabric_color_id: document.getElementById("editLoteFabricColor").value,
      supplier_id: document.getElementById("editLoteSupplier").value,
      warehouse_id: document.getElementById("editLoteWarehouse").value,
      fecha_compra: document.getElementById("editLoteFecha").value,
      metraje_por_rollo: document.getElementById("editLoteMetraje").value,
    };

    // Solo se incluye si el usuario puede ver/editar precio
    const precioInput = document.getElementById("editLotePrecio");
    if (precioInput) {
      payload.precio_compra = precioInput.value;
    }

    const data = await safeFetch(`${window.BASE_URL}/rolls/update`, {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: new URLSearchParams(payload),
    });

    if (!data) return;

    if (!data.ok) {
      notify(data.error || "Error al actualizar", "error");
      return;
    }

    document.getElementById("modalEditLote").classList.add("hidden");
    notify(`Lote actualizado. Nuevo código: ${data.codigo}`, "success");
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
      document
        .querySelectorAll(".modal")
        .forEach((m) => m.classList.add("hidden"));
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
