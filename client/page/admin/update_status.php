<?php
require '../../../api/connect.php';
global $conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
$estado = intval($_POST['estado']);
$id = intval($_POST['id']);

// var_dump($id);
// exit();
  try{
  $sql_update_estado = $conn->prepare("UPDATE peliculas SET estado = :estado WHERE id_pelicula = :id");
  $sql_update_estado->bindParam('estado',$estado);
  $sql_update_estado->bindParam('id',$id);
  $sql_update_estado->execute();
  } catch (PDOException $e){
  echo "Error al actualizar el estado: ".$e->getMessage();
  }
}