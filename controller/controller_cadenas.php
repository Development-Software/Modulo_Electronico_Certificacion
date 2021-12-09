<?php
include_once dirname(__DIR__) . '/model/db.php';
include_once dirname(__DIR__) . '/model/permisos.php';
include_once dirname(__DIR__) . '/model/configuracion.php';
include_once dirname(__DIR__) . '/controller/controller_sesion.php';
include_once dirname(__DIR__) . '/model/alumnos.php';
include_once dirname(__DIR__) . '/model/permisos.php';
include_once dirname(__DIR__) . '/model/valida_alumnos.php';
$alumno = new alumno();
extract($_GET);
//echo '<pre>'.print_r(extract($_GET)).'</pre>';
$datosGenerales = $alumno->getDatosGenerales($id_registro);
$materiasalumno = $alumno->getMateriasAlumno($id_registro);
$materias = "";
if (count($datosGenerales) > 0 && count($materiasalumno) > 0) {
    foreach ($datosGenerales as $cadena) {
        $fechaExp = $cadena['Fecha_Exp'] . "T00:00:00";
        $fechaRvoe = $cadena['Fecha_Registro'] . "T00:00:00";
        $fechaNac = $cadena['Fecha_Nacimiento'] . "T00:00:00";
        if ($cadena['Promedio'] == '10.00') {
            $promedio_f = number_format($cadena['Promedio'], 0);
        } else {
            $promedio_f = $cadena['Promedio'];
        }
        $getCadena = "||2.0|5|" . $cadena['Id_Institucion'] . "|" . $cadena['Id_Campus'] . "|" . $cadena['Id_Entidad_Exp'] . "|" . $cadena['CURP_aut'] . "|" . $cadena['Id_Cargo_aut'] . "|" . $cadena['RVOE'] . "|" . $fechaRvoe . "|" . $cadena['Id_Carrera'] . "|" . $cadena['Id_Periodo'] . "|" . $cadena['Anio_Plan'] . "|" . $cadena['Id_Nivel'] . "|" . number_format($cadena['Minima'], 0) . "|" . number_format($cadena['Maxima'], 0) . "|" . $cadena['Minima_Aprobatoria'] . "|" . $cadena['Matricula'] . "|" . $cadena['CURP'] . "|" . $cadena['Nombre'] . "|" . $cadena['Apellido_Paterno'] . "|" . $cadena['Apellido_Materno'] . "|" . $cadena['Id_Genero'] . "|" . $fechaNac . "|||" . $cadena['Tipo_Certificado'] . "|" . $fechaExp . "|" . $cadena['Id_Entidad_Exp'] . "|" . $cadena['Total_Materias'] . "|" . $cadena['Asignadas'] . "|" . $promedio_f . "|" . $cadena['Creditos_Totales'] . "|" . $cadena['Creditos_Obtenidos'];
        foreach ($materiasalumno as $materia) {
            if ($materia['Calificacion'] == '10.00') {
                $materia_f = number_format($materia['Calificacion'], 0);
            } else {
                $materia_f = $materia['Calificacion'];
            }
            $materias .= "|" . $materia['Id_Materia'] . "|" . $materia['Ciclo'] . "|" . $materia_f . "|" . $materia['Id_Tipo_Asignatura'] . "|" . $materia['Creditos'];
        }
        $cadenaSign = $getCadena . $materias . "||";
    }
}
?>
<form>
    <div style="width: 80%;margin:auto;word-wrap: break-word;">
        <?php echo $cadenaSign; ?>
    </div>
</form>