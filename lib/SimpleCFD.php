<?php
/**
 * SimpleCFD (Comprobantes Fiscales Digitales)
 * Copyright (C) 2010 Basilio Briceno Hernandez <bbh@tlalokes.org>
 *
 * SimpleCFD class is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Lesser General Public License as published by the
 * Free Software Foundation, version 3 of the License.
 *
 * SimpleCFD is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser General Public License
 * for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with SimpleCFD. If not, see <http://www.gnu.org/licenses/lgpl.html>.
 */

/**
 * SimpleCFD provides static methods to process a Comprobante Fiscal Digital
 * also named as Factura Electronica.
 *
 * @version 0.3
 * @author Basilio Brice&ntilde;o Hern&aacute;ndez <bbh@tlalokes.org>
 * @copyright Copyright &copy; 2010 Basilio Brice&ntilde;o Hern&aacute;ndez
 * @license http://www.gnu.org/licenses/lgpl.html GNU LGPL
 */
class SimpleCFD {

  /**
   * Encodes data from UTF-8 to ISO-8859-1 throw HTML entities
   *
   * @param string $text
   * @return string
   */
  private static function encText( $text )
  {
    return html_entity_decode( htmlentities( $text, ENT_QUOTES, 'UTF-8' ),
                               ENT_QUOTES, 'ISO-8859-1' );
  }

