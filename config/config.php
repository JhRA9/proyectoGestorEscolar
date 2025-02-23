<?php

// VARIABLES GLOBALES


    // ACCESO A LA BASE DE DATOS
    define('SERVIDOR', 'localhost');
    define('USUARIO', 'root');
    define('PASSWORD', '');
    define('BD', 'sistemaescolar');

    // RUTAS
    define('APP_NAME', 'SISTEMA DE GESTION ESCOLAR');
    define('APP_URL','http://localhost/proyectoEscuela/');
    // define('KEY_API_MAPS','');

    // CONEXION BD

    $servidor = "mysql:dbname=".BD.";host=".SERVIDOR;

    try {
        $pdo = new PDO($servidor, USUARIO, PASSWORD);
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");        
        // echo "Conexion exitosa a la base de datos";
    }catch (PDOException $e){
        print_r("Error: ".$e->getMessage());
        echo "Error al conectar a la base de datos";
    }

    // HORA DEL SERVIDOR
    date_default_timezone_set('America/Bogota');
    $fechaHora = date('Y-m-d H:i:s');
    $fechaActual = date('Y-m-d');
    $diaActual = date('d');
    $mesActual = date('m');
    $anioActual = date('Y');
    $estadoRegistro = 1;

    // echo "Se recuerda que la semana pasada se dejo una tarea para el dia ".$diaActual." del mes ".$mesActual." del año ".$anioActual;