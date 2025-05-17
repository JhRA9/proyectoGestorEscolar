<?php
// Me aseguro de que la sesión esté iniciada antes de continuar
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verifico si el usuario está autenticado
if (!isset($_SESSION['sesion email'])) {
    header('Location: ' . APP_URL . 'index.php');
    exit();
}

// Obtengo el rol del usuario
$role = $_SESSION['role'] ?? '';

// Valido si el usuario tiene acceso al módulo de tareas
if (!in_array($role, ['ADMINISTRADOR', 'PROFESOR', 'ESTUDIANTE'])) {
    header('Location: ' . APP_URL . 'admin/home.php'); // Redirigir si no tiene permiso
    exit();
}

// Validación adicional para restringir acceso según la página
$current_page = basename($_SERVER['PHP_SELF']); // Obtiene el nombre del archivo actual

// Restricción para la sección de roles
if (strpos($_SERVER['REQUEST_URI'], '/roles/') !== false && $role !== 'ADMINISTRADOR') {
    header('Location: ' . APP_URL . 'admin/home.php'); // Redirigir si no tiene permiso
    exit();
}

// Restricción para la página de creación de materias
if ($current_page === 'create.php' && !in_array($role, ['ADMINISTRADOR', 'PROFESOR'])) {
    header('Location: ' . APP_URL . 'admin/home.php'); // Redirigir si no tiene permiso
    exit();
}

// Restricción para la página de edición de materias
if ($current_page === 'edit.php' && !in_array($role, ['ADMINISTRADOR', 'PROFESOR'])) {
    header('Location: ' . APP_URL . 'admin/home.php'); // Redirigir si no tiene permiso
    exit();
}
?>