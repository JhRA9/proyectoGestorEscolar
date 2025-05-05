<?php

use Dom\Entity;

include('../config/config.php');
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE email = '$email' AND estado = '1'";
$query = $pdo->prepare($sql);
$query->execute();

$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

if (count($usuarios) > 0) {
    $user = $usuarios[0];
    if (!empty($user) && (password_verify($password, $user['password']))) {
        session_start();
        $_SESSION['mensaje'] = "Bienvenido al sistema";
        $_SESSION['icono'] = "success";
        $_SESSION['sesion email'] = $email;
        $_SESSION['name'] = $user['nombres'];

        $sql_role = "SELECT * FROM roles WHERE id_rol = " . $user['rol_id'];
        $query = $pdo->prepare($sql_role);
        $query->execute();
        $role = $query->fetchAll(PDO::FETCH_ASSOC);
        if (count($role) > 0) {
            $_SESSION['role'] = $role[0]['nombre_rol'];
        } else {
            $_SESSION['role'] = '';
        }

        if ($role === 'ADMINISTRADOR') {
            header('location:' . APP_URL . "/admin/index.php");
        } else {
            header('location:' . APP_URL . "/admin/home.php");
        }
        return;
    }
}

session_start();
$_SESSION['mensaje'] = "Los datos son incorrectos, porfavor verifiquelos y vuelva a intentarlo";
header('location:' . APP_URL . "/login/index.php");
exit();
?>
