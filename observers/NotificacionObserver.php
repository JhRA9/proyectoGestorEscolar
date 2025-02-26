<?php
include('Observer.php');
include('../config/config.php');

class NotificacionObserver implements Observer {
    public function update($eventData) {
        global $pdo;
        $mensaje = $eventData['mensaje'];
        $id_tarea = $eventData['id_tarea'];
        $sentencia = $pdo->prepare("INSERT INTO notificaciones (mensaje, id_tarea) VALUES (?, ?)");
        $sentencia->execute([$mensaje, $id_tarea]);
    }
}
?>