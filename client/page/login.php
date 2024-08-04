<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- CDN - Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet" />

  <!-- Fuente Nunito - Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet" />

  <!-- Animate CSS - animaciones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <!-- Link estilos -->
  <!-- Estilos Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <!-- Estilos personalizados-->
  <link rel="stylesheet" href="../asset/css/styles.css" />

  <!-- Icono Pestaña -->
  <link rel="shortcut icon" href="./images/film.ico" type="image/x-icon" />
  <!-- Título de la Pestaña -->
  <title>CAC-movies | Iniciar Sesión</title>
</head>

<body class="register_container">
  <!-- Encabezado - logo - nombre y menú -->
  <header class="header_color">
    <nav class="header_nav_links">
      <!-- Icono y logo -->
      <a href="../../index.php" class="header_logo">
        <i class="fas fa-film"></i>
        <span>CAC-Movies</span>
      </a>
    </nav>
  </header>
  <!-- Fin encabezado-->
  <main class="register_main_container">
    <!-- Contenedor formulario  -->
    <section class="container mb-5">
      <div class="row align-items-center px-2 px-md-0">
        <div class="col-md-6 offset-md-3 px-md-5 px-3 px-0 py-3 mt-5 rounded-3 register_form_container animate__animated animate__fadeIn animate__slow">
          <h1 class="fs-md-3 fs-4 mt-2">Iniciar Sesión</h1>
          <!-- Formulario de registro -->
          <form action="/" class="mt-5" id="formLogin">
            <div class="col my-4">
              <input type="text" autocomplete="off" placeholder="Email" id="email" class="form_input w-100" />
              <div id="errorEmail"></div>
            </div>
            <div class="col my-4">
              <input type="password" autocomplete="off" id="password" placeholder="Contraseña" class="form_input w-100" />
              <div id="errorPassword"></div>
            </div>
            <div class="col my-4">
              <input type="submit" value="Ingresar" class="form_btn w-100" />
            </div>
            <div class="col my-3">
              <a href="./register.php" class="form_link w-100">No tienes una cuenta?</a>
            </div>
          </form>
        </div>
      </div>
    </section>
  </main>
  <!-- sweetalert2 CDN-->
  <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
  <script src="./js/login.js"></script>
</body>

</html>