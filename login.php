<?php session_start();
//Importar conexion
require 'includes/config/database.php';
$db = conectarDB();

//Autenticar el usuario
$errores = [];

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string( $db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if(!$email) {
        $errores[] = 'El email es obligatorio o no es válido';
    }

    if (!$password) {
        $errores[] = 'El password es obligatorio';
    }

    if(empty($errores)) {
        //Revisar si el usuario existe en la BD
        $query = "SELECT * FROM usuarios WHERE email = '$email'";
        $resultado = mysqli_query($db, $query);
        
        if($resultado -> num_rows) {
            $usuario = mysqli_fetch_assoc($resultado);

            //Verificar si el password es correcto
            $auth = password_verify($password, $usuario['password']);

            if($auth) {
                //El usuario está autenticado
                $_SESSION['usuario'] = $usuario['email'];
                $_SESSION['login'] = true;
                header('Location: /admin');
            }else {
                $errores[] = 'El email o contraseña no son correctos';
            }

        } else {
            $errores[] = 'El email o contraseña no son correctos';
        }
    }
}


include 'includes/templates/header.php';
 ?>

<main class="contenedor seccion contenido-centrado">
    <h1>Iniciar Sesión</h1>

    <?php foreach ($errores as $error):?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario">
        <fieldset>
            <legend>Email y Password</legend>

            <label for="email">E-mail</label>
            <input type="email" placeholder="Tu Email" id="email" name="email">

            <label for="password">Password</label>
            <input type="password" placeholder="Contraseña" id="password" name="password">

        </fieldset>

        <input type="submit" value="Iniciar sesión" class="boton boton-verde">
    </form>
</main>

<?php include 'includes/templates/footer.php'; ?>
</body>

</html>