// =========================================================
// PAGE: SUPPLIERS INDEX
// =========================================================

import { initSuppliers } from "../modules/suppliers.js";
import { initSuppliersTable } from "../modules/suppliers-table.js";

document.addEventListener("DOMContentLoaded", () => {
    initSuppliers();
    initSuppliersTable();
});