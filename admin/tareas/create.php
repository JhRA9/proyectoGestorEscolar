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
                <h1>Crear Tarea</h1>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Digite los datos</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= APP_URL; ?>config/controllers/tareas/create.php" method="POST">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Título</label>
                                            <input type="text" class="form-control" name="titulo" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Descripción</label>
                                            <textarea class="form-control" name="descripcion" required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Fecha de Entrega</label>
                                            <input type="date" class="form-control" name="fecha_entrega" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Guardar Tarea</button>
                                            <a href="<?= APP_URL; ?>admin/tareas" class="btn btn-secondary">Cancelar</a>
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