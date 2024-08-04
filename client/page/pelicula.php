<?php
require '../../api/connect.php';

require '../../api/crud.php';
session_start();

// Comprobar si el usuario ha iniciado sesión
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $registro = searchMoviesById($id);
}
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- CDN - Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Fuente Nunito - Google Fonts -->
  <link rel="pre<connect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">

  <!-- Animate CSS - animaciones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Link estilos -->
  <!-- Estilos Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />

  <!-- Estilos personalizados-->
  <link rel="stylesheet" href="../asset/css/styles.css" />
  <link rel="stylesheet" href="../asset/css/modalFooter.css" />

  <!-- Icono Pestaña -->
  <link rel="shortcut icon" href="../asset/images/film.ico" type="image/x-icon" />
  <!-- Título de la Pestaña -->
  <title>CAC-MOVIES | Pelicula - Detalle</title>
</head>

<body>
  <!-- Encabezado - logo - nombre y menú -->
  <header>
    <nav class="header_nav_links">
      <!-- Icono y logo -->
      <a href="../../index.php" class="header_logo">
        <i class="fas fa-film"></i>
        <span>CAC-Movies</span>
      </a>
      <!--botón toggle menú responsive-->
      <div class="btn_menu_toggle">
        <i class="fa-solid fa-bars btn_menu_toggle-open btn_menu-active" id="btnMenuOpen"></i>
        <i class="fa-solid fa-xmark btn_menu_toggle-close" id="btnMenuClose"></i>
      </div>
      <!-- Links de navegación -->
      <ul class="header_list_links mt-md-3" id="headerListLinks">
        <li class="header_items">
          <a href="../../index.php#trends" class="header_link">Tendencias</a>
        </li>
        <li class="header_items">
          <a href="../../index.php#acclaimeds" class="header_link">Aclamadas</a>
        </li>
        <li class="header_items">
          <a href="../../client/page/rick_y_morty.html" class="header_link-login header_link-api">Rick y Morty</a>
        </li>

        <?php if ($user) : ?>
        <?php if ($user['rol'] == 'admin') : ?>
        <li class="header_items">
          <a href="../../client/page/admin/dashboard.php" class="header_link-login header_link-api">Panel Admin</a>
        </li>
        <?php endif; ?>
        <li class="header_items">
          <a href="../../api/logout.php" class="header_link-login">Cerrar sesión</a>
        </li>
        <span class="bienvenido">Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
        <?php else : ?>
        <li class="header_items">
          <a href="../../client/page/register.php" class="header_link-login">Iniciar Sesión</a>
        </li>
        <?php endif; ?>

        <!-- <li class="header_items">
            <a href="./client/page/register.php" class="header_link">Registrarse</a>
          </li> -->

      </ul>
    </nav>
  </header>
  <!-- Fin encabezado-->

  <!-- Contenido principal del sitio -->
  <main class="container">

    <div class="d-flex justify-content-center align-items-center container_movie_detail">

      <div class="card" style="max-width: 70%;">
        <div class="row g-1">
          <div class="col-md-4">
            <img src="<?php echo filter_var($registro['imagen'],FILTER_VALIDATE_URL) ? $registro['imagen'] : '../asset/uploads/'.htmlspecialchars($registro['imagen']) ?>" class="img-fluid h-100 rounded-start" alt="..." style="object-fit: cover;">
          </div>
          <div class="col-md-8">
            <div class="card-body">
              <h2 class="card-title"><?php echo $registro['nombre'] ?></h2>
              <p class="card-text"><small class="text-body-secondary"><?php echo $registro['genero'] ?></small></p>
              <p class="card-text"><?php echo $registro['anio'] ?></p>
              <p class="card-text"><?php echo $registro['descripcion'] ?></p>
              <p class="card-text">director: <?php echo $registro['director'] ?></p>
              <p class="card-text">
                <?php for ($i = 0; $i < $registro['calificacion']; $i = $i + 2) {echo '⭐'; } ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

<!-- Fin contenido principal -->
  <!-- Contenedor del modal footer-->
  <div class="modal fade" id="dynamicModal" tabindex="-1" aria-labelledby="dynamicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- El contenido del modal se cargará aquí -->
      </div>
    </div>
  </div>
  <!-- Modal -->
  <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="termsModalLabel">Términos y Condiciones</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>
            Estos son los términos y condiciones de uso de nuestra página web. Al usar este sitio, aceptas cumplir con
            todos los términos aquí descritos.
          </p>
          <p>
            1. Uso del sitio: ...
          </p>
          <p>
            2. Propiedad intelectual: ...
          </p>
          <!-- Agrega más contenido según sea necesario -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- Footer - Links de navegación - Botón ir a top -->
  <footer class="container-fluid">
    <!-- links de navagación - footer -->
    <div class="container-fluid py-5 text-center position-relative">
      <div class="row mb-2 mb-md-0">
        <div class="col-12">
          <nav class="footer_links d-flex justify-content-center">
            <ul
              class="footer_list_links d-flex row-gap-3 w-100 flex-md-row flex-column justify-content-md-evenly align-items-center p-0">
              <li class="footer_item">
                <a href="#" class="footer_link" data-content="terms" data-url="">Términos y condiciones</a>
              </li>
              <li class="footer_item">
                <a href="#" class="footer_link" data-content="pregunt" data-url="<?php echo $uri_actual === '/index.php' ? '/' : '' ?>">Preguntas frecuentes</a>
              </li>
              <li class="footer_item">
                <a href="#" class="footer_link" data-content="ayuda" data-url="<?php echo $uri_actual === '/index.php' ? '/' : '' ?>">Ayuda</a>
              </li>
              <li class="footer_item">
                <a href="#" class="footer_link" data-content="detailsContact" data-url="<?php echo $uri_actual === '/index.php' ? '/' : '' ?>">Contacto</a>
              </li>
            </ul>
          </nav>
        </div>
      </div>

      <!-- CopyRight -->
      <div class="row w-100 text-center bottom-0 position-absolute">
        <div class="col">
          <p class="footer_copyRight">&copy; CAC - PHP-ERROR 404 - 2024</p>
        </div>
      </div>
    </div>

    <!-- Botón ir arriba-->
    <a class="btn_top" id="btnTop">
      <img src="../asset/images/flecha-hacia-arriba.svg" alt="Ir arriba flecha" class="btn_top_image" />
    </a>
  </footer>
  <!-- Fin footer-->
  <!-- Enlace script index.js-->
  <script src="../asset/js/index.js"></script>
  <script src="../asset/js/search.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
  <!-- Script para el modal del footer-->
  <script src="../asset/js/modal_footer.js"></script>
</body>

</html>