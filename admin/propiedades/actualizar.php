<?php

include '../../includes/funciones.php';
$auth = autenticarUsuario();

if (!$auth) {
    header('Location: /');
}

include '../../includes/config/database.php';

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin');
}

//Base de datos
$db = conectarDB();

//Obtener los datos de la propiedad
$consulta = "SELECT * FROM propiedades WHERE id = $id";
$resultado = mysqli_query($db, $consulta);
$propiedad = mysqli_fetch_assoc($resultado);


//Obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);


//Arreglo con errores
$errores = [];

$titulo = $propiedad['titulo'];
$precio = $propiedad['precio'];
$descripcion = $propiedad['descripcion'];
$habitaciones = $propiedad['habitaciones'];
$wc = $propiedad['wc'];
$estacionamientos = $propiedad['estacionamientos'];
$vendedorId = $propiedad['vendedores_id'];
$imagenPropiedad = $propiedad['imagen'];


//Ejecutar el código después de que el usuario envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);
    $precio = mysqli_real_escape_string($db, $_POST['precio']);
    $descripcion = mysqli_real_escape_string($db, $_POST['descripcion']);
    $habitaciones = mysqli_real_escape_string($db, $_POST['habitaciones']);
    $wc = mysqli_real_escape_string($db, $_POST['wc']);
    $estacionamientos = mysqli_real_escape_string($db, $_POST['estacionamientos']);
    $vendedorId = mysqli_real_escape_string($db, $_POST['vendedor']);
    $creado = date('Y/m/d');
    $imagen = $_FILES["imagen"];


    if (!$titulo) {
        $errores[] = "Debes añadir un título";
    }

    if (!$precio) {
        $errores[] = "Debes añadir un precio";
    }

    if (strlen($descripcion) < 50) {
        $errores[] = "La descripción debe tener al menos 50 caracteres";
    }

    if (!$habitaciones) {
        $errores[] = "Debes añadir un número de habitaciones";
    }

    if (!$wc) {
        $errores[] = "Debes añadir un número de baños";
    }

    if (!$estacionamientos) {
        $errores[] = "Debes añadir un número de estacionamientos";
    }

    if (!$vendedorId) {
        $errores[] = "Debes elegir un vendedor";
    }


    //Revisar si el arreglo de errores está vacío para insertar los datos en la BD
    if (empty($errores)) {

        //crear la carpeta
        $carpetaImagenes = '../../imagenes/';

        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        /* SUBIDA DE ARCHIVOS */

        if($imagen['name']) {
            unlink($carpetaImagenes . $propiedad['imagen']);

            //generar nombre unico para imagen
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //Subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen);
        } else {
            $nombreImagen = $propiedad['imagen'];
        }


        //Insertar valores en la BD
        $query = "UPDATE propiedades SET 
    titulo = '$titulo', 
    precio = '$precio', 
    imagen = '$nombreImagen', 
    descripcion = '$descripcion', 
    habitaciones = '$habitaciones', 
    wc = '$wc', 
    estacionamientos = '$estacionamientos', 
    vendedores_id = '$vendedorId' 
    WHERE id = $id";


        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /admin?actualizado=1');
        }
    }
}

include '../../includes/templates/header.php';
?>

<main class="contenedor seccion">
    <h1>Actualizar Propiedad</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" enctype="multipart/form-data" class="formulario">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título:</label>
            <input name="titulo" type="text" id="titulo" placeholder="Título Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input name="precio" type="number" id="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/*" name="imagen">
            <img style="width: 10rem;" src="/imagenes/<?php echo $imagenPropiedad ?>" alt="">

            <label for="desripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" placeholder="Descripción"><?php echo $descripcion; ?></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad:</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input name="habitaciones" type="number" id="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

            <label for="wc">Baños:</label>
            <input name="wc" type="number" id="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

            <label for="estacionamiento">estacionamientos:</label>
            <input name="estacionamientos" type="number" id="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamientos; ?>">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor" id="">
                <option value="">-- Seleccione --</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)): ?>
                    <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?>
                        value="<?php echo $vendedor['id'] ?>">
                        <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
    </form>
</main>

<?php include '../../includes/templates/footer.php'; ?>
</body>

</html>