<?php
require 'connect.php';
// ---------------------------------------------------------------------------------------------------
//                                            CRUD DE USUARIOS
// ---------------------------------------------------------------------------------------------------
// Crear usuario
function createUser($email, $password, $nombre, $apellido, $fecha_nac, $pais, $rol = 'usuario')
{
  global $conn;
  // Verificar si el correo ya está registrado
  if (getUserByEmail($email)) {
      return 'email_existente';
  }
  try {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $conn->prepare("INSERT INTO usuarios (email, password, nombre, apellido, fecha_nac, pais, rol) VALUES (:email, :password, :nombre, :apellido, :fecha_nac, :pais, :rol)");
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':password', $hashedPassword);
      $stmt->bindParam(':nombre', $nombre);
      $stmt->bindParam(':apellido', $apellido);
      $stmt->bindParam(':fecha_nac', $fecha_nac);
      $stmt->bindParam(':pais', $pais);
      $stmt->bindParam(':rol', $rol);

      return $stmt->execute();
    } catch (PDOException $e) {
      return false;
  }
}

// Obtener usuario por email
function getUserByEmail($email)
{
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = :email");
  $stmt->bindParam(':email', $email);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtener usuario por ID
function getUserById($id)
{
  global $conn;
  $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = :id");
  $stmt->bindParam(':id', $id);
  $stmt->execute();
  return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Obtener todos los usuarios
function getAllUsers()
{
  global $conn;
  $stmt = $conn->query("SELECT * FROM usuarios");
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Actualizar usuario
function updateUser($id, $email, $nombre, $apellido, $fecha_nac, $pais, $rol)
{
  global $conn;
  $stmt = $conn->prepare("UPDATE usuarios SET email = :email, nombre = :nombre, apellido = :apellido, fecha_nac = :fecha_nac, pais = :pais, rol = :rol WHERE id = :id");
  $stmt->bindParam(':email', $email);
  $stmt->bindParam(':nombre', $nombre);
  $stmt->bindParam(':apellido', $apellido);
  $stmt->bindParam(':fecha_nac', $fecha_nac);
  $stmt->bindParam(':pais', $pais);
  $stmt->bindParam(':rol', $rol);
  $stmt->bindParam(':id', $id);
  return $stmt->execute();
}

// Eliminar usuario
function deleteUser($id)
{
  global $conn;
  $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = :id");
  $stmt->bindParam(':id', $id);
  return $stmt->execute();
}

// Login de usuario
function loginUser($email, $password)
{
  $user = getUserByEmail($email);
  if (!$user) {
    return 'email_incorrecto';
  }
  if (!password_verify($password, $user['password'])) {
    return 'contraseña_incorrecta';
  }
  return $user;
}

// ---------------------------------------------------------------------------------------------------
//                                          CRUD DE PELICULAS
// ---------------------------------------------------------------------------------------------------
// Listar todas las peliculas - Front
function getAllMovies(){
  global $conn;

  try {
    $stmt = $conn->query("SELECT * FROM peliculas WHERE estado = 1");
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $peliculas;
  } catch (PDOException $e) {
    echo "Error al obtener datos: " . $e->getMessage();
  }
}

// Listar todas las peliculas - panel Admin
function getAllMoviesBack(){
  global $conn;

  try {
    $stmt = $conn->query("SELECT * FROM peliculas");
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $peliculas;
  } catch (PDOException $e) {
    echo "Error al obtener datos: " . $e->getMessage();
  }
}


function getAllName() {
  global $conn;

  try {
    $stmt = $conn->query("SELECT nombre FROM peliculas WHERE estado = 1");
    $peliculas = $stmt->fetchAll(PDO::FETCH_COLUMN, 0); // Obtener solo la columna de nombres
    return $peliculas;
  } catch (PDOException $e) {
    echo "Error al obtener datos: " . $e->getMessage();
  }
}

// Update de peliculas
function updateMovie($id, $nombre, $descripcion, $genero, $anio, $calificacion, $director, $imagen, $seccion, $estado) {
  global $conn;

  try {
    $stmt = $conn->prepare("
      UPDATE peliculas 
      SET 
        nombre = :nombre, 
        descripcion = :descripcion, 
        genero = :genero, 
        anio = :anio, 
        calificacion = :calificacion, 
        director = :director, 
        imagen = :imagen, 
        seccion = :seccion, 
        estado = :estado 
      WHERE 
        id_pelicula = :id_pelicula
    ");
    $stmt->bindParam(':id_pelicula', $id, PDO::PARAM_INT);
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
    $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
    $stmt->bindParam(':anio', $anio, PDO::PARAM_INT);
    $stmt->bindParam(':calificacion', $calificacion, PDO::PARAM_STR);
    $stmt->bindParam(':director', $director, PDO::PARAM_STR);
    $stmt->bindParam(':imagen', $imagen, PDO::PARAM_STR);
    $stmt->bindParam(':seccion', $seccion, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->rowCount(); // Retorna el número de filas actualizadas
  } catch (PDOException $e) {
    echo "Error al actualizar datos: " . $e->getMessage();
  }
}

function storeMovie($nombre, $descripcion, $genero, $calificacion, $seccion, $anio, $director, $imagen, $tempURL){
  global $conn;
  $estado = $tempURL === '' ? 0 : 1;
  $sql = "INSERT INTO peliculas (nombre, descripcion, genero, calificacion, seccion, anio, director,imagen, estado) VALUES (:nombre, :descripcion, :genero, :calificacion, :seccion, :anio, :director,:rutaImagen, :estado)";
  $stmt = $conn->prepare($sql);
  $stmt->bindParam(':nombre', $nombre);
  $stmt->bindParam(':descripcion', $descripcion);
  $stmt->bindParam(':genero', $genero);
  $stmt->bindParam(':calificacion', $calificacion);
  $stmt->bindParam(':seccion', $seccion);
  $stmt->bindParam(':anio', $anio);
  $stmt->bindParam(':director', $director);
  $stmt->bindParam(':rutaImagen', $imagen);
  $stmt->bindParam('estado', $estado);
  try {
    $stmt->execute();
    move_uploaded_file($tempURL, $imagen);
    return true;
  } catch (PDOException $e){
    echo "Error al guardar datos: ". $e->getMessage();
    return false;
  }
}

// trae las peliculas por seccion
function getMoviesBySection($seccion){
  global $conn;

  try {
    $stmt = $conn->prepare("SELECT * FROM peliculas WHERE seccion = :seccion AND estado = 1");
    $stmt->bindParam(':seccion', $seccion);
    $stmt->execute();
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $peliculas;
  } catch (PDOException $e) {
    echo "Error al obtener datos: " . $e->getMessage();
  }
}

// Obtener pelicula por nombre
function searchMoviesByName($name) {
  global $conn;

  try {
    // Normalizar el nombre de entrada reemplazando caracteres especiales y espacios
    $normalizedName = '%' . str_replace(['-', ' '], '%', $name) . '%';
    // Preparar la consulta principal
    $stmt = $conn->prepare("
      SELECT * FROM peliculas 
      WHERE REPLACE(REPLACE(REPLACE(nombre, '-', ''), ' ', ''), ' ', '') 
      LIKE REPLACE(REPLACE(REPLACE(:name, '-', ''), ' ', ''), ' ', '') 
      AND estado = 1
    ");
    
    // Ejecutar la consulta principal
    $stmt->execute(['name' => $normalizedName]);
    $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Si no hay resultados, hacer una nueva consulta con las primeras 4 letras
    if (empty($peliculas)) {
      $shortName = substr($name, 0, 4) . '%';
      $stmt = $conn->prepare("
        SELECT * FROM peliculas 
        WHERE nombre LIKE :shortName 
        AND estado = 1
      ");
      $stmt->execute(['shortName' => $shortName]);
      $peliculas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    return $peliculas;
  } catch (PDOException $e) {
    echo "Error al obtener datos: " . $e->getMessage();
  }
}


// Obtener pelicula por id
function searchMoviesById($id){
  global $conn;

  try {
    $stmt = $conn->prepare("SELECT * FROM peliculas WHERE id_pelicula = :id_pelicula");
    $stmt->execute(['id_pelicula' => $id]);
    $peliculas = $stmt->fetch(PDO::FETCH_ASSOC);
    return $peliculas;
  } catch (PDOException $e) {
    echo "Error al obtener datos: " . $e->getMessage();
  }
}

// Da de baja la pelicula sin eliminarla de la DB
function deleteMovie($id){
  global $conn;

  try {
    $stmt = $conn->prepare("UPDATE peliculas SET estado = 0 WHERE id_pelicula = :id_pelicula");
    $stmt->bindParam(':id_pelicula', $id);
    $stmt->execute();
    return $stmt->rowCount(); // Retorna el número de filas actualizadas
  } catch (PDOException $e) {
    echo "Error al eliminar datos: " . $e->getMessage();
  }
}

// Elimina de la base de datos
function deleteMoviePermanently($id){
  global $conn;

  try {
    $stmt = $conn->prepare("DELETE FROM peliculas WHERE id_pelicula = :id_pelicula");
    $stmt->bindParam(':id_pelicula', $id);
    $stmt->execute();
    return $stmt->rowCount(); // Retorna el número de filas eliminadas
  } catch (PDOException $e) {
    echo "Error al eliminar datos: " . $e->getMessage();
  }
}