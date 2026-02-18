<?php
require_once __DIR__ . "/config/db.php";

$id = intval($_GET['id']);

/* 1. Obtener semestre y turno del alumno */
$sqlDatos = "SELECT semestre, turno FROM inscripciones WHERE id = ?";
$stmtDatos = $conn->prepare($sqlDatos);
$stmtDatos->bind_param("i", $id);
$stmtDatos->execute();
$resultDatos = $stmtDatos->get_result();
$datos = $resultDatos->fetch_assoc();

$semestre = $datos['semestre'];
$turno    = $datos['turno'];

/* 2. Contar alumnos por grupo */
$grupos = ['A', 'B', 'C'];
$conteo = [];

foreach ($grupos as $grupo) {
    $sql = "SELECT COUNT(*) AS total 
            FROM inscripciones 
            WHERE semestre = ? AND turno = ? AND grupo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $semestre, $turno, $grupo);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    $conteo[$grupo] = $res['total'];
}

/* 3. Asignar el grupo con menos alumnos */
asort($conteo);
$grupoAsignado = array_key_first($conteo);

/* 4. Actualizar inscripción */
$sqlUpdate = "UPDATE inscripciones 
              SET estado = 'Validado', grupo = ?
              WHERE id = ?";
$stmtUpdate = $conn->prepare($sqlUpdate);
$stmtUpdate->bind_param("si", $grupoAsignado, $id);
$stmtUpdate->execute();

/* 5. Regresar al panel admin */
header("Location: panel-admin.php");
exit;