<?php
include ('../../config/config.php');
include ('../../admin/layout/parte1.php');
include ('../layout/parte1.php');
?>

<!-- Formulario para crear un nuevo rol -->
<div class="content-wrapper">
  <br>
  <div class="content">
      <div class="container">
          <div class="row">
              <div class="col-md-6">
                  <div class="card card-primary shadow-none">
                      <div class="card-header">
                          <h3 class="card-title">Crear nuevo rol</h3>
                      </div>
                      <div class="card-body">
                          <form action="store.php" method="POST">
                              <div class="form-group">
                                  <label for="nombre_rol">Nombre del rol</label>
                                  <input type="text" name="nombre_rol" id="nombre_rol" class="form-control" required>
                              </div>
                              <button type="submit" class="btn btn-primary">Guardar</button>
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