  /**
   * Returns the CFD as PDF
   *
   * @param array $data the CFD array
   * @param boolean $print_headers if set true, it prints the PDF directly
   * @return mixed
   */
  public static function getPDF ( array &$data, $print_headers = false )
  {
    try {
      $p = new PDFlib();

      $p->set_parameter("errorpolicy", "return");

      if ( $p->begin_document( "", "" ) == 0 ) {
        die( "Error: " . $p->get_errmsg() );
      }

      $p->set_info( "Creator", "SimpleCFD.php" );
      $p->set_info( "Author", self::encText( $data['Emisor']['nombre'] ) );
      $p->set_info( "Title", "Factura No. " . $data['folio'] );
      $p->set_info( "Subject", "Factura emitada a ".
                               self::encText( $data['Receptor']['nombre'] ).
                               " el ".$data['fecha'] );

      // set letter size
      $p->begin_page_ext( 612, 792, "" );

      $font = $p->load_font( "Helvetica-Bold", "iso8859-1", "" );

      $p->setfont( $font, 12 );

      $p->fit_textline( "Factura", 30, 750, "fontsize=16 position=left" );

      // Serie
      if ( isset( $data['serie'] ) ) {
        $p->fit_textline( "Serie: ", 120, 765,
                          "fontsize=8 fillcolor={rgb 0.6 0.3 0.6} ".
                          "position={bottom left} boxsize={25 10}" );
        $p->fit_textline( $data['serie'], 145, 765,
                    "fontsize=8 ".
                    "position={bottom left} boxsize={60 10}" );
      }
      // Folio
      $p->fit_textline( "Folio: ", 120, 750,
                        "fontsize=8 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={25 10}" );
      $p->fit_textline( $data['folio'], 145, 750,
                        "fontsize=8 ".
                        "position={bottom left} boxsize={90 10}" );
      // AnoAprobacion
      $p->fit_textline( self::encText( "A�o de Aprobaci�n: " ), 250, 765,
                        "fontsize=8 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={80 10}" );
      $p->fit_textline( $data['anoAprobacion'], 330, 765,
                        "fontsize=8 ".
                        "position={bottom left} boxsize={20 10}" );
      // NoAprobacion
      $p->fit_textline( self::encText( "N�mero de Aprobaci�n: " ), 250, 750,
                        "fontsize=8 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={95 10}" );
      $p->fit_textline( $data['noAprobacion'], 345, 750,
                        "fontsize=8 ".
                        "position={bottom left} boxsize={65 10}" );
      // Fecha
      $p->fit_textline( "Fecha:", 425, 750,
                        "fontsize=8 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={30 10}" );
      $p->fit_textline( $data['fecha'], 455, 750,
                        "fontsize=8 ".
                        "position={bottom left} boxsize={80 10}" );

      // line
      $p->moveto( 30, 740 );
      $p->lineto( 580, 740);
      $p->stroke();

      $p->setlinewidth( 0.5 );

      // Emisor
      $p->fit_textline( "Emisor", 30, 720,
                        "fontsize=10 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={200 20}" );

      $p->fit_textline( self::encText( $data['Emisor']['nombre'] ), 30, 695,
                        "fontsize=18 ".
                        "position={bottom left} boxsize={270 20}" );

      $p->fit_textline( "RFC: ".$data['Emisor']['rfc'], 30, 675,
                        "fontsize=14 ".
                        "position={bottom left} boxsize={270 15}" );

      $domicilio = self::encText( $data['DomicilioFiscal']['calle'] )." No. ".
                   $data['DomicilioFiscal']['noExterior'];
      $domicilio .= isset( $data['DomicilioFiscal']['noInterior'] ) ?
                    " - ".$data['DomicilioFiscal']['noInterior'] : '';
      $p->fit_textline( self::encText( $domicilio ), 30, 660, "fontsize=12 ".
                        "position={bottom left} boxsize={270 10}" );
      unset( $domicilio );

      $p->fit_textline( self::encText( $data['DomicilioFiscal']['colonia'] ),
                        30, 645, "fontsize=12 ".
                        "position={bottom left} boxsize={270 10}" );

      $p->fit_textline( self::encText( $data['DomicilioFiscal']['municipio'] ),
                        30, 630, "fontsize=12 ".
                        "position={bottom left} boxsize={270 10}" );

      $p->fit_textline( "C.P. ".$data['DomicilioFiscal']['codigoPostal'],
                        30, 615, "fontsize=12 ".
                        "position={bottom left} boxsize={270 10}" );

      $p->fit_textline( self::encText( $data['DomicilioFiscal']['estado'] ),
                        30, 600, "fontsize=12 ".
                        "position={bottom left} boxsize={270 10}" );

      // Receptor
      $p->fit_textline( "Receptor", 380, 720,
                        "fontsize=10 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom right} boxsize={200 20}" );

      $p->fit_textline( self::encText( $data['Receptor']['nombre'] ), 310, 695,
                        "fontsize=18 ".
                        "position={bottom right} boxsize={270 20}" );

      $p->fit_textline( "RFC: ".$data['Receptor']['rfc'], 310, 675,
                        "fontsize=14 ".
                        "position={bottom right} boxsize={270 15}" );

      $domicilio = self::encText( $data['Domicilio']['calle'] )." No. ".
                   $data['Domicilio']['noExterior'];
      $domicilio .= isset( $data['Domicilio']['noInterior'] ) ?
                    " - ".$data['Domicilio']['noInterior'] : '';
      $p->fit_textline( $domicilio, 310, 660, "fontsize=12 ".
                        "position={bottom right} boxsize={270 10}" );
      unset( $domicilio );

      $p->fit_textline( self::encText( $data['Domicilio']['colonia'] ),
                        310, 645, "fontsize=12 ".
                        "position={bottom right} boxsize={270 10}" );

      $p->fit_textline( self::encText( $data['Domicilio']['municipio'] ),
                        310, 630, "fontsize=12 ".
                        "position={bottom right} boxsize={270 10}" );

      $p->fit_textline( "C.P. ".$data['Domicilio']['codigoPostal'],
                        310, 615, "fontsize=12 ".
                        "position={bottom right} boxsize={270 10}" );

      $p->fit_textline( self::encText( $data['Domicilio']['estado'] ),
                        310, 600, "fontsize=12 ".
                        "position={bottom right} boxsize={270 10}" );

      // line
      $p->moveto( 30, 585 );
      $p->lineto( 580, 585);
      $p->stroke();

      // Concepto

      // Cantidad
      $p->fit_textline( "Cantidad", 30, 565, "fontsize=11 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={50 10}" );

      // Descripcion
      $p->fit_textline( self::encText( "Descripci�n" ), 100, 565,
                        "fontsize=11 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={65 10}" );

      // Precio
      $p->fit_textline( "Precio", 483, 565, "fontsize=11 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={35 10}" );

      // Importe
      $p->fit_textline( "Importe", 540, 565, "fontsize=11 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={40 10}" );

      // line
      $p->moveto( 30, 555 );
      $p->lineto( 580, 555);
      $p->stroke();

      $count = count( $data['Concepto'] );
      static $pos = 552;
      for ( $i = 0; $i < $count; ++$i ) {
        $pos -= 20;
        // Cantidad
        $p->fit_textline( $data['Concepto'][$i]['cantidad'],
                          30, $pos, "fontsize=9 ".
                          "position={bottom left} boxsize={145 10}" );
        // Descripcion
        $p->fit_textline( $data['Concepto'][$i]['descripcion'],
                          100, $pos, "fontsize=9 ".
                          "position={bottom left} boxsize={145 10}" );
        // Valor unitario
        $p->fit_textline( $data['Concepto'][$i]['valorUnitario'],
                          483, $pos, "fontsize=9 ".
                          "position={bottom left} boxsize={145 10}" );
        // Importe
        $p->fit_textline( $data['Concepto'][$i]['importe'],
                          435, $pos, "fontsize=9 ".
                          "position={bottom right} boxsize={145 10}" );
      }

      // line cantidad
      $p->moveto( 90, 580 );
      $p->lineto( 90, $pos - 10 );
      $p->stroke();

      // line descripcion
      $p->moveto( 470, 580 );
      $p->lineto( 470, $pos - 10 );
      $p->stroke();

      // line
      $p->moveto( 30, $pos - 20 );
      $p->lineto( 580, $pos - 20 );
      $p->stroke();

      // Subtotal
      $pos -= 40;
      $p->fit_textline( "SubTotal",
                        375, $pos, "fontsize=9 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom right} boxsize={145 10}" );
      $p->fit_textline( $data['subTotal'],
                        435, $pos, "fontsize=9 ".
                        "position={bottom right} boxsize={145 10}" );

      // Traslado
      if ( isset( $data['Traslado'] ) ) {
        $count = count( $data['Traslado'] );
        for ( $i = 0; $i < $count; ++$i ) {
          $pos -= 20;
          $p->fit_textline( $data['Traslado'][$i]['impuesto'], 375, $pos,
                            "fontsize=9 fillcolor={rgb 0.6 0.3 0.6} ".
                            "position={bottom right} boxsize={145 10}" );
          $p->fit_textline( " (Tasa: ".$data['Traslado'][$i]['tasa']."%)",
                            357, $pos+1, "fontsize=6 fillcolor={rgb 0.6 0.3 0.6} ".
                            "position={bottom right} boxsize={145 10}" );
          $p->fit_textline( $data['Traslado'][$i]['importe'],
                            435, $pos, "fontsize=9 ".
                            "position={bottom right} boxsize={145 10}" );
        }
      }
      // Retencion
      if ( isset( $data['Retencion'] ) ) {
        $count = count( $data['Retencion'] );
        for ( $i = 0; $i < $count; ++$i ) {
          $pos -= 20;
          $p->fit_textline( self::encText( "Retenci�n " ).
                            $data['Retencion'][$i]['impuesto'],
                            375, $pos, "fontsize=9 fillcolor={rgb 0.6 0.3 0.6} ".
                            "position={bottom right} boxsize={145 10}" );
          $p->fit_textline( $data['Retencion'][$i]['importe'],
                            435, $pos, "fontsize=9 ".
                            "position={bottom right} boxsize={145 10}" );
        }
      }

      // Total
      $pos -= 20;
      $p->fit_textline( "Total",
                        375, $pos, "fontsize=9 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom right} boxsize={145 10}" );
      $p->fit_textline( $data['total'], 435, $pos, "fontsize=9 ".
                        "position={bottom right} boxsize={145 10}" );

      // line importe
      $pos -= 10;
      $p->moveto( 530, 580 );
      $p->lineto( 530, $pos );
      $p->stroke();

      // line
      $pos -= 10;
      $p->moveto( 30, $pos );
      $p->lineto( 580, $pos );
      $p->stroke();

      // noCertificado
      $pos -= 20;
      $p->fit_textline( self::encText( "N�mero de Serie del Certificado:" ),
                        30, $pos, "fontsize=9 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={145 10}" );
      $p->fit_textline( self::encText( $data['noCertificado'] ), 175, $pos,
                        "fontsize=9 position={bottom left} boxsize={100 10}" );

      // cadenaOriginal
      $p->fit_textline( "Cadena original:", 30, $pos-20,
                        "fontsize=9 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={75 10}" );
      $cad = explode( ":::", wordwrap( self::encText( $data['cadenaOriginal'] ),
                                       150, ":::", true ) );
      $count = count( $cad );
      $position_cad = $pos - 20;
      for ( $i = 0; $i < $count; ++$i ) {
        $position_cad -= 10;
        $p->fit_textline( $cad[$i], 30, $position_cad,
                         "fontsize=7 position={bottom left} boxsize={550 10}" );
      }
      unset( $count );

      // sello
      $position_cer = $position_cad - 20;
      $p->fit_textline( "Sello Digital:", 30, $position_cer,
                        "fontsize=9 fillcolor={rgb 0.6 0.3 0.6} ".
                        "position={bottom left} boxsize={60 10}" );
      $cer = explode( ":::", wordwrap( $data['sello'],115,":::",true ) );
      $count = count( $cer );
      $position = $position_cer;
      for ( $i = 0; $i < $count; ++$i ) {
        $position -= 10;
        $p->fit_textline( self::encText( $cer[$i] ), 30, $position,
                         "fontsize=7 position={bottom left} boxsize={550 10}" );
      }
      unset( $count );
      unset( $cer );

      // note CFD
      $p->fit_textline( self::encText( "Este documento es una impresi�n de un ".
                                       "Comprobante Fiscal Digital " ), 150,
                        $position - 30, "fontsize=10 ".
                        "position={bottom left} boxsize={320 10}" );

      $p->end_page_ext( "" );

      $p->end_document( "" );

      $buf = $p->get_buffer();

      unset( $p );

      if ( $print_headers ) {
        $len = strlen( $buf );
        header( "Content-type: application/pdf" );
        header( "Content-Length: $len" );
        header( "Content-Disposition: inline; filename=hello.pdf" );
        echo $buf;
        exit;
      }

      return $buf;

    } catch ( PDFlibException $e ) {
      die( "PDFlib exception occurred in Factura:\n" . "[" . $e->get_errnum() .
           "] " . $e->get_apiname() . ": " . $e->get_errmsg() . "\n" );
    } catch ( Exception $e ) {
      die( $e );
    }
  }
  /**
   * Trasforms a CFD array into a CFD XML
   *
   * @param array $data
   * @return string CFD XML
   */
  public static function getXMLU ()
  {
    $dom = new DOMDocument( '1.0', 'UTF-8' );
    $dom->formatOutput = true;

    // Dec
    $dec = $dom->createElement( 'Dec' );
    $dom->appendChild( $dec );
	
	$version = $dom->createAttribute( 'version' );
	$version->appendChild( $dom->createTextNode( "2.0" ) );
    $dec->appendChild( $version );
    
	$tipoCertificado = $dom->createAttribute( 'tipoCertificado' );
	$tipoCertificado->appendChild( $dom->createTextNode( "5" ) );
    $dec->appendChild( $tipoCertificado );
	
	$foliocontrol = $dom->createAttribute( 'folioControl' );
	$foliocontrol->appendChild( $dom->createTextNode( "001" ) );
    $dec->appendChild( $foliocontrol );
	
    $sello = $dom->createAttribute( 'sello' );
	$sello->appendChild( $dom->createTextNode( "abcdefghijklmn�opqrtuvwxyz" ) );
    $dec->appendChild( $sello );
	
	$noCertificadoResponsable = $dom->createAttribute( 'noCertificadoResponsable' );
	$noCertificadoResponsable->appendChild( $dom->createTextNode( "00001000000404869085" ) );
    $dec->appendChild( $noCertificadoResponsable );
	
	$xmlns = $dom->createAttribute( 'xmlns' );
    $xmlns->appendChild( $dom->createTextNode( "https://www.siged.sep.gob.mx/certificados/" ) );
    $dec->appendChild( $xmlns );
	
	//Ipes
	$ipes = $dom->createElement( 'Ipes' );
    $dec->appendChild( $ipes );

    $idNombreInstitucion = $dom->createAttribute( 'idNombreInstitucion' );
    $ipes->appendChild( $idNombreInstitucion );
    $idNombreInstitucion->appendChild( $dom->createTextNode( '20002' ) );
    
    $idCampus = $dom->createAttribute( 'idCampus' );
    $ipes->appendChild( $idCampus );
    $idCampus->appendChild( $dom->createTextNode( '090101' ) );

    $idEntidadFederativa = $dom->createAttribute( 'idEntidadFederativa' );
    $ipes->appendChild( $idEntidadFederativa );
    $idEntidadFederativa->appendChild( $dom->createTextNode( '09' ) );	
	
    // Responsable
    $responsable = $dom->createElement( 'Responsable' );
    $ipes->appendChild( $responsable );
	
	$nombre = $dom->createAttribute( 'nombre' );
    $responsable->appendChild( $nombre );
    $nombre->appendChild( $dom->createTextNode( 'MARIA ANTONIETA' ) );
	
	$primerApellido = $dom->createAttribute( 'primerApellido' );
    $responsable->appendChild( $primerApellido );
    $primerApellido->appendChild( $dom->createTextNode( 'MARTINEZ' ) );
	
	$segundoApellido = $dom->createAttribute( 'segundoApellido' );
    $responsable->appendChild( $segundoApellido );
    $segundoApellido->appendChild( $dom->createTextNode( 'RODRIGUEZ' ) );
	
	$curp = $dom->createAttribute( 'curp' );
    $responsable->appendChild( $curp );
    $curp->appendChild( $dom->createTextNode( 'MARA720117MDFRDN00' ) );
	
	$idCargo = $dom->createAttribute( 'idCargo' );
    $responsable->appendChild( $idCargo );
    $idCargo->appendChild( $dom->createTextNode( '1' ) );
	    	
    //rvoe
    $rvoe = $dom->createElement( 'Rvoe' );
    $dec->appendChild( $rvoe );	
	
	$numero = $dom->createAttribute( 'numero' );
    $rvoe->appendChild( $numero );
    $numero->appendChild( $dom->createTextNode( '20160537' ) );	
	
	$fechaExpedicion = $dom->createAttribute( 'fechaExpedicion' );
    $rvoe->appendChild( $fechaExpedicion );
    $fechaExpedicion->appendChild( $dom->createTextNode( '2016-07-20T00:00:00' ) );
	
	
$element = $dom->createElement('test', 'This is the root element!');
// We insert the new element as root (child of the document)
$dec->appendChild($element);
    		
	//carrera
	/*$carreras = $dom->createElement( 'Carrera' );
    $co->appendChild( $carreras );	
	
	$numeroc = $dom->createAttribute( 'numeroControl' );
    $co->appendChild( $numeroc );
    $numeroc->appendChild( $dom->createTextNode( '20160537' ) );
	
	//Ipes
	$Alumno = $dom->createElement( 'Alumno' );
    $co->appendChild( $Alumno );

    $numeroControl = $dom->createAttribute( 'numeroControl' );
    $Alumno->appendChild( $numeroControl );
    $numeroControl->appendChild( $dom->createTextNode( 'U00000890' ) );
    
    $curpa = $dom->createAttribute( 'curp' );
    $Alumno->appendChild( $curpa );
    $curpa->appendChild( $dom->createTextNode( '090101' ) );

    $nombrea = $dom->createAttribute( 'nombre' );
    $Alumno->appendChild( $nombrea );
    $nombrea->appendChild( $dom->createTextNode( 'MARIA DEL PILAR' ) );	
*/
	
    return $dom->saveXML();
	
  }
  
public static function getXMLtest ($cadena,$array,$folio,$materiasalumno)
  {



$xml_header = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?><Dec></Dec>';

$sxe = new SimpleXMLElement($xml_header);
$sxe->addAttribute('version', '2.0');
$sxe->addAttribute('tipoCertificado', '5'); //tipocertificado  es id/nombre $cadena['Tipo_Certificado']
$sxe->addAttribute('folioControl', $cadena['folioControl']); //folioControl no viene, lo tomo de los ids enviados sin 0
$sxe->addAttribute('sello', $array['sello']);
$sxe->addAttribute('certificadoResponsable', $array['certificado']);
$sxe->addAttribute('noCertificadoResponsable', $array['noCertificado']);
$sxe->addAttribute('xmlns', 'https://www.siged.sep.gob.mx/certificados/');

$ipes = $sxe->addChild('Ipes');
$ipes->addAttribute('idNombreInstitucion', $cadena['Id_Institucion']);
$ipes->addAttribute('idCampus', $cadena['Id_Campus']);
$ipes->addAttribute('idEntidadFederativa',$cadena['Id_Entidad_Exp']);
$ipe  = $ipes->addChild('Responsable');
$ipe->addAttribute('nombre', $cadena['Nombre_aut']);
$ipe->addAttribute('primerApellido', $cadena['Apellido_P_aut']);
$ipe->addAttribute('segundoApellido', $cadena['Apellido_M_aut']);
$ipe->addAttribute('curp', $cadena['CURP_aut']);
$ipe->addAttribute('idCargo', $cadena['Id_Cargo_aut']);



$rvoe = $sxe->addChild('Rvoe');
$rvoe->addAttribute('numero', $cadena['RVOE']);
$rvoe->addAttribute('fechaExpedicion', $cadena['Fecha_Registro'].'T00:00:00'); //verificar si es fecha de RVOE o fecha de Expedicion


$carrera = $sxe->addChild('Carrera');
$carrera->addAttribute('idCarrera', $cadena['Id_Carrera']);
$carrera->addAttribute('idTipoPeriodo', $cadena['Id_Periodo']);
$carrera->addAttribute('clavePlan', $cadena['Anio_Plan']); //cual es clave_carrera/anio_plan
$carrera->addAttribute('idNivelEstudios',$cadena['Id_Nivel']);
$carrera->addAttribute('calificacionMinima', number_format($cadena['Minima'],0));
$carrera->addAttribute('calificacionMaxima', number_format($cadena['Maxima'],0));
$carrera->addAttribute('calificacionMinimaAprobatoria', $cadena['Minima_Aprobatoria']);  


$alumno = $sxe->addChild('Alumno');
$alumno->addAttribute('numeroControl', $cadena['Matricula']);
$alumno->addAttribute('curp', $cadena['CURP']);
$alumno->addAttribute('nombre', $cadena['Nombre']);
$alumno->addAttribute('primerApellido', $cadena['Apellido_Paterno']);
$alumno->addAttribute('segundoApellido', $cadena['Apellido_Materno']);
$alumno->addAttribute('idGenero', $cadena['Id_Genero']);
$alumno->addAttribute('fechaNacimiento', $cadena['Fecha_Nacimiento'].'T00:00:00'); 

$expedicion = $sxe->addChild('Expedicion');
$expedicion->addAttribute('idTipoCertificacion', $cadena['Tipo_Certificado']);  //no viene el idTipoCertificacion en la consulta
$expedicion->addAttribute('fecha', $cadena['Fecha_Exp'].'T00:00:00');   //verificar si es fecha de RVOE o fecha de Expedicion
$expedicion->addAttribute('idLugarExpedicion', $cadena['Id_Entidad_Exp']);

$asignaturas = $sxe->addChild('Asignaturas');
$asignaturas->addAttribute('total', $cadena['Total_Materias']);
$asignaturas->addAttribute('asignadas', $cadena['Asignadas']);
if($cadena['Promedio']=='10.00'){$promedio_f=number_format($cadena['Promedio'],0);}else{$promedio_f=$cadena['Promedio'];}
$asignaturas->addAttribute('promedio', $promedio_f);
$asignaturas->addAttribute('totalCreditos', $cadena['Creditos_Totales']); //verificar si est� correcto la variable asignada
$asignaturas->addAttribute('creditosObtenidos', $cadena['Creditos_Obtenidos']);

foreach($materiasalumno as $materia){
	$asignatura  = $asignaturas->addChild('Asignatura');
	$asignatura->addAttribute('idAsignatura', $materia['Id_Materia']);
  $asignatura->addAttribute('ciclo', $materia['Ciclo']);
  if($materia['Calificacion']=='10.00'){$materia_f=number_format($materia['Calificacion'],0);}else{$materia_f=$materia['Calificacion'];}
	$asignatura->addAttribute('calificacion',$materia_f );
	$asignatura->addAttribute('idObservaciones', $materia['Id_Observacion']);
	$asignatura->addAttribute('idTipoAsignatura', $materia['Id_Tipo_Asignatura']);
	$asignatura->addAttribute('creditos', $materia['Creditos']);
  }


return base64_encode($sxe->asXML());
//return $sxe->asXML();
  }	  
  
