<?php 
$nombre = 'materias';
require 'template/header.php'; 

$exito="Materia registrada con éxito";
$exito2="Materia eliminada con éxito";


$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); 

    
    $deleteQuery = "DELETE FROM Materias WHERE id = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        
        header('Location: materias.php?eliminado=1');
        exit;
    } else {
        echo "<div class='error-message'>Error al eliminar la materia.</div>";
    }

    $stmt->close();
}


$query = "SELECT id, nombre, descripcion FROM Materias";
if (!empty($busqueda)) {
    $query .= " WHERE nombre LIKE '%$busqueda%'";
}
$query .= " ORDER BY id DESC";
$result = $conexion->query($query);
?>

<div class="main-content">
    <h1>Lista de Materias</h1>
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
        <a href="materias/crear.php" class="btn btn-success">Nueva materia</a>
    </div>
    
    <div class="search-container">
        <form method="GET" action="materias.php" class="search-form">
            <input type="text" name="busqueda" placeholder="Buscar materia..." value="<?php echo htmlspecialchars($busqueda); ?>" class="search-input">
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
                        <td>
                            <a href="materias/editar.php?id=<?php echo $row['id']; ?>" class="btn btn-primary" style="height: 100%;">Editar</a>
                            
                            <form method="POST" action="materias.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger" style="width: 75px;" onclick="return confirm('¿Estás seguro de eliminar esta materia?');">Borrar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No se encontraron materias.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
require 'template/footer.php'; 
?>
