<?php
include '../../config/config.php';
include('../layout/parte1.php');
include('../../config/controllers/tareas/index.php');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Listado de Tareas</h1><br>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary shadow-none">
                        <div class="card-header">
                            <h3 class="card-title">Tareas registradas</h3>
                            <div class="card-tools">
                                <?php if (in_array($_SESSION['role'], ['ADMINISTRADOR', 'PROFESOR'])): ?>
                                    <a href="create.php" class="btn btn-dark"> <i class="bi bi-plus-square"></i> Crear nueva tarea </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Mostrar mensaje con SweetAlert -->
                            <?php include('../../layout/mostrarMensajes.php'); ?>
                            
                            <table id="example1" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Título</th>
                                        <th>Descripción</th>
                                        <th>Fecha de Entrega</th>
                                        <th>Hora de Entrega</th>
                                        <th>Estado</th>
                                        <th>Materia</th>
                                        <th>Archivo</th>
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
                                            <td><?= $tarea['hora_entrega'] ?></td>
                                            <td><?= $tarea['estado'] ?></td>
                                            <td><?= $tarea['materia'] ?></td>
                                            <td>
                                                <?php if ($tarea['ruta_archivo']): ?>
                                                    <a href="/proyectoEscuela/config/uploads/<?= $tarea['ruta_archivo'] ?>" target="_blank">Ver archivo</a>
                                                <?php else: ?>
                                                    No hay archivo
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="show.php?id=<?= $tarea['id_tarea'] ?>" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                                <?php if (in_array($_SESSION['role'], ['ADMINISTRADOR', 'PROFESOR'])): ?>
                                                    <a href="edit.php?id=<?= $tarea['id_tarea'] ?>" class="btn btn-warning btn-sm">Editar</a>
                                                    <form action="<?= APP_URL ?>/config/controllers/tareas/delete.php" method="POST" style="display:inline;">
                                                        <input type="hidden" name="id_tarea" value="<?= $tarea['id_tarea'] ?>">
                                                        <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                <?php endif; ?>
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
    </div>
</div>
<?php
include('../../admin/layout/parte2.php');
?>