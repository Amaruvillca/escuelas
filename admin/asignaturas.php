<?php 
$nombre = 'clases';
require 'template/header.php'; 

$exito = "Asignatura registrada con éxito";
$exito2 = "Asignatura eliminada con éxito";


$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);

   
    $deleteQuery = "DELETE FROM Asignatura WHERE id = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        
        header('Location: asignaturas.php?eliminado=1');
        exit; 
    } else {
        echo "<div class='error-message'>Error al eliminar la asignatura.</div>";
    }

    $stmt->close();
}


$query = "SELECT a.id, a.nombre, a.descripcion, u.nombre AS usuario_nombre, m.nombre AS materia_nombre 
          FROM Asignatura a 
          LEFT JOIN Usuario u ON a.id_usuario = u.id 
          LEFT JOIN Materias m ON a.id_materia = m.id";

if (!empty($busqueda)) {
    $query .= " WHERE a.nombre LIKE '%$busqueda%'"; 
}
$query .= " ORDER BY a.id DESC";
$result = $conexion->query($query);
?>

<div class="main-content">
    <h1>Lista de Asignaturas</h1>
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
        <a href="asignaturas/crear.php" class="btn btn-success">Nueva Asignatura</a>
    </div>
   
    <div class="search-container">
        <form method="GET" action="asignaturas.php" class="search-form">
            <input type="text" name="busqueda" placeholder="Buscar asignatura..." value="<?php echo htmlspecialchars($busqueda); ?>" class="search-input">
            <button type="submit" class="search-button">Buscar</button>
        </form>
    </div>
    <br>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Docente</th>
                <th>Materia</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): 
                $c = 1; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $c++; ?></td>
                        <td><?php echo $row['nombre']; ?></td>
                        <td><?php echo $row['descripcion']; ?></td>
                        <td><?php echo $row['usuario_nombre']; ?></td>
                        <td><?php echo $row['materia_nombre']; ?></td>
                        <td>
                            <a href="asignaturas/editar.php?id=<?php echo $row['id']; ?>" class="btn btn-primary" style="height: 100%;">Editar</a>
                            
                            <form method="POST" action="asignaturas.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger" style="width: 75px;" onclick="return confirm('¿Estás seguro de eliminar esta asignatura?');">Borrar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron asignaturas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
require 'template/footer.php'; 
?>
