<?php
include ('../../config/config.php');
include ('../../admin/layout/parte1.php');
include ('../../config/controllers/materias/listado_de_materias.php');

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <br>
    <div class="content">
        <div class="container">
            <div class="row">
                <h1>Listado de materias</h1>
            </div>
            <br>
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Materias registrados</h3>
                            <div class="card-tools">
                            <?php if (in_array($_SESSION['role'], ['ADMINISTRADOR'])): ?><a href="create.php" class="btn btn-primary"><i class="bi bi-plus-square"></i> Crear nueva materia</a><?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-striped table-bordered table-hover table-sm">
                                <thead>
                                <tr>
                                    <th><center>Nro</center></th>
                                    <th><center>Materia</center></th>
                                    <th><center>Estado</center></th>
                                    <th><center>Acciones</center></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $contador_materias = 0;
                                foreach ($materias as $materia){
                                    $id_materia = $materia['id_materia'];
                                    $contador_materias = $contador_materias +1; ?>
                                    <tr>
                                        <td style="text-align: center"><?=$contador_materias;?></td>
                                        <td style="text-align: center;"><?=$materia['nombre_materia'];?></td>
                                        <td style="text-align: center;">
                                            <?php
                                            if($materia['estado']=="1") echo "ACTIVO";
                                            else echo "INACTIVO";
                                            ?>
                                        </td>
                                        <td style="text-align: center">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                <a href="show.php?id=<?=$id_materia;?>" type="button" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                                <?php if (in_array($_SESSION['role'], ['ADMINISTRADOR'])): ?><a href="edit.php?id=<?=$id_materia;?>" type="button" class="btn btn-success btn-sm"><i class="bi bi-pencil"></i></a>
                                                <form action="<?=APP_URL;?>/config/controllers/materias/delete.php" onclick="preguntar<?=$id_materia;?>(event)" method="post" id="miFormulario<?=$id_materia;?>">
                                                    <input type="text" name="id_materia" value="<?=$id_materia;?>" hidden>
                                                    <button type="submit" class="btn btn-danger btn-sm" style="border-radius: 0px 5px 5px 0px"><i class="bi bi-trash"></i></button>
                                                </form>
                                                <?php endif; ?>
                                                <script>
                                                    function preguntar<?=$id_materia;?>(event) {
                                                        event.preventDefault();
                                                        Swal.fire({
                                                            title: 'Eliminar registro',
                                                            text: '¿Desea eliminar este registro?',
                                                            icon: 'question',
                                                            showDenyButton: true,
                                                            confirmButtonText: 'Eliminar',
                                                            confirmButtonColor: '#a5161d',
                                                            denyButtonColor: '#270a0a',
                                                            denyButtonText: 'Cancelar',
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                var form = $('#miFormulario<?=$id_materia;?>');
                                                                form.submit();
                                                            }
                                                        });
                                                    }
                                                </script>
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
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php

include ('../../admin/layout/parte2.php');
include ('../../layout/mostrarMensajes.php');

?>

<script>
    $(function () {
        $("#example1").DataTable({
            "pageLength": 5,
            "language": {
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Materias",
                "infoEmpty": "Mostrando 0 a 0 de 0 Materias",
                "infoFiltered": "(Filtrado de _MAX_ total Materias)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Materias",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscador:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            "responsive": true, "lengthChange": true, "autoWidth": false,
            buttons: [{
                extend: 'collection',
                text: 'Reportes',
                orientation: 'landscape',
                buttons: [{
                    text: 'Copiar',
                    extend: 'copy',
                }, {
                    extend: 'pdf'
                },{
                    extend: 'csv'
                },{
                    extend: 'excel'
                },{
                    text: 'Imprimir',
                    extend: 'print'
                }
                ]
            },
                {
                    extend: 'colvis',
                    text: 'Visor de columnas',
                    collectionLayout: 'fixed three-column'
                }
            ],
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
</script>