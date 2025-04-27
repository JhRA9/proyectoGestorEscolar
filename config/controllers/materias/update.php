<?php
include('../../config.php');
$id_materia = $_POST['id_materia'];
$nombre_materia = $_POST['nombre_materia'];

$sentencia = $pdo->prepare('UPDATE materias
 SET nombre_materia=:nombre_materia,
     hora_actualizacion=:hora_actualizacion
WHERE id_materia=:id_materia ');

$sentencia->bindParam(':nombre_materia', $nombre_materia);
$sentencia->bindParam(':hora_actualizacion', $fechaHora);
$sentencia->bindParam(':id_materia', $id_materia);

if ($sentencia->execute()) {
    echo 'success';
    session_start();
    $_SESSION['mensaje'] = "Se actualizó la materia de la manera correcta en la base de datos";
    $_SESSION['icono'] = "success";
    header('Location:' . APP_URL . "/admin/materias");
} else {
    echo 'error al registrar a la base de datos';
    session_start();
    $_SESSION['mensaje'] = "Error no se pudo actualizar en la base datos, comuniquese con el administrador";
    $_SESSION['icono'] = "error";
?><script>
        window.history.back();
    </script><?php
            }
