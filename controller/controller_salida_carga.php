<?php
include_once dirname(__DIR__) . '/model/db.php';
include_once dirname(__DIR__) . '/model/permisos.php';
include_once dirname(__DIR__) . '/controller/controller_sesion.php';
include_once dirname(__DIR__) . '/model/valida_alumnos.php';
extract($_GET);
//echo $id_log;
$f_salida = new Alumno();
$registros_salida = $f_salida->registros_salida($id_log);
if ($registros_salida != 0) {
    $filename='Registro_MEC_'.date("d_m_Y").'.csv';
    //cabeceras para descarga
    header('Content-Encoding: UTF-8'); 
    header('Content-type: text/csv; charset=UTF-8'); 
    header('Content-Disposition: attachment; filename='.$filename); 
    echo "\xEF\xBB\xBF";

    //preparar el wrapper de salida
    $outputBuffer = fopen("php://output", 'w');
    $cabezeras[0]=array("Nombre de Archivo","Columna","Error","Fecha de Carga");
    foreach($cabezeras as $header){
        fputcsv($outputBuffer, $header);
    }
    //volcamos el contenido del array en formato csv
    foreach ($registros_salida as $val) {
        fputcsv($outputBuffer, $val);
        
    }
    //cerramos el wrapper
    fclose($outputBuffer);
    exit;
}
