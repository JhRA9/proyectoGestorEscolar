<?php

$sql_materias = "SELECT * FROM materias where estado = '1' and id_materia = '$id_materia'  ";
$query_materias = $pdo->prepare($sql_materias);
$query_materias->execute();
$materias = $query_materias->fetchAll(PDO::FETCH_ASSOC);

foreach ($materias as $materia){
    $nombre_materia = $materia['nombre_materia'];
    $hora_creacion = $materia['hora_creacion'];
    $estado = $materia['estado'];
}