<?php
include_once dirname(__DIR__) . '/controller/controller_sesion.php';
include '../model/db.php';
include '../model/valida_alumnos.php';
include '../model/alumnos.php';
include_once dirname(__DIR__) . '/model/configuracion.php';
include_once dirname(__DIR__) . '/model/bitacora.php';
extract($_POST);

$ids = $_POST['folios_firma'];
//echo $ids;
$ids = explode(',', $ids);
$registro_bitacora=new bitacora();

$alumno = new alumno();
$update = new funciones_alumnos();
$configuracion = new configuracion();
$fileNameCer = $_FILES["archivocer"]["name"];
$fileNameKey = $_FILES["archivokey"]["name"];
$fileNameExtCer = explode(".", $fileNameCer);
$fileNameExtKey = explode(".", $fileNameKey);
$fileExtensionCer = strtolower(end($fileNameExtCer));
$fileExtensionKey = strtolower(end($fileNameExtKey));
$allowedfileExtensions = array('cer', 'key');

if (in_array($fileExtensionCer, $allowedfileExtensions) && in_array($fileExtensionKey, $allowedfileExtensions)) {
    $password = $password;
    $cer_path = $_FILES['archivocer']['tmp_name'];
    $key_path = $_FILES['archivokey']['tmp_name'];

    // calls SimpleCDF methods
    include_once dirname(__DIR__) .  '/lib/SimpleCFD.php';

    $array['noCertificado'] = SimpleCFD::getSerialFromCertificate($cer_path);
    $array['certificado'] = SimpleCFD::getCertificate($cer_path, false);
    $encoded = "-----BEGIN CERTIFICATE-----\n" . $array['certificado'] . "\n-----END CERTIFICATE-----";
    $cert_info = openssl_x509_parse($encoded);
    $CURP = $cert_info['subject']['serialNumber'];
    $certificado = $configuracion->getFirma();
    $curp_cer_db = $certificado['CURP_FIEL'];

    if ($CURP == $curp_cer_db) {
        $registros_error = [];
        $registros_correctos = [];
        //print_r($datosGenerales);
        
        if (SimpleCFD::signData(SimpleCFD::getPrivateKey($key_path, $password), 'Comprobar contraseña') != '0') {
            for ($i = 0; $i < count($ids); $i++) {
                $datosGenerales = $alumno->getDatosGenerales($ids[$i]);
                $folio=$ids[$i];
                $materiasalumno = $alumno->getMateriasAlumno($folio);
                
                $materias = "";
                //$cadenaSign='';
                if (count($datosGenerales) > 0 && count($materiasalumno) > 0) {
                    foreach ($datosGenerales as $cadena) {

                        $fechaExp = $cadena['Fecha_Exp'] . "T00:00:00";

                        $fechaRvoe = $cadena['Fecha_Registro'] . "T00:00:00";
                        $fechaNac = $cadena['Fecha_Nacimiento'] . "T00:00:00";
                        if($cadena['Promedio']=='10.00'){$promedio_f=number_format($cadena['Promedio'],0);}else{$promedio_f=$cadena['Promedio'];}
                        $getCadena = "||2.0|5|" . $cadena['Id_Institucion'] . "|" . $cadena['Id_Campus'] . "|" . $cadena['Id_Entidad_Exp'] . "|" . $cadena['CURP_aut'] . "|" . $cadena['Id_Cargo_aut'] . "|" . $cadena['RVOE'] . "|" . $fechaRvoe . "|" . $cadena['Id_Carrera'] . "|" . $cadena['Id_Periodo'] . "|" . $cadena['Anio_Plan'] . "|" . $cadena['Id_Nivel'] . "|" . number_format($cadena['Minima'],0) . "|" . number_format($cadena['Maxima'],0) . "|" . $cadena['Minima_Aprobatoria'] . "|" . $cadena['Matricula'] . "|" . $cadena['CURP'] . "|" . $cadena['Nombre'] . "|" . $cadena['Apellido_Paterno'] . "|" . $cadena['Apellido_Materno'] . "|" . $cadena['Id_Genero'] . "|" . $fechaNac . "|||" . $cadena['Tipo_Certificado'] . "|" . $fechaExp . "|" . $cadena['Id_Entidad_Exp'] . "|" . $cadena['Total_Materias'] . "|" . $cadena['Asignadas'] . "|" . $promedio_f . "|" . $cadena['Creditos_Totales'] . "|" . $cadena['Creditos_Obtenidos'];
                        foreach ($materiasalumno as $materia) {
                            if($materia['Calificacion']=='10.00'){$materia_f=number_format($materia['Calificacion'],0);}else{$materia_f=$materia['Calificacion'];}
                            $materias .= "|" . $materia['Id_Materia'] . "|" . $materia['Ciclo'] . "|" . $materia_f . "|" . $materia['Id_Tipo_Asignatura'] . "|" . $materia['Creditos'];
                        }
                        $cadenaSign = $getCadena . $materias . "||";
                        
                        $array['sello'] = SimpleCFD::signData(SimpleCFD::getPrivateKey($key_path, $password), $cadenaSign);
                        
                        $xmlbase64 = SimpleCFD::getXMLtest($cadena, $array, $ids[$i], $materiasalumno);
                        $xml = $xmlbase64;
                        
                        $respuesta = $alumno->addXML($ids[$i], $xml); //Registra XML en BD
                        
                        if ($respuesta) {
                            $update_res = $update->update_registros(3, $ids[$i]);
                        } // Actualiza el estatus del Folio
                        if ($respuesta && $update_res) {
                            array_push($registros_correctos, $ids[$i]);
                            
                        } else if ($respuesta) {
                            //rollback de registro de xml ya que no se actualizo el estatus
                            $alumno->rollback($ids[$i]);
                            array_push($registros_error, $ids[$i]);
                            
                        } else {
                            array_push($registros_error, $ids[$i]);
                            
                        }
                        
                    }
                } else {
                    array_push($registros_error, $ids[$i]);
                }
            }
            //errores de datos contra catalogos
            if (count($ids) == count($registros_error)) {
                //Error en todos los registros
                $res = array("acc" => false, "msg" => "Existen problemas con los datos de los registros por lo que no se firmaron los Xml correctamente.");
            } elseif (count($registros_error) > 0) {
                //Error en algunos regitros
                $res = array("acc" => true, "msg" => "Algunos registros no se pudieron procesar correctamente. Solo " . count($registros_correctos) . " de " . count($ids) . " fueron firmados correctamente.");
            } else {
                //Todos los registros correctos
                $res = array("acc" => true, "msg" => "Se firmaron y generaron correctamente los registros.");
            }
        } else {
            $res = array("acc" => false, "msg" => "La contraseña del certificado no es correcta, favor de validarla.");
        }
    } else {
        $res = array("acc" => false, "msg" => "El certificado ingresado no coincide con el registrado en la configuración del sistema.");
    }
    $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Firmar','Proceso de sellado de xml de registros:'.json_encode($res).'Id_Registros Error:'.json_encode($registros_error)."Id_Registros_totales". json_encode($ids));
    echo $var = json_encode($res);
    //echo var_dump($registros_error);
    //echo count($registros_correctos);
}
