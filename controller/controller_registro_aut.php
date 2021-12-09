<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include_once '../controller/controller_sesion.php';
extract($_POST);
include_once '../model/db.php';
include_once '../model/configuracion.php';
include_once '../model/bitacora.php';
$configuracion=new configuracion();
$registro_bitacora=new bitacora();
$metodo_bitacora='';
if($tipo=='0'){
    $configuracion->setDominio($dominio);
    $configuracion->setDN($BaseDn);
    $configuracion->setAtributo($searchattr);
    $configuracion->setTipo($tipo);
    $metodo_bitacora='Active Directory';
}elseif ($tipo=='1'){
    $configuracion->setTipo($tipo);
    $metodo_bitacora='Base de datos local';
}
$registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Autenticación','El usuario cambio el método de autenticación a '.$metodo_bitacora );
echo $tipoAutenticacion = $configuracion->updateAutenticacion();
?>