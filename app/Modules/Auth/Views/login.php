
<h2>Iniciar sesión</h2>

<form method="POST" action="<?= BASE_URL ?>/auth/login">

    <input type="text" name="user" placeholder="Usuario" required>

    <input type="password" name="pass" placeholder="Contraseña" required>

    <button type="submit">Entrar</button>

</form>

<?php if(isset($error)): ?>
    <p style="color:red;"><?= $error ?></p>
<?php endif; ?>