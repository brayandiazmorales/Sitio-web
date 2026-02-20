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

/* Obtener datos personales del alumno */
$sql = "SELECT alumno, correo, telefono, matricula, semestre, turno, grupo
        FROM inscripciones
        WHERE correo = ?
        ORDER BY fecha DESC
        LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correoAlumno);
$stmt->execute();
$result = $stmt->get_result();
$datos = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Datos personales</title>
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

    <h3 class="mb-4 text-center">Datos personales del alumno</h3>

    <?php if ($datos): ?>
        <!-- ✅ DATOS ENCONTRADOS -->
        <div class="card shadow mx-auto" style="max-width:600px;">
            <div class="card-body">

                <p><strong>Nombre:</strong> <?= htmlspecialchars($datos['alumno']) ?></p>
                <p><strong>Correo institucional:</strong> <?= htmlspecialchars($datos['correo']) ?></p>
                <p><strong>Teléfono:</strong> <?= htmlspecialchars($datos['telefono']) ?></p>
                <p><strong>Matrícula:</strong> <?= htmlspecialchars($datos['matricula']) ?></p>
                <p><strong>Semestre:</strong> <?= htmlspecialchars($datos['semestre']) ?></p>
                <p><strong>Turno:</strong> <?= htmlspecialchars($datos['turno']) ?></p>
                <p>
                    <strong>Grupo:</strong>
                    <?= $datos['grupo'] ? htmlspecialchars($datos['grupo']) : 'Asignado próximamente' ?>
                </p>

            </div>
        </div>

    <?php else: ?>
        <!-- ❗ AÚN NO HAY INSCRIPCIÓN -->
        <div class="alert alert-warning text-center mx-auto" style="max-width:600px;">
            Aún no se han registrado tus datos personales porque no has completado la inscripción.

            <div class="mt-3">
                <a href="inscripcion.html" class="btn btn-primary">
                    Realizar inscripción
                </a>
            </div>
        </div>
    <?php endif; ?>

</div>

</body>
</html>