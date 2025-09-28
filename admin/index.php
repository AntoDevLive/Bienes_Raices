<?php
include '../includes/funciones.php';
$auth = autenticarUsuario();

if(!$auth) {
    header('Location: /');
}

// Importar la conexión
include '../includes/config/database.php';
$db = conectarDB();

//Escribir el query
$query = "SELECT * FROM propiedades";

//Consultar la BD
$resultado = mysqli_query($db, $query);

$actualizado = $_GET['actualizado'] ?? null;
$borrado = $_GET['borrado'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if ($id) {
        //Eliminar el archivo
        $query = "SELECT imagen FROM propiedades WHERE id = $id";
        $resultado = mysqli_query($db, $query);
        $propiedad = mysqli_fetch_assoc($resultado);

        var_dump($propiedad);
        unlink('../imagenes/' . $propiedad['imagen']);

        //Eliminar la propiedad
        $query = "DELETE FROM propiedades WHERE id = $id";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: /admin?borrado=1');
        }
    }
}

include '../includes/templates/header.php'
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raíces</h1>

    <?php if ($actualizado == 1): ?>
        <div class="alerta exito">
            <p>Anuncio actualizado correctamente</p>
        </div>
    <?php endif; ?>

    <?php if ($borrado == 1): ?>
        <div class="alerta exito">
            <p>Anuncio eliminado correctamente</p>
        </div>
    <?php endif; ?>

    <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

    <table class="propiedades">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Imagen</th>
                <th>Precio</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($propiedad = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td> <?php echo $propiedad['id']; ?> </td>
                    <td> <?php echo $propiedad['titulo']; ?> </td>
                    <td> <img class="imagen-tabla" src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt=""> </td>
                    <td> <?php echo $propiedad['precio']; ?> </td>
                    <td>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad['id']; ?>" class="boton-amarillo-block">Actualizar</a>
                        <form method="POST">
                            <input type="hidden" name="id" value="<?php echo $propiedad['id']; ?>">
                            <input type="submit" style="width: 100%;" class="boton-rojo-block" value="Eliminar">
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>

<?php
//Cerrar la conexión
mysqli_close($db);

include '../includes/templates/footer.php'; ?>
</body>

</html>