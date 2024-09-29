<?php 
$nombre = 'alumnos';
require __DIR__.'/../template/header.php'; 

$exito = "Grado registrado con éxito";
$exito2 = "Grado eliminado con éxito";


$id_alumno = isset($_GET['id']) ? intval($_GET['id']) : 0;




if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); 

    
    $deleteQuery = "DELETE FROM grado WHERE id = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header('Location: grados.php?eliminado=1&id_alumno=' . $id_alumno);
        exit;
    } else {
        echo "<div class='error-message'>Error al eliminar el grado.</div>";
    }

    $stmt->close();
}


$query = "SELECT id, curso, grado, paralelo FROM grado WHERE id_alumno = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id_alumno);
$stmt->execute();
$result = $stmt->get_result();

?>

<div class="main-content">
    <h1>Cursos Inscritos del Estudiante</h1>
    <center>
    <?php if (isset($_GET['MENSAJE'])): ?>
        <div class="success-message">
            <p><?php echo $exito; ?></p>
        </div>
    <?php endif; ?>
    <?php if (isset($_GET['eliminado'])): ?>
        <div class="success-message">
            <p><?php echo $exito2; ?></p>
        </div>
    <?php endif; ?>
    </center>

    <div class="btn-container">
        <a href="../grados/crear.php?id=<?php echo $id_alumno; ?>" class="btn btn-success">Inscribir curso</a>
    </div>
    
    <br>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Curso</th>
                <th>Grado</th>
                <th>Paralelo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): 
                $c = 1; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $c++; ?></td>
                        <td><?php echo $row['curso']; ?></td>
                        <td><?php echo $row['grado']; ?></td>
                        <td><?php echo $row['paralelo']; ?></td>
                        <td>
                            <a href="../incribirmateria/mostrar.php?id_alumno=<?php echo $_GET['id']; ?>&id_grado=<?php echo $row['id']; ?>" class="btn btn-primary">Ver Materias</a>
                            
                           
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No se encontraron grados para este estudiante.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
require '../template/footer.php'; 
?>

