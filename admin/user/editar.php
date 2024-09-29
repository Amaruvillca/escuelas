<?php 
$nombre = 'user';
require __DIR__.'/../template/header.php'; 


$errores = [];
$exito = "";


if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 

   
    $query = "SELECT nombre, Numero_carnet, email, tipo_usuario FROM Usuario WHERE id = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        $nombre = $usuario['nombre'];
        $carnet = $usuario['Numero_carnet'];
        $email = $usuario['email'];
        $tipo_usuario = $usuario['tipo_usuario'];
    } else {
        $errores[] = "El usuario no fue encontrado.";
    }
    $stmt->close();
} else {
    $errores[] = "ID de usuario no proporcionado.";
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $carnet = trim($_POST['Numero_carnet']);
    $email = trim($_POST['email']);
    $tipo_usuario = $_POST['tipo_usuario'];

    
    if (empty($nombre) || strlen($nombre) < 3) {
        $errores[] = "El nombre debe tener al menos 3 caracteres.";
    }

    
    if (empty($carnet) || !preg_match('/^\d{7,10}$/', $carnet)) {
        $errores[]= "El número de carnet debe tener 8 dígitos numéricos.";
    }

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido.";
    }

    
    if (empty($errores)) {
        
        $query = "UPDATE Usuario SET nombre = ?, Numero_carnet = ?, email = ?, tipo_usuario = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('ssssi', $nombre, $carnet, $email, $tipo_usuario, $id);

        if ($stmt->execute()) {
            $exito = "Usuario actualizado exitosamente.";
            header('Location: /escuela/admin/user.php');
            exit; 
        } else {
            $errores[] = "Hubo un error al actualizar el usuario. Por favor, intenta nuevamente.";
        }

        $stmt->close();
    }
}
?>

<div class="main-content">
    <br><br>
    <h1>Editar Usuario</h1>

    
    <?php if (!empty($errores)): ?>
        <div class="error-messages">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


    <?php if (!empty($exito)): ?>
        <div class="success-message">
            <p><?php echo $exito; ?></p>
        </div>
    <?php endif; ?>

    <form method="POST" class="crear--user">
        <div class="form-group">
            <label for="nombre">Nombre Completo</label>
            <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" value="<?php echo isset($nombre) ? htmlspecialchars($nombre) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="Numero_carnet">Número de Carnet</label>
            <input type="text" id="Numero_carnet" name="Numero_carnet" placeholder="Número de carnet" value="<?php echo isset($carnet) ? htmlspecialchars($carnet) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" placeholder="Tu correo electrónico" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="tipo_usuario">Tipo de Usuario</label>
            <select id="tipo_usuario" name="tipo_usuario" class="form-control">
                <option value="administrador" <?php echo (isset($tipo_usuario) && $tipo_usuario === 'administrador') ? 'selected' : ''; ?>>Administrador</option>
                <option value="docente" <?php echo (isset($tipo_usuario) && $tipo_usuario === 'docente') ? 'selected' : ''; ?>>Docente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
    </form>
</div>

<?php require '../template/footer.php'; ?> 
