<?php
include('../../config/config.php');
include('../layout/parte1.php');
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
                                <?php if (in_array($_SESSION['role'], ['ADMINISTRADOR', 'PROFESOR'])): ?><a href="create.php" class="btn btn-dark"> <i class="bi bi-plus-square"></i> Crear nueva tarea </a> <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <button accesskey="1" class="btn btn-primary" id="btn-fecha">Ordenar por fecha</button>
                            <button accesskey="2" class="btn btn-primary" id="btn-estado">Ordenar por estado</button>
                            <button accesskey="3" class="btn btn-primary" id="btn-materia">Ordenar por materia</button>
                            <table id="example1" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            <center>#</center>
                                        </th>
                                        <th>
                                            <center>Título</center>
                                        </th>
                                        <th>
                                            <center>Descripción</center>
                                        </th>
                                        <th>
                                            <center>Fecha de Entrega</center>
                                        </th>
                                        <th>
                                            <center>Hora de Entrega</center>
                                        </th>
                                        <th>
                                            <center>Estado</center>
                                        </th>
                                        <th>
                                            <center>Materia</center>
                                        </th>
                                        <th>
                                            <center>Archivo</center>
                                        </th>
                                        <th>
                                            <center>Acciones</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tbody">

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

        function loadTable(order = 'title') {

            fetch('/proyectoEscuela/config/controllers/tareas/list.php?order=' + order)
                .then(response => response.json())
                .then(data => {
                    if ($.fn.DataTable.isDataTable("#example1")) {
                        $('#example1').DataTable().clear().destroy();
                    }
                    const table = document.getElementById('tbody');
                    table.innerHTML = '';

                    data.data.forEach(element => {
                        const row = document.createElement('tr');

                        const fileHTML = element.ruta_archivo ? `<a href="/proyectoEscuela/config/uploads/${element.ruta_archivo}" target="_blank">Ver archivo</a>` : 'No hay archivo';

                        let adminEditHTML = ''
                        let adminRemoveHTML = ''
                        if ('<?= $_SESSION['role'] ?>' === 'ADMINISTRADOR' || '<?= $_SESSION['role'] ?>' === 'PROFESOR') {
                            adminEditHTML = `
                                <a href="edit.php?id=${element.id_tarea}" class="btn btn-warning btn-sm">Editar</a>
                            `
                            adminRemoveHTML = `
                                <form action="/proyectoEscuela/config/controllers/tareas/delete.php" method="POST">
                                    <input type="text" value="${element.id_tarea}" hidden name="id_tarea">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>
                            `
                        }
                        const actionsHTML = `
                            <a href="show.php?id=${element.id_tarea}" type="button" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i></a>
                                ${adminEditHTML}
                                <a href="upload.php?id=${element.id_tarea}" type="button" class="btn btn-primary btn-sm"><i class="bi bi-upload"></i></a>
                                ${adminRemoveHTML}
                        `

                        row.innerHTML = `
                            <td><center>${element.id_tarea}</center></td>
                            <td><center>${element.titulo}</center></td>
                            <td><center>${element.descripcion}</center></td>
                            <td><center>${element.fecha_entrega}</center></td>
                            <td><center>${element.hora_entrega}</center></td>
                            <td><center>${element.estado}</center></td>
                            <td><center>${element.materia}</center></td>
                            <td><center>${fileHTML}</center></td>
                            <td><center>${actionsHTML}</center></td>
                        `;

                        table.appendChild(row);
                    });

                })
                .then(() => {
                    $("#example1").DataTable({
                            responsive: true,
                            lengthChange: false,
                            autoWidth: false,
                            ordering: false,
                            searching: false,
                            paging: false,
                        })
                        .buttons()
                        .container()
                        .appendTo('#example1_wrapper .col-md-6:eq(0)');
                })
                .catch(error => console.error(error));
        }
        loadTable()

        document.getElementById('btn-fecha').addEventListener('click', () => {
            loadTable('fecha_entrega')
        })
        document.getElementById('btn-estado').addEventListener('click', () => {
            loadTable('estado')
        })
        document.getElementById('btn-materia').addEventListener('click', () => {
            loadTable('materia')
        })

    });
</script>