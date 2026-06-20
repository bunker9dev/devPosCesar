import { Events } from "../core/events.js";
import { initDataTable } from "../modules/table.js";
import "../modules/warehouses.js";

document.addEventListener("DOMContentLoaded", () => {
    Events.emit("warehouses:index");
    initDataTable("#tablaWarehouses");
});