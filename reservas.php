 <?php include "conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservas - Restaurante</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body{font-family: 'Georgia', serif; background-color:#f5f2eb; margin:0; padding:0;}
        .container{max-width:900px; margin:2rem auto; padding:1rem;}
        .form-card{background:#fff8f0; padding:2rem; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);}
        .form-card h2{text-align:center; color:#4a6741; margin-bottom:1rem;}
        .form-row{display:flex; gap:1rem; flex-wrap:wrap;}
        .form-group{flex:1; display:flex; flex-direction:column; margin-bottom:1rem;}
        input, select, button{padding:0.8rem; border-radius:8px; border:1px solid #ccc; font-size:1rem;}
        input.valid{border-color:#4CAF50; background-color:#eaf7ea;}
        input.invalid{border-color:#f44336; background-color:#fbeaea;}
        button.btn-primary{background-color:#4a6741; color:white; border:none; cursor:pointer; transition:0.3s;}
        button.btn-primary:hover{background-color:#3e5534;}
        button.btn-secondary{background-color:#c8d4c3; color:#333; border:none; cursor:pointer; transition:0.3s;}
        button.btn-secondary:hover{background-color:#b1bfae;}
        .alert{padding:1rem; border-radius:8px; margin-bottom:1rem;}
        .alert-success{background-color:#eaf7ea; color:#2e7d32; border:1px solid #4CAF50;}
        .alert-error{background-color:#fbeaea; color:#c62828; border:1px solid #f44336;}
        .reservation-info{margin-top:2rem;}
        .status-badge{padding:0.3rem 0.6rem; border-radius:6px; color:white; font-weight:bold;}
        .status-pending{background:#fbc02d;}
        .status-confirmed{background:#4caf50;}
        .status-cancelled{background:#f44336;}
        .modal{display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); justify-content:center; align-items:center;}
        .modal-content{background:white; padding:2rem; border-radius:12px; max-width:400px; width:90%;}
        .close{position:absolute; right:1rem; top:1rem; cursor:pointer; font-size:1.5rem;}
        @media(max-width:768px){.form-row{flex-direction:column;}}
    </style>
</head>
<body>
    <!-- NAV -->
    <nav class="elegant-nav">
        <div class="nav-container" style="display:flex; justify-content:space-between; align-items:center; padding:1rem;">
            <a href="index.php" class="logo" style="color:#4a6741; font-size:1.5rem; text-decoration:none;"><i class="fas fa-utensils"></i> Restaurante</a>
            <ul class="nav-links" style="display:flex; gap:1rem; list-style:none;">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="menu.php">Menú</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <?php
        date_default_timezone_set('America/La_Paz');
        $hoy = date('Y-m-d');

        // Cancelar reserva
        if(isset($_POST['cancelar_reserva'])){
            $id_reserva = $_POST['id_reserva'];
            try{
                $sql = $pdo->prepare("UPDATE reservas SET estado='cancelada' WHERE id=?");
                $sql->execute([$id_reserva]);
                echo '<div class="alert alert-success">Reserva cancelada exitosamente.</div>';
            }catch(Exception $e){
                echo '<div class="alert alert-error">Error al cancelar la reserva.</div>';
            }
        }

        // Nueva reserva
        if(isset($_POST['reservar'])){
            $nombre = trim($_POST['nombre']);
            $apellido = trim($_POST['apellido']);
            $correo = trim($_POST['correo']);
            $telefono = trim($_POST['telefono']);
            $mesa = $_POST['mesa'];
            $cantidad_personas = $_POST['cantidad_personas'];
            $fecha = $_POST['fecha'];
            $hora = $_POST['hora'];

            if($fecha < $hoy){
                echo '<div class="alert alert-error">La fecha de reserva debe ser posterior a hoy.</div>';
            } else {
                // Verificar si la misma mesa ya está reservada a esa hora
                $stmt = $pdo->prepare("SELECT * FROM reservas WHERE mesa=? AND fecha=? AND hora=? AND estado!='cancelada'");
                $stmt->execute([$mesa,$fecha,$hora]);
                if($stmt->rowCount()>0){
                    echo '<div class="alert alert-error">La mesa '.$mesa.' ya está reservada a esa hora.</div>';
                } else {
                    // Insertar reserva
                    $sql = $pdo->prepare("INSERT INTO reservas 
                    (nombre, apellido, correo, telefono, mesa, cantidad_personas, fecha, hora, estado, creado_en)
                    VALUES (?,?,?,?,?,?,?,?, 'pendiente', NOW())");
                    $sql->execute([$nombre,$apellido,$correo,$telefono,$mesa,$cantidad_personas,$fecha,$hora]);
                    echo '<div class="alert alert-success">¡Reserva registrada exitosamente! Estado: PENDIENTE</div>';
                }
            }
        }

        // Consultar reservas
        if(isset($_POST['consultar_reserva'])){
            $email = $_POST['consulta_email'];
            $telefono = $_POST['consulta_telefono'];
            $stmt = $pdo->prepare("SELECT * FROM reservas WHERE correo=? AND telefono=? ORDER BY fecha DESC,hora DESC");
            $stmt->execute([$email,$telefono]);
            $reservas = $stmt->fetchAll();
            if($reservas){
                echo '<div class="reservation-info">';
                foreach($reservas as $res){
                    $estado_class='status-pending';
                    if($res['estado']=='confirmada'||$res['estado']=='aceptada') $estado_class='status-confirmed';
                    if($res['estado']=='cancelada'||$res['estado']=='rechazada') $estado_class='status-cancelled';
                    echo '<div style="border:1px solid #ddd; padding:1rem; margin-bottom:1rem; border-radius:10px; background:#fff;">';
                    echo '<p><b>Nombre:</b> '.$res['nombre'].' '.$res['apellido'].'</p>';
                    echo '<p><b>Mesa:</b> '.$res['mesa'].' | <b>Personas:</b> '.$res['cantidad_personas'].'</p>';
                    echo '<p><b>Fecha:</b> '.$res['fecha'].' | <b>Hora:</b> '.$res['hora'].'</p>';
                    echo '<p><b>Estado:</b> <span class="status-badge '.$estado_class.'">'.$res['estado'].'</span></p>';
                    echo '</div>';
                }
                echo '</div>';
            } else {
                echo '<div class="alert alert-error">No se encontraron reservas.</div>';
            }
        }
        ?>

        <!-- FORMULARIO -->
        <div class="form-card">
            <h2><i class="fas fa-utensils"></i> Nueva Reserva</h2>
            <form id="reservaForm" method="POST" novalidate>
                <div class="form-row">
                    <div class="form-group">
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre *" required>
                    </div>
                    <div class="form-group">
                        <input type="text" name="apellido" id="apellido" placeholder="Apellido *" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <input type="email" name="correo" placeholder="Email *" required>
                    </div>
                    <div class="form-group">
                        <input type="tel" name="telefono" id="telefono" placeholder="Teléfono *" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <select name="mesa" required>
                            <option value="">Mesa *</option>
                            <option value="1">Mesa 1 (2-4 personas)</option>
                            <option value="2">Mesa 2 (2-4 personas)</option>
                            <option value="3">Mesa 3 (4-6 personas)</option>
                            <option value="4">Mesa 4 (4-6 personas)</option>
                            <option value="5">Mesa 5 (6-8 personas)</option>
                            <option value="6">Mesa 6 (6-8 personas)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="cantidad_personas" required>
                            <option value="">Personas *</option>
                            <?php for ($i=1;$i<=8;$i++) echo "<option value='$i'>$i personas</option>"; ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group"><input type="date" name="fecha" required min="<?php echo $hoy;?>"></div>
                    <div class="form-group">
                        <select name="hora" required>
                            <option value="">Hora *</option>
                            <option value="12:00">12:00 PM</option>
                            <option value="13:00">1:00 PM</option>
                            <option value="14:00">2:00 PM</option>
                            <option value="18:00">6:00 PM</option>
                            <option value="19:00">7:00 PM</option>
                            <option value="20:00">8:00 PM</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="reservar" class="btn-primary">Reservar Mesa</button>
            </form>
            <button onclick="openConsultaModal()" class="btn-secondary">Consultar mi Reserva</button>
        </div>
    </div>

    <!-- MODAL CONSULTA -->
    <div id="consultaModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeConsultaModal()">&times;</span>
            <h2>Consultar Reserva</h2>
            <form method="POST">
                <div class="form-group"><input type="email" name="consulta_email" placeholder="Email *" required></div>
                <div class="form-group"><input type="tel" name="consulta_telefono" placeholder="Teléfono *" required></div>
                <button type="submit" name="consultar_reserva" class="btn-secondary">Buscar</button>
            </form>
        </div>
    </div>

    <script>
        function openConsultaModal(){document.getElementById('consultaModal').style.display='flex';}
        function closeConsultaModal(){document.getElementById('consultaModal').style.display='none';}
        window.onclick=function(e){if(e.target==document.getElementById('consultaModal'))closeConsultaModal();}

        // VALIDACION EN TIEMPO REAL
        const nombreInput=document.getElementById('nombre');
        const apellidoInput=document.getElementById('apellido');
        const telefonoInput=document.getElementById('telefono');

        nombreInput.addEventListener('input', ()=>{nombreInput.value = nombreInput.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ ]/g,''); 
            if(nombreInput.value.trim()!='') {nombreInput.classList.add('valid'); nombreInput.classList.remove('invalid');} else {nombreInput.classList.add('invalid'); nombreInput.classList.remove('valid');}
        });
        apellidoInput.addEventListener('input', ()=>{apellidoInput.value = apellidoInput.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ ]/g,''); 
            if(apellidoInput.value.trim()!='') {apellidoInput.classList.add('valid'); apellidoInput.classList.remove('invalid');} else {apellidoInput.classList.add('invalid'); apellidoInput.classList.remove('valid');}
        });
        telefonoInput.addEventListener('input', ()=>{
            telefonoInput.value=telefonoInput.value.replace(/[^0-9]/g,'');
            if(/^([6|7][0-9]{7})$/.test(telefonoInput.value)){telefonoInput.classList.add('valid'); telefonoInput.classList.remove('invalid');}else{telefonoInput.classList.add('invalid'); telefonoInput.classList.remove('valid');}
        });

        // VALIDACION AL ENVIAR FORM
        const form=document.getElementById('reservaForm');
        form.addEventListener('submit', e=>{
            if(nombreInput.classList.contains('invalid')||apellidoInput.classList.contains('invalid')||telefonoInput.classList.contains('invalid')){e.preventDefault(); alert('Por favor corrige los campos resaltados en rojo.');}
        });
    </script>
</body>
</html>
