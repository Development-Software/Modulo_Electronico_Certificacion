<?php
include_once dirname(__DIR__) . '/model/db.php';
include_once dirname(__DIR__)  . '/model/permisos.php';
include_once dirname(__DIR__)  . '/model/configuracion.php';
include_once dirname(__DIR__) . '/controller/controller_sesion.php';
include_once dirname(__DIR__) . '/model/alumnos.php';
include_once dirname(__DIR__) . '/model/bitacora.php';

$falumnos = new funciones_alumnos();
$registro_bitacora=new bitacora();

if(!empty($_POST['folios'])){
    $registros = json_decode($_POST['folios']);
    $registros_error=[];
    $registros_correctos=[];
    $total_eliminados=0;
    //echo var_dump($registros)
     foreach($registros as $id_registro){
        $elimina = $falumnos->delete_registros($id_registro);
        if($elimina){
            $total_eliminados=$total_eliminados+1;
            array_push($registros_correctos,$id_registro);
        }else{
            array_push($registros_error,$id_registro);
        }

    }
    if($total_eliminados==count($registros)){
        $res = array("acc" => true, "msg" => "Se eliminaron los registros de forma exitosa.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Generar-Firmar','Proceso de eliminación de registros:'.json_encode($res).'Registros:'.json_encode($registros_correctos));
        echo $var = json_encode($res);
    } else{
        $res = array("acc" => false, "msg" => "Tuvimos problemas para eliminar algunos registros, intentalo mas tarde.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Generar-Firmar','Proceso de eliminación de registros:'.json_encode($res).'Registros:'.json_encode($registros_error));
        echo $var = json_encode($res);
    } 
   

}elseif(!empty($_POST['folios_update'])){
    $registros = json_decode($_POST['folios_update']);
    $registros_error=[];
    $registros_correctos=[];
    $total_enviados=0;
    foreach($registros as $id_registro){
        $actualiza = $falumnos->update_registros(2,$id_registro);
        if($actualiza){
            $total_enviados=$total_enviados+1;
            array_push($registros_correctos,$id_registro);
        }else{
            array_push($registros_error,$id_registro);
        }
    }
    if($total_enviados==count($registros)){
        $res = array("acc" => true, "msg" => "Se enviaron los registros de forma exitosa.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Generar','Proceso de envio de registros:'.json_encode($res).'Registros:'.json_encode($registros_correctos));
        echo $var = json_encode($res);
    } else{
        $res = array("acc" => false, "msg" => "Tuvimos problemas para enviar algunos registros, intentalo mas tarde.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Generar','Proceso de envio de registros:'.json_encode($res).'Registros:'.json_encode($registros_error));
        echo $var = json_encode($res);
    } 
}elseif(!empty($_POST['folios_xml'])){
    $registros = json_decode($_POST['folios_xml']);
    $registros_error=[];
    $registros_correctos=[];
    $total_borrados=0;
    foreach($registros as $id_registro){
        $eliminar = $falumnos->delete_registros_xml($id_registro);
        if($eliminar){
            $total_borrados=$total_borrados+1;
            array_push($registros_correctos,$id_registro);
        }else{
            array_push($registros_error,$id_registro);
        }
    }
    if($total_borrados==count($registros)){
        $res = array("acc" => true, "msg" => "Se eliminaron los registros de forma exitosa.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Consultar','Proceso de eliminación de xml:'.json_encode($res).'Registros:'.json_encode($registros_correctos));
        echo $var = json_encode($res);
    } else{
        $res = array("acc" => false, "msg" => "Tuvimos problemas para enviar algunos registros, intentalo mas tarde.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'consultar','Proceso de eliminación de xml:'.json_encode($res).'Registros:'.json_encode($registros_error));
        echo $var = json_encode($res);
    } 
}
