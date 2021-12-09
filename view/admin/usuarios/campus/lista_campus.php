<div id="panel-registros" style="width:95%;margin:auto;">
    <br>
    <div id="panel_carga" style="text-align: center;" class="row justify-content-center align-items-center minh-100">
        <p style="text-align: left;"><strong>Instrucciones:</strong><br>Favor de seleccionar el campus en el que desees modificar el personal asignado, podras agregar o eliminar solo usuarios activos.</p>
    </div>
    <div class=" justify-content-center align-items-center minh-100">
        <div style="text-align: center;">
            <div class="card-table">
                <div class="card-table-body">
                    <div class="table-responsive">
                        <table id="tabla_campus" class="table table-bordered" style="width: 95%;margin: auto; font-size:smaller;">
                            <thead style="background-color: #ffc670;color: #150485;">
                                <th>Id Campus</th>
                                <th>Campus</th>
                                <th>Usuarios Asignados</th>
                                <th>Modificar usuarios</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($datos_registros as $row) {
                                ?>
                                    <tr>
                                        <td><?php echo $row['Id_Campus']; ?></td>
                                        <td><?php echo $row['Campus']; ?></td>
                                        <td><?php echo $row['Usuarios']; ?></td>
                                        <td align="center">
                                            <button id="btnEdit" style="border: none; background-color:transparent;">
                                                <img src="../../img/usuarios/Edit_campus.png" width="20px">
                                            </button>
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
    <div class="row" id="usuarios">
    </div>
</div>

<script>
    $(document).ready(function() {

        $('head').append('<style>.selected{ background-color:#aed9ff !important;}</style>');
    var table_campus = $('#tabla_campus').DataTable({
            dom: '<"bar"f>t<"#tools_l.footer_table"><"#tools_p"p>',
            columnDefs: [{
                orderable: false,
                //className: 'select-checkbox',
                targets: 0,
                blurable: true
            }],

            select: {
                style: 'multi',
                selector: 'td:first-child'
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

    $('#tabla_campus tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table_campus.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
    
    });    


    $('body').on("click", "button[id=btnEdit]", function(e) {
        var id_campus = $(this).closest('td').siblings().eq(0).text();
        $("#usuarios").load("../../controller/controller_tabla_user.php?id_campus=" + id_campus, " ", function() {
            $("#usuarios").show("slow");
        });

    });
</script>