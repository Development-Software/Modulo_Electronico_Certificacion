<?php
include_once dirname(__DIR__) . '/model/db.php';
include_once dirname(__DIR__)  . '/model/permisos.php';
include_once dirname(__DIR__)  . '/model/configuracion.php';
include_once dirname(__DIR__)  . '/controller/controller_sesion.php';
include_once dirname(__DIR__)  . '/model/campus.php';
extract($_GET);
$usuarios = new campus();
$usuarios->setIdCampus($id_campus);
$id_users = $usuarios->getReporteCampusUsuario();
$id_user_asignados = $usuarios->getReporteCampusasignado();
$permisos = new permisos($_SESSION['usuarioid'], $_SESSION['usuarioidRol']);
$t_permisos = $permisos->listar_total_permisos();
$permiso_agregar = false;
$permiso_eliminar = false;

foreach ($t_permisos as $id_permiso) {
    if ($id_permiso['idPermiso'] == 27) {
        $permiso_agregar = true;
    } elseif ($id_permiso['idPermiso'] == 28) {
        $permiso_eliminar = true;
    }
    /*     echo '<pre>';
    var_dump($id_permiso['idPermiso']);
    echo'</pre>'; */
}

?>
<input type="text" name="idCampus" id="idCampus" value="<?php echo $id_campus ?>" hidden>
<div class="col-md-5">
    <div class=" justify-content-center align-items-center minh-100">
        <div style="text-align: center;">
            <h4>Usuarios por asignar</h4>
            <div class="card-table">
                <div class="card-table-body">
                    <div class="table-responsive">
                        <table id="tabla_usuarios_asignar" class="table table-bordered" style="width: 95%;margin: auto; font-size:smaller; text-align:left;">
                            <thead style="background-color: #ffc670;color: #150485;">
                                <th>
                                    <input type="checkbox" id="select_all" />
                                </th>
                                <th style="display: none;">Id_Usuario</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($id_users as $row) {
                                ?>
                                    <tr>
                                        <td style="text-align: center;">
                                        </td>
                                        <td style="display: none;"><?php echo $row['idUsuario']; ?></td>
                                        <td><?php echo $row['Nombre']; ?></td>
                                        <td><?php echo $row['Correo']; ?></td>
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
<div class="col-md-2">
    <?php if ($permiso_agregar) {
        echo "<div style=\"margin-top: 150px;margin-left:50px\"><input type=\"image\" src=\"../../img/usuarios/agregar.png\" alt=\"agregar usuarios al campus\" width=\"50px\" id=\"add\"> </div>";
    } ?>
    <?php if ($permiso_eliminar && !$permiso_agregar) {
        echo "<div style=\"margin-left:50px;margin-top:150px;\"><input type=\"image\" src=\"../../img/usuarios/eliminar.png\" alt=\"agregar usuarios al campus\" width=\"50px\" id=\"remove\"></div>";
    } elseif ($permiso_eliminar) {
        echo "<div style=\"margin-left:50px; \"><input type=\"image\" src=\"../../img/usuarios/eliminar.png\" alt=\"agregar usuarios al campus\" width=\"50px\" id=\"remove\"></div>";
    } ?>
</div>
<div class="col-md-5">
    <div class=" justify-content-center align-items-center minh-100">
        <div style="text-align: center;">
            <h4>Usuarios asignados al campus</h4>
            <div class="card-table">
                <div class="card-table-body">
                    <div class="table-responsive">
                        <table id="tabla_usuarios_campus" class="table table-bordered" style="text-align:left; width: 95%;margin: auto; font-size:smaller;">
                            <thead style="background-color: #ffc670;color: #150485;">
                                <th>
                                    <input type="checkbox" id="select_all_1" />
                                </th>
                                <th style="display: none;">Id_Usuario</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($id_user_asignados as $row) {
                                ?>
                                    <tr>
                                        <td style="text-align: center;">
                                        </td>
                                        <td style="display: none;"><?php echo $row['idUsuario']; ?></td>
                                        <td><?php echo $row['Nombre']; ?></td>
                                        <td><?php echo $row['Correo']; ?></td>
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
<script>
    $(document).ready(function() {
        $('head').append('<style>.selected{ background-color:#aed9ff !important;}</style>');
        var table = $('#tabla_usuarios_asignar').DataTable({
                dom: '<"bar"f>t<"#tools_l.footer_table"><"#tools_p"p>',
                columnDefs: [{
                    orderable: false,
                    //className: 'select-checkbox',
                    targets: 0,
                    blurable: true,
                    render: function(data, type, full, meta) {
                        return '<input type="checkbox">';
                    }
                }],

                select: {
                    style: 'multi',
                    //selector: 'td:first-child'
                },
                language: {
                    sProcessing: 'Procesando...',
                    sLengthMenu: 'Mostrar _MENU_ registros',
                    sZeroRecords: 'No se encontraron resultados',
                    sEmptyTable: 'Ningún dato disponible en esta tabla',
                    sInfo: 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                    sInfoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
                    sInfoFiltered: '(filtrado de un total de _MAX_ registros)',
                    sInfoPostFix: '',
                    sSearch: '',
                    sUrl: '',
                    sInfoThousands: '',
                    sLoadingRecords: 'Cargando...',
                    oPaginate: {
                        sFirst: 'Primero',
                        sLast: 'Último',
                        sNext: 'Siguiente',
                        sPrevious: 'Anterior'
                    }
                },
                order: [
                    [0, "asc"]
                ],
                lengthMenu: [
                    [1, 5, 10, 25, 50, -1],
                    [1, 5, 10, 25, 50, "Todos"]
                ],
                pageLength: 5,
                ordering: true,
                searching: false,
                stateSave: true
            }

        );

        $('body').on('change', '#select_all', function() {
            var rows, checked;
            rows = $('#tabla_usuarios_asignar').find('tbody tr');
            checked = $(this).prop('checked');
            $.each(rows, function() {
                var checkbox = $($(this).find('td').eq(0)).find('input').prop('checked', checked);
            });
        });

        $('#tabla_usuarios_asignar tbody').on('click', 'tr', function() {
            $(this).toggleClass('selected');

            var checked = $(this).find('input[type=checkbox]').prop('checked')

            var selected = $(this).hasClass('selected');
            //console.log(checked);
            //console.log(selected);
            if (!selected) {
                $(this).find('input[type=checkbox]').prop('checked', false)
            } else {
                $(this).find('input[type=checkbox]').prop('checked', true)
            }
        });

        $('#tabla_usuarios_asignar').on('click', '#select_all', function() {
            if ($('#select_all:checked').val() === 'on')
                table.rows().select();
            else
                table.rows().deselect();
        });

        $('#select_all').change(function() {
            $('#tabla_usuarios_asignar').DataTable()
                .column(0)
                .nodes()
                .to$()
                .find('input[type=checkbox]')
                .prop('checked', this.checked);
        });



        var table_1 = $('#tabla_usuarios_campus').DataTable({
                dom: '<"bar"f>t<"#tools_l.footer_table"><"#tools_p"p>',
                columnDefs: [{
                    orderable: false,
                    //className: 'select-checkbox',
                    targets: 0,
                    blurable: true,
                    render: function(data, type, full, meta) {
                        return '<input type="checkbox">';
                    }
                }],

                select: {
                    style: 'multi',
                    //selector: 'td:first-child'
                },
                language: {
                    sProcessing: 'Procesando...',
                    sLengthMenu: 'Mostrar _MENU_ registros',
                    sZeroRecords: 'No se encontraron resultados',
                    sEmptyTable: 'Ningún dato disponible en esta tabla',
                    sInfo: 'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
                    sInfoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
                    sInfoFiltered: '(filtrado de un total de _MAX_ registros)',
                    sInfoPostFix: '',
                    sSearch: '',
                    sUrl: '',
                    sInfoThousands: '',
                    sLoadingRecords: 'Cargando...',
                    oPaginate: {
                        sFirst: 'Primero',
                        sLast: 'Último',
                        sNext: 'Siguiente',
                        sPrevious: 'Anterior'
                    }
                },
                order: [
                    [0, "asc"]
                ],
                lengthMenu: [
                    [1, 5, 10, 25, 50, -1],
                    [1, 5, 10, 25, 50, "Todos"]
                ],
                pageLength: 5,
                ordering: true,
                searching: false,
                stateSave: true
            }

        );

        $('body').on('change', '#select_all_1', function() {
            var rows, checked;
            rows = $('#tabla_usuarios_campus').find('tbody tr');
            checked = $(this).prop('checked');
            $.each(rows, function() {
                var checkbox = $($(this).find('td').eq(0)).find('input').prop('checked', checked);
            });
        });

        $('#tabla_usuarios_campus tbody').on('click', 'tr', function() {
            $(this).toggleClass('selected');
            var checked = $(this).find('input[type=checkbox]').prop('checked')
            var selected = $(this).hasClass('selected');
            if (!selected) {
                $(this).find('input[type=checkbox]').prop('checked', false)
            } else {
                $(this).find('input[type=checkbox]').prop('checked', true)
            }
        });

        $('#tabla_usuarios_campus').on('click', '#select_all_1', function() {
            if ($('#select_all_1:checked').val() === 'on')
                table_1.rows().select();
            else
                table_1.rows().deselect();
        });

        $('#select_all_1').change(function() {
            $('#tabla_usuarios_campus').DataTable()
                .column(0)
                .nodes()
                .to$()
                .find('input[type=checkbox]')
                .prop('checked', this.checked);
        });

        $("#add").on("click", function(e) {
            var registros = []
            var idcampus = $('#idCampus').val()
            var data = table.rows({
                selected: true
            }).data();
            data.each(function(value, index) {
                //console.log("Data in index: " + index + " is: " + value[1]);
                registros.push(value[1])
            });
            //console.log(registros);
                    if (registros.length == 0) {
                        Swal.fire({
                            html: '<div style="width: 100%;"><div style="float: left;"><img src="../../img/swal_alert/exclamacion.png"></div><div float: right;color:#721c24;"    class="font_alert"><p class="font_alert" style="font-weight: bold; text-align: center;">Seleccionar registros</p>Es necesario seleccionar algun usuario de la lista para registrarlo en el campus</div></div>',
                            position: 'top-end',
                            showConfirmButton: false,
                            width: 500,
                            background: '#f5c6cb',
                            timer: 1500
                        });
                        return false;
                    } else {
                        $.ajax({
                            url: "../../controller/controller_asigna_campus.php",
                            type: "POST",
                            dataType: "JSON",
                            data: {
                                'usuarios': JSON.stringify(registros),
                                'idCampus': JSON.stringify(idcampus)
                            }
                        }).done(function(res) {
                            if (res.acc == true) {
                                Swal.fire({
                                    html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Usuarios registrados exitosamente</div><div>' + res.msg + '</div></div>',
                                    confirmButtonColor: "#000461"
                                }).then(function() {
                                    window.location.href = "./?menu=campus";
                                });
                            } else {
                                Swal.fire({
                                    html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/error_info.png" width="150px" ><div style="font-weight: bolder;">Algo salio mal</div><div>' + res.msg + '</div></div>',
                                    confirmButtonColor: "#ff7070"
                                }).then(function() {
                                    window.location.href = "./?menu=campus";
                                });
                            }
                        })
                    } 
        })
        $("#remove").on("click", function(e) {
            var registros = []
            var idcampus = $('#idCampus').val()
            var data = table_1.rows({
                selected: true
            }).data();
            data.each(function(value, index) {
                //console.log("Data in index: " + index + " is: " + value[1]);
                registros.push(value[1])
            });
            //console.log(registros);
        if (registros.length == 0) {
            Swal.fire({
                html: '<div style="width: 100%;"><div style="float: left;"><img src="../../img/swal_alert/exclamacion.png"></div><div float: right;color:#721c24;"    class="font_alert"><p class="font_alert" style="font-weight: bold; text-align: center;">Seleccionar registros</p>Es necesario seleccionar algun usuario de la lista para eliminarlo del campus</div></div>',
                position: 'top-end',
                showConfirmButton: false,
                width: 500,
                background: '#f5c6cb',
                timer: 1500
            });
            return false;
        } else {
            $.ajax({
                url: "../../controller/controller_elimina_campus.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    'usuarios': JSON.stringify(registros),
                    'idCampus': JSON.stringify(idcampus)
                }
            }).done(function(res) {
                if (res.acc == true) {
                    Swal.fire({
                        html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Usuarios eliminados exitosamente</div><div>' + res.msg + '</div></div>',
                        confirmButtonColor: "#000461"
                    }).then(function() {
                        window.location.href = "./?menu=campus";
                    });
                } else {
                    Swal.fire({
                        html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/error_info.png" width="150px" ><div style="font-weight: bolder;">Algo salio mal</div><div>' + res.msg + '</div></div>',
                        confirmButtonColor: "#ff7070"
                    }).then(function() {
                        window.location.href = "./?menu=campus";
                    });
                }
            })
        }
    })
    });
</script>
