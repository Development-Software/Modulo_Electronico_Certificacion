<?php

error_reporting(E_ALL);
session_start();
ini_set('display_errors', '1');
extract($_POST);
include_once dirname( __DIR__ ) . '/model/db.php';
include_once dirname( __DIR__ ) . '/model/login.php';
include_once dirname( __DIR__ ) . '/model/configuracion.php';

//echo dirname( __DIR__ );
$configuracion = new Configuracion();
$tipoAutenticacion = $configuracion->getTipoAutenticacion();
if(!empty($_SESSION['usuarioid'])){
    header("Location: view/admin/?menu=inicio",true,301);
}else{
    $loginuser = new Login($UserName,$UserPass,$tipoAutenticacion['LDAP_Domain'],$tipoAutenticacion['BaseDn'],$tipoAutenticacion['SearchAttr']);
    $tipoAutenticacion['Autenticacion'] == 1 ? $autentica = $loginuser->authUserBD() : $autentica = $loginuser->authUserAD(); 
}


?>