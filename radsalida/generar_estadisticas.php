<?php
/**
 * En este frame se van cargado cada una de las funcionalidades del sistema
 *
 * Descripcion Larga
 *
 * @category
 * @package      SGD Orfeo
 * @subpackage   Main
 * @author       Community
 * @author       Skina Technologies SAS (http://www.skinatech.com)
 * @license      GNU/GPL <http://www.gnu.org/licenses/gpl-2.0.html>
 * @link         http://www.orfeolibre.org
 * @version      SVN: $Id$
 * @since
 */

        /*---------------------------------------------------------+
        |                     INCLUDES                             |
        +---------------------------------------------------------*/


        /*---------------------------------------------------------+
        |                    DEFINICIONES                          |
        +---------------------------------------------------------*/


        /*---------------------------------------------------------+
        |                       MAIN                               |
        +---------------------------------------------------------*/


		 session_start();
		 error_reporting(7);
		 $ruta_raiz = "..";
	         if(!$dependencia) include "../rec_session.php";
		 if(!$fecha_busq) $fecha_busq=date("Y-m-d");
		 if(!$fecha_busq2) $fecha_busq2=date("Y-m-d");
?>
<head>
<link rel="stylesheet" href="../estilos_totales.css">
</head>
<BODY>
<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<script language="javascript"><!--
  var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "new_product", "fecha_busq","btnDate1","<?=$fecha_busq?>",scBTNMODE_CUSTOMBLUE);
	var dateAvailable2 = new ctlSpiffyCalendarBox("dateAvailable2", "new_product", "fecha_busq2","btnDate1","<?=$fecha_busq2?>",scBTNMODE_CUSTOMBLUE);
//--></script><P>
<p><CENTER><b><span class="etexto">GENERACION LISTADOS DE DOCUMENTOS DEVUELTOS POR AGENCIA DE CORREO<p></CENTER>
  <form name="new_product"  method=post  action='generar_estadisticas.php?<?=session_name()."=".session_id()."&krd=$krd&fecha_h=$fechah"?>'>
<center>

<TABLE width="450" class="t_bordeGris">
  <!--DWLayoutTable-->
  <TR>
    <TD width="125" height="21"  class='grisCCCCCC'> Fecha desde<br>
	<?
	  echo "($fecha_busq)";
	?>
	</TD>
    <TD width="225" align="right" valign="top">

        <script language="javascript">
		        dateAvailable.date = "2003-08-05";
			    dateAvailable.writeControl();
			    dateAvailable.dateFormat="yyyy-MM-dd";
    	  </script>
</TD>
  </TR>
  <TR>
    <TD width="125" height="21"  class='grisCCCCCC'> Fecha Hasta<br>
	<?
	  echo "($fecha_busq2)";
	?>
	</TD>
    <TD width="225" align="right" valign="top">
        <script language="javascript">
		        dateAvailable2.date = "2003-08-05";
			    dateAvailable2.writeControl();
			    dateAvailable2.dateFormat="yyyy-MM-dd";
    	  </script>
</TD>
  </TR>
   <tr>
    <td height="26" colspan="2" valign="top" class='grisCCCCCC'> <center>
		<INPUT TYPE=SUBMIT name=generar_informe Value=' Generar Informe ' class=ebuttons2>
		</td>
	</tr>
  </TABLE>
  </center>
