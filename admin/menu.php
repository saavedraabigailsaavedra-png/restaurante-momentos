 <?php 
session_start(); 
if (!isset($_SESSION['admin'])) { 
    header("Location: ../login.php"); 
    exit; 
} 
include "../conexion.php";

// Función para subir imagen
function subirImagen($archivo) {
    $upload_dir = "../images/platos/";
    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
    
    $ext = strtolower(pathinfo($archivo["name"], PATHINFO_EXTENSION));
    $nombre = uniqid() . "." . $ext;
    $ruta = $upload_dir . $nombre;

    $tipos_permitidos = ["jpg","jpeg","png","webp"];
    if(!in_array($ext, $tipos_permitidos) || $archivo["size"] > 5000000) return false;

    if(move_uploaded_file($archivo["tmp_name"], $ruta)) return "images/platos/" . $nombre;
    return false;
}

// Guardar o actualizar plato
if(isset($_POST['guardar'])) {
    $id = $_POST['id'] ?? 0;
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);
    $precio = $_POST['precio'];
    $fecha = $_POST['fecha'];
    $imagen_actual = $_POST['imagen_actual'] ?? '';

    $imagen_ruta = $imagen_actual;
    if(!empty($_FILES['imagen']['name'])) {
        $nueva_imagen = subirImagen($_FILES['imagen']);
        if($nueva_imagen){
            if($imagen_actual && file_exists("../".$imagen_actual)) unlink("../".$imagen_actual);
            $imagen_ruta = $nueva_imagen;
        } else {
            $error_imagen = "Error al subir la imagen. Verifique formato y tamaño.";
        }
    }

    if(!isset($error_imagen)){
        try {
            if($id){
                $upd = $pdo->prepare("UPDATE menu SET nombre=?, descripcion=?, precio=?, fecha=?, imagen=? WHERE id=?");
                $upd->execute([$nombre, $descripcion, $precio, $fecha, $imagen_ruta, $id]);
            } else {
                $ins = $pdo->prepare("INSERT INTO menu (nombre, descripcion, precio, fecha, imagen) VALUES (?,?,?,?,?)");
                $ins->execute([$nombre, $descripcion, $precio, $fecha, $imagen_ruta]);
            }

            // Mensaje de éxito usando sesión
            $_SESSION['mensaje_exito'] = "✅ ¡Plato guardado exitosamente!";
            header("Location: menu.php");
            exit;
        } catch(PDOException $e){
            $error_db = "Error en la base de datos: " . $e->getMessage();
        }
    }
}

// Eliminar plato
if(isset($_GET['eliminar'])){
    $stmt = $pdo->prepare("SELECT imagen FROM menu WHERE id=?");
    $stmt->execute([$_GET['eliminar']]);
    $plato = $stmt->fetch();
    if($plato && $plato['imagen'] && file_exists("../".$plato['imagen'])) unlink("../".$plato['imagen']);
    
    $del = $pdo->prepare("DELETE FROM menu WHERE id=?");
    $del->execute([$_GET['eliminar']]);
    $_SESSION['mensaje_exito'] = "🗑️ Plato eliminado correctamente.";
    header("Location: menu.php");
    exit;
}

// Editar plato
$editar = null;
if(isset($_GET['editar'])){
    $stmt = $pdo->prepare("SELECT * FROM menu WHERE id=?");
    $stmt->execute([$_GET['editar']]);
    $editar = $stmt->fetch();
}

// Obtener todos los platos
$platos = $pdo->query("SELECT * FROM menu ORDER BY fecha DESC, id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestionar Menú</title>
<link rel="stylesheet" href="../style.css">
<style>
.mensaje-exito {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 10px;
    margin-bottom: 15px;
    border-radius: 5px;
}

.btn-panel, .btn-salir {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 8px;
    text-decoration: none;
    color: white;
    font-weight: bold;
    margin-right: 10px;
    transition: all 0.3s;
}

/* Botón volver al panel - verde */
.btn-panel {
    background-color: #4CAF50;
}
.btn-panel:hover {
    background-color: #45a049;
    transform: translateY(-2px);
}

/* Botón cerrar sesión - rojo */
.btn-salir {
    background-color: #f44336;
}
.btn-salir:hover {
    background-color: #e53935;
    transform: translateY(-2px);
}
</style>
</head>
<body>
<div class="container">
    <h1>🍽 Gestión del Menú</h1>

    <!-- Mostrar mensaje de éxito -->
    <?php 
    if(isset($_SESSION['mensaje_exito'])){
        echo "<div class='mensaje-exito'>".$_SESSION['mensaje_exito']."</div>";
        unset($_SESSION['mensaje_exito']);
    }
    ?>

    <?php if(isset($error_imagen)) echo "<div class='error'>$error_imagen</div>"; ?>
    <?php if(isset($error_db)) echo "<div class='error'>$error_db</div>"; ?>

    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $editar['id'] ?? ''; ?>">
        <input type="hidden" name="imagen_actual" value="<?php echo $editar['imagen'] ?? ''; ?>">

        <label>Nombre del Plato:</label>
        <input type="text" name="nombre" required value="<?php echo htmlspecialchars($editar['nombre'] ?? ''); ?>">

        <label>Descripción:</label>
        <textarea name="descripcion"><?php echo htmlspecialchars($editar['descripcion'] ?? ''); ?></textarea>

        <label>Precio (Bs):</label>
        <input type="number" step="0.01" name="precio" required value="<?php echo $editar['precio'] ?? ''; ?>">

        <label>Fecha:</label>
        <input type="date" name="fecha" required value="<?php echo $editar['fecha'] ?? date('Y-m-d'); ?>">

        <label>Imagen:</label>
        <input type="file" name="imagen" accept="image/*">
        <?php if($editar && $editar['imagen']): ?>
            <p>Imagen actual: <img src="../<?php echo $editar['imagen']; ?>" width="100"></p>
        <?php endif; ?>

        <button type="submit" name="guardar"><?php echo $editar?'Actualizar':'Guardar'; ?></button>
    </form>

    <h2>Platos Registrados</h2>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre</th><th>Descripción</th><th>Precio</th><th>Fecha</th><th>Imagen</th><th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($platos as $p): ?>
            <tr>
                <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                <td><?php echo htmlspecialchars($p['descripcion']); ?></td>
                <td><?php echo number_format($p['precio'],2); ?> Bs</td>
                <td><?php echo $p['fecha']; ?></td>
                <td>
                    <?php if($p['imagen'] && file_exists("../".$p['imagen'])): ?>
                        <img src="../<?php echo $p['imagen']; ?>" width="80">
                    <?php else: ?>
                        Sin imagen
                    <?php endif; ?>
                </td>
                <td>
                    <a href="menu.php?editar=<?php echo $p['id']; ?>">✏️ Editar</a> | 
                    <a href="menu.php?eliminar=<?php echo $p['id']; ?>" onclick="return confirm('Eliminar este plato?')">🗑️ Eliminar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <br>
    <a href="dashboard.php" class="btn-panel">⬅ Volver al Panel</a>
    <a href="salir.php" class="btn-salir">🚪 Cerrar Sesión</a>
</div>
</body>
</html>
