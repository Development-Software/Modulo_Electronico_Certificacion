<?php
include_once dirname(dirname(__DIR__)) . '/model/db.php';
include_once dirname(dirname(__DIR__))  . '/model/permisos.php';
include_once dirname(dirname(__DIR__))  . '/model/configuracion.php';
include_once dirname(dirname(__DIR__))  . '/controller/controller_sesion.php';
include_once dirname(dirname(__DIR__))  . '/model/campus.php';

$registros = new campus();
$datos_registros = $registros->getReporteCampus();

include_once '../../view/admin/usuarios/campus.php';
