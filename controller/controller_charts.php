<?php
include_once '../controller/controller_sesion.php';
include_once '../model/db.php';
include_once '../model/data_chart.php';
extract($_POST);
$data= new data();
$id_chart=$_GET['id_chart'];
$datos=array();
if($id_chart=='1'){

    $registros=$data->reporte_estatus();
    foreach($registros as $id){
        array_push($datos,$id);
    }
echo json_encode($datos);
}elseif($id_chart=='2'){
    $registros=$data->reporte_estatusxml();
    foreach($registros as $id){
        array_push($datos,$id);
    }
echo json_encode($datos);
}