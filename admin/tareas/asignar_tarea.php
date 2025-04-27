<?php
session_start();
include('../../config/config.php');
include('../../config/autenticacion_rol.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_materia = $_POST['id_materia'];
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $fecha_entrega = $_POST['fecha_entrega'];

    $sentencia = $pdo->prepare("INSERT INTO tareas (id_materia, titulo, descripcion, fecha_entrega, estado) VALUES (?, ?, ?, ?, 'Pendiente')");
    $sentencia->execute([$id_materia, $titulo, $descripcion, $fecha_entrega]);

    header('Location: index.php');
    exit();
}
