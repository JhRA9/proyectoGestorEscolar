<?php
$sentencia = $pdo->prepare("
    SELECT t.*, m.nombre_materia AS materia, a.ruta_archivo 
    FROM tareas t 
    LEFT JOIN materias m ON t.id_materia = m.id_materia
    LEFT JOIN archivos a ON t.id_tarea = a.id_tarea
");
$sentencia->execute();
$tareas = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');

foreach ($tareas as $tarea) {
    if ($tarea['estado'] == 'pendiente' && $fecha_actual > $tarea['fecha_entrega']) {
        $sentencia = $pdo->prepare("UPDATE tareas SET estado = 'No entrego' WHERE id_tarea = ?");
        $sentencia->execute([$tarea['id_tarea']]);
    }
}
