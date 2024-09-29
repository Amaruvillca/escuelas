<?php
$nombre = 'Notas del Estudiante';
require 'template/header.php';


$id_alumno = isset($_GET['id_alumno']) ? intval($_GET['id_alumno']) : 0;
$id_asignatura = isset($_GET['id_asignatura']) ? intval($_GET['id_asignatura']) : 0;


$query = "SELECT n.nota, n.fecha_asignacion
          FROM Nota n
          JOIN Inscripcion i ON n.id_inscripcion = i.id
          WHERE i.id_alumno = ? AND i.id_asignatura = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('ii', $id_alumno, $id_asignatura);
$stmt->execute();
$result = $stmt->get_result();


$numero_notas = $result->num_rows;

?>

<div class="main-content">
    <h1>Notas del Estudiante</h1>

    
    <?php if ($numero_notas < 4): ?>
        <a href="add_nota.php?id_alumno=<?php echo $id_alumno; ?>&id_asignatura=<?php echo $id_asignatura; ?>" class="btn btn-primary">Añadir Nota</a>
    <?php else: ?>
        <p>No se pueden añadir más notas. El límite es de 4 notas por asignatura.</p>
    <?php endif; ?>
<br><br>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nota</th>
                <th>Fecha de Asignación</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($numero_notas > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nota']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_asignacion']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No hay notas disponibles para este estudiante en esta asignatura.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require 'template/footer.php';
?>
