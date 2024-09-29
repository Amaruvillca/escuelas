<?php
$nombre = 'Añadir Nota';
require 'template/header.php';

// Asumiendo que $conexion es tu conexión a la base de datos
$id_alumno = isset($_GET['id_alumno']) ? intval($_GET['id_alumno']) : 0;
$id_asignatura = isset($_GET['id_asignatura']) ? intval($_GET['id_asignatura']) : 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $nota = $_POST['nota'];
    
    
    if (!is_numeric($nota) || $nota <= 0 || $nota > 100) {
        echo "<center>La nota debe ser un número entre 1 y 100.</center>";
        exit;
    }

   
    $fecha_asignacion = date('Y-m-d'); 
    var_dump($fecha_asignacion); 

    
    $query_inscripcion = "SELECT id FROM Inscripcion WHERE id_alumno = ? AND id_asignatura = ?";
    $stmt_inscripcion = $conexion->prepare($query_inscripcion);
    $stmt_inscripcion->bind_param('ii', $id_alumno, $id_asignatura);
    $stmt_inscripcion->execute();
    $result_inscripcion = $stmt_inscripcion->get_result();
    $inscripcion = $result_inscripcion->fetch_assoc();

    
    if ($inscripcion) {
        $id_inscripcion = $inscripcion['id'];

       
        $query = "INSERT INTO Nota (id_inscripcion, nota, fecha_asignacion) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($query);
        
        
        $stmt->bind_param('ids', $id_inscripcion, $nota, $fecha_asignacion);

        
        if ($stmt->execute()) {
            header("Location: notas.php?id_alumno=$id_alumno&id_asignatura=$id_asignatura");
            exit;
        } else {
            echo "Error al insertar la nota: " . $stmt->error; 
        }
    } else {
        echo "No se encontró la inscripción para el alumno y la asignatura seleccionados.";
    }
}
?>

<div class="main-content">
    <h1>Añadir Nota</h1>
    <form method="POST" action="" class="crear--asignatura">
        <div>
            <label for="nota">Nota:</label>
            <input type="text" id="nota" name="nota" required>
        </div>
        <br>
        <button type="submit" class="btn btn-success">Guardar Nota</button>
    </form>
</div>

<?php
require 'template/footer.php';
?>
