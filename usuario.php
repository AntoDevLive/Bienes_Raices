<?php
//Importar conexion
require 'includes/config/database.php';
$db = conectarDB();

//crear email y password
$email = 'correo@correo.com';
$password = '123';

//Hashear la contraseña
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

//query para crear el usuario
$query = "INSERT INTO usuarios (email, password) VALUES ('$email', '$passwordHash')";
echo $query;

//Agregarlo a la bd
mysqli_query($db, $query);

?>