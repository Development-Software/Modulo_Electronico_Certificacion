<?php
error_reporting(E_ALL);
include_once '../controller/controller_sesion.php';
  extract($_POST);
  include_once '../model/db.php';
  include_once '../model/configuracion.php';
  include_once '../model/bitacora.php';
  $registro_bitacora=new bitacora();
  $configuracion = new Configuracion();
  $configuracion->setSerieCerFirma($numero_serie);
  $configuracion->setNombreCerFirma($nombre_aut);
  $configuracion->setCurpCerFirma($CURP);
  $registro_bitacora->registro_bitacora($_SESSION['usuarioid'],'Firma','El usuario cambio la firma registrada para los certificados. El CURP de la nueva firma es:  '.$CURP );
  echo $tipoAutenticacion = $configuracion->updateCerFirma();