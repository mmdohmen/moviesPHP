<?php 
require './api/crud.php';
require './helpers/functions.php';
session_start();

// Comprobar si el usuario ha iniciado sesión
$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

$seccionTendencias = 'tendencias';
$seccionAclamadas = 'aclamadas';
$tendencias = getMoviesBySection($seccionTendencias);
$aclamadas = getMoviesBySection($seccionAclamadas);

$peliculasByName = getAllName();
$nameAutocomplete = json_encode($peliculasByName);

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
  <link rel="stylesheet" href="./client/asset/css/styles.css" />
  <link rel="stylesheet" href="./client/asset/css/modalFooter.css" />

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/smoothness/jquery-ui.css">
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>

  <!-- Icono Pestaña -->
  <link rel="shortcut icon" href="./client/asset/images/film.ico" type="image/x-icon" />
  <style>
  #resultados {
    display: none;
  }
  </style>
  <!-- Título de la Pestaña -->
  <title>CAC-MOVIES | Inicio</title>
</head>

<body>
  <!-- Encabezado - logo - nombre y menú -->
  <header>
    <nav class="header_nav_links">
      <!-- Icono y logo -->
      <a href="index.php" class="header_logo">
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
          <a href="#trends" class="header_link">Tendencias</a>
        </li>
        <li class="header_items">
          <a href="#acclaimeds" class="header_link">Aclamadas</a>
        </li>
        <li class="header_items">
          <a href="./client/page/rick_y_morty.html" class="header_link-login header_link-api">Rick y Morty</a>
        </li>

        <?php if ($user): ?>
        <?php if ($user['rol'] == 'admin'): ?>
        <li class="header_items">
          <a href="./client/page/admin/dashboard.php" class="header_link-login header_link-api">Panel Admin</a>
        </li>
        <?php endif;?>
        <li class="header_items">
          <a href="./api/logout.php" class="header_link-login">Cerrar sesión</a>
        </li>
        <span class="bienvenido">Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?></span>
        <?php else: ?>
        <li class="header_items">
          <a href="./client/page/register.php" class="header_link-login">Iniciar Sesión</a>
        </li>
        <?php endif;?>

        <!-- <li class="header_items">
            <a href="./client/page/register.php" class="header_link">Registrarse</a>
          </li> -->

      </ul>
    </nav>
  </header>
  <!-- Fin encabezado-->
  <!-- Contenido principal del sitio -->
  <main class="container-fluid main_container" id="mainContainer">
    <!-- Registrarse -->
    <div class="row text-center">
      <div class="col p-0">
        <section class="main_register animate__animated animate__zoomIn animate_faster">
          <h1 class="main_register-title">
            Películas y series ilimitadas
            <br />
            en un solo lugar
          </h1>
          <h2 class="main_register-subTitle no-margin">
            Disfruta donde quieras.
          </h2>
          <h2 class="main_register-subTitle">
            Cancela en cualquier momento.
          </h2>
          <?php if (!$user): ?>
          <a href="./client/page/register.php?source=main_register_btn" class="main_register_btn">Registrate</a>
          <?php endif;?>
        </section>
      </div>
    </div>

    <!-- Buscar películas -->
    <section class="container text-center main_search_container" id="searchContainer">
      <div class="row">
        <div class="col">
          <h2 class="main_search_title">¿Qué estas buscando para ver?</h2>
          <!-- Formulario para buscar películas -->
          <div class="row">
            <div class="col-md-8 col-12 offset-md-2 col-lg-6 offset-lg-3 offset-0">
              <form id="searchForm" method="GET" action=""
                class="d-flex flex-column flex-sm-row mt-4 align-items-center justify-content-center gap-2 main_search_form">
                <input type="search" name="search" id="search" placeholder="Buscar..." class="h-50 main_search_input" />
                <input type="submit" value="Buscar" class="main_search_btn" />
                <button type="button" id="clearButton" onclick="clearSearch()" class="main_search_btn">Limpiar</button>
              </form>
              <div id="searchAncla">
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
      $(document).ready(function() {
        var peliculasByName = <?php echo $nameAutocomplete; ?>;
        $("#search").autocomplete({
          source: peliculasByName
        });
      });
      </script>
    </section>
    <!-- Separar sección con línea -->
    <hr class="line_divisor" />
    <div id="resultados" class="mt-5">
      <h2>Resultados</h2>
      <div class="row mt-5">
        <div class="col d-flex flex-wrap justify-content-center align-items-center column-gap-sm-3 gap-5 gap-lg-5">
          <?php
