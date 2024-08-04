<?php
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- CDN - Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <!-- Fuente Nunito - Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet" />
  
  <!-- Animate CSS - animaciones -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  
  <!-- Link estilos -->
  <!-- Estilos Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <!--Estilos Pikaday-->
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css" />
  
  <!-- Estilos datatables	-->
  <link rel="stylesheet" href="../../asset/css/datatables_2.css">
  <link rel="stylesheet" href="../../asset/css/datatables.css">
  
  <!-- Estilos personalizados-->
  <link rel="stylesheet" href="../../asset/css/styles.css" />
  
  <!-- Icono Pestaña -->
  <link rel="shortcut icon" href="../../asset/images/film.ico" type="image/x-icon" />
  <!--	JQuery -->
  <script src="../../asset/js/jquery-3.7.1.min.js"></script>
  <!--	script datatables -->
  <script src="../../asset/js/dataTables.min.js"></script>
  
  <!-- Título de la Pestaña -->
  <title>CAC-movies | <?php echo $title?></title>
</head>

<body>
<header class="header_color">
  <nav class="header_nav_links">
    <!-- Icono y logo -->
    <a href="../../../index.php" class="header_logo">
      <i class="fas fa-film"></i>
      <span>CAC-Movies</span>
    </a>
  </nav>
</header>
