# 🍽️ Restaurante Momentos

Sistema web completo para la gestión de un restaurante, incluyendo menú dinámico, reservas en línea y panel administrativo.

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)

## 📋 Descripción

**Restaurante Momentos** es una página web dinámica diseñada para facilitar la gestión de un restaurante moderno. Permite a los clientes explorar el menú, realizar reservas en línea y contactar al establecimiento, mientras que los administradores pueden gestionar el contenido dinámicamente desde un panel de control seguro.

---

## ✨ Características Principales

### 👥 Módulo de Clientes
- 🏠 **Página de Inicio**: Presentación elegante del restaurante con secciones de desayunos, almuerzos y bebidas
- 📖 **Menú Dinámico**: Visualización de platos principales, aperitivos y postres con imágenes y precios
- 📅 **Sistema de Reservas**: Reserva de mesas con validación en tiempo real
- 📍 **Página de Contacto**: Información completa con mapa interactivo, horarios y WhatsApp
- ✅ **Validación de Formularios**: Validación en tiempo real de campos (nombres solo letras, teléfonos formato boliviano)

### 🔐 Módulo Administrativo
- 🔑 **Login Seguro**: Sistema de autenticación con contraseñas hasheadas
- 📊 **Dashboard**: Panel central de administración
- 🍽️ **Gestión de Menú**: CRUD completo para platos con carga de imágenes
- 📋 **Gestión de Reservas**: Aceptar/rechazar reservas y ver historial
- 🖼️ **Manejo de Imágenes**: Sistema de carga y almacenamiento de imágenes optimizado

---

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL con PDO
- **Frontend**: HTML5, CSS3, JavaScript vanilla
- **Estilos**: CSS personalizado con diseño responsive
- **Iconos**: Font Awesome 6.0
- **Seguridad**: Password hashing con `password_hash()` y `password_verify()`

---

## 📁 Estructura del Proyecto

```
restaurante-momentos/
│
├── admin/                      # Módulo administrativo
│   ├── dashboard.php          # Panel principal
│   ├── menu.php               # Gestión de menú
│   ├── reservas.php           # Gestión de reservas
│   └── salir.php              # Cerrar sesión
│
├── images/                    # Recursos gráficos
│   └── platos/               # Imágenes de platos (generadas automáticamente)
│
├── conexion.php              # Configuración de base de datos
├── create_admin.php          # Crear usuario administrador
├── login.php                 # Autenticación
├── index.php                 # Página principal
├── menu.php                  # Menú público
├── reservas.php              # Sistema de reservas
├── contacto.php              # Información de contacto
├── style.css                 # Estilos globales
└── README.md                 # Este archivo
```

---

## 🚀 Instalación

### Requisitos Previos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Servidor web (Apache/Nginx)
- XAMPP, WAMP o similar (para desarrollo local)

### Pasos de Instalación

1. **Clonar el repositorio**
```bash
git clone https://github.com/saavedraabigailsaavedra-png/restaurante-momentos.git
cd restaurante-momentos
```

2. **Configurar la base de datos**
```sql
CREATE DATABASE proyecto CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE proyecto;

-- Tabla de administradores
CREATE TABLE administrador (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    contrasena VARCHAR(255) NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de menú
CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    imagen VARCHAR(255),
    fecha DATE NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de reservas
CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    correo VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    mesa INT NOT NULL,
    cantidad_personas INT NOT NULL,
    fecha DATE NOT NULL,
    hora TIME NOT NULL,
    estado ENUM('pendiente','aceptada','rechazada','cancelada') DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. **Configurar conexión a la base de datos**

Editar `conexion.php`:
```php
$host = "localhost";
$dbname = "proyecto";
$username = "root";      // Tu usuario de MySQL
$password = "";          // Tu contraseña de MySQL
```

4. **Crear primer administrador**

Acceder a: `http://localhost/restaurante-momentos/create_admin.php`

