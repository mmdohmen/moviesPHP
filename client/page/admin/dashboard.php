<?php
	require '../../../api/crud.php';
	require '../../../helpers/functions.php';
	session_start();
	$user = isset($_SESSION['user']) ? $_SESSION['user'] : null;

	if (!$user) {
		header('Location: ../../../index.php');
		exit; // Detén la ejecución del script
	}
	
	// Verifica si el usuario tiene el rol de administrador
	if ($user['rol'] !== 'admin') {
		// Si el usuario no es administrador, redirige al índice
		header('Location: ../../../index.php');
		exit; // Detén la ejecución del script
	}


	$peliculas = getAllMoviesBack();
	
	// incluir el header pasandole el titulo para la pestaña
	$title = 'Panel-Admin';
	include '../layouts/partials/backend/header.php';
?>

<!--Contenido para mostrar en vista dashboard-->
  <?php if ($user) : ?>
  <?php if ($user['rol'] == 'admin') : ?>
  <main class="container-fluid p-5 container-api">
    <div class="d-flex align-items-center justify-content-between">
      <h1 class="fs-3">Administrador de Películas</h1>
      <a href="formMovie.php" class="link_movie-add"><i class="fa-regular fa-file"></i>Agregar</a>
    </div>
    <section class="mt-5">
      <?php if (count($peliculas) == 0) : ?>
      <h3 class="fs-5 text-center">No hay ninguna pelicula en el sistema</h3>
      <?php else : ?>
      <div class="row">
        <div class="col">
          <div class="table-responsive">
            <table class="table table-dark table-hover table-bordered my-4" id="myTable">
              <thead>
                <tr class="text-center">
                  <th style="background-color:#00000025">COD</th>
                  <!--									<th style="background-color:#00000025">Imágen</th>-->
                  <th style="background-color:#00000025">Nombre</th>
                  <!--									<th style="background-color:#00000025">Descripción</th>-->
                  <th style="background-color:#00000025">Género</th>
                  <!--									<th style="background-color:#00000025">Calificación</th>-->
                  <th style="background-color:#00000025">Año</th>
                  <th style="background-color:#00000025">Director</th>
                  <th style="background-color:#00000025">Sección</th>
                  <th style="background-color:#00000025">Activo</th>
                  <th style="background-color:#00000025">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($peliculas as $indice => $pelicula) : ?>
                <tr>
                  <td class="text-center align-middle"><?php echo $pelicula['id_pelicula'] ?></td>
                  <td class="align-middle"><?php echo $pelicula['nombre'] ?></td>
                  <td class="align-middle"><?php echo $pelicula['genero'] ?></td>
                  <td class="text-center align-middle"><?php echo $pelicula['anio'] ?></td>
                  <td class="align-middle"><?php echo $pelicula['director'] ?></td>
                  <td class="align-middle"><?php echo $pelicula['seccion'] ?></td>
                  <td class="text-center align-middle"><input type="checkbox"
                      id="estado<?php echo $pelicula['id_pelicula'] ?>"
                      onchange="changeStatus(<?php echo $pelicula['id_pelicula'] ?>)" name="estado"
                      <?php echo $pelicula['estado'] == 1 ? 'checked' : '' ?>></td>
                  <td class="align-middle">
                    <div class="d-flex justify-content-center align-items-center gap-3">
                      <a role="button" data-bs-toggle="modal"
                        data-bs-target="#pelicula<?php echo $pelicula['id_pelicula'] ?>">
                        <i class="fa-regular fa-eye bg-none text-light text-hover" title="Vista Previa"></i>
                      </a>


                      <a href="formMovie.php?id=<?php echo $pelicula['id_pelicula'] ?>">
                        <i class="fa-regular fa-pen-to-square text-pink text-hover" title="Editar"></i>
                      </a>
											<!-- Eliminar película -->
                      <form action="deleteMovie.php" method="POST" id="formDelete<?php echo $pelicula['id_pelicula']?>">
                        <input type="hidden" name="id" value="<?php echo $pelicula['id_pelicula'] ?>">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="button" onclick="confirmDelete('formDelete', <?php echo $pelicula['id_pelicula']?>)" class="link-delete text-hover">
	                        <i class="fa-regular fa-trash-can text-danger text-hover" title="Eliminar"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                <!-- archivo para mostrar el modal de vista previa-->
                <?php include '../../components/modal-preview.php' ?>
                <?php endforeach ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div id="message" data-active="<?php echo $active ?>" data-message="<?php echo $message ?>"></div>
      <?php endif ?>
    </section>
  </main>
  <?php endif; ?>
  <?php endif; ?>

<!-- Incluir el footer -->
<?php include '../layouts/partials/backend/footer.php' ?>
