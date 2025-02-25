<?php
include ('../../config/config.php');
include ('../layout/parte1.php');
include('../../config/controllers/tareas/index.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Listado de Tareas</h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <a href="create.php" class="btn btn-primary">Crear Tarea</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Descripción</th>
                                <th>Fecha de Entrega</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($tareas as $tarea): ?>
                                <tr>
                                    <td><?= $tarea['id_tarea'] ?></td>
                                    <td><?= $tarea['titulo'] ?></td>
                                    <td><?= $tarea['descripcion'] ?></td>
                                    <td><?= $tarea['fecha_entrega'] ?></td>
                                    <td><?= $tarea['estado'] ?></td>
                                    <td>
                                        <a href="show.php?id=<?= $tarea['id_tarea'] ?>" class="btn btn-info">Ver</a>
                                        <a href="edit.php?id=<?= $tarea['id_tarea'] ?>" class="btn btn-warning">Editar</a>
                                        <form action="<?= APP_URL; ?>/config/controllers/tareas/delete.php" method="POST" style="display:inline;">
                                            <input type="hidden" name="id_tarea" value="<?= $tarea['id_tarea'] ?>">
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include ('../../admin/layout/parte2.php');
include ('../../layout/mostrarMensajes.php');
?>