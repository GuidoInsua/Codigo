<?php

/*
    Aplicación No 22 (Login)
    Archivo: Login.php
    método:POST
    Recibe los datos del usuario(clave, mail) por POST ,crear un objeto y utilizar sus métodos para poder verificar si es un usuario registrado. 
    Retorna un :
    “Verificado” si el usuario existe y coincide la clave también.
    “Error en los datos” si esta mal la clave.
    “Usuario no registrado” si no coincide el mail

    Hacer los métodos necesarios en la clase usuario.

    Guido Insua
*/

require_once 'usuario.php'; 
require_once 'manejadorUsuario.php';

function responderError($codigo, $mensaje) {
    http_response_code($codigo);
    echo $mensaje;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderError(405, "Error: Método no permitido. Esta API solo acepta solicitudes POST.");
}

if (!isset($_POST["clave"]) || !isset($_POST["mail"])) {
    responderError(400, "Error: Falta el mail o clave");
}

$clave = $_POST["clave"];
$mail = $_POST["mail"];

$usuarioPendiente = new Usuario(null, $clave, $mail);

$manejadorUsuarios = new manejadorUsuarios('usuarios.csv');

if($manejadorUsuarios->existeUsuarioEnLista($usuarioPendiente)) {
    echo "Verificado";
} else {
    echo "Error, usuario no registrado";
}

?>