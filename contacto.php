 <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📍 Contacto - Momentos</title>
    <link rel="stylesheet" href="style.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Georgia', serif; background-color: #e8e8e8; color: #333; line-height: 1.6; }

        /* NAV */
        .nav { background: #4a6741; padding: 1rem; display: flex; justify-content: center; gap: 2rem; }
        .nav a { color: white; text-decoration: none; font-size: 1.1rem; font-weight: bold; transition: color 0.3s; }
        .nav a:hover { color: #ddd; }
        .nav a.active { border-bottom: 2px solid white; }

        /* Header */
        .header { background-color: #4a6741; padding: 2rem 0; text-align: center; color: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header h1 { font-size: 2.5rem; font-weight: normal; margin-bottom: 0.5rem; }
        .header p { font-size: 1.1rem; opacity: 0.9; }

        /* Container */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 2rem; }

        /* Mapa Section */
        .mapa-section { background: white; padding: 3rem 2rem; margin: 2rem 0; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); text-align: center; }
        .mapa-container { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 6px 20px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto; }
        .mapa-container iframe { width: 100%; height: 400px; border: 0; }
        .mapa-info { padding: 2rem; background: #f8f9fa; }
        .mapa-info h3 { color: #4a6741; font-size: 1.5rem; margin-bottom: 1rem; }

        /* Info Section */
        .contacto-info-section { background: white; padding: 3rem 2rem; margin: 2rem 0; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
        .contacto-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; margin-top: 2rem; }
        .info-card { background: linear-gradient(135deg, #4a6741, #5a7751); color: white; padding: 2rem; border-radius: 12px; text-align: center; }
        .info-card .icon { font-size: 2.5rem; margin-bottom: 1rem; display: block; }
        .info-card h3 { font-size: 1.3rem; margin-bottom: 0.5rem; }
        .info-card p { font-size: 1.1rem; }

        /* Horarios */
        .horarios-section { background: white; padding: 3rem 2rem; margin: 2rem 0; border-radius: 15px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); text-align: center; }
        .horarios-section h2 { color: #4a6741; font-size: 2rem; margin-bottom: 2rem; border-bottom: 3px solid #4a6741; display: inline-block; }
        .horarios-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-top: 2rem; }
        .horario-item { background: linear-gradient(45deg, #f8f9fa, #e9ecef); padding: 1.5rem; border-radius: 10px; border-left: 4px solid #4a6741; }
        .horario-dia { font-weight: bold; color: #4a6741; }

        /* WhatsApp */
        .whatsapp-section { background: linear-gradient(135deg, #25D366, #128C7E); padding: 3rem 2rem; margin: 2rem 0; border-radius: 15px; text-align: center; box-shadow: 0 8px 25px rgba(37, 211, 102, 0.3); }
        .whatsapp-section h2 { color: white; font-size: 2rem; margin-bottom: 1rem; }
        .whatsapp-btn { display: inline-flex; align-items: center; gap: 10px; background: white; color: #25D366; padding: 1rem 2rem; border-radius: 50px; text-decoration: none; font-weight: bold; font-size: 1.1rem; }
        .whatsapp-btn:hover { transform: translateY(-3px); }

        /* Footer */
        .footer { background-color: #4a6741; color: white; text-align: center; padding: 2rem; margin-top: 3rem; }
    </style>
</head>
<body>
    <!-- Navegación -->
    <nav class="nav">
        <a href="index.php">Inicio</a>
        <a href="menu.php">Menú</a>
        <a href="reservas.php">Reservas</a>
        <a href="contacto.php" class="active">Contacto</a>
    </nav>

    <!-- Header -->
    <header class="header">
        <div class="container">
            <h1>📍 Contacto - Momentos</h1>
            <p>Centro Comercial Chiriguano, Santa Cruz de la Sierra</p>
        </div>
    </header>

    <div class="container">
        <!-- Información de Contacto -->
        <div class="contacto-info-section">
            <h2 style="text-align: center; color: #4a6741;">Información de Contacto</h2>
            <div class="contacto-grid">
                <div class="info-card">
                    <span class="icon">📞</span>
                    <h3>Teléfono</h3>
                    <p>+591 70000000</p>
                </div>
                <div class="info-card">
                    <span class="icon">📧</span>
                    <h3>Email</h3>
                    <p>momentos@gmail.com</p>
                </div>
                <div class="info-card">
                    <span class="icon">📍</span>
                    <h3>Dirección</h3>
                    <p>Centro Comercial Chiriguano<br>Santa Cruz de la Sierra</p>
                </div>
            </div>
        </div>

        <!-- Mapa -->
        <div class="mapa-section">
            <h2 style="color: #4a6741;">📍 Nuestra Ubicación</h2>
            <div class="mapa-container">
                <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.127620064702!2d-63.181049285078056!3d-17.78296398785361!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93f1e7b4aabf7f77%3A0xf61f17b6f3b4f547!2sCentro%20Comercial%20Chiriguano!5e0!3m2!1ses-419!2sbo!4v1695154899885!5m2!1ses-419!2sbo" 
    width="100%" 
    height="400" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
</iframe>

                <div class="mapa-info">
                    <h3>Centro Comercial Chiriguano</h3>
                    <p>Fácil acceso en transporte público y estacionamiento disponible</p>
                </div>
            </div>
        </div>

        <!-- Horarios -->
        <div class="horarios-section">
            <h2>⏰ Horarios de Atención</h2>
            <div class="horarios-grid">
                <div class="horario-item"><span class="horario-dia">Lunes a Viernes</span> 7:00 AM - 11:00 PM</div>
                <div class="horario-item"><span class="horario-dia">Sábados</span> 8:00 AM - 12:00 AM</div>
                <div class="horario-item"><span class="horario-dia">Domingos</span> 9:00 AM - 10:00 PM</div>
                <div class="horario-item"><span class="horario-dia">Feriados</span> 10:00 AM - 6:00 PM</div>
            </div>
        </div>

        <!-- WhatsApp -->
        <div class="whatsapp-section">
            <h2>💬 Contáctanos por WhatsApp</h2>
            <p>¿Tienes alguna consulta? ¡Escríbenos directamente!</p>
            <a href="https://wa.me/59170000000?text=¡Hola! Me gustaría hacer una consulta sobre el restaurante Momentos." class="whatsapp-btn" target="_blank">
                📱 Chatear por WhatsApp
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2024 Restaurante Momentos. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
