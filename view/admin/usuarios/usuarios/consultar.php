<div id="panel-registros" style="width:95%;margin:auto;">
    <br>
    <div id="panel_carga" style="text-align: center;" class="row justify-content-center align-items-center minh-100">
        <p style="text-align: left;"><strong>Instrucciones:</strong><br>Selecciona la opción de la acción que requieras realizar, en esta seccion podras reinciar la contraseña de los usuarios, activarlos y modificar sus datos.</p>
    </div>
    <div class=" justify-content-center align-items-center minh-100">
        <div style="text-align: center;">
            <div class="card-table">
                <div class="row toolsbar_user">
                    <div class="col-md-6" style="text-align: left;">
                    <?php if ($permiso_agregar) {echo
                        "<button title=\"Agregar\" id=\"agregar_user\" type=\"button\" class=\"btn btn-outline-white btn-rounded btn-sm px-2\">
                            <i class=\"fas fa-user-plus fa-lg\" style=\"color: blue;\"></i> Agregar usuario
                        </button>"; } ?>
                        <?php if ($permiso_activar) {echo
                        "<button title=\"Desactivar\" id=\"desactivar_user\" type=\"button\" class=\"btn btn-outline-white btn-rounded btn-sm px-2\">
                            <i class=\"fas fa-user-times fa-lg\" style=\"color: red;\"></i> Desactivar usuario
                        </button>
                        <button title=\"Activar\" id=\"activar_user\" type=\"button\" class=\"btn btn-outline-white btn-rounded btn-sm px-2\">
                            <i class=\"fas fa-user-check fa-lg\" style=\"color: green;\"></i> Activar usuario
                        </button>"; } ?>
                    </div>
                    <div class="col-md-6" style="text-align: right;">
                        <button title="Buscar en la tabla" id="buscar" type="button" class="btn btn-outline-white btn-rounded btn-sm px-2">
                            <i class="fas fa-search fa-lg"></i> <input id="buscar_id" style="display: none;" value="0">
                        </button>
                        <?php if ($permiso_exportar) {
                            echo "<button title=\"Exportar a excel\" id=\"excel\" type=\"button\" class=\"btn btn-outline-white btn-rounded btn-sm px-2\">
                        <i class=\"fas fa-file-excel fa-lg\"></i>
                    </button>";
                        }
                        ?>
                    </div>
                </div>
                <div class="card-table-body">
                    <div class="table-responsive">
                        <table id="tabla_c" class="table table-striped table-dark table-bordered" style="width: 95%;margin: auto; font-size:smaller;color:#fff !important;">
                            <thead style="background-color: #ffa5a5;color: #150485;">
                                <th>
                                    <input type="checkbox" id="select_all" />
                                </th>
                                <th style="display: none;">IdUsuario</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Correo</th>
                                <th>Usuario</th>
                                <th style="display: none;">IdRol</th>
                                <th>Rol</th>
                                <th>Estatus</th>
                                <th>Fecha Registro</th>
                                <th><?php if ($permiso_editar) { echo 'Editar';}?></th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($datosReporte as $row) {
                                ?>
                                    <tr>
                                        <td>
                                            <input class="form-check-input position-static" style="margin: auto;" type="checkbox" id="<?php echo $row['idUsuario'] ?>" value="option1" aria-label="...">
                                        </td>
                                        <td style="display: none;"><?php echo $row['idUsuario']; ?></td>
                                        <td><?php echo $row['nombre']; ?></td>
                                        <td><?php echo $row['apellido_paterno']; ?></td>
                                        <td><?php echo $row['apellido_materno']; ?></td>
                                        <td><?php echo $row['correo']; ?></td>
                                        <td><?php echo $row['username']; ?></td>
                                        <td style="display: none;"><?php echo $row['idRol']; ?></td>
                                        <td><?php echo $row['Rol']; ?></td>
                                        <td><?php $row['Activo'] == 1 ? $label = "<span class='badge badge-success' style='font-weight: normal !important;font-size:100%;'>Activo</span>" : $label = "<span class='badge badge-danger' style='font-weight: normal !important;font-size:100%;'>Inactivo</span>";
                                            echo $label ?></td>
                                        <td><?php echo $row['Fecha_Registro']; ?></td>
                                        <td align="center">
                                        <?php if ($permiso_editar) { echo  "<button id=\"btnEdit\" style=\"border: none; background-color:transparent;\">
                                                <img src=\"../../img/usuarios/EditUser.png\" width=\"20px\">
                                            </button>";
                                        } ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!---->
            </div>
        </div>
    </div>
</div>
<!-- Modal Update -->
<div class="modal fade" id="modal_update" tabindex="-1" role="dialog" aria-labelledby="modal_updateLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to right, rgba(242,246,248,1) 0%, rgba(216,225,231,1) 23%, rgba(181,198,208,1) 54%, rgba(224,239,249,1) 100%);">
                <h5 class="modal-title" id="emodal_updateLabel">Actualizar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="update_user" class="needs-validation" novalidate>
                    <input type="hidden" name="id" id="id">
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control form-control-sm" id="nombre" pattern="[a-zA-Z ]{2,254}" required>
                        <div class="invalid-feedback">Este campo es obligatorio y solo debes ingresar letras.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="apellidoP" class="col-form-label">Apellido Paterno:</label>
                        <input type="text" class="form-control form-control-sm" id="apellidoP" required>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="apellidoM" class="col-form-label">Apellido Materno:</label>
                        <input type="text" class="form-control form-control-sm" id="apellidoM" required>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="correo" class="col-form-label">Correo:</label>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                            </div>
                            <input type="email" class="form-control form-control-sm" id="correo" required>
                        </div>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="rol" class="col-form-label">Rol:</label>
                        <select name="rol" id="rol" class="form-control form-control-sm">
                            <?php foreach ($datosRoles as $roles) {
                                echo '<option value=' . $roles['idRol'] . '>' . $roles['Descripcion'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="estatus" class="col-form-label">Estatus:</label>
                        <select name="estatus" id="estatus" class="form-control form-control-sm">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="username" class="col-form-label">Usuario:</label>
                        <input type="text" class="form-control form-control-sm" id="username" readonly>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="enc" class="col-form-label">Contraseña:</label>
                        <input type="password" class="form-control form-control-sm" id="enc">
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="update_user" id="update_button">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Insert -->
<div class="modal fade" id="modal_insert" tabindex="-1" role="dialog" aria-labelledby="modal_insertLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to right, rgba(242,246,248,1) 0%, rgba(216,225,231,1) 23%, rgba(181,198,208,1) 54%, rgba(224,239,249,1) 100%);">
                <h5 class="modal-title" id="emodal_insertLabel">Agregar Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="insert_user" class="needs-validation" novalidate method="POST">

                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="nombre_insert" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control form-control-sm" id="nombre_insert" name="nombre_insert" pattern="[a-zA-Z ]{2,254}" required>
                        <div class="invalid-feedback">Este campo es obligatorio y solo debes ingresar letras.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="apellidoP_insert" class="col-form-label">Apellido Paterno:</label>
                        <input type="text" class="form-control form-control-sm" id="apellidoP_insert" name="apellidoP_insert" required>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="apellidoM_insert" class="col-form-label">Apellido Materno:</label>
                        <input type="text" class="form-control form-control-sm" id="apellidoM_insert" name="apellidoM_insert" required>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="correo_insert" class="col-form-label">Correo:</label>
                        <div class="input-group input-group-sm mb-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">@</div>
                            </div>
                            <input type="email" class="form-control form-control-sm" id="correo_insert" name="correo_insert" required>
                        </div>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="rol_insert" class="col-form-label">Rol:</label>
                        <select name="rol_insert" id="rol_insert" class="form-control form-control-sm">
                            <?php foreach ($datosRoles as $roles) {
                                echo '<option value=' . $roles['idRol'] . '>' . $roles['Descripcion'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="estatus_insert" class="col-form-label">Estatus:</label>
                        <select name="estatus_insert" id="estatus_insert" class="form-control form-control-sm">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="username_insert" class="col-form-label">Usuario:</label>
                        <input type="text" class="form-control form-control-sm" id="username_insert" name="username_insert" required>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="enc_insert" class="col-form-label">Contraseña:</label>
                        <input type="password" class="form-control form-control-sm" id="enc_insert" name="enc_insert" required>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>

                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="insert_user" id="insert_button">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        let table = $('#tabla_c').DataTable({
            dom: '<"bar"f>t<"#tools_l.footer_table"lB><"#tools_p"p>',
            columnDefs: [{
                orderable: false,
                //className: 'select-checkbox',
                targets: 0,
                blurable: true
            }],
            select: {
                style: 'multi'
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
                [2, "asc"]
            ],
            lengthMenu: [
                [1, 5, 10, 25, 50, -1],
                [1, 5, 10, 25, 50, "Todos"]
            ],
            pageLength: 5,
            ordering: true,
            searching: true,
            stateSave: true,
            buttons: [{
                extend: 'excel',
                className: 'excelButton',
                title: 'MEC 2.0|UniverMilenium-Reporte de Usuarios'
            }]


        });

        $('#tabla_c').on('click', '#select_all', function() {
            if ($('#select_all:checked').val() === 'on')
                table.rows().select();
            else
                table.rows().deselect();
        });
        $('#select_all').change(function() {
            var checkboxes = $(this).closest('table').find(':checkbox');
            checkboxes.prop('checked', $(this).is(':checked'));
        });
        /* table.on('select', function(e, dt, type, indexes) {
            var indice = Number(indexes) + 1
            table[type](indexes).nodes().to$().addClass('custom-selected');
            $('#' + indice).prop('checked', true)
        }); */
        /* table.on('deselect', function(e, dt, type, indexes) {
            var indice = Number(indexes) + 1
            table[type](indexes).nodes().to$().addClass('custom-selected');
            $('#' + indice).prop('checked', false)
        }); */
        $('#tabla_c_filter').attr('style', 'z-index: 3 !important;position: absolute;right: 245px;margin-top: -50px; display:none;');
        $('head').append('<style> .card-table-header-primary{ background: linear-gradient(60deg, #ff0000, #ff7c7c) !important;} .page-link{color:#000000 !important} .page-item.active .page-link {z-index: 3;color: #fff !important;background-color: #343434 !important;border-color: #303030 !important;} tr,td{ color:#fff !important;}</style>');
        $("button.excelButton span").remove();
        /* $("a.page-link").addClass('btn btn-dark');
        $("a.page-link").removeClass('page-link'); */
        $("button.excelButton").html('<i class="fas fa-file-excel fa-lg"></i>');

    });

    $("#buscar").on("click", function(e) {
        //debugger;

        if ($('#buscar_id').val() == 0) {

            $("#tabla_c_filter").slideDown();
            $('#buscar_id').val(1);
        } else {
            $("#tabla_c_filter").slideUp();
            $('#buscar_id').val(0);
        }

    });

    $("#desactivar_user").on("click", function(e) {
        //debugger;
        var user_ids = []
        $("input[type=checkbox]:checked").each(function(index) {
            if ($(this).closest('td').siblings().eq(0).text() != '') {
                var user_id_registro = $(this).closest('td').siblings().eq(0).text();
                user_ids.push(user_id_registro);
            }

        });

        if (user_ids.length == 0) {
            Swal.fire({
                html: '<div style="width: 100%;"><div style="float: left;"><img src="../../img/swal_alert/exclamacion.png"></div><div float: right;color:#721c24;"    class="font_alert"><p class="font_alert" style="font-weight: bold; text-align: center;">Seleccionar registros</p>Es necesario seleccionar algun registro de la lista para eliminar</div></div>',
                position: 'top-end',
                showConfirmButton: false,
                width: 500,
                background: '#f5c6cb',
                timer: 1500
            });
            return false;
        } else {
            Swal.fire({
                html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/bloquearusuario.png" width="150px"><div style="font-weight: bolder;">Desactivar usuario(s)</div><div>Al desactivar al usuario no podra tener acceso al sistema y tampoco podra terminar los procesos que no ha concluido.</div><div style="font-weight: bold;font-size: medium;">¿Deseas continuar?</div></div>',
                confirmButtonColor: "#000461",
                confirmButtonText: "Si",
                showCancelButton: true,
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "../../controller/controller_funciones_usuarios.php",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'id_users_disabled': JSON.stringify(user_ids)
                        }
                    }).done(function(res) {
                        if (res.acc == true) {
                            Swal.fire({
                                html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Usuario(s) desactivados</div><div>' + res.msg + '</div></div>',
                                confirmButtonColor: "#000461"
                            }).then(function() {
                                window.location.href = "./?menu=usuarios";
                            });
                        } else {
                            Swal.fire({
                                html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/error_info.png" width="150px" ><div style="font-weight: bolder;">Algo salio mal</div><div>' + res.msg + '</div></div>',
                                confirmButtonColor: "#ff7070"
                            }).then(function() {
                                window.location.href = "./?menu=usuarios";
                            });
                        }
                    })
                }
            });
        }
    });

    $("#activar_user").on("click", function(e) {
        //debugger;
        var user_ids = []
        $("input[type=checkbox]:checked").each(function(index) {
            if ($(this).closest('td').siblings().eq(0).text() != '') {
                var user_id_registro = $(this).closest('td').siblings().eq(0).text();
                user_ids.push(user_id_registro);
            }

        });

        if (user_ids.length == 0) {
            Swal.fire({
                html: '<div style="width: 100%;"><div style="float: left;"><img src="../../img/swal_alert/exclamacion.png"></div><div float: right;color:#721c24;"    class="font_alert"><p class="font_alert" style="font-weight: bold; text-align: center;">Seleccionar registros</p>Es necesario seleccionar algun registro de la lista para eliminar</div></div>',
                position: 'top-end',
                showConfirmButton: false,
                width: 500,
                background: '#f5c6cb',
                timer: 1500
            });
            return false;
        } else {
            $.ajax({
                url: "../../controller/controller_funciones_usuarios.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    'id_users_active': JSON.stringify(user_ids)
                }
            }).done(function(res) {
                if (res.acc == true) {
                    Swal.fire({
                        html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Usuario(s) activados</div><div>' + res.msg + '</div></div>',
                        confirmButtonColor: "#000461"
                    }).then(function() {
                        window.location.href = "./?menu=usuarios";
                    });
                } else {
                    Swal.fire({
                        html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/error_info.png" width="150px" ><div style="font-weight: bolder;">Algo salio mal</div><div>' + res.msg + '</div></div>',
                        confirmButtonColor: "#ff7070"
                    }).then(function() {
                        window.location.href = "./?menu=usuarios";
                    });
                }
            })
        }
    });

    $("#excel").on("click", function(e) {
        //debugger;
        var folios_id = []
        $("input[type=checkbox]:checked").each(function(index) {
            if ($(this).closest('td').siblings().eq(0).text() != '') {
                var folio_registro = $(this).closest('td').siblings().eq(1).text();
                folios_id.push(folio_registro);
            }

        });
        if (folios_id.length == 0) {
            Swal.fire({
                html: '<div style="width: 100%;"><div style="float: left;"><img src="../../img/swal_alert/exclamacion.png"></div><div float: right;color:#721c24;"    class="font_alert"><p class="font_alert" style="font-weight: bold; text-align: center;">Seleccionar registros</p>Es necesario seleccionar algun registro de la lista para exportar</div></div>',
                position: 'top-end',
                showConfirmButton: false,
                width: 500,
                background: '#f5c6cb',
                timer: 1500
            });
            return false;
        } else {
            $('.excelButton').click();
        }
    });

    $('body').on("click", "button[id=btnEdit]", function(e) {
        //debugger;
        var checkbox = $(this).closest('td').siblings().eq(1).text();
        $('#' + checkbox).prop('checked', false)
        var id_usuario = $(this).closest('td').siblings().eq(1).text();
        var nombre = $(this).closest('td').siblings().eq(2).text();
        var apellido_p = $(this).closest('td').siblings().eq(3).text();
        var apellido_m = $(this).closest('td').siblings().eq(4).text();
        var correo = $(this).closest('td').siblings().eq(5).text();
        var username = $(this).closest('td').siblings().eq(6).text();
        var idrol = $(this).closest('td').siblings().eq(7).text();
        var status = $(this).closest('td').siblings().eq(9).text();
        $('#modal_update').modal('show');
        $("#id").val(id_usuario);
        $("#nombre").val(nombre);
        $("#apellidoP").val(apellido_p);
        $("#apellidoM").val(apellido_m);
        $("#correo").val(correo);
        $("#username").val(username);
        $("#rol").val(idrol);
        if (status == 'Activo') {

            $("#estatus").val(1);
        } else {
            $("#estatus").val(0);
        }

    });

    $('#update_user').submit(function(event) {
        event.preventDefault();
        if ($('#update_user')[0].checkValidity() === false) {
            event.stopPropagation();
        } else {
            var id = $.trim($("#id").val());
            var nombre = $.trim($("#nombre").val());
            var ap = $.trim($("#apellidoP").val());
            var am = $.trim($("#apellidoM").val());
            var correo = $.trim($("#correo").val());
            var username = $.trim($("#username").val());
            var enc = $.trim($("#enc").val());
            var rol = $.trim($("#rol").val());
            var estatus = $.trim($("#estatus").val());
            var datos = {
                id: id,
                nombre: nombre,
                apellidoP: ap,
                apellidoM: am,
                correo: correo,
                username: username,
                enc: enc,
                rol: rol,
                estatus: estatus
            };
            $.ajax({
                url: "../../controller/controller_actualizar_usuarios.php",
                type: "POST",
                dataType: "JSON",
                async: true,
                data: datos,
                success: function(data) {
                    var estatus = data[0].st;

                    if (estatus == true) {
                        event.preventDefault();
                        Swal.fire({
                            html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Registro Exitoso</div><div>El usuario se ha actualizado correctamente!</div></div>',
                            confirmButtonColor: "#000461"
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/file_error.gif" width="150px"><div style="font-weight: bolder;">Algo salio mal</div><div>El nombre de usuario/correo electrónico ya existe!</div></div>',
                            confirmButtonColor: "#ff7070"
                        }).then(function() {
                            return false;
                            //location.reload();
                        });
                    }

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("No se pudo conectar al servicio, intente nuevamente");
                }
            });
        }
        $('#update_user').addClass('was-validated');
    });

    $("#agregar_user").on("click", function(e) {
        $('#modal_insert').modal('show');
    })

    $('#insert_user').submit(function(event) {
        event.preventDefault();

        if ($('#insert_user')[0].checkValidity() === false) {
            event.stopPropagation();
        } else {
            $.ajax({
                url: "../../controller/controller_registra_usuario.php",
                type: "POST",
                data: $("#insert_user").serialize(),
                dataType: 'json',
                success: function(data) {
                    if (data.res == true) {
                        event.preventDefault();
                        Swal.fire({
                            html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Registro Exitoso</div><div>' + data.msg + '</div></div>',
                            confirmButtonColor: "#000461"
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/file_error.gif" width="150px"><div style="font-weight: bolder;">Algo salio mal</div><div>' + data.msg + '</div></div>',
                            confirmButtonColor: "#ff7070"
                        }).then(function() {
                            return false;
                            //location.reload();
                        });
                    }

                }

            });

        }
        $('#insert_user').addClass('was-validated');
    });
</script>