<?php
session_start();
require_once __DIR__ . "/config/db.php";

/* Seguridad: solo alumno */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'alumno') {
    header("Location: login.php");
    exit;
}

/* Correo del alumno desde sesión */
$correoAlumno = $_SESSION['correo'];

/* Obtener inscripción más reciente (si existe) */
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

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="fondo-panel">

<nav class="navbar navbar-dark bg-primary shadow">
    <div class="container-fluid">
        <span class="navbar-brand">Preparatoria Iberoamericana</span>
        <a href="logout.php" class="btn btn-light btn-sm">Cerrar sesión</a>
    </div>
</nav>

<div class="container my-5">

    <!-- MENSAJE DE ESTADO (SI APLICA) -->
    <?php if (!$inscripcion): ?>
        <div class="alert alert-info text-center mb-4">
            Aún no has realizado tu inscripción. Para continuar, completa el formulario de inscripción.
        </div>
    <?php elseif ($inscripcion['estado_pago'] !== 'Pagado'): ?>
        <div class="alert alert-warning text-center mb-4">
            Tu inscripción está registrada, pero tu pago aún no ha sido validado.
            Puedes descargar tu voucher para realizar el pago.
        </div>
    <?php else: ?>
        <div class="alert alert-success text-center mb-4">
            Tu pago ha sido validado correctamente. Bienvenido al sistema.
        </div>
    <?php endif; ?>

    <!-- TÍTULO -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Bienvenido al Panel del Alumno</h2>
        <p class="text-muted">Sistema de Inscripciones Escolares</p>
    </div>

    <!-- TARJETAS PRINCIPALES -->
    <div class="row g-4 mb-5">

        <!-- INSCRIPCIÓN -->
        <div class="col-md-4">
            <div class="card text-center shadow h-100">
                <div class="card-body">
                    <h5 class="card-title">Inscripción</h5>
                    <p class="card-text">Realiza o consulta tu inscripción al semestre.</p>
                    <a href="inscripcion.html" class="btn btn-primary">
                        Acceder
                    </a>
                </div>
            </div>
        </div>

        <!-- COMPROBANTE -->
        <div class="col-md-4">
            <div class="card text-center shadow h-100">
                <div class="card-body">
                    <h5 class="card-title">Comprobante</h5>
                    <p class="card-text">Consulta o descarga tu voucher de pago.</p>
                    <?php if ($inscripcion): ?>
                        <a href="voucher.php" class="btn btn-primary">
                            Ver
                        </a>
                    <?php else: ?>
                        <button class="btn btn-secondary" disabled>
                            No disponible
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- DATOS PERSONALES -->
        <div class="col-md-4">
            <div class="card text-center shadow h-100">
                <div class="card-body">
                    <h5 class="card-title">Datos personales</h5>
                    <p class="card-text">Consulta tu información registrada.</p>
                    <a href="#" class="btn btn-primary">
                        Consultar
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- ANUNCIO INSTITUCIONAL -->
    <div class="text-center">
        <img src="img/aviso.png"
             class="img-fluid rounded shadow w-75"
             alt="Aviso institucional">
    </div>

</div>

</body>
</html>