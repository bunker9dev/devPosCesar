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

});
