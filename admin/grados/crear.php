<?php 
$nombre = 'alumnos';
require __DIR__.'/../template/header.php'; 


$errores = [];
$exito = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $curso = trim($_POST['curso']);
    $grado = trim($_POST['grado']);
    $paralelo = trim($_POST['paralelo']);
    $id_alumno = trim($_POST['id_alumno']); 

    
    if (empty($curso)) {
        $errores[] = "El curso es obligatorio.";
    }

    
    if (empty($grado)) {
        $errores[] = "El grado es obligatorio.";
    }

    
    if (empty($paralelo)) {
        $errores[] = "El paralelo es obligatorio.";
    }

    
    if (empty($errores)) {
        
        $query = "INSERT INTO grado (curso, grado, paralelo, id_alumno) 
                  VALUES (?, ?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('sssi', $curso, $grado, $paralelo, $id_alumno);

        if ($stmt->execute()) {
            
            header('Location:/escuela/admin/alumnos/clasesinscritas.php?id='.$_GET['id']);
        } else {
            $errores[] = "Hubo un error al registrar el curso. Por favor, intenta nuevamente.";
        }

        $stmt->close();
    }
}
?>

<div class="main-content">
    <br><br>
    <h1>Registrar Nuevo Curso</h1>

    
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

    <form method="POST" class="crear--curso">
        <input type="hidden" name="id_alumno" value="<?php echo htmlspecialchars($_GET['id']); ?>"> <!-- ID del alumno enviado por GET -->

        <div class="form-group">
            <label for="curso">Curso</label>
            <select name="curso" id="curso" class="form-control" required>
                <option value="">Seleccionar curso</option>
                <option value="Primero">Primero</option>
                <option value="Segundo">Segundo</option>
                <option value="Tercero">Tercero</option>
                <option value="Cuarto">Cuarto</option>
                <option value="Quinto">Quinto</option>
                <option value="Sexto">Sexto</option>
            </select>
        </div>

        <div class="form-group">
            <label for="grado">Grado</label>
            <select name="grado" id="grado" class="form-control" required>
                <option value="">Seleccionar grado</option>
                <option value="Primaria">Primaria</option>
                <option value="Secundaria">Secundaria</option>
            </select>
        </div>

        <div class="form-group">
            <label for="paralelo">Paralelo</label>
            <select name="paralelo" id="paralelo" class="form-control" required>
                <option value="">Seleccionar paralelo</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
                <option value="F">F</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Registrar Curso</button>
    </form>
</div>

<?php require '../template/footer.php'; ?> 
