 <?php
$host = "localhost";
$dbname = "proyecto"; // nombre de la BD
$username = "root";   // cambia si usas otro usuario
$password = "";       // pon tu contraseña si tiene

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>