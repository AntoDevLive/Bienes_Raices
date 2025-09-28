<?php
include '../../includes/config/database.php';
$db = conectarDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = $_POST['titulo'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $habitaciones = $_POST['habitaciones'];
    $wc = $_POST['wc'];
    $estacionamientos = $_POST['estacionamientos'];
    $vendedorId = $_POST['vendedor'];

    $query = "INSERT INTO propiedades (titulo, precio, descripcion, habitaciones, wc, estacionamientos, vendedores_id) VALUES ('$titulo', '$precio', '$descripcion', '$habitaciones', '$wc', '$estacionamientos', '$vendedorId')";

    $resultado = mysqli_query($db, $query);
}

include '../../includes/templates/header.php';
?>

<main class="contenedor seccion">
    <h1>Crear Propiedad</h1>

    <a href="/admin" class="boton boton-verde">Volver</a>

    <form method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data" class="formulario">
        <fieldset>
            <legend>Información General</legend>

            <label for="titulo">Título:</label>
            <input name="titulo" type="text" id="titulo" placeholder="Título Propiedad">

            <label for="titulo">Precio:</label>
            <input name="precio" type="number" id="precio" placeholder="Precio Propiedad">

            <label for="imagen">Imagen:</label>
            <input type="file" id="imagen" accept="image/*">

            <label for="desripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" placeholder="Descripción"></textarea>
        </fieldset>

        <fieldset>
            <legend>Información Propiedad:</legend>

            <label for="habitaciones">Habitaciones:</label>
            <input name="habitaciones" type="number" id="habitaciones" placeholder="Ej: 3" min="1" max="9">

            <label for="wc">Baños:</label>
            <input name="wc" type="number" id="wc" placeholder="Ej: 3" min="1" max="9">

            <label for="estacionamiento">estacionamientos:</label>
            <input name="estacionamientos" type="number" id="estacionamiento" placeholder="Ej: 3" min="1" max="9">
        </fieldset>

        <fieldset>
            <legend>Vendedor</legend>

            <select name="vendedor" id="">
                <option value="1">Antonio</option>
                <option value="2">Ismael</option>
            </select>
        </fieldset>

        <input type="submit" value="Crear Propiedad" class="boton boton-verde">
    </form>
</main>

<?php include '../../includes/templates/footer.php'; ?>
</body>

</html>