<?php
require 'includes/app.php';
$db = conectarDb();
$password = '';
$email = '';
$errores = [];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_SANITIZE_EMAIL)));
    $password = mysqli_real_escape_string($db, $_POST['password']);

   
    if (!$email) {
        $errores[] = 'El correo  es obligatorio';
    }
    if (!$password) {
        $errores[] = 'La contraseña es obligatoria';
    }

    
    if (empty($errores)) {
        
        $query = "SELECT * FROM Usuario WHERE email = '${email}'";
        $result = mysqli_query($db, $query);

        if ($result->num_rows) {
            
            $usuario = mysqli_fetch_assoc($result);
            $passwordValida = password_verify($password, $usuario['password']);

            if (!$passwordValida) {
                $errores[] = 'La contraseña no es válida';
            } else {
                // Iniciar sesión
                session_start();
                $_SESSION['id_usuario'] = $usuario['id'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
                $_SESSION['login'] = true;

                // Redirigir al usuario según su tipo
                if ($usuario['tipo_usuario'] === 'administrador') {
                    header('Location: admin/index.php');
                } else if ($usuario['tipo_usuario'] === 'docente') {
                    header('Location: docentes/index.php');
                }
            }
        } else {
            $errores[] = "El usuario no existe";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/app.css">
    <link rel="stylesheet" href="css/normalize.css">
</head>
<body>

    <section class="login-section">
        <div class="login-container">
            <h2 class="login-title">Iniciar Sesión</h2>

            <!-- Mostrar errores si los hay -->
            <?php if (!empty($errores)) : ?>
                
                    <?php foreach ($errores as $error) : ?>
                        <div class="error-container">
                        <p class="error-message"><?php echo $error; ?></p>
                        </div>
                    <?php endforeach; ?>
                
            <?php endif; ?>

            <!-- Formulario de inicio de sesión -->
            <form class="login-form" action="" method="POST">
                <div class="input-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="Tu correo electrónico" value="<?php echo htmlspecialchars($email); ?>">
                </div>
                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" placeholder="Tu contraseña">
                </div>
                <button type="submit" class="btn-login">Ingresar</button>
            </form>
        </div>
    </section>

</body>
</html>
