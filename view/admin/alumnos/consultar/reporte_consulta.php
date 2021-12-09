<div id="panel-registros" style="width:95%;margin:auto;">
    <br>
    <div id="panel_carga" style="text-align: center;" class="row justify-content-center align-items-center minh-100">
        <p style="text-align: left;"><strong>Instrucciones:</strong><br>Se debera seleccionar uno o mas registros para poder descargarse. Solo se mostraran los registros correspondientes a los parametros de seguridad <br>establecidos por el admisitrador.</p>
    </div>
    <div class=" justify-content-center align-items-center minh-100">
        <div style="text-align: center;">
            <div class="card-table">
                <div class="view view-cascade gradient-card-header blue-gradient narrower py-2 mx-4 mb-3 d-flex justify-content-between align-items-center">
                    <div class="card-table-header card-table-header-primary">
                        <h4 class="card-table-title ">Registros XML Generados</h4>
                    </div>
                </div>
                <div class="toolsbar">
                    <button title="Buscar en la tabla" id="buscar" type="button" class="btn btn-outline-white btn-rounded btn-sm px-2">
                        <i class="fas fa-search fa-lg"></i> <input id="buscar_id" style="display: none;" value="0">
                    </button>
                    <button title="Mostrar ordenamiento" id="ordenar" type="button" class="btn btn-outline-white btn-rounded btn-sm px-2">
                        <i class="fas fa-sort-amount-up-alt fa-lg"></i><input id="ordenar_id" style="display: none;" value="0">
                    </button>
                    <?php if($permiso_eliminar){
                    echo "<button title=\"Eliminar registro\" id=\"eliminar\" type=\"button\" class=\"btn btn-outline-white btn-rounded btn-sm px-2\">
                        <i class=\"fas fa-trash-alt fa-lg\"></i>
                    </button>";
                    } ?>
                    <?php if($permiso_exportar){
                        echo "<button title=\"Exportar a excel\" id=\"excel\" type=\"button\" class=\"btn btn-outline-white btn-rounded btn-sm px-2\">
                        <i class=\"fas fa-file-excel fa-lg\"></i>
                    </button>";
                    }
                    ?>
                </div>
                <div class="card-table-body">
                    <div class="table-responsive">
                        <form id="tabla_consulta">
                            <table id="tabla_c" class="table table-striped" style="width: 95%;margin: auto; font-size:smaller;">
                                <thead style="background-color: #c4030352;color: #150485;">
                                    <th>
                                        <!-- <input class="form-check-input position-static" style="margin: auto;" type="checkbox" id="selectall" value="option1" aria-label="seleccionar todos" title="Seleccionar todos"> -->
                                        <input type="checkbox" id="select_all" />
                                    </th>
                                    <th>#</th>
                                    <th>Folio</th>
                                    <!-- <th>CURP</th> -->
                                    <th>Matrícula</th>
                                    <th>Nombre Completo</th>
                                    <th>Campus</th>
                                    <th>Clave de Carrera</th>
                                    <th>Nombre de Carrera</th>
                                    <th>Tipo de certificado</th>
                                    <th>Usuario</th>
                                    <th>Fecha de registro</th>
                                    <th>Fecha de firma</th>
                                    <th>Consultar Cadena</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($registros_consulta != 0) {
                                        foreach ($registros_consulta as $dato) {
                                    ?>
                                            <tr>
                                                <td>
                                                    <input class="form-check-input position-static" style="margin: auto;" type="checkbox" id="<?php echo $dato["Id"] ?>" value="option1" aria-label="...">
                                                </td>
                                                <td><?php echo $dato["Id"] ?></td>
                                                <td><?php echo $dato["Folio_Registro"] ?></td>
                                                <!-- <td><?php echo $dato["CURP"] ?></td> -->
                                                <td><?php echo $dato["Matricula"] ?></td>
                                                <td><?php echo $dato["Nombre"] ?></td>
                                                <td><?php echo $dato["Campus"] ?></td>
                                                <td><?php echo $dato["Clave_Carrera"] ?></td>
                                                <td><?php echo $dato["Nombre_Carrera"] ?></td>
                                                <td><?php echo $dato["Tipo_Certificado"] ?></td>
                                                <td><?php echo $dato["Username"] ?></td>
                                                <td><?php echo $dato["Fecha_Registro"] ?></td>
                                                <td><?php echo $dato["Fecha_XML"] ?></td>
                                                <td><button id="btncadena" style="border: none; background-color:transparent;">
                                                <img src="../../img/enlaces.png" width="20px">
                                            </button></td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <form id="form-descarga" method="POST" action="../../controller/controller_descarga_xml.php">
            <div class="row justify-content-center" style="width: 90%; margin:auto; margin-top:-20px;">
                <input type="text" id="folios_descarga" name="folios_descarga" style="display: none;">
                <?php if($permiso_descargar){ echo "<button id=\"descargar\" class=\"btn\" style=\"background-color: #255ad2; border-color:#255ad2;color:#fff;\">Descargar</button>";}?>
            </div>
        </form>
    </div>
</div>
<!-- Modal cadenas -->
<div class="modal fade" id="modal_permisos" tabindex="-1" role="dialog" aria-labelledby="modal_permisos" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(to right, rgba(242,246,248,1) 0%, rgba(216,225,231,1) 23%, rgba(181,198,208,1) 54%, rgba(224,239,249,1) 100%);">
                <h5 class="modal-title" id="modal_permisos">Cadenas para Sello</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="editar_resul" style="overflow-y: scroll;max-height: 500px;">


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
                [1, "asc"]
            ],
            lengthMenu: [ [1,5,10, 25, 50, -1], [1,5,10, 25, 50, "Todos"] ],
            pageLength: 5,
            ordering: true,
            searching: true,
            /* stateSave: true, */
            buttons: [{
                extend: 'excel',
                className: 'excelButton',
                title: 'MEC 2.0|UniverMilenium-Registros en estatus de firma'
            }],
            scrollY: '400px',
            scrollCollapse: true,
        });
        $('body').on('change', '#select_all', function() {
            var rows, checked;
            rows = $('#tabla_c').find('tbody tr');
            checked = $(this).prop('checked');
            $.each(rows, function() {
                var checkbox = $($(this).find('td').eq(0)).find('input').prop('checked', checked);
            });
        });
        
        $('#tabla_c_filter').attr('style', 'z-index: 3 !important;position: absolute;right: 245px;margin-top: -50px; display:none;');
        $('head').append('<style> .card-table-header-primary{ background: linear-gradient(60deg, #002bff, #4ca4ff) !important;}</style>');
        $("button.excelButton span").remove();
        $("button.excelButton").html('<i class="fas fa-file-excel fa-lg"></i>');
    });

    function refrescar() {
        //Actualiza la página
        location.reload();
    }
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
    $("#ordenar").on("click", function(e) {
        //debugger;
        //alert($('#ordenar_id').val());
        if ($('#ordenar_id').val() == 0) {
            $('head').append('<style>table.dataTable thead .sorting:before, .sorting_asc:before, .sorting_desc:before{display: block!important;}table.dataTable thead .sorting:after, .sorting_asc:after, .sorting_desc:after{ display: block!important;}</style>');
            $('#ordenar_id').val(1);
        } else {
            $('style').remove();
            $('#ordenar_id').val(0);
            $('head').append('<style> .card-table-header-primary{ background: linear-gradient(60deg, #002bff, #4ca4ff) !important;}</style>');
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
    $("#descargar").on("click", function(e) {
        var folios_id = []
        $("input[type=checkbox]:checked").each(function(index) {
            if ($(this).closest('td').siblings().eq(0).text() != '') {
                var folio_registro = $(this).closest('td').siblings().eq(1).text();
                folios_id.push(folio_registro);
            }

        });
        if (folios_id.length == 0) {
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
            setTimeout(refrescar, 2000);
            $('#descargar').slideUp();
            $('#folios_descarga').val(folios_id);
        }

    });

    $("#eliminar").on("click", function(e) {
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
                html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Delete.gif" width="150px"><div style="font-weight: bolder;">Eliminar registros(s)</div><div>Al eliminar estos registros ya no podran recuperarse</div><div style="font-weight: bold;font-size: medium;">¿Deseas continuar?</div></div>',
                confirmButtonColor: "#000461",
                confirmButtonText: "Si",
                showCancelButton: true,
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "../../controller/controller_funciones_registros.php",
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'folios_xml': JSON.stringify(folios_id)
                        }
                    }).done(function(res) {
                        if (res.acc == true) {
                            Swal.fire({
                                html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Eliminación Exitosa Exitoso</div><div>' + res.msg + '</div></div>',
                                confirmButtonColor: "#000461"
                            }).then(function() {
                                window.location.href = "./?menu=consultar";
                            });
                        } else {
                            Swal.fire({
                                html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/error_info.png" width="150px" ><div style="font-weight: bolder;">Algo salio mal</div><div>' + res.msg + '</div></div>',
                                confirmButtonColor: "#ff7070"
                            }).then(function() {
                                window.location.href = "./?menu=consultar";
                            });
                        }
                    })
                }
            });
        }
    });
    $('body').on("click", "button[id=btncadena]", function(e) {
        //debugger;
        var id_registro = $(this).closest('td').siblings().eq(2).text();
        $("#editar_resul").load("../../controller/controller_cadenas.php?id_registro=" + id_registro, " ", function() {
            $("#editar_resul").show("slow");
        });
        $('#modal_permisos').modal('show');
        return false;
    });
</script>