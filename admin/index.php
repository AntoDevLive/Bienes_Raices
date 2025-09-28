<?php
// Importar la conexión
include '../includes/config/database.php';
$db = conectarDB();

//Escribir el query
$query = "SELECT * FROM propiedades";

//Consultar la BD
$resultado = mysqli_query($db, $query);


include '../includes/templates/header.php' 
?>

<main class="contenedor seccion">
    <h1>Administrador de Bienes Raíces</h1>

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
            <?php while($propiedad = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td> <?php echo $propiedad['id']; ?> </td>
                    <td> <?php echo $propiedad['titulo']; ?> </td>
                    <td> <img class="imagen-tabla" src="/imagenes/<?php echo $propiedad['imagen']; ?>" alt="">  </td>
                    <td> <?php echo $propiedad['precio']; ?> </td>
                    <td> 
                        <a href="#" class="boton-amarillo-block">Actualizar</a> 
                        <a href="#" class="boton-rojo-block">Eliminar</a> 
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