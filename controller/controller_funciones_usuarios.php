<?php
include '../model/db.php';
include '..//model/permisos.php';
include '../model/configuracion.php';
include '../controller/controller_sesion.php';
include '../model/usuarios.php';
include '../model/bitacora.php';
$registro_bitacora = new bitacora();
$usuarios = new Usuario();
if (!empty($_POST['id_users_disabled'])) {
    $registros = json_decode($_POST['id_users_disabled']);
    $total_desactivados=0;
    //echo var_dump($registros);
     foreach($registros as $id_registro){
        $desactiva = $usuarios->desactivar_usuarios($id_registro);
        
        if($desactiva){
            $total_desactivados=$total_desactivados+1;
        }
    }
    if($total_desactivados==count($registros)){
        $res = array("acc" => true, "msg" => "Se desactivaron los usuarios de forma exitosa.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Usuarios','Se desactivaron con exito los siguientes usuarios: '.json_encode($registros));
        echo $var = json_encode($res);
    } else{
        $res = array("acc" => false, "msg" => "Tuvimos problemas para desactivar algunos usuarios, intentalo mas tarde.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Usuarios','Se intento desactivar a los siguientes usuarios: '.json_encode($registros).' ; sin emabargo no se tuvo exito con todos');
        echo $var = json_encode($res);
    } 
}elseif (!empty($_POST['id_users_active'])) {
    $registros = json_decode($_POST['id_users_active']);
    $total_activados=0;
    //echo var_dump($registros);
     foreach($registros as $id_registro){
        $activa = $usuarios->activar_usuarios($id_registro);
        
        if($activa){
            $total_activados=$total_activados+1;
        }
    }
    if($total_activados==count($registros)){
        $res = array("acc" => true, "msg" => "Se activaron los usuarios de forma exitosa.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Usuarios','Se activaron con exito los siguientes usuarios: '.json_encode($registros));
        echo $var = json_encode($res);
    } else{
        $res = array("acc" => false, "msg" => "Tuvimos problemas para activar algunos usuarios, intentalo mas tarde.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Usuarios','Se intento activar a los siguientes usuarios: '.json_encode($registros).' ; sin emabargo no se tuvo exito con todos');
        echo $var = json_encode($res);
    } 
}