  /**
   * Trasforms a CFD array into a CFD XML
   *
   * @param array $data
   * @return string CFD XML
   */
  public static function getXML ( array $data )
  {
    $dom = new DOMDocument( '1.0', 'UTF-8' );
    $dom->formatOutput = true;

    // Comprobante
    $co = $dom->createElement( 'Dec' );
    $dom->appendChild( $co );
	
	$version = $dom->createAttribute( 'version' );
    $co->appendChild( $version );
    $version->appendChild( $dom->createTextNode( '2.0' ) );
	
	$tipoCertificado = $dom->createAttribute( 'tipoCertificado' );
    $co->appendChild( $tipoCertificado );
    $tipoCertificado->appendChild( $dom->createTextNode( '5' ) );
	
	$folioControl = $dom->createAttribute( 'folioControl' );
    $co->appendChild( $folioControl );
    $folioControl->appendChild( $dom->createTextNode( '001' ) );
	
	$sello = $dom->createAttribute( 'sello' );
    $co->appendChild( $sello );
    $sello->appendChild( $dom->createTextNode( 'abcdefghijklmn�opqrtuvwxyz' ) );
	
	$certificadoResponsable = $dom->createAttribute( 'certificadoResponsable' );
    $co->appendChild( $certificadoResponsable );
    $certificadoResponsable->appendChild( $dom->createTextNode( 'MIIGizCCBHOgAwIBAgIUMDAwMDEwMD' ) );
	
	$noCertificadoResponsable = $dom->createAttribute( 'noCertificadoResponsable' );
    $co->appendChild( $noCertificadoResponsable );
    $noCertificadoResponsable->appendChild( $dom->createTextNode( '00001000000404869085' ) );
	
    $xmlns = $dom->createAttribute( 'xmlns' );
    $xmlns->appendChild( $dom->createTextNode( "https://www.siged.sep.gob.mx/certificados/" ) );
    $co->appendChild( $xmlns );


    // Ipes
    $e = $dom->createElement( 'Ipes' );
    $co->appendChild( $e );

    $idNombreInstitucion = $dom->createAttribute( 'idNombreInstitucion' );
    $e->appendChild( $idNombreInstitucion );
    $idNombreInstitucion->appendChild( $dom->createTextNode( '20002' ) );
    
	$idCampus = $dom->createAttribute( 'idCampus' );
    $e->appendChild( $idCampus );
    $idCampus->appendChild( $dom->createTextNode( '090101' ) );
	
	$idEntidadFederativa = $dom->createAttribute( 'idEntidadFederativa' );
    $e->appendChild( $idEntidadFederativa );
    $idEntidadFederativa->appendChild( $dom->createTextNode( '09' ) );

    // Responsable
    $res = $dom->createElement( 'Responsable' );
    $e->appendChild( $res );

    $nombre = $dom->createAttribute( 'nombre' );
    $res->appendChild( $nombre );
    $nombre->appendChild( $dom->createTextNode( 'MARIA ANTONIETA' ) );
    
    $primerApellido = $dom->createAttribute( 'primerApellido' );
    $res->appendChild( $primerApellido );
    $primerApellido->appendChild( $dom->createTextNode( 'MARTINEZ' ) );
   
    $segundoApellido = $dom->createAttribute( 'segundoApellido' );
    $res->appendChild( $segundoApellido );
    $segundoApellido->appendChild( $dom->createTextNode( 'RODRIGUEZ' ) );
    
    $curp = $dom->createAttribute( 'curp' );
    $res->appendChild( $curp );
    $curp->appendChild( $dom->createTextNode( 'MARA720117MDFRDN00' ) );

    $idCargo = $dom->createAttribute( 'idCargo' );
    $res->appendChild( $idCargo );
    $idCargo->appendChild( $dom->createTextNode( '1' ) );
  
    // Rvoe
    $r = $dom->createElement( 'Rvoe','' );
    $co->appendChild( $r );

    $numero = $dom->createAttribute( 'numero' );
    $r->appendChild( $numero );
    $numero->appendChild( $dom->createTextNode( '20160537' ) );
   
    $fechaExpedicion = $dom->createAttribute( 'fechaExpedicion' );
    $r->appendChild( $fechaExpedicion );
    $fechaExpedicion->appendChild( $dom->createTextNode( '2016-07-20T00:00:00' ) );
  

    // Domicilio
    //$d = $dom->createElement( 'test' );
    //$r->appendChild( $d );



    // Conceptos
    $cs = $dom->createElement( 'Conceptos' );
    $co->appendChild( $cs );

    $count = count( $data['Concepto'] );
    if ( $count == 1 ) {

      $c = $dom->createElement( 'Concepto' );
      $cs->appendChild( $c );

      if ( isset( $data['Concepto'][0]['cantidad'] ) ) {
        $c_cantidad = $dom->createAttribute( 'cantidad' );
        $c->appendChild( $c_cantidad );
        $c_cantidad->appendChild( $dom->createTextNode( $data['Concepto'][0]['cantidad'] ) );
      }

      if ( isset( $data['Concepto'][0]['unidad'] ) ) {
        $c_unidad = $dom->createAttribute( 'unidad' );
        $c->appendChild( $c_unidad );
        $c_unidad->appendChild( $dom->createTextNode( $data['Concepto'][0]['unidad'] ) );
      }

      if ( isset( $data['Concepto'][0]['noIdentificacion'] ) ) {
        $c_noIdentificacion = $dom->createAttribute( 'noIdentificacion' );
        $c->appendChild( $c_noIdentificacion );
        $c_noIdentificacion->appendChild( $dom->createTextNode( $data['Concepto'][0]['noIdentificacion'] ) );
      }

      if ( isset( $data['Concepto'][0]['descripcion'] ) ) {
        $c_descripcion = $dom->createAttribute( 'descripcion' );
        $c->appendChild( $c_descripcion );
        $c_descripcion->appendChild( $dom->createTextNode( $data['Concepto'][0]['descripcion'] ) );
      }

      if ( isset( $data['Concepto'][0]['valorUnitario'] ) ) {
        $c_valorUnitario = $dom->createAttribute( 'valorUnitario' );
        $c->appendChild( $c_valorUnitario );
        $c_valorUnitario->appendChild( $dom->createTextNode( $data['Concepto'][0]['valorUnitario'] ) );
      }

      if ( isset( $data['Concepto'][0]['importe'] ) ) {
        $c_importe = $dom->createAttribute( 'importe' );
        $c->appendChild( $c_importe );
        $c_importe->appendChild( $dom->createTextNode( $data['Concepto'][0]['importe'] ) );
      }
    } else {
      for( $i = 0; $i < $count; ++$i ) {

        $c_{$i} = $dom->createElement( 'Concepto' );
        $cs->appendChild( $c_{$i} );

        if ( isset( $data['Concepto'][$i]['cantidad'] ) ) {
          $c_cantidad = $dom->createAttribute( 'cantidad' );
          $c_{$i}->appendChild( $c_cantidad );
          $c_cantidad->appendChild( $dom->createTextNode( $data['Concepto'][$i]['cantidad'] ) );
        }

        if ( isset( $data['Concepto'][$i]['unidad'] ) ) {
          $c_unidad[$i] = $dom->createAttribute( 'unidad' );
          $c_{$i}->appendChild( $c_unidad[$i] );
          $c_unidad[$i]->appendChild( $dom->createTextNode( $data['Concepto'][$i]['unidad'] ) );
        }

        if ( isset( $data['Concepto'][$i]['noIdentificacion'] ) ) {
          $c_noIdentificacion[$i] = $dom->createAttribute( 'noIdentificacion' );
          $c_{$i}->appendChild( $c_noIdentificacion[$i] );
          $c_noIdentificacion[$i]->appendChild( $dom->createTextNode( $data['Concepto'][$i]['noIdentificacion'] ) );
        }

        if ( isset( $data['Concepto'][$i]['descripcion'] ) ) {
          $c_descripcion = $dom->createAttribute( 'descripcion' );
          $c_{$i}->appendChild( $c_descripcion );
          $c_descripcion->appendChild( $dom->createTextNode( $data['Concepto'][$i]['descripcion'] ) );
        }

        if ( isset( $data['Concepto'][$i]['valorUnitario'] ) ) {
          $c_valorUnitario = $dom->createAttribute( 'valorUnitario' );
          $c_{$i}->appendChild( $c_valorUnitario );
          $c_valorUnitario->appendChild( $dom->createTextNode( $data['Concepto'][$i]['valorUnitario'] ) );
        }

        if ( isset( $data['Concepto'][$i]['importe'] ) ) {
          $c_importe = $dom->createAttribute( 'importe' );
          $c_{$i}->appendChild( $c_importe );
          $c_importe->appendChild( $dom->createTextNode( $data['Concepto'][$i]['importe'] ) );
        }
      }
    }

    // Impuestos
    $im = $dom->createElement( 'Impuestos' );
    $co->appendChild( $im );

    // Retenciones
    if ( isset( $data['Retencion'] ) ) {
      $rs = $dom->createElement( 'Retenciones' );
      $im->appendChild( $rs );

      // Retencion
      $count = count( $data['Retencion'] );
      if ( $count == 1 ) {

        $rt = $dom->createElement( 'Retencion' );
        $rs->appendChild( $rt );

        if ( isset( $data['Retencion'][0]['impuesto'] ) ) {
          $rt_impuesto = $dom->createAttribute( 'impuesto' );
          $rt->appendChild( $rt_impuesto );
          $rt_impuesto->appendChild( $dom->createTextNode( $data['Retencion'][0]['impuesto'] ) );
        }

        if ( isset( $data['Retencion'][0]['importe'] ) ) {
          $rt_importe = $dom->createAttribute( 'importe' );
          $rt->appendChild( $rt_importe );
          $rt_importe->appendChild( $dom->createTextNode( $data['Retencion'][0]['importe'] ) );
        }
      } else {
        for( $i = 0; $i < $count; ++$i ) {

          $rt_{$i} = $dom->createElement( 'Retencion' );
          $rs->appendChild( $rt_{$i} );

          if ( isset( $data['Retencion'][$i]['impuesto'] ) ) {
            $rt_impuesto = $dom->createAttribute( 'impuesto' );
            $rt_{$i}->appendChild( $rt_impuesto );
            $rt_impuesto->appendChild( $dom->createTextNode( $data['Retencion'][$i]['impuesto'] ) );
          }

          if ( isset( $data['Retencion'][$i]['importe'] ) ) {
            $rt_importe = $dom->createAttribute( 'importe' );
            $rt_{$i}->appendChild( $rt_importe );
            $rt_importe->appendChild( $dom->createTextNode( $data['Retencion'][$i]['importe'] ) );
          }
        }
      }
    }

    // Traslados
    if ( isset( $data['Traslado'] ) ) {

      $ts = $dom->createElement( 'Traslados' );
      $im->appendChild( $ts );

      // Traslado
      $count = count( $data['Traslado'] );
      if ( $count == 1 ) {

        $tr = $dom->createElement( 'Traslado' );
        $ts->appendChild( $tr );

        if ( isset( $data['Traslado'][0]['impuesto'] ) ) {
          $ts_impuesto = $dom->createAttribute( 'impuesto' );
          $tr->appendChild( $ts_impuesto );
          $ts_impuesto->appendChild( $dom->createTextNode( $data['Traslado'][0]['impuesto'] ) );
        }

        if ( isset( $data['Traslado'][0]['tasa'] ) ) {
          $ts_tasa = $dom->createAttribute( 'tasa' );
          $tr->appendChild( $ts_tasa );
          $ts_tasa->appendChild( $dom->createTextNode( $data['Traslado'][0]['tasa'] ) );
        }

        if ( isset( $data['Traslado'][0]['importe'] ) ) {
          $ts_importe = $dom->createAttribute( 'importe' );
          $tr->appendChild( $ts_importe );
          $ts_importe->appendChild( $dom->createTextNode( $data['Traslado'][0]['importe'] ) );
        }
      } else {
        for( $i = 0; $i < $count; ++$i ) {

          $tr_{$i} = $dom->createElement( 'Traslado' );
          $ts->appendChild( $tr_{$i} );

          if ( isset( $data['Traslado'][0]['impuesto'] ) ) {
            $ts_impuesto = $dom->createAttribute( 'impuesto' );
            $tr_{$i}->appendChild( $ts_impuesto );
            $ts_impuesto->appendChild( $dom->createTextNode( $data['Traslado'][0]['impuesto'] ) );
          }

          if ( isset( $data['Traslado'][0]['tasa'] ) ) {
            $ts_tasa = $dom->createAttribute( 'tasa' );
            $tr_{$i}->appendChild( $ts_tasa );
            $ts_tasa->appendChild( $dom->createTextNode( $data['Traslado'][0]['tasa'] ) );
          }

          if ( isset( $data['Traslado'][0]['importe'] ) ) {
            $ts_importe = $dom->createAttribute( 'importe' );
            $tr_{$i}->appendChild( $ts_importe );
            $ts_importe->appendChild( $dom->createTextNode( $data['Traslado'][0]['importe'] ) );
          }
        }
      }
    }

	/*$xml->formatOutput = true;
    $el_xml = $xml->saveXML();
    $xml->save('libros.xml');
 
    //Mostramos el XML puro
    echo "<p><b>El XML ha sido creado.... Mostrando en texto plano:</b></p>".
         htmlentities($el_xml)."
<hr>";*/
	
	
    return $dom->saveXML();
  }

