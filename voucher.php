<?php
// ID de la inscripción (por ahora fijo para pruebas)
// Más adelante se tomará desde sesión
$id = 1;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Inscripción</title>
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
    <div class="card mx-auto voucher-card">
        <div class="card-body p-4">

            <h4 class="text-center mb-3">Comprobante de Inscripción</h4>
            <hr>

            <p><strong>Nombre:</strong> Alumno Iberoamericano</p>
            <p><strong>Matrícula:</strong> 2026-0001</p>
            <p><strong>Semestre:</strong> 1°</p>
            <p><strong>Turno:</strong> Matutino</p>
            <p><strong>Monto:</strong> $3,500.00 MXN</p>

            <div class="alert alert-info">
                Este comprobante deberá presentarse para la validación del pago.
            </div>

            <div class="d-flex justify-content-end gap-2 no-print">
                <button type="button" class="btn btn-secondary" onclick="window.print()">
                    Imprimir
                </button>

                <!-- ✅ ESTE BOTÓN SÍ DESCARGA EL PDF -->
                <a href="voucher-pdf.php?id=<?= $id ?>" class="btn btn-primary">
                    Descargar PDF
                </a>
            </div>

        </div>
    </div>
</div>

</body>
</html>