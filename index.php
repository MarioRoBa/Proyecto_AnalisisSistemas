<?php

session_start();  // Esto debe estar al principio para trabajar con sesiones

// Parámetros de la base de datos
$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "Agencia";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
} else {
    //echo "Conexión exitosa";
}

function getImagePath($destinationName)
{
    $basePath = 'imagenes/';
    $fileName = strtolower(str_replace(' ', '_', $destinationName));
    $extensions = ['jpg', 'jpeg', 'png'];

    foreach ($extensions as $ext) {
        $filePath = $basePath . $fileName . '.' . $ext;
        if (file_exists($filePath)) {
            return $filePath;
        }
    }
    return $basePath . 'default.jpg'; // Imagen por defecto si no se encuentra ninguna
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Turistea</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="imagenes/logo.png">
</head>

<body style="background-color: #b8daba">

    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container-fluid">
            <a href="index.php" class="navbar-brand">
                <span class="text-success">Agencia de Viajes</span>
                Turistea
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-start"
                aria-controls="navbar-start" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbar-start">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#carouselE1">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#destinos">Destinos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#paquetes">Paquetes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#promociones">Promociones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sobrenosotros">Sobre Nosotros</a>
                    </li>

                    <!-- Si el usuario está logueado, muestra su nombre y un botón de cerrar sesión -->
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link">Bienvenido, <?php echo $_SESSION['nombre']; ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Cerrar sesión</a>
                        </li>
                    <?php else: ?>
                        <!-- Si el usuario no está logueado, muestra el enlace de login y registro -->
                        <li class="nav-item">
                            <a class="nav-link" href="registro.php">Registro</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Iniciar sesión</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="carousel slide" data-bs-ride="carousel" id="carouselE1">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselE1" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselE1" data-bs-slide-to="1" aria-label="Slide 2"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="imagenes/nacional.jpg" class="d-block w-100">
                <div class="carousel-caption">
                    <h5>Destinos nacionales</h5>
                    <p>
                        Descubre los rincones más hermosos de nuestro país: Desde playas hasta montañas, tenemos los
                        destinos más impresionantes para todo tipo de viajero.
                    </p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="imagenes/paquetes.jpg" class="d-block w-100">
                <div class="carousel-caption">
                    <h5>Paquetes turísticos</h5>
                    <p>
                        Viajes a tu medida: Disfruta de paquetes exclusivos que combinan calidad y precio. Perfectos
                        para cada tipo de viaje, sin preocupaciones y con todo incluido.
                    </p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselE1" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselE1" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>



    <section class="container mt-2 pt-5" id="destinos">
        <h1 class="text-center mb-5 banner">Destinos</h1>
        <div class="row">
            <?php
            $sql = "SELECT * FROM DESTINOS";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $imagePath = getImagePath($row['Nom_Des']);
                    echo '<div class="col-12 col-md-12 col-lg-3">';
                    echo '<div class="card bg-light shadow-sm border-0 px-2 py-3 mb-4">';
                    echo '<div class="text-center">';
                    echo '<img src="' . $imagePath . '" alt="">';
                    echo '<!-- Ruta de la imagen: ' . $imagePath . ' -->'; // Mensaje de depuración
                    if (!file_exists($imagePath)) {
                        echo '<!-- Imagen no encontrada: ' . $imagePath . ' -->'; // Mensaje de depuración
                    }
                    echo '</div>';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['Nom_Des'] . '</h5>';
                    echo '<p>' . $row['Des_Des'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay destinos disponibles.</p>';
            }
            ?>
        </div>
    </section>



    <section class="container mt-1 pt-5" id="paquetes">
        <h1 class="text-center mb-5 banner">Paquetes</h1>
        <div class="row">
            <?php
            $sql = "SELECT PAQUETES.*, DESTINOS.Nom_Des, TRANSPORTES.Tipo_Trans, HOTELES.Nom_Hotel, HOTELES.Estr_Hotel, HOTELES.Tipo_Habitacion, GROUP_CONCAT(GUIA_TURISTICA.Id_Guia) AS Guia_Ids
                FROM PAQUETES
                JOIN DESTINOS ON PAQUETES.Id_Des = DESTINOS.Id_Des
                JOIN TRANSPORTES ON PAQUETES.Id_Trans = TRANSPORTES.Id_Trans
                JOIN HOTELES ON PAQUETES.Id_Hotel = HOTELES.Id_Hotel
                LEFT JOIN GUIA_TURISTICA ON FIND_IN_SET(GUIA_TURISTICA.Id_Guia, PAQUETES.Id_Guia)
                GROUP BY PAQUETES.Id_Paq";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $paquete_num = 1;
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="col-12 col-md-12 col-lg-6">';
                    echo '<h5 style="text-align: center;">Paquete ' . $paquete_num . '</h5>';
                    echo '<div class="card bg-light shadow-sm border-0 px-2 py-3 mb-4">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['Nom_Paq'] . '</h5>';
                    echo '<i class="bi bi-caret-right"></i> Destino: ' . $row['Nom_Des'] . '<br>';
                    echo '<i class="bi bi-caret-right"></i> Transporte: ' . $row['Tipo_Trans'] . '<br>';
                    echo '<i class="bi bi-caret-right"></i> Hotel: ' . $row['Nom_Hotel'] . '<br>';
                    echo '<div style="margin-left: 130px">';
                    echo '<i class="bi bi-check"></i> Estrellas: ' . $row['Estr_Hotel'] . '<br>';
                    echo '<i class="bi bi-check"></i> Tipo de habitación: ' . $row['Tipo_Habitacion'] . '<br>';
                    echo '</div><br>';
                    echo '<i class="bi bi-caret-right"></i> Personas: 2 personas<br>';
                    echo '<i class="bi bi-caret-right"></i> Duración: ' . $row['Duración_Dias'] . '<br>';
                    echo '<i class="bi bi-caret-right"></i> Incluye: <br>';
                    echo '<i class="bi bi-check" style="margin-left: 87px"></i> Hospedaje <br>';
                    echo '<i class="bi bi-check" style="margin-left: 87px"></i> ' . $row['Incluye_Alim'] . ' <br> <br>';

                    // Información del guía
                    echo '<i class="bi bi-caret-right"></i> Guía: ';
                    $guia_ids = explode(',', $row['Guia_Ids']);
                    foreach ($guia_ids as $guia_id) {
                        $guia_sql = "SELECT Nom_Guia, Ape_Guia, Exp_Guia, Idioma_Guia FROM GUIA_TURISTICA WHERE Id_Guia = $guia_id";
                        $guia_result = $conn->query($guia_sql);
                        if ($guia_result->num_rows > 0) {
                            while ($guia_row = $guia_result->fetch_assoc()) {
                                echo $guia_row['Nom_Guia'] . ' ' . $guia_row['Ape_Guia'] . '<br>';
                                echo '<div style="margin-left: 180px">';
                                echo '<i class="bi bi-check"></i> Experiencia: ' . $guia_row['Exp_Guia'] . '<br>';
                                echo '<i class="bi bi-check"></i> Idiomas: ' . $guia_row['Idioma_Guia'] . '<br>';
                                echo '</div><br>';
                            }
                        }
                    }

                    echo '<p><strong>Precio: ₡' . number_format($row['Precio_Paq'], 0, ',', '.') . ' i.v.i</strong></p>';
                    echo '<div class="d-flex justify-content-center">';
                    echo '<a href="reservar.php?id_paq=' . $row['Id_Paq'] . '" class="btn btn-primary">Reservar ahora</a>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $paquete_num++;
                }
            } else {
                echo '<p>No hay paquetes disponibles.</p>';
            }
            ?>
        </div>
    </section>



    <section class="container mt-1 pt-5" id="promociones">
    <h1 class="text-center mb-5 banner">Promociones</h1>
    <h4 style="text-align: center;">-Reservá desde este apartado y obtené mejores precios y adaptación para tu
        familia-</h4> <br>

    <div class="row">
        <?php
        $promociones = [
            1 => ['id_paq' => 1, 'precio_original' => 240000, 'nombre_paquete' => 'Aventura en la Playa Manuel Antonio'],
            2 => ['id_paq' => 2, 'precio_original' => 450000, 'nombre_paquete' => 'Relajación en Arenal'],
            3 => ['id_paq' => 4, 'precio_original' => 1200000, 'nombre_paquete' => 'Paraíso Tropical en Playa Tamarindo'],
            4 => ['id_paq' => 6, 'precio_original' => 850000, 'nombre_paquete' => 'Isla del Coco: Aventura en alta mar']
        ];

        $sql = "SELECT * FROM PROMOCIONES";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $promo_num = 1;
            while ($row = $result->fetch_assoc()) {
                $id_paq = $promociones[$promo_num]['id_paq'];
                $precio_original = $promociones[$promo_num]['precio_original'];
                $nombre_paquete = $promociones[$promo_num]['nombre_paquete'];

                echo '<div class="col-12 col-md-12 col-lg-12">';
                echo '<h4 style="text-align: center; text-decoration: underline;">Promoción ' . $promo_num . '</h4>';
                echo '<div class="card bg-light shadow-sm border-0 px-2 py-3 mb-4">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">"' . $row['Nombre_Promo'] . '"</h5> <br>';
                echo '<strong>Descripción:</strong> ' . $row['Descripcion_Promo'] . '<br> <br>';
                echo '<i class="bi bi-caret-right"></i> Paquete original: ' . $nombre_paquete . '<br>';
                echo '<i class="bi bi-caret-right"></i> Precio original: ₡' . number_format($precio_original, 0, ',', '.') . ' para 2 personas <br>';
                echo '<i class="bi bi-caret-right"></i> Descuento: ' . $row['Descuento_Promo'] . '<br>';
                echo '<i class="bi bi-caret-right"></i> Precio con descuento: ₡' . number_format($row['Precio_Promo'], 0, ',', '.') . ' para 2 personas <br> <br>';
                echo '<p><strong>Por tiempo limitado</strong></p>';
                echo '<div class="d-flex justify-content-center">';
                echo '<a href="reservar.php?id_paq=' . $id_paq . '&promocion=true" class="btn btn-primary">Recibir promoción</a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
                $promo_num++;
            }
        } else {
            echo '<p>No hay promociones disponibles.</p>';
        }
        ?>
    </div>
