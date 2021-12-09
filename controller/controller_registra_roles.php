<?php 
include '../model/db.php';
include '..//model/permisos.php';
include '../model/configuracion.php';
include '../controller/controller_sesion.php';
include '../model/roles.php';
include '../model/bitacora.php';
$registro_bitacora = new bitacora();

extract($_POST);
$roles = new roles();
$roles->setNombre_rol($nombre_rol);
$roles->setestatus($estatus_rol);
if(!empty($admin_insert)){
    $roles->setAdminrol(1);
}else{
    $roles->setAdminrol(0);
}
$var=$roles->getInsertRol();
$registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Roles','Creación de rol: '.$nombre_rol.' con resultado: '.$var['msg']);
echo json_encode($var);