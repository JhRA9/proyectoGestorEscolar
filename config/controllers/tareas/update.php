<?php
include ('../../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tarea = $_POST['id_tarea'];
    $id_materia = $_POST['id_materia'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $hora_entrega = $_POST['hora_entrega'];
    $estado = $_POST['estado'];

    $sentencia = $pdo->prepare("UPDATE tareas SET id_materia = ?, titulo = ?, descripcion = ?, fecha_entrega = ?, hora_entrega = ?, estado = ? WHERE id_tarea = ?");
    $sentencia->execute([$id_materia, $titulo, $descripcion, $fecha_entrega, $hora_entrega, $estado, $id_tarea]);

    header('Location: ' . APP_URL . 'admin/tareas/index.php');
    exit();
}
?>