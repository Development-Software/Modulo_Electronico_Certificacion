<div style="width:90%;margin:auto;">
    <br><br>
    <div id="panel_carga" style="text-align: center;" class="row justify-content-center align-items-center minh-100">

        <p style="text-align: left;"><strong>Instrucciones:</strong><br>En este paso, sera necesario ingresar el archivo en formato de Excel o Zip para poder cargar los datos de los estudiantes que se van a certificar.
            <br>Una vez cargado(s) tu(s) archivo(s) podras seleccionar los registros que necesites enviar a firmar.</p>

        <div id="panel_0" class="panel panel-primary text-justify file_input_1" style="width:100%;">
            <div class="panel-heading">
                <h3 class="panel-title">Seleccionar Archivos</h3>
            </div>
            <div class="panel-body">
                <form enctype="multipart/form-data">
                    <input id="input-fas" name="input-fas[]" type="file" accept=".csv,.xls,.xlsx" multiple>
                    <small class="form-text text-muted">Solo se permiten las siguientes extensiones: xlsx, xls y csv.</small>
                </form>
                <div class="alert alert-success" role="alert"> Tu archivo se cargo corretamente</div>
            </div>
        </div>
        <div id="continue" class="row justify-content-center">
            <!-- <div id="cancelar" class="col-md-2 btn_test"><input type="button" class="btn btn-secondary" value="Cancelar"></input></div> -->
            <div id="continuar" class="col-md-2 btn_test"><input type="button" class="btn btn-primary" value="Continuar" onclick="window.location.href = './?menu=generar'"></input></div>
            <div class="col-12" style="font-size: smaller;">Seleccione continuar si desea concluir el proceso con los registros cargados.</div>
        </div>
    </div>
</div>
<script>

</script>
<script>
    // Tipos de archivos admitidos por su extensión
    var tipos = ['xlsx', 'xls', 'csv'];
    // Evento filecleared del plugin que se ejecuta cuando pulsamos el botón 'Quitar'
    //		Vaciamos y ocultamos el div de alerta
    $('#input-fas').on('filecleared', function(event) {
        $('div.alert').empty();
        $('div.alert').hide();
    });


    $("#input-fas").fileinput({
        theme: "fas",
        uploadAsync: true,
        uploadUrl: "../../controller/controller_carga_alumnos.php",
        language: "es",
        previewFileIconSettings: {
            'xls': '<i class="fas fa-file-excel text-success"></i>',
            'xlsx': '<i class="fas fa-file-excel text-success"></i>',
            'csv': '<i class="fas fa-file-excel text-success"></i>',
            'zip': '<i class="fas fa-file-archive text-muted"></i>',
        },
        showCaption: false,
        //showRemove: false,
        showclose: false,
        maxFileCount: 6,
        allowedFileExtensions: tipos,
        layoutTemplates: {
            footer: '<div class="file-thumbnail-footer">\n' +
                '    <div class="file-caption-name" style="width:{width}">{caption}</div>\n' +
                '</div>'
        }
    });

    // Evento filebatchuploadsuccess del plugin que se ejecuta cuando se han enviado todos los archivos al servidor
    $('#input-fas').on('fileuploaded', function(event, data, previewId, index) {
        console.log('test');
        var ficheros = data.files;
        var respuesta = data.response;
        var total = data.filescount;
        var mensaje;
        var archivo;
        var total_tipos = '';
        console.log(respuesta);
        const demoClasses = document.querySelectorAll('.btn-file');
        // Change the text of multiple elements with a loop
        demoClasses.forEach(element => {
            element.setAttribute('style', 'display:none');
        });
        mensaje = '<p>Ficheros ingresados:</p><ul>';
        // Procesamos la lista de ficheros para crear las líneas con sus nombres y tamaños
        for (var i = 0; i < ficheros.length; i++) {
            if (ficheros[i] != undefined) {
                archivo = ficheros[i];
                tam = archivo.size / 1024;
                mensaje += '<li>' + archivo.name + ' (' + Math.ceil(tam) + 'Kb)' + '</li>';
            }
        };
        mensaje += '</ul>';
        // Si el total de archivos indicados por el plugin coincide con el total que hemos recibido en la respuesta del script PHP
        // mostramos mensaje de proceso correcto
        if (respuesta.total == total) mensaje += '<p>Todos los arhivos se procesaron con exito.</p>';
        else mensaje += '<p>Solo ' + respuesta.total + ' archivo(s) se procesaron con exito.</p>';
        // Una vez creado todo el mensaje lo cargamos en el DIV de alerta y lo mostramos
        //$('div.alert').html(mensaje);
        //$('div.alert').show();
        Swal.fire({
            html: ' <div class="font_alert" style="width: 100%;text-align: center;"><img src="../../img/swal_alert/Check.gif" width="250px"><div style="font-weight: bolder;">Registro Exitoso</div><div style="text-align: left;color: #155724;background-color: #d4edda;border-color: #c3e6cb;border-radius: 4px;padding: 5px;">' +mensaje + '</div></div>',
            confirmButtonColor: "#000461"
        }).then(function() {
                        location.reload();
                    });
        
    });
    // Ocultamos el div de alerta donde se muestra un resumen del proceso
    $('div.alert').hide();
    $('#continue').hide();
</script>