  /**
   * Validates and transforma an array of data to a | (pipe) separated string
   *
   * @param array contains the FEA data
   * @return string separated by | (pipe)
   */
  public static function getOriginalString ( array &$data )
  {
    if ( !$data ) {
      return false;
    }

    $string = '||';

    // Comprobante
    $string .= isset( $data['version'] ) ? $data['version'].'|' : '';
    $string .= isset( $data['serie'] ) ? $data['serie'].'|' : '';
    $string .= isset( $data['folio'] ) ? $data['folio'].'|' : '';
    $string .= isset( $data['fecha'] ) ? $data['fecha'].'|' : ''; // 2010-11-24T16:30:00
    $string .= isset( $data['noAprobacion'] ) ? $data['noAprobacion'].'|' : '';
    $string .= isset( $data['anoAprobacion'] ) ? $data['anoAprobacion'].'|' : '';
    $string .= isset( $data['tipoDeComprobante'] ) ? $data['tipoDeComprobante'].'|' : '';
    $string .= isset( $data['formaDePago']  ) ? $data['formaDePago'].'|' : '';
    $string .= isset( $data['condicionesDePago']  ) ? $data['condicionesDePago'].'|' : '';
    $string .= isset( $data['subTotal']  ) ? $data['subTotal'].'|' : '';
    $string .= isset( $data['descuento']  ) ? $data['descuento'].'|' : '';
    $string .= isset( $data['total']  ) ? $data['total'].'|' : '';

    // Emisor
    if ( !isset( $data['Emisor'] ) ) {
      die( 'You must provide the Emisor in your array'."\n" );
    }
    $string .= isset( $data['Emisor']['rfc'] ) ? $data['Emisor']['rfc'].'|' : '';
    $string .= isset( $data['Emisor']['nombre'] ) ? $data['Emisor']['nombre'].'|' : '';

    // DomicilioFiscal
    $string .= isset( $data['DomicilioFiscal']['calle'] ) ? $data['DomicilioFiscal']['calle'].'|' : '';
    $string .= isset( $data['DomicilioFiscal']['noExterior'] ) ? $data['DomicilioFiscal']['noExterior'].'|' : '';
    $string .= isset( $data['DomicilioFiscal']['noInterior'] ) ? $data['DomicilioFiscal']['noInterior'].'|' : '';
    $string .= isset( $data['DomicilioFiscal']['colonia'] ) ? $data['DomicilioFiscal']['colonia'].'|' : '';
    $string .= isset( $data['DomicilioFiscal']['localidad'] ) ? $data['DomicilioFiscal']['localidad'].'|' : '';
    $string .= isset( $data['DomicilioFiscal']['referencia'] ) ? $data['DomicilioFiscal']['referencia'].'|' : '';
    $string .= isset( $data['DomicilioFiscal']['municipio'] ) ? $data['DomicilioFiscal']['municipio'].'|' : '';
    $string .= isset( $data['DomicilioFiscal']['estado'] ) ? $data['DomicilioFiscal']['estado'].'|' : '';
    $string .= isset( $data['DomicilioFiscal']['pais'] ) ? $data['DomicilioFiscal']['pais'].'|' : '';
    $string .= isset( $data['DomicilioFiscal']['codigoPostal'] ) ? $data['DomicilioFiscal']['codigoPostal'].'|' : '';

    // ExpedidoEn
    $string .= isset( $data['ExpedidoEn']['calle'] ) ? $data['ExpedidoEn']['calle'].'|' : '';
    $string .= isset( $data['ExpedidoEn']['noExterior'] ) ? $data['ExpedidoEn']['noExterior'].'|' : '';
    $string .= isset( $data['ExpedidoEn']['noInterior'] ) ? $data['ExpedidoEn']['noInterior'].'|' : '';
    $string .= isset( $data['ExpedidoEn']['colonia'] ) ? $data['ExpedidoEn']['colonia'].'|' : '';
    $string .= isset( $data['ExpedidoEn']['localidad'] ) ? $data['ExpedidoEn']['localidad'].'|' : '';
    $string .= isset( $data['ExpedidoEn']['referencia'] ) ? $data['ExpedidoEn']['referencia'].'|' : '';
    $string .= isset( $data['ExpedidoEn']['municipio'] ) ? $data['ExpedidoEn']['municipio'].'|' : '';
    $string .= isset( $data['ExpedidoEn']['estado'] ) ? $data['ExpedidoEn']['estado'].'|' : '';
    $string .= isset( $data['ExpedidoEn']['pais'] ) ? $data['ExpedidoEn']['pais'].'|' : '';
    $string .= isset( $data['ExpedidoEn']['codigoPostal'] ) ? $data['ExpedidoEn']['codigoPostal'].'|' : '';

    // Receptor
    if ( !isset( $data['Receptor'] ) ) {
      die( 'You must provide the Receptor in your array'."\n" );
    }
    $string .= isset( $data['Receptor']['rfc'] ) ? $data['Receptor']['rfc'].'|' : '';
    $string .= isset( $data['Receptor']['nombre'] ) ? $data['Receptor']['nombre'].'|' : '';

    // Domicilio
    $string .= isset( $data['Domicilio']['calle'] ) ? $data['Domicilio']['calle'].'|' : '';
    $string .= isset( $data['Domicilio']['noExterior'] ) ? $data['Domicilio']['noExterior'].'|' : '';
    $string .= isset( $data['Domicilio']['noInterior'] ) ? $data['Domicilio']['noInterior'].'|' : '';
    $string .= isset( $data['Domicilio']['colonia'] ) ? $data['Domicilio']['colonia'].'|' : '';
    $string .= isset( $data['Domicilio']['localidad'] ) ? $data['Domicilio']['localidad'].'|' : '';
    $string .= isset( $data['Domicilio']['referencia'] ) ? $data['Domicilio']['referencia'].'|' : '';
    $string .= isset( $data['Domicilio']['municipio'] ) ? $data['Domicilio']['municipio'].'|' : '';
    $string .= isset( $data['Domicilio']['estado'] ) ? $data['Domicilio']['estado'].'|' : '';
    $string .= isset( $data['Domicilio']['pais'] ) ? $data['Domicilio']['pais'].'|' : '';
    $string .= isset( $data['Domicilio']['codigoPostal'] ) ? $data['Domicilio']['codigoPostal'].'|' : '';

    // Conceptos
    if ( !isset( $data['Concepto'] ) ) {
      die( 'You must provide at least one Concepto in your array'."\n" );
    }
    $count = count( $data['Concepto'] );
    for( $i = 0; $i < $count; ++$i ) {
      $string .= isset( $data['Concepto'][$i]['cantidad'] ) ? $data['Concepto'][$i]['cantidad'].'|' : '';
      $string .= isset( $data['Concepto'][$i]['unidad'] ) ? $data['Concepto'][$i]['unidad'].'|' : '';
      $string .= isset( $data['Concepto'][$i]['noIdentificacion'] ) ? $data['Concepto'][$i]['noIdentificacion'].'|' : '';
      $string .= isset( $data['Concepto'][$i]['descripcion'] ) ? $data['Concepto'][$i]['descripcion'].'|' : '';
      $string .= isset( $data['Concepto'][$i]['valorUnitario'] ) ? $data['Concepto'][$i]['valorUnitario'].'|' : '';
      $string .= isset( $data['Concepto'][$i]['importe'] ) ? $data['Concepto'][$i]['importe'].'|' : '';
      $string .= isset( $data['Concepto'][$i]['InformacionAduanera']['numero'] ) ? $data['Concepto'][$i]['InformacionAduanera']['numero'].'|' : '';
      $string .= isset( $data['Concepto'][$i]['InformacionAduanera']['fecha'] ) ? $data['Concepto'][$i]['InformacionAduanera']['fecha'].'|' : '';
      $string .= isset( $data['Concepto'][$i]['InformacionAduanera']['aduana'] ) ? $data['Concepto'][$i]['InformacionAduanera']['aduana'].'|' : '';
      $string .= isset( $data['Concepto'][$i]['CuentaPredial']['numero'] ) ? $data['Concepto'][$i]['CuentaPredial']['numero'].'|' : '';
    }
    unset( $count );

    // Retencion
    if ( isset( $data['Retencion'] ) ) {
      $count = count( $data['Retencion'] );
      for( $i = 0; $i < $count; ++$i ) {
        $string .= isset( $data['Retencion'][$i]['impuesto'] ) ? $data['Retencion'][$i]['impuesto'].'|' : '';
        $string .= isset( $data['Retencion'][$i]['importe'] ) ? $data['Retencion'][$i]['importe'].'|' : '';
      }
      unset( $count );
      $string .= isset( $data['Retencion']['totalImpuestosRetenidos'] ) ? $data['Retencion']['totalImpuestosRetenidos'].'|' : '';
    }

    // Traslado
    if ( isset( $data['Traslado'] ) ) {
      $count = count( $data['Traslado'] );
      for( $i = 0; $i < $count; ++$i ) {
        $string .= isset( $data['Traslado'][$i]['impuesto'] ) ? $data['Traslado'][$i]['impuesto'].'|' : '';
        $string .= isset( $data['Traslado'][$i]['tasa'] ) ? $data['Traslado'][$i]['tasa'].'|' : '';
        $string .= isset( $data['Traslado'][$i]['importe'] ) ? $data['Traslado'][$i]['importe'].'|' : '';
      }
      unset( $count );
      $string .= isset( $data['Traslado']['totalImpuestosTraslados'] ) ? $data['Traslado']['totalImpuestosTraslados'].'|' : '';
    }

    return preg_replace( '/(.*)\|$/', '$1', $string )."||";
  }

