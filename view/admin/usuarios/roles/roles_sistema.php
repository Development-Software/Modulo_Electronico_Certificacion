<div id="panel-registros" style="width:95%;margin:auto;">
    <br>
    <div id="panel_carga" style="text-align: center;" class="row justify-content-center align-items-center minh-100">
        <p style="text-align: left;"><strong>Instrucciones:</strong><br>Selecciona del menu de acciones lo que requieras ejecutar, recuerda que al desactivar un perfil se desactivaran todos los usuarios que esten asignados a el.</p>
    </div>
    <div class=" justify-content-center align-items-center minh-100">
        <div style="text-align: center;">
            <div class="card-table">
                <div class="row toolsbar_user">
                    <div class="col-md-6" style="text-align: left;">
                        <?php if ($permiso_agregar) {
                            echo
                                "<button title=\"Agregar\" id=\"agregar_rol\" type=\"button\" class=\"btn btn-outline-white btn-rounded btn-sm px-2\">
                            <i class=\"fas fa-user-shield fa-lg\" style=\"color: blue;\"></i> Agregar Rol/Perfil
                        </button>";
                        } ?>
                        <?php if ($permiso_activar) {
                            echo
                                "<button title=\"Desactivar\" id=\"desactivar_rol\" type=\"button\" class=\"btn btn-outline-white btn-rounded btn-sm px-2\">
                            <i class=\"fas fa-lock fa-lg\" style=\"color: red;\"></i> Desactivar Rol/Perfil
                        </button>
                        <button title=\"Activar\" id=\"activar_rol\" type=\"button\" class=\"btn btn-outline-white btn-rounded btn-sm px-2\">
                            <i class=\"fas fa-lock-open fa-lg\" style=\"color: green;\"></i> Activar Rol/Perfil
                        </button>";
                        } ?>
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
                        <table id="tabla_roles" class="table table-bordered" style="width: 95%;margin: auto; font-size:smaller;color:#fff !important;">
                            <thead style="background-color: #00000038;color: #150485;">
                                <th>
                                    <input type="checkbox" id="select_all" />
                                </th>
                                <th style="display: none;">IdRol</th>
                                <th>Perfil</th>
                                <th>Estatus</th>
                                <th>Usuarios activos</th>
                                <th>Usuarios inactivos</th>
                                <th>Fecha de creación</th>
                                <th>Ultima modificación</th>
                                <th><?php if ($permiso_editar) {
                                        echo 'Asignar permisos';
                                    } ?></th>
                                <th><?php if ($permiso_editar) {
                                        echo 'Editar';
                                    } ?></th>
                                    <th style="display: none;">Administrador</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($datosReporte as $row) {
                                ?>
                                    <tr>
                                        <td>
                                            <input class="form-check-input position-static" style="margin: auto;" type="checkbox" id="<?php echo $row['idUsuario'] ?>" value="option1" aria-label="...">
                                        </td>
                                        <td style="display: none;"><?php echo $row['idRol']; ?></td>
                                        <td><?php echo $row['Descripcion']; ?></td>
                                        <td><?php $row['Activo'] == 1 ? $label = "<span class='badge badge-success' style='font-weight: normal !important;font-size:100%;'>Activo</span>" : $label = "<span class='badge badge-danger' style='font-weight: normal !important;font-size:100%;'>Inactivo</span>";
                                            echo $label ?></td>
                                        <td><?php echo $row['Usuarios_activos']; ?></td>
                                        <td><?php echo $row['Usuarios_inactivos']; ?></td>
                                        <td><?php echo $row['Fecha_registro']; ?></td>
                                        <td><?php echo $row['Ultima_mod']; ?></td>
                                        <td align="center">
                                            <?php if ($permiso_editar) {
                                                echo     "<button id=\"btnsecure\" style=\"border: none; background-color:transparent;\">
                                                <img src=\"../../img/usuarios/proteger.png\" width=\"20px\">
                                            </button>";
                                            } else {
                                                echo     "<button id=\"btnsecure\" style=\"border: none; background-color:transparent;\" disabled>
                                                <img src=\"../../img/usuarios/proteger.png\" width=\"20px\">
                                            </button>";
                                            } ?>
                                        </td>
                                        <td align="center">
                                            <?php if ($permiso_editar) {
                                                echo  "<button id=\"btnEdit\" style=\"border: none; background-color:transparent;\">
                                                <img src=\"../../img/usuarios/EditUser.png\" width=\"20px\">
                                            </button>";
                                            } else {
                                                echo  "<button id=\"btnEdit\" style=\"border: none; background-color:transparent;\" disabled>
                                                <img src=\"../../img/usuarios/EditUser.png\" width=\"20px\">
                                            </button>";
                                            } ?>
                                        </td>
                                        <td style="display: none;"><?php echo $row['Administrador']; ?></td>
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
                <h5 class="modal-title" id="emodal_updateLabel">Actualizar Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="update_rol" class="needs-validation" novalidate>
                    <input type="hidden" name="id" id="id">
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control form-control-sm" id="nombre" required>
                        <div class="invalid-feedback">Este campo es obligatorio.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="estatus" class="col-form-label">Estatus:</label>
                        <select name="estatus" id="estatus" class="form-control form-control-sm">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;margin-top:10px;text-align:center;">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="admin" >
                            <label class="custom-control-label" for="admin">Administrador</label>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="update_rol" id="update_button">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Insert -->
<div class="modal fade" id="modal_insert" tabindex="-1" role="dialog" aria-labelledby="modal_insert" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to right, rgba(242,246,248,1) 0%, rgba(216,225,231,1) 23%, rgba(181,198,208,1) 54%, rgba(224,239,249,1) 100%);">
                <h5 class="modal-title" id="modal_insert">Crear Perfil</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="insert_rol" class="needs-validation" novalidate>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="nombre_rol" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control form-control-sm" id="nombre_rol" name="nombre_rol" required>
                        <div class="invalid-feedback">Este campo es obligatorio y solo debes ingresar letras.</div>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;">
                        <label for="estatus_rol" class="col-form-label">Estatus:</label>
                        <select name="estatus_rol" id="estatus_rol" name="estatus_rol" class="form-control form-control-sm">
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                        </select>
                    </div>
                    <div class="form-group" style="font-size: small; margin:0;margin-top:10px;text-align:center;">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="admin_insert" name="admin_insert" >
                            <label class="custom-control-label" for="admin_insert">Administrador</label>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary" form="insert_rol" id="insert_button">Guardar cambios</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal permisos -->
