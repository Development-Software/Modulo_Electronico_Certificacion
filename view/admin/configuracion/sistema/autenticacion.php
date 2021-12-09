<!--Contenido autenticacion-->
<form id="form-autenticacion" onsubmit="return validacion()" style="text-align: center;">
    <div>
        <h4 class="card-title" style="float: none;"><strong>Instrucciones:</strong> Selecciona un método de autenticación para accesar al sistema</h4>
    </div>
    <hr width="100%" class="bg-primary" />
    <div class="col-md-12">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <!-- directorio activo-->
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="origenAD" <?php echo $checkedAD; ?>>
                    <label class="custom-control-label" for="origenAD">Directorio activo</label>
                </div>
            </div>
            <div class="col-md-4">
                <!-- base de datos-->
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="origenDB" <?php echo $checkedBD; ?>>
                    <label class="custom-control-label" for="origenDB">Autenticación del sistema</label>
                </div>
            </div>
            <input type="hidden" name="tipo" id="tipo" value="" required="" maxlength="1">
        </div>
        <br>
        <div class="row justify-content-center">
            <div id="ad_comment" class="col-12" style="display: none;">Es necesario ingresar los siguientes datos para poder conectar al directorio activo correctamente.</div>
            <div id="bd_comment" class="col-12" style="display: none;">Al seleccionar esta opción las contraseñas serán las que se otorgen en la sección de usuarios al momento de la creación.</div>
        </div>
        <br>
        <!--Panel para datos de Directorio Activo-->
        <div id="ad_panel" style="display: none;">
            <div class="row justify-content-center">
                <div class="col-md-3"><label>Dominio</label></div>
                <div class="col-md-4"><input class="form-control form-control-sm" type="text" name="dominio" id="dominio" value="<?php echo $tipoAutenticacion['LDAP_Domain']; ?>" maxlength="50" autocomplete="off"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3"><label>BaseDn</label></div>
                <div class="col-md-4"><input class="form-control form-control-sm" type="text" name="BaseDn" id="BaseDn" value="<?php echo $tipoAutenticacion['BaseDn']; ?>" maxlength="50" autocomplete="off"></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-3"><label>Atributo de Busqueda</label></div>
                <div class="col-md-4"><input class="form-control form-control-sm" type="text" name="searchattr" id="searchattr" value="<?php echo $tipoAutenticacion['SearchAttr']; ?>" maxlength="50" autocomplete="off"></div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div id="test" class="col-md-3 btn_test" style="display:none"><button class="btn btn-secondary">Probar Conexión</button></div>
            <div id="save_1" class="col-md-1"><button id="save" class="btn btn-primary" type="button">Guardar</>
            </div>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        if ($('#origenAD').prop('checked')) {
            $('#ad_panel').attr('style', 'display:block;margin-bottom: 15px;');
            $('#test').attr('style', 'display:block');
            $('#ad_comment').attr('style', 'display:block');
            $('#bd_comment').attr('style', 'display:none');
            $('#tipo').val(0);
        } else {
            $('#ad_panel').attr('style', 'display:none');
            $('#test').attr('style', 'display:none');
            $('#ad_comment').attr('style', 'display:none');
            $('#bd_comment').attr('style', 'display:block');
            $('#tipo').val(1);
        }
    });

    $("#origenAD").change(function() {
        if ($('#origenAD').prop('checked')) {
            $('#origenDB').prop('checked', false);
            $('#ad_panel').attr('style', 'margin-bottom: 15px;');
            $('#ad_panel').slideDown();
            $('#test').slideDown();
            $('#ad_comment').slideDown();
            $('#bd_comment').slideUp();
            $('#tipo').val(0);
        } else {
            $('#origenDB').prop('checked', true);
            $('#ad_panel').slideUp();
            $('#test').slideUp();
            $('#ad_comment').slideUp();
            $('#bd_comment').slideDown();
            $('#tipo').val(1);
        }

    });
    $("#origenDB").change(function() {

        if ($('#origenDB').prop('checked')) {
            $('#origenAD').prop('checked', false);
            $('#ad_panel').slideUp();
            $('#test').slideUp();
            $('#ad_comment').slideUp();
            $('#bd_comment').slideDown();
            $('#tipo').val(1);

        } else {
            $('#origenAD').prop('checked', true);
            $('#ad_panel').attr('style', 'margin-bottom: 15px;');
            $('#ad_panel').slideDown();
            $('#test').slideDown();
            $('#ad_comment').slideDown();
            $('#bd_comment').slideUp();
            $('#tipo').val(0);
        }

    });
</script>
<script type="text/javascript">
    function validacion() {
        if ($('#origenAD').prop('checked')) {
            if ($('#dominio').val() == null || $('#BaseDn').val() == '' || $('#searchattr').val() == '') {
                Swal.fire({
                    html: '<div style="width: 100%;"><div style="float: left;"><img src="../../img/swal_alert/exclamacion.png"></div><div float: right;color:#721c24;"    class="font_alert"><p class="font_alert" style="font-weight: bold; text-align: center;">Datos Incompletos</p>Es necesario ingresar todos los datos para continuar</div></div>',
                    position: 'top-end',
                    showConfirmButton: false,
                    width: 400,
                    background: '#f5c6cb',
                    timer: 1000
                });
                return false;
            } else {
                return true
            }
        } else {
            return true;
        }
    }

    $('#save').on("click", function(e) {
        e.preventDefault();
        if (validacion()) {

            $.ajax({
                url: "../../controller/controller_registro_aut.php",
                type: "POST",
                data: $("#form-autenticacion").serialize(),
                success: function(data) {
                    if (data == true) {
                        e.preventDefault();
                        Swal.fire({
                            html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Registro Exitoso</div><div>La información fue registrada exitosamente</div></div>',
                            confirmButtonColor: "#000461"
                        });

                    } else {
                        Swal.fire({
                            html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/error_info.png" width="150px"><div style="font-weight: bolder;">Algo salio mal</div><div>Ha ocurrido un error,favor de intentarlo nuevamente</div></div>',
                            confirmButtonColor: "#ff7070"
                        });
                    }


                },
                error: function() {
                    Swal.fire({
                        html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/error_info.png" width="150px"><div style="font-weight: bolder;">Algo salio mal</div><div>Ha ocurrido un error,favor de intentarlo nuevamente</div></div>',
                        confirmButtonColor: "#ff7070"
                    });
                }

            });
        }

    });
</script>