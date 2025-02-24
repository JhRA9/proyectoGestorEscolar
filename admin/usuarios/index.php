<?php
include('../../config/config.php');
include('../../admin/layout/parte1.php');
include('../../config/controllers/usuarios/listado_usuarios.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Listado de usuarios</h1><br>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary shadow-none">
                        <div class="card-header">
                            <h3 class="card-title">Usuarios registrados</h3>
                            <div class="card-tools">
                                <a href="create.php" class="btn btn-dark"> <i class="bi bi-plus-square"></i>Crear nuevo usuario</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>#</center>
                                        </th>
                                        <th>
                                            <center>Nombre del usuario</center>
                                        </th>
                                        <th>
                                            <center>Rol ID</center>
                                        </th>
                                        <th>
                                            <center>Email</center>
                                        </th>
                                        <th>
                                            <center>Fecha de creacion</center>
                                        </th>
                                        <th>
                                            <center>Estado</center>
                                        </th>
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $contador_usuarios = 0;
                                    foreach ($usuarios as $usuario) {
                                        $contador_usuarios++;
                                        $id_usuario = $usuario['id_usuario'];
                                    ?>
                                        <tr>
                                            <td><?= $contador_usuarios; ?></td>
                                            <td><?= $usuario['nombres'] ?></td>
                                            <td><?= $usuario['nombre_rol'] ?></td>
                                            <td><?= $usuario['email'] ?></td>
                                            <td><?= $usuario['hora_creacion'] ?></td>
                                            <td><?= $usuario['estado'] ?></td>
                                            <td style="text-align: center">
                                                <div class="btn-group" role="group" aria-label="Basic example">
                                                    <a href="show.php?id=<?= $id_usuario; ?>" type="button" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                                    <a href="edit.php?id=<?= $id_usuario; ?>" type="button" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                                                    <form action="<?= APP_URL; ?>/config/controllers/roles/delete.php" method="POST">
                                                        <input type="text" value="<?= $id_usuario; ?>" hidden name="id_rol">
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
include('../../admin/layout/parte2.php');
include('../../layout/mostrarMensajes.php');
?>

<script>
    $(function() {
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,

        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>