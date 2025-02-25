<?php
include('../../config.php');
session_start();

$id_tarea = $_POST['id_tarea'];

// Eliminar los archivos asociados a la tarea
$sentencia = $pdo->prepare("DELETE FROM archivos WHERE id_tarea = :id_tarea");
$sentencia->bindParam(':id_tarea', $id_tarea);
$sentencia->execute();

// Eliminar la tarea
$sentencia = $pdo->prepare("DELETE FROM tareas WHERE id_tarea = :id_tarea");
$sentencia->bindParam(':id_tarea', $id_tarea);

if ($sentencia->execute()) {
    $_SESSION['mensaje'] = "Tarea eliminada correctamente";
    $_SESSION['icono'] = "success";
} else {
    $_SESSION['mensaje'] = "Error al eliminar la tarea";
    $_SESSION['icono'] = "error";
}

header('Location: ' . APP_URL . 'admin/tareas/index.php');
exit();
?>