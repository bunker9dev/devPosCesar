document.addEventListener("click", (e) => {

    if (e.target.classList.contains("btn-delete")) {
        const id = e.target.dataset.id;

        if (!confirm("¿Eliminar tipo de tela?")) return;

        window.location.href = `/products/types/delete/${id}`;
    }

    if (e.target.classList.contains("btn-restore")) {
        const id = e.target.dataset.id;

        if (!confirm("¿Restaurar tipo de tela?")) return;

        window.location.href = `/products/types/restore/${id}`;
    }

    function initInlineCreateType() {
  const input = document.getElementById("inputTypeName");
  const form = document.getElementById("formCreateType");

  if (!input || !form) return;

  // 🔥 autofocus siempre
  input.focus();

  // 🔥 seleccionar texto al enfocar (UX PRO)
  input.addEventListener("focus", () => {
    input.select();
  });

  // 🔥 ENTER = submit limpio
  input.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      form.submit();
    }
  });

  // 🔥 limpiar después de enviar (sin recarga no aplica, pero dejamos preparado)
  form.addEventListener("submit", () => {
    setTimeout(() => {
      input.value = "";
    }, 100);
  });
}

});

Events.on("inventory:types", () => {
  initDataTable("#tablaFabricTypes", "tipos de tela");
  initInlineCreateType(); // 👈 AQUÍ
});
