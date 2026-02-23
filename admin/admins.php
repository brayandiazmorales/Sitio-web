<?php
session_start();

require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../auth/login-admin.php");
    exit;
}

$sql = "SELECT id, nombre, correo FROM usuarios WHERE rol = 'admin'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administradores</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">

<div class="container my-5">
    <h3>Administradores</h3>

    <a href="alta-admin.php" class="btn btn-primary mb-3">
        Agregar administrador
    </a>

    <table class="table table-bordered">
        <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Acciones</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['correo']) ?></td>
                <td>
                    <?php if ($row['id'] !== $_SESSION['id']): ?>
                        <form action="eliminar-admin.php" method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                            <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('¿Eliminar este administrador?');">
                                Eliminar
                            </button>
                        </form>
                    <?php else: ?>
                        <span class="text-muted">Sesión activa</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <a href="panel-admin.php">← Volver al panel</a>
</div>

<p class="text-center mt-3 mb-0 text-muted">
    © 2026 Preparatoria Iberoamericana
</p>

</body>
</html>