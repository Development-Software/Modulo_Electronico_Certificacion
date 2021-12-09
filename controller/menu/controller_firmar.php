<?php
include_once dirname(dirname(__DIR__)) . '/model/db.php';
include_once dirname(dirname(__DIR__))  . '/model/permisos.php';
include_once dirname(dirname(__DIR__))  . '/model/configuracion.php';
include_once dirname(dirname(__DIR__))  . '/controller/controller_sesion.php';
include_once dirname(dirname(__DIR__))  . '/model/alumnos.php';
include_once dirname(dirname(__DIR__))  . '/model/permisos.php';

$falumnos = new funciones_alumnos();
$falumnos->setidEstatus(2);
$registros_firma = $falumnos->query_firma();
if($registros_firma!=0){
    $registros_firma;
}else{
    $registros_firma=0;
}

$permisos=new permisos($_SESSION['usuarioid'],$_SESSION['usuarioidRol']);
$t_permisos=$permisos->listar_total_permisos();
$permiso_exportar=false;
$permiso_eliminar=false;
$permiso_firmar=false;
foreach ($t_permisos as $id_permiso){
    if($id_permiso['idPermiso']==8){
        $permiso_eliminar=true;
    }elseif($id_permiso['idPermiso']==9){
        $permiso_exportar=true;
    }elseif($id_permiso['idPermiso']==10){
        $permiso_firmar=true;
    }
/*     echo '<pre>';
    var_dump($permiso_eliminar);
    echo'</pre>'; */
}
include_once dirname(dirname(__DIR__))  . '/view/admin/alumnos/firmar.php';