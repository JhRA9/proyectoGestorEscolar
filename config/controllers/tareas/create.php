<?php
include('../../config.php');
session_start();

$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_entrega = $_POST['fecha_entrega'];
$estado = 'pendiente';
$fechaHora = date('Y-m-d H:i:s'); // Obtener la hora actual

$sentencia = $pdo->prepare("INSERT INTO tareas (titulo, descripcion, fecha_entrega, estado, hora_creacion) VALUES (:titulo, :descripcion, :fecha_entrega, :estado, :hora_creacion)");

$sentencia->bindParam(':titulo', $titulo);
$sentencia->bindParam(':descripcion', $descripcion);
$sentencia->bindParam(':fecha_entrega', $fecha_entrega);
$sentencia->bindParam(':estado', $estado);
$sentencia->bindParam(':hora_creacion', $fechaHora);

if ($sentencia->execute()) {
    $_SESSION['mensaje'] = "Tarea creada correctamente";
    $_SESSION['icono'] = "success";
} else {
    $_SESSION['mensaje'] = "Error al crear la tarea";
    $_SESSION['icono'] = "error";
}

header('Location: ' . APP_URL . 'admin/tareas');
exit();
?>