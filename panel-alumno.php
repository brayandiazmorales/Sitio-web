<?php
session_start();
require_once __DIR__ . "/config/db.php";

/* Seguridad: solo alumno */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'alumno') {
    header("Location: login.php");
    exit;
}

/* Correo del alumno desde la sesión */
$correoAlumno = $_SESSION['correo'];

/* Obtener datos de la inscripción */
$sql = "SELECT matricula, semestre, turno, grupo, estado, estado_pago
        FROM inscripciones
        WHERE correo = ?
        ORDER BY fecha DESC
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correoAlumno);
$stmt->execute();
$result = $stmt->get_result();
$inscripcion = $result->fetch_assoc();

/* ✅ BLOQUEO POR PAGO */
if ($inscripcion && $inscripcion['estado_pago'] !== 'Pagado') {
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Pago pendiente</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="fondo-ibero">

    <div class="container vh-100 d-flex justify-content-center align-items-center">
        <div class="card shadow-lg p-4 text-center" style="max-width:420px;">
            <h4 class="mb-3 text-warning">Pago pendiente</h4>

            <p>
                Tu pago aún no ha sido validado por la institución.
            </p>

            <p class="text-muted">
                Por favor espera a que el área administrativa confirme tu pago
                o acude a la institución si tienes dudas.
            </p>

            <a href="voucher.php" class="btn btn-primary mt-2">
                Descargar voucher de pago
            </a>

            <a href="logout.php" class="btn btn-outline-secondary mt-3">
                Cerrar sesión
            </a>
        </div>
    </div>

    </body>
    </html>
    <?php
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Alumno</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="fondo-panel">

<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">Panel del Alumno</span>
        <a href="logout.php" class="btn btn-light btn-sm">Cerrar sesión</a>
    </div>
</nav>

<div class="container my-5">

    <h3 class="mb-4">Estado de tu Inscripción</h3>

    <?php if ($inscripcion): ?>
        <div class="card">
            <div class="card-body">

                <p><strong>Matrícula:</strong> <?= htmlspecialchars($inscripcion['matricula']) ?></p>
                <p><strong>Semestre:</strong> <?= htmlspecialchars($inscripcion['semestre']) ?></p>
                <p><strong>Turno:</strong> <?= htmlspecialchars($inscripcion['turno']) ?></p>

                <p>
                    <strong>Estado académico:</strong>
                    <?php if ($inscripcion['estado'] === 'Validado'): ?>
                        <span class="badge bg-success">Validado</span>
                    <?php elseif ($inscripcion['estado'] === 'Rechazado'): ?>
                        <span class="badge bg-danger">Rechazado</span>
                    <?php else: ?>
                        <span class="badge bg-warning text-dark">Pendiente</span>
                    <?php endif; ?>
                </p>

                <p>
                    <strong>Grupo:</strong>
                    <?= $inscripcion['grupo'] ? htmlspecialchars($inscripcion['grupo']) : 'Asignado próximamente' ?>
                </p>

                <p>
                    <strong>Estado de pago:</strong>
                    <span class="badge bg-success">Pagado</span>
                </p>

            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            No se encontró ninguna inscripción asociada a tu cuenta.
        </div>
    <?php endif; ?>

</div>

</body>
</html>