</section>



    <section class="container pt-5" id=sobrenosotros>
        <h1 class="text-center mb-3 banner">Sobre Nosotros</h1>

        <div class="container mb-lg-5">
            <div class="d-flex justify-content-center">
                <ul type="none">
                    <h5>
                        <li class="bi bi-box-seam"> Paquetes exclusivos.
                    </h5>
                    </li>
                    <h5>
                        <li class="bi bi-clipboard-data"> Atención personalizada.
                    </h5>
                    </li>
                    <h5>
                        <li class="bi bi-currency-dollar"> Precios competitivos.
                    </h5>
                    </li>
                    <h5>
                        <li class="bi bi-person-walking"> Guías locales expertos.
                    </h5>
                    </li>
                    <h5>
                        <li class="bi bi-shield-lock"> Seguridad durante todo el viaje.
                    </h5>
                    </li>
                </ul>
            </div>
        </div>

        <h2>Opiniones de los clientes:</h2>

        <div id="testimonios-carrusel" class="carousel slide carousel-dark" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container text-center">
                        <img class="testimonio-imagen rounded-circle " src="imagenes/cliente1.svg"> <br>
                        <p class="testimonio-texto">"Nuestro viaje en Costa Rica con esta agencia fue una experiencia
                            increíble. Desde el primer contacto hasta el regreso, todo estuvo perfectamente organizado.
                            Los guías fueron muy profesionales, el transporte cómodo y las excursiones fueron únicas.
                            Nos hicieron sentir como en casa, y sin duda volveremos para explorar más de este hermoso
                            país. ¡Recomendamos esta agencia a todos los viajeros!"
                        </p>
                        <div class="testimonio-info">
                            <p class="cliente">Christian López</p>
                            <p class="cargo">Administrador</p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="container text-center">
                        <img class="testimonio-imagen rounded-circle " src="imagenes/cliente2.svg">
                        <p class="testimonio-texto">"Viajar con esta agencia fue una de las mejores decisiones que
                            tomamos. El itinerario fue perfectamente equilibrado entre descanso y aventura. Los hoteles
                            que nos recomendaron fueron maravillosos, y las actividades fueron fascinantes, como el tour
                            por el Volcán Arenal. Nos sentimos muy bien atendidos en todo momento y recibimos
                            recomendaciones personalizadas según nuestras preferencias. ¡Sin duda volveremos pronto!"
                        </p>
                        <div class="testimonio-info">
                            <p class="cliente">María Rodríguez</p>
                            <p class="cargo">Gerente de Tienda</p>
                        </div>
                    </div>
                </div>

                <div class="carousel-item">
                    <div class="container text-center">
                        <img class="testimonio-imagen rounded-circle " src="imagenes/cliente3.svg">
                        <p class="testimonio-texto text-center">"No podíamos haber elegido mejor agencia para nuestro
                            viaje en Costa Rica. Desde que llegamos, todo fue sencillo y sin estrés. Nos ayudaron a
                            planificar cada detalle, desde el transporte hasta las actividades más emocionantes.
                            Los guías locales fueron expertos en su área y nos brindaron una experiencia única.
                            Lo mejor de todo fue la atención personalizada. Fue un viaje inolvidable, ¡gracias por
                            hacerlo posible!"
                        </p>
                        <div class="testimonio-info">
                            <p class="cliente">Carlos Méndez</p>
                            <p class="cargo">Fundador</p>
                        </div>
                    </div>
                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#testimonios-carrusel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonios-carrusel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <footer class="bg-dark p-3 text-center mt-5">
        <div class="container">
            <p class="text-white">&copy; Todos los derechos reservados - Turistea - turistea@gmail.com</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
</body>

</html>