<?php
require '../../../api/connect.php';
require '../../../api/crud.php';
require '../../../helpers/functions.php';
global $conn;
session_start();

// Recibir datos del formulario
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $genero = $_POST['genero'];
    $calificacion = floatval($_POST['calificacion']);
    $seccion = $_POST['seccion'];
    $anio = intval($_POST['anio']);
    $director = $_POST['director'];

    // Array para errores y mensajes
    $errores = [];
    $messages = [];

    // Validaciones de campos obligatorios
    if (empty($_POST['nombre'])) {
        $errores['nombre'] = 'El nombre es obligatorio';
    }
    if (empty($_POST['descripcion'])) {
        $errores['descripcion'] = 'La descripción es obligatoria';
    }
    if (empty($_POST['genero'])) {
        $errores['genero'] = 'El género es obligatorio';
    }
    if (empty($_POST['calificacion'])) {
        $errores['calificacion'] = 'La calificación es obligatoria';
    }
    if (empty($_POST['seccion'])) {
        $errores['seccion'] = 'La sección es obligatoria';
    }
    if (empty($_POST['anio'])) {
        $errores['anio'] = 'El año es obligatorio';
    }
    if (empty($_POST['director'])) {
        $errores['director'] = 'El director es obligatorio';
    }

    // Validar imagen si se está actualizando
    if (isset($_FILES['imagen']['name']) && $_FILES['imagen']['size'] > 0) {
        // Verificar tamaño y tipo de la imagen
        if ($_FILES['imagen']['size'] >= 1000000) {
            $errores['imagen'] = 'La imagen es muy grande';
        }
        elseif (!in_array($_FILES['imagen']['type'], ['image/png', 'image/jpeg'])) {
            $errores['imagen'] = 'La imagen no tiene la extensión correcta';
        }
    }

    // Si no hay errores, proceder con la actualización o creación
    if (empty($errores)) {
        // Obtener la película actual si es una actualización
        $movie = [];
        if (!empty($id)) {
            $movie = searchMoviesById($id);
        }

       // Si se ha subido una nueva imagen
      if (isset($_FILES['imagen']['name']) && $_FILES['imagen']['size'] > 0) {
        $rutaDestino = '../../asset/uploads/';

        // Generar un nombre aleatorio único para la imagen
        $nombreImagen = uniqid('img_') . '_' . bin2hex(random_bytes(6)) . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $rutaImagen = $rutaDestino . $nombreImagen;

        // Mover la imagen al directorio de destino
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            // Eliminar imagen anterior si existe y no es la imagen por defecto
            if (!empty($movie['imagen']) && $movie['imagen'] !== 'default.jpg') {
                $rutaImagenAnterior = $rutaDestino . $movie['imagen'];
                if (file_exists($rutaImagenAnterior)) {
                    unlink($rutaImagenAnterior);
                }
            }
        } else {
            $errores['imagen'] = 'Error al subir la imagen';
        }
      } else {
        // Si no se subió una nueva imagen, mantener la imagen actual
        $rutaImagen = !empty($movie['imagen']) ? $movie['imagen'] : '';
      }


        // Actualizar o crear la película en la base de datos
        if (!empty($id)) {
            //buscamos la pelicula y enviamos el valor del estado que contenga para que se actualice con ese valor
            $movie = searchMoviesById($id);
            $estado = $movie['estado'];
            updateMovie($id, $nombre, $descripcion, $genero, $anio, $calificacion, $director, $rutaImagen, $seccion, $estado);

            // Redirigir con mensaje de éxito
            $messages['title'] = 'Pelicula actualizada';
            $messages['message'] = 'La película se actualizó correctamente';
            $messages['icon'] = 'success';
            $_SESSION['messages'] = $messages;
            header('Location:dashboard.php');
            exit();
        } else {
            $tempURL = isset($_FILES['imagen']['tmp_name']) ? $_FILES['imagen']['tmp_name'] : '';
            $movie = storeMovie($nombre, $descripcion, $genero, $calificacion, $seccion, $anio, $director, $rutaImagen, $tempURL);

            // Si se creó la película correctamente
            if ($movie) {
                $messages['title'] = 'Pelicula creada';
                $messages['message'] = 'La película se creó correctamente';
                $messages['icon'] = 'success';
                $_SESSION['messages'] = $messages;
                header('Location: dashboard.php');
                exit();
            } else {
                $messages['title'] = 'Error al crear la pelicula';
                $messages['message'] = 'No se pudo crear la pelicula';
                $messages['icon'] = 'error';
                
                $_SESSION['messages'] = $messages;
                $_SESSION['form_data'] = $_POST;
                header('Location: formMovie.php');
                exit();
            }
        }
    } else {
        // Si hay errores, guardar en sesión y redirigir al formulario
        $_SESSION['errores'] = $errores;
        $_SESSION['form_data'] = $_POST;
        // si existe id , es porque se esta editando reenviamos enviando el id correspondiente
        if($id){
            header("Location: formMovie.php?id=$id");
        } else{
            // sino existe id, es porque se esta creando y se reenvia sin enviarlo
            header('Location: formMovie.php');
        }
        exit();
    }
}
?>




