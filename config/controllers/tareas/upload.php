<?php
include ('../../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_tarea = $_POST['id_tarea'];
    $archivo = $_FILES['archivo'];

    $sentencia = $pdo->prepare("SELECT * FROM tareas WHERE id_tarea = ?");
    $sentencia->execute([$id_tarea]);
    $tarea = $sentencia->fetch(PDO::FETCH_ASSOC);

    $fecha_actual = date('Y-m-d');
    $hora_actual = date('H:i:s');

    if ($fecha_actual > $tarea['fecha_entrega'] || ($fecha_actual == $tarea['fecha_entrega'] && $hora_actual > $tarea['hora_entrega'])) {
        echo "La fecha y hora de entrega han pasado. No puedes subir archivos.";
        exit();
    }

    $directorio = '../../uploads/';
    if (!is_dir($directorio)) {
        mkdir($directorio, 0777, true);
    }
    $ruta_archivo = $directorio . basename($archivo['name']);

    if (move_uploaded_file($archivo['tmp_name'], $ruta_archivo)) {
        $sentencia = $pdo->prepare("INSERT INTO archivos (id_tarea, ruta_archivo) VALUES (?, ?)");
        $sentencia->execute([$id_tarea, $ruta_archivo]);

        header('Location: ' . APP_URL . 'admin/tareas/index.php');
        exit();
    } else {
        echo "Hubo un error al subir el archivo.";
    }
}
?>