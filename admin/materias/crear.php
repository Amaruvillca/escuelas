<?php 
$nombre = 'materias';
require __DIR__.'/../template/header.php'; 


$errores = [];
$exito = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre_materia = trim($_POST['nombre_materia']);
    $descripcion = trim($_POST['descripcion']);

   
    if (empty($nombre_materia) || strlen($nombre_materia) < 3) {
        $errores[] = "El nombre de la materia debe tener al menos 3 caracteres.";
    }

    
    if (empty($descripcion)) {
        $errores[] = "La descripción de la materia es obligatoria.";
    }

    
    if (empty($errores)) {
        
        $query = "INSERT INTO Materias (nombre, descripcion) VALUES (?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ss', $nombre_materia, $descripcion);

        if ($stmt->execute()) {
            $exito = "Materia creada exitosamente.";
            
            header('Location: /escuela/admin/materias.php');
            exit;
        } else {
            $errores[] = "Hubo un error al crear la materia. Por favor, intenta nuevamente.";
        }

        $stmt->close();
    }
}
?>

<div class="main-content">
    <br><br>
    <h1>Crear Materia</h1>

    
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

    <form method="POST" class="crear--materia">
        <div class="form-group">
            <label for="nombre_materia">Nombre de la Materia</label>
            <input type="text" id="nombre_materia" name="nombre_materia" placeholder="Nombre de la materia" value="<?php echo isset($nombre_materia) ? htmlspecialchars($nombre_materia) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" placeholder="Descripción de la materia" class="form-control"><?php echo isset($descripcion) ? htmlspecialchars($descripcion) : ''; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Crear Materia</button>
    </form>
</div>

<?php require '../template/footer.php'; ?>