  /**
   * Returns the private key from DER to PEM format, uses openssl from shell
   *
   * @param string $key_path the path of the private key in DER format
   * @param string $password the private key password
   * @return string the private key in a PEM format
   */
  public static function getPrivateKey ( $key_path, $password )
  {
    $cmd = 'openssl pkcs8 -inform DER -in '.$key_path.' -passin pass:'.$password;
    if ( $result = shell_exec( $cmd ) ) {
      unset( $cmd );

      return $result;
    }

    return false;
  }

  /**
   * Return the certificate from DER to PEM on two formats, uses openssl from shell
   * if to_string is true resutns the certificate in a string as is (multiline)
   * but if set to false returns only the certificate in a one line string.
   *
   * @param string $cer_path the path of the certificate in DER format
   * @param boolean $to_string a flag to set the format required
   * @return string the certificate in PEM format
   */
  public static function getCertificate ( $cer_path, $to_string = true )
  {
    $cmd = 'openssl x509 -inform DER -outform PEM -in '.$cer_path.' -pubkey';
    if ( $result = shell_exec( $cmd ) ) {
      unset( $cmd );

      if ( $to_string ) {

        return $result;
      }

      $split = preg_split( '/\n(-*(BEGIN|END)\sCERTIFICATE-*\n)/', $result );
      unset( $result );

      return preg_replace( '/\n/', '', $split[1] );
    }

    return false;
  }

