<?php

/*
    Aplicación No 20 BIS (Registro CSV)
    Archivo: registro.php
    método:  POST
    Recibe los datos del usuario(nombre, clave, mail) por POST, crear un objeto y 
    utilizar sus métodos para poder hacer el alta, guardando los datos en usuarios.csv.
    retorna si se pudo agregar o no.
    Cada usuario se agrega en un renglón diferente al anterior.
    Hacer los métodos necesarios en la clase usuario

    Guido Insua
*/

require_once "usuario.php";
require_once "manejadorUsuario.php";

define('ARCHIVO_USUARIOS', 'usuarios.csv');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["nombre"]) || !isset($_POST["clave"]) || !isset($_POST["mail"])) {
        echo "Error: Todos los campos son obligatorios.";
        exit;
    }

    $nombre = $_POST["nombre"];
    $clave = $_POST["clave"];
    $mail = $_POST["mail"];

    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo "Error: El formato del correo electrónico es inválido.";
        exit;
    }

    $usuario = new usuario($nombre, $clave, $mail);

    $manejadorUsuarios = new manejadorUsuarios(ARCHIVO_USUARIOS);
    $resultado = $manejadorUsuarios->agregarUsuario($usuario);

    if ($resultado) {
        echo "Usuario agregado correctamente.";
    } else {
        echo "Error al agregar usuario.";
    }
}

?>