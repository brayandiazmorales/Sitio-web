<?php
session_start();

/* Conexión a la base de datos */
require_once __DIR__ . "/../config/db.php";

/* Seguridad: solo alumno logueado */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'alumno') {
    header("Location: ../auth/login.php");
    exit;
}

/* Validar que el formulario venga por POST */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: inscripcion.html");
    exit;
}

/* =========================
   DATOS DEL ALUMNO
========================= */

// Matrícula automática
$matricula  = "2026-" . rand(1000, 9999);

// Datos del formulario
$alumno   = trim($_POST["alumno"]);
$telefono = trim($_POST["telefono"]);
$semestre = $_POST["semestre"];
$turno    = $_POST["turno"];

// Correo tomado de la sesión
$correo = $_SESSION["correo"];

// Datos de pago
$monto      = 3500;
$referencia = "IBERO-" . $matricula;

/* =========================
   INSERTAR EN BASE DE DATOS
========================= */

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

/* =========================
   REDIRECCIÓN AL VOUCHER
========================= */

header("Location: ../voucher.php");
exit;