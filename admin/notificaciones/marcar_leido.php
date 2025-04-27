<?php
include('../../config/config.php');
include('../../config/autenticacion_rol.php');
$id_notificacion = $_GET['id'];
$sentencia = $pdo->prepare("UPDATE notificaciones SET leido = TRUE WHERE id = ?");
$sentencia->execute([$id_notificacion]);
header('Location: ' . APP_URL . '/admin');
exit();
