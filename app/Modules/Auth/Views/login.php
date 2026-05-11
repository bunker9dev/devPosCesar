<div class="login_container">
    <!-- IZQUIERDA: IMAGEN -->
    <div class="login_image">
        <img src="<?= BASE_URL ?>/assets/img/login-bg450x300.png" alt="Login">
    </div>

    <!-- DERECHA: FORM -->
    <div class="login_form">

        <h2>Iniciar Sesión</h2>

        <form method="POST" action="<?= BASE_URL ?>/auth/login">
            <input type="text" name="user" placeholder="Usuario" required>
            <input type="password" name="pass" placeholder="Contraseña" required>

            <button type="submit">Ingresar</button>
        </form>

        <div>
            <?php if (!empty($_SESSION['error'])): ?>
                <div id="alerta-error" class="alerta alerta-error">
                    <?= $_SESSION['error'] ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
        </div>

    </div>

</div>