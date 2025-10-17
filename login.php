 <?php
session_start();
include "conexion.php"; // tu conexión PDO

// 🔐 --- OPCIÓN ESPECIAL PARA GENERAR NUEVA CONTRASEÑA ---
// Ejemplo de uso: http://localhost/tu_proyecto/login.php?nueva=12345
if (isset($_GET['nueva'])) {
    echo "<h2>🔑 Hash generado para la nueva contraseña:</h2>";
    echo "<p><b>Contraseña:</b> " . htmlspecialchars($_GET['nueva']) . "</p>";
    echo "<p><b>Hash (copia este valor en la BD):</b></p>";
    echo "<textarea style='width:100%;height:120px;'>" . password_hash($_GET['nueva'], PASSWORD_DEFAULT) . "</textarea>";
    echo "<hr><a href='login.php'>Volver al login</a>";
    exit;
}
// 🔐 --- FIN DEL GENERADOR ---

if (isset($_POST['entrar'])) {
    $usuario = trim($_POST['usuario']);
    $contrasena = $_POST['contrasena'];

    if (!empty($usuario) && !empty($contrasena)) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM administrador WHERE usuario = ?");
            $stmt->execute([$usuario]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($contrasena, $admin['contrasena'])) {
                $_SESSION['admin'] = $admin['usuario'];
                // Redirige al panel de admin
                header("Location: admin/dashboard.php");
                exit;
            } else {
                $error = "Usuario o contraseña incorrectos";
            }
        } catch (Exception $e) {
            $error = "Error al conectar con la base de datos";
        }
    } else {
        $error = "Debes completar todos los campos";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login - Administrador</title>
<link rel="stylesheet" href="style.css">
<style>
.login-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 30px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}
.form-group { margin-bottom: 20px; position: relative; }
.form-group input {
    width: 100%;
    padding: 12px;
    border: 2px solid #ddd;
    border-radius: 8px;
    font-size: 16px;
    transition: all 0.3s;
}
.form-group input:focus {
    outline: none;
    border-color: #4CAF50;
}
.password-container { position: relative; }
.password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 18px;
    color: #666;
    user-select: none;
}
.login-btn {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s;
}
.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}
.error-msg {
    background: #f8d7da;
    color: #721c24;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 15px;
    border-left: 4px solid #dc3545;
    text-align:center;
}
</style>
</head>
<body>
<div class="login-container">
  <h1 style="text-align:center;">🔒 Acceso Administrador</h1>

  <?php if(isset($error)): ?>
    <div class="error-msg"><?php echo $error; ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="form-group">
      <input type="text" name="usuario" placeholder="Usuario" required autocomplete="off" autocorrect="off" autocapitalize="none">
    </div>

    <div class="form-group password-container">
      <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" required autocomplete="off" autocorrect="off" autocapitalize="none">
      <span class="password-toggle" onclick="togglePassword()">👁</span>
    </div>

    <button type="submit" name="entrar" class="login-btn">🔑 Ingresar</button>
  </form>

  <br>
  <a href="index.php" style="display:block; text-align:center; margin-top:10px; color:#667eea; text-decoration:none;">🏠 Ir a Página Principal</a>

  <hr>
  
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById('contrasena');
    const toggleIcon = document.querySelector('.password-toggle');
    if(passwordField.type === 'password'){
        passwordField.type = 'text';
        toggleIcon.textContent = '🙈';
    } else {
        passwordField.type = 'password';
        toggleIcon.textContent = '👁';
    }
}
</script>
</body>
</html>
