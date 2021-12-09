 <!--Contenido fuente-->
 <form id="form-fuente" method="POST" onsubmit="return validacion_source();return false;" style="text-align: center;">
     <div>
         <h4 class="card-title" style="float: none;"><strong>Instrucciones:</strong> Selecciona un método de de extracción de información</h4>
     </div>
     <hr width="100%" class="bg-warning" />
     <div class="col-md-12">
         <div class="row justify-content-center">
             <div class="col-md-4">
                 <!-- directorio activo-->
                 <div class="custom-control custom-switch">
                     <input type="checkbox" class="custom-control-input" id="origenfuenteDB" <?php echo $Source_checkedBD; ?>>
                     <label id="db" class="custom-control-label" for="origenfuenteDB">Base de Datos Externa</label>
                 </div>
             </div>
             <div class="col-md-4">
                 <!-- base de datos-->
                 <div class="custom-control custom-switch">
                     <input type="checkbox" class="custom-control-input" id="origenfuenteFile" <?php echo $Source_checkedFile; ?>>
                     <label id="file" class="custom-control-label" for="origenfuenteFile">Carga de Layouts</label>
                 </div>
             </div>
             <input type="hidden" name="tipo_fuente" id="tipo_fuente" value="1" required="" maxlength="1">
         </div>
         <br>
         <div class="row justify-content-center">
             <div id="db_comment" class="col-12">Es necesario ingresar los siguientes datos para poder conectarnos a la base de datos.<br>Al seleccionar esta opción es necesario ingresar los querys de consulta a la base de datos en el menu de catalogos y alumnos.</div>
             <div id="ar_comment" class="col-12">Al seleccionar esta opción será necesario cargar a traves de layouts la informacion necesaria en el menu de catalogos.</div>
         </div>
         <br>
         <!--Panel para datos de Base de Datos-->
         <div id="bd_panel">
             <div class="row justify-content-center">
                 <div class="col-md-3"><label>Servidor-Instancia</label></div>
                 <div class="col-md-4"><input class="form-control form-control-sm" type="text" name="server" id="server" value="<?php echo $tipoAutenticacion['LDAP_Domain']; ?>" maxlength="50" autocomplete="off"></div>
             </div>
             <div class="row justify-content-center">
                 <div class="col-md-3"><label>Usuario</label></div>
                 <div class="col-md-4"><input class="form-control form-control-sm" type="text" name="usuario" id="usuario" value="<?php echo $tipoAutenticacion['BaseDn']; ?>" maxlength="50" autocomplete="off"></div>
             </div>
             <div class="row justify-content-center">
                 <div class="col-md-3"><label>Contraseña</label></div>
                 <div class="col-md-4"><input class="form-control form-control-sm" type="password" name="password" id="password" value="<?php echo $tipoAutenticacion['SearchAttr']; ?>" maxlength="50" autocomplete="off"></div>
             </div>
         </div>
         <div class="row justify-content-center">
             <div id="test_source" class="col-md-2 btn_test"><button class="btn btn-secondary">Probar Conexión</button></div>
             <div id="save_source" class="col-md-1"><button class="btn btn-primary" type="submit">Guardar</button></div>
         </div>
     </div>
 </form>
 <script>
     $(document).ready(function() {
         
         if ($('#origenfuenteDB').prop('checked')) {
             $('#bd_panel').attr('style', 'display:block;margin-bottom: 15px;');
             $('#test_source').attr('style', 'display:block');
             $('#db_comment').attr('style', 'display:block');
             $('#ar_comment').attr('style', 'display:none');
             $('#tipo_fuente').val(0);
         } else {
             $('#bd_panel').attr('style', 'display:none');
             $('#test_source').attr('style', 'display:none');
             $('#db_comment').attr('style', 'display:none');
             $('#ar_comment').attr('style', 'display:block');
             $('#tipo_fuente').val(1);
         }
     });

     $("#origenfuenteDB").change(function() {
         
         if ($('#origenfuenteDB').prop('checked')) {
             $('#origenfuenteFile').prop('checked', false);
             $('#bd_panel').attr('style', 'margin-bottom: 15px;');
             $('#bd_panel').slideDown();
             $('#test_source').slideDown();
             $('#db_comment').slideDown();
             $('#ar_comment').slideUp();
             $('#tipo_fuente').val(0);
         } else {
             $('#origenfuenteFile').prop('checked', true);
             $('#bd_panel').slideUp();
             $('#test_source').slideUp();
             $('#db_comment').slideUp();
             $('#ar_comment').slideDown();
             $('#tipo_fuente').val(1);
         }

     });
     $("#origenfuenteFile").change(function() {
         
         if ($('#origenfuenteFile').prop('checked')) {
             $('#origenfuenteDB').prop('checked', false);
             $('#bd_panel').slideUp();
             $('#test_source').slideUp();
             $('#db_comment').slideUp();
             $('#ar_comment').slideDown();
             $('#tipo_fuente').val(1);

         } else {
             $('#origenfuenteDB').prop('checked', true);
             $('#bd_panel').attr('style', 'margin-bottom: 15px;');
             $('#bd_panel').slideDown();
             $('#test_source').slideDown();
             $('#db_comment').slideDown();
             $('#ar_comment').slideUp();
             $('#tipo_fuente').val(0);
         }

     });
 </script>
 <script type="text/javascript">
     function validacion_source() {
         if ($('#origenfuenteDB').prop('checked')) {
             if ($('#server').val() == '' || $('#usuario').val() == '' || $('#contraseña').val() == '') {
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

     $('#save_source').on("click", function(e) {
         e.preventDefault();
         if (validacion_source()) {

             $.ajax({
                 url: "../../controller/controller_registro_fuente.php",
                 type: "POST",
                 data: $("#form-fuente").serialize(),
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