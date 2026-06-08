import { initDataTable } from "./table.js";

export function initUsersTable() {
    initDataTable("#tablaUsuarios", {

        // =================================================
        // PRIORIDAD RESPONSIVE (CLAVE)
        // =================================================
        columnDefs: [
            {
                className: "dtr-control",
                orderable: false,
                targets: 0,
            },
            {
                responsivePriority: 1,
                targets: 2, // usuario
            },
            {
                responsivePriority: 2,
                targets: -1, // acciones
            },
            {
                responsivePriority: 3,
                targets: 3, // nombre
            },
            {
                targets: -1,
                orderable: false,
                searchable: false,
            },
        ],

        // =================================================
        // ORDEN PERSONALIZADO
        // =================================================
        order: [[1, "desc"]],

    });
}