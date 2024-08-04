<?php
require '../../api/crud.php';
session_start();

$showSignUp = isset($_GET['source']) && $_GET['source'] === 'main_register_btn';

 // Array para errores y mensajes
 $errores = [];
 $messages = [];
 $values = ['nombre' => '', 'apellido' => '', 'email' => '', 'password' => '', 'fecha_nac' => '', 'pais' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $action = $_POST['action']; // Campo oculto para diferenciar entre registro y login

   // Actualizar valores con los datos enviados por el usuario
   $values['nombre'] = $_POST['nombre'] ?? '';
   $values['apellido'] = $_POST['apellido'] ?? '';
   $values['email'] = $_POST['email'] ?? '';
   $values['password'] = $_POST['password'] ?? '';
   $values['fecha_nac'] = $_POST['fecha_nac'] ?? '';
   $values['pais'] = $_POST['pais'] ?? '';


   // Validaciones de campos obligatorios
   $campos_obligatorios = [
        'nombre' => 'El nombre es obligatorio',
        'apellido' => 'El apellido es obligatorio',
        'email' => 'El email es obligatorio',
        'password' => 'El password es obligatorio',
        'pais' => 'El país es obligatorio',
        'fecha_nac' => 'La fecha de nacimiento es obligatoria',
    ];

    // Validar campos obligatorios
    foreach ($campos_obligatorios as $campo => $mensaje) {
        if (empty($_POST[$campo])) {
            $errores[$campo] = $mensaje;
        }
    }

    // Validar fecha de nacimiento mínima (mayor de 16 años)
    if (!empty($_POST['fecha_nac'])) {
        $fecha_nac = $_POST['fecha_nac'];
        $fecha_nacimiento = DateTime::createFromFormat('d/m/Y', $fecha_nac);
    
        if ($fecha_nacimiento === false) {
            $errores['fecha_nac'] = 'Formato de fecha incorrecto. Utiliza el formato DD/MM/YYYY';
        } else {
            $fecha_actual = new DateTime();
            $edad = $fecha_actual->diff($fecha_nacimiento)->y;
    
            if ($edad < 16) {
                $errores['fecha_nac'] = 'Debes tener al menos 16 años para registrarte';
            }
        }
    }

  if ($action == 'register' && empty($errores)) {
    // Registro de usuario
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $fecha_nac = $_POST['fecha_nac'];
    $pais = $_POST['pais'];

    $resultado = createUser($email, $password, $nombre, $apellido, $fecha_nac, $pais);

    if ($resultado === 'email_existente') {
        $errores['email'] = 'El email ya está registrado';
    } elseif ($resultado) {
        $messages['success'] = 'Usuario creado exitosamente';
    } else {
        $errores['general'] = 'Error al crear el usuario';
    }
    } elseif ($action == 'login') {
      // Inicio de sesión
      $email = $_POST['email'];
      $password = $_POST['password'];

      $resultado = loginUser($email, $password);

      if ($resultado === 'email_incorrecto') {
        $errorEmail = "El correo electrónico es incorrecto.";
      } elseif ($resultado === 'contraseña_incorrecta') {
        $errorPassword = "La contraseña es incorrecta.";
      } elseif (is_array($resultado)) {
        // Login exitoso
        $_SESSION['user'] = $resultado;
        $rol = $resultado['rol']; // Obtener el rol del usuario desde el array

        if ($rol == 'admin') {
          header('Location: ../page/admin/dashboard.php'); // Ajuste de la ruta para redirigir a admin
        } else {
          header('Location: ../../index.php'); // Ajuste de la ruta para redirigir al índice
        }
        exit; // Detener la ejecución del script
      } else {
        $errorGeneral = "Ocurrió un error desconocido.";
      }
    }
    // Si hay errores en el registro, mostrar la sección de registro
    if ($action == 'register' && !empty($errores)) {
      $showSignUp = true;
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- CDN - Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Fuente Nunito - Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet" />

  <!-- Animate CSS - animaciones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <!-- Link estilos -->
  <!-- Estilos Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <!--Estilos Pikaday-->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css" />
  <!-- Estilos personalizados-->
  <link rel="stylesheet" href="../asset/css/styles.css" />

  <!-- Icono Pestaña -->
  <link rel="shortcut icon" href="./images/film.ico" type="image/x-icon" />
  <style>
        /* Estilos iniciales */
        <?php if ($showSignUp) : ?>
            #loginSection { display: none; }
            #signUpSection { display: block; }
        <?php else : ?>
            #loginSection { display: block; }
            #signUpSection { display: none; }
        <?php endif; ?>
    </style>

  <!-- Título de la Pestaña -->
  <title>CAC-movies | Registro</title>
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
    <!-- Formulario de login -->
    <section class="container mb-5" id="loginSection">
      <div class="row align-items-center px-2 px-md-0">
        <div class="col-md-6 offset-md-3 px-md-5 px-3 px-0 py-3 mt-5 rounded-3 register_form_container animate__animated animate__fadeIn animate__slow">
          <h1 class="fs-md-3 fs-4 mt-2">Iniciar Sesión</h1>

          <form action="register.php" method="POST" class="mt-5" id="formLogin">
            <div class="col my-4">
              <input type="text" autocomplete="off" placeholder="Email" name="email" id="email" class="form_input w-100" />
              <div id="errorEmail"></div>
              <?php if (isset($errorEmail)): ?>
                  <p style="color: red;"><?php echo $errorEmail; ?></p>
              <?php endif; ?>
            </div>
            <div class="col my-4">
              <input type="password" autocomplete="off" name="password" id="password" placeholder="Contraseña" class="form_input w-100" />
              <div id="errorPassword"></div>
              <?php if (isset($errorPassword)): ?>
                  <p style="color: red;"><?php echo $errorPassword; ?></p>
              <?php endif; ?>
            </div>
            <div class="col my-4">
              <input type="hidden" name="action" value="login">
              <input type="submit" value="Ingresar" class="form_btn w-100" />
            </div>
            <div class="col my-3">
              <a href="#" id="signUpLink" class="form_link w-100">No tienes una cuenta?</a>
            </div>
            <?php if (isset($errorGeneral)): ?>
                <p style="color: red;"><?php echo $errorGeneral; ?></p>
            <?php endif; ?>
          </form>
        </div>
      </div>
    </section>
    <!-- fin formulario de login  -->

    <!-- formulario de registro  -->
    <section class="container mb-5" id="signUpSection">
      <div class="row align-items-center px-2 px-md-0">
        <div class="col-md-6 offset-md-3 px-md-5 px-3 px-0 py-3 mt-5 rounded-3 register_form_container animate__animated animate__fadeIn animate__slow">
          <h1 class="fs-md-3 fs-4 mt-2">Nuevo Usuario</h1>
          <form method="POST" action="register.php" class="mt-5">
            <div class="col my-4">
              <input type="text" name="nombre" autocomplete="off" class="form_input w-100" placeholder="Nombre" value="<?php echo htmlspecialchars($values['nombre']); ?>" />
              <?php if (isset($errores['nombre'])): ?>
                <p class="text-danger fs-6 mx-5"><?php echo $errores['nombre']; ?></p>
              <?php endif;?>
            </div>
            <div class="col my-4">
              <input type="text" name="apellido" autocomplete="off" placeholder="Apellido" class="form_input w-100" value="<?php echo htmlspecialchars($values['apellido']); ?>"/>
              <?php if (isset($errores['apellido'])): ?>
                <p class="text-danger fs-6 mx-5"><?php echo $errores['apellido']; ?></p>
              <?php endif; ?>
            </div>
            <div class="col my-4">
              <input type="email" name="email" autocomplete="off" placeholder="Email" class="form_input w-100" value="<?php echo htmlspecialchars($values['email']); ?>"/>
              <?php if (isset($errores['email'])): ?>
                <p class="text-danger fs-6 mx-5"><?php echo $errores['email']; ?></p>
              <?php endif; ?>
            </div>
            <div class="col my-4">
              <input type="password" name="password" autocomplete="off" placeholder="Contraseña" class="form_input w-100" value="<?php echo htmlspecialchars($values['password']); ?>"/>
              <?php if (isset($errores['password'])): ?>
                <p class="text-danger fs-6 mx-5"><?php echo $errores['password']; ?></p>
              <?php endif; ?>
            </div>
            <div class="col my-4">
              <input type="text" class="form_input w-100" id="datepicker" name="fecha_nac" placeholder="Fecha de nacimiento" value="<?php echo htmlspecialchars($values['fecha_nac']); ?>"/>
              <?php if (isset($errores['fecha_nac'])): ?>
                <p class="text-danger fs-6 mx-5"><?php echo $errores['fecha_nac']; ?></p>
              <?php endif; ?>
            </div>
            <div class="col my-4">
              <select class="w-100 form_input form_select" name="pais">
                <option value="" selected disabled>Pais de residencia</option>
                <option value="Argentina" <?php echo $values['pais'] === 'Argentina' ? 'selected' : ''; ?>>Argentina</option>
                <option value="colombia" <?php echo $values['pais'] === 'Colombia' ? 'selected' : ''; ?>>Colombia</option>
                <option value="espania" <?php echo $values['pais'] === 'espania' ? 'selected' : ''; ?>>España</option>
                <option value="Italia" <?php echo $values['pais'] === 'Italia' ? 'selected' : ''; ?>>Italia</option>
                <option value="Uruguay" <?php echo $values['pais'] === 'Uruguay' ? 'selected' : ''; ?>>Uruguay</option>
              </select>
              <?php if (isset($errores['pais'])): ?>
                <p class="text-danger fs-6 mx-5"><?php echo $errores['pais']; ?></p>
              <?php endif; ?>
            </div>
            <div class="col my-4">
              <div class="form_container_terms ms-1">
                <input type="checkbox" autocomplete="off" id="terms" required />
                <label for="terms" class="form_terms_text">Acepto términos y condiciones</label>
              </div>
            </div>
            <div class="col my-4">
              <input type="hidden" name="action" value="register">
              <input type="submit" value="Registrarse" class="form_btn w-100">
            </div>
            <div class="col my-3">
              <a href="#" class="form_link w-100" id="loginLink">Ya estás registrado?</a>
            </div>
          </form>
        </div>
      </div>
    </section>
    <!-- fin formulario de registro  -->
  </main>
  <!--enlace script index.js-->
  <script>
    document.getElementById('loginLink').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('loginSection').style.display = 'block';
        document.getElementById('signUpSection').style.display = 'none';
    });

    document.getElementById('signUpLink').addEventListener('click', function(event) {
        event.preventDefault();
        document.getElementById('signUpSection').style.display = 'block';
        document.getElementById('loginSection').style.display = 'none';
    });
</script>
  <!-- Manejo de fechas - Pikaday -->
  <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
  <script src="../asset/js/register.js"></script>
  <script src="../asset/js/login.js"></script>
</body>

</html>