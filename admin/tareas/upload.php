<?php
include ('../../config/config.php');
include ('../layout/parte1.php');

$id_tarea = $_GET['id'];
$sentencia = $pdo->prepare("SELECT * FROM tareas WHERE id_tarea = ?");
$sentencia->execute([$id_tarea]);
$tarea = $sentencia->fetch(PDO::FETCH_ASSOC);

$fecha_actual = date('Y-m-d');
$hora_actual = date('H:i:s');
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Detalles de la Tarea</h1>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Detalles de la tarea: <?= $tarea['titulo'] ?></h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Descripción:</strong> <?= $tarea['descripcion'] ?></p>
                            <p><strong>Fecha de Entrega:</strong> <?= $tarea['fecha_entrega'] ?></p>
                            <p><strong>Hora de Entrega:</strong> <?= $tarea['hora_entrega'] ?></p>
                            <p><strong>Materia:</strong> <?= $tarea['id_materia'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($fecha_actual <= $tarea['fecha_entrega'] && $hora_actual <= $tarea['hora_entrega']): ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Subir archivo para la tarea</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= APP_URL; ?>config/controllers/tareas/upload.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_tarea" value="<?= $id_tarea ?>">
                                <div class="form-group">
                                    <label for="archivo">Archivo</label>
                                    <input type="file" class="form-control" name="archivo" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Subir Archivo</button>
                                    <a href="<?= APP_URL; ?>admin/tareas" class="btn btn-secondary">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php else: ?>
            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-danger">
                        La fecha y hora de entrega han pasado. No puedes subir archivos.
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
include ('../../admin/layout/parte2.php');
include ('../../layout/mostrarMensajes.php');
?>