<?php
 include_once dirname(dirname(__DIR__)). '/model/db.php';
 include_once dirname(dirname(__DIR__)). '/model/permisos.php';
 include_once dirname(dirname(__DIR__)). '/model/configuracion.php';
 include_once dirname(dirname(__DIR__)). '/controller/controller_sesion.php';
 include_once dirname(dirname(__DIR__)). '/model/alumnos.php';
include_once dirname(dirname(__DIR__))  . '/model/permisos.php';

$configuracion = new configuracion();
$tipoAutenticacion = $configuracion->getTipoAutenticacion();
$tipoAutenticacion['Autenticacion'] == 1 ? $checkedBD = 'checked' : $checkedBD = '';
$tipoAutenticacion['Autenticacion'] == 0 ? $checkedAD = 'checked' : $checkedAD = '';
$tipoFuente = $configuracion->getTipofuente();
$tipoFuente['Fuente'] == 0 ? $Source_checkedBD = 'checked' : $Source_checkedBD = '';
$tipoFuente['Fuente'] == 1 ? $Source_checkedFile = 'checked' : $Source_checkedFile = '';
$certificado = $configuracion->getFirma();
$curp_cer_db = $certificado['CURP_FIEL'];
$nombre_cer_db = $certificado['Nombre_FIEL'];
$serie_cer_db = $certificado['Numero_Serie_FIEL'];

if ($curp_cer_db != '' && $nombre_cer_db != '' && $serie_cer_db != '') {
    $cargar_datos_cer = '1';
} else {
    $cargar_datos_cer = '0';
}

$permisos=new permisos($_SESSION['usuarioid'],$_SESSION['usuarioidRol']);
$t_permisos=$permisos->listar_total_permisos();
$permiso_autenticacion=false;
$permiso_fuente=false;
$permiso_firma=false;
foreach ($t_permisos as $id_permiso){
    if($id_permiso['idPermiso']==31){
        $permiso_autenticacion=true;
    }elseif($id_permiso['idPermiso']==32){
        $permiso_fuente=true;
    }elseif($id_permiso['idPermiso']==33){
        $permiso_firma=true;
    }
/*     echo '<pre>';
    var_dump($id_permiso['idPermiso']);
    echo'</pre>'; */
}
include_once dirname(dirname(__DIR__))  . '/view/admin/configuracion/sistema.php';
