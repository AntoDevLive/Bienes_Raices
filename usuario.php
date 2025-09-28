<?php
//Importar conexion
require 'includes/config/database.php';
$db = conectarDB();

//crear email y password
$email = 'correo@correo.com';
$password = '123';

//query para crear el usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$password')";
echo $query;

//Agregarlo a la bd
mysqli_query($db, $query);

?>