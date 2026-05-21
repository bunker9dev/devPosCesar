<form method="POST" action="<?= BASE_URL ?>/suppliers/store" class="form-users">

    <!-- NOMBRE / RAZÓN SOCIAL -->
    <div class="form-group">
        <label>Nombre o razón social</label>
        <input id="nombre" name="nombre" placeholder="Ej: Comercial XYZ SAS" required>
        <small id="nombre-msg" class="input-msg"></small>
    </div>

    <!-- APELLIDOS -->
    <div class="form-group">
        <label>Apellidos (opcional)</label>
        <input name="apellidos" placeholder="Solo si aplica">
    </div>

    <!-- NIT -->
    <div class="form-group">
        <label>Cédula / NIT</label>
        <input id="nit" name="nit" placeholder="Número de identificación" required>
        <small id="nit-msg" class="input-msg"></small>
    </div>

    <!-- CIUDAD -->
    <div class="form-group">
        <label>Ciudad</label>
        <input name="ciudad" placeholder="Medellín">
    </div>

    <!-- CAMPOS OPCIONALES (SOLO SUPER) -->
    <?php if ($isSuper): ?>
        
        <div class="form-group">
            <label>Email (opcional)</label>
            <input name="email" placeholder="correo@empresa.com">
        </div>

        <div class="form-group">
            <label>Teléfono (opcional)</label>
            <input id="telefono" name="telefono" placeholder="3001234567">
            <small id="telefono-msg" class="input-msg"></small>
        </div>

    <?php endif; ?>

    <!-- BOTONES -->
    <div class="form-actions">
        <button class="btn-primary">Guardar</button>
        <a href="<?= BASE_URL ?>/suppliers" class="btn-secondary">Cancelar</a>
    </div>

</form>

<!-- BASE_URL para JS -->
<script>
    window.BASE_URL = "<?= BASE_URL ?>";
</script>

<!-- JS modular (si luego validas NIT AJAX) -->
<script type="module" src="<?= BASE_URL ?>/assets/js/pages/suppliers-create.js"></script>
