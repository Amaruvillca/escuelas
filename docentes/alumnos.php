<?php
$nombre = 'asignaturas';
require 'template/header.php';


$id_asignatura = isset($_GET['id_asignatura']) ? intval($_GET['id_asignatura']) : 0;

$query = "SELECT a.id AS id_alumno, a.nombre AS nombre_alumno, a.Numero_carnet
          FROM Inscripcion i
          JOIN Alumno a ON i.id_alumno = a.id
          WHERE i.id_asignatura = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id_asignatura);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="main-content">
    <h1>Estudiantes Inscritos en la Asignatura</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nombre del Estudiante</th>
                <th>Número de Carnet</th>
                <th>Acción</th> 
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_alumno']); ?></td>
                        <td><?php echo htmlspecialchars($row['Numero_carnet']); ?></td>
                        <td>
                            <a href="notas.php?id_alumno=<?php echo htmlspecialchars($row['id_alumno']); ?>&id_asignatura=<?php echo htmlspecialchars($id_asignatura); ?>" class="btn btn-primary">Ver Notas</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No hay estudiantes inscritos en esta asignatura.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require 'template/footer.php';
?>
