
<?php 
//include_once dirname(dirname(dirname(dirname(dirname(dirname(__DIR__)))))).'/controller/menu/.php';
include_once dirname(dirname(dirname(dirname(__DIR__)))). '/model/db.php';
include_once dirname(dirname(dirname(dirname(__DIR__)))). '/model/configuracion.php';
include_once dirname(dirname(dirname(dirname(__DIR__)))). '/controller/controller_sesion.php';
include_once dirname(dirname(dirname(dirname(__DIR__))))  . '/model/permisos.php';
$configuracion = new configuracion();
$certificado = $configuracion->getFirma();
$curp_cer_db = $certificado['CURP_FIEL'];
$nombre_cer_db = $certificado['Nombre_FIEL'];
$serie_cer_db = $certificado['Numero_Serie_FIEL'];

if ($curp_cer_db != '' && $nombre_cer_db != '' && $serie_cer_db != '') {
    $cargar_datos_cer = '1';
} else {
    $cargar_datos_cer = '0';
}
$cargar_datos_cer='1';
if($cargar_datos_cer=='0'){
include_once 'cargar_firma.php';
}else{
$id_form='0';
include_once 'certificado.php';
}