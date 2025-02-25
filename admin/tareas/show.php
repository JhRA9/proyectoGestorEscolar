<?php
include ('../../config/config.php');
include ('../../admin/layout/parte1.php');

$id_tarea = $_GET['id'];
$sentencia = $pdo->prepare("SELECT * FROM tareas WHERE id_tarea = :id_tarea");
$sentencia->bindParam(':id_tarea', $id_tarea);
$sentencia->execute();
$tarea = $sentencia->fetch(PDO::FETCH_ASSOC);

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
                <div class="col-md-12">
                    <p><strong>Título:</strong> <?= $tarea['titulo'] ?></p>
                    <p><strong>Descripción:</strong> <?= $tarea['descripcion'] ?></p>
                    <p><strong>Fecha de Entrega:</strong> <?= $tarea['fecha_entrega'] ?></p>
                    <p><strong>Estado:</strong> <?= $tarea['estado'] ?></p>
                    <a href="edit.php?id=<?= $tarea['id_tarea'] ?>" class="btn btn-warning">Editar</a>
                    <a href="index.php" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include ('../../admin/layout/parte2.php');
include ('../../layout/mostrarMensajes.php');
?>