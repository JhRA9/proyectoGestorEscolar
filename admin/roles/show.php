<?php
$id_rol = $_GET['id'];
include('../../config/config.php');
include('../../config/autenticacion_rol.php');
include('../../admin/layout/parte1.php');
include('../../config/controllers/roles/datos_rol.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <br>
  <div class="content">
    <div class="container">
      <div class="row">
        <h1>Rol: <?= $nombre_rol; ?></h1>
      </div>
      <br>
      <div class="row">
        <div class="col-md-6">
          <div class="card card-outline card-info">
            <div class="card-header">
              <h3 class="card-title">Datos registrados</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label for="">Nombre del rol</label>
                    <p><?= $nombre_rol; ?></p>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <a href="<?= APP_URL; ?>admin/roles" class="btn btn-secondary">Volver</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include('../../admin/layout/parte2.php');
include('../../layout/mostrarMensajes.php');
?>