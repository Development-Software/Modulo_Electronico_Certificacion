<?php
include_once dirname(dirname(__DIR__)) . '/model/db.php';
include_once dirname(dirname(__DIR__))  . '/model/permisos.php';
include_once dirname(dirname(__DIR__))  . '/model/configuracion.php';
include_once dirname(dirname(__DIR__))  . '/controller/controller_sesion.php';
include_once dirname(dirname(__DIR__))  . '/model/usuarios.php';

$informacion = new ReporteUsuario();
$datosReporte = $informacion->getReporteUsuario();
$datosRoles = $informacion->getRoles();


$permisos=new permisos($_SESSION['usuarioid'],$_SESSION['usuarioidRol']);
$t_permisos=$permisos->listar_total_permisos();
$permiso_agregar=false;
$permiso_activar=false;
$permiso_editar=false;
$permiso_exportar=false;
foreach ($t_permisos as $id_permiso){
    if($id_permiso['idPermiso']==17){
        $permiso_agregar=true;
    }elseif($id_permiso['idPermiso']==18){
        $permiso_activar=true;
    }elseif($id_permiso['idPermiso']==19){
        $permiso_editar=true;
    }elseif($id_permiso['idPermiso']==20){
        $permiso_exportar=true;
    }
/*     echo '<pre>';
    var_dump($id_permiso['idPermiso']);
    echo'</pre>'; */
}

//echo $registros_consulta;
include_once '../../view/admin/usuarios/usuarios.php';