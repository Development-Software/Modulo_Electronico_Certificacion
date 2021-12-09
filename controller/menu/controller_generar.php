<?php
include_once dirname(dirname(__DIR__)) . '/model/db.php';
include_once dirname(dirname(__DIR__))  . '/model/permisos.php';
include_once dirname(dirname(__DIR__))  . '/model/configuracion.php';
include_once dirname(dirname(__DIR__))  . '/controller/controller_sesion.php';
include_once dirname(dirname(__DIR__))  . '/model/alumnos.php';
include_once dirname(dirname(__DIR__))  . '/model/permisos.php';
$configuracion = new configuracion();
$tipoFuente = $configuracion->getTipofuente();
$tipoFuente['Fuente'] == 0 ? $Source_checkedBD = 'checked' : $Source_checkedBD = '';
$tipoFuente['Fuente'] == 1 ? $Source_checkedFile = 'checked' : $Source_checkedFile = '';
if (!empty($_POST['id_registro'])) {

    $id_registros = 0;
} else {
    $falumnos = new funciones_alumnos();
    $falumnos->setidUsuario($_SESSION['usuarioid']);
    $falumnos->setidEstatus(1);
    $registros = $falumnos->query_alumnos();
    if ($registros == 0) {
        $id_registros = 0;
    } else {
        $id_registros = 1;
    }
}

$permisos = new permisos($_SESSION['usuarioid'], $_SESSION['usuarioidRol']);
$t_permisos = $permisos->listar_total_permisos();
$permiso_exportar = false;
$permiso_eliminar = false;
$permiso_enviar = false;
foreach ($t_permisos as $id_permiso) {
    if ($id_permiso['idPermiso'] == 4) {
        $permiso_eliminar = true;
    } elseif ($id_permiso['idPermiso'] == 5) {
        $permiso_exportar = true;
    } elseif ($id_permiso['idPermiso'] == 6) {
        $permiso_enviar = true;
    }
    /*     echo '<pre>';
    var_dump($id_permiso['idPermiso']);
    echo'</pre>'; */
}

include_once dirname(dirname(__DIR__))  . '/view/admin/alumnos/generar.php';
