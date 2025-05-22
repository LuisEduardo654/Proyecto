<?php
session_start();
require_once("clases/Usuario.php");
require_once("includes/usuarios.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = trim($_POST["usuario"] ?? '');
    $contra = trim($_POST["contra"] ?? '');

    if (empty($usuario) || empty($contra)) {
        header("Location: inicio_sesion.html?error=Todos los campos son obligatorios");
        exit;
    }

    if (!preg_match('/^[a-zA-Z0-9_]{4,20}$/', $usuario)) {
        header("Location: inicio_sesion.html?error=El usuario debe tener entre 4 y 20 caracteres (solo letras, números y _)");
        exit;
    }

    if (strlen($contra) < 6 || strlen($contra) > 18) {
        header("Location: inicio_sesion.html?error=La contraseña debe tener entre 6 y 18 caracteres");
        exit;
    }

    // Buscar usuario
    $usuarioEncontrado = false;
    foreach ($_SESSION['usuarios'] as $u) {
        if ($u->usuario === $usuario && $u->contra === $contra) {
            $usuarioEncontrado = true;
            $_SESSION['usuario_actual'] = $u;
            break;
        }
    }

    if ($usuarioEncontrado) {
        header("Location: Inicio.html?login=exitoso");
        exit;
    } else {
        header("Location: inicio_sesion.html?error=Usuario o contraseña incorrectos");
        exit;
    }
} else {
    // Si no es POST, redirigir al login
    header("Location: inicio_sesion.html");
    exit;
}
?>