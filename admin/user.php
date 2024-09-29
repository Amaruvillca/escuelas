<?php 
$nombre = 'user';
require 'template/header.php'; 


$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); 

   
    $deleteQuery = "DELETE FROM Usuario WHERE id = ?";
    $stmt = $conexion->prepare($deleteQuery);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        
        header('Location: user.php');
        exit; 
    } else {
        echo "<div class='error-message'>Error al eliminar el usuario.</div>";
    }

    $stmt->close();
}


$query = "SELECT id, nombre, Numero_carnet, email, tipo_usuario FROM Usuario";
if (!empty($busqueda)) {
    $query .= " WHERE nombre LIKE '%$busqueda%' OR Numero_carnet LIKE '%$busqueda%' OR email LIKE '%$busqueda%'"; 
}
$query .= " ORDER BY id DESC";
$result = $conexion->query($query);
?>

<div class="main-content">
    <h1>Lista de Usuarios</h1>

    <div class="btn-container">
        <a href="user/crear.php" class="btn btn-success">Añadir usuario</a>
    </div>
    <!-- Formulario de búsqueda -->
    <div class="search-container">
        <form method="GET" action="user.php" class="search-form">
            <input type="text" name="busqueda" placeholder="Buscar usuario..." value="<?php echo htmlspecialchars($busqueda); ?>" class="search-input">
            <button type="submit" class="search-button">Buscar</button>
        </form>
    </div>
    <br>
    
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Número de Carnet</th>
                <th>Email</th>
                <th>Tipo de Usuario</th>
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
                        <td><?php echo $row['Numero_carnet']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo ucfirst($row['tipo_usuario']); ?></td>
                        <td >
                            <a href="user/editar.php?id=<?php echo $row['id']; ?>" class="btn btn-primary" style="height: 100%;">Editar</a>
                            
                            <form method="POST" action="user.php" style="display:inline;">
                                
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-danger" style="width: 75px;" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Borrar</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron usuarios.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
require 'template/footer.php'; 
?>
