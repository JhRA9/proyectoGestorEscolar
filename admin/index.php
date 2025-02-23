<?php
include('../config/config.php');
include('layout/parte1.php');
include('../config/controllers/roles/listado_roles.php');
include('../config/controllers/usuarios/listado_usuarios.php');
include('../config/controllers/materias/listado_de_materias.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <br>
  <div class="container">
    <div class="container">
      <div class="row">
        <h1><?= APP_NAME; ?></h1>
      </div>
      <br>
      <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-primary">
            <div class="inner">

              <?php
              $contador_rol = 0;
              foreach ($roles as $role) {
                $contador_rol++;
              }
              ?>

              <h3><?= $contador_rol; ?></h3>

              <p>Roles registrados</p>
            </div>
            <div class="icon">
              <i class="fas bi-bookmarks"></i>
            </div>
            <a href="<?= APP_URL; ?>/admin/roles" class="small-box-footer">
              Mas informacion <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-info">
            <div class="inner">

              <?php
              $contador_usuarios = 0;
              foreach ($usuarios as $usuario) {
                $contador_usuarios++;
              }
              ?>

              <h3><?= $contador_usuarios; ?></h3>

              <p>Usuarios registrados</p>
            </div>
            <div class="icon">
              <i class="fas bi-people-fill"></i>
            </div>
            <a href="<?= APP_URL; ?>/admin/usuarios" class="small-box-footer">
              Mas informacion <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <div class="small-box bg-danger">
            <div class="inner">
              <?php
              $contador_materias = 0;
              foreach ($materias as $materia) {
                $contador_materias = $contador_materias + 1;
              }
              ?>
              <h3><?= $contador_materias; ?></h3>
              <p>Materias registrados</p>
            </div>
            <div class="icon">
              <i class="fas"><i class="bi bi-bookshelf"></i></i></i>
            </div>
            <a href="<?= APP_URL; ?>/admin/materias" class="small-box-footer">
              Más información <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('../admin/layout/parte2.php');
include('../layout/mostrarMensajes.php');
?>