  /**
   * Signs data with the key and returns it in a base64 string
   *
   * @param string $key string containing the key in PEM format
   * @param string $data data to sign
   * @return string the signed data in base64
   */
  public static function signData ( $key, $data )
  {
    $pkeyid = openssl_get_privatekey( $key );
    if (!empty($pkeyid)){      
    // On 2011 Signing algorythm changes from MD5 to SHA1/SHA256 (Thanks to eDwaRd for the reminder)
    if ( openssl_sign( $data, $cryptedata, $pkeyid,OPENSSL_ALGO_SHA256) ) {

      openssl_free_key( $pkeyid );

      return base64_encode( $cryptedata );
    }
  }else{
    return '0';
  }
}

  /**
   * Returns the serial number from a DER certificate, uses openssl from shell
   *
   * @param string $cer_path the certificate path in DER format
   * @return string the serial number of the certificate in ASCII
   */
  public static function getSerialFromCertificate ( $cer_path )
  {
    $cmd = 'openssl x509 -inform DER -outform PEM -in '.$cer_path.' -pubkey | '.
           'openssl x509 -serial -noout';
    if ( $serial = shell_exec( $cmd ) ) {
      unset( $cmd );

      if ( preg_match( "/([0-9]{40})/", $serial, $match ) ) {
        unset( $serial );

        return implode( '', array_map( 'chr', array_map( 'hexdec', str_split( $match[1], 2 ) ) ) );
      }
    }

    return false;
  }
}