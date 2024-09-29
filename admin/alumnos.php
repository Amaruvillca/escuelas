<?php 
$nombre = 'alumnos';
require 'template/header.php'; 

$exito="alumno registrado con exito";
$exito2="anumno borrado con exito";


$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); 

  
    $deleteQuery = "DELETE FROM Alumno WHERE id = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        
        header('Location: alumnos.php?eliminado=1');
        exit;
    } else {
        echo "<div class='error-message'>Error al eliminar el alumno.</div>";
    }

    $stmt->close();
}


$query = "SELECT id, nombre, apellido_pa, apellido_ma, Numero_carnet, fecha_nacimiento, direccion, telefono FROM Alumno";
if (!empty($busqueda)) {
    $query .= " WHERE nombre LIKE '%$busqueda%' OR Numero_carnet LIKE '%$busqueda%'"; 
}
$query .= " ORDER BY id DESC";
$result = $conexion->query($query);
?>

<div class="main-content">
    <h1>Lista de Alumnos</h1>
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
        <a href="alumnos/crear.php" class="btn btn-success">nuevo alumno</a>
    </div>
   
    <div class="search-container">
        <form method="GET" action="alumnos.php" class="search-form">
            <input type="text" name="busqueda" placeholder="Buscar alumno..." value="<?php echo htmlspecialchars($busqueda); ?>" class="search-input">
            <button type="submit" class="search-button">Buscar</button>
        </form>
    </div>
    <br>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombres y apellidos</th>
                <th>Ci</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): 
                $c = 1; ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $c++; ?></td>
                        <td><?php echo $row['nombre'].' '.$row['apellido_pa'].' '.$row['apellido_ma']; ?></td>
                        <td><?php echo $row['Numero_carnet']; ?></td>
                       
                        <td><?php echo $row['telefono']; ?></td>
                        <td>
                            <a href="alumnos/editar.php?id=<?php echo $row['id']; ?>" class="btn btn-primary" style="height: 100%;">Editar</a>
                            
                            <form method="POST" action="alumnos.php" style="display:inline;">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger" style="width: 75px;" onclick="return confirm('¿Estás seguro de eliminar este alumno?');">Borrar</button>
                            </form>
                            <a href="alumnos/clasesinscritas.php?id=<?php echo $row['id']; ?>" class="btn btn-info" style="height: 100%;">Cursos</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9">No se encontraron alumnos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
require 'template/footer.php'; 
?>
