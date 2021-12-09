<?php
include_once dirname(dirname(__DIR__)) . '/model/db.php';
include_once dirname(dirname(__DIR__))  . '/model/permisos.php';
include_once dirname(dirname(__DIR__))  . '/model/configuracion.php';
include_once dirname(dirname(__DIR__))  . '/controller/controller_sesion.php';
include_once dirname(dirname(__DIR__))  . '/model/roles.php';

$informacion = new roles();
$datosReporte = $informacion->getReporteRoles();

$permisos=new permisos($_SESSION['usuarioid'],$_SESSION['usuarioidRol']);
$t_permisos=$permisos->listar_total_permisos();
$permiso_agregar=false;
$permiso_activar=false;
$permiso_editar=false;
$permiso_exportar=false;
foreach ($t_permisos as $id_permiso){
    if($id_permiso['idPermiso']==22){
        $permiso_agregar=true;
    }elseif($id_permiso['idPermiso']==23){
        $permiso_activar=true;
    }elseif($id_permiso['idPermiso']==24){
        $permiso_editar=true;
    }elseif($id_permiso['idPermiso']==25){
        $permiso_exportar=true;
    }
/*     echo '<pre>';
    var_dump($id_permiso['idPermiso']);
    echo'</pre>'; */
}
include_once '../../view/admin/usuarios/roles.php';