<?php
include_once dirname(__DIR__) . '/model/db.php';
include_once dirname(__DIR__) . '/model/permisos.php';
include_once dirname(__DIR__) . '/model/configuracion.php';
include_once dirname(__DIR__) . '/controller/controller_sesion.php';
include_once dirname(__DIR__) . '/model/alumnos.php';
include_once dirname(__DIR__) . '/model/data_chart.php';
$permisos = new permisos( $_SESSION['usuarioid'],$_SESSION['usuarioidRol']);
$permisos_user = $permisos->listar_permisos();
$configuracion = new configuracion();
$nombre_user = $_SESSION['usuarioNombre'];
$data_chart=new data();
$registros_totales=$data_chart->registros_totales();
$registros_totales_xml=$data_chart->registros_totales_xml();

if (isset($_GET['menu'])) {
    $menu = $_GET['menu'];
    $valida = false;



    foreach ($permisos_user as $idPermiso => $valor) {
        $item = $valor['SubMenu'];
        if ($configuracion->quitar_tildes(strtolower($item)) == $menu) {
            $valida = true;
        }
    }
    if ($menu == 'logout') {
        session_destroy();
//        $host = $_SERVER["HTTP_HOST"];
//        $url = $_SERVER["REQUEST_URI"];
//        $retUrl= $host.substr($url,strpos($url,'/'),strpos($url,'/',1));
//        header('Location: http://'. $retUrl);

        header("Location: " . SITE_URL);
    } elseif ($valida) {

        if ($menu == 'inicio') {
            $active_inicio = '1';
            include_once dirname(__DIR__) . '/view/admin/inicio.php';
        } elseif ($menu == 'generar') {

            $active_inicio = '2';
            include_once dirname(__DIR__) . '/controller/menu/controller_generar.php';
        } elseif ($menu == 'firmar') {

            $active_inicio = '3';
            include_once dirname(__DIR__) . '/controller/menu/controller_firmar.php';
        } elseif ($menu == 'consultar') {

            $active_inicio = '4';
            include_once dirname(__DIR__) . '/controller/menu/controller_consultar.php';
        } elseif ($menu == 'usuarios') {

            $active_inicio = '5';
            include_once dirname(__DIR__) . '/controller/menu/controller_usuarios.php';
        } elseif ($menu == 'roles') {

            $active_inicio = '6';
            include_once dirname(__DIR__) . '/controller/menu/controller_roles.php';
        } elseif ($menu == 'campus') {

            $active_inicio = '7';
            include_once dirname(__DIR__) . '/controller/menu/controller_campus.php';
        } elseif ($menu == 'sistema') {

            $active_inicio = '8';
            include_once dirname(__DIR__) . '/controller/menu/controller_sistema.php';
        } elseif ($menu == 'catalogos') {

            $active_inicio = '9';
            include_once dirname(__DIR__) . '/view/admin/configuracion/catalogos.php';
        } elseif ($menu == 'alumnos') {

            $active_inicio = '10';
            include_once dirname(__DIR__) . '/view/admin/configuracion/alumnos.php';
        }
    } else {
        echo 'sin permiso';
    }
}
