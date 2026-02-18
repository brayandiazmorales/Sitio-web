<?php
require_once __DIR__ . "/config/db.php";

// Validar que el formulario venga por POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: inscripcion.html");
    exit;
}

// Recibir datos del formulario
$matricula  = "2026-" . rand(1000, 9999); // matrícula automática
$alumno     = $_POST["alumno"];
$correo     = $_POST["correo"];
$telefono   = $_POST["telefono"];
$semestre   = $_POST["semestre"];
$turno      = $_POST["turno"];
$monto      = 3500; // monto fijo
$referencia = "IBERO-" . $matricula;

// Insertar en la BD
$sql = "INSERT INTO inscripciones 
(matricula, alumno, correo, telefono, semestre, turno, monto, referencia)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssis",
    $matricula,
    $alumno,
    $correo,
    $telefono,
    $semestre,
    $turno,
    $monto,
    $referencia
);

$stmt->execute();

// Redirigir al voucher
header("Location: voucher.html");
exit;