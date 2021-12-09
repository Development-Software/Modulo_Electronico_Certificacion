<?php
ini_set('display_errors', 0);
include_once '../controller_sesion.php';
include_once '../../lib/class.upload.php';
include_once '../../model/db.php';
include_once '../../model/configuracion.php';
include_once '../../model/catalogo.php';
include_once '../../model/bitacora.php';
$registro_bitacora = new bitacora();

//Valida contra catalogos
$catalogo = new Catalogo();
if (!$catalogo->getInstitucion()) {
    $res = array("acc" => false, "msg" => "Es necesario cargar el catalogo de Institución previamente.");
    echo $var = json_encode($res);
    die();
}
if (!$catalogo->existeCatalogo('Id_Campus', 'Campus')) {
    $res = array("acc" => false, "msg" => "Es necesario cargar el catalogo de Campus previamente.");
    echo $var = json_encode($res);
    die();
}
if (!$catalogo->existeCatalogo('Id_Carrera', 'Carreras')) {
    $res = array("acc" => false, "msg" => "Es necesario cargar el catalogo de Carreras previamente.");
    echo $var = json_encode($res);
    die();
}
if (!$catalogo->existeCatalogo('RVOE', 'RVOE')) {
    $res = array("acc" => false, "msg" => "Es necesario cargar el catalogo de RVOE previamente.");
    echo $var = json_encode($res);
    die();
}
if (!$catalogo->existeCatalogo('Id_Materia', 'Materias')) {
    $res = array("acc" => false, "msg" => "Es necesario cargar el catalogo de Materias previamente.");
    echo $var = json_encode($res);
    die();
}

