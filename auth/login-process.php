<?php
session_start();

require_once __DIR__ . '/../config/db.php';

/* 1. Recibir datos del formulario */
$correo   = trim($_POST['correo'] ?? '');
$password = trim($_POST['password'] ?? '');

/* 2. Validaciones básicas*/
if ($correo === '' || $password === '') {
    die("❌ Todos los campos son obligatorios.");
}

/* Solo correos institucionales */
if (!preg_match('/@ibero\.edu\.mx$/', $correo)) {
    die("❌ Acceso permitido solo con correos institucionales.");
}

/* . Encriptar contraseña*/
$passwordHash = hash('sha256', $password);

/* 4. Buscar usuario en BD */
$sql = "SELECT id, nombre, correo, rol 
        FROM usuarios 
        WHERE correo = ? AND password = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $correo, $passwordHash);
$stmt->execute();
$result = $stmt->get_result();

/* 5. Validar credenciales */
if ($result->num_rows === 1) {

    $usuario = $result->fetch_assoc();

    session_regenerate_id(true);

    $_SESSION['id']     = $usuario['id'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['correo'] = $usuario['correo'];
    $_SESSION['rol']    = $usuario['rol'];

    /* 6. Redirección por rol */
    if ($usuario['rol'] === 'admin') {
        header("Location: ../admin/panel-admin.php");
        exit;
    }

    if ($usuario['rol'] === 'alumno') {
        header("Location: ../alumno/panel-alumno.php");
        exit;
    }

    session_destroy();
    die("❌ Rol no autorizado.");

} else {
    die("❌ Correo o contraseña incorrectos.");
}