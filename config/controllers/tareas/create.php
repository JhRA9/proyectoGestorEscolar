<?php
include ('../../config.php');
include ('../../../observers/Subject.php');
include ('../../../observers/NotificacionObserver.php');


// PATRON OBSERVER

$subject = new Subject();
$notificacionObserver = new NotificacionObserver();
$subject->addObserver($notificacionObserver);

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

// Notificar la creación de la tarea
$mensaje = "Se ha creado una nueva tarea en la materia $nombre_materia: $titulo";
$subject->notifyObservers(['mensaje' => $mensaje, 'id_tarea' => $id_tarea]);

// Verificar si la tarea está próxima a vencer (por ejemplo, en 2 días)
$fecha_actual = new DateTime();
$fecha_entrega_dt = new DateTime($fecha_entrega);
$intervalo = $fecha_actual->diff($fecha_entrega_dt);

if ($intervalo->days <= 2 && $intervalo->invert == 0) {
    $mensaje_vencimiento = "La tarea '$titulo' de la materia '$nombre_materia' está próxima a vencer.";
    $subject->notifyObservers(['mensaje' => $mensaje_vencimiento, 'id_tarea' => $id_tarea]);
}

// Redirigir al usuario a la página de listado de tareas
header('Location: ' . APP_URL . 'admin/tareas/index.php');
exit();
?>