if (isset($_FILES["file_plan"])) {
    $up = new Upload($_FILES["file_plan"]);
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
            //echo $maxCell['column'] . $maxCell['row'] .$totReal;
            $registros = [];
            $registrosError = [];
            $valida = array();
            $repetidos = array();
            for ($row = 2; $row <= $totReal; $row++) { //limite $highestRow se cambia por $totReal
                $x_no_institucion = trim($sheet->getCell("A" . $row)->getValue());
                $x_no_campus = trim($sheet->getCell("B" . $row)->getValue());
                $x_no_carrera = trim($sheet->getCell("C" . $row)->getValue());
                $x_no_rvoe = trim($sheet->getCell("D" . $row)->getValue());
                $x_creditos_totales = trim($sheet->getCell("E" . $row)->getValue());  //verificar si es float o entero
                $x_anio_plan = trim($sheet->getCell("F" . $row)->getValue());
                $x_no_materia = trim($sheet->getCell("G" . $row)->getValue());
                $x_no_tipo_asignatura = trim($sheet->getCell("H" . $row)->getValue());
                $x_creditos = trim($sheet->getCell("I" . $row)->getValue());  //verificar si es float o entero
                $x_no_periodo = trim($sheet->getCell("J" . $row)->getValue());
                
                $catalogo->setIdInstitucion($x_no_institucion);
                if ($catalogo->getInstitucionId() && $catalogo->existeCatalogoId("Id_Campus", "Campus", $x_no_campus) && $catalogo->existeCatalogoId("Id_Carrera", "Carreras", $x_no_carrera) && $catalogo->existeCatalogoId("RVOE", "RVOE", $x_no_rvoe) && preg_match('/^\d+$/', $x_creditos_totales) && !empty(trim($x_anio_plan)) && $catalogo->existeCatalogoId("Id_Materia", "Materias", $x_no_materia) && $catalogo->existeCatalogoId("idTipoAsignatura", "Tipo_Asignatura", $x_no_tipo_asignatura) && preg_match('/^\d+$/', $x_creditos) && $catalogo->existeCatalogoId("idTipoPeriodo", "Tipo_Periodo", $x_no_periodo)) {

                    //$registros[] = ['idInstitucion' => $x_no_institucion, 'id_campus' => $x_no_campus, 'id_carrera' => $x_no_carrera, 'id_rvoe' => $x_no_rvoe, 'creditos_totales' => $x_creditos_totales, 'anio_plan' => $x_anio_plan, 'id_materia' => $x_no_materia, 'id_tipo_asignatura' => $x_no_tipo_asignatura, 'creditos' => $x_creditos, 'id_periodo' => $x_no_periodo];
                    $valida[] =   1;
                } else {
                    $valida[] =   0;
                }

                if (!empty(trim($x_no_institucion)) && !empty(trim($x_no_campus)) && !empty(trim($x_no_carrera)) && !empty(trim($x_no_rvoe)) && !empty(trim($x_creditos_totales)) && !empty(trim($x_anio_plan)) && !empty(trim($x_no_materia)) && !empty(trim($x_no_tipo_asignatura)) && !empty(trim($x_creditos)) && !empty(trim($x_no_periodo))) {
                    if (!$catalogo->getInstitucionId()) {
                        $res = array("acc" => false, "msg" => "La institucion de algun registro no se encuentra registrada previamente.");
                        $valida[] =   0;
                    } elseif (!$catalogo->existeCatalogoId("Id_Campus", "Campus", $x_no_campus)) {
                        $res = array("acc" => false, "msg" => "El campus de algun registro no se encuentra registrada previamente.");
                        $valida[] =   0;
                    } elseif (!$catalogo->existeCatalogoId("Id_Carrera", "Carreras", $x_no_carrera)) {
                        $res = array("acc" => false, "msg" => "La carrera de algun registro no se encuentra registrada previamente.");
                        $valida[] =   0;
                    } elseif (!$catalogo->existeCatalogoId("RVOE", "RVOE", $x_no_rvoe)) {
                        $res = array("acc" => false, "msg" => "El RVOE de algun registro no se encuentra registrada previamente.");
                        $valida[] =   0;
                    } elseif (!$catalogo->existeCatalogoId("Id_Materia", "Materias", $x_no_materia)) {
                        $res = array("acc" => false, "msg" => "La materia de algun registro no se encuentra registrada previamente.");
                        $valida[] =   0;
                    } elseif (!$catalogo->existeCatalogoId("idTipoAsignatura", "Tipo_Asignatura", $x_no_tipo_asignatura)) {
                        $res = array("acc" => false, "msg" => "El tipo de asignatura no esta permitido en el catalogo oficial de la SEP");
                        $valida[] =   0;
                    } elseif (!$catalogo->existeCatalogoId("idTipoPeriodo", "Tipo_Periodo", $x_no_periodo)) {
                        $res = array("acc" => false, "msg" => "El tipo de periodo no esta permitido en el catalogo oficial de la SEP");
                        $valida[] =   0;
                    } elseif (!preg_match('/^\d+(?:\.\d{1,2})?$/', $x_creditos_totales)) {
                        $res = array("acc" => false, "msg" => "El campo de creditos totales tiene un formato incorrecto.".$x_creditos_totales);
                        $valida[] =   0;
                    } elseif (!preg_match('/^\d+(?:\.\d{1,2})?$/', $x_creditos)) {
                        $res = array("acc" => false, "msg" => "El campo de creditos tiene un formato incorrecto.");
                        $valida[] =   0;
                    } else {
                        $registros[] = ['idInstitucion' => $x_no_institucion, 'id_campus' => $x_no_campus, 'id_carrera' => $x_no_carrera, 'id_rvoe' => $x_no_rvoe, 'creditos_totales' => $x_creditos_totales, 'anio_plan' => $x_anio_plan, 'id_materia' => $x_no_materia, 'id_tipo_asignatura' => $x_no_tipo_asignatura, 'creditos' => $x_creditos, 'id_periodo' => $x_no_periodo];
                        $valida[] =   1;

                    }
                } else {
                    $res = array("acc" => false, "msg" => "El archivo contiene registros con información incompleta.");
                    $valida[] =   0;
                }
                
            }

            unlink($archivo);
            if (in_array(0, $valida)==1) {
                    foreach ($registros as $row) {
                        $catalogo->setIdInstitucion($row['idInstitucion']);
                        $catalogo->setIdCampus($row['id_campus']);
                        $catalogo->setIdCarrera($row['id_carrera']);
                        $catalogo->setIdRvoe($row['id_rvoe']);

                        $catalogo->setCreditosTotales($row['creditos_totales']); //crear
                        $catalogo->setAnioPlan($row['anio_plan']); //crear

                        $catalogo->setIdMateria($row['id_materia']);

                        $catalogo->setIdTipoAsignatura($row['id_tipo_asignatura']); //crear
                        $catalogo->setCreditos($row['creditos']); //crear
                        $catalogo->setIdPeriodo($row['id_periodo']); //crear
                        
                        if (!$catalogo->addCatalogoPlanEstudios()) {
                            $res = array("acc" => false, "msg" => "El archivo contiene registros duplicados.");
                            echo $var = json_encode($res);
                            //die();
                        }
                    }
                    $res = array("acc" => true, "msg" => "El catalogo Plan de Estudios se ha cargado correctamente");
                    echo $var = json_encode($res);
            } else {
                //$res = array("acc" => false, "msg" => "NO SE REALIZÓ EL REGISTRO, VERIFICA TU ARCHIVO");
                $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Catálogos','El usuario intento cargar el catálogo de plan de estudios y el resultado fue: '.$res['msg']);
                echo $var = json_encode($res);
            }
        }
    }
}
