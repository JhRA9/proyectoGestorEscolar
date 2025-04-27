<?php

$id_tarea = $_GET['id'];
$sentencia = $pdo->prepare("SELECT * FROM tareas WHERE id_tarea = :id_tarea");
$sentencia->bindParam(':id_tarea', $id_tarea);
$sentencia->execute();
$tarea = $sentencia->fetch(PDO::FETCH_ASSOC);
