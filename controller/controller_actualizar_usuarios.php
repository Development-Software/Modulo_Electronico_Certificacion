<?php  
include '../model/db.php';
include '..//model/permisos.php';
include '../model/configuracion.php';
include '../controller/controller_sesion.php';
include '../model/usuarios.php';
include '../model/bitacora.php';
$registro_bitacora = new bitacora();
	extract($_POST);
	
    $documento = new Usuario();
	$documento->setId($id);
    $documento->setNombre(trim($nombre));
	$documento->setApellidoP(trim($apellidoP));
	$documento->setApellidoM(trim($apellidoM));
	$documento->setCorreo(trim($correo));
	$documento->setUserName(trim($username));
	$documento->setPass(trim($enc));
	echo $documento->setRol(trim($rol));
	$documento->setEstatus(trim($estatus));
     
	$Respuesta = array(
						array("st"=>$documento->updateUsuario())
					   );
   $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Usuarios','Se actualizo el usuario: '.$username);
	echo json_encode($Respuesta);
	