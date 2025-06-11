<link rel="icon" href="medios/favicon16.ico" type="image/ico">
<?php
ob_start();
require_once('includes/load.php');
if ($session->isUserLoggedIn(true)) {
    redirect('home.php', false);
}
?>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 100vh;
        margin: 0;
        padding: 0;
        background: url("medios/banner pagina_page-0007.jpg") no-repeat center center/cover;
        font-family: "Montserrat", sans-serif !important;
        position: relative;
        overflow: hidden;
    }

    /* Capa oscura */
    body::before {
        font-family: "Montserrat", sans-serif !important;
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 0;
    }

    form {
        font-family: "Montserrat", sans-serif !important;
        position: relative;
        z-index: 1;
        background: #ffffff;
        border-radius: 18px;
        padding: 45px 35px;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 12px 45px rgba(0, 0, 0, 0.25);
        animation: slideUp 0.8s ease-out;
        transform: translateY(0);
        transition: transform 0.4s ease, box-shadow 0.3s ease;
    }

    form:hover {
        font-family: "Montserrat", sans-serif !important;
        transform: translateY(-5px);
        box-shadow: 0 16px 60px rgba(0, 0, 0, 0.3);
    }

    @keyframes slideUp {
        from {
            font-family: "Montserrat", sans-serif !important;
            opacity: 0;
            transform: translateY(40px);
        }

        to {
            font-family: "Montserrat", sans-serif !important;
            opacity: 1;
            transform: translateY(0);
        }
    }

    .logo-titulo {
        font-family: 'Jost', sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 0px;
    }

    .logo-titulo img {
        width: 42px;
    }

    .logo-titulo span {
        font-size: 40px;
        font-weight: 600;
        color: #370494;
    }

    h1 {
        font-family: "Montserrat", sans-serif !important;
        text-align: center;
        font-size: 20px;
        margin-bottom: 18px;
        color: #222;
    }

    fieldset {
        font-family: "Montserrat", sans-serif !important;
        border: none;
        display: flex;
        flex-direction: column;
        margin-bottom: 18px;
    }

    label {
        font-family: "Montserrat", sans-serif !important;
        margin-bottom: 6px;
        font-size: 14px;
        color: #333;
    }

    input {
        font-family: "Montserrat", sans-serif !important;
        padding: 12px;
        border-radius: 10px;
        border: 1px solid #ccc;
        font-size: 14px;
        transition: border 0.3s, box-shadow 0.3s;
    }

    input:focus {
        font-family: "Montserrat", sans-serif !important;
        outline: none;
        border: 1px solid #370494;
        box-shadow: 0 0 5px rgba(55, 4, 148, 0.5);
    }

    button {
        font-family: "Montserrat", sans-serif !important;
        background-color: #370494;
        color: white;
        border: none;
        border-radius: 4px !important;
        padding: 5px 18px;
        font-size: 14px !important;
        font-weight: 400;
        cursor: pointer;
        transition: background 0.3s, transform 0.2s;
        float: right;
        margin-top: 10px;
    }

    button:hover {
        font-family: "Montserrat", sans-serif !important;
        background-color: #2d0378;
        transform: translateY(-2px);
    }

    .input-wrap {
        font-family: "Montserrat", sans-serif !important;
        position: relative;
        margin-bottom: 30px;
    }

    .input-wrap input {
        font-family: "Montserrat", sans-serif !important;
        width: 100%;
        padding: 12px;
        border: 2px solid #ccc;
        border-radius: 6px;
        font-size: 16px;
        background: #FFF;
        transition: all 0.2s ease;
        color: #222;
    }

    .input-wrap input:focus {
        font-family: "Montserrat", sans-serif !important;
        border-color: #370494;
        animation: pop 0.25s ease;
    }

    .input-wrap label {
        font-family: "Montserrat", sans-serif !important;
        position: absolute;
        left: 12px;
        top: 12px;
        background: rgba(255, 255, 255, 0.75);
        padding: 0 4px;
        font-size: 14px;
        color: #667;
        transition: 0.2s ease all;
        pointer-events: none;
    }

    .input-wrap input:focus+label,
    .input-wrap input:not(:placeholder-shown)+label {
        font-family: "Montserrat", sans-serif !important;
        top: -10px;
        font-size: 12px;
        color: #370494;
    }

    @keyframes pop {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.03);
        }

        100% {
            transform: scale(1);
        }
    }

    @keyframes shake {

        0%,
        100% {
            transform: translateX(0);
        }

        20%,
        60% {
            transform: translateX(-6px);
        }

        40%,
        80% {
            transform: translateX(6px);
        }
    }

    .shake {
        animation: shake 0.4s;
        border-color: red !important;
    }

    .logo-titulo-completo {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 10px;
    }

    .subtitulo-logo {
        font-size: 11px;
        color: #444;
        margin-top: -6px;
    }
</style>

<?php echo display_msg($msg); ?>
<form method="post" action="auth.php" id="loginForm">
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