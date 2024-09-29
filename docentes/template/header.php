<?php session_start(); 
require '../includes/app.php';
estadoAutenticado();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/dasboard.css">
    <link rel="stylesheet" href="../css/normalize.css">
</head>
<body>
    <div class="dashboard">
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>docente</h2>
            </div>
            <hr style="color: white;">
            <ul class="sidebar-menu">
                <li><a href="/escuela/docentes/index.php" class="<?php if($nombre=='index'){echo 'active';}?>">Inicio</a></li>
                
                <li><a href="/escuela/docentes/asignaturas.php" class="<?php if($nombre=='asignaturas'){echo 'active';}?>">asignaturas</a></li>
                <li><a href="/escuela/includes/salir.php">Cerrar Sesión</a></li>
            </ul>
        </aside>