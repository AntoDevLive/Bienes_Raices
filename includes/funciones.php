<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');

function incluirTemplate($nombre, $inicio = false) {
    include TEMPLATES_URL . "/$nombre.php";
}

function autenticarUsuario() {
    session_start();

    if (!$_SESSION['login']) {
        header('Location: /');
    }
}

function debugear($variable) {
    echo '<pre>';
    var_dump($variable);
    echo '</pre>';
    exit;
}