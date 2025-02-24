<?php

include('../../config.php');

$nombre_materia = $_POST['nombre_materia'];

$sentencia = $pdo->prepare('INSERT INTO materias
(nombre_materia,hora_creacion, estado)
VALUES ( :nombre_materia,:hora_creacion,:estado)');

$sentencia->bindParam(':nombre_materia',$nombre_materia);
$sentencia->bindParam('hora_creacion',$fechaHora);
$sentencia->bindParam('estado',$estadoRegistro);

if($sentencia->execute()){
    echo 'success';
    session_start();
    $_SESSION['mensaje'] = "Se registro la materia de la manera correcta en la base de datos";
    $_SESSION['icono'] = "success";
    header('Location:'.APP_URL."/admin/materias");
}else{
    echo 'error al registrar a la base de datos';
    session_start();
    $_SESSION['mensaje'] = "Error no se pudo registrar en la base datos, comuniquese con el administrador";
    $_SESSION['icono'] = "error";
    ?><script>window.history.back();</script><?php
}