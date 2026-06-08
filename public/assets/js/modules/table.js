// =========================================================
// CORE TABLE PRO (REUTILIZABLE)
// =========================================================

export function initDataTable(selector, options = {}) {
    const table = document.querySelector(selector);
    if (!table) return;

    return $(selector).DataTable({

        // =================================================
        // RESPONSIVE
        // =================================================
        responsive: {
            details: {
                type: "column",
                target: 0,
            },
            breakpoints: [
                { name: "desktop", width: Infinity },
                { name: "tablet", width: 1024 },
                { name: "mobile", width: 600 },
            ],
        },

        autoWidth: false,

        // =================================================
        // COLUMNAS
        // =================================================
        columnDefs: [
            {
                className: "dtr-control",
                orderable: false,
                targets: 0,
            },
            {
                targets: -1,
                orderable: false,
                searchable: false,
            },
        ],

        order: [[1, "desc"]],

        // =================================================
        // DOM LAYOUT (MISMO QUE USERS)
        // =================================================
        dom:
            "<'dt-header d-flex justify-between'Bf>" +
            "<'dt-table'tr>" +
            "<'dt-footer d-flex justify-between'lp>",

        // =================================================
        // BOTONES EXPORT
        // =================================================
        buttons: [
            {
                extend: "excel",
                text: "Excel",
                className: "btn-action"
            },
            {
                extend: "pdf",
                text: "PDF",
                className: "btn-action"
            },
            {
                extend: "print",
                text: "Imprimir",
                className: "btn-action"
            }
        ],

        // =================================================
        // IDIOMA
        // =================================================
        language: {
            search: "Buscar:",
            lengthMenu: "Mostrar _MENU_ registros",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            zeroRecords: "No hay resultados",
            paginate: {
                next: "→",
                previous: "←",
            },
        },

        // =================================================
        // EXTENSIÓN POR MÓDULO
        // =================================================
        ...options
    });
}