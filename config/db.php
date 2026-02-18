<?php
// Datos de conexión
$host = "localhost";
$user = "root";
$pass = ""; // En XAMPP la contraseña está vacía
$db   = "sistema_inscripciones";

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}