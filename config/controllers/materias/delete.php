<?php
include('../../config.php');
$id_materia = $_POST['id_materia'];

$sentencia = $pdo->prepare("DELETE FROM materias where id_materia=:id_materia ");

$sentencia->bindParam('id_materia', $id_materia);


if ($sentencia->execute()) {
    session_start();
    $_SESSION['mensaje'] = "Se elimino la materia de la manera correcta en la base de datos";
    $_SESSION['icono'] = "success";
    header('Location:' . APP_URL . "/admin/materias");
} else {
    session_start();
    $_SESSION['mensaje'] = "Error no se pudo eliminar en la base datos, comuniquese con el administrador";
    $_SESSION['icono'] = "error";
    header('Location:' . APP_URL . "/admin/materias");
}
