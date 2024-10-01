<?php
require __DIR__ . '/../template/header.php';
require '../../includes/fpdf/fpdf.php';

$id_alumno = isset($_GET['id_alumno']) ? intval($_GET['id_alumno']) : 0;
$id_grado = isset($_GET['id_grado']) ? intval($_GET['id_grado']) : 0;

if ($id_alumno == 0 || $id_grado == 0) {
    die('ID del alumno o grado no proporcionado.');
}


$query = "
    SELECT al.nombre AS nombre_alumno, al.apellido_pa, al.apellido_ma, al.Numero_carnet, 
           a.nombre AS asignatura, n.nota, n.fecha_asignacion
    FROM Alumno al
    JOIN Inscripcion i ON al.id = i.id_alumno
    JOIN Asignatura a ON i.id_asignatura = a.id
    LEFT JOIN Nota n ON i.id = n.id_inscripcion
    WHERE al.id = ? AND i.id_grado = ?
";
$stmt = $conexion->prepare($query);
$stmt->bind_param('ii', $id_alumno, $id_grado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die('No se encontraron materias inscritas para este alumno.');
}


$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);


$pdf->Image('../../img/logo.png', 10, 10, 30); // Logo del colegio
$pdf->Cell(40); // Margen para el logo
$pdf->Cell(200, 10, 'Boletín de Notas - 20 de octubre II', 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(280, 10, 'Año Escolar 2023 - 2024', 0, 1, 'C');


$pdf->Line(10, 40, 290, 40);
$pdf->Ln(10);


$alumno = $result->fetch_assoc();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Nombre del Estudiante: ');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(100, 10, $alumno['nombre_alumno'] . ' ' . $alumno['apellido_pa'] . ' ' . $alumno['apellido_ma'], 0, 1);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Carnet: ');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(100, 10, $alumno['Numero_carnet'], 0, 1);


$pdf->Ln(10);


$pdf->SetFillColor(230, 230, 230); 
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(90, 10, 'Clase', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Bimestre 1', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Bimestre 2', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Bimestre 3', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Bimestre 4', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Promedio', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Estado', 1, 0, 'C', true);
$pdf->Ln();


$pdf->SetFont('Arial', '', 12);
$fill = false;
$result->data_seek(0); 
$promedio=0;
$mensaje="aprobado";
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(90, 10, $row['asignatura'], 1, 0, 'L', $fill);
    $pdf->Cell(30, 10, $row['nota'] ? $row['nota'] : 'N/A', 1, 0, 'C', $fill); // Nota 1
    $promedio=$promedio+$row['nota'];
    $pdf->Cell(30, 10, $row['nota'] ? $row['nota'] : 'N/A', 1, 0, 'C', $fill); // Nota 2
    $promedio=$promedio+$row['nota'];
    $pdf->Cell(30, 10, $row['nota'] ? $row['nota'] : 'N/A', 1, 0, 'C', $fill); // Nota 3
    $promedio=$promedio+$row['nota'];
    $pdf->Cell(30, 10, $row['nota'] ? $row['nota'] : 'N/A', 1, 0, 'C', $fill); // Nota 4
    $promedio=$promedio+$row['nota'];
    $promedio=$promedio/4;
    $pdf->Cell(30, 10, $promedio?? 'N/A', 1, 0, 'C', $fill); // Nota 4
    if($promedio<=61){$mensaje="aprobado";}else{
        $mensaje="reprobado";
    }
    $pdf->Cell(30, 10, $mensaje?? 'N/A', 1, 0, 'C', $fill); 
    $pdf->Ln();
    $fill = !$fill; 
}


$pdf->Output('I', 'Boletin_' . $alumno['nombre_alumno'] . '.pdf');


