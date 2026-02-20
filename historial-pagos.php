<?php
session_start();
require_once __DIR__ . "/config/db.php";

/* Seguridad: solo alumno */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'alumno') {
    header("Location: login.php");
    exit;
}

$correoAlumno = $_SESSION['correo'];

/* Obtener historial de pagos del alumno */
$sql = "SELECT matricula, clave_pago, monto, estado_pago, fecha_pago
        FROM inscripciones
        WHERE correo = ?
        ORDER BY fecha DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correoAlumno);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Pagos</title>
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

    <h3 class="mb-4 text-center">Historial de Pagos</h3>

    <?php if ($result->num_rows > 0): ?>
        <div class="card shadow">
            <div class="card-body table-responsive">

                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Clave bancaria</th>
                            <th>Monto</th>
                            <th>Estado</th>
                            <th>Fecha de pago</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['matricula']) ?></td>
                                <td><?= $row['clave_pago'] ? htmlspecialchars($row['clave_pago']) : '—' ?></td>
                                <td>$<?= number_format($row['monto'], 2) ?></td>
                                <td>
                                    <?php if ($row['estado_pago'] === 'Pagado'): ?>
                                        <span class="badge bg-success">Pagado</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark">Pendiente</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= $row['fecha_pago'] ? htmlspecialchars($row['fecha_pago']) : '—' ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            Aún no tienes pagos registrados.
        </div>
    <?php endif; ?>

</div>

</body>
</html>