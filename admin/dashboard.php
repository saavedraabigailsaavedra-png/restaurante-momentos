 <?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel de Administración</title>
<link rel="stylesheet" href="../style.css">
<style>
body { font-family: Arial; background: #f0f2f5; text-align:center; }
.container { margin:50px auto; background:white; padding:30px; border-radius:15px; width:400px; box-shadow:0 5px 20px rgba(0,0,0,0.2); }
nav a { display:block; margin:15px 0; padding:12px; background:#667eea; color:white; text-decoration:none; border-radius:8px; }
nav a:hover { background:#5a67d8; }
</style>
</head>
<body>
<div class="container">
<h1>📊 Panel de Administración</h1>
<p>Bienvenido, <strong><?php echo htmlspecialchars($_SESSION['admin']); ?></strong></p>
<nav>
    <a href="menu.php">📋 Gestionar Menú</a>
    <a href="reservas.php">📅 Gestionar Reservas</a>
    <a href="salir.php">🚪 Cerrar Sesión</a>
</nav>
</div>
</body>
</html>
