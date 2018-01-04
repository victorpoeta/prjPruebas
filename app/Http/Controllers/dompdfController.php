<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;

class dompdfController extends Controller
{
    //
    public function cartaGuiaInt__() {

    	echo 'carta_guiaint';

		// instantiate and use the dompdf class
		$dompdf = new Dompdf();

		$html = "<!DOCTYPE html>
				 <html>
					<head>
						<style type='text/css'>
							body {
								background-color:ghostwhite;
								width:100%;
							}
							table {
								position: relative;
								background-color:lightgray;
								color:darkblue;
								border: 1px solid gray;
								width: 80%;
							}
							.marco { 
								margin-left: 10%;
								width: 80%;
								background-color: lightgray;
							}
							.footer {
								position: absolute;
							 	right: 0;
							 	bottom: 0;
							 	left: 0;
							 	padding: 10px;
							 	background-color: gray;
							 	text-align: center;
							}
						</style>
					</head>
					<body>
						<div id='header'>
							<img src='http://desarrollo3.grupozoom.com/faaszoom/public/img/logozoom.png' alt='' />
						</div>
						<div align='center'>
							<h4>Carta Guía Internacional</h4>
							<table align='center'>
								<tr>
									<td style='background-color:gray;'>N° Guía</td>
									<td style='background-color:gray;'>Cliente</td>
									<td style='background-color:gray;'>Dirección</td>
								</tr>
								<tr>
									<td> " . @$_REQUEST['nroguia'] . " </td>
									<td>Victor Poeta</td>
									<td>Caracas</td>
								</tr>
							</table>
						</div>
						<div class='footer'>
							Footer
						</div>
					</body>
				</html>";

		//return $html;

		//$options = new Options();
		//$options->set('defaultFont', 'Courier');
		//$options->output('isRemoteEnabled', true);

		$dompdf->set_option('defaultFont', 'Courier');		
		$dompdf->set_option('isRemoteEnabled', true);
		
		$dompdf->loadHtml($html);

		// (Optional) Setup the paper size and orientation
		//$dompdf->setPaper('A4', 'landscape');
		$dompdf->setPaper('A4', 'portrait');

		// Render the HTML as PDF
		$dompdf->render();

		// Output the generated PDF to Browser
		$dompdf->stream('carta_guiaint.pdf');

		
    }


