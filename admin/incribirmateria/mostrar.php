<?php
$nombre = 'alumnos';
require __DIR__ . '/../template/header.php';


$id_alumno = isset($_GET['id_alumno']) ? intval($_GET['id_alumno']) : 0;
$id_grado = isset($_GET['id_grado']) ? intval($_GET['id_grado']) : 0;


$query = "SELECT i.id, a.nombre AS asignatura, CONCAT(g.curso, ' ', g.grado, ' ', g.paralelo) AS grado, 
                 i.fecha_inscripcion, u.nombre AS docente
          FROM Inscripcion i 
          JOIN Asignatura a ON i.id_asignatura = a.id 
          JOIN Grado g ON i.id_grado = g.id
          JOIN Usuario u ON a.id_usuario = u.id
          WHERE i.id_alumno = ? AND i.id_grado = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('ii', $id_alumno, $id_grado);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="main-content">
    <h1>Materias Inscritas del Estudiante</h1>

    <center>
        <?php if (isset($_GET['eliminado'])): ?>
            <div class="success-message">
                <p>Materia eliminada con éxito.</p>
            </div>
        <?php endif; ?>
    </center>

    <div class="btn-container">
        <a href="/escuela/admin/materias/inscribir_materia.php?id_alumno=<?php echo $id_alumno; ?>&id_grado=<?php echo $id_grado; ?>" class="btn btn-success">Inscribir Materia</a>
    </div>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Asignatura</th>
                <th>Grado</th>
                <th>Fecha de Inscripción</th>
                <th>Docente</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0):
                $c = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $c++; ?></td>
                        <td><?php echo htmlspecialchars($row['asignatura']); ?></td>
                        <td><?php echo htmlspecialchars($row['grado']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_inscripcion']); ?></td>
                        <td><?php echo htmlspecialchars($row['docente']); ?></td>
                        <td>
                            <a href="notas.php?id_inscripcion=<?php echo $row['id']; ?>" class="btn btn-primary" style="height: 100%;"> Ver Notas</a>

                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron materias inscritas para este estudiante en el grado seleccionado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require '../template/footer.php';
?>