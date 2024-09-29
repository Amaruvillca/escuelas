<?php
$nombre = 'clases';
require __DIR__ . '/../template/header.php';


$errores = [];
$exito = "";
$user = "SELECT * FROM usuario WHERE tipo_usuario = 'docente'";
$materia = "SELECT * FROM  materias";
$userq = mysqli_query($conexion, $user);
$materiaq = mysqli_query($conexion, $materia);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_asignatura = trim($_POST['nombre_asignatura']);
    $descripcion = trim($_POST['descripcion']);
    $id_usuario = intval($_POST['id_usuario']);
    $id_materia = intval($_POST['id_materia']);

   
    if (empty($nombre_asignatura) || strlen($nombre_asignatura) < 3) {
        $errores[] = "El nombre de la asignatura debe tener al menos 3 caracteres.";
    }

    
    if (empty($descripcion)) {
        $errores[] = "La descripción de la asignatura es obligatoria.";
    }

    
    if (empty($errores)) {
        // Insertar la nueva asignatura en la base de datos
        $query = "INSERT INTO Asignatura (nombre, descripcion, id_usuario, id_materia) VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssii', $nombre_asignatura, $descripcion, $id_usuario, $id_materia);

        if ($stmt->execute()) {
            $exito = "Asignatura creada exitosamente.";
            // Redirigir después de éxito
            header('Location: /escuela/admin/asignaturas.php');
            exit;
        } else {
            $errores[] = "Hubo un error al crear la asignatura. Por favor, intenta nuevamente.";
        }

        $stmt->close();
    }
}
?>

<div class="main-content">
    <br><br>
    <h1>Crear Asignatura</h1>

    
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

    <form method="POST" class="crear--asignatura">
        <div class="form-group">
            <label for="nombre_asignatura">Nombre de la Asignatura</label>
            <input type="text" id="nombre_asignatura" name="nombre_asignatura" placeholder="Nombre de la asignatura" value="<?php echo isset($nombre_asignatura) ? htmlspecialchars($nombre_asignatura) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" placeholder="Descripción de la asignatura" class="form-control"><?php echo isset($descripcion) ? htmlspecialchars($descripcion) : ''; ?></textarea>
        </div>

        <div class="form-group">
            <label for="id_usuario">Docente</label>
            <select id="id_usuario" name="id_usuario" class="form-control">
                <option value="">Seleccione un docente</option> <!-- Opción predeterminada -->
                <?php while ($usuario = mysqli_fetch_assoc($userq)): ?>
                    <option value="<?php echo htmlspecialchars($usuario['id']); ?>" <?php echo isset($id_usuario) && $id_usuario == $usuario['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($usuario['nombre']); ?> <!-- Asegúrate de que 'nombre' es la columna correcta -->
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="id_materia">Materia</label>
            <select id="id_materia" name="id_materia" class="form-control">
                <option value="">Seleccione una materia</option> <!-- Opción predeterminada -->
                <?php while ($materia = mysqli_fetch_assoc($materiaq)): ?>
                    <option value="<?php echo htmlspecialchars($materia['id']); ?>" <?php echo isset($id_materia) && $id_materia == $materia['id'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($materia['nombre']); ?> <!-- Asegúrate de que 'nombre' es la columna correcta -->
                    </option>
                <?php endwhile; ?>
            </select>
        </div>


        <button type="submit" class="btn btn-primary">Crear Asignatura</button>
    </form>
</div>

<?php require '../template/footer.php'; ?>