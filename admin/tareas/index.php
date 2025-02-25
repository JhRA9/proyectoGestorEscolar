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
                <h1>Listado de Tareas</h1><br>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary shadow-none">
                        <div class="card-header">
                            <h3 class="card-title">Tareas registradas</h3>
                            <div class="card-tools">
                                <a href="create.php" class="btn btn-dark"> <i class="bi bi-plus-square"></i> Crear nueva tarea </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th><center>#</center></th>
                                        <th><center>Título</center></th>
                                        <th><center>Descripción</center></th>
                                        <th><center>Fecha de Entrega</center></th>
                                        <th><center>Hora de Entrega</center></th>
                                        <th><center>Estado</center></th>
                                        <th><center>Materia</center></th>
                                        <th><center>Archivo</center></th>
                                        <th><center>Acciones</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador_tarea = 0;
                                    foreach($tareas as $tarea){
                                        $contador_tarea++;
                                        $id_tarea = $tarea['id_tarea'];
                                    ?>
                                    <tr>
                                        <td><?=$contador_tarea;?></td>
                                        <td><?=$tarea['titulo']?></td>
                                        <td><?=$tarea['descripcion']?></td>
                                        <td><?=$tarea['fecha_entrega']?></td>
                                        <td><?=$tarea['hora_entrega']?></td>
                                        <td><?=$tarea['estado']?></td>
                                        <td><?=$tarea['materia']?></td>
                                        <td>
                                            <?php if ($tarea['ruta_archivo']): ?>
                                                <a href="<?= APP_URL . 'uploads/' . basename($tarea['ruta_archivo']) ?>" target="_blank">Ver archivo</a>
                                            <?php else: ?>
                                                No hay archivo
                                            <?php endif; ?>
                                        </td>
                                        <td style="text-align: center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="show.php?id=<?=$id_tarea;?>" type="button" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                                <a href="edit.php?id=<?=$id_tarea;?>" type="button" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                                                <a href="upload.php?id=<?=$id_tarea;?>" type="button" class="btn btn-primary btn-sm"><i class="bi bi-upload"></i></a>
                                                <form action="<?=APP_URL;?>/config/controllers/tareas/delete.php" method="POST">
                                                    <input type="text" value="<?=$id_tarea;?>" hidden name="id_tarea">
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
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
include ('../../admin/layout/parte2.php');
include ('../../layout/mostrarMensajes.php');
?>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
  });
</script>