O insertar manualmente:
```bash
# Visitar para generar hash:
http://localhost/restaurante-momentos/login.php?nueva=tucontraseña

# Copiar el hash generado e insertar:
INSERT INTO administrador (usuario, contrasena, nombre) 
VALUES ('admin', 'HASH_GENERADO_AQUI', 'Administrador');
```

5. **Crear carpeta de imágenes**
```bash
mkdir -p images/platos
chmod 777 images/platos
```

6. **Acceder al sistema**
- Sitio público: `http://localhost/restaurante-momentos/`
- Panel admin: `http://localhost/restaurante-momentos/login.php`

---

## 📱 Funcionalidades Detalladas

### Sistema de Reservas
- ✅ Selección de mesa (1-6)
- ✅ Elección de cantidad de personas (1-8)
- ✅ Fecha y hora específicas
- ✅ Validación de disponibilidad en tiempo real
- ✅ Consulta de estado de reserva
- ✅ Estados: Pendiente, Aceptada, Rechazada, Cancelada

### Gestión de Menú
- ✅ Agregar/editar/eliminar platos
- ✅ Carga de imágenes (JPG, PNG, WEBP)
- ✅ Límite de tamaño: 5MB
- ✅ Nombres únicos para evitar conflictos
- ✅ Eliminación automática de imágenes antiguas

### Validaciones
- ✅ Nombres y apellidos: Solo letras y espacios
- ✅ Teléfonos: Formato boliviano (6/7 + 7 dígitos)
- ✅ Email: Validación estándar
- ✅ Fechas: No permitir reservas en el pasado

---

## 🔒 Seguridad

- ✅ Contraseñas hasheadas con `PASSWORD_DEFAULT`
- ✅ Prepared statements para prevenir SQL injection
- ✅ Validación de tipos de archivo en uploads
- ✅ Sesiones PHP para autenticación
- ✅ Sanitización de salidas con `htmlspecialchars()`

---

## 🎨 Diseño Responsive

- ✅ Mobile First
- ✅ Breakpoints optimizados
- ✅ Menú hamburguesa en móviles
- ✅ Tablas adaptativas
- ✅ Imágenes responsivas

---

## 🤝 Contribuir

Las contribuciones son bienvenidas. Por favor:

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/NuevaCaracteristica`)
3. Commit tus cambios (`git commit -m 'Agregar nueva característica'`)
4. Push a la rama (`git push origin feature/NuevaCaracteristica`)
5. Abre un Pull Request

---

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

---

## 👨‍💻 Autor

**Abigail Saavedra**
- GitHub: [@saavedraabigailsaavedra-png](https://github.com/saavedraabigailsaavedra-png)
- Email: saavedraabigailsaavedra@gmail.com

---

## 📞 Soporte

Si tienes alguna pregunta o problema, por favor abre un [issue](https://github.com/saavedraabigailsaavedra-png/restaurante-momentos/issues) en GitHub.

---

## 🙏 Agradecimientos

- Font Awesome por los iconos
- Google Maps por la integración de mapas
- La comunidad de desarrolladores PHP

## 📝 Notas Adicionales

### Credenciales de Prueba
- **Usuario**: admin
- **Contraseña**: (la que configures durante la instalación)

### Ubicación del Restaurante
- **Dirección**: Centro Comercial Chiriguano
- **Ciudad**: Santa Cruz de la Sierra, Bolivia
- **Teléfono**: +591 75601336
- **Email**: momentos@gmail.com


## 🚀 Próximas Mejoras

- [ ] Sistema de pagos en línea
- [ ] Notificaciones por email
- [ ] Integración con WhatsApp Business API
- [ ] Historial de pedidos
- [ ] Sistema de valoraciones y reseñas
- [ ] Multi-idioma (Español/Inglés)
- [ ] PWA (Progressive Web App)
- [ ] Dashboard con estadísticas y gráficos


⭐️ **Si este proyecto te fue útil, considera darle una estrella en GitHub!**
 