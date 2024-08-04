<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "movies_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


// Leer el archivo JSON y decodificarlo en un array
$json_data = file_get_contents('../movies.json');
$peliculas = json_decode($json_data, true);

if ($peliculas === null) {
    die("Error decoding JSON");
}

// Preparar la declaración SQL
$sql = "INSERT INTO peliculas (nombre, descripcion, genero, anio, calificacion, director, imagen) 
        VALUES (:nombre, :descripcion, :genero, :anio, :calificacion, :director, :imagen)";

$stmt = $conn->prepare($sql);

// Recorrer el array y ejecutar la declaración para cada película
foreach ($peliculas as $pelicula) {
    $stmt->bindParam(':nombre', $pelicula['nombre']);
    $stmt->bindParam(':descripcion', $pelicula['descripcion']);
    $stmt->bindParam(':genero', $pelicula['genero']);
    $stmt->bindParam(':anio', $pelicula['anio'], PDO::PARAM_INT);
    $stmt->bindParam(':calificacion', $pelicula['calificacion']);
    $stmt->bindParam(':director', $pelicula['director']);
    $stmt->bindParam(':imagen', $pelicula['imagen']);
    
    try {
        $stmt->execute();
    } catch(PDOException $e) {
        echo "Error al insertar la película: " . $pelicula['nombre'] . " - " . $e->getMessage() . "<br>";
    }
}

echo "Películas insertadas correctamente.";
?>