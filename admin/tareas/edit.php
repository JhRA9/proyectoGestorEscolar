<?php
include ('../../config/config.php');
include ('../../admin/layout/parte1.php');
include ('../../config/controllers/tareas/edit.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Editar Tarea</h1>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Digite los datos</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= APP_URL; ?>config/controllers/tareas/update.php" method="POST">
                                <input type="hidden" name="id_tarea" value="<?= $tarea['id_tarea'] ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Título</label>
                                            <input type="text" class="form-control" name="titulo" value="<?= $tarea['titulo'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Descripción</label>
                                            <textarea class="form-control" name="descripcion" required><?= $tarea['descripcion'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Fecha de Entrega</label>
                                            <input type="date" class="form-control" name="fecha_entrega" value="<?= $tarea['fecha_entrega'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Estado</label>
                                            <select class="form-control" name="estado" required>
                                                <option value="pendiente" <?= $tarea['estado'] == 'pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                                <option value="completada" <?= $tarea['estado'] == 'completada' ? 'selected' : '' ?>>Completada</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Actualizar Tarea</button>
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