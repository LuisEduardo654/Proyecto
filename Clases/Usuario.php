<?php
class Usuario {
    public $nombres;
    public $apellidos;
    public $correo;
    public $usuario;
    public $contra;

    public function __construct($nombres, $apellidos, $correo, $usuario, $contra) {
        $this->nombres = $nombres;
        $this->apellidos = $apellidos;
        $this->correo = $correo;
        $this->usuario = $usuario;
        $this->contra = $contra;
    }
}
?>