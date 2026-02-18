<?php
require_once __DIR__ . "/config/db.php";

$sql = "SELECT * FROM inscripciones ORDER BY fecha DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="fondo-panel">
<nav class="navbar navbar-dark bg-primary">
    <div class="container-fluid">
        <span class="navbar-brand">Panel Administrativo</span>
    </div>
</nav>
<div class="container my-5">
    <h3 class="mb-4">Validación de Inscripciones</h3>
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Alumno</th>
                        <th>Semestre</th>
                        <th>Grupo</th> <!-- ✅ NUEVA COLUMNA -->
                        <th>Monto</th>
                        <th>Referencia</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['matricula']) ?></td>
                            <td><?= htmlspecialchars($row['alumno']) ?></td>
                            <td><?= htmlspecialchars($row['semestre']) ?></td>
                            <!-- ✅ GRUPO -->
                            <td>
                                <?= $row['grupo'] ? htmlspecialchars($row['grupo']) : '—' ?>
                            </td>
                            <td>$<?= number_format($row['monto'], 2) ?></td>
                            <td><?= htmlspecialchars($row['referencia']) ?></td>
                            <!-- ✅ ESTADO -->
                            <td>
                                <?php if ($row['estado'] === 'Validado'): ?>
                                    <span class="badge bg-success">Validado</span>
                                <?php elseif ($row['estado'] === 'Rechazado'): ?>
                                    <span class="badge bg-danger">Rechazado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php endif; ?>
                            </td>
                            <!-- ✅ ACCIONES -->
                            <td>
                                <?php if ($row['estado'] === 'Pendiente'): ?>
                                    <a href="validar.php?id=<?= $row['id'] ?>"
                                       class="btn btn-success btn-sm">
                                        Validar
                                    </a>
                                    <a href="validar.php?id=<?= $row['id'] ?>&rechazar=1"
                                       class="btn btn-danger btn-sm">
                                        Rechazar
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">Procesado</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">
                            No hay registros.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>