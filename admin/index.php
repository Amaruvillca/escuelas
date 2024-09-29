<?php 
$nombre = 'index';
require 'template/header.php'; 


if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}


$usuarios_count = $conexion->query("SELECT COUNT(*) as total FROM Usuario WHERE tipo_usuario = 'administrador'")->fetch_assoc()['total'];
$usuarios_docentes = $conexion->query("SELECT COUNT(*) as total FROM Usuario WHERE tipo_usuario = 'docente'")->fetch_assoc()['total'];
$alumnos_count = $conexion->query("SELECT COUNT(*) as total FROM Alumno")->fetch_assoc()['total'];
$materias_count = $conexion->query("SELECT COUNT(*) as total FROM Materias")->fetch_assoc()['total'];
$asignaturas_count = $conexion->query("SELECT COUNT(*) as total FROM Asignatura")->fetch_assoc()['total'];
$inscripciones_count = $conexion->query("SELECT COUNT(*) as total FROM Inscripcion")->fetch_assoc()['total'];
$notas_count = $conexion->query("SELECT COUNT(*) as total FROM Nota")->fetch_assoc()['total'];
?>

<div class="main-content">
    <div class="header">
        <h1>Bienvenido  <?php echo $_SESSION['nombre']; ?></h1>
    </div>
    <div class="content">
        <div class="card">
            <h3> Usuarios</h3>
            <p>usuarios: <?php echo $usuarios_count;  ?>   docentes:  <?php echo $usuarios_docentes;  ?></p>
        </div>
        <div class="card">
            <h3> Alumnos</h3>
            <p>alumnos: <?php echo $alumnos_count; ?></p>
        </div>
        <div class="card">
            <h3> Materias</h3>
            <p>materias: <?php echo $materias_count; ?></p>
        </div>
        <div class="card">
            <h3> Asignaturas</h3>
            <p>asignaturas: <?php echo $asignaturas_count; ?></p>
        </div>
        <div class="card">
            <h3>Inscripciones</h3>
            <p>Cantidad de inscripciones: <?php echo $inscripciones_count; ?></p>
        </div>
        <div class="card">
            <h3>Notas</h3>
            <p>Cantidad de notas: <?php echo $notas_count; ?></p>
        </div>
    </div>
</div>

<?php require 'template/footer.php'; ?>
