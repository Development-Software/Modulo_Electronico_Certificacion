<?php
//include_once dirname(__DIR__) . '/controller/controller_sesion.php';
include_once dirname(__DIR__) . '/model/db.php';
//include_once dirname(__DIR__) . '/lib/class.upload.php';
//include_once dirname(__DIR__) . '/model/configuracion.php';
include_once dirname(__DIR__) . '/model/valida_alumnos.php';
//include_once dirname(__DIR__) . '/model/utilerias.php';

$query= new alumno();
//$query='1';
echo var_dump($query->registros_usuario()) ;
