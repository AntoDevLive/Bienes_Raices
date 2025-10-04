<?php

include '../../includes/app.php';

use App\Propiedad;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager as Image;

autenticarUsuario();


$db = conectarDB();

//Consultar para obtener los vendedores
$consulta = "SELECT * FROM vendedores";
$resultado = mysqli_query($db, $consulta);

//Arreglo con errores
$errores = Propiedad::getErrores();

$titulo = '';
$precio = '';
$descripcion = '';
$habitaciones = '';
$wc = '';
$estacionamientos = '';
$vendedorId = '';


//Ejecutar el código después de que el usuario envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $propiedad = new Propiedad($_POST);

    //generar nombre unico para imagen
    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
    if($_FILES['imagen']['tmp_name']) {
        $manager = new Image(Driver::class);
        $imagen = $manager -> read($_FILES['imagen']['tmp_name']) -> cover(800, 600);
        $propiedad -> setImagen($nombreImagen);
    }

    $errores = $propiedad -> validar();


    //Revisar si el arreglo de errores está vacío para insertar los datos en la BD
    if (empty($errores)) {

        /* SUBIDA DE ARCHIVOS */
        

        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        //Guarda la img en el servidor
        $imagen -> save(CARPETA_IMAGENES . $nombreImagen);

        $resultado = $propiedad->guardar();
        if ($resultado) {
            header('Location: crear.php?registrado=1');
        }
    }
}

$registrado = $_GET['registrado'] ?? null;

include '../../includes/templates/header.php';
?>

<main class="contenedor seccion">
    <h1>Crear Propiedad</h1>

    <?php if ($registrado == 1): ?>
        <div class="alerta exito">
            <p>Anuncio creado correctamente</p>
        </div>
    <?php endif; ?>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <?php foreach ($errores as $error): ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data" class="formulario">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título:</label>
            <input name="titulo" type="text" id="titulo" placeholder="Título Propiedad" value="<?php echo $titulo; ?>">

            <label for="precio">Precio:</label>
            <input name="precio" type="number" id="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/*" name="imagen">

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

            <select name="vendedores_id" id="">
                <option value="">-- Seleccione --</option>
                <?php while ($vendedor = mysqli_fetch_assoc($resultado)): ?>
                    <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?>
                        value="<?php echo $vendedor['id'] ?>">
                        <?php echo $vendedor['nombre'] . ' ' . $vendedor['apellido'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php include '../../includes/templates/footer.php'; ?>
</body>

</html>