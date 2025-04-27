<?php
include('../../config/config.php');
include('../../config/autenticacion_rol.php');

// Verifico si el rol es válido para editar tareas
if (!in_array($_SESSION['role'], ['ADMINISTRADOR', 'PROFESOR'])) {
    header('Location: index.php'); // Redirigir al listado si no tiene permiso
    exit();
}

include('../../admin/layout/parte1.php');

// Verifico si se ha pasado el ID de la tarea
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['mensaje'] = "No se especificó una tarea válida para editar.";
    $_SESSION['icono'] = "error";
    header('Location: index.php');
    exit();
}

$id_tarea = $_GET['id'];

// Obtengo los datos de la tarea desde la base de datos
$sentencia = $pdo->prepare("SELECT * FROM tareas WHERE id_tarea = ?");
$sentencia->execute([$id_tarea]);
$tarea = $sentencia->fetch(PDO::FETCH_ASSOC);

// Verifico si la tarea existe
if (!$tarea) {
    $_SESSION['mensaje'] = "La tarea no existe o no se encontró.";
    $_SESSION['icono'] = "error";
    header('Location: index.php');
    exit();
}

// Obtengo las materias para el formulario
$sentencia = $pdo->prepare("SELECT * FROM materias");
$sentencia->execute();
$materias = $sentencia->fetchAll(PDO::FETCH_ASSOC);
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
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Fecha de Entrega</label>
                                            <input type="date" class="form-control" name="fecha_entrega" value="<?= $tarea['fecha_entrega'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Hora de Entrega</label>
                                            <input type="time" class="form-control" name="hora_entrega" value="<?= $tarea['hora_entrega'] ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="">Materia</label>
                                            <select class="form-control" name="id_materia" required>
                                                <?php foreach ($materias as $materia): ?>
                                                    <option value="<?= $materia['id_materia'] ?>" <?= $tarea['id_materia'] == $materia['id_materia'] ? 'selected' : '' ?>><?= $materia['nombre_materia'] ?></option>
                                                <?php endforeach; ?>
                                            </select>
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
            <!-- Botón para subir archivos -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline card-success">
                        <div class="card-header">
                            <h3 class="card-title">Subir Archivo</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= APP_URL; ?>config/controllers/tareas/upload.php" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id_tarea" value="<?= $tarea['id_tarea'] ?>">
                                <div class="form-group">
                                    <label for="archivo">Archivo</label>
                                    <input type="file" class="form-control" name="archivo" required>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Subir Archivo</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('../../admin/layout/parte2.php');
include('../../layout/mostrarMensajes.php');
?>