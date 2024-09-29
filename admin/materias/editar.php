<?php 
$nombre = 'materias';
require __DIR__.'/../template/header.php'; 


$errores = [];
$exito = "";


if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    
    $query = "SELECT nombre, descripcion FROM Materias WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $materia = $result->fetch_assoc();
        $nombre_materia = $materia['nombre'];
        $descripcion = $materia['descripcion'];
    } else {
        $errores[] = "La materia no fue encontrada.";
    }
    $stmt->close();
} else {
    $errores[] = "ID de materia no proporcionado.";
}


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
       
        $query = "UPDATE Materias SET nombre = ?, descripcion = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssi', $nombre_materia, $descripcion, $id);

        if ($stmt->execute()) {
            $exito = "Materia actualizada exitosamente.";
            header('Location: /escuela/admin/materias.php');
            exit; 
        } else {
            $errores[] = "Hubo un error al actualizar la materia. Por favor, intenta nuevamente.";
        }

        $stmt->close();
    }
}
?>

<div class="main-content">
    <br><br>
    <h1>Editar Materia</h1>

    
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

    <form method="POST" class="editar--materia">
        <div class="form-group">
            <label for="nombre_materia">Nombre de la Materia</label>
            <input type="text" id="nombre_materia" name="nombre_materia" placeholder="Nombre de la materia" value="<?php echo isset($nombre_materia) ? htmlspecialchars($nombre_materia) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea id="descripcion" name="descripcion" placeholder="Descripción de la materia" class="form-control"><?php echo isset($descripcion) ? htmlspecialchars($descripcion) : ''; ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Materia</button>
    </form>
</div>

<?php require '../template/footer.php'; ?>
