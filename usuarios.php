<?php
require_once("clases/Usuario.php");

$usuarios = array();

$usuarios[] = new Usuario("Eduardo", "Guerrero", "lalo@guerrero.com", "lguerrero", "lalo123456");
$usuarios[] = new Usuario("Braulio", "Morales", "braulio@morales.com", "bmorales", "brau123456");
$usuarios[] = new Usuario("Cerros", "Cerros", "Cerros@example.com", "cerros", "cerritos123456");

session_start();
$_SESSION['usuarios'] = $usuarios;
?>