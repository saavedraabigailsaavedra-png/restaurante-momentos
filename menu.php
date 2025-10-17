 <?php include 'conexion.php'; // Conexión a la base de datos

try {
    $stmt = $pdo->prepare("SELECT * FROM menu ORDER BY fecha DESC, id DESC");
    $stmt->execute();
    $platos_principales = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    $platos_principales = [];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Menú - Restaurante Momentos</title>
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family: 'Georgia', serif; background-color: #f6f2e9; color: #333; line-height:1.6; }

/* HEADER */
.navbar { background-color:#556b2f; padding:1rem 0; box-shadow:0 2px 10px rgba(0,0,0,0.1); }
.nav-container { max-width:1200px; margin:0 auto; display:flex; justify-content:space-between; align-items:center; padding:0 2rem; }
.logo { color:white; font-size:1.8rem; text-decoration:none; display:flex; align-items:center; gap:10px; }
.logo::before { content:"🍽"; font-size:1.5rem; }
.nav-menu { display:flex; gap:2rem; align-items:center; }
.nav-link { color:#dcd6c9; text-decoration:none; font-size:0.9rem; text-transform:uppercase; transition:color 0.3s; }
.nav-link:hover, .nav-link.active { color:white; }
.hamburger { display:none; flex-direction:column; cursor:pointer; }
.hamburger span { width:25px; height:3px; background:white; margin:3px 0; transition:0.3s; }

/* HERO */
.menu-hero { background-color:#6b8e23; color:white; text-align:center; padding:4rem 2rem; }
.menu-hero h1 { font-size:2.5rem; font-weight:normal; }

/* CONTAINER */
.container { max-width:1200px; margin:0 auto; padding:3rem 2rem; }

/* SECTION TITLES */
.section-title { color:#556b2f; font-size:2rem; font-weight:normal; margin-bottom:2rem; border-bottom:2px solid #c7d6a3; padding-bottom:0.5rem; display:inline-block; }

/* APERITIVOS */
.aperitivos-container { display:flex; flex-wrap:wrap; gap:2rem; justify-content:center; }
.aperitivo-item { display:flex; gap:1rem; align-items:center; background:white; padding:1.5rem; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1); transition:transform 0.3s; max-width:450px; }
.aperitivo-item:hover { transform:translateY(-5px); box-shadow:0 10px 25px rgba(0,0,0,0.15); }
.aperitivo-image { width:120px; height:120px; border-radius:12px; overflow:hidden; flex-shrink:0; background:#f0f0e8; display:flex; justify-content:center; align-items:center; color:#999; }
.aperitivo-image img { width:100%; height:100%; object-fit:cover; }
.aperitivo-info h3 { color:#556b2f; margin-bottom:0.5rem; font-size:1.2rem; font-weight:normal; }
.aperitivo-info .precio { font-size:1.1rem; font-weight:bold; color:#333; }

/* PLATOS PRINCIPALES */
.platos-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(280px,1fr)); gap:2rem; }
.plato-item { background:white; border-radius:12px; overflow:hidden; box-shadow:0 5px 15px rgba(0,0,0,0.1); transition:transform 0.3s; }
.plato-item:hover { transform:translateY(-5px); box-shadow:0 10px 25px rgba(0,0,0,0.15); }
.plato-image { width:100%; height:220px; overflow:hidden; background:linear-gradient(135deg,#f6f2e9,#e8e4d0); display:flex; align-items:center; justify-content:center; color:#999; }
.plato-image img { width:100%; height:100%; object-fit:cover; transition:transform 0.3s; }
.plato-image img:hover { transform:scale(1.05); }
.plato-image .no-image { font-size:3rem; opacity:0.3; }
.plato-info { padding:1.5rem; text-align:center; }
.plato-info h3 { color:#556b2f; margin-bottom:0.5rem; font-size:1.2rem; font-weight:normal; }
.plato-info .descripcion { color:#666; font-size:0.9rem; margin-bottom:0.5rem; }
.plato-info .precio { font-size:1.1rem; font-weight:bold; color:#333; }
.plato-info .fecha { color:#999; font-size:0.8rem; font-style:italic; }

/* POSTRES */
.postres-container { display:flex; flex-direction:column; gap:1.5rem; max-width:800px; margin:0 auto; }
.postre-item { display:flex; gap:1rem; align-items:center; background:white; padding:1.2rem; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); transition:transform 0.3s; }
.postre-item:hover { transform:translateX(5px); box-shadow:0 6px 20px rgba(0,0,0,0.15); }
.postre-image { width:100px; height:100px; border-radius:12px; overflow:hidden; background:#f0f0e8; display:flex; justify-content:center; align-items:center; color:#999; }
.postre-image img { width:100%; height:100%; object-fit:cover; }
.postre-image .no-image { font-size:2rem; opacity:0.3; }
.postre-info h3 { color:#556b2f; margin-bottom:0.3rem; font-size:1.1rem; font-weight:normal; }
.postre-info .precio { font-size:1.1rem; font-weight:bold; color:#333; }

/* NO PLATOS */
.no-platos { text-align:center; padding:2rem; background:white; border-radius:12px; box-shadow:0 5px 15px rgba(0,0,0,0.1); margin-top:2rem; }
.no-platos h3 { color:#556b2f; margin-bottom:1rem; font-size:1.5rem; }

/* FOOTER */
.footer { background-color:#556b2f; color:white; text-align:center; padding:3rem 2rem; margin-top:4rem; }
.footer p { font-size:1rem; margin-bottom:0.5rem; }
.footer .socials { display:flex; justify-content:center; gap:1rem; margin-top:1rem; }
.footer .socials a { color:white; font-size:1.5rem; text-decoration:none; transition:color 0.3s; }
.footer .socials a:hover { color:#c7d6a3; }

/* RESPONSIVO */
@media(max-width:768px){ .hamburger{display:flex;} .nav-menu{position:fixed; left:-100%; top:0; flex-direction:column; background-color:#556b2f; width:100%; height:100vh; text-align:center; transition:0.3s; gap:3rem; padding-top:6rem;} .nav-menu.active{left:0;} }
@media(max-width:480px){ .platos-grid{grid-template-columns:1fr;} .aperitivo-item, .postre-item{flex-direction:column; text-align:center; } .aperitivo-image,.postre-image{width:100px;height:100px;} }
</style>
</head>
<body>
<header>
<nav class="navbar">
<div class="nav-container">
<h1 class="logo"><a href="index.php">Momentos</a></h1>
<div class="hamburger" onclick="toggleMenu()"><span></span><span></span><span></span></div>
<div class="nav-menu" id="navMenu">
<a href="index.php" class="nav-link">INICIO</a>
<a href="menu.php" class="nav-link active">MENÚ</a>
<a href="contacto.php" class="nav-link">CONTACTO</a>
<a href="reservas.php" class="nav-link">RESERVAS</a>
</div>
</div>
</nav>
</header>

<div class="menu-hero">
<h1>Descubre nuestro menú</h1>
</div>

<div class="container">

<!-- Aperitivos -->
<div class="menu-section">
<h2 class="section-title">Aperitivos</h2>
<div class="aperitivos-container">
<div class="aperitivo-item">
<div class="aperitivo-image">
<img src="https://images.unsplash.com/photo-1562967914-608f82629710?w=300&h=300&fit=crop&q=80" alt="Nuggets" onerror="this.parentNode.innerHTML='<div class=\'no-image\'>🍗</div>';">
</div>
<div class="aperitivo-info">
<h3>Nuggets de pollo crujientes</h3>
<p class="precio">30 Bs</p>
</div>
</div>
</div>
</div>

<!-- Platos principales -->
<div class="menu-section">
<h2 class="section-title">Platos principales</h2>
<?php if(!empty($platos_principales)): ?>
<div class="platos-grid">
<?php foreach($platos_principales as $plato): ?>
<div class="plato-item">
<div class="plato-image">
<?php if(!empty($plato['imagen']) && file_exists($plato['imagen'])): ?>
<img src="<?php echo htmlspecialchars($plato['imagen']); ?>" alt="<?php echo htmlspecialchars($plato['nombre']); ?>" onerror="this.parentNode.innerHTML='<div class=\'no-image\'>🍽️</div>';">
<?php else: ?>
<div class="no-image">🍽️</div>
<?php endif; ?>
</div>
<div class="plato-info">
<h3><?php echo htmlspecialchars($plato['nombre']); ?></h3>
<?php if(!empty($plato['descripcion'])): ?>
<p class="descripcion"><?php echo htmlspecialchars($plato['descripcion']); ?></p>
<?php endif; ?>
<p class="precio"><?php echo number_format($plato['precio'],0); ?> Bs</p>
<p class="fecha">Disponible: <?php echo date('d/m/Y',strtotime($plato['fecha'])); ?></p>
</div>
</div>
<?php endforeach; ?>
</div>
<?php else: ?>
<div class="no-platos">
<h3>No hay platos disponibles</h3>
<p>Vuelve pronto para descubrir nuestras especialidades.</p>
</div>
<?php endif; ?>
</div>

<!-- Postres -->
<div class="menu-section">
<h2 class="section-title">Postres</h2>
<div class="postres-container">
<div class="postre-item">
<div class="postre-image"><img src="brazo.jpeg" alt="Brazo gitano" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';"><div class="no-image" style="display:none;">🍰</div></div>
<div class="postre-info"><h3>Brazo gitano</h3><p class="precio">15 Bs</p></div>
</div>
<div class="postre-item">
<div class="postre-image"><img src="https://images.unsplash.com/photo-1546173159-315724a31696?w=200&h=200&fit=crop&q=80" alt="Ensalada de frutas" onerror="this.parentNode.innerHTML='<div class=\'no-image\'>🥗</div>';"></div>
<div class="postre-info"><h3>Ensalada de frutas</h3><p class="precio">20 Bs</p></div>
</div>
<div class="postre-item">
<div class="postre-image"><img src="https://images.unsplash.com/photo-1551024506-0bccd828d307?w=200&h=200&fit=crop&q=80" alt="Flan" onerror="this.parentNode.innerHTML='<div class=\'no-image\'>🍮</div>';"></div>
<div class="postre-info"><h3>Flan de chocolate</h3><p class="precio">15 Bs</p></div>
</div>
</div>
</div>

</div>

<!-- Footer -->
<footer class="footer">
<p>Si te interesa el servicio de catering contáctanos al:</p>
<p class="phone">63560579</p>
<div class="socials">
<a href="#"><span>📘</span></a>
<a href="#"><span>📸</span></a>
<a href="#"><span>🎵</span></a>
</div>
<p>&copy; 2024 Restaurante Momentos. Todos los derechos reservados.</p>
</footer>

<script>
function toggleMenu(){
const navMenu=document.getElementById('navMenu');
const hamburger=document.querySelector('.hamburger');
navMenu.classList.toggle('active');
hamburger.classList.toggle('active');
document.body.style.overflow=navMenu.classList.contains('active')?'hidden':'auto';
}
document.querySelectorAll('.nav-link').forEach(link=>{link.addEventListener('click',()=>{document.getElementById('navMenu').classList.remove('active');document.querySelector('.hamburger').classList.remove('active');document.body.style.overflow='auto';});});
</script>
</body>
</html>
