// =========================================================
// MODULE: SUPPLIERS
// =========================================================

import { post } from "../core/api.js";

// =========================================================
// INIT
// =========================================================
export function initSuppliers() {
    initSupplierToggle();
    initSupplierDelete();
    initSupplierRestore();
    initSupplierValidation();
}

// =========================================================
// TOGGLE ESTADO
// =========================================================
function initSupplierToggle() {
    document.addEventListener("click", async (e) => {
        const btn = e.target.closest(".toggle-supplier");
        if (!btn) return;

        const id = btn.dataset.id;
        const url = btn.dataset.url;

        try {
            const res = await post(url, { id });

            if (!res.success) {
                showToast(res.message || "Error", "error");
                return;
            }

            const estado = res.data.estado;

            btn.classList.remove("active", "inactive");

            if (estado == 1) {
                btn.classList.add("active");
                btn.textContent = "Activo";
            } else {
                btn.classList.add("inactive");
                btn.textContent = "Inactivo";
            }

        } catch (err) {
            showToast("Error de conexión", "error");
        }
    });
}

// =========================================================
// DELETE (SOFT)
// =========================================================
function initSupplierDelete() {
    document.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-delete");
        if (!btn) return;

        const id = btn.dataset.id;
        const url = btn.dataset.url;
        const name = btn.dataset.name;

        if (!confirm(`¿Eliminar proveedor "${name}"?`)) return;

        try {
            const res = await post(url, { id });

            if (!res.success) {
                showToast(res.message || "Error al eliminar", "error");
                return;
            }

            const row = btn.closest("tr");

            // 🔥 actualizar estado visual
            const badge = row.querySelector(".toggle-supplier");

            if (badge) {
                badge.classList.remove("active", "inactive");
                badge.classList.add("deleted");
                badge.textContent = "Eliminado";
            }

            // 🔥 limpiar acciones
            const actions = row.querySelector(".actions");

            if (actions) {
                if (window.USER_ROLE_ID == 1) {
                    actions.innerHTML = `
                        <button class="btn-action restore btn-restore"
                            data-id="${id}"
                            data-url="${BASE_URL}/suppliers/restore">
                            Restaurar
                        </button>
                    `;
                } else {
                    actions.innerHTML = ``;
                }
            }

            showToast("Proveedor eliminado", "success");

        } catch (err) {
            showToast("Error de conexión", "error");
        }
    });
}

// =========================================================
// RESTORE
// =========================================================
function initSupplierRestore() {
    document.addEventListener("click", async (e) => {
        const btn = e.target.closest(".btn-restore");
        if (!btn) return;

        const id = btn.dataset.id;
        const url = btn.dataset.url;

        try {
            const res = await post(url, { id });

            if (!res.success) {
                showToast(res.message || "Error al restaurar", "error");
                return;
            }

            const row = btn.closest("tr");

            // 🔥 restaurar estado
            const badge = row.querySelector(".toggle-supplier");

            if (badge) {
                badge.classList.remove("deleted");
                badge.classList.add("active");
                badge.textContent = "Activo";
            }

            // 🔥 restaurar acciones
            const actions = row.querySelector(".actions");

            if (actions) {
                actions.innerHTML = `
                    <a href="${BASE_URL}/suppliers/edit?id=${id}" class="btn-action edit">
                        Editar
                    </a>
                    <button class="btn-action delete btn-delete"
                        data-id="${id}"
                        data-url="${BASE_URL}/suppliers/delete">
                        Eliminar
                    </button>
                `;
            }

            showToast("Proveedor restaurado", "success");

        } catch (err) {
            showToast("Error de conexión", "error");
        }
    });
}

// =========================================================
// VALIDACIÓN NIT (AJAX)
// =========================================================
function initSupplierValidation() {
    const input = document.getElementById("nit");
    if (!input) return;

    let timeout;

    input.addEventListener("input", () => {
        clearTimeout(timeout);

        const nit = input.value.trim().toLowerCase();
        input.value = nit;

        const msg = document.getElementById("nit-msg");
        if (!msg) return;

        if (nit.length < 5) {
            showMsg(msg, "Mínimo 5 caracteres", "error");
            input.dataset.exists = "true";
            return;
        }

        showMsg(msg, "Verificando...", "loading");

        timeout = setTimeout(async () => {
            try {
                const res = await post("/api/suppliers/check-nit", { nit });

                if (!res || !res.success) {
                    showMsg(msg, "Error al validar", "error");
                    return;
                }

                if (res.exists) {
                    showMsg(msg, "❌ NIT ya registrado", "error");
                    input.dataset.exists = "true";
                } else {
                    showMsg(msg, "✔️ Disponible", "success");
                    input.dataset.exists = "false";
                }

            } catch {
                showMsg(msg, "Error de conexión", "error");
            }
        }, 400);
    });
}