<div class="modal fade" id="modal_permisos" tabindex="-1" role="dialog" aria-labelledby="modal_permisos" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to right, rgba(242,246,248,1) 0%, rgba(216,225,231,1) 23%, rgba(181,198,208,1) 54%, rgba(224,239,249,1) 100%);">
                <h5 class="modal-title" id="modal_permisos">Asignar permisos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="editar_resul" style="overflow-y: scroll;max-height: 500px;">


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <!-- <button type="submit" class="btn btn-primary" form="permisos_insert" id="permisos_button">Guardar cambios</button> -->
                <input type="button" class="btn btn-primary" id="form_permisos" value="Guardar Cambios">
            </div>
        </div>
    </div>
</div>



<script>
    $(document).ready(function() {
        let table = $('#tabla_roles').DataTable({
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
                title: 'MEC 2.0|UniverMilenium-Reporte de Perfiles'
            }]


        });

        $('#tabla_roles').on('click', '#select_all', function() {
            if ($('#select_all:checked').val() === 'on')
                table.rows().select();
            else
                table.rows().deselect();
        });
        $('#select_all').change(function() {
            var checkboxes = $(this).closest('table').find(':checkbox');
            checkboxes.prop('checked', $(this).is(':checked'));
        });

        $('#tabla_roles_filter').attr('style', 'z-index: 3 !important;position: absolute;right: 245px;margin-top: -50px; display:none;');
        $('head').append('<style> .card-table-header-primary{ background: linear-gradient(60deg, #ff0000, #ff7c7c) !important;} .page-link{color:#000000 !important} .page-item.active .page-link {z-index: 3;color: #fff !important;background-color: #343434 !important;border-color: #303030 !important;}</style>');
        $("button.excelButton span").remove();
        $("button.excelButton").html('<i class="fas fa-file-excel fa-lg"></i>');

    });

    $("#buscar").on("click", function(e) {
        //debugger;

        if ($('#buscar_id').val() == 0) {

            $("#tabla_roles_filter").slideDown();
            $('#buscar_id').val(1);
        } else {
            $("#tabla_roles_filter").slideUp();
            $('#buscar_id').val(0);
        }

    });

    $("#excel").on("click", function(e) {
        //debugger;
        var idRol = []
        $("input[type=checkbox]:checked").each(function(index) {
            if ($(this).closest('td').siblings().eq(0).text() != '') {
                var idRol_1 = $(this).closest('td').siblings().eq(1).text();
                idRol.push(idRol_1);
            }

        });
        if (idRol.length == 0) {
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

    $("#desactivar_rol").on("click", function(e) {
        //debugger;
        var idrol = []
        $("input[type=checkbox]:checked").each(function(index) {
            if ($(this).closest('td').siblings().eq(0).text() != '') {
                var idrol_registro = $(this).closest('td').siblings().eq(0).text();
                idrol.push(idrol_registro);
            }

        });

        if (idrol.length == 0) {
            Swal.fire({
                html: '<div style="width: 100%;"><div style="float: left;"><img src="../../img/swal_alert/exclamacion.png"></div><div float: right;color:#721c24;"    class="font_alert"><p class="font_alert" style="font-weight: bold; text-align: center;">Seleccionar registros</p>Es necesario seleccionar algun registro de la lista para desactivar</div></div>',
                position: 'top-end',
                showConfirmButton: false,
                width: 500,
                background: '#f5c6cb',
                timer: 1500
            });
            return false;
        } else {
            Swal.fire({
                html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/bloquearusuario.png" width="150px"><div style="font-weight: bolder;">Desactivar perfile(s)</div><div>Al desactivar rol o perfil, se desactivaran todos los usuarios que pertenecen a el. .</div><div style="font-weight: bold;font-size: medium;">¿Deseas continuar?</div></div>',
                confirmButtonColor: "#000461",
                confirmButtonText: "Si",
                showCancelButton: true,
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "../../controller/controller_funciones_roles.php",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'idRol_disabled': JSON.stringify(idrol)
                        }
                    }).done(function(res) {
                        if (res.acc == true) {
                            Swal.fire({
                                html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Usuario(s) y Roles desactivados</div><div>' + res.msg + '</div></div>',
                                confirmButtonColor: "#000461"
                            }).then(function() {
                                window.location.href = "./?menu=roles";
                            });
                        } else {
                            Swal.fire({
                                html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/error_info.png" width="150px" ><div style="font-weight: bolder;">Algo salio mal</div><div>' + res.msg + '</div></div>',
                                confirmButtonColor: "#ff7070"
                            }).then(function() {
                                window.location.href = "./?menu=roles";
                            });
                        }
                    })
                }
            });
        }
    });

    $("#activar_rol").on("click", function(e) {
        //debugger;
        var idrol = []
        $("input[type=checkbox]:checked").each(function(index) {
            if ($(this).closest('td').siblings().eq(0).text() != '') {
                var idrol_registro = $(this).closest('td').siblings().eq(0).text();
                idrol.push(idrol_registro);
            }

        });

        if (idrol.length == 0) {
            Swal.fire({
                html: '<div style="width: 100%;"><div style="float: left;"><img src="../../img/swal_alert/exclamacion.png"></div><div float: right;color:#721c24;"    class="font_alert"><p class="font_alert" style="font-weight: bold; text-align: center;">Seleccionar registros</p>Es necesario seleccionar algun registro de la lista para activar</div></div>',
                position: 'top-end',
                showConfirmButton: false,
                width: 500,
                background: '#f5c6cb',
                timer: 1500
            });
            return false;
        } else {
            $.ajax({
                url: "../../controller/controller_funciones_roles.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    'idRol_active': JSON.stringify(idrol)
                }
            }).done(function(res) {
                if (res.acc == true) {
                    Swal.fire({
                        html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Rol(es) activado(s)</div><div>' + res.msg + '</div></div>',
                        confirmButtonColor: "#000461"
                    }).then(function() {
                        window.location.href = "./?menu=roles";
                    });
                } else {
                    Swal.fire({
                        html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/error_info.png" width="150px" ><div style="font-weight: bolder;">Algo salio mal</div><div>' + res.msg + '</div></div>',
                        confirmButtonColor: "#ff7070"
                    }).then(function() {
                        window.location.href = "./?menu=roles";
                    });
                }
            })
        }
    });
    $('body').on("click", "button[id=btnEdit]", function(e) {
        //debugger;
        var checkbox = $(this).closest('td').siblings().eq(1).text();
        $('#' + checkbox).prop('checked', false)
        var id_rol = $(this).closest('td').siblings().eq(1).text();
        var nombre_rol = $(this).closest('td').siblings().eq(2).text();
        var status = $(this).closest('td').siblings().eq(3).text();
        var admin = $(this).closest('td').siblings().eq(9).text();
        $('#modal_update').modal('show');
        $("#id").val(id_rol);
        $("#nombre").val(nombre_rol);
        if (status == 'Activo') {
            $("#estatus").val(1);
        } else {
            $("#estatus").val(0);
        }
        
        if(admin==1){
            $('#admin').prop('checked', true);
        }

    });

    $('body').on("click", "button[id=btnsecure]", function(e) {
        var id_rol = $(this).closest('td').siblings().eq(1).text();
        $("#editar_resul").load("../../controller/controller_modal_permisos.php?id_rol=" + id_rol, " ", function() {
            $("#editar_resul").show("slow");
        });
        $('#modal_permisos').modal('show');
    });
    $('#update_rol').submit(function(event) {
        event.preventDefault();
        if ($('#update_rol')[0].checkValidity() === false) {
            event.stopPropagation();
        } else {
            var id = $.trim($("#id").val());
            var nombre = $.trim($("#nombre").val());
            var estatus = $.trim($("#estatus").val());
            var admin =  $('#admin').prop('checked');
            
            var datos = {
                id: id,
                nombre: nombre,
                estatus: estatus,
                admin: admin
            };
            $.ajax({
                url: "../../controller/controller_actualizar_roles.php",
                type: "POST",
                dataType: "JSON",
                async: true,
                data: datos,
                success: function(data) {
                    if (data.res == true) {
                        event.preventDefault();
                        Swal.fire({
                            html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Registro Exitoso</div><div>El perfil se ha actualizado correctamente!</div></div>',
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

                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("No se pudo conectar al servicio, intente nuevamente");
                }
            });
        }
        $('#update_rol').addClass('was-validated');
    });

    $("#agregar_rol").on("click", function(e) {
        $('#modal_insert').modal('show');
    })

    $('#insert_rol').submit(function(event) {
        event.preventDefault();

        if ($('#insert_rol')[0].checkValidity() === false) {
            event.stopPropagation();
        } else {
            $.ajax({
                url: "../../controller/controller_registra_roles.php",
                type: "POST",
                data: $("#insert_rol").serialize(),
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
        $('#insert_rol').addClass('was-validated');
    });

    $('#form_permisos').on("click", function(e) {
        var permisos = []
        var idrol = $('#idRol').val()
        $('#tabla_permisos tr').each(function(i, row) {

            var $actualrow = $(row);
            $checkbox = $actualrow.find('input:checked');
            $checkbox.each(function() {
                var id_permiso = $(this).closest('td').siblings().eq(1).text()
                permisos.push(id_permiso);
            });
        });
        if (permisos.length == 0) {
            Swal.fire({
                html: '<div style="width: 100%;"><div style="float: left;"><img src="../../img/swal_alert/exclamacion.png"></div><div float: right;color:#721c24;"    class="font_alert"><p class="font_alert" style="font-weight: bold; text-align: center;">Seleccionar registros</p>Es necesario seleccionar algun permiso de la lista para registrarlo en el perfil</div></div>',
                position: 'top-end',
                showConfirmButton: false,
                width: 500,
                background: '#f5c6cb',
                timer: 1500
            });
            return false;
        } else {
            $.ajax({
                url: "../../controller/controller_inserta_permisos.php",
                type: "POST",
                dataType: "JSON",
                data: {
                    'permisos': JSON.stringify(permisos),
                    'idrol': JSON.stringify(idrol)
                }
            }).done(function(res) {
                if (res.acc == true) {
                    Swal.fire({
                        html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Permisos registrados exitosamente</div><div>' + res.msg + '</div></div>',
                        confirmButtonColor: "#000461"
                    }).then(function() {
                        window.location.href = "./?menu=roles";
                    });
                } else {
                    Swal.fire({
                        html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/error_info.png" width="150px" ><div style="font-weight: bolder;">Algo salio mal</div><div>' + res.msg + '</div></div>',
                        confirmButtonColor: "#ff7070"
                    }).then(function() {
                        window.location.href = "./?menu=roles";
                    });
                }
            })
        }
    });
</script>