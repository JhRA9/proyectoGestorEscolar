<?php
include('../../config/config.php');
include('../../config/autenticacion_rol.php');
include('../../admin/layout/parte1.php');
include('../../config/controllers/roles/listado_roles.php');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Creacion de usuario</h1>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Digite los datos</h3>
                        </div>
                        <div class="card-body">
                            <form action="<?= APP_URL; ?>config/controllers/usuarios/create.php" method="POST">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Datos del usuario</label>
                                            <div class="form-inline"><select name="rol_id" class="form-control">
                                                    <?php
                                                    foreach ($roles as $rol) { ?>
                                                        <option value="<?= $rol['id_rol']; ?>"><?= $rol['nombre_rol']; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <a href="<?= APP_URL; ?>/admin/roles" style="margin: 10px;" class="btn btn-primary "><i class="bi bi-file-plus"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Nombre del usuario</label>
                                            <input type="text" name="nombres" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Correo electronico</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Contraseña</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">Repita la contraseña</label>
                                            <input type="password" name="password_repeat" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Guardar rol</button>
                                            <a href="<?= APP_URL; ?>admin/usuarios" class="btn btn-secondary">Cancelar</a>
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
include('../../admin/layout/parte2.php');
include('../../layout/mostrarMensajes.php');
?>