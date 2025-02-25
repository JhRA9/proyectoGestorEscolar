<?php
$sentencia = $pdo->prepare("
    SELECT t.*, m.nombre_materia AS materia 
    FROM tareas t 
    LEFT JOIN materias m ON t.id_materia = m.id_materia
");
$sentencia->execute();
$tareas = $sentencia->fetchAll(PDO::FETCH_ASSOC);
?>