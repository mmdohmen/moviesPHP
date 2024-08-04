
<!-- Modal - Vista previa de card-->
<div class="modal fade modal-preview" id="pelicula<?php echo $pelicula['id_pelicula'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark">
      <div class="modal-header text-pink" style="background-color: rgb(0, 105, 197);">
        <h1 class="modal-title fs-5" id="exampleModalLabel1">Vista Previa</h1>
        <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body m-auto">
        <!-- Card de la pelicula -->
        <div class="card bg-card" style="width:18rem;border:2px solid rgb(0, 105, 197);">
          <img src="<?php echo !empty($pelicula['imagen']) || file_exists('../uploads/image/'.$pelicula['imagen']) ? $pelicula['imagen'] : '../../asset/images/no-disponible.jpg' ?>" class="card-img-top img-card" alt="imagen pelicula">
          <div class="card-body">
            <h5 class="card-title"><?php echo $pelicula['nombre'] ?></h5>
            <p class="card-text mt-2"><?php echo convert_ratings($pelicula['calificacion']) ?> </p>
            <p class="card-text">Género: <?php echo convert_genre($pelicula['genero'])?></p>
            <p>Año: <?php echo $pelicula['anio']?></p>
            <p>Director: <?php echo $pelicula['director']?></p>
						<!-- Mostrar / Ocultar detalles de la película -->
	          <button class="mt-3 link_movie-add" data-bs-toggle="modal" data-bs-target="#cardDescription<?php echo $pelicula['id_pelicula']?>">Detalles</button>
<!--	          <p class="card-text collapse position-absolute" id="cardDescription--><?php //echo $pelicula['id_pelicula']?><!--">--><?php //echo $pelicula['descripcion'] ?><!--</p>-->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--Modal Detalles -->
<div class="modal fade modal-preview" tabindex="-1" id="cardDescription<?php echo $pelicula['id_pelicula']?>" aria-hidden="true" aria-labelledby="exampleModalLabel2">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
		<div class="modal-content bg-dark">
			<div class="modal-header text-pink" style="background-color: rgb(0, 105, 197);">
				<h5 class="modal-title fs-5" id="exampleModalLabel2">Detalles</h5>
				<button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p><?php echo $pelicula['descripcion']?></p>
			</div>
			<div class="modal-footer">
				<button class="link_movie-add" data-bs-toggle="modal" data-bs-target="#pelicula<?php echo $pelicula['id_pelicula']?>"><i class="fa-solid fa-caret-left"></i>Volver</button>
			</div>
		</div>
	</div>
</div>
