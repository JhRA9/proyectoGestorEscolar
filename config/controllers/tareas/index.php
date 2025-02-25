<?php
$sentencia = $pdo->prepare("SELECT * FROM tareas");
$sentencia->execute();
$tareas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>  