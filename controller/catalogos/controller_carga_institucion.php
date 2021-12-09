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
$configuracion = new configuracion();
$datosfirma = $configuracion->getFirma();
$curpAutDb = $datosfirma['CURP_FIEL'];

if (isset($_FILES["file_institucion"])) {
    $up = new upload($_FILES["file_institucion"]);
    if ($up->uploaded) {
        $up->process('/tmp/');
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
                $x_nombreAut = trim($sheet->getCell("C" . $row)->getValue());
                $x_apellidoPAut = trim($sheet->getCell("D" . $row)->getValue());
                $x_apellidoMAut = trim($sheet->getCell("E" . $row)->getValue());
                $x_curp = trim($sheet->getCell("F" . $row)->getValue());
                $x_cargo = trim($sheet->getCell("G" . $row)->getValue());
                $x_active = trim($sheet->getCell("H" . $row)->getValue());

                $formato = '/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/';
                $catalogo->setIdCargo($x_cargo);

                //valida nulos
                if (!empty(trim($x_no)) && !empty(trim($x_descripcion)) && !empty(trim($x_nombreAut))  && !empty(trim($x_apellidoPAut)) && !empty(trim($x_apellidoMAut)) && !empty(trim($x_curp))) {
                    //valida formato CURP
                    if (!preg_match($formato, $x_curp)) {
                        array_push($registrosError, $x_no);
                        $res = array("acc" => false, "msg" => "El archivo contiene CURP(s) inválidos");
                        $valida[] =   0;
                        //valido el curp con el del certificado
                    } elseif (!trim($x_curp) == trim($curpAutDb)) {
                        array_push($registrosError, $x_no);
                        $res = array("acc" => false, "msg" => "Los datos de la autoridad que firma los certificados no coincide, es necesario cargar la firma previamente o validar el archivo.");
                        $valida[] =   0;
                    } elseif (!$catalogo->getCargo()) {
                        array_push($registrosError, $x_no);
                        $res = array("acc" => false, "msg" => "El cargo del archivo no se encuentra dentro del catálogo de la SEP, favor de validar");
                        $valida[] =   0;
                    } elseif (!(preg_match('/^\d+$/', $x_no))) {
                        array_push($registrosError, $x_no);
                        $res = array("acc" => false, "msg" => "El id de la institucion tiene un formato incorrecto.");
                        $valida[] =   0;
                    } else {
                        //En este proceso se debera insertar o actualizar la información.
                        if ($catalogo->existeCatalogoId('Id_Institucion', 'Institucion', $x_no)) {
                            //Update registro
                            $update = $catalogo->updCatalogoInstitucion($x_no, $x_descripcion, $x_nombreAut, $x_apellidoPAut, $x_apellidoMAut, $x_curp, $x_cargo, $x_active);
                            if ($update) {
                                array_push($registros, $x_no);
                                //$registros[] = ['id' => $x_no, 'descripcion' => $x_descripcion, 'nombreAut' => $x_nombreAut, 'apellidoPAut' => $x_apellidoPAut, 'apellidoMAut' => $x_apellidoMAut, 'curpAut' => $x_curp, 'idCargo' => $x_cargo];
                                $valida[] =   1;
                                $res = array("acc" => false, "msg" => "Se inserto el registro con exito.");
                            } else {
                                $registros_test[] = ['id' => $x_no, 'descripcion' => $x_descripcion, 'nombreAut' => $x_nombreAut, 'apellidoPAut' => $x_apellidoPAut, 'apellidoMAut' => $x_apellidoMAut, 'curpAut' => $x_curp, 'idCargo' => $x_cargo, 'active' => $x_active];
                                array_push($registrosError, $x_no);
                                $valida[] = 0;
                                $res = array("acc" => false, "msg" => "Tuvimos un problema al insertar tu registro, por favor valida mas tarde o notificalo al area de Sistemas.");
                            }
                        } else {
                            //Insert registro
                            $insert = $catalogo->addCatalogoInstitucion($x_no, $x_descripcion, $x_nombreAut, $x_apellidoPAut, $x_apellidoMAut, $x_curp, $x_cargo);
                            if ($insert) {
                                array_push($registros, $x_no);
                                $valida[] =   1;
                            } else {
                                array_push($registrosError, $x_no);
                                $valida[] = 0;
                                $res = array("acc" => false, "msg" => "Tuvimos un problema al insertar tu registro, por favor valida mas tarde o notificalo al area de Sistemas.");
                            }
                        }

                        $repetidos[] = (int)$x_no;
                    }
                } else {
                    $res = array("acc" => false, "msg" => "El archivo contiene registros con información incompleta.");
                    $valida[] =   0;
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
        } else {
            echo 'error : ' . $up->error;
        }
        $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Catálogos','El usuario intento cargar el catálogo de insitución y el resultado fue: '.$res['msg']);
        echo $var = json_encode($res);
    }
}