    /** Ejemplo Carta Internacional Guia Electronica Internacional - Pruebas **/
    public function cartaGuiaInt(Request $request) {

		//require (dirname(dirname(dirname(__FILE__))).'/dompdf/dompdf_config.inc.php');

		//print $_SESSION['docfactura']."--";
		//print $_SESSION['docCertificado']."--";
		//print $_SESSION['docAntigrogas']."--";

		$codguia=$request->get('codguia');
		//print "--".$codguia."---";

		//$infodoc= $controlador->facturacom->selectAllWhere("codguia='".$codguia."'"); 

		//Informacion general para las cartas
		/*$docfactura=$infodoc->fields['impfactura'];
		$docCertificado=$infodoc->fields['impcertificado'];
		$docAntigrogas=$infodoc->fields['impantidrigas'];
		$nacionalidad=strtoupper($infodoc->fields['nacionalidad']);
		$cedula=$infodoc->fields['cedula'];
		$razon=$infodoc->fields['razon'];*/
		$docfactura='t';
		$docCertificado='t';
		$docAntigrogas='t';

		$nacionalidad='Venezolano';
		$cedula='16952402';
		$razon='RAZON';

		$docinf['cantidad'] = '1';
		$docinf['descripcion'] = 'DESCRIPCION: OTROS';
		$docinf['valorunitbs'] = '1';
		$docinf['valortotbs'] = 10000.00;
		$docinf['valortotal'] = 10000;
		$docinf['razon'] = 'OTHERS';
		$docinf['dolar'] = '704.32';

		$fechanac = '24/02/1986';

		//$data = $controlador->guia->selectAllWhere("codguia='".$codguia."'"); 

		//$estado= $controlador->ciudad->getOne("codestado","codciudad='".$data->fields['codciudadoriope']."'"); 
		//$codpais= $controlador->estado->getOne("codpais","codestado='".$estado."'"); 
		//$paisori=$controlador->pais->getOne("nombre","codpais='".$codpais."'"); 
		$estado = '';
		$codpais= '124';
		$paisori = 'Venezuela';
		$paisdes="ITALIA";

		$data['contactorem'] = 'VICTOR G. POETA';
		$data['direccionrem'] = 'DIRECCION REMITENTE';
		$data['telefonorem'] = '0212-5552200 / 0212-5550001';
		$zip = '123852';
		$data['destinatario'] = 'JUAN PEREZ';
		$data['direcciondes'] = 'DIRECCION DESTINO';
		$data['contactodes'] = 'CONTACTO DESTINATARIO';
		$data['telefonodes'] = '00393332228811';
		$data['ciudaddesint'] = 'ORTONA';

		//Para pasar la pagina
		$pasarpag="<div style=page-break-before:always;>&nbsp;</div>";

		//PARA SABER SI PASO LA PAGINA O NO
		if (($docfactura=='t') && ($docCertificado=='t')&& ($docAntigrogas=='t'))
		{
			$pagefactura='si';
			$pageAntidrogas='si';
			$pagecertificado='no';
		}
		else if ((($docfactura=='t') && (@$docCertificado=='f')&& (@$docAntigrogas=='f')) || (($docfactura=='f') && (@$docCertificado=='t')&& (@$docAntigrogas=='f')) || (($docfactura=='f') && (@$docCertificado=='f')&& (@$docAntigrogas=='t')))
		{
			$pagefactura='no';
			$pageAntidrogas='no';
			$pagecertificado='no';
		}
		else if (($docfactura=='t') && (@$docCertificado=='t')&& (@$docAntigrogas=='f'))
		{
			$pagefactura='si';
			$pageAntidrogas='no';
			$pagecertificado='no';
		}
		else if (($docfactura=='f') && (@$docCertificado=='t')&& (@$docAntigrogas=='t'))
		{
			$pagefactura='no';
			$pageAntidrogas='si';
			$pagecertificado='no';
		}
		else
		{
			$pagefactura='no';
			$pageAntidrogas='no';
			$pagecertificado='no';
		}

		if ($docfactura=='t' && $docCertificado=='t' && $docAntigrogas=='t') {
			$totalPag = 3;
		}

		$logozoom = '<img src="http://desarrollo3.grupozoom.com/proveedores/frontend/plantilla/imagenes/logonew1.png" border=0>'; // Nuevo 

		//$style='http://10.0.10.13/proveedores/frontend/plantilla/css/cascading.css';
		$style='../plantilla/css/cascading.css';
		//            <link rel="stylesheet" href="'.$style.'" type="text/css" /> 

		$html=' 
		        <!doctype html> 
		        <html> 
		        <head>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
					<style>
					
					body { /*font-family: DejaVu Sans;*/ }
					

					.normal2			  
					{		
						COLOR: #343434;
						FONT-FAMILY: Arial, Helvetica, sans-serif;
						FONT-SIZE: 12px; /* Modificado */
						padding: 0 0 0 0px;
						margin: 0px 0px 0px 0px;
						text-align: left;
						letter-spacing: 0;
						line-height: 1.1em;
						word-spacing: normal;
					}


					.print_zoom_nom
					{
						font-family: Arial;
						font-size: 12px;
						font-weight: bold;
						padding: 0 0 0 0px;
						margin: 0px 0px 0px 0px;
						text-align: left;
						letter-spacing: 0;
						width: 270px;
						height: 12px;
						word-spacing: normal;
					}


					.print_zoom_txt		   /*DIRECCION DE ZOOM*/
					{
						font-family: Arial;
						font-size: 8px;
						padding: 0 0 0 0px;
						font-weight:lighter;
						margin: 0px 0px 0px 0px;
						text-align: left;
						letter-spacing: 0;
						width: 270px;
						height: 10px;
						word-spacing: normal;
					}

					.nro_pagina {
						position:absolute;bottom:0;font-size:11px;
					}

					</style>
		        </head> 
		        <body>'; 

		$logozoom='<img src="http://desarrollo3.grupozoom.com/proveedores/frontend/plantilla/imagenes/logonew1.png" border=0>';

		if ($docfactura=='t'){

		  $html.='
		  <table class="tabla"  id="tabla" border="0" width="100%"> <!-- Modificado -->
			<tr class="normal2">
				<td>
					'.$logozoom.'
				</td>
				<td>
					<div class="print_zoom_nom"><em>ZOOM INTERNATIONAL SERVICES, C.A</em></div>
					<div class="print_zoom_txt">CALLE 7, EDIF.MERANO, LA URBINA, CARACAS. TLFS: 0800<br> SOS - ZOOM 767-9666 FAX: (0212) 242.33.82  www.zoomenvios.com  <br>  RIF.J-00102174-4 HAB.POSTAL 1010   EOHIC 003</div>
					<br> <!-- Modificado -->
				</td>
				<td>
					<table border=0 width="100%"> <!-- Modificado -->
					<tr   class="normal2">
						<td align="center">
							<b>Fecha: '.Date('d/m/Y').'</b>
						</td>
					</tr>
					<tr   class="normal2">
						<td align="center">
							No. '.$codguia.'
						</td>
					</tr>
					</table>
				</td>
			</tr>';
			$html.='<tr class="normal2" >
				<td colspan=3 ><br><br>
					<table border=1 width="100%">'; // <!-- Modificado -->
					$html.='<tr>';
						$html.='<td valign="top">
							<table border=0 class="tabla" id="tabla" width="100%"  > <!-- Modificado -->
								<tr >
									<td  valign="top">
										<div class="print_carta1"><br><br>
											<center><b>Exportador / Shipper</b></center> <!-- Modificado -->
											<br><br><br>
											<b>Nombre / Name:</b><br>
											'.$data['contactorem'].'<br><br>
											<b>Direcci&oacute;n / Address:</b><br>
											'.$data['direccionrem'].'<br><br>
											<b>Persona Contacto / Contact Name:</b><br>
											'.$data['contactorem'].'<br><br>
											<b>Tel&eacute;fono / Phone:</b><br>
											'.$data['telefonorem'].'<br><br>
										</div>
									</td>
								</tr>
							</table>
						</td>';
						$zip=(@$zip)?$zip:'';
						$html.='<td valign="top">
							<table border=0 class="tabla"  id="tabla" width="100%" > <!-- Modificado -->
								<tr >
									<td  valign="top">
										<div class="print_carta1"><br><br>
										<center><b>Consignatario / Consignee</b></center> <!-- Modificado -->
										<br><br><br>
										<b>Nombre / Name:</b><br>
										'.$data['destinatario'].'<br><br>
										<b>Direcci&oacute;n / Address / Zip Code:</b><br>
										'.$data['direcciondes'].' ZIP CODE: '.$zip.'<br><br>
										<b>Persona Contacto / Contact Name:</b><br>
										'.$data['contactodes'].'<br><br>
										<b>Tel&eacute;fono / Phone:</b><br>
										'.$data['telefonodes'].'<br><br>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>';


					$html.='<tr>
						<td colspan=2>
							<div class="print_subtitulo_carta1" align="center">DATOS DEL CONTENIDO DEL ENV&Iacute;O</div> </td>
					</tr>';



					$html.='<tr>
						<td colspan=2>
							<table width=100%>
								<tr>
									<td>Cantidad /<br> Quantity</td>
									<td>Descripci&oacute;n / <br>Description</td>
									<td>*Valor Unitario<br>/ Unit Value<br>(Bs)</td>
									<td>*Valor<br>Total/Total<br>Value Bs.F</td>
									<td>*Valor Total /<br>Total Value ($)</td>
								</tr>';
								$totalgeneralbs=0;
								$totalgeneraldolares=0;
								//foreach($infodoc as $docinf) {
									//print "<pre>";
									//print_r($docinf);
									$totalgeneralbs= $totalgeneralbs + $docinf['valortotbs'];
									$totalgeneraldolares=$totalgeneraldolares+ $docinf['valortotal'];
									$html.='<tr>
										<td>'.$docinf['cantidad'].'</td>
										<td>'.$docinf['descripcion'].'</td>
										<td>'.$docinf['valorunitbs'].'</td>
										<td>'.$docinf['valortotbs'].'</td>
										<td>'.$docinf['valortotal'].'</td>
									</tr>';
								//}
								
							$html.='</table>
						</td>
					</tr>';

					$html.='<tr>
						<td colspan=2>
							<table width=100%>
							<tr>
								<td colspan=2>&nbsp;</td>
								<td>TOTALES /<br>TOTALES:</td>
								<td>&nbsp;</td>
								<td>Bs. '.$totalgeneralbs.'</td>
								<td>US$ '.$totalgeneraldolares.'</td>
							</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan=2>
							<div class="print_subtitulo_carta1" align="center" bgcolor="#cccccc" >RAZ&Oacute;N DE LA EXPORTACI&Oacute;N / REASON FOR EXPORT</div>
							<div class="print_subtitulo_carta1" align="center" bgcolor="#cccccc" >'.strtoupper($docinf['razon']).'</div> 
						</td>
					</tr>';



					$html.='<tr>
						<td colspan=2>
							Por medio del presente, declaro que tengo conocimiento de que la informaci&oacute;n suministrada en este documento es verdadera y correcta, y la mercanc&iacute;a descrita en &eacute;ste es originaria de: '.$paisori.'
							<br><br>
							I declare that the information given on this declaration is true and correct to the best of my knowledge and that themerchandise described above was originated in: '.$paisori.'
							<br><br>
							Firma del Exportador / Shipper s Signature: ________________________________<br>
							* Equivalente a Bs.F '.$docinf['dolar'].', tasa de cambio oficial para US$ en Venezuela.<br><br>
							</td>
					</tr>';

					$html.='</table>
				</td>
			</tr>';
			$html.='</table> <div class="nro_pagina">Pag 1</div>'; // Modificado

			if ($pagefactura=='si'){
			  $html.= $pasarpag;
			}
		}


		if (@$docAntigrogas=='t'){

		//<img src="plantilla/imagenes/encabezascartaint.JPG" border=0 width="740" >
		$html.='<br>
			<table border=0 class="tabla"  id="tabla" width="100%" > <!-- Modificado -->
				<tr >
					<td colspan=3>
						<img src="http://desarrollo3.grupozoom.com/proveedores/frontend/plantilla/imagenes/encabezascartaint.JPG" width="680px;" height="60px;" > <!-- Modificado -->
					</td>
				</tr>
				<tr>
					<td colspan=3>
						<div class="normal2" class_modif="print_carta2" style="text-align:justify;"><br><br> <!-- Modificado -->
							<b>Yo, '.$data['contactorem'].'</b>, Titular de la C&eacute;dula de Identidad N&ordm;  <b>'.$cedula.'</b>, manifiesto que la
							encomienda, la cual destino enviar a trav&eacute;s de la Empresa Zoom International Services C.A., bajo el N&uacute;mero de Gu&iacute;a N&ordm;  '.$codguia.' &nbsp;,  declaro bajo Fe de Juramento que no se transporta ning&uacute;n tipo de sustancia psicotr&oacute;pica o estupefacientes se&ntilde;aladas en la Ley Org&aacute;nica de Drogas</b>,  asumiendo toda
							responsabilidad del contenido de estos efectos, objetos, documentos u otro tipo de productos.
							<br><br>
							Seguidamente procedo a completar el siguiente formulario, con la finalidad de identificarme plenamente ante las autoridades venezolanas y establecer mi
							ubicaci&oacute;n.<br><br>
						</div> 
					</td>
				</tr>';

		$html.='<tr   class="normal2">
					<td colspan=3 >
						<table border=3 class="tabla1"  id="tabla" width="100%" bgcolor="#cccccc" > <!-- Modificado -->
							<tr >
								<td colspan=3>
									<div class="print_subtitulo_carta1" align="center" bgcolor="#cccccc" >FORMATO DEL COMANDO ANTIDROGAS</div> 
								</td>
							</tr>
						</table>
					</td>
				</tr>';



		$html.='<tr   class="normal2">
					<td colspan=3 >
						<table border=1 class="tabla1"  id="tabla" width="100%" > <!-- Modificado -->
							<tr>
								<td>&nbsp;NOMBRES Y APELLIDOS:</td>
								<td colspan=2>&nbsp;'.$data['contactorem'].'</td>
							</tr>
							<tr>
								<td>&nbsp;CEDULA DE IDENTIDAD:</td>
								<td colspan=2>&nbsp;'.$cedula.'</td>
							</tr>
							<tr>
								<td>&nbsp;FECHA DE NACIMIENTO:</td>
								<td colspan=2>&nbsp;'.$fechanac.'</td> 
							</tr>
							<tr>
								<td>&nbsp;DIRECCION DE UBICACION<br>&nbsp;EN VENEZUELA:</td>
								<td colspan=2>&nbsp;'.htmlentities($data['direccionrem']).'</td>
							</tr>
							<tr>
								<td>&nbsp;TELEFONOS:</td>
								<td colspan=2>&nbsp;'.$data['telefonorem'].'</td>
							</tr>
							<tr>
								<td>&nbsp;DESTINO Y DIRECCION <br>&nbsp;DEL ENVIO:</td>
								<td colspan=2>&nbsp;'.$data['direcciondes'].', CIUDAD:'.$data['ciudaddesint'].', '.$paisdes.'</td>
							</tr>
							<tr>
								<td>&nbsp;PERSONA RECEPTORA<br>&nbsp;DE LA ENCOMIENDA:</td>
								<td colspan=2>&nbsp;'.$data['destinatario'].'</td>
							</tr>
							<tr>
								<td>
									&nbsp;HUELLAS DACTILARES:
								</td>
								<td><center>HUELLA DACTILAR</center> <br><br><br><br><br><br><br><br><center>PULGAR MANO DERECHA</center>
								</td>
								<td><center>HUELLA DACTILAR</center><br><br><br><br><br><br><br><br><center>INDICE MANO DERECHA</center>
								</td>
								</td>
							</tr>
						</table>
					</td>
				</tr>';
			$html.='</table> <div class="nro_pagina">Pag 2</div>'; // Modificado

			if ($pageAntidrogas=='si'){
			  $html.= $pasarpag;
			}

		}


		if (@$docCertificado=='t'){

		//<img src="plantilla/imagenes/logonew1.png" border=0>
		$html.='<br><br>
			<table border=0 class="tabla1"  id="tabla">'; // <!-- Modificado -->
			$html.='<tr   class="normal2">';
			$html.='<td>
						' .$logozoom .' <!-- Modificado -->
					</td>
					<td>
						<div class="print_zoom_nom"><em>ZOOM INTERNATIONAL SERVICES, C.A</em></div>
						<div class="print_zoom_txt">CALLE 7, EDIF.MERANO, LA URBINA, CARACAS. TLFS: 0800<br> SOS - ZOOM 767-9666 FAX: (0212) 242.33.82  www.zoomenvios.com  <br>  RIF.J-00102174-4 HAB.POSTAL 1010   EOHIC 003</div>
					</td>';
					/*$html3333='<td>
						<table border=0>
						<tr   class="normal2">
							<td align="center">
								<b>Fecha: '.date('d/m/Y').'</b>
							</td>
						</tr>
						</table>
					</td>';*/
			$html.='</tr>';
			$html.='<tr   class="normal2">
					<td colspan=3>
						<br><br><br>
						<div class="print_subtitulo_carta1" align="center">Requisito de Exportaci&oacute;n de Documento / Mercanc&iacute;a</div> 
						<br><br>
						<div class="print_subtitulo_carta1" align="center">Certificado de Seguridad del Remitente</div><br>
						<div class="print_subtitulo_carta1" align="center">Shipper s Security Endorsement</div> 
						<br><br><br><br>

						<div class="print_carta1" style="text-align:justify;"> <!-- Modificado -->
							<b>REMITENTE: '.$data['contactorem'].'</b>, de nacionalidad <b>'.$nacionalidad.'</b>, y portador de la C&eacute;dula de Identidad / Pasaporte N&ordm; <b>'.$cedula.'</b>,
							declaro BAJO FE DE JURAMETO, que en el env&iacute;o amparado bajo la gu&iacute;a a&eacute;rea N&ordm;  <b>'.$codguia.'</b>  con destino a
							<b>'.$paisdes.'</b>, no transporta ning&uacute;n tipo de sustancias psicotr&oacute;picas, documentos de valores de tr&aacute;nsito prohibido,
							explosivos, mecanismos destructivos o material peligroso; asumiento todo el rigor y responsabilidad que pueda
							derivarse de la tramitaci&oacute;n o agenciamiento de la mercanc&iacute;a, bienes u/o &uacute;tiles contenidos en este embarque.
							Consiento la revisi&oacute;n de este env&iacute;o, avalo este certificado con mi firma original y presento los documentos que me
							identifican. Este certificado ser&aacute; mantenido en archivo por parte de la empresa transportista, hasta que se efect&uacute;e
							la entrega en destino.
							<br><br><br>
							<b>SHIPPER: '.$data['contactorem'].'</b>, nationality <b>'.$nacionalidad.'</b>, Identification Card / Passport N&ordm; <b>'.$cedula.'</b>, declare UNDER SWERING,
							that the shipment with the air-guide N&ordm; <b>'.$codguia.'</b>  to (city/country) <b>'.$paisdes.'</b> does not contain any kind of drugs,
							documents, unauthorized values, explosives, destructive devices or hazardous material; assuming any
							responsibility and consequences that this shipment will contain. I consent the revision of this shipment and
							guarantee this certification with my original signature along with other shipping documents. This document will be
							retained on file until the shipment is delivered.
							<br><br><br>
							<div style="text-align:right;"><b>CONTRATO DE FLETAMIENTO N&ordm; '.$codguia.'</b></div>
							<br><br><br>
							<b>FECHA / DATE: '.Date('d/m/Y').'</b>
							<br><br><br>
							<b>FIRMA DEL REMITENTE / SHIPPER S SIGNATURE: ____________________________________</b>
							<br><br><br>
							Cumpliendo con regulaciones impuestas por la Administraci&oacute;n Federal de Aviaci&oacute;n (Federal Aviation
							Administration, FAA) y las autoridades de las aduanas de USA y Venezuela, para todo material a transportarse en
							cualquier aeronave que ingrese o transite a trav&eacute;s de los territorios de ambos pa&iacute;ses.
							<br><br><br>
						</div> 
					</td>
				</tr>';
			$html.='</table> <div class="nro_pagina">Pag 3</div>'; // Modificado

			if ($pagecertificado=='si'){
			  $html.= $pasarpag;
			}
		}
      
		$html.='</body> 
		        </html>'; 

		//print $html; exit();

		$dompdf = new Dompdf();
		$dompdf->loadHtml(utf8_decode($html));

		$dompdf->set_paper('letter','portrait');
		//$dompdf->set_paper("letter", "landscape");
		$dompdf->set_option('isRemoteEnabled', true);
		$dompdf->set_option('isPhpEnabled', true);

		/*<script type="text/php">
		  if (isset($pdf))
		    {
		      $font = Font_Metrics::get_font("Arial", "bold");
		      $pdf->page_text(765, 550, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
		    }
		</script>*/

		//dd($dompdf);

		$dompdf->render();
		
		//$dompdf->stream("CartasInternacionales_".$codguia.".pdf");
		
		header('Content-type: application/pdf');
		echo $dompdf->output(1);

    }

}
