<?php
$nombre = 'alumnos';
require __DIR__ . '/../template/header.php';


$id_alumno = isset($_GET['id_alumno']) ? intval($_GET['id_alumno']) : 0;
$id_grado = isset($_GET['id_grado']) ? intval($_GET['id_grado']) : 0;


$query = "SELECT a.id AS id_asignatura, a.nombre AS asignatura, u.nombre AS docente 
          FROM Asignatura a 
          JOIN Usuario u ON a.id_usuario = u.id";
$stmt = $conexion->prepare($query);
$stmt->execute();
$result = $stmt->get_result();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_asignatura = isset($_POST['id_asignatura']) ? intval($_POST['id_asignatura']) : 0;

    
    $query = "INSERT INTO Inscripcion (id_alumno, id_asignatura, id_grado, fecha_inscripcion) 
              VALUES (?, ?, ?, NOW())";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('iii', $id_alumno, $id_asignatura, $id_grado);
    
    if ($stmt->execute()) {
        header("Location: /escuela/admin/incribirmateria/mostrar.php?id_alumno=$id_alumno&id_grado=$id_grado&inscrito=1");
        exit();
    } else {
        $error_message = "Error al inscribir la materia: " . htmlspecialchars($stmt->error);
    }
}
?>

<div class="main-content">
    <h1>Inscribir Materia</h1>

    <?php if (isset($error_message)): ?>
        <div class="error-message">
            <p><?php echo htmlspecialchars($error_message); ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" class="crear--curso" action="inscribir_materia.php?id_alumno=<?php echo $id_alumno; ?>&id_grado=<?php echo $id_grado; ?>">
        <div class="form-group">
            <label for="id_asignatura">Asignatura:</label>
            <select name="id_asignatura" id="id_asignatura" class="form-control" required>
                <option value="">Seleccione una asignatura</option>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <option value="<?php echo $row['id_asignatura']; ?>">
                        <?php echo htmlspecialchars($row['asignatura']) . ' - ' . htmlspecialchars($row['docente']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Inscribir</button>
        <br><br><br>
    <div class="btn-container">
        <a href="/escuela/admin/incribirmateria/mostrar.php?id_alumno=<?php echo $id_alumno; ?>&id_grado=<?php echo $id_grado; ?>" class="btn btn-primary">Volver a Materias Inscritas</a>
    </div>
    </form>

</div>

<?php 
require '../template/footer.php'; 
?>
