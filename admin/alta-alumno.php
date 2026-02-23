<?php
session_start();

require_once __DIR__ . '/../config/db.php';

/* Solo admin */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../auth/login-admin.php");
    exit;
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nombre   = trim($_POST['nombre'] ?? '');
    $correo   = trim($_POST['correo'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($nombre && $correo && $password) {

        if (!preg_match('/@ibero\.edu\.mx$/', $correo)) {
            $mensaje = "❌ El correo debe ser institucional.";
        } else {

            $passwordHash = hash('sha256', $password);

            $sql = "INSERT INTO usuarios (nombre, correo, password, rol)
                    VALUES (?, ?, ?, 'alumno')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nombre, $correo, $passwordHash);

            if ($stmt->execute()) {
                $mensaje = "✅ Alumno dado de alta correctamente.";
            } else {
                $mensaje = "❌ Error: el correo ya existe.";
            }
        }
    } else {
        $mensaje = "❌ Todos los campos son obligatorios.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Alta de Alumno</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">

<div class="container my-5" style="max-width:500px;">
    <h4 class="mb-4">Alta de Alumno</h4>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>Nombre completo</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Correo institucional</label>
            <input type="email" name="correo" class="form-control"
                   placeholder="alumno@ibero.edu.mx" required>
        </div>

        <div class="mb-3">
            <label>Contraseña inicial</label>
            <input type="text" name="password" class="form-control" required>
        </div>

        <button class="btn btn-primary w-100">Registrar Alumno</button>
    </form>

    <a href="panel-admin.php" class="btn btn-link mt-3">← Volver al panel</a>
</div>

<p class="text-center mt-3 mb-0 text-muted">
    © 2026 Preparatoria Iberoamericana
</p>

</body>
</html>