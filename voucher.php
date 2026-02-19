<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . "/config/db.php";

/* Seguridad: solo alumno */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'alumno') {
    header("Location: login.php");
    exit;
}

$correo = $_SESSION['correo'];

/* Obtener última inscripción del alumno */
$sql = "SELECT id, matricula, alumno, semestre, turno
        FROM inscripciones
        WHERE correo = ?
        ORDER BY fecha DESC
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();
$ins = $result->fetch_assoc();

if (!$ins) {
    die("No se encontró ninguna inscripción para este alumno.");
}

$id = $ins['id'];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Inscripción</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="fondo-panel">

<nav class="navbar navbar-dark bg-primary shadow">
    <div class="container-fluid">
        <span class="navbar-brand">Preparatoria Iberoamericana</span>
        <a href="panel-alumno.php" class="btn btn-light btn-sm">Volver al panel</a>
    </div>
</nav>

<div class="container my-5">

    <div class="card mx-auto voucher-card">
        <div class="card-body p-4">

            <h4 class="text-center mb-3">Comprobante de Inscripción</h4>
            <hr>

            <p><strong>Nombre:</strong> <?= htmlspecialchars($ins['alumno']) ?></p>
            <p><strong>Matrícula:</strong> <?= htmlspecialchars($ins['matricula']) ?></p>
            <p><strong>Semestre:</strong> <?= htmlspecialchars($ins['semestre']) ?></p>
            <p><strong>Turno:</strong> <?= htmlspecialchars($ins['turno']) ?></p>
            <p><strong>Monto:</strong> $3,500.00 MXN</p>

            <div class="alert alert-info">
                Este comprobante deberá presentarse para la validación del pago.
            </div>

            <div class="d-flex justify-content-end gap-2 no-print">
                <button type="button" class="btn btn-secondary" onclick="window.print();">
                    Imprimir
                </button>

                <!-- DESCARGA PDF CORRECTA -->
                <a href="voucher-pdf.php?id=<?= $id ?>" class="btn btn-primary">
                    Descargar PDF
                </a>
            </div>

        </div>
    </div>

</div>

</body>
</html>