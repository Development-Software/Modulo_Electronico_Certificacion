<?php
include_once dirname( __DIR__ ) . '/controller/controller_sesion.php';

$file = $_FILES["certificado"]["tmp_name"]; 
$fileName = $_FILES["certificado"]["name"]; 
$fileType = $_FILES["certificado"]["type"];
$fileSize = $_FILES['certificado']['size'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps));
$allowedfileExtensions = array('cer');
if(in_array($fileExtension, $allowedfileExtensions)) {
	$newFileName = $fileName;

	$my_file = $_FILES['certificado']['tmp_name'];//'cert.cer';
	$handle = fopen($my_file, 'r');
	$data = fread($handle,filesize($my_file));


	$encoded = "-----BEGIN CERTIFICATE-----\n".base64_encode($data)."\n-----END CERTIFICATE-----";
    
    $cert_info = openssl_x509_parse($encoded);
	$nombreCer = $cert_info['subject']['name'];
	$serialCer = $cert_info['subject']['serialNumber'];
    $serialHexCer = substr($cert_info['serialNumber'],2);
	$cargar_datos_cer='2';
	$id_form='1';
    include_once '../view/admin/configuracion/sistema/certificado.php';
}

?>