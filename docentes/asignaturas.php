<?php
$nombre='asignaturas';
require 'template/header.php';


$id_usuario = $_SESSION['id_usuario']; 

$query = "SELECT a.id AS id_asignatura, a.nombre AS nombre_asignatura, a.descripcion AS descripcion_asignatura
          FROM Asignatura a
          JOIN Usuario u ON a.id_usuario = u.id
          WHERE u.id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param('i', $id_usuario);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="main-content">
    <h1>Asignaturas del Usuario: <?php echo htmlspecialchars($_SESSION['nombre']); ?></h1>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID Asignatura</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th> 
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0):
                $c=1; ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($c++); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_asignatura']); ?></td>
                        <td><?php echo htmlspecialchars($row['descripcion_asignatura']); ?></td>
                        <td>
                            <a href="/escuela/docentes/alumnos.php?id_asignatura=<?php echo htmlspecialchars($row['id_asignatura']); ?>" class="btn btn-info">Ver Inscritos</a> 
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No se encontraron asignaturas para este usuario.</td> 
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
require 'template/footer.php';
?>
