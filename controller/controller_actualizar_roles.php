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
$roles->setIdRol($id);
$roles->setNombre_rol($nombre);
$roles->setestatus($estatus);

if ($admin=='true') {
    $roles->setAdminrol(1);

}else{
    $roles->setAdminrol(0);

}

if ($estatus == 0) {
    if ($roles->getdesactivarUsuariosRol()) {
        $Respuesta = $roles->getUpdateRol();
    } else {
        $Respuesta = array('res' => false, 'msg' => 'No fue posible actualizar los usuarios de este perfil');
    }
} else {
    $Respuesta = $roles->getUpdateRol();
}
$registro_bitacora->registro_bitacora($_SESSION['usuarioid'], 'Roles', 'actualización de rol: ' . $nombre . ' con resultado: ' . $Respuesta['msg']);
echo json_encode($Respuesta);
