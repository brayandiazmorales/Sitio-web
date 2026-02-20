<?php
session_start();
require_once __DIR__ . "/config/db.php";

if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = intval($_GET['id']);

$sql = "UPDATE inscripciones
        SET estado_pago = 'Pagado',
            fecha_pago = NOW()
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: panel-admin.php");
exit;