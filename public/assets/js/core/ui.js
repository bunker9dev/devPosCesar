export function updateBadgeState(el, estado) {
  if (!el) return;

  el.dataset.estado = estado;

  el.classList.remove("active", "inactive", "deleted");

  const labelActive = el.dataset.labelActive || "Activo";
  const labelInactive = el.dataset.labelInactive || "Inactivo";
  const labelDeleted = el.dataset.labelDeleted || "Eliminado";

  if (estado == 1) {
    el.classList.add("active");
    el.textContent = labelActive;
  } else if (estado == 2) {
    el.classList.add("inactive");
    el.textContent = labelInactive;
  } else {
    el.classList.add("deleted");
    el.textContent = labelDeleted;
  }
}