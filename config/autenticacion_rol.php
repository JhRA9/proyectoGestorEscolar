<?php
// Me aseguro de que la sesión esté iniciada antes de continuar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifico si el usuario está autenticado
if (!isset($_SESSION['sesion email'])) {
    header('Location: ' . APP_URL . '/login/index.php');
    exit();
}

// Obtengo el rol del usuario
$role = $_SESSION['role'] ?? '';

// Valido si el usuario tiene acceso al módulo de tareas
if (!in_array($role, ['ADMINISTRADOR', 'PROFESOR', 'ESTUDIANTE'])) {
    header('Location: ' . APP_URL . '/admin/home.php'); // Redirigir si no tiene permiso
    exit();
}
?>