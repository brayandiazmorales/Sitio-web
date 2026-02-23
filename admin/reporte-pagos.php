<?php
session_start();

require_once __DIR__ . '/../config/db.php';

/* Seguridad: solo admin */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../auth/login-admin.php");
    exit;
}

/* Filtro por estado */
$estadoFiltro = $_GET['estado_pago'] ?? 'Todos';

/* Construir consulta */
$sql = "SELECT alumno, matricula, correo, clave_pago, estado_pago, fecha_pago
        FROM inscripciones";

if ($estadoFiltro !== 'Todos') {
    $sql .= " WHERE estado_pago = ?";
}

$sql .= " ORDER BY fecha DESC";

$stmt = $conn->prepare($sql);

if ($estadoFiltro !== 'Todos') {
    $stmt->bind_param("s", $estadoFiltro);
}

$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Pagos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="fondo-panel">

<nav class="navbar navbar-dark bg-primary shadow">
    <div class="container-fluid">
        <span class="navbar-brand">Reporte de Pagos</span>
        <a href="panel-admin.php" class="btn btn-light btn-sm">Volver al panel</a>
    </div>
</nav>

<div class="container my-5">
    <h3 class="mb-4">Reporte de Pagos</h3>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <label class="form-label">Estado de pago</label>
            <select name="estado_pago" class="form-select">
                <option <?= $estadoFiltro === 'Todos' ? 'selected' : '' ?>>Todos</option>
                <option value="Pagado" <?= $estadoFiltro === 'Pagado' ? 'selected' : '' ?>>Pagado</option>
                <option value="Pendiente" <?= $estadoFiltro === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button class="btn btn-primary w-100">Filtrar</button>
        </div>
    </form>

    <div class="card shadow">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Alumno</th>
                        <th>Matrícula</th>
                        <th>Correo</th>
                        <th>Clave bancaria</th>
                        <th>Estado de pago</th>
                        <th>Fecha de pago</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['alumno']) ?></td>
                            <td><?= htmlspecialchars($row['matricula']) ?></td>
                            <td><?= htmlspecialchars($row['correo']) ?></td>
                            <td><?= $row['clave_pago'] ? htmlspecialchars($row['clave_pago']) : '—' ?></td>
                            <td>
                                <?php if ($row['estado_pago'] === 'Pagado'): ?>
                                    <span class="badge bg-success">Pagado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $row['fecha_pago'] ? htmlspecialchars($row['fecha_pago']) : '—' ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay registros.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<p class="text-center mt-3 mb-0 text-muted">
    © 2026 Preparatoria Iberoamericana
</p>

</body>
</html>