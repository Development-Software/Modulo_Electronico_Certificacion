<?php
ini_set('display_errors', 1);
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

/*
* Valida que la fecha ingresada no sea mayor a la actual
*/
function validaFecha($end)
{
    date_default_timezone_set("America/Mexico_City");

    $fecha_registro = str_replace('/', '-', $end);
    $fecha_registro = date('Y-m-d', strtotime($fecha_registro));
    $fecha_registro = strtotime($fecha_registro);

    $fecha_actual = strtotime(date("Y-m-d"));

    if ($fecha_actual >= $fecha_registro) {
        $valida = true;
    } else {
        $valida = false;
    }
    return $valida;
}
/*
   * Valida el formato de la fecha introducida dd/mm/yyyy
  */
function validaFechaFormato($str)
{
    $array = explode('/', $str);
    $day = $array[0];
    $month = $array[1];
    $year = $array[2];

    $isDateValid = checkdate($month, $day, $year);

    if ($isDateValid == true) {
        return validaFecha($str);
    } else {
        return false;
    }
}

if (isset($_FILES["file_rvoe"])) {
    $up = new Upload($_FILES["file_rvoe"]);
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
                $a1Cell = $sheet->getCell("B" . $row);
                if (preg_match("/^((((31\/(0?[13578]|1[02]))|((29|30)\/(0?[1,3-9]|1[0-2])))\/(1[6-9]|[2-9]\d)?\d{2})|(29\/0?2\/(((1[6-9]|[2-9]\d)?(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))|(0?[1-9]|1\d|2[0-8])\/((0?[1-9])|(1[0-2]))\/((1[6-9]|[2-9]\d)?\d{2}))/", $a1Cell)) {
                    $x_fecha_registro = $a1Cell;
                } else {
                    /*Convierte a formato válido la fecha extraida de excel(UNIX)*/
                    $a1Cell = $sheet->getCell("B" . $row);
                    $a1CellFormattedValue = PHPExcel_Shared_Date::ExcelToPHPObject($a1Cell->getCalculatedValue());
                    $string_date = $a1CellFormattedValue->format("d/m/Y");
                    $x_fecha_registro = $string_date;
                }



                $x_minima = trim($sheet->getCell("C" . $row)->getValue());
                $x_maxima = trim($sheet->getCell("D" . $row)->getValue());
                $x_minima_aprobatoria = trim($sheet->getCell("E" . $row)->getValue());
                $x_no_institucion = trim($sheet->getCell("F" . $row)->getValue());
                $x_active = trim($sheet->getCell("G" . $row)->getValue());

                $catalogo->setIdInstitucion($x_no_institucion);


                if (!empty(trim($x_no)) && !empty(trim($x_fecha_registro)) && !empty(trim($x_fecha_registro)) && !empty(trim($x_minima)) && !empty(trim($x_maxima)) && !empty(trim($x_minima_aprobatoria) && !empty(trim($x_no_institucion)))) {
                    if (!(preg_match('/^\d+$/', $x_no))) {
                        $res = array("acc" => false, "msg" => "El id del RVOE tiene un formato incorrecto.");
                        array_push($registrosError, $x_no);
                    } elseif (!validaFechaFormato($x_fecha_registro)) {
                        $res = array("acc" => false, "msg" => "La fecha tiene un formato incorrecto.");
                        array_push($registrosError, $x_no);
                    } elseif (!(preg_match('/^[0-9]{1,2}$|^[0-9]{1,2}\.[0-9]{1,2}$/', $x_minima)) && !preg_match('/^[0-9]{1,2}$|^[0-9]{1,2}\.[0-9]{1,2}$/', $x_maxima) && !preg_match('/^[0-9]{1,2}$|^[0-9]{1,2}\.[0-9]{1,2}$/', $x_minima_aprobatoria)) {
                        $res = array("acc" => false, "msg" => "Alguna de las calificaciones (minima,maxima o min. aprobatoria) tiene un formato incorrecto.");
                        array_push($registrosError, $x_no);
                    } elseif (!$catalogo->getInstitucionId()) {
                        $res = array("acc" => false, "msg" => "La institucion de algun registro no se encuentra registrada previamente.");
                        array_push($registrosError, $x_no);
                    } else {

                        //En este proceso se debera insertar o actualizar la información.
                        if ($catalogo->existeCatalogoId("RVOE", "RVOE", $x_no)) {
                            //Update registro
                            $update = $catalogo->updCatalogoRvoe($x_no, $x_fecha_registro, $x_minima, $x_maxima, $x_minima_aprobatoria, $x_no_institucion, $x_active);
                            if ($update) {
                                array_push($registros, $x_no);
                            } else {
                                array_push($registrosError, $x_no);
                            }
                        } else {
                            //Insert registro
                            $insert = $catalogo->addCatalogoRvoe($x_no, $x_fecha_registro, $x_minima, $x_maxima, $x_minima_aprobatoria, $x_no_institucion);
                            if ($insert) {
                                array_push($registros, $x_no);
                            } else {
                                array_push($registrosError, $x_no);
                            }
                        }
                        //$registros[] = ['id' => $x_no, 'fecha_registro' => $x_fecha_registro, 'minima' => $x_minima, 'maxima' => $x_maxima, 'minima_aprobatoria' => $x_minima_aprobatoria, 'idInstitucion' => $x_no_institucion];

                    }
                } else {
                    $res = array("acc" => false, "msg" => "El archivo contiene registros con información incompleta.");
                    array_push($registrosError, $x_no);
                }
            }

            unlink($archivo);
            if (count($registrosError) == ($totReal - 1)) {

                $res = array("acc" => false, "msg" => "No se pudieron insertar los registros del archivo.");
            } elseif (0 < count($registrosError) && count($registrosError) < ($totReal - 1)) {
                $res = array("acc" => true, "msg" => "Se insertaron y/o actualizaron solo " . count($registros) . " de un total de " . ($totReal - 1) . " registros.");
            } else {
                $res = array("acc" => true, "msg" => "Se insertaron y actualizaron todos los registros con exito");
            }
            $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Catálogos','El usuario intento cargar el catálogo de RVOE y el resultado fue: '.$res['msg']);
            echo $var = json_encode($res);
        }
    }
}
