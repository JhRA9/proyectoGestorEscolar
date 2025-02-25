<?php
include ('../../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_materia = $_POST['id_materia'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_entrega = $_POST['fecha_entrega'];
    $hora_entrega = $_POST['hora_entrega'];

    $sentencia = $pdo->prepare("INSERT INTO tareas (id_materia, titulo, descripcion, fecha_entrega, hora_entrega, estado) VALUES (?, ?, ?, ?, ?, 'Pendiente')");
    $sentencia->execute([$id_materia, $titulo, $descripcion, $fecha_entrega, $hora_entrega]);

    header('location:' . APP_URL . "admin/tareas/index.php");
    exit();
}
?>