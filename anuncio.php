<?php
$id = $_GET['id'];
if (!$id) {
    header('Location: /');
}

//Importar conexión
require 'includes/app.php';
$db = conectarDB();

//Consultar
$query = "SELECT * FROM propiedades WHERE id = $id";

//Obtener resultados
$resultado = mysqli_query($db, $query);

if ($resultado->num_rows === 0) {
    header('Location: /');
}

$propiedad = mysqli_fetch_assoc($resultado);

include 'includes/templates/header.php';
?>

<main class="contenedor seccion contenido-centrado">
    <h1><?php echo $propiedad['titulo']; ?></h1>

    <img loading="lazy" src="imagenes/<?php echo $propiedad['imagen']; ?>" alt="imagen de la propiedad">

    <div class="resumen-propiedad">
        <p class="precio">$<?php echo $propiedad['precio']; ?></p>
        <ul class="iconos-caracteristicas">
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="icono wc">
                <p><?php echo $propiedad['wc']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="icono estacionamiento">
                <p><?php echo $propiedad['estacionamientos']; ?></p>
            </li>
            <li>
                <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="icono habitaciones">
                <p><?php echo $propiedad['habitaciones']; ?></p>
            </li>
        </ul>

        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Itaque, corrupti. Eum voluptatibus amet quos facere alias rem, ut quaerat veritatis eos suscipit et consequatur odio eligendi porro officiis, ratione aut!
        Dolore soluta molestiae, minus corrupti placeat, explicabo facere dicta labore, eum blanditiis quisquam? Doloremque suscipit minus nesciunt veritatis quo neque nulla vel harum, provident consequatur eum? Sequi nulla magnam minus.
        Natus vel soluta odio dicta aperiam quod harum voluptate enim fugiat quae et, impedit deleniti voluptas culpa corrupti explicabo repellat, quos vitae illum fuga atque deserunt velit amet dolores? Reiciendis?
        Libero, animi eveniet voluptatibus quo placeat alias expedita! Quis deserunt neque, minus autem dolor ratione quibusdam facere quam molestiae obcaecati doloribus error voluptas recusandae non beatae perspiciatis laborum laboriosam ad?
        Corrupti deleniti eveniet ut impedit odit? Eaque vero commodi est numquam cumque dolores non harum, quas aspernatur aliquam mollitia eveniet nesciunt explicabo saepe sit. Provident libero est quae corporis consectetur!</p>
    </div>
</main>

<?php
mysqli_close($db);
include 'includes/templates/footer.php';
?>
</body>

</html>