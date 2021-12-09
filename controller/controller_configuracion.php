<?php
include_once dirname(__DIR__) . '/controller/controller_sesion.php';
$configuracion = new configuracion();
$tipoAutenticacion = $configuracion->getTipoAutenticacion();
$tipoAutenticacion['Autenticacion'] == 1 ? $checkedBD='checked' : $checkedBD='';
$tipoAutenticacion['Autenticacion'] == 0 ? $checkedAD='checked' : $checkedAD='';
?>