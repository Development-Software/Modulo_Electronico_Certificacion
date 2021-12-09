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

if (isset($_FILES["file_carreras"])) {
    $up = new Upload($_FILES["file_carreras"]);
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
                $x_no = $sheet->getCell("A" . $row)->getValue();
                $x_clave_carrera = trim($sheet->getCell("B" . $row)->getValue());
                $x_descripcion = trim($sheet->getCell("C" . $row)->getValue());
                $x_no_nivel = trim($sheet->getCell("D" . $row)->getValue());
                $x_no_institucion = trim($sheet->getCell("E" . $row)->getValue());
                $x_active = trim($sheet->getCell("F" . $row)->getValue());

                $catalogo->setIdNivel($x_no_nivel);
                $catalogo->setIdInstitucion($x_no_institucion);

                if (!empty(trim($x_no)) &&  !empty(trim($x_clave_carrera)) && !empty(trim($x_descripcion)) && !empty(trim($x_no_nivel)) && !empty(trim($x_no_institucion))) {
                    if (!$catalogo->getNivel()) {
                        array_push($registrosError[]);
                        $res = array("acc" => false, "msg" => "El id del nivel no se encuentra dentro del catálogo de la SEP, favor de validar");
                        
                    } elseif (!$catalogo->getInstitucionId()) {
                        array_push($registrosError[]);
                        $res = array("acc" => false, "msg" => "La institucion de algun registro no se encuentra registrada previamente.");
                        
                    } elseif (!(preg_match('/^\d+$/',$x_no))) {
                        array_push($registrosError[]);
                        $res = array("acc" => false, "msg" => "El id de la carrera tiene un formato incorrecto.");
                        
                    } else {
                        
                        //En este proceso se debera insertar o actualizar la información.
                        if ($catalogo->existeCatalogoId("Id_Carrera", "Carreras",$x_no)) {
                            //Update registro
                            $update=$catalogo->updCatalogoCarreras($x_no,$x_clave_carrera,$x_descripcion,$x_no_nivel,$x_no_institucion,$x_active);
                            if($update){
                                array_push($registros, $x_no);
                            }else{
                                array_push($registrosError, $x_no);
                            }
                        } else {
                            //Insert registro
                            $insert=$catalogo->addCatalogoCarreras($x_no,$x_clave_carrera,$x_descripcion,$x_no_nivel,$x_no_institucion);
                            if($insert){
                                array_push($registros, $x_no);
                            }else{
                                array_push($registrosError, $x_no);
                            }
                        }
                        
                        //$registros[] = ['id' => $x_no, 'clave_carrera' => $x_clave_carrera, 'descripcion' => $x_descripcion, 'idNivel' => $x_no_nivel, 'idInstitucion' => $x_no_institucion];
                        
                    }
                } else {
                    $res = array("acc" => false, "msg" => "El archivo contiene registros con información incompleta.");
                    array_push($registrosError[]);
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
            $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Catálogos','El usuario intento cargar el catálogo de carreras y el resultado fue: '.$res['msg']);
            echo $var = json_encode($res);
        }
    }
}
