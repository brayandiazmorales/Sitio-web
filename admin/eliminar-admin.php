<?php
session_start();

require_once __DIR__ . '/../config/db.php';

/* Solo admin */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../auth/login-admin.php");
    exit;
}

$id = intval($_POST['id'] ?? 0);

/* No permitir borrar el admin actual */
if ($id === ($_SESSION['id'] ?? 0)) {
    header("Location: admins.php?error=propio");
    exit;
}

$sql = "DELETE FROM usuarios WHERE id = ? AND rol = 'admin'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admins.php");
exit;