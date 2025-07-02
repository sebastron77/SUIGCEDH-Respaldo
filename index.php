<link rel="icon" href="medios/favicon16.ico" type="image/ico">
<?php
ob_start();
require_once('includes/load.php');
if ($session->isUserLoggedIn(true)) {
    redirect('home.php', false);
}
?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="libs/css/login.css" />
<?php echo display_msg($msg); ?>
<form method="post" action="auth.php" id="loginForm" class="zoomed">
    <br />
    <div class="logo-titulo-completo">
        <div class="logo-titulo">
            <img src="medios/moremorado.png" width="60" alt="CEDH" />
            <span>SUIGCEDH</span>
        </div>
        <span class="subtitulo-logo">Sistema Único de Información y Gestión de la CEDH</span>
    </div>

    <div class="text-center">
        <h1 style="font-weight: bold; color:#2a2b3b; padding-top: 10px; font-size: 22px !important; margin-bottom: 20px;">Iniciar Sesión</h1>
    </div>
    <div class="input-wrap">
        <input type="name" name="username" id="username" required>
        <label>Usuario</label>
    </div>
    <div class="input-wrap">
        <input type="password" name="password" id="password" required>
        <label>Contraseña</label>
    </div>
    <button type="submit">Entrar</button>
</form>
<script>
    const form = document.getElementById('loginForm');

    form.addEventListener('submit', function(e) {
        let hasError = false;
        form.querySelectorAll('input').forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('shake');
                hasError = true;
                setTimeout(() => input.classList.remove('shake'), 400);
            }
        });

        if (hasError) {
            e.preventDefault(); // evita enviar el formulario si hay errores
        }
    });
</script>
<?php include_once('layouts/header.php'); ?>