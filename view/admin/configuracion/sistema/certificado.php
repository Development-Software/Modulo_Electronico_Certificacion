<form id="form-certificado-<?php echo $id_form ?>" style="text-align: center;">
    <div>
        <h4 class="card-title" style="float: none;"><strong>Instrucciones:</strong> Favor de validar que los datos del nombre y CURP sean correctos.</h4>
    </div>
    <hr width="100%" class="bg-danger" />
    <div id="cer_panel">
             <div class="row justify-content-center">
                 <div class="col-md-3"><label>Numero de Serie</label></div>
                 <div class="col-md-4"><input readonly class="form-control form-control-sm" type="text" name="numero_serie" id="numero_serie" value="<?php if($cargar_datos_cer=='0'||$cargar_datos_cer=='2') {echo $serialHexCer;} else {echo $serie_cer_db; }  ?>"  autocomplete="off"></div>
             </div>
             <div class="row justify-content-center">
                 <div class="col-md-3"><label>Nombre</label></div>
                 <div class="col-md-4"><input readonly class="form-control form-control-sm" type="text" name="nombre_aut" id="nombre_aut" value="<?php if($cargar_datos_cer=='0'||$cargar_datos_cer=='2') {echo $nombreCer;} else {echo $nombre_cer_db; } ?>"  autocomplete="off"></div>
             </div>
             <div class="row justify-content-center">
                 <div class="col-md-3"><label>CURP</label></div>
                 <div class="col-md-4"><input readonly class="form-control form-control-sm" type="text" name="CURP" id="CURP" value="<?php if($cargar_datos_cer=='0'||$cargar_datos_cer=='2') {echo $serialCer;} else {echo $curp_cer_db; } ?>" autocomplete="off"></div>
             </div>
         </div>
         <br>
         <div class="row justify-content-center">
        <?php if($cargar_datos_cer=='0'||$cargar_datos_cer=='2') {
            echo '<div id="back_sign" class="col-md-2 btn_test"><input type="button" class="btn btn-outline-secondary" onclick="cambio_tab()" value="Regresar"></input></div>
            <div id="save_sign" class="col-md-2 btn_test"><input id="save_cer" type="button" class="btn btn-primary" value="Guardar"></input></div>';
        } else{
            echo '<div id="back_sign" class="col-md-2 btn_test"><input type="button" class="btn btn-outline-secondary" onclick="cambio_tab_2()" value="Cambiar"></input></div>' ;
        }?>          
         </div>
</form>
<?php if($cargar_datos_cer=='1'){include_once 'cargar_firma.php';}?>
<script>
    $(document).ready(function(){
        $("#form-firma").attr('style', 'text-align: center; display:none;');
    });

    function cambio_tab(){
        $('#form-certificado-1').attr('style', 'text-align: center; display:none;');
        $("#form-firma").attr('style', 'text-align: center; display:block;');
    }
    function cambio_tab_2(){
        $('#form-certificado-0').attr('style', 'text-align: center; display:none;');
        $("#form-firma").attr('style', 'text-align: center; display:block;');
    }
</script>

<script type="text/javascript">
	$('#save_cer').on("click",function(e) {
        e.preventDefault();
        
		$.ajax({
	        url: "../../controller/controller_registro_cer.php",
	        type: "POST",
	        data: $("#form-certificado-1").serialize(),
				success: function (data) {
                 if(data==true){
                    e.preventDefault();
					Swal.fire({
                            html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Registro Exitoso</div><div>La información fue registrada exitosamente</div></div>',
                            confirmButtonColor: "#000461"
                        });

                  }else{
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

		}).done(function(res){
				console.log(res);
                $('#save_sign').attr('style', 'display:none;');
		    });
});

</script>
