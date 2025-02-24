<?php

include('../../config.php');

$nombres = $_POST['nombres'];
$rol_id = $_POST['rol_id'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_repeat = $_POST['password_repeat'];

if ($password == $password_repeat) {
    $password = password_hash($password, PASSWORD_DEFAULT);

    $sentencia = $pdo->prepare('INSERT INTO usuarios (nombres, rol_id, email, password, hora_creacion, estado) VALUES ( :nombres,:rol_id,:email,:password, :hora_creacion, :estado)');

    $sentencia->bindParam(':nombres', $nombres);
    $sentencia->bindParam(':rol_id', $rol_id);
    $sentencia->bindParam(':email', $email);
    $sentencia->bindParam(':password', $password);
    $sentencia->bindParam('hora_creacion', $fechaHora);
    $sentencia->bindParam('estado', $estadoRegistro);

    try {
        if ($sentencia->execute()) {
            session_start();
            $_SESSION['mensaje'] = "Usuario registrado correctamente";
            $_SESSION['icono'] = "success";
            header('Location: ' . APP_URL . 'admin/usuarios/index.php');
        } else {
            session_start();
            $_SESSION['mensaje'] = "El usuario no se pudo registrar";
            $_SESSION['icono'] = "error";
            header('Location: ' . APP_URL . 'admin/usuarios/index.php');
        }
}catch (PDOException $e) {
    session_start();
    $_SESSION['mensaje'] = "El email del usuario ya existe en la base de datos";
    $_SESSION['icono'] = "error";
    header('Location: ' . APP_URL . 'admin/usuarios/create.php');
}
}
else {
    session_start();
    $_SESSION['mensaje'] = "Las contraseñas no coinciden";
    $_SESSION['icono'] = "error";
    header('Location: ' . APP_URL . 'admin/usuarios/create.php');
}


