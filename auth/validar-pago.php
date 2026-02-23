<?php
session_start();
require_once __DIR__ . "/config/db.php";

/*
  Seguridad básica:
  solo administrador puede validar pagos
*/
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $clave = trim($_POST['clave_pago']);

    if ($clave === "") {
        $mensaje = "❌ Ingresa una clave bancaria.";
    } else {

        // Buscar inscripción por clave bancaria
        $sql = "SELECT id, estado_pago FROM inscripciones WHERE clave_pago = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $clave);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows === 1) {

            $row = $resultado->fetch_assoc();

            // Verificar si ya fue pagado
            if ($row['estado_pago'] === 'Pagado') {
                $mensaje = "⚠️ Este pago ya fue validado anteriormente.";
            } else {

                $idInscripcion = $row['id'];
                $adminId = $_SESSION['id'];

                // Marcar pago como pagado
                $update = $conn->prepare(
                    "UPDATE inscripciones
                     SET estado_pago = 'Pagado',
                         fecha_pago = NOW(),
                         validado_por = ?
                     WHERE id = ?"
                );
                $update->bind_param("ii", $adminId, $idInscripcion);
                $update->execute();

                $mensaje = "✅ Pago validado correctamente.";
            }

        } else {
            $mensaje = "❌ Clave bancaria no encontrada.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Validar Pago</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5" style="max-width: 480px;">
    <h4 class="mb-4 text-center">Validación de Pago Bancario</h4>

    <?php if ($mensaje): ?>
        <div class="alert alert-info text-center">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Clave bancaria</label>
            <input type="text"
                   name="clave_pago"
                   class="form-control"
                   placeholder="IBERO-2026-XXXXXXXX"
                   required>
        </div>

        <button class="btn btn-primary w-100">
            Validar Pago
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="panel-admin.php">← Volver al panel administrativo</a>
    </div>
</div>
 <p class="text-center mt-3 mb-0 text-muted">
                © 2026 Preparatoria Iberoamericana
            </p>

</body>
</html>