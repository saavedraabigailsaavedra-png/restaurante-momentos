 <?php
include "conexion.php";

if (isset($_POST['crear'])) {
    $usuario = $_POST['usuario'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $nombre = $_POST['nombre'];

    $stmt = $pdo->prepare("INSERT INTO administrador (usuario, contrasena, nombre) VALUES (?,?,?)");
    $stmt->execute([$usuario, $contrasena, $nombre]);

    echo "<p style='color:green; text-align:center;'>✅ Administrador creado con éxito. Ahora podés ir a <a href='login.php'>Login</a></p>";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Admin</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>👤 Crear Administrador</h1>
  <form method="POST">
    <input type="text" name="nombre" placeholder="Nombre completo" required>
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    <button type="submit" name="crear">Crear Admin</button>
  </form>
  <nav><a href="index.php">⬅ Volver al inicio</a></nav>
</body>
</html>