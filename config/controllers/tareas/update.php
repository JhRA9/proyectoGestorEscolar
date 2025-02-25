<?php
include('../../config.php');
session_start();

$id_tarea = $_POST['id_tarea'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_entrega = $_POST['fecha_entrega'];
$estado = $_POST['estado'];
$id_materia = $_POST['id_materia'];
$fechaHora = date('Y-m-d H:i:s'); // Obtener la hora actual

$sentencia = $pdo->prepare("UPDATE tareas SET titulo = :titulo, descripcion = :descripcion, fecha_entrega = :fecha_entrega, estado = :estado, id_materia = :id_materia, hora_actualizacion = :hora_actualizacion WHERE id_tarea = :id_tarea");

$sentencia->bindParam(':titulo', $titulo);
$sentencia->bindParam(':descripcion', $descripcion);
$sentencia->bindParam(':fecha_entrega', $fecha_entrega);
$sentencia->bindParam(':estado', $estado);
$sentencia->bindParam(':id_materia', $id_materia);
$sentencia->bindParam(':hora_actualizacion', $fechaHora);
$sentencia->bindParam(':id_tarea', $id_tarea);

if ($sentencia->execute()) {
    $_SESSION['mensaje'] = "Tarea actualizada correctamente";
    $_SESSION['icono'] = "success";
} else {
    $_SESSION['mensaje'] = "Error al actualizar la tarea";
    $_SESSION['icono'] = "error";
}

header('Location: ' . APP_URL . 'admin/tareas');
exit();
?>