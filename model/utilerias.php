<?php
require_once('../lib/PHPExcel.php');
ini_set('memory_limit', '2000M');
include_once dirname(__DIR__) . '/model/valida_alumnos.php';
include_once dirname(__DIR__) . '/model/campus.php';
include_once dirname(__DIR__) . '/model/bitacora.php';
define('dir_descargas', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'files');
function convertCSV($infile, $outfile)
{
    $fileType = PHPExcel_IOFactory::identify($infile);
    $objReader = PHPExcel_IOFactory::createReader($fileType);

    //$objReader->setReadDataOnly(true);   
    var_dump($infile);
    $objPHPExcel = $objReader->load($infile);

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save($outfile);
}

function cargar_excel($archivo_destino)
{
    $campus = new campus();
    $campus->setidUsuario($_SESSION['usuarioid']);
    $campus_usuario = $campus->getReporteCampusxUsuario();
    $paths[] = $archivo_destino;
    $alumnos = new alumno();
    //Variables para leer el archivo
    $archivo = $archivo_destino;
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
    $repetidos = array();
    $valida = array();
    $mgs_error = '';
    $registros_error = [];
    $guid = trim($alumnos->get_uid(), '{}');
    $host = $_SERVER["HTTP_HOST"];
    $url = $_SERVER["REQUEST_URI"];
//    $retUrl = $host . substr($url, strpos($url, '/'), strpos($url, '/', 1));
//    $url_salida= 'http://'. $retUrl.'/controller/controller_salida_carga.php?id_log=';
    $url_salida= SITE_URL.'controller/controller_salida_carga.php?id_log=';
    $registros_alumnos = [];
    $registros_materias = [];
    $nombre_extension = explode('.', basename($archivo_destino));
    $extension = array_pop($nombre_extension);
    $nombre = array_pop($nombre_extension);
    for ($row = 2; $row <= $totReal; $row++) {

        //Variables de archivo
        $folio = $sheet->getCell("A" . $row)->getValue();
        $Id_Institucion = $sheet->getCell("B" . $row)->getValue();
        $Id_Campus = $sheet->getCell("C" . $row)->getValue();
        $Id_Oferta_Académica = $sheet->getCell("D" . $row)->getValue();
        $Anio_plan = $sheet->getCell("E" . $row)->getValue();
        $CURP_Alumno = $sheet->getCell("F" . $row)->getValue();
        $Matricula_Alumno = $sheet->getCell("G" . $row)->getValue();
        $Nombre_Alumno = rtrim(ltrim($sheet->getCell("H" . $row)->getValue()));
        $Apellido_Paterno_Alumno = rtrim(ltrim($sheet->getCell("I" . $row)->getValue()));
        $Apellido_Materno_Alumno = rtrim(ltrim($sheet->getCell("J" . $row)->getValue()));
        $Fecha_Nacimiento_Alumnov1 = $sheet->getCell("K" . $row)->getValue();

        if ($extension == 'csv') {
            $timestamp_1 = strtotime($Fecha_Nacimiento_Alumnov1);
        } else {
            $timestamp_1 = PHPExcel_Shared_Date::ExcelToPHP($Fecha_Nacimiento_Alumnov1);
        }

        //$Fecha_Nacimiento_Alumno = date("d/m/Y", $timestamp_1);
        $Fecha_Nacimiento_Alumno = \PHPExcel_Style_NumberFormat::toFormattedString($Fecha_Nacimiento_Alumnov1, 'DD/MM/YYYY');
        $Id_Entidad_Federativa_Alumno = str_pad($sheet->getCell("L" . $row)->getValue(), 2, "0", STR_PAD_LEFT);
        $Id_Genero_Alumno = $sheet->getCell("M" . $row)->getValue();
        $Id_Materia = $sheet->getCell("N" . $row)->getValue();
        $Id_Observacion_Materia = $sheet->getCell("O" . $row)->getValue();
        $Ciclo_Materia = $sheet->getCell("P" . $row)->getValue();
        $Calificacion_Materia = $sheet->getCell("Q" . $row)->getValue();
        $Id_Entidad_Federativa_Expedicion = str_pad($sheet->getCell("R" . $row)->getValue(), 2, "0", STR_PAD_LEFT);;
        $Fecha_Expedicion_v1 = $sheet->getCell("S" . $row)->getValue();
        if ($extension == 'csv') {
            $timestamp = strtotime($Fecha_Expedicion_v1);
        } else {
            $timestamp = PHPExcel_Shared_Date::ExcelToPHP($Fecha_Expedicion_v1);
        }
        $Fecha_Expedicion = \PHPExcel_Style_NumberFormat::toFormattedString($Fecha_Expedicion_v1, 'DD/MM/YYYY');
        //obtener booleano para comparación con catalogos
        $vfolio = $alumnos->getFolio($folio);
        $vId_Institucion = $alumnos->getInstitucion($Id_Institucion);
        $vId_Campus = $alumnos->getCampus($Id_Campus);
        $vId_Oferta_Académica = $alumnos->getOfertaAcademica($Id_Oferta_Académica);
        $vPlan = $alumnos->getPlan($Id_Oferta_Académica, $Anio_plan);
        $vId_Entidad_Federativa_Alumno = $alumnos->getEntidadF($Id_Entidad_Federativa_Alumno);
        $vId_Genero_Alumno = $alumnos->getGenero($Id_Genero_Alumno);
        $vId_Materia = $alumnos->getMateria($Id_Materia);
        $vId_Observacion_Materia = $alumnos->getObervaciones($Id_Observacion_Materia);
        $vId_Entidad_Federativa_Expedicion = $alumnos->getEntidadF($Id_Entidad_Federativa_Expedicion);
        //regex CURP
        $formato = '/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/';
        //mensajes de error
        $campus->setIdCampus($Id_Campus);

        //validar nulos
        if (!empty(trim($folio)) && !empty(trim($Id_Institucion)) && !empty(trim($Id_Campus)) && !empty(trim($Id_Oferta_Académica)) && !empty(trim($Anio_plan)) && !empty(trim($CURP_Alumno)) && !empty(trim($Matricula_Alumno)) && !empty(trim($Nombre_Alumno)) && !empty(trim($Apellido_Paterno_Alumno)) && !empty(trim($Apellido_Materno_Alumno)) && !empty(trim($Fecha_Nacimiento_Alumno)) && !empty(trim($Id_Entidad_Federativa_Alumno)) && !empty(trim($Id_Genero_Alumno)) && !empty(trim($Id_Materia)) && !empty(trim($Id_Observacion_Materia)) && !empty(trim($Ciclo_Materia)) && !empty(trim($Calificacion_Materia)) && !empty(trim($Id_Entidad_Federativa_Expedicion)) && !empty(trim($Fecha_Expedicion))) {
            //validar contra catalogos 
            if ($vId_Institucion && $vId_Campus && $vId_Oferta_Académica && $vPlan && $vId_Entidad_Federativa_Alumno && $vId_Genero_Alumno && $vId_Materia && $vId_Observacion_Materia && $vId_Entidad_Federativa_Expedicion) {
                //Vaidar campos en especifico
                if (!preg_match($formato, $CURP_Alumno)) {

                    $mgs_error = 'Los registros contienen CURP no validos';
                    $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error.' Datos ingresados: '.$CURP_Alumno, $_SESSION['usuarioid']);
                    $valida[] = 0;
                } elseif (!(strlen($Matricula_Alumno) > 9 && strlen($Matricula_Alumno) < 13)) {

                    $mgs_error = 'Los registros contienen matrículas no validas';
                    $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error.' Datos ingresados: '.$Matricula_Alumno, $_SESSION['usuarioid']);
                    $valida[] = 0;
                } elseif (!(idate("Y", $timestamp_1) > 1920 && idate("Y", $timestamp_1) < 2020)) {

                    $mgs_error = 'Los registros contienen fecha de nacimiento no validas' . $timestamp_1;
                    $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error.' Datos ingresados: '.$Fecha_Nacimiento_Alumnov1, $_SESSION['usuarioid']);
                    $valida[] = 0;
                } elseif (!(strlen(str_replace('-', '', $Ciclo_Materia)) == 5)) {

                    $mgs_error = 'Los registros contienen ciclos no validos';
                    $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error.' Datos ingresados: '.$Ciclo_Materia, $_SESSION['usuarioid']);
                    $valida[] = 0;
                } elseif (!($Calificacion_Materia > 6 && $Calificacion_Materia <= 10)) {

                    $mgs_error = 'Los registros contienen calificaciones no validas';
                    $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error.' Datos ingresados: '.$Calificacion_Materia, $_SESSION['usuarioid']);
                    $valida[] = 0;
                } elseif (!(idate("Y", $timestamp) >= 2019)) {

                    $mgs_error = 'Los registros contienen fechas de expedición no validas';
                    $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error.' Datos ingresados: '.$Fecha_Expedicion_v1, $_SESSION['usuarioid']);
                    $valida[] = 0;
                } elseif ($vfolio) {

                    $mgs_error = 'Los registros contienen folios registrados anterioremente.';
                    $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error.' Datos ingresados: '.$folio, $_SESSION['usuarioid']);
                    $valida[] = 0;
                } else {
                    if ($campus->getvalidacampus()) {
                        //se inserta el archivo
                        $registros_alumnos[] = ['Folio_Registro' => $folio, 'Id_Institucion' => $Id_Institucion, 'Id_Campus' => $Id_Campus, 'Id_Carrera' => $Id_Oferta_Académica, 'Anio_Plan' => $Anio_plan, 'CURP' => $CURP_Alumno, 'Matricula' => $Matricula_Alumno, 'Nombre' => $Nombre_Alumno, 'Apellido_Paterno' => $Apellido_Paterno_Alumno, 'Apellido_Materno' => $Apellido_Materno_Alumno, 'Fecha_Nacimiento' => $Fecha_Nacimiento_Alumno, 'Id_Entidad_F_Alumno' => $Id_Entidad_Federativa_Alumno, 'Id_Genero' => $Id_Genero_Alumno, 'Id_Entidad_Exp' => $Id_Entidad_Federativa_Expedicion, 'Fecha_Exp' => $Fecha_Expedicion];
                        $registros_materias[] = ['Folio_Registro' => $folio, 'Id_Carrera' => $Id_Oferta_Académica, 'Matricula' => $Matricula_Alumno, 'Id_Observacion' => $Id_Observacion_Materia, 'Id_Materia' => $Id_Materia, 'Ciclo' => $Ciclo_Materia, 'Calificacion' => $Calificacion_Materia];
                        //$mgs_error = 'Exitoso';
                        //echo var_dump(array_unique($registros_alumnos));
                        $valida[] = 1;
                        //$repetidos[] = (int)$folio;
                    } else {
                        $mgs_error = 'El usuario no cuenta con permiso para cargar archivos en el campus:' . $Id_Campus . '.';
                        $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error, $_SESSION['usuarioid']);
                        $valida[] = 0;
                    }
                }
            } else {

                $mgs_error = 'Los registros contienen información que no se encuentra registrada en los catálogos previamente cargados o en los catálogos de SEP ';
                $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error.' Datos ingresados: Id_Institucion:'.str_replace('true','Correcto',str_replace('false','Error',json_encode($vId_Institucion))).'||Id_Campus:'.str_replace('true','Correcto',str_replace('false','Error',json_encode($vId_Campus))).'||Id_Oferta_Académica:'.str_replace('true','Correcto',str_replace('false','Error',json_encode($vId_Oferta_Académica))).'||Anio_plan:'.str_replace('true','Correcto',str_replace('false','Error',json_encode($vPlan))).'||Id_Entidad_Federativa_Alumno:'.str_replace('true','Correcto',str_replace('false','Error',json_encode($vId_Entidad_Federativa_Alumno))).'||Id_Genero_Alumno'.str_replace('true','Correcto',str_replace('false','Error',json_encode($vId_Genero_Alumno))).'||Id_Materia'.str_replace('true','Correcto',str_replace('false','Error',json_encode($vId_Materia))).'||Id_Observacion_Materia'.str_replace('true','Correcto',str_replace('false','Error',json_encode($vId_Observacion_Materia))).'||Id_Entidad_Federativa_Expedicion:'.str_replace('true','Correcto',str_replace('false','Error',json_encode($vId_Entidad_Federativa_Expedicion))) , $_SESSION['usuarioid']);
                $valida[] = 0;
            }
        } else {

            $mgs_error = 'Los registros contienen celdas vacías';
            $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error, $_SESSION['usuarioid']);
            $valida[] = 0;
        }
    }
    if (count(array_unique($repetidos)) < count($repetidos)) {
        $mgs_error = 'El archivo contiene folios repetidos';
        $alumnos->registra_errores($guid, basename($archivo), $row, $mgs_error, $_SESSION['usuarioid']);
        $valida[] = 0;
    }

    if (!in_array(0, $valida)) {
        $temp = array();
        $new = array();

        foreach ($registros_alumnos as $value) {
            if (!in_array($value["Folio_Registro"], $temp)) {
                $temp[] = $value["Folio_Registro"];
                $new[] = $value;
            }
        }
        foreach ($new as $row_array) {
            $alumnos->setFolioRegistro($row_array['Folio_Registro']);
            $alumnos->setIdInstitucion($row_array['Id_Institucion']);
            $alumnos->setIdCampus($row_array['Id_Campus']);
            $alumnos->setIdOfertaAcadémica($row_array['Id_Carrera']);
            $alumnos->setAnio_Plan($row_array['Anio_Plan']);
            $alumnos->setCURP($row_array['CURP']);
            $alumnos->setMatricula($row_array['Matricula']);
            $alumnos->setNombre($row_array['Nombre']);
            $alumnos->setApellidoP($row_array['Apellido_Paterno']);
            $alumnos->setApellidoM($row_array['Apellido_Materno']);
            $alumnos->setFechaN($row_array['Fecha_Nacimiento']);
            $alumnos->setIdEntidadFederativa($row_array['Id_Entidad_F_Alumno']);
            $alumnos->setIdGeneroAlumno($row_array['Id_Genero']);
            $alumnos->setEntidadExp($row_array['Id_Entidad_Exp']);
            $alumnos->setFechaExp($row_array['Fecha_Exp']);
            $alumnos->setUser($_SESSION['usuarioid']);
            if (!$alumnos->registrararchivo()) {
                $valida_carga_1 = false;
                //echo var_dump($registros_materias);                
                //$mgs_error = 'El archivo no se pudo cargar correctamente en BD';
                //$response = ['error' => $mgs_error];
                //echo json_encode($response);
            } else {
                $valida_carga_1 = true;

                //$mgs_error = 'Archivo cargado exitosamente';
                //$response = ['success' => $mgs_error, 'total' => count($paths), 'ficheros' => $nombre . $extension];
                //echo json_encode($response);
            }
        }
        foreach ($registros_materias as $row1) {
            $alumnos->setFolioRegistro($row1['Folio_Registro']);
            $alumnos->setIdOfertaAcadémica($row1['Id_Carrera']);
            $alumnos->setMatricula($row1['Matricula']);
            $alumnos->setIdMateria($row1['Id_Materia']);
            $alumnos->setIdObservacionMateria($row1['Id_Observacion']);
            $alumnos->setCiclo($row1['Ciclo']);
            $alumnos->setCalificacion($row1['Calificacion']);
            if (!$alumnos->registrararchivoMaterias()) {
                $valida_carga_2 = false;
            } else {
                $valida_carga_2 = true;
            }
        }
        if (!$valida_carga_1 && !$valida_carga_2) {

            $mgs_error = 'El archivo no se pudo cargar correctamente en BD';
            $response = ['error' => $mgs_error];
        } else {
            $mgs_error = 'Archivo cargado exitosamente';
            $response = ['success' => $mgs_error, 'total' => count($paths), 'ficheros' => $nombre . $extension];
            //echo json_encode($response);
        }
    } else {
        $response = ['error' => $mgs_error.'<br>Puedes revisar el log de salida de tu carga <a href="'.$url_salida.$guid.'">aquí</a>'];
        //echo json_encode($response);
    }
    unlink($archivo_destino);
    $registro_bitacora = new bitacora();
    $registro_bitacora->registro_bitacora($_SESSION['usuarioid'], 'Generar', 'Proceso de carga de archivo:' . json_encode($response));
    return $response;
}
