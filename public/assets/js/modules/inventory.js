import { Events } from "../core/events.js";
import { post } from "../core/api.js";


export function initDataTable(selector, entityName) {
  if (!window.DataTable || !document.querySelector(selector)) return;

  if ($.fn.DataTable.isDataTable(selector)) {
    $(selector).DataTable().destroy();
  }

  new DataTable(selector, {
    responsive: window.matchMedia("(max-width: 460px)").matches
      ? false
      : {
          details: {
            type: "column",
            target: 0,
          },
        },
    autoWidth: false,
    order: [[1, "desc"]],
    dom: "Bfrtip",
    buttons: [
      { extend: "excel", text: "Excel" },
      { extend: "pdf", text: "PDF" },
      { extend: "print", text: "Print" },
    ],
    columnDefs: [
      {
        className: "dtr-control",
        orderable: false,
        targets: 0,
      },
    ],
    language: {
      search: "Buscar:",
      info: `Mostrando _START_ a _END_ de _TOTAL_ ${entityName}`,
      paginate: {
        next: "→",
        previous: "←",
      },
    },
  });
}

function renderRollFound(roll) {
  const target = document.getElementById("scannerResult");
  if (!target) return;

  target.className = "scan-result found";
  target.innerHTML = `
    <strong>${roll.codigo_barra}</strong>
    <span>${roll.codigo_visible}</span>
    <span>${roll.tipo_tela} / ${roll.color}</span>
    <span>${Number(roll.metros).toFixed(2)} m - ${roll.bodega}</span>
  `;
}

function renderRollError(message) {
  const target = document.getElementById("scannerResult");
  if (!target) return;

  target.className = "scan-result error";
  target.textContent = message || "Rollo no encontrado";
}

function initRollScanner() {
  const scanner = document.getElementById("globalRollScanner");
  if (!scanner) return;

  scanner.focus();

  scanner.addEventListener("keydown", async (event) => {
    if (event.key !== "Enter") return;

    event.preventDefault();

    const code = scanner.value.trim();
    if (!code) return;

    const response = await post("/rolls/search", { code });

    if (!response.ok) {
      renderRollError(response.error);
      Events.emit("roll:not-found", { code });
      return;
    }

    renderRollFound(response.roll);
    Events.emit("roll:found", response.roll);
    scanner.select();
  });
}

function initMovementForm() {
  const form = document.getElementById("movementForm");
  if (!form) return;

  const rollInput = document.getElementById("movementRollId");
  const metersInput = form.querySelector('input[name="metros"]');

  Events.on("roll:found", (roll) => {
    rollInput.value = roll.id;
    if (metersInput && !metersInput.value) {
      metersInput.value = Number(roll.metros).toFixed(2);
    }
  });

  form.addEventListener("submit", async (event) => {
    event.preventDefault();

    if (!rollInput.value) {
      renderRollError("Escanea un rollo antes de registrar el movimiento");
      return;
    }

    const data = Object.fromEntries(new FormData(form).entries());
    const response = await post("/movements/store", data);

    if (!response.ok) {
      renderRollError(response.error);
      return;
    }

    Events.emit("alerts:show", {
      type: "success",
      message: "Movimiento registrado",
    });

    setTimeout(() => window.location.reload(), 500);
  });
}

function initSidebar() {
  const toggles = document.querySelectorAll(".sidebar-group-toggle");

  if (!toggles.length) return;

  toggles.forEach((toggle) => {
    toggle.addEventListener("click", () => {
      const parent = toggle.closest(".sidebar-group");
      const isOpen = parent.classList.contains("open");

      // cerrar todos (acordeón)
      document.querySelectorAll(".sidebar-group").forEach((group) => {
        group.classList.remove("open");
        group
          .querySelector(".sidebar-group-toggle")
          ?.setAttribute("aria-expanded", "false");
      });

      // abrir actual
      if (!isOpen) {
        parent.classList.add("open");
        toggle.setAttribute("aria-expanded", "true");
      }
    });
  });

  // 🔥 mantener activo según URL
  const currentUrl = window.location.pathname;

  document.querySelectorAll(".sidebar-submenu a").forEach((link) => {
    if (currentUrl.includes(link.getAttribute("href"))) {
      const parent = link.closest(".sidebar-group");

      parent.classList.add("open");
      parent
        .querySelector(".sidebar-group-toggle")
        ?.setAttribute("aria-expanded", "true");
    }
  });
}



Events.on("inventory:rolls", () => {
  initDataTable("#tablaRolls", "rollos");
  initRollScanner();
});

Events.on("inventory:products", () => {
  initDataTable("#tablaProducts", "productos");
});

Events.on("inventory:types", () => {
  initDataTable("#tablaFabricTypes", "tipos de tela");
});

Events.on("inventory:colors", () => {
  initDataTable("#tablaFabricColors", "colores");
});

Events.on("inventory:movements", () => {
  initDataTable("#tablaMovements", "movimientos");
  initRollScanner();
  initMovementForm();
});

Events.on("inventory:purchases", () => {
  initDataTable("#tablaPurchases", "compras");
});

Events.on("app:init", () => {
  initSidebar();
});