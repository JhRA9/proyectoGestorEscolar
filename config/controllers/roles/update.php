<?php
include('../../config.php');

$id_rol = $_POST['id_rol'];
$nombre_rol = $_POST['nombre_rol'];
$nombre_rol = mb_strtoupper($nombre_rol, 'UTF-8');

if($nombre_rol == "") {
    session_start();
    $_SESSION['mensaje'] = "El nombre del rol es requerido";
    $_SESSION['icono'] = "error";
    header('location:'.APP_URL."admin/roles/edit.php?id=".$id_rol);
}else{

$sentencia = $pdo->prepare("UPDATE roles SET nombre_rol=:nombre_rol, hora_actualizacion=:hora_actualizacion WHERE id_rol = :id_rol");

$sentencia->bindParam('nombre_rol', $nombre_rol);
$sentencia->bindParam('hora_actualizacion', $fechaHora);
$sentencia->bindParam('id_rol', $id_rol);

try{
    if($sentencia->execute()) {
        session_start();
        $_SESSION['mensaje'] = "Se actualiza el rol de manera correcta";
        $_SESSION['icono'] = "success";
        header('location:'.APP_URL."admin/roles");
    } else {
        session_start();
        $_SESSION['mensaje'] = "Error al actualizar el rol";
        $_SESSION['icono'] = "error";
        header('location:'.APP_URL."admin/roles/edit.php?id=".$id_rol);
    }
}
catch(PDOException $e) {
        session_start();
        $_SESSION['mensaje'] = "Este rol ya existe";
        $_SESSION['icono'] = "error";
        header('location:'.APP_URL."admin/roles/edit.php?id=".$id_rol);
}
}
?>
