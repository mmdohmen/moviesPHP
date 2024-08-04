<?php
require '../../../api/crud.php';
require '../../../helpers/functions.php';
session_start();

//si existe la variable de sesion errores se almacena en el array
if (isset($_SESSION['errores'])) {
    $errores = $_SESSION['errores'];
    unset($_SESSION['errores']);
}

// Si existe la variable de sesión form_data, se almacena en el array
if (isset($_SESSION['form_data'])) {
    $form_data = $_SESSION['form_data'];
    unset($_SESSION['form_data']);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $create = true;
    $movieEdit = searchMoviesById($id);
} else {
    $create = false;
}

// incluuir header pasandole el título
$title = 'Nueva Pelicula';
include '../layouts/partials/backend/header.php';
?>

<!-- Contenido para mostrar en crear peliculas -->
<section class="container-fluid p-5 container-api">
  <div class="d-flex align-items-center justify-content-end">
    <!--			<h1 class="fs-3">Administrador de Películas</h1>-->
    <a href="dashboard.php" class="link_movie-add"><i class="fa-solid fa-caret-left"></i>Volver</a>
  </div>
  <form action="createMovie.php" method="post" class="form-peliculas" enctype="multipart/form-data">
    <h1 class="text-center p-2 h1-form">Cargar Películas</h1>
    <input type="hidden" name="id"
      value="<?php echo isset($movieEdit['id_pelicula']) ? $movieEdit['id_pelicula'] : ''; ?>" />

    <label for="nombre">Nombre</label>
    <input type="text" name="nombre"
      value="<?php echo isset($form_data['nombre']) ? $form_data['nombre'] : ($create ? $movieEdit['nombre'] : ''); ?>" />
    <?php if (isset($errores['nombre'])): ?>
    <p class="text-danger fs-6 mx-5"><?php echo $errores['nombre']; ?></p>
    <?php endif;?>

    <label for="">Descripción</label>
    <textarea name="descripcion"
      class="descripcion"><?php echo isset($form_data['descripcion']) ? $form_data['descripcion'] : ($create ? $movieEdit['descripcion'] : ''); ?></textarea>
    <?php if (isset($errores['descripcion'])): ?>
    <p class="text-danger fs-6 mx-5"><?php echo $errores['descripcion']; ?></p>
    <?php endif;?>

    <label for="genero">Género</label>
    <input type="text" name="genero" placeholder="separar con coma los Género"
      value="<?php echo isset($form_data['genero']) ? $form_data['genero'] : ($create ? $movieEdit['genero'] : ''); ?>" />
    <?php if (isset($errores['genero'])): ?>
    <p class="text-danger fs-6 mx-5"><?php echo $errores['genero']; ?></p>
    <?php endif;?>

    <!-- SELECT CALIFICACION -->
    <label for="calificacion">Calificación</label>
    <select name="calificacion" id="calificacion">
      <option value="" disabled <?php echo !$create && !isset($form_data['calificacion']) ? 'selected' : ''; ?>>
        Selecciona una calificación</option>
      <?php
$selectedCalificacion = isset($form_data['calificacion']) ? (int) $form_data['calificacion'] : ($create ? (int) $movieEdit['calificacion'] : null);
for ($i = 1; $i <= 10; $i++): ?>
      <option value="<?php echo $i - 0.1; ?>" <?php echo $selectedCalificacion === $i ? 'selected' : ''; ?>><?php echo $i; ?>
      </option>
      <?php endfor;?>
    </select>
    <?php if (isset($errores['calificacion'])): ?>
    <p class="text-danger fs-6 mx-5"><?php echo $errores['calificacion']; ?></p>
    <?php endif;?>

    <!-- SELECT SECCION -->
    <label for="seccion">Sección</label>
    <select name="seccion" id="seccion">
      <option value="" disabled <?php echo !$create && !isset($form_data['seccion']) ? 'selected' : ''; ?>>Selecciona
        una sección</option>
      <option value="list"
        <?php echo (isset($form_data['seccion']) && $form_data['seccion'] === 'list') || ($create && $movieEdit['seccion'] === 'list') ? 'selected' : ''; ?>>
        List</option>
      <option value="tendencias"
        <?php echo (isset($form_data['seccion']) && $form_data['seccion'] === 'tendencias') || ($create && $movieEdit['seccion'] === 'tendencias') ? 'selected' : ''; ?>>
        Tendencias</option>
      <option value="aclamadas"
        <?php echo (isset($form_data['seccion']) && $form_data['seccion'] === 'aclamadas') || ($create && $movieEdit['seccion'] === 'aclamadas') ? 'selected' : ''; ?>>
        Aclamadas</option>
    </select>
    <?php if (isset($errores['seccion'])): ?>
    <p class="text-danger fs-6 mx-5"><?php echo $errores['seccion']; ?></p>
    <?php endif;?>

    <label for="anio">Año</label>
    <input type="number" name="anio"
      value="<?php echo isset($form_data['anio']) ? $form_data['anio'] : ($create ? $movieEdit['anio'] : ''); ?>" />
    <?php if (isset($errores['anio'])): ?>
    <p class="text-danger fs-6 mx-5"><?php echo $errores['anio']; ?></p>
    <?php endif;?>

    <label for="director">Director</label>
    <input type="text" name="director"
      value="<?php echo isset($form_data['director']) ? $form_data['director'] : ($create ? $movieEdit['director'] : ''); ?>" />
    <?php if (isset($errores['director'])): ?>
    <p class="text-danger fs-6 mx-5"><?php echo $errores['director']; ?></p>
    <?php endif;?>

    <label for="director">Imágen</label>
    <input type="file" name="imagen" onchange="previewImage(event)" />

    <!-- MOSTRAR IMAGEN PREVIA - El contenedor se utiliza para que renderizar la imágen en el caso de que no exista -->

    <div id="previewImage">
      <?php if (!empty($movieEdit['imagen'])): ?>
      <img
        src="<?php echo !empty($movieEdit['imagen']) || file_exists('../uploads/image/' . $movieEdit['imagen']) ? $movieEdit['imagen'] : '../../asset/images/no-disponible.jpg' ?>"
        class="mx-5 my-4 img-form" alt="imagen pelicula">
      <?php endif;?>

    </div>

    <?php if (isset($errores['imagen'])): ?>
    <p class="text-danger fs-6 mx-5"><?php echo $errores['imagen'] ?></p>
    <?php endif;?>
    <input type="submit" value="<?php echo !$create ? 'Guardar' : 'Actualizar' ?>" class="mt-3" />
  </form>

</section>

<!-- Inluir footer -->
<?php include '../layouts/partials/backend/footer.php'?>