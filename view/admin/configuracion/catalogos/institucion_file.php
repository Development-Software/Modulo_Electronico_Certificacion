<form id="form-institucion-file" style="text-align: center;" enctype="multipart/form-data">
    <div>
        <h4 class="card-title" style="float: none;"><strong>Instrucciones:</strong>Seleccione el archivo para cargar los el catalogo correspondiente a la información de institución.</h4>
    </div>
    <hr width="100%" class="bg-dark" />
    <div class="row">
        <div class="col-md-5">
            <small class="form-text text-muted">Solo se permiten las siguientes extensiones: xlsx, xls y csv.</small>
            <br>
            <div class="row justify-content-center">
                <div class="form-group">
                    <input type="file" name="file_institucion" id="file_institucion" class="input-file" accept=".xlsx,.xls,.csv">
                    <label for="file_institucion" class="btn btn-tertiary js-labelFile">
                        <i class="icon fa fa-check"></i>
                        <span class="js-fileName">Archivo Institución</span>
                    </label>
                </div>
            </div>
            <br>
            <div class="row justify-content-center">
                <div id="valida" class="col-md-4"><input id="carga_institucion" type="button" class="btn btn-secondary" value="Cargar Datos"></input></div>

            </div>
        </div>
        <div class="col-md-1" style="border-right: 1px solid #00000029; height: 100px;"></div>
        <div class="col-md-5" style="margin: auto;">
            <div class="row justify-content-center">
                <small class="form-text text-muted">Es necesario el archivo cuente con el formato establecido. Si lo desea puede descargar el ejemplo para apoyarse.</small>
                <a id="descarga_institucion" target="_blank"><input type="image" src="../../img/catalogos/Excel.png" width="60px" style="margin-top: 15px;"></a>
            </div>
        </div>
    </div>
</form>

<script>
    $('#descarga_institucion').click(function(e) {
        e.preventDefault(); //stop the browser from following
        window.location.href = '../../files/layouts/Institucion.xlsx';
    });
    (function() {

        'use strict';

        $('.input-file').each(function() {
            var $input = $(this),
                $label = $input.next('.js-labelFile'),
                labelVal = $label.html();

            $input.on('change', function(element) {
                var fileName = '';
                if (element.target.value) fileName = element.target.value.split('\\').pop();
                fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label.removeClass('has-file').html(labelVal);
            });
        });

    })();
</script>
<script>
    $("#carga_institucion").on("click", function(e) {
        //debugger;


        if ($("#file_institucion")[0].files.length == 0) {
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
            var file = $('#file_institucion')[0].files[0];
            var filename = file.name;
            // recuperamos la extensión del archivo
            var ext = filename.split('.').pop();
            // Convertimos en minúscula porque 
            // la extensión del archivo puede estar en mayúscula
            ext = ext.toLowerCase();
            switch (ext) {
                case 'xls':
                case 'xlsx':
                case 'csv':
                    break;
                default:
                    //alert('El archivo no tiene la extensión adecuada');
                    //this.value = ''; // reset del valor
                    //this.files[0].name = '';
                    filename = '';
                    $('#file_institucion').val('');
                    Swal.fire({
                        html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Alerta.gif" width="150px"><div style="font-weight: bolder;">Formato incorrecto</div><div>El archivo contiene una extensíón o formato incorrecto</div></div>',
                        confirmButtonColor: "#000461"
                    });
                    return false;
            }
        }

        var f = $(this);
        var formData = new FormData(document.getElementById("form-institucion-file"));
        formData.append("dato", "valor");
        $.ajax({
                url: "../../controller/catalogos/controller_carga_institucion.php",
                type: "post",
                dataType: "JSON",
                data: formData,
                cache: false,
                contentType: false,
                processData: false
            })
            .done(function(res) {
                filename = 'Archivo Institución';
                var $input = $('#file_institucion'),
                    $label = $input.next('.js-labelFile');
                $label.addClass('has-file').find('.js-fileName').html(filename)
                $label.removeClass('has-file');
                $("#form-institucion-file")[0].reset();
                if (res.acc == true) {
                    e.preventDefault();
                    Swal.fire({
                        html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Registro Exitoso</div><div>' + res.msg + '</div></div>',
                        confirmButtonColor: "#000461"
                    }).then(function() {
                        location.reload();
                    });

                } else {

                    Swal.fire({
                        html: '<div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/file_error.gif" width="150px"><div style="font-weight: bolder;">Algo salio mal</div><div>' + res.msg + '</div></div>',
                        confirmButtonColor: "#ff7070"
                    }).then(function() {
                        location.reload();
                    });
                    filename = 'Archivo Institución';
                    var $input = $('#file_institucion'),
                        $label = $input.next('.js-labelFile');
                    $label.addClass('has-file').find('.js-fileName').html(filename)
                    $label.removeClass('has-file');
                    $("#form-institucion-file")[0].reset();


                }

            });

    });
</script>