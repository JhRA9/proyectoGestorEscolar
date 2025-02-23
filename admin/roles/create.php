<?php
include ('../../config/config.php');
include ('../../admin/layout/parte1.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <br>
      <div class="content">
      <div class="container">
        <div class="row">
          <h1>Creacion de nuevo rol</h1>
        </div>
        <br>
        <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title">Digite los datos</h3>
              </div>
              <div class="card-body">
                <form action="<?=APP_URL;?>config/controllers/roles/create.php" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Nombre del rol</label>
                            <input type="text" class="form-control" name="nombre_rol" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Guardar rol</button>
                            <a href="<?=APP_URL;?>admin/roles" class="btn btn-secondary">Cancelar</a>
                        </div>
                    </div>  
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php 
include ('../../admin/layout/parte2.php');
include ('../../layout/mostrarMensajes.php');
?>

