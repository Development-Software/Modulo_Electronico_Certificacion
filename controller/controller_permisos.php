<?php
include_once dirname( __DIR__ ) . '/controller/controller_sesion.php';
include_once dirname( __DIR__ ) . '/model/db.php';
include_once dirname( __DIR__ ) . '/model/permisos.php';

$permisos = new permisos($_SESSION['usuarioidRol'],$_SESSION['usuarioid']);
$permisos_user = $permisos->listar_permisos();

foreach ($permisos_user as $idPermiso => $valor) {
    $item = $valor['idPermiso'];    
}

?>