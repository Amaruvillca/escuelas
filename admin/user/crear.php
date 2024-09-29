<?php 
$nombre = 'user';
require __DIR__.'/../template/header.php'; 


$errores = [];
$exito = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $carnet = trim($_POST['Numero_carnet']);
    $email = trim($_POST['email']);
    $tipo_usuario = $_POST['tipo_usuario'];

    
    if (empty($nombre) || strlen($nombre) < 3) {
        $errores[] = "El nombre debe tener al menos 3 caracteres.";
    }

   
    if (empty($carnet) || !preg_match('/^\d{7,10}$/', $carnet)) {
        
        $errores[]= "El número de carnet debe tener  8 dígitos numéricos.";
    }
    

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido.";
    }if (!$nombre) {
        $errores[] = "el nombre es obligatoria";
    }

    
    if (empty($errores)) {
        
        $emailPart = strstr($email, '@', true); 
        $password = $carnet . $emailPart;
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT); 

        
        $query = "INSERT INTO Usuario (nombre, Numero_carnet, email, password, tipo_usuario) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssss', $nombre, $carnet, $email, $passwordHashed, $tipo_usuario);

        if ($stmt->execute()) {
            header('Location:/escuela/admin/user.php');
        } else {
            $errores[] = "Hubo un error al crear el usuario. Por favor, intenta nuevamente.";
        }

        $stmt->close();
    }
}
?>

<div class="main-content">
    <br><br>
    <h1>Crear Nuevo Usuario</h1>

  
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
            <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" value="<?php echo isset($nombre) ? $nombre : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="Numero_carnet">Número de Carnet</label>
            <input type="text" id="Numero_carnet" name="Numero_carnet" placeholder="Número de carnet" value="<?php echo isset($carnet) ? $carnet : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" placeholder="Tu correo electrónico" value="<?php echo isset($email) ? $email : ''; ?>" class="form-control">
        </div>

        <div class="form-group">
            <label for="tipo_usuario">Tipo de Usuario</label>
            <select id="tipo_usuario" name="tipo_usuario" class="form-control">
                <option value="administrador">Administrador</option>
                <option value="docente">Docente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Crear Usuario</button>
    </form>
</div>


<?php require '../template/footer.php'; ?>
