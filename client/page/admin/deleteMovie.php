<?php
  require '../../../api/crud.php';
  
if($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['_method']=='DELETE'){
  $id = $_POST['id'];
  $messages=[];
  try{
    // Buscamos la pelicula para saber que imágen tiene
    $movie = searchMoviesById($id);
    // verificamos si la imágen es una url ó no, y si no es una url eliminanos la imágen de la carpeta uploads
    if(!filter_var($movie['imagen'], FILTER_VALIDATE_URL)){
      unlink('../../asset/uploads/'.$movie['imagen']);
    }
    // eliminamos la pelicula permanentemente
    $deleteMovie = deleteMoviePermanently($id);
    if ($deleteMovie > 0){
      $messages['title'] = "Pelicula eliminada";
      $messages['message'] = 'La película se eliminó correctamente';
      $messages['icon'] = "success";
      session_start();
      $_SESSION['messages'] = $messages;
      header('Location:dashboard.php');
    }
  } catch (PDOException $e){
//    var_dump($e->getMessage());
    $messages['title'] = "Error al eliminar";
    $messages['message'] = 'No se pudo eliminar la película';
    $messages['icon'] = "error";
    session_start();
    $_SESSION['messages'] = $messages;
    header('Location:dashboard.php');
  }
}