if (isset($_GET['search'])) {
    $name = $_GET['search'];
    $resultados = searchMoviesByName($name);

    if (!empty($resultados)) {
        foreach ($resultados as $pelicula) {
            if (filter_var($pelicula['imagen'], FILTER_VALIDATE_URL)) {
                $pelicula['imagen'] = $pelicula['imagen'];
            } else {
                $pelicula['imagen'] = 'client/asset/uploads/' . htmlspecialchars($pelicula['imagen']);
            }
            ;
            echo '<div class="trend_container">';
            echo '<a href="./client/page/pelicula.php?id=' . $pelicula["id_pelicula"] . '"' . 'class="trend_container_link">';
            echo '<img src="' . htmlspecialchars($pelicula['imagen']) . '" alt="' . htmlspecialchars($pelicula['nombre']) . '" class="trend_image" />';
            echo '<div class="trend_container-hover">';
            echo '<h4 class="trend_title-hover" title="' . htmlspecialchars($pelicula['nombre']) . '">';
            echo htmlspecialchars($pelicula['nombre']);
            echo '</h4>';
            echo '<p class="trend_review-hover">'.convert_ratings(htmlspecialchars($pelicula['calificacion'])).'</p>';
            echo '<img src="' . htmlspecialchars($pelicula['imagen']) . '" alt="' . htmlspecialchars($pelicula['nombre']) . '" class="trend_image-hover" />';
            echo '</div>';
            echo '</a>';
            echo '</div>';
        }
    } else {
        echo "No se encontraron películas.";
    }
}
?>
        </div>
      </div>
      <div class="mb-5"></div>
    </div>

    <!-- Separar sección con línea -->
    <hr class="line_divisor" />

    <!-- Sección de películas Tendencias-->
    <?php
$peliculasPorPagina = 10;
$totalPeliculas = count($tendencias);

$totalPaginas = ceil($totalPeliculas / $peliculasPorPagina);

// Obtener la página actual de la solicitud, si no está presente, establecer en 1
$paginaActual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;

// Calcular el índice inicial y final para las películas de la página actual
$indiceInicial = ($paginaActual - 1) * $peliculasPorPagina;
$indiceFinal = min($indiceInicial + $peliculasPorPagina, $totalPeliculas);

