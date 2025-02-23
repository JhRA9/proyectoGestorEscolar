<?php

$id_rol = $_GET['id'];

include ('../../config/config.php');
include ('../../admin/layout/parte1.php');
include ('../../config/controllers/roles/datos_rol.php');

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <br>
      <div class="content">
      <div class="container">
        <div class="row">
          <h1>Rol: <?=$nombre_rol;?></h1>
        </div>
        <br>
        <div class="row">
        <div class="col-md-6">
            <div class="card card-outline card-success">
              <div class="card-header">
                <h3 class="card-title">Editar el rol: <?=$nombre_rol;?></h3>
              </div>
              <div class="card-body">
                <form action="<?=APP_URL;?>config/controllers/roles/update.php" method="POST">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="">Nombre del rol</label>
                            <input type="text" name="id_rol" value="<?=$id_rol;?>" hidden>
                            <input name="nombre_rol" type="text" class="form-control" value="<?=$nombre_rol;?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                        <button type="submit" class="btn btn-success">Actualizar</button>
                        <a href="<?=APP_URL;?>admin/roles" class="btn btn-secondary">Volver</a>
                        </div>
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
<?php 
include ('../../admin/layout/parte2.php');
include ('../../layout/mostrarMensajes.php');
?>