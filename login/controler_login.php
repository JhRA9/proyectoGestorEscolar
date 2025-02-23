<?php
include ('../config/config.php');
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM usuarios WHERE email = '$email' AND estado = '1'";
$query = $pdo->prepare($sql);
$query->execute();

$usuarios = $query->fetchAll(PDO::FETCH_ASSOC);

// print_r($usuarios);

$usuarioExiste = 0;

foreach ($usuarios as $usuario) {
    $password_tabla = $usuario['password'];
    $usuarioExiste++;
}
if ( ($usuarioExiste > 0) && ($password === $password_tabla) ){
    session_start();
    $_SESSION['mensaje'] = "Bienvenido al sistema";
    $_SESSION['icono'] = "success";
    $_SESSION['sesion email'] = $email;
    // lo que estoy haciendo con sesion email es
    header('location:'.APP_URL."/admin/index.php");
} else {
    header('location:'.APP_URL."/login/index.php");
    session_start();
    $_SESSION['mensaje'] = "Los datos son incorrectos, porfavor verifiquelos y vuelva a intentarlo";
}
?>