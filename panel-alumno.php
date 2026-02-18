<?php
require_once __DIR__ . "/config/db.php";

/*
  🔹 En esta etapa (sin login),
  simulamos que el alumno se identifica por correo.
  Más adelante esto se hará con sesiones.
*/

// 👉 CAMBIA ESTE CORREO POR EL DEL ALUMNO REGISTRADO
$correoAlumno = "correo@ibero.edu.mx";

$sql = "SELECT matricula, semestre, turno, grupo, estado
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
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">Panel del Alumno</span>
        <a href="index.html" class="btn btn-light btn-sm">Cerrar sesión</a>
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
                    <strong>Estado:</strong>
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
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            No se encontró ninguna inscripción asociada a este correo.
        </div>
    <?php endif; ?>
</div>
</body>
</html>