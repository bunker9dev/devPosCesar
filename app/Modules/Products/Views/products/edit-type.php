<form method="POST" action="<?= BASE_URL ?>/products/types/update" class="form-users">

    <input type="hidden" name="id" value="<?= $type['id'] ?>">

    <div class="form-group">
        <label>Nombre del tipo de tela</label>

        <input 
            type="text" 
            name="nombre"
            value="<?= htmlspecialchars($type['nombre']) ?>"
            required
            autofocus
        >
    </div>

    <!-- 🔥 ACCIONES -->
    <div class="form-actions">

        <button type="submit" class="btn-primary">
            Actualizar
        </button>

        <a href="<?= BASE_URL ?>/products/types" class="btn-secondary">
            Cancelar
        </a>

    </div>

</form>