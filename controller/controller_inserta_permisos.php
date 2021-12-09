<?php
include '../model/db.php';
include '..//model/permisos.php';
include '../model/configuracion.php';
include '../controller/controller_sesion.php';
include '../model/roles.php';
include '../model/bitacora.php';
$registro_bitacora = new bitacora();
$permisos = new roles();

if (!empty($_POST['permisos']) && !empty($_POST['idrol'])) {
    $registros = json_decode($_POST['permisos']);
    //echo var_dump($registros);
    $idrol = json_decode($_POST['idrol']);
    $permisos->setIdRol($idrol);
    $permisos_registrados = 0;
    $delete = $permisos->getDeletePermisos();
    if ($delete) {
        foreach ($registros as $id_permiso) {
            $permisos->setidPermiso($id_permiso);
            $insert = $permisos->getInsertPermisosRol();
            if ($insert) {
                $permisos_registrados = $permisos_registrados + 1;
            }
        }
        if(count($registros)==$permisos_registrados){
            $res = array("acc" => true, "msg" => "Se registraron los permisos de forma exitosa.");
        }elseif($permisos_registrados>0){
            $res = array("acc" => true, "msg" => "Solo se registraron ".$permisos_registrados."de un total de ".count($registros));
        }else{
            $res = array("acc" => false, "msg" => "No se pudieron registrar los permisos, favor de intentar mas tarde");
        }
    }else{
        $res = array("acc" => false, "msg" => "No se pudieron registrar los permisos, favor de intentar mas tarde");
    }
}else{
    $res = array("acc" => false, "msg" => "No se pudieron registrar los permisos, favor de intentar mas tarde");
}
$registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Roles','Registro de permisos al idRol: '.$idrol.' con id(s): '.json_encode($registros).' respuesta de la ejecución: '.$res['msg']);
echo $var = json_encode($res);
