<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Momentos - Restaurante</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Georgia', serif;
            line-height: 1.6;
            color: #333;
        }

        /* Admin Access Button - Floating */
        .admin-access {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
        }

        .admin-btn {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #2c1810, #3d241a);
            color: white;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            font-size: 1.2rem;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-btn:hover {
            transform: scale(1.1) translateY(-2px);
            box-shadow: 0 15px 50px rgba(0,0,0,0.3);
            background: linear-gradient(135deg, #3d241a, #4e2f21);
        }

        .admin-btn:active {
            transform: scale(1.05);
        }

        /* Header y Navegación */
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo-icon {
            width: 50px;
            height: 50px;
            background: #2d5a4f;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .logo-text {
            font-size: 2rem;
            font-weight: bold;
            color: #2d5a4f;
        }

        .nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .nav-link {
            text-decoration: none;
            color: #666;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: color 0.3s;
            border-radius: 25px;
        }

        .nav-link:hover {
            color: #2d5a4f;
            background: rgba(45, 90, 79, 0.1);
        }

        .dropdown {
            position: relative;
        }

        .dropdown-toggle {
            background: none;
            border: none;
            color: #666;
            font-weight: 500;
            padding: 0.5rem 1rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            border-radius: 25px;
            transition: all 0.3s;
        }

        .dropdown-toggle:hover {
            color: #2d5a4f;
            background: rgba(45, 90, 79, 0.1);
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: #2d5a4f;
            min-width: 160px;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .dropdown.active .dropdown-menu {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: block;
            padding: 1rem 1.5rem;
            color: #ccc;
            text-decoration: none;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)),
                        url('https://images.unsplash.com/photo-1514933651103-005eec06c04b?w=1200&h=800&fit=crop&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 0 2rem;
        }

        .hero h1 {
            font-family: 'Georgia', serif;
            font-size: 4rem;
            color: #f8f6f3;
            margin-bottom: 1rem;
            font-weight: bold;
            text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.5);
        }

        .hero p {
            font-size: 1.5rem;
            color: #f0f0f0;
            max-width: 600px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
        }

        /* Sections */
        .section {
            padding: 6rem 2rem;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-dark {
            background: #2d5a4f;
            color: white;
        }

        .section-light {
            background: #f8f6f3;
        }

        /* Meat Section */
        .meat-hero {
            display: flex;
            align-items: center;
            gap: 3rem;
            margin-bottom: 4rem;
        }

        .meat-content {
            flex: 1;
        }

        .meat-content h2 {
            font-size: 3rem;
            color: #c9a876;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .meat-content p {
            font-size: 1.2rem;
            color: #ccc;
        }

        .meat-image {
            width: 300px;
            height: 200px;
            border-radius: 10px;
            overflow: hidden;
            background:#ccc;
        }

        .meat-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Breakfast Section */
        .breakfast-hero {
            text-align: center;
            margin-bottom: 4rem;
        }

        .breakfast-hero h2 {
            font-size: 3rem;
            color: #2d5a4f;
            margin-bottom: 1rem;
        }

        .breakfast-hero h3 {
            font-size: 1.5rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .breakfast-hero p {
            font-size: 1.1rem;
            color: #666;
            max-width: 800px;
            margin: 0 auto;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 3rem;
            margin-top: 4rem;
        }

        .product-card {
            text-align: center;
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-image {
            width: 200px;
            height: 150px;
            margin: 0 auto 1.5rem;
            border-radius: 10px;
            overflow: hidden;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-image img:empty {
            background: #ccc;
        }

        .product-image:hover img {
            transform: scale(1.05);
        }

        .product-card h3 {
            font-size: 1.8rem;
            color: #2d5a4f;
            margin-bottom: 1rem;
        }

        .product-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Lunch Section */
        .lunch-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
                        url('https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=1200&h=400&fit=crop&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            text-align: center;
            padding: 6rem 2rem;
        }

        .lunch-hero h2 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .lunch-hero h3 {
            font-size: 1.5rem;
            color: #c9a876;
            margin-bottom: 2rem;
        }

        .lunch-text {
            background: rgba(248, 246, 243, 0.95);
            color: #2d5a4f;
            padding: 2rem;
            text-align: center;
            font-size: 1.2rem;
        }

        /* Drinks Section */
        .drinks-section {
            background: url('https://images.unsplash.com/photo-1559056199-641a0ac8b55e?w=1200&h=600&fit=crop&q=80');
            background-size: cover;
        }

        .drinks-content {
            display: flex;
            align-items: center;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .drinks-text {
            flex: 1;
        }

        .drinks-text h2 {
            font-size: 3rem;
            color: #2d5a4f;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .drinks-text p {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 2rem;
        }

        .drinks-gallery {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .drink-item {
            width: 100px;
            height: 100px;
            border-radius: 10px;
            overflow: hidden;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 0.8rem;
            text-align: center;
        }

        .drink-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* About Section */
        .about-section {
            text-align: center;
        }

        .about-section h2 {
            font-size: 3rem;
            color: #2d5a4f;
            margin-bottom: 3rem;
            font-style: italic;
        }

        .about-content {
            background: #2d5a4f;
            color: white;
            padding: 3rem;
            border-radius: 15px;
            margin-bottom: 3rem;
        }

        .about-content p {
            font-size: 1.2rem;
            line-height: 1.8;
        }

        .contact-info {
            background: white;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .contact-info p {
            font-size: 1.1rem;
            color: #333;
            font-weight: 500;
        }

        /* Footer */
        footer {
            background:#2d5a4f; 
            color:white; 
            padding:3rem 2rem; 
            text-align:center;
        }

        footer a {
            color:white; 
            font-size:2rem; 
            margin:0 1rem; 
            transition:0.3s;
        }

        footer a:hover {
            color:#c9a876;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header {
                padding: 1rem;
                flex-direction: column;
                gap: 1rem;
            }

            .logo-text {
                font-size: 1.5rem;
            }

            .nav {
                gap: 1rem;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero p {
                font-size: 1.2rem;
            }

            .meat-hero, .drinks-content {
                flex-direction: column;
                text-align: center;
            }

            .meat-content h2, .drinks-text h2 {
                font-size: 2rem;
            }

            .product-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .drinks-gallery {
                grid-template-columns: repeat(2, 1fr);
            }

            .section {
                padding: 4rem 1rem;
            }

            .lunch-hero h2 {
                font-size: 2.5rem;
            }

            .admin-btn {
                width: 45px;
                height: 45px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Botón de acceso administrativo -->
    <div class="admin-access">
        <a href="login.php" class="admin-btn" title="Acceso Administrativo">
            <i class="fas fa-user-shield"></i>
        </a>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="logo">
            <div class="logo-icon">M</div>
            <div class="logo-text">Restaurante</div>
        </div>
        <nav class="nav">
            <a href="#home" class="nav-link">Inicio</a>
            <div class="dropdown">
                <button class="dropdown-toggle" onclick="toggleDropdown()">
                     Mas▼
                </button>
                <div class="dropdown-menu">
                    <a href="contacto.php" class="dropdown-item">Contacto</a>
                    <a href="reservas.php" class="dropdown-item">Reservas</a>
                    <a href="menu.php" class="dropdown-item">Menu</a>
                </div>
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
        <h1>Momentos</h1>
        <p>Únicos en la mesa</p>
    </section>

    <!-- Meat Section -->
    <section class="section section-dark">
        <div class="container">
            <div class="meat-hero">
                <div class="meat-image">
                    <img src="https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=300&h=200&fit=crop&q=80" alt="Plato principal">
                </div>
                <div class="meat-content">
                    <h2>Sabores auténticos en cada bocado</h2>
                    <p>Momentos llenos de sabor</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Breakfast Section -->
    <section class="section section-light">
        <div class="container">
            <div class="breakfast-hero">
                <h2>¡Sabores que reconfortan el alma!</h2>
                <h3>Un abrazo de sabor matutino</h3>
                <p>Disfruta de una variedad de desayunos frescos y deliciosos perfectos para comenzar tu día con energía y sabor.</p>
            </div>

            <div class="product-grid">
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1506084868230-bb9d95c24759?w=200&h=150&fit=crop&q=80" alt="Tortilla">
                    </div>
                    <h3>Panqueques</h3>
                    <p>Ligero y delicioso hecho con ingredientes frescos. ¡Perfecto para un día lleno de energía.</p>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1539252554453-80ab65ce3586?w=200&h=150&fit=crop&q=80" alt="Sándwich de atún">
                    </div>
                    <h3>Sándwich de atún</h3>
                    <p>Fresco y sabroso servido en pan crujiente con vegetales frescos. ¡Una opción ligera y deliciosa para cualquier momento del día!</p>
                </div>
               
            </div>
        </div>
    </section>

    <!-- Lunch Hero -->
    <section class="lunch-hero">
        <h2>"Sabores que reconfortan el alma en cada almuerzo"</h2>
        <h3>"Plato delicioso para una pausa revitalizante"</h3>
    </section>

    <div class="lunch-text">
        <div class="container">
            <p>Prueba una variedad que siempre está en nuestro menú</p>
        </div>
    </div>

    <!-- Lunch Menu -->
    <section class="section">
        <div class="container">
            <div class="product-grid">
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1587593810167-a84920ea0781?w=200&h=150&fit=crop&q=80" alt="Pechuga de pollo a la plancha">
                    </div>
                    <h3>Pechuga de pollo a la plancha</h3>
                    <p>Jugosa y sazonada perfecta para una comida ligera</p>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=200&h=150&fit=crop&q=80" alt="Bistec">
                    </div>
                    <h3>Bistec</h3>
                    <p>Jugoso y tierno, ideal para disfrutar en cualquier comida.</p>
                </div>
                <div class="product-card">
                    <div class="product-image">
                        <img src="https://images.unsplash.com/photo-1558030006-450675393462?w=200&h=150&fit=crop&q=80" alt="Bife de chorizo">
                    </div>
                    <h3>Bife de chorizo</h3>
                    <p>Corte jugoso y sabroso, con un sabor intenso que conquista paladares.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Drinks Section -->
    <section class="section drinks-section">
        <div class="container">
            <div class="drinks-content">
                <div class="drinks-gallery">
                    
                    <div class="drink-item">
                        <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=100&h=100&fit=crop&q=80" alt="Café">
                    </div>
                    <div class="drink-item">
                        <img src="https://images.unsplash.com/photo-1622597467836-f3285f2131b8?w=100&h=100&fit=crop&q=80" alt="Batido">
                    </div>
                    <div class="drink-item">
                        <img src="https://images.unsplash.com/photo-1622543925917-763c34d1a86e?w=100&h=100&fit=crop&q=80" alt="Jugo">
                    </div>
                </div>
                <div class="drinks-text">
                    <h2>Relájate con nuestra selección de masitas y jugos frescos.</h2>
                    <p>Momento perfecto para relajarse y disfrutar de una deliciosa taza de té.</p>
                </div>
            </div>
            <div style="text-align: center; margin-top: 2rem;">
                <p style="color: #2d5a4f; font-weight: 500;">Algunos de nuestros jugos y té que ofrecemos a cualquier hora del día.</p>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section about-section">
        <div class="container">
            <h2>Sobre nosotros</h2>
            <div class="about-content">
                <p>Momentos es un restaurante que crea experiencias memorables, donde cada cliente puede disfrutar de un ambiente acogedor, y un servicio atento, siempre dispuesto a satisfacer sus deseos culinarios.</p>
            </div>
            <div class="contact-info">
                <p>Para cualquier pedido personalizado, comuníquese con nosotros y deje un mensaje con el pedido que necesita.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p style="font-size:1.2rem; margin-bottom:1rem;">Síguenos en nuestras redes sociales</p>
            <div>
                <a href="https://www.tiktok.com" target="_blank"><i class="fab fa-tiktok"></i></a>
                <a href="https://www.facebook.com" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://www.instagram.com" target="_blank"><i class="fab fa-instagram"></i></a>
            </div>
            <p style="font-size:0.9rem; margin-top:1rem;">&copy; 2025 Restaurante Momentos. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script>
        function toggleDropdown() {
            const dropdown = document.querySelector('.dropdown');
            dropdown.classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const dropdown = document.querySelector('.dropdown');
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            });
        });
    </script>
</body>
</html>
