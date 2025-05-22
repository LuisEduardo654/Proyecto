<?php
session_start();
require_once("clases/Usuario.php");

function validarCadena($cadena, $min, $max, $campo) {
    $cadena = trim($cadena);
    if(strlen($cadena) >= $min && strlen($cadena) <= $max) {
        return '';
    } else {
        return "El campo $campo debe tener entre $min y $max caracteres";
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar campos obligatorios
    $errores = [];
    
    // Validar nombres
    if(empty($_POST['nombres'])) {
        $errores['nombres'] = 'El nombre es obligatorio';
    } else {
        $error = validarCadena($_POST['nombres'], 3, 30, 'nombre');
        if(!empty($error)) $errores['nombres'] = $error;
    }
    
    // Validar apellidos
    if(empty($_POST['apellidos'])) {
        $errores['apellidos'] = 'Los apellidos son obligatorios';
    } else {
        $error = validarCadena($_POST['apellidos'], 3, 30, 'apellidos');
        if(!empty($error)) $errores['apellidos'] = $error;
    }
    
    // Validar correo
    if(empty($_POST['correo'])) {
        $errores['correo'] = 'El correo electrónico es obligatorio';
    } elseif(!filter_var($_POST['correo'], FILTER_VALIDATE_EMAIL)) {
        $errores['correo'] = 'El correo electrónico no es válido';
    }
    
    // Validar usuario
    if(empty($_POST['usuario'])) {
        $errores['usuario'] = 'El nombre de usuario es obligatorio';
    } else {
        $error = validarCadena($_POST['usuario'], 4, 20, 'usuario');
        if(!empty($error)) $errores['usuario'] = $error;
    }
    
    // Validar contraseña
    if(empty($_POST['contrasena'])) {
        $errores['contrasena'] = 'La contraseña es obligatoria';
    } elseif(strlen($_POST['contrasena']) < 6 || strlen($_POST['contrasena']) > 18) {
        $errores['contrasena'] = 'La contraseña debe tener entre 6 y 18 caracteres';
    } elseif($_POST['contrasena'] !== $_POST['confirmar']) {
        $errores['confirmar'] = 'Las contraseñas no coinciden';
    }
    
    // Si no hay errores, registrar al usuario
    if(empty($errores)) {
        $nuevoUsuario = new Usuario(
            $_POST['nombres'],
            $_POST['apellidos'],
            $_POST['correo'],
            $_POST['usuario'],
            $_POST['contrasena']
        );
        
        // Agregar dirección y otros datos al usuario
        $nuevoUsuario->direccion = $_POST['direccion'] ?? '';
        $nuevoUsuario->colonia = $_POST['colonia'] ?? '';
        $nuevoUsuario->cp = $_POST['cp'] ?? '';
        $nuevoUsuario->telefono = $_POST['telefono'] ?? '';
        $nuevoUsuario->fecha_nac = $_POST['fecha_nac'] ?? '';
        $nuevoUsuario->sexo = $_POST['sexo'] ?? '';
        
        // Guardar usuario en sesión (luego puedes migrar a base de datos)
        $_SESSION['usuarios'][] = $nuevoUsuario;
        $_SESSION['usuario_actual'] = $nuevoUsuario;
        
        header("Location: Inicio.html?registro=exitoso");
        exit;
    } else {
        // Redirigir con errores
        $query = http_build_query(['errores' => $errores]);
        header("Location: registro.html?$query");
        exit;
    }
} else {
    header("Location: registro.html");
    exit;
}
?>