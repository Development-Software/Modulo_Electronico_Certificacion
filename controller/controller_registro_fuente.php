<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once '../controller/controller_sesion.php';
extract($_POST);
include_once '../model/db.php';
include_once '../model/configuracion.php';
include_once '../model/bitacora.php';
  $registro_bitacora=new bitacora();
  $fuente_bitacora='';
$configuracion=new configuracion();
if ($tipo_fuente == '0') {
    $configuracion->setHostFuente($server);
    $configuracion->setUsuarioFuente($usuario);
    $configuracion->setPasswordFuente($password);
    $configuracion->setTipo($tipo_fuente);
    $fuente_bitacora='Base de Datos';
} else {
    $configuracion->setTipo($tipo_fuente);
    $fuente_bitacora='Archivos Layouts';
}
$registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Fuente','El usuario cambio la fuente de datos a '.$fuente_bitacora);
echo $tipoAutenticacion = $configuracion->updateFuente();
