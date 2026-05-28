// ================================
// 🔥 INIT DATA TABLE PRO
// ================================
export function initDataTable(selector, entityName) {

  // 🔒 Validaciones
  if (!window.DataTable || !document.querySelector(selector)) return;

  // 🔥 destruir si ya existe
  if ($.fn.DataTable.isDataTable(selector)) {
    $(selector).DataTable().destroy();
  }

  const table = document.querySelector(selector);

  // ================================
  // 🔥 DETECTAR COLUMNA CONTROL "+"
  // ================================
  const firstTh = table.querySelector("thead th:first-child");
  const hasControlColumn = firstTh && firstTh.textContent.trim() === "";

  // ================================
  // 🔥 CONFIGURACIÓN BASE
  // ================================
  new DataTable(selector, {

    // ================================
    // RESPONSIVE INTELIGENTE
    // ================================
    responsive: hasControlColumn
      ? {
          details: {
            type: "column",
            target: 0,
          },
        }
      : false,

    // ================================
    // UI
    // ================================
    autoWidth: false,
    processing: true,

    // ================================
    // ORDEN
    // ================================
    order: [[hasControlColumn ? 1 : 0, "desc"]],

    // ================================
    // BOTONES
    // ================================
    dom: "Bfrtip",

    buttons: [
      {
        extend: "excel",
        text: "Excel",
        className: "btn-export"
      },
      {
        extend: "pdf",
        text: "PDF",
        className: "btn-export"
      },
      {
        extend: "print",
        text: "Print",
        className: "btn-export"
      }
    ],

    // ================================
    // COLUMNAS
    // ================================
    columnDefs: hasControlColumn
      ? [
          {
            className: "dtr-control",
            orderable: false,
            targets: 0,
          }
        ]
      : [],

    // ================================
    // IDIOMA
    // ================================
    language: {
      search: "Buscar:",
      lengthMenu: "Mostrar _MENU_ registros",
      info: `Mostrando _START_ a _END_ de _TOTAL_ ${entityName}`,
      infoEmpty: "Sin registros",
      zeroRecords: "No se encontraron resultados",
      paginate: {
        next: "→",
        previous: "←"
      }
    },

    // ================================
    // CALLBACKS
    // ================================
    drawCallback: function () {
      // 🔥 re-render iconos (Lucide)
      if (window.lucide) {
        lucide.createIcons();
      }
    }

  });

}