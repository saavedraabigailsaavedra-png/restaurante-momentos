 <?php
session_start();
if(!isset($_SESSION['admin'])){
    header("Location: ../login.php");
    exit;
}
include "../conexion.php";

// Aceptar / Rechazar
if(isset($_GET['accion']) && isset($_GET['id'])){
    $id = $_GET['id'];
    if($_GET['accion']==='aceptar'){
        $pdo->prepare("UPDATE reservas SET estado='aceptada' WHERE id=?")->execute([$id]);
    } elseif($_GET['accion']==='rechazar'){
        $pdo->prepare("UPDATE reservas SET estado='rechazada' WHERE id=?")->execute([$id]);
    }
    header("Location: reservas.php");
    exit;
}

$reservas = $pdo->query("SELECT * FROM reservas ORDER BY fecha DESC, hora DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gestionar Reservas</title>
<link rel="stylesheet" href="../style.css">
<style>
body {
    font-family: Arial, sans-serif;
    background: linear-gradient(135deg, #667eea, #764ba2);
    margin:0; padding:20px; color:#333;
}

.container {
    max-width:1200px;
    margin:0 auto;
    background:#fff;
    padding:30px;
    border-radius:15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

h1 {
    text-align:center;
    margin-bottom:20px;
    color:#2d5a4f;
}

table {
    width:100%;
    border-collapse:collapse;
}

th, td {
    border:1px solid #ccc;
    padding:10px;
    text-align:center;
}

th {
    background:#2d5a4f;
    color:#fff;
}

a {
    text-decoration:none;
    margin:0 3px;
    display:inline-block;
    padding:5px 10px;
    border-radius:5px;
    font-size:0.9rem;
    transition: all 0.3s ease;
}

a.accept {background:#28a745; color:#fff;}
a.accept:hover {background:#218838; transform: translateY(-2px);}
a.reject {background:#dc3545; color:#fff;}
a.reject:hover {background:#c82333; transform: translateY(-2px);}
a.btn-back, a.btn-logout {
    background:#6c757d;color:#fff; padding:10px 20px; display:inline-block; margin-top:20px;
    text-align:center;
}
a.btn-logout {background:#ff9800;}
a.btn-back:hover {background:#5a6268;}
a.btn-logout:hover {background:#fb8c00;}

/* Modo responsivo */
@media(max-width: 992px){
    table {
        display: block;
    }
    thead {
        display: none;
    }
    tr {
        display: block;
        margin-bottom:20px;
        border: 2px solid #ccc;
        border-radius: 10px;
        padding:10px;
    }
    td {
        display: flex;
        justify-content: space-between;
        padding:8px 5px;
        border:none;
        border-bottom:1px solid #eee;
        font-size: 0.95rem;
    }
    td:last-child {border-bottom:none;}
    td::before {
        content: attr(data-label);
        font-weight:bold;
        color:#2d5a4f;
        margin-right:10px;
    }
    td a {margin:2px 2px;}
}
</style>
</head>
<body>
<div class="container">
<h1>📅 Gestión de Reservas</h1>

<table>
<thead>
<tr>
<th>Cliente</th><th>Correo</th><th>Teléfono</th><th>Mesa</th><th>Personas</th><th>Fecha</th><th>Hora</th><th>Estado</th><th>Acciones</th>
</tr>
</thead>
<tbody>
<?php foreach($reservas as $r): ?>
<tr>
<td data-label="Cliente"><?php echo $r['nombre']." ".$r['apellido']; ?></td>
<td data-label="Correo"><?php echo $r['correo']; ?></td>
<td data-label="Teléfono"><?php echo $r['telefono']; ?></td>
<td data-label="Mesa"><?php echo $r['mesa']; ?></td>
<td data-label="Personas"><?php echo $r['cantidad_personas']; ?></td>
<td data-label="Fecha"><?php echo $r['fecha']; ?></td>
<td data-label="Hora"><?php echo $r['hora']; ?></td>
<td data-label="Estado"><?php echo ucfirst($r['estado']); ?></td>
<td data-label="Acciones">
<?php if($r['estado']==='pendiente'): ?>
<a class="accept" href="reservas.php?accion=aceptar&id=<?php echo $r['id']; ?>">✅ Aceptar</a>
<a class="reject" href="reservas.php?accion=rechazar&id=<?php echo $r['id']; ?>">❌ Rechazar</a>
<?php else: ?>
<em><?php echo ucfirst($r['estado']); ?></em>
<?php endif; ?>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<a href="dashboard.php" class="btn-back">⬅ Volver al panel</a>
<a href="salir.php" class="btn-logout">🚪 Cerrar Sesión</a>
</div>
</body>
</html>
