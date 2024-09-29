<?php
require '../template/header.php';


$id_inscripcion = isset($_GET['id_inscripcion']) ? intval($_GET['id_inscripcion']) : 0;


$query = "SELECT n.id, a.nombre AS materia, n.nota 
          FROM Nota n 
          JOIN Inscripcion i ON n.id_inscripcion = i.id
          JOIN Asignatura a ON i.id_asignatura = a.id
          WHERE n.id_inscripcion = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id_inscripcion);
$stmt->execute();
$result = $stmt->get_result();


$sum = 0;
$count = 0;

while ($row = $result->fetch_assoc()) {
    $sum += $row['nota'];
    $count++;
}


$promedio = $count > 0 ? $sum / 4 : 0;


$estado = $promedio >= 61 ? 'Aprobado' : 'Reprobado';

?>

<div class="main-content">
    <h1>Notas del Estudiante</h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>bimestre</th>
                
                <th>Materia</th>
                <th>Nota</th>
            </tr>
        </thead>
        <tbody>
            <?php
           
            $result->data_seek(0);
            if ($count > 0): 
                $c = 1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $c++; ?></td>
                        <td><?php echo htmlspecialchars($row['materia']); ?></td>
                        <td><?php echo htmlspecialchars($row['nota']); ?></td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No se encontraron notas para esta inscripción.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<br><br>
    <h2>Promedio de Notas: <?php echo number_format($promedio, 2); ?></h2> 
    <h2>Estado: <?php echo $estado; ?></h2> 
</div>

<?php
require '../template/footer.php';
?>
