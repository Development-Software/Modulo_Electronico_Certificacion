<?php
include '../model/db.php';
include '..//model/permisos.php';
include '../model/configuracion.php';
include '../controller/controller_sesion.php';
include '../model/roles.php';
include '../model/bitacora.php';
$registro_bitacora = new bitacora();
$roles = new roles();

if (!empty($_POST['idRol_disabled'])) {
    $registros = json_decode($_POST['idRol_disabled']);
    $total_desactivados = 0;
    $total_user_desactivados = 0;
    //echo var_dump($registros);
    foreach ($registros as $id_registro) {
        $roles->setIdRol($id_registro);
        $desactiva = $roles->getdesactivarRol();
        $desactiva_users = $roles->getdesactivarUsuariosRol();
        if ($desactiva && $desactiva_users) {
            $total_desactivados = $total_desactivados + 1;
        }
    }
    if ($total_desactivados == count($registros)) {
        $res = array("acc" => true, "msg" => "Se desactivaron los usuarios y/o roles de forma exitosa.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Roles','Se desactivaron con exito los siguientes usuarios  y/o roles : '.json_encode($registros));
        echo $var = json_encode($res);
    } else {
        $res = array("acc" => false, "msg" => "Tuvimos problemas para desactivar algunos usuarios, intentalo mas tarde.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Roles','Se intento desactivar a los siguientes usuarios y/o roles: '.json_encode($registros).' ; sin emabargo no se tuvo exito con todos');
        echo $var = json_encode($res);
    }
} elseif (!empty($_POST['idRol_active'])) {
    $registros = json_decode($_POST['idRol_active']);
    $total_activados = 0;
    $total_user_activados = 0;
    //echo var_dump($registros);
    foreach ($registros as $id_registro) {
        $roles->setIdRol($id_registro);
        $desactiva = $roles->getactivarRol();        
        $total_activados = $total_activados + 1;
    }
    if ($total_activados == count($registros)) {
        $res = array("acc" => true, "msg" => "Se activaron los roles de forma exitosa.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Roles','Se activaron con exito los siguientes usuarios  y/o roles : '.json_encode($registros));
        echo $var = json_encode($res);
    } else {
        $res = array("acc" => false, "msg" => "Tuvimos problemas para desactivar algunos usuarios, intentalo mas tarde.");
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Roles','Se intento activar a los siguientes usuarios y/o roles: '.json_encode($registros).' ; sin emabargo no se tuvo exito con todos');
        echo $var = json_encode($res);
    }
}
