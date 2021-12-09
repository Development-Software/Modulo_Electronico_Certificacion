<?php
include_once dirname(__DIR__) . '/model/db.php';
include_once dirname(__DIR__)  . '/model/permisos.php';
include_once dirname(__DIR__)  . '/model/configuracion.php';
include_once dirname(__DIR__)  . '/controller/controller_sesion.php';
include_once dirname(__DIR__)  . '/model/alumnos.php';
include_once dirname(__DIR__)  . '/model/bitacora.php';


extract($_POST);

$registro_bitacora=new bitacora();
$ids = $_POST['folios_descarga'];
$ids = explode(',', $ids);

$alumnos = new funciones_alumnos();
$registros_correctos = [];
$registros_incorrectos = [];
$array_files=[];
$zip_filename='Certificados_' . date('d') . '_' . date('m') . '_' . date('Y').'.zip';
if (count($ids) > 1) {
    // Creamos un instancia de la clase ZipArchive
    $zip = new ZipArchive();
    // Creamos y abrimos un archivo zip temporal
    $zip->open($zip_filename, ZipArchive::CREATE);
    for ($i = 0; $i < count($ids); $i++) {
        $registros_xml = $alumnos->consulta_xml($ids[$i]);
        array_push($registros_incorrectos,$ids[$i]);
        if ($registros_xml == 0) {
            //El registro se borro de la base de datos
            array_push($registros_incorrectos, $ids[$i]);
        } else {
            foreach ($registros_xml as $datos) {
                $decode = base64_decode($datos['XML']);
                $file = 'Folio_Control_' . $datos['Id_Registro'] . '.xml';
                $fichero = $file;
                // Escribe el contenido al fichero
                file_put_contents($fichero, $decode);
                // Añadimos un archivo en la raid del zip.
                $zip->addFile($fichero, $fichero);
                $alumnos->update_registros(4,$ids[$i]);
                array_push($array_files,$fichero);
                //unlink($fichero);
            }
        }
    }
    $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Consultar','Proceso de descarga masiva de xml de registros.Registros:'.json_encode($registros_incorrectos));           
    // Una vez añadido los archivos deseados cerramos el zip.
    $zip->close();
     header("Content-type: application/octet-stream");
    header("Content-disposition: attachment; filename=".$zip_filename."");
    // leemos el archivo creado
    readfile($zip_filename);     
    foreach ($array_files as $f_name){
        unlink($f_name);
    }
    // Por último eliminamos el archivo temporal creado
    unlink($zip_filename); //Destruye el archivo temporal
    
    
} else {
    //Solo se solicito un registro
    $registros_xml = $alumnos->consulta_xml($ids[0]);
    if ($registros_xml == 0) {
        //El registro se borro de la base de datos
    } else {
        $alumnos->update_registros(4,$ids[0]); 
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Consultar','Proceso de descarga de xml de registros. Se descargo el siguiente registro:'.json_encode($ids[0]));           
        foreach ($registros_xml as $datos) {
            $decode = base64_decode($datos['XML']);
            $file = 'Folio_Control_' . $datos['Id_Registro']. '.xml';;
            ob_end_clean();
            ob_start();
            header('Content-Type: application/xml;');
            header('Content-Encoding: UTF-8');
            header('Content-Disposition: attachment;filename=' . $file.'');
            header('Expires: 0');
            header('Pragma: cache');
            header('Cache-Control: private');
            echo $decode;
            
        }
    }
}
