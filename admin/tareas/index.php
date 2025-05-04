<?php
include '../../config/config.php';
include('../layout/parte1.php');
include('../../config/controllers/tareas/index.php');
?>

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
                                    <a href="create.php" class="btn btn-dark"> <i class="bi bi-plus-square"></i> Crear tarea </a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <button accesskey="1" class="btn btn-primary" id="btn-fecha">Ordenar por fecha</button>
                            <button accesskey="2" class="btn btn-primary" id="btn-estado">Ordenar por estado</button>
                            <button accesskey="3" class="btn btn-primary" id="btn-materia">Ordenar por materia</button>

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
                                <tbody id="tbody">
                                    <!-- JavaScript llenará esta sección -->
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
    $(function () {
        const role = "<?= $_SESSION['role'] ?>";

        function loadTable(order = 'title') {
            fetch('/proyectoEscuela/config/controllers/tareas/list.php?order=' + order)
                .then(response => response.json())
                .then(data => {
                    if ($.fn.DataTable.isDataTable("#example1")) {
                        $('#example1').DataTable().clear().destroy();
                    }

                    const tbody = document.getElementById('tbody');
                    tbody.innerHTML = '';

                    data.data.forEach(element => {
                        const row = document.createElement('tr');

                        const fileHTML = element.ruta_archivo ?
                            `<a href="/proyectoEscuela/config/uploads/${element.ruta_archivo}" target="_blank">Ver archivo</a>` :
                            'No hay archivo';

                        let adminEditHTML = '';
                        let adminRemoveHTML = '';
                        if (role === 'ADMINISTRADOR' || role === 'PROFESOR') {
                            adminEditHTML = `<a href="edit.php?id=${element.id}" class="btn btn-warning btn-sm">Editar</a>`;
                            adminRemoveHTML = `
                                <form action="/proyectoEscuela/config/controllers/tareas/delete.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_tarea" value="${element.id}">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i></button>
                                </form>`;
                        }

                        const actionsHTML = `
                            <a href="show.php?id=${element.id}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                            ${adminEditHTML}
                            <a href="upload.php?id=${element.id}" class="btn btn-primary btn-sm"><i class="bi bi-upload"></i></a>
                            ${adminRemoveHTML}
                        `;

                        row.innerHTML = `
                            <td><center>${element.id}</center></td>
                            <td><center>${element.titulo}</center></td>
                            <td><center>${element.descripcion}</center></td>
                            <td><center>${element.fecha_entrega}</center></td>
                            <td><center>${element.hora_entrega}</center></td>
                            <td><center>${element.estado}</center></td>
                            <td><center>${element.materia}</center></td>
                            <td><center>${fileHTML}</center></td>
                            <td><center>${actionsHTML}</center></td>
                        `;
                        tbody.appendChild(row);
                    });

                    $("#example1").DataTable({
                        responsive: true,
                        lengthChange: false,
                        autoWidth: false,
                        ordering: false,
                        searching: false,
                        paging: false,
                    });
                })
                .catch(error => console.error(error));
        }

        loadTable();

        document.getElementById('btn-fecha').addEventListener('click', () => loadTable('fecha_entrega'));
        document.getElementById('btn-estado').addEventListener('click', () => loadTable('estado'));
        document.getElementById('btn-materia').addEventListener('click', () => loadTable('materia'));
    });
</script>
