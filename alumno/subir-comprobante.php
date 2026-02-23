<?php
session_start();

require_once __DIR__ . '/../config/db.php';

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'alumno') {
    header("Location: ../auth/login.php");
    exit;
}

$correo = $_SESSION['correo'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_FILES['comprobante'])) {
        die("No se envió archivo.");
    }

    $nombre = time() . "_" . basename($_FILES['comprobante']['name']);

    // carpeta REAL donde se guardan los PDFs
    $ruta = "../comprobantes/" . $nombre;

    if (move_uploaded_file($_FILES['comprobante']['tmp_name'], $ruta)) {

        // ruta RELATIVA guardada en BD
        $rutaBD = "comprobantes/" . $nombre;

        $sql = "UPDATE inscripciones
                SET comprobante_pago = ?, estado_pago = 'En revisión'
                WHERE correo = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $rutaBD, $correo);
        $stmt->execute();

        header("Location: panel-alumno.php");
        exit;

    } else {
        die("Error al subir el archivo.");
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir comprobante</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body class="bg-light">

<div class="container my-5" style="max-width:500px;">
    <h4 class="mb-3">Subir comprobante de pago</h4>

    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="comprobante" class="form-control mb-3" required>
        <button class="btn btn-primary w-100">Enviar comprobante</button>
    </form>

    <a href="panel-alumno.php" class="btn btn-link mt-3">Volver</a>
</div>

<p class="text-center mt-3 mb-0 text-muted">
    © 2026 Preparatoria Iberoamericana
</p>

</body>
</html>