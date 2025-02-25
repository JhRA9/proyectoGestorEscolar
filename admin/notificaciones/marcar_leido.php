<?php
include ('../../config/config.php');

$id_notificacion = $_GET['id'];

$sentencia = $pdo->prepare("UPDATE notificaciones SET leido = TRUE WHERE id = ?");
$sentencia->execute([$id_notificacion]);

header('Location: ' . APP_URL . '/admin');
exit();
?>