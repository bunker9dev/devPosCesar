// import { Events } from "../core/events.js";

// export function inittable() {
//   const tabla = document.querySelector("#table");
//   if (!tabla) return;

//   $("#table").DataTable({
//     responsive: {
//       details: {
//         type: "column",
//         target: 0,
//       },
//       breakpoints: [
//         { name: "desktop", width: Infinity },
//         { name: "tablet", width: 1024 },
//         { name: "mobile", width: 600 },
//       ],
//     },

//     autoWidth: false,

//     columnDefs: [
//       {
//         className: "control", // necesario para el "+"
//         orderable: false,
//         targets: 0,
//       },
//       {
//         targets: -1,
//         orderable: false,
//         searchable: false,
//       },
//     ],

//     order: [[1, "desc"]], // ordenar desde la segunda columna

//     autoWidth: false,

//     dom: "<'dt-header'Bf>" + "<'dt-table'tr>" + "<'dt-footer'lp>",

//     buttons: ["excel", "pdf", "print"],

//     language: {
//       search: "Buscar:",
//       lengthMenu: "Mostrar _MENU_ registros",
//       info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
//       zeroRecords: "No hay resultados",
//       paginate: {
//         next: "→",
//         previous: "←",
//       },
//     },
//   });
// }

// Events.on("table:init", inittable);
