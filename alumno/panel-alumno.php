<?php
session_start();

require_once __DIR__ . '/../config/db.php';

/* Seguridad: solo alumno */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'alumno') {
    header("Location: ../auth/login.php");
    exit;
}

/* Correo del alumno desde sesión */
$correoAlumno = $_SESSION['correo'];

/* Obtener inscripción más reciente */
$sql = "SELECT id, matricula, semestre, turno, grupo, estado, estado_pago
        FROM inscripciones
        WHERE correo = ?
        ORDER BY fecha DESC
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correoAlumno);
$stmt->execute();
$result = $stmt->get_result();
$inscripcion = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Alumno</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="fondo-panel">

<nav class="navbar navbar-dark bg-primary shadow">
    <div class="container-fluid">
        <span class="navbar-brand">Preparatoria Iberoamericana</span>
        <a href="../auth/logout.php" class="btn btn-light btn-sm">Cerrar sesión</a>
    </div>
</nav>

<div class="container my-5">

    <?php if (!$inscripcion): ?>
        <div class="alert alert-info text-center mb-4">
            Aún no has realizado tu inscripción. Para continuar, completa el formulario.
        </div>
    <?php elseif ($inscripcion['estado_pago'] === 'Pendiente'): ?>
        <div class="alert alert-warning text-center mb-4">
            Tu inscripción está registrada, pero aún no has enviado tu comprobante de pago.
        </div>
    <?php elseif ($inscripcion['estado_pago'] === 'En revisión'): ?>
        <div class="alert alert-info text-center mb-4">
            Tu comprobante fue enviado y está en revisión por el área administrativa.
        </div>
    <?php else: ?>
        <div class="alert alert-success text-center mb-4">
            ✅ Tu pago ha sido validado correctamente.
        </div>
    <?php endif; ?>

    <div class="text-center mb-5">
        <h2 class="fw-bold">Bienvenido al Panel del Alumno</h2>
        <p class="text-muted">Sistema de Inscripciones Escolares</p>
    </div>

    <div class="row g-4 mb-5">

        <div class="col-md-3">
            <div class="card text-center shadow h-100">
                <div class="card-body">
                    <h5 class="card-title">Inscripción</h5>
                    <p class="card-text">Registro al semestre.</p>
                    <?php if (!$inscripcion): ?>
                        <a href="../inscripcion/inscripcion.html" class="btn btn-primary">Acceder</a>
                    <?php else: ?>
                        <span class="badge bg-success">✅ Inscripción completada</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow h-100">
                <div class="card-body">
                    <h5 class="card-title">Comprobante</h5>
                    <p class="card-text">Pago bancario.</p>
                    <?php if (!$inscripcion): ?>
                        <button class="btn btn-secondary" disabled>No disponible</button>
                    <?php elseif ($inscripcion['estado_pago'] === 'Pendiente'): ?>
                        <a href="subir-comprobante.php" class="btn btn-warning">Subir comprobante</a>
                    <?php elseif ($inscripcion['estado_pago'] === 'En revisión'): ?>
                        <span class="badge bg-info text-dark">En revisión</span>
                    <?php else: ?>
                        <span class="badge bg-success">✅ Pago completado</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow h-100">
                <div class="card-body">
                    <h5 class="card-title">Datos personales</h5>
                    <p class="card-text">Información registrada.</p>
                    <a href="datos-personales.php" class="btn btn-primary">Consultar</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow h-100">
                <div class="card-body">
                    <h5 class="card-title">Historial de pagos</h5>
                    <p class="card-text">Pagos realizados.</p>
                    <a href="historial-pagos.php" class="btn btn-primary">Ver historial</a>
                </div>
            </div>
        </div>

    </div>

    <div class="text-center">
        <img src="../img/aviso.png" class="img-fluid rounded shadow w-75" alt="Aviso institucional">
    </div>
</div>

<p class="text-center mt-3 mb-0 text-muted">
    © 2026 Preparatoria Iberoamericana
</p>

</body>
</html>