<?php
include ('../../config.php');

// Obtener los datos del formulario
$id_materia = $_POST['id_materia'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$fecha_entrega = $_POST['fecha_entrega'];
$hora_entrega = $_POST['hora_entrega'];

// Obtener el nombre de la materia
$sentencia = $pdo->prepare("SELECT nombre_materia FROM materias WHERE id_materia = ?");
$sentencia->execute([$id_materia]);
$materia = $sentencia->fetch(PDO::FETCH_ASSOC);
$nombre_materia = $materia['nombre_materia'];

// Insertar la nueva tarea en la base de datos
$sentencia = $pdo->prepare("INSERT INTO tareas (id_materia, titulo, descripcion, fecha_entrega, hora_entrega, estado) VALUES (?, ?, ?, ?, ?, 'Pendiente')");
$sentencia->execute([$id_materia, $titulo, $descripcion, $fecha_entrega, $hora_entrega]);

// Obtener el ID de la tarea recién creada
$id_tarea = $pdo->lastInsertId();


// Agregar notificación
$mensaje = "Se ha creado una nueva tarea en la materia $nombre_materia: $titulo";
$sentencia = $pdo->prepare("INSERT INTO notificaciones (mensaje, id_tarea) VALUES (?, ?)");
$sentencia->execute([$mensaje, $id_tarea]);

// Redirigir al usuario a la página de listado de tareas
header('Location: ' . APP_URL . 'admin/tareas/index.php');
exit();
?>