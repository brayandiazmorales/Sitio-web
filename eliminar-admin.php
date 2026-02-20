<?php
session_start();
require_once __DIR__ . "/config/db.php";

/* Solo admin */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = intval($_POST['id']);

/* No permitir borrar el admin actual */
if ($id === $_SESSION['id']) {
    header("Location: admins.php?error=propio");
    exit;
}

$sql = "DELETE FROM usuarios WHERE id = ? AND rol = 'admin'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admins.php");
exit;