<?php
session_start();
require_once __DIR__ . "/config/db.php";

/* Seguridad: solo administrador */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

/* Obtener inscripciones */
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

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-primary shadow">
    <div class="container-fluid">
        <span class="navbar-brand">Preparatoria Iberoamericana</span>
        <div>
            <!-- ✅ NUEVO: ADMINISTRADORES -->
            <a href="admins.php" class="btn btn-outline-light btn-sm me-2">
                Administradores
            </a>

            <a href="reporte-pagos.php" class="btn btn-outline-light btn-sm me-2">
                Reporte de Pagos
            </a>

            <a href="alta-alumno.php" class="btn btn-outline-light btn-sm me-2">
                Alta de Alumno
            </a>

            <a href="logout.php" class="btn btn-light btn-sm">
                Cerrar sesión
            </a>
        </div>
    </div>
</nav>

<!-- CONTENIDO -->
<div class="container my-5">

    <h3 class="mb-4">Validación de Inscripciones y Pagos</h3>

    <div class="card">
        <div class="card-body table-responsive">

            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Alumno</th>
                        <th>Semestre</th>
                        <th>Grupo</th>
                        <th>Monto</th>
                        <th>Referencia</th>
                        <th>Estado Académico</th>
                        <th>Estado de Pago</th>
                        <th>Comprobante</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['matricula']) ?></td>
                            <td><?= htmlspecialchars($row['alumno']) ?></td>
                            <td><?= htmlspecialchars($row['semestre']) ?></td>
                            <td><?= $row['grupo'] ? htmlspecialchars($row['grupo']) : '—' ?></td>
                            <td>$<?= number_format($row['monto'], 2) ?></td>
                            <td><?= htmlspecialchars($row['referencia']) ?></td>

                            <!-- Estado académico -->
                            <td>
                                <?php if ($row['estado'] === 'Validado'): ?>
                                    <span class="badge bg-success">Validado</span>
                                <?php elseif ($row['estado'] === 'Rechazado'): ?>
                                    <span class="badge bg-danger">Rechazado</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php endif; ?>
                            </td>

                            <!-- Estado de pago -->
                            <td>
                                <?php if ($row['estado_pago'] === 'Pagado'): ?>
                                    <span class="badge bg-success">Pagado</span>
                                <?php elseif ($row['estado_pago'] === 'En revisión'): ?>
                                    <span class="badge bg-info text-dark">En revisión</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                <?php endif; ?>
                            </td>

                            <!-- Comprobante -->
                            <td>
                                <?php if (!empty($row['comprobante_pago'])): ?>
                                    <a href="<?= htmlspecialchars($row['comprobante_pago']) ?>"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        Ver
                                    </a>
                                <?php else: ?>
                                    —
                                <?php endif; ?>
                            </td>

                            <!-- Acciones -->
                            <td>
                                <?php if ($row['estado_pago'] === 'En revisión'): ?>
                                    <a href="autorizar-pago.php?id=<?= (int)$row['id'] ?>"
                                       class="btn btn-success btn-sm mb-1"
                                       onclick="return confirm('¿Autorizar este pago?');">
                                        Autorizar pago
                                    </a>
                                <?php endif; ?>

                                <?php if ($row['estado'] === 'Pendiente'): ?>
                                    <a href="validar.php?id=<?= (int)$row['id'] ?>"
                                       class="btn btn-primary btn-sm mb-1">
                                        Validar inscripción
                                    </a>
                                <?php endif; ?>

                                <form action="eliminar-inscripcion.php"
                                      method="POST"
                                      style="display:inline;"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar esta inscripción?');">
                                    <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Eliminar
                                    </button>
                                </form>
                            </td>

                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="10" class="text-center">
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