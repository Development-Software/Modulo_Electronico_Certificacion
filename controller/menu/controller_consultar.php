<?php
include_once dirname(dirname(__DIR__)) . '/model/db.php';
include_once dirname(dirname(__DIR__))  . '/model/permisos.php';
include_once dirname(dirname(__DIR__))  . '/model/configuracion.php';
include_once dirname(dirname(__DIR__))  . '/controller/controller_sesion.php';
include_once dirname(dirname(__DIR__))  . '/model/alumnos.php';

$falumnos = new funciones_alumnos();
$falumnos->setidUsuario($_SESSION['usuarioid']);

$registros_consulta = $falumnos->query_alumnos_descarga();

if($registros_consulta!=0){
    $registros_consulta;
}else{
    $registros_consulta=0;
}

$permisos=new permisos($_SESSION['usuarioid'],$_SESSION['usuarioidRol']);
$t_permisos=$permisos->listar_total_permisos();
$permiso_eliminar=false;
$permiso_exportar=false;
$permiso_descargar=false;
foreach ($t_permisos as $id_permiso){
    if($id_permiso['idPermiso']==12){
        $permiso_descargar=true;
    }elseif($id_permiso['idPermiso']==13){
        $permiso_exportar=true;
    }elseif($id_permiso['idPermiso']==14){
        $permiso_eliminar=true;
    }
/*     echo '<pre>';
    var_dump($id_permiso['idPermiso']);
    echo'</pre>'; */
}
//echo $registros_consulta;
include_once '../../view/admin/alumnos/consultar.php';