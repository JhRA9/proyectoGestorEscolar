<?php
$sql_usuarios = "SELECT * FROM usuarios as usu INNER JOIN roles as rol on rol.id_rol = usu.rol_id WHERE usu.estado = '1' and usu.id_usuario = '$id_usuario'";
// lo que estoy haciendo con inner join es traer los datos de la tabla roles que estan relacionados con la tabla usuarios, esto me permite traer el nombre del rol en lugar del id del rol

$query_usuarios = $pdo->prepare($sql_usuarios);
$query_usuarios->execute();
$usuarios = $query_usuarios->fetchAll(PDO::FETCH_ASSOC);

foreach($usuarios as $usuario) {
    $nombres = $usuario['nombres'];
    $nombre_rol = $usuario['nombre_rol'];
    $email = $usuario['email'];
    $password = $usuario['password'];
    $fechaHora = $usuario['hora_creacion'];
    $estado = $usuario['estado'];
    }