// Obtener las películas para la página actual
$peliculasPagina = array_slice($tendencias, $indiceInicial, $peliculasPorPagina);
?>
    <!-- Contenedor Tendencias -->
    <section class="container p-5 trends_container" id="trends">
      <div class="row">
        <div class="col">
          <h3 class="text-center fs-2">Las tendencias de hoy</h3>
        </div>
      </div>

      <!-- Contenedor Películas    -->
      <div class="row mt-5">
        <div class="col d-flex flex-wrap justify-content-center align-items-center column-gap-sm-3 gap-5 gap-lg-5">

          <!-- Tendencias -->
          <?php foreach ($peliculasPagina as $registro) {
             if (filter_var($registro['imagen'], FILTER_VALIDATE_URL)) {
              $registro['imagen'] = $registro['imagen'];
              } else {
                $registro['imagen'] = 'client/asset/uploads/' . htmlspecialchars($registro['imagen']);
              }
            ?>
            

          <div class="trend_container">
            <a href="./client/page/pelicula.php?id=<?php echo $registro['id_pelicula'] ?>" class="trend_container_link">
              <img src="<?php echo $registro['imagen'] ?>" alt="<?php echo $registro['nombre'] ?>" class="trend_image" />
              <div class="trend_container-hover">
                <h4 class="trend_title-hover" title="<?php echo $registro['nombre'] ?>"><?php echo $registro['nombre'] ?></h4>
                <p class="trend_review-hover">
                  <?php for ($i = 0; $i < $registro['calificacion']; $i = $i + 2) {
    echo '⭐';
}
    ?>
                </p>
                <?php echo '<img src="' . htmlspecialchars($registro['imagen']) . '" alt="' . htmlspecialchars($registro['nombre']) . '" class="trend_image-hover" />';?>
                <!-- <img src="./client/asset/images/film.ico" alt="icono pelicula" class="trend_image-hover" /> -->
              </div>
            </a>
          </div>

          <?php }?>

        </div>
      </div>
      <!-- Fin peliculas tendencias-->
      <!-- Botones anterior - siguiente -->
      <div class="row text-center mt-5">
        <div class="col d-flex gap-4 justify-content-center align-items-center">
          <button class="main_trends_btn" id="btnTrendPrev" <?php if ($paginaActual <= 1) {
    echo 'disabled';
}
?>>Anterior</button>
          <button class="main_trends_btn" id="btnTrendNext" <?php if ($paginaActual >= $totalPaginas) {
    echo 'disabled';
}
?>>Siguiente</button>
        </div>
      </div>
    </section>
    <script>
    document.getElementById('btnTrendPrev').addEventListener('click', function() {
      window.location.href = '?pagina=' + (<?php echo $paginaActual; ?> - 1) + '#trends';
    });

    document.getElementById('btnTrendNext').addEventListener('click', function() {
      window.location.href = '?pagina=' + (<?php echo $paginaActual; ?> + 1) + '#trends';
    });
    </script>
    <!-- Fin contenedor tendencias -->

    <!-- Separar sección con línea -->
    <hr class="line_divisor" />

    <!-- Las más aclamadas -->
    <section class="container p-5 main_acclaimed" id="acclaimeds">
      <div class="row">
        <div class="col">
          <h3 class="text-center fs-2">Las más aclamadas</h3>
        </div>
      </div>
      <!-- Contenedor aclamadas -->
      <div class="row acclaimeds">
        <div class="col position-relative p-md-5">
          <section class="d-flex gap-md-5 gap-3 mt-5 mt-md-0 px-md-3 align-items-center acclaimeds_container"
            id="acclaimedsContainer">
            <button class="position-absolute start-0 fs-2 acclaimed_btn" id="acclaimedBtnPrev">
              <i class="fa-solid fa-angle-left"></i>
            </button>
            <button class="position-absolute end-0 fs-2 acclaimed_btn" id="acclaimedBtnNext">
              <i class="fa-solid fa-angle-right"></i>
            </button>

            <?php foreach ($aclamadas as $registro) {
               if (filter_var($registro['imagen'], FILTER_VALIDATE_URL)) {
                $registro['imagen'] = $registro['imagen'];
                } else {
                  $registro['imagen'] = 'client/asset/uploads/' . htmlspecialchars($registro['imagen']);
                }
              ?>
            <div class="acclaimed_container">
              <a href="./client/page/pelicula.php?id=<?php echo $registro['id_pelicula'] ?>">
                <!-- <img src="<?php echo $registro['imagen'] ?>" alt="aclamada 1" class="acclaimed_image" /> -->
                <?php echo '<img src="' . htmlspecialchars($registro['imagen']) . '" alt="' . htmlspecialchars($registro['nombre']) . '" class="acclaimed_image" />';?>
              </a>
            </div>
            <?php }?>

          </section>
        </div>
      </div>
      <!-- Fin contenedor aclamadas-->
    </section>
    <!-- Fin peliculas aclamadas -->
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
                <a href="#" class="footer_link" data-content="terms" data-url="/">Términos y condiciones</a>
              </li>
              <li class="footer_item">
                <a href="#" class="footer_link" data-content="pregunt" data-url="/">Preguntas frecuentes</a>
              </li>
              <li class="footer_item">
                <a href="#" class="footer_link" data-content="ayuda" data-url="/">Ayuda</a>
              </li>
              <li class="footer_item">
                <a href="#" class="footer_link" data-content="default" data-url="/">Contacto</a>
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
      <img src="./client/asset/images/flecha-hacia-arriba.svg" alt="Ir arriba flecha" class="btn_top_image" />
    </a>
  </footer>
  <!-- Fin footer-->
  <!-- Enlace script index.js-->
  <script src="./client/asset/js/index.js"></script>
  <script src="./client/asset/js/search.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
  <!-- Script para el modal del footer-->
  <script src="./client/asset/js/modal_footer.js"></script>
  <script>
  // JavaScript para mostrar el div si hay resultados y el botón de limpiar
  <?php if (isset($resultados) && !empty($resultados)): ?>
  document.getElementById('resultados').style.display = 'block';
  document.getElementById('clearButton').style.display = 'inline-block';
  window.location.hash = 'searchAncla';
  <?php endif;?>
  </script>
</body>

</html>