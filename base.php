<?php
$host = 'localhost';
$dbname = 'sales';
$username = 'root';
$password = '';

// Conexión a la base de datos con PDO
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>
