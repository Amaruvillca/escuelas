<?php
require 'includes/app.php';

$conn=conectarDb();

// Datos del usuario administrador
$nombre = "Amaru";
$email = "76595194amaru@gmail.com";
$Numero_carnet = "9874713";
$tipo_usuario = "docente";
$password_plain = "123456789"; // Contraseña sin encriptar

// Encriptar la contraseña
$password_hash = password_hash($password_plain, PASSWORD_DEFAULT);

// Preparar la consulta SQL para insertar el usuario
$sql = $conn->prepare("INSERT INTO Usuario (nombre, Numero_carnet, email, password, tipo_usuario) 
                       VALUES (?, ?, ?, ?, ?)");

if ($sql) {
    // Vincular los parámetros
    $sql->bind_param("sssss", $nombre, $Numero_carnet, $email, $password_hash, $tipo_usuario);

    // Ejecutar la consulta
    if ($sql->execute()) {
        echo "Usuario administrador creado exitosamente.";
    } else {
        echo "Error al crear el usuario: " . $sql->error;
    }

    // Cerrar la consulta
    $sql->close();
} else {
    echo "Error en la preparación de la consulta: " . $conn->error;
}

// Cerrar la conexión
$conn->close();

