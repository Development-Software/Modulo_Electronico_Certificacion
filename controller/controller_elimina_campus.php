<?php
include_once dirname(__DIR__) . '/model/db.php';
include_once dirname(__DIR__)  . '/model/permisos.php';
include_once dirname(__DIR__)  . '/model/configuracion.php';
include_once dirname(__DIR__)  . '/controller/controller_sesion.php';
include_once dirname(__DIR__)  . '/model/campus.php';
include_once dirname(__DIR__)  . '/model/bitacora.php';
$registro_bitacora = new bitacora();
$campus=new campus();

if (!empty($_POST['usuarios']) && !empty($_POST['idCampus'])) {
    $registros = json_decode($_POST['usuarios']);
    $idCampus = json_decode($_POST['idCampus']);
    $campus->setIdCampus($idCampus);
    $usuarios_asignados=0;
    foreach($registros as $idUsuario){
        $campus->setidUsuario($idUsuario);
        $insert=$campus->getdeleteCampusUsuario();
        if($insert){
            $usuarios_asignados=$usuarios_asignados+1;
        }
    }
if($usuarios_asignados==count($registros)){
    $res = array("acc" => true, "msg" => "Se eliminaron los usuarios en el campus de forma exitosa.");

}elseif($usuarios_asignados<count($registros)){
    $res = array("acc" => true, "msg" => "Solo se eliminaron ".$usuarios_asignados."de un total de ".count($registros));
}else{
    $res = array("acc" => false, "msg" => "No se pudieron eliminar los usuarios, favor de intentar mas tarde");
}
$registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Campus','Eliminación de permisos al campus con id : '.$idCampus.' a los usuarios con id(s): '.json_encode($registros).' respuesta de la ejecución: '.$res['msg']);
echo $var = json_encode($res);
}