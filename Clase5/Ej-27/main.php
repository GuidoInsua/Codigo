<?php

/*
    Aplicación No 27 (Registro BD)
    Archivo: registro.php
    método:POST
    Recibe los datos del usuario (nombre, apellido, clave, mail, localidad) por POST, 
    crear un objeto con la fecha de registro y utilizar sus métodos para poder hacer el alta,
    guardando los datos la base de datos
    retorna si se pudo agregar o no.

    Guido Insua
*/

require_once "usuario.php";

$servername = "localhost"; 
$username = "root"; 
$password = "";
$database = "ej27"; 

$conexion = new mysqli($servername, $username, $password, $database);

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
else
{
    echo "Conexión exitosa <br>";
}

function responderError($codigo, $mensaje) {
    http_response_code($codigo);
    echo $mensaje;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderError(405, "Error: Método no permitido. Esta API solo acepta solicitudes POST.");
}

if (!isset($_POST["nombre"]) || !isset($_POST["apellido"]) || !isset($_POST["clave"]) || !isset($_POST["mail"]) || !isset($_POST["localidad"])) {
    responderError(400, "Error: Faltan parametros");
}

$nombre1 = $_POST["nombre"];
$apellido1 = $_POST["apellido"];
$clave1 = $_POST["clave"];
$mail1 = $_POST["mail"];
$localidad1 = $_POST["localidad"];

$nuevoUsuario = new Usuario($nombre1, $apellido1, $clave1, $mail1, $localidad1);

$sql = "INSERT INTO usuarios (nombre, apellido, clave, mail, localidad) VALUES (?, ?, ?, ?, ?)";

if ($stmt = $conexion->prepare($sql)) {
    $stmt->bind_param("sssss", $nombre, $apellido, $clave, $mail, $localidad);

    $nombre = $nuevoUsuario->getNombre();
    $apellido = $nuevoUsuario->getApellido();
    $clave = $nuevoUsuario->getClave();
    $mail = $nuevoUsuario->getMail();
    $localidad = $nuevoUsuario->getLocalidad();

    if ($stmt->execute()) {
        echo "Nuevo usuario registrado correctamente";
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Error al preparar la sentencia: " . $conexion->error;
}

?>
