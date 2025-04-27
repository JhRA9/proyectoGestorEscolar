<?php
include('../../config.php');
$id_usuario = $_POST['id_usuario'];

$sentencia = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario=:id_usuario");

$sentencia->bindParam('id_usuario', $id_usuario);

if ($sentencia->execute()) {
    session_start();
    $_SESSION['mensaje'] = "Se elimino el rol de manera correcta";
    $_SESSION['icono'] = "success";
    header('location:' . APP_URL . "admin/usuarios");
} else {
    session_start();
    $_SESSION['mensaje'] = "Error al eliminar el rol";
    $_SESSION['icono'] = "error";
    header('location:' . APP_URL . "admin/usuarios/create.php");
}
