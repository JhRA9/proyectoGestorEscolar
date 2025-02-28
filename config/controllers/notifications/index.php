<?php
include ('../../config.php');

$sql = "SELECT * FROM notificaciones";
$query = $pdo->prepare($sql);
$query->execute();
$notifications = $query->fetchAll(PDO::FETCH_ASSOC);

// Validate each notification to see if it is soon to expire
foreach ($notifications as $key => $notification) {
    // Pregunta si la notificacion tiene un dia menos de vigencia
    

    // Crea una nueva notificacion que diga que esta proximo a vencerse y la inserta en la base de datos

}

$sql = "SELECT * FROM notificaciones";
$query = $pdo->prepare($sql);
$query->execute();
$notifications = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($notifications);