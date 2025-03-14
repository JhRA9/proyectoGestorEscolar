<?php
session_start();
if (!isset($_SESSION['sesion email'])) {
  header('location:' . APP_URL . "/login/index.php");
  return;
}

$email_sesion = $_SESSION['sesion email'];
$nombre_sesion_usuario = $_SESSION['name'];

$url_home = APP_URL . "/admin/";
if (in_array($_SESSION['role'], ['PROFESOR', 'ESTUDIANTE'])) {
  $url_home = APP_URL . "/admin/home.php";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= APP_NAME; ?>/</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= APP_URL; ?>/public/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= APP_URL; ?>/public/dist/css/adminlte.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <!-- DATATABLE -->
  <link rel="stylesheet" href="<?= APP_URL; ?>/public/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= APP_URL; ?>/public/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="<?= APP_URL; ?>/public/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <style>
    .dropdown-item {
      white-space: normal;
      word-wrap: break-word;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?= APP_URL; ?>/admin" class="nav-link"><?= APP_NAME; ?></a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="badge badge-warning navbar-badge count_notifications"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-header count_notifications"></span>
            <div class="dropdown-divider"></div>
            <div id="notifications"></div>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="<?= $url_home; ?>" class="brand-link">
        <img src="<?= APP_URL ?>/public/img/iconoPrincipal.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">San Francisco de Asís</span>
      </a>
      

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="<?= APP_URL ?>/public/img/usuarioAdmin.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?=$nombre_sesion_usuario;?></a>
          </div>
        </div>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <?php if ($_SESSION['role'] == 'ADMINISTRADOR'): ?>
              <li class="nav-item">
                <a href="#" class="nav-link active">

                  <p>
                    <i class="bi bi-bookmarks"></i>
                    Roles
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= APP_URL; ?>/admin/roles" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Listado de roles</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="#" class="nav-link active">
                  <p>
                    <i class="bi bi-people-fill"></i>
                    Usuarios
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= APP_URL; ?>/admin/usuarios" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Listado de usuarios</p>
                    </a>
                  </li>
                </ul>
              </li>
            <?php endif; ?>
            <li class="nav-item">
              <a href="#" class="nav-link active">
                <p>
                  <i class="bi bi-book-half"></i>
                  Materias
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= APP_URL; ?>/admin/materias" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Listado de materias</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="#" class="nav-link active">

                <p>
                  <i class="bi bi-plus-slash-minus"></i>
                  Tareas
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?= APP_URL; ?>/admin/tareas/" class="nav-link">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Listado de tareas</p>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-item">
              <a href="<?= APP_URL; ?>/login/logout.php" class="nav-link" style="background-color: #eb2d14;">
                <i class="bi bi-door-open"></i>
                <p>
                  Cerrar sesion
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- PATRON OBSERVER -->

    <script>
      function getNotifications() {
        fetch('/proyectoEscuela/config/controllers/notifications/', {
            method: 'GET',
            headers: {
              'Content-Type': 'application/json'
            }
          })
          .then(response => response.json())
          .then(data => {
            console.log('Notificaciones: ', data.length)
            const divNotifications = document.getElementById('notifications');
            divNotifications.innerHTML = '';
            for (const notification of data) {
              const a = document.createElement('a');
              a.href = `/proyectoEscuela/admin/tareas/show.php?id=${notification.id_tarea}`;
              a.className = 'dropdown-item';
              a.innerHTML = `
                <i class="fas fa-envelope mr-2"></i> ${notification.mensaje}
                <span class="float-right text-muted text-sm">${notification.fecha_creacion}</span>
              `;
              divNotifications.appendChild(a);

              const divDivider = document.createElement('div');
              divDivider.className = 'dropdown-divider';
              divNotifications.appendChild(divDivider);
            }
            divNotifications.innerHTML += `
              <a href="#" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
            `;

            const countNoti = document.getElementsByClassName('count_notifications');
            for (const count of countNoti) {
              count.innerHTML = data.length;
            }

          })
          .catch((error) => {
            console.error('Error:', error);
          });
      };

      setInterval(() => {
        getNotifications();
      }, 2_000);
    </script>