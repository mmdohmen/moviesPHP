<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "movies_db";
$charset = "utf8mb4";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}