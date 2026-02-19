<?php
require_once __DIR__ . "/config/db.php";
require_once __DIR__ . "/fpdf/fpdf.php";

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    die("ID inválido");
}

$sql = "SELECT * FROM inscripciones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$ins = $stmt->get_result()->fetch_assoc();

if (!$ins) {
    die("Inscripción no encontrada");
}

/* Generar clave bancaria si no existe */
if (empty($ins['clave_pago'])) {
    $clave = "IBERO-" . date("Y") . "-" . strtoupper(bin2hex(random_bytes(4)));
    $up = $conn->prepare("UPDATE inscripciones SET clave_pago=? WHERE id=?");
    $up->bind_param("si", $clave, $id);
    $up->execute();
} else {
    $clave = $ins['clave_pago'];
}

/* =========================
   CREAR PDF
========================= */

$pdf = new FPDF('P','mm','Letter');
$pdf->AddPage();

/* ENCABEZADO */
$pdf->SetFont('Arial','B',16);
$pdf->Cell(0,10,'PREPARATORIA IBEROAMERICANA',0,1,'C');

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,8,'Comprobante de Inscripcion / Voucher de Pago',0,1,'C');

$pdf->Ln(5);

/* -------------------------
   DATOS DEL ALUMNO
------------------------- */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'Datos del Alumno',0,1);
$pdf->Line(15, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(4);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,7,'Nombre: '.$ins['alumno'],0,1);
$pdf->Cell(0,7,'Matricula: '.$ins['matricula'],0,1);
$pdf->Cell(0,7,'Correo: '.$ins['correo'],0,1);

$pdf->Ln(6);

/* -------------------------
   DATOS ACADÉMICOS
------------------------- */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'Datos Academicos',0,1);
$pdf->Line(15, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(4);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,7,'Semestre: '.$ins['semestre'],0,1);
$pdf->Cell(0,7,'Turno: '.$ins['turno'],0,1);
$pdf->Cell(0,7,'Grupo: '.($ins['grupo'] ?: 'Asignado por control escolar'),0,1);

$pdf->Ln(6);

/* -------------------------
   INFORMACIÓN DE PAGO
------------------------- */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'Informacion de Pago',0,1);
$pdf->Line(15, $pdf->GetY(), 200, $pdf->GetY());
$pdf->Ln(4);

$pdf->SetFont('Arial','',11);
$pdf->Cell(0,7,'Concepto: Inscripcion Semestral',0,1);
$pdf->Cell(0,7,'Monto: $3,500.00 MXN',0,1);

$pdf->Ln(10);

/* -------------------------
   CLAVE BANCARIA
------------------------- */
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,8,'CLAVE BANCARIA DE PAGO',0,1,'C');

$pdf->Ln(3);

$pdf->SetFont('Arial','B',16);
$pdf->SetDrawColor(0,0,0);
$pdf->Cell(0,18, $clave, 1, 1, 'C');

$pdf->Ln(8);

/* -------------------------
   AVISO
------------------------- */
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(
    0,
    6,
    'Presenta este comprobante en la institucion bancaria autorizada para realizar el pago. '
    .'La clave bancaria es unica y permite identificar tu transaccion.'
);

/* -------------------------
   DESCARGA FORZADA
------------------------- */
$pdf->Output('D', 'Voucher_'.$ins['matricula'].'.pdf');
exit;