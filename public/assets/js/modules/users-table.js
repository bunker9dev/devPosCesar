import { initDataTable } from "./table.js";

export function initUsersTable() {
    initDataTable("#tablaUsuarios", {

        columnDefs: [
      { className: "dtr-control", orderable: false, targets: 0 },
      { responsivePriority: 1, targets: 1 },
      { responsivePriority: 2, targets: 2 },
      { responsivePriority: 3, targets: 3 },
      { responsivePriority: 100, targets: 7 },
      { responsivePriority: 99, targets: 4 },
      { responsivePriority: 98, targets: 6 },
      { responsivePriority: 97, targets: 5 },
    ],
    });
}