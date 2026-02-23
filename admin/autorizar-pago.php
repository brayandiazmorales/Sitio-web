<?php
session_start();

require_once __DIR__ . '/../config/db.php';

/* Seguridad: solo admin */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../auth/login-admin.php");
    exit;
}

/* Validar ID */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido");
}

$id = (int) $_GET['id'];

/* Actualizar estado de pago */
$sql = "UPDATE inscripciones
        SET estado_pago = 'Pagado',
            fecha_pago = NOW()
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

/* Confirmar que sí se actualizó */
if ($stmt->affected_rows === 0) {
    die("No se actualizó ningún registro. Revisa el ID.");
}

header("Location: panel-admin.php");
exit;