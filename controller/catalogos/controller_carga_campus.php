<?php
ini_set('display_errors', 0);
include_once '../controller_sesion.php';
include_once '../../lib/class.upload.php';
include_once '../../model/db.php';
include_once '../../model/configuracion.php';
include_once '../../model/catalogo.php';
include_once '../../model/bitacora.php';
$registro_bitacora = new bitacora();

$catalogo = new Catalogo();
if (!$catalogo->getInstitucion()) {
    $res = array("acc" => false, "msg" => "Es necesario cargar el catalogo de Institución previamente.");
    echo $var = json_encode($res);
    die();
}

if (isset($_FILES["file_campus"])) {
    $up = new Upload($_FILES["file_campus"]);
    if ($up->uploaded) {
        $up->Process("/tmp/");
        if ($up->processed) {
            /// leer el archivo excel
            include '../../lib/PHPExcel.php';
            $archivo = "/tmp/" . $up->file_dst_name;
            $inputFileType = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($archivo);
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $maxCell = $sheet->getHighestRowAndColumn();
            $data = $sheet->rangeToArray('A1:' . $maxCell['column'] . $maxCell['row']);
            $data = array_map('array_filter', $data);
            $data = array_filter($data);
            $totReal = count($data);

            $registros = [];
            $registrosError = [];
            $valida = array();
            $repetidos = array();
            for ($row = 2; $row <= $totReal; $row++) { //limite $highestRow se cambia por $totReal
                $x_no = trim($sheet->getCell("A" . $row)->getValue());
                $x_descripcion = trim($sheet->getCell("B" . $row)->getValue());
                $x_no_institucion = trim($sheet->getCell("C" . $row)->getValue());
                $x_active = trim($sheet->getCell("D" . $row)->getValue());

                $catalogo->setIdInstitucion($x_no_institucion);

                //valida campos vacios
                if (!empty(trim($x_no)) && !empty(trim($x_descripcion)) && !empty(trim($x_no_institucion))) {

                    if (strlen(trim($x_no)) != 6 || !(preg_match('/^\d+$/', $x_no))) {
                        $res = array("acc" => false, "msg" => "El id del Campus tiene un formato incorrecto.");
                        array_push($registrosError, $x_no);
                    } elseif (!$catalogo->getInstitucionId()) {
                        $res = array("acc" => false, "msg" => "La institucion de algun registro no se encuentra registrada previamente.");
                        array_push($registrosError, $x_no);
                    } else {
                        //En este proceso se debera insertar o actualizar la información.
                        if ($catalogo->existeCatalogoId("Id_Campus", "Campus", $x_no)) {
                            //Update registro
                            $update=$catalogo->updCatalogoCampus($x_no,$x_descripcion,$x_no_institucion,$x_active);
                            if($update){
                                array_push($registros, $x_no);
                            }else{
                                array_push($registrosError, $x_no);
                            }
                        } else {
                            //Insert registro
                            $insert=$catalogo->addCatalogoCampus($x_no,$x_descripcion,$x_no_institucion);
                            if($insert){
                                array_push($registros, $x_no);
                            }else{
                                array_push($registrosError, $x_no);
                            }
                        }
                        /* $registros[] = ['id' => $x_no, 'descripcion' => $x_descripcion, 'idInstitucion' => $x_no_institucion]; */
                        
                    }
                } else {
                    $res = array("acc" => false, "msg" => "El archivo contiene registros con información incompleta.");
                    array_push($registrosError, $x_no);
                    
                }
            }
            unlink($archivo);
            if (count($registrosError) == ($totReal-1)) {
                $res = array("acc" => false, "msg" => "No se pudieron insertar los registros del archivo.");
            } elseif (0 < count($registrosError) && count($registrosError) < ($totReal-1)) {
                $res = array("acc" => true, "msg" => "Se insertaron y/o actualizaron solo " . count($registros) . " de un total de " . ($totReal-1) . " registros.");
            } else {
                $res = array("acc" => true, "msg" => "Se insertaron y actualizaron todos los registros con exito");
            }
            $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Catálogos','El usuario intento cargar el catálogo de campus y el resultado fue: '.$res['msg']);
            echo $var = json_encode($res);
        }
    }
}
