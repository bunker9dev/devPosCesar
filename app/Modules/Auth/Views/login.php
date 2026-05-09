<div class="login_container">
<!-- IZQUIERDA: IMAGEN -->
    <div class="login_image">
        <img src="<?= BASE_URL ?>/assets/img/login-bg3.png" alt="Login">
    </div>

    <!-- DERECHA: FORM -->
    <div class="login_form">

        <h2>Iniciar Sesión</h2>

        <form method="POST" action="<?= BASE_URL ?>/login">
            <input type="text" name="user" placeholder="Usuario" required>
            <input type="password" name="pass" placeholder="Contraseña" required>

            <button type="submit">Ingresar</button>
        </form>

    </div>

</div>