<?php session_start(); 
require __DIR__ . '/../../includes/app.php';
estadoAutenticado();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/escuela/css/dasboard.css">
    <link rel="stylesheet" href="/escuela/css/normalize.css">
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>Admin</h2>
            </div>
            <hr style="color: white;">
            <ul class="sidebar-menu">
                <li><a href="/escuela/admin/index.php" class="<?php if($nombre=='index'){echo 'active';}?>">Inicio</a></li>
                <li><a href="/escuela/admin/user.php" class="<?php if($nombre=='user'){echo 'active';}?>">Usuarios</a></li>
                <li><a href="/escuela/admin/alumnos.php" class="<?php if($nombre=='alumnos'){echo 'active';}?>">alumnos</a></li>
                <li><a href="/escuela/admin/materias.php" class="<?php if($nombre=='materias'){echo 'active';}?>">Materias</a></li>
                <li><a href="/escuela/admin/asignaturas.php" class="<?php if($nombre=='clases'){echo 'active';}?>">Clases</a></li>
                <li><a href="/escuela/includes/salir.php">Cerrar Sesión</a></li>
            </ul>
        </aside>