</form>
<HR>
<?php
if(!$fecha_busq) $fecha_busq = date("Y-m-d");
if($generar_informe)
{
	error_reporting(7);
	$fecha_ini = "$fecha_busq 00:00:00 ";
	$fecha_fin = "$fecha_busq2 23:59:59 ";
	//include "./oracle_pdf.php";
	$query = "select  a.radi_nume_sal,
	a.sgd_renv_planilla,
	a.sgd_renv_fech,
	a.sgd_renv_dir,
	a.sgd_renv_depto,
	a.sgd_renv_mpio,
	a.sgd_renv_cantidad,
	a.sgd_renv_valor,
	a.sgd_deve_fech,
	a.sgd_renv_nombre,
	d.sgd_fenv_descrip,
	substr(a.radi_nume_sal,5,3) dependencia,
	'-' firma,
	b.sgd_deve_desc,
	c.depe_nomb
	from SGD_RENV_REGENVIO a, sgd_deve_dev_envio  b, dependencia c, SGD_FENV_FRMENVIO d ";
	$fecha_mes = substr($fecha_ini,0,7);
	// Si la variable $generar_listado_existente viene entonces este if genera la planilla existente
	$where_isql = " WHERE a.DEPE_CODI='$dependencia'
	AND a.sgd_deve_fech BETWEEN
	TO_DATE('$fecha_ini','yyyy-mm-dd HH24:MI:ss') AND
	TO_DATE('$fecha_fin','yyyy-mm-dd HH24:MI:ss')
	AND a.sgd_deve_codigo=b.sgd_deve_codigo
	and a.sgd_fenv_codigo=d.sgd_fenv_codigo
	and substr(a.radi_nume_sal,5,3) = c.depe_codi
	and a.sgd_deve_codigo is not null
	";
	// and SGD_FENV_CODIGO = $tipo_envio   Se elimino esta line, a peticion de Usuarios.
	if($tipo_envio=="101" or $tipo_envio=="108" )
	{
	 $where_isql .= " AND a.SGD_RENV_PLANILLA IS NOT NULL
		";
	}
	$order_isql = "  ORDER BY  substr(a.radi_nume_sal,5,3), a.SGD_RENV_FECH DESC,a.SGD_RENV_PLANILLA DESC";
	$query_t = $query . $where_isql . $order_isql ;
	$ruta_raiz = "..";
	error_reporting(7);
	require "$ruta_raiz/class_control/class_control.php";
	$btt = new CONTROL_ORFEO("$ruta_raiz");
	$campos_align = array("L","C","L","L","L","L","L","L","L","L","L","L","L","L","L");
	$campos_tabla = array("sgd_fenv_descrip"  ,"depe_nomb","radi_nume_sal","sgd_renv_nombre","sgd_renv_dir","sgd_renv_mpio","sgd_renv_depto","sgd_renv_fech","sgd_deve_fech","sgd_deve_desc","firma");
	$campos_vista = array ("Forma Envio"      ,"Dependencia","Radicado","Destinatario","Direccion","Municipio","Departamento","Fecha de envio","Fecha Dev"         ,"Motivo Devolucion","Recibido");
        $campos_width = array (80           ,110          ,80        ,160           ,120        ,70         ,70           ,80            ,80                    ,150                ,120);	
	$btt->campos_align = $campos_align;
	$btt->campos_tabla = $campos_tabla;
	$btt->campos_vista = $campos_vista;
	$btt->campos_width = $campos_width;
	?>
	</CENTER>
	<span class="etextomenu">
	</CENTER>
	<b>Listado de documentos Devueltos</b><br>
	Fecha Inicial <?=$fecha_ini ?> <br>
	Fecha Final   <?=$fecha_fin ?> <br>
	Fecha Generado <? echo date("Ymd - H:i:s"); ?>
	<?
	$btt->tabla_sql($query_t);
	error_reporting(7);
	$html= $btt->tabla_html;
	define(FPDF_FONTPATH,'../fpdf/font/');
	require("$ruta_raiz/fpdf/html_table.php");
	error_reporting(7);
	$pdf = new PDF("L","mm","A4");
	$pdf->AddPage();
	$pdf->SetFont('Arial','',7);
	$encabezado = "<table border=1>
			<tr>
			<td width=1120 height=30>SUPERINTENDENCIA DE SERVICIOS PUBLICOS DOMICILIARIOS</td>
			</tr>
			<tr>
			<td width=1120 height=30>REPORTE DE DEVOLUCION DE DOCUMENTOS ENTRE $fecha_ini y $fecha_fin </td>
			</tr>
			</table>";
	$fin = "<table border=1 bgcolor='#FFFFFF'>
			<tr>
			<td width=1120 height=60 bgcolor='#CCCCCC'>FUNCIONARIO CORRESPONDENCIA</td>
			</tr>
			<tr>
			<td width=1120 height=60></td>
			</tr>
		</table>";
	$pdf->WriteHTML($encabezado . $html . $fin);
	$arpdf_tmp = "../bodega/pdfs/planillas/dev/$dependencia_$krd_". date("Ymd_hms") . "_dev.pdf";
	$pdf->Output($arpdf_tmp);
	echo "<a href='$arpdf_tmp' target='".date("dmYh").time("his")."'>Abrir Archivo Pdf</a>";
}
?>
