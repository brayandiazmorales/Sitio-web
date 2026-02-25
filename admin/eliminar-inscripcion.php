<?php
session_start();

/* Conexión a la base de datos */
require_once __DIR__ . "/../config/db.php";

/* Seguridad: solo admin */
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

/* Validar que venga por POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: panel-admin.php");
    exit;
}

$id = intval($_POST['id']);

if ($id <= 0) {
    header("Location: panel-admin.php");
    exit;
}

/* Eliminar inscripción */
$sql = "DELETE FROM inscripciones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();

/* Redirigir al panel */
header("Location: panel-admin.php");
exit;