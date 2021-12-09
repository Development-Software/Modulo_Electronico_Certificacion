<?php
include_once dirname(__DIR__) . '/controller/controller_sesion.php';
include_once dirname(__DIR__) . '/model/db.php';
include_once dirname(__DIR__) . '/lib/class.upload.php';
include_once dirname(__DIR__) . '/model/configuracion.php';
include_once dirname(__DIR__) . '/model/valida_alumnos.php';
include_once dirname(__DIR__) . '/model/utilerias.php';

$ficheros = $_FILES['input-fas'];
$paths = array();
$nombres_ficheros = $ficheros['name'];
$response=array();

for ($i = 0; $i < count($nombres_ficheros); $i++) {
    $nombre_extension = explode('.', basename($nombres_ficheros[$i]));
    $extension = array_pop($nombre_extension);
    $nombre = array_pop($nombre_extension);
    $archivo_destino = dir_descargas . DIRECTORY_SEPARATOR . utf8_decode($nombre) . '.' . $extension;
    if (move_uploaded_file($ficheros['tmp_name'][$i], $archivo_destino)) {
       
        $response=cargar_excel($archivo_destino);
        echo json_encode($response);

        
    }else{
        $response=['error'=>'No se pudo cargar el archivo'.$ficheros['tmp_name'][$i].$archivo_destino];
        echo json_encode($response);
    }
}
