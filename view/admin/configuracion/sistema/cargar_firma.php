<form id="form-firma" style="text-align: center;" enctype="multipart/form-data">
    <div>
        <h4 class="card-title" style="float: none;"><strong>Instrucciones:</strong>Favor de cargar el certificado de la firma que sellara los certificados</h4>
    </div>
    <hr width="100%" class="bg-danger" />
    <div class="col-md-12">
        <div class="row justify-content-center">
            <div class="custom-file" style="width: 35%;">
                <input name="certificado" type="file" accept=".cer" class="custom-file-input" id="customFileLang" lang="es">
                <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
            </div>
            <script>
                $(".custom-file-input").on("change", function() {
                    var fileName = $(this).val().split("\\").pop();
                    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
                });
            </script>
        </div>
        <br>
        <div>
            <h6><strong class="text-danger">Nota:</strong>Es necesario que la firma ingresada coincida con los datos de la autoridad registrada en el catalogo de la institución.</h6>
        </div>
        <br>
        <div class="row justify-content-center">
            <div id="valida" class="col-md-2 btn_test"><input type="button" class="btn btn-secondary" onclick="validar(this.form, this.form.certificado.value)" value="Validar Datos"></input></div>

        </div>
    </div>
</form>
<div id="seccion_datos_cer"></div>
<script>
    function validar(formulario, archivo) {
        extensiones_permitidas = new Array(".cer");
        if (!archivo) {
            //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
            Swal.fire({
                html: '<div style="width: 100%;"><div style="float: left;"><img src="../../img/swal_alert/exclamacion.png"></div><div float: right;color:#721c24;"    class="font_alert"><p class="font_alert" style="font-weight: bold; text-align: center;">Datos Incompletos</p>Es necesario ingresar todos los datos para continuar</div></div>',
                position: 'top-end',
                showConfirmButton: false,
                width: 400,
                background: '#f5c6cb',
                timer: 1000
            });
        } else {
            //recupero la extensión de este nombre de archivo
            extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
            //compruebo si la extensión está entre las permitidas
            permitida = false;
            for (var i = 0; i < extensiones_permitidas.length; i++) {
                if (extensiones_permitidas[i] == extension) {
                    permitida = true;
                    break;
                }
            }
            if (!permitida) {
                Swal.fire({
                    html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Alerta.gif" width="150px"><div style="font-weight: bolder;">Formato incorrecto</div><div>El archivo contiene una extensíón o formato incorrecto</div></div>',
                    confirmButtonColor: "#000461"
                });
            } else {
                //submito!
                //e.preventDefault();
                var f = $(this);
                var formData = new FormData(document.getElementById("form-firma"));
                formData.append("dato", "valor");
                $.ajax({
                        url: "../../controller/controller_extraer_certificado.php",
                        type: "post",
                        dataType: "html",
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false
                    })
                    .done(function(res) {
                        $("#form-firma").attr('style', 'display:none');
                        $("#seccion_datos_cer").html(res);
                    });
                return true;
            }
        }
        //si estoy aqui es que no se ha podido submitir
        return false;
    }
</script>