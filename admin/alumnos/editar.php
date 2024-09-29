<?php 
$nombre = 'alumnos';
require __DIR__.'/../template/header.php'; 


$errores = [];
$exito = "";


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

    
    $query = "SELECT nombre, apellido_pa, apellido_ma, Numero_carnet, fecha_nacimiento, direccion, telefono FROM Alumno WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $alumno = $result->fetch_assoc();
        $nombre = $alumno['nombre'];
        $apellido_pa = $alumno['apellido_pa'];
        $apellido_ma = $alumno['apellido_ma'];
        $carnet = $alumno['Numero_carnet'];
        $fecha_nacimiento = $alumno['fecha_nacimiento'];
        $direccion = $alumno['direccion'];
        $telefono = $alumno['telefono'];
    } else {
        $errores[] = "El alumno no fue encontrado.";
    }
    $stmt->close();
} else {
    $errores[] = "ID de alumno no proporcionado.";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido_pa = trim($_POST['apellido_pa']);
    $apellido_ma = trim($_POST['apellido_ma']);
    $carnet = trim($_POST['Numero_carnet']);
    $fecha_nacimiento = trim($_POST['fecha_nacimiento']);
    $direccion = trim($_POST['direccion']);
    $telefono = trim($_POST['telefono']);

    // Validación
    if (empty($nombre) || strlen($nombre) < 3) {
        $errores[] = "El nombre debe tener al menos 3 caracteres.";
    }

    
    if (empty($apellido_pa) || strlen($apellido_pa) < 3) {
        $errores[] = "El apellido paterno debe tener al menos 3 caracteres.";
    }

    
    if (empty($apellido_ma) || strlen($apellido_ma) < 3) {
        $errores[] = "El apellido materno debe tener al menos 3 caracteres.";
    }

 
    if (empty($carnet) || !preg_match('/^\d{7,10}$/', $carnet)) {
        $errores[] = "El número de carnet debe tener 7 dígitos numéricos.";
    }

    
    if (empty($fecha_nacimiento)) {
        $errores[] = "La fecha de nacimiento es obligatoria.";
    } elseif (!DateTime::createFromFormat('Y-m-d', $fecha_nacimiento)) {
        $errores[] = "El formato de la fecha de nacimiento no es válido (YYYY-MM-DD).";
    }

    
    if (empty($direccion)) {
        $errores[] = "La dirección es obligatoria.";
    }

    
    if (empty($telefono) || !preg_match('/^\d{7,10}$/', $telefono)) {
        $errores[] = "El número de teléfono debe tener entre 7 y 10 dígitos.";
    }

    
    if (empty($errores)) {
        
        $query = "UPDATE Alumno SET nombre = ?, apellido_pa = ?, apellido_ma = ?, Numero_carnet = ?, fecha_nacimiento = ?, direccion = ?, telefono = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssssssi', $nombre, $apellido_pa, $apellido_ma, $carnet, $fecha_nacimiento, $direccion, $telefono, $id);

        if ($stmt->execute()) {
            $exito = "Alumno actualizado exitosamente.";
            header('Location: /escuela/admin/alumnos.php');
            exit; 
        } else {
            $errores[] = "Hubo un error al actualizar el alumno. Por favor, intenta nuevamente.";
        }

        $stmt->close();
    }
}
?>

<div class="main-content">
    <br><br>
    <h1>Editar Alumno</h1>

    
    <?php if (!empty($errores)): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <?php if (!empty($exito)): ?>
        <div class="success-message">
            <p><?php echo $exito; ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" class="crear--alumno">
        <div class="form-group">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" value="<?php echo isset($nombre) ? htmlspecialchars($nombre) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="apellido_pa">Apellido Paterno</label>
            <input type="text" id="apellido_pa" name="apellido_pa" placeholder="Apellido paterno" value="<?php echo isset($apellido_pa) ? htmlspecialchars($apellido_pa) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="apellido_ma">Apellido Materno</label>
            <input type="text" id="apellido_ma" name="apellido_ma" placeholder="Apellido materno" value="<?php echo isset($apellido_ma) ? htmlspecialchars($apellido_ma) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="Numero_carnet">Número de Carnet</label>
            <input type="text" id="Numero_carnet" name="Numero_carnet" placeholder="Número de carnet" value="<?php echo isset($carnet) ? htmlspecialchars($carnet) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo isset($fecha_nacimiento) ? htmlspecialchars($fecha_nacimiento) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="direccion">Dirección</label>
            <input type="text" id="direccion" name="direccion" placeholder="Dirección" value="<?php echo isset($direccion) ? htmlspecialchars($direccion) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input type="text" id="telefono" name="telefono" placeholder="Teléfono" value="<?php echo isset($telefono) ? htmlspecialchars($telefono) : ''; ?>" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Alumno</button>
    </form>
</div>

<?php require '../template/footer.php'; ?>
