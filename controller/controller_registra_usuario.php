<?php 
include '../model/db.php';
include '..//model/permisos.php';
include '../model/configuracion.php';
include '../controller/controller_sesion.php';
include '../model/usuarios.php';
include '../model/bitacora.php';
$registro_bitacora = new bitacora();

	extract($_POST);
    //include_once dirname( __DIR__ ) . '/Model/db.php';
	//include_once dirname( __DIR__ ) . '/Model/Usuario.php';
	  
	$documento = new Usuario();
	
    $documento->setNombre(trim($nombre_insert));
	$documento->setApellidoP(trim($apellidoP_insert));
	$documento->setApellidoM(trim($apellidoM_insert));
	$documento->setCorreo(trim($correo_insert));
	$documento->setUserName(trim($username_insert));
	$documento->setPass(trim($enc_insert));
    $documento->setRol(trim($rol_insert));
    $documento->setEstatus(trim($estatus_insert));
	//echo $documento->getRegistroUsuario();
    // die();

    if($regusu = $documento->getRegistroUsuario()){
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Usuarios','Se intento registrar al usuario: '.$username_insert.' con la siguiente respuesta:'.$regusu['msg']);
        echo $var = json_encode($regusu);
    }else{
        $res = array('res'=>false,'msg'=>'Registro incorrecto intenta nuevamente');
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Usuarios','Se creo correctamente el usuario: '.$username_insert);
        echo $var = json_encode($res);
    }

?>