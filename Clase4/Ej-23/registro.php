<?php

/*
    Aplicación No 23 (Registro JSON)
    Archivo: registro.php
    método:POST
    Recibe los datos del usuario (nombre, clave, mail) por POST ,
    crea un ID autoincremental (emulado, puede ser un random de 1 a 10.000). 
    crear un dato con la fecha de registro, toma todos los datos y utilizar sus métodos para poder hacer el alta,
    guardando los datos en "usuarios.json" y subir la imagen al servidor en la carpeta "Usuario/Fotos/."
    Retorna si se pudo agregar o no.
    Cada usuario se agrega en un renglón diferente al anterior.

    Hacer los métodos necesarios en la clase usuario.

    Guido Insua
*/

require_once "usuario.php";
require_once "manejadorUsuario.php";

function responderError($codigo, $mensaje) {
    http_response_code($codigo);
    echo $mensaje;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderError(405, "Error: Método no permitido. Esta API solo acepta solicitudes POST.");
}

if (!isset($_POST["nombre"]) || !isset($_POST["clave"]) || !isset($_POST["mail"])) {
    responderError(400, "Error: Falta el nombre, mail o clave");
}

$nombre = $_POST["nombre"];
$clave = $_POST["clave"];
$mail = $_POST["mail"];

if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
    $imagen_nombre = $_FILES['imagen']['name'];
    $imagen_tmp_name = $_FILES['imagen']['tmp_name'];
    $carpeta_destino = 'Usuario/Fotos/';
    if (!move_uploaded_file($imagen_tmp_name, $carpeta_destino . $imagen_nombre)) {
        responderError(423, "Error: No se pudo subir la imagen al servidor.");
    }
}

$nuevoUsuario = new Usuario($nombre, $clave, $mail);

$manejador = new ManejadorUsuarios("usuarios.json");

if ($manejador->existeUsuarioEnLista($nuevoUsuario)) {
    echo "El usuario " . $nuevoUsuario->getMail() . " ya está registrado. <br>";
} else {
    try {
        $manejador->agregarUsuario($nuevoUsuario);
        echo "El usuario " . $nuevoUsuario->getMail() . " fue registrado. <br>";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

?>