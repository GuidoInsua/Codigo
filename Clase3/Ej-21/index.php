<?php

/*
    Aplicación No 21 ( Listado CSV y array de usuarios)
    Archivo: listado.php
    método:GET
    Recibe qué listado va a retornar(ej:usuarios,productos,vehículos,...etc), por ahora solo tenemos usuarios.
    En el caso de usuarios carga los datos del archivo "usuarios.csv" 
    Se deben cargar los datos en un array de usuarios.
    Retorna los datos que contiene ese array en una lista

    <ul>
        <li>Coffee</li>
        <li>Tea</li>
        <li>Milk</li>
    </ul>

    Hacer los métodos necesarios en la clase usuario

    Guido Insua
*/

require_once 'usuario.php'; 
require_once 'manejadorUsuario.php';

function responderError($codigo, $mensaje) {
    http_response_code($codigo);
    echo $mensaje;
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    responderError(405, "Error: Método no permitido. Esta API solo acepta solicitudes GET.");
}

if(!isset($_GET['tipo'])) {
    responderError(400, "Error: Falta el parámetro 'tipo' en la solicitud.");
}

$tipo = $_GET['tipo'];

if ($tipo !== 'usuarios') {
    responderError(400, "Error: Tipo de lista desconocido. Los tipos válidos son 'usuarios'.");
}

$manejadorUsuarios = new manejadorUsuarios('usuarios.csv');

$usuarios = $manejadorUsuarios->obtenerUsuarios();

$listaUsuariosHTML = "<ul>";
foreach ($usuarios as $usuario) {
    $listaUsuariosHTML .= "<li>{$usuario->getNombre()}</li>";
    $listaUsuariosHTML .= "<li>{$usuario->getClave()}</li>";
    $listaUsuariosHTML .= "<li>{$usuario->getMail()}</li>";
    $listaUsuariosHTML .= "<hr>";
}
$listaUsuariosHTML .= "</ul>";

echo $listaUsuariosHTML;

?>