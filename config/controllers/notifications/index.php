<?php
include('../../config.php');

$sql = "SELECT * FROM notificaciones";
$query = $pdo->prepare($sql);
$query->execute();
$notifications = $query->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM notificaciones";
$query = $pdo->prepare($sql);
$query->execute();
$notifications = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($notifications);
