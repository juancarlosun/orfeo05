<?php
/** CONSULTA WEB A CIUDADANOS
  *@autor JAIRO LOSADA - SUPERINTENDENCIA DE SERVICIOS PUBLICOS DOMICILIATIOS - COLOMBIA
  *@version 3.2
  *@fecha 21/10/2005
  *@licencia GPL
  */

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;


$ruta_raiz = "..";
$verradicado = $idRadicado;
$dependencia = 990;
$codusuario = 300;
$verrad = $idRadicado;
$ent = substr($idRadicado,-1);
error_reporting(7);
$iTpRad = 10;
include "$ruta_raiz/ver_datosrad.php";
include "$ruta_raiz/config.php";
include "sessionWeb.php";
//$db->conn->debug=true;

/** encriptacion de pagina para inactivar en una Hora
  */
  
$llave = date("YmdH") . "$verrad";
$password =md5($llave);
$fechah=date("YmdHis");
// Finaliza Historicos
?>
<html lang="es">
<head>
<title>SISTEMA DE GESTION DOCUMENTAL - CIUDADANOS</title>
<meta 
<meta http-equiv="Content-Type" charset="UTF-8" content="text/html;">
<!-- CSS -->
<link rel="stylesheet" href="css/structure2.css" type="text/css" />
<link rel="stylesheet" href="css/form.css" type="text/css" />
<style type="text/css">
<!--
@import url("web.css");
-->
</style><script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function Start(URL, WIDTH, HEIGHT) {
windowprops = "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=1020,height=500";
preview = window.open(URL , "preview", windowprops);
}
//-->
</script>
</head>
<body bgcolor="#ffffff">
<form name=form_cerrar action=index_web.php?<?=session_name()."=".session_id()."&fechah=$fechah&krd=$krd"?> method=post>
</form>
<?
	include "cabez.php";

?>
			<h2><?=$entidad_largo?></h2>
<div class="datagrid">

<table width="90%" summary="Esta tabla contiene la información general sobre el radicado consultado
			    y el estado actual del tramite">
<caption><h4>INFORMACION DEL DOCUMENTO CON NUMERO DE RADICADO <?=$verradicado?>   <? $tipo1=strtoupper(substr($radi_path,-3));
           if ($tipo1=="TIF" or $tipo1=="PDF" or $tipo1=="CSV" or $tipo1=="JPG"){
	      ?>
                <a href='<?=$ruta_raiz?>/bodega/<?=$radi_path?>' title='Abrir Imagén del documento consultado' 
		   aria-label='Abrir Imagén del documento consultado'>(Ver Imagen del documento)</a>
              <? } ?></h4></caption>

<thead>
<tr>
<th width="11%">TIPO DOCUMENTO</th>
<th width="11%">FECHA RADICADO </th>
<th width="11%">ASUNTO </th>
<th width="11%"><?=$tip3Nombre[1][$ent]?></th>
<th width="11%">DIRECCI&Oacute;N </th>
<th width="11%">MUN/DPTO</th>
<th width="11%">REF/OFICIO/CUENTA INT </th>
<th width="11%">ESTADO ACTUAL </th>
</tr>
</thead>
<tbody>
<?


// MODIFICADO POR SKINATECH SEPT 21/09
//	$isql = "select SGD_TPR_DESCRIP FROM SGD_TPR_TPDCUMENTO where sgd_tpr_codigo='$tdoc'";
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$isql = "select SGD_TPR_DESCRIP FROM SGD_TPR_TPDCUMENTO T, RADICADO R where R.radi_nume_radi='$verradicado' and R.tdoc_codi=t.sgd_tpr_codigo";
$rs=$db->query($isql);
	if  (!$rs->EOF){
		$tpdoc_nombre = $rs->fields["SGD_TPR_DESCRIP"];
	}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

/*
include "nuevaConexion.php";

$conexion = new nuevaConexion();
$conexion->conectar();
if($conexion->conectar()==true){
	echo "conexion exitosa";
	echo "<br>";
	$result=$conexion->consultar("SELECT * FROM radicado where radi_nume_radi = $verradicado");
	echo "<br>";
	//$line = pg_fetch_array($result, null, PGSQL_ASSOC)) 
		print_r($line);
		echo "<br>";
	}else{
		echo "no se pudo conectar";
	}

*/
?>

<td><?=$tpdoc_nombre ?></td>
<td><?=$radi_fech_radi ?></td>
<td><?=$ra_asun ?></td>
<td><?=$nombret_us1 ?> </td>
<td><?=$direccion_us1 ?></td>
<td><?=$dpto_nombre_us1."/".$muni_nombre_us1 ?></td>
<td><?=$cuentai?>-</td>
	<?
	if(!$flujo_nombre and $radi_depe_actu=='999') $flujo_nombre = "Finalizado"; 
	else {
	 if(!$flujo_nombre) $flujo_nombre = "En Tramite";
	}
	?>
<td> 
		<?
/*	MODIFICADO POR SKINATECH, OCTUBRE 6/09
		$isql = "select a.SGD_FLD_CODIGO,
		 a.SGD_FLD_DESC
		 , b.SGD_TPR_TERMINO
		 ,a.SGD_FLD_IMAGEN
		 ,a.SGD_FLD_GRUPOWEB
		 FROM SGD_FLD_FLUJODOC a, SGD_TPR_TPDCUMENTO B
		 where
		 a.sgd_tpr_codigo=b.SGD_TPR_CODIGO
		 AND a.sgd_tpr_codigo='$tdoc'
		 AND a.sgd_fld_codigo=a.sgd_fld_grupoweb
		 order by a.SGD_FLD_CODIGO";*/
//	 $db->conn->debug=true;
	$rs=$db->query($isql);
	$iFld = 0;
	if(!$rs->EOF)
		{
		$flujo = $rs->fields["SGD_TPR_TERMINO"];
		//$flujo_nombre = $rs->fields["SGD_FLD_DESC"];			
		}
		echo $flujo_nombre;
	
	?> </td>
          </tr>
</tbody>
</table> 
</div>

<div class="datagrid">
<table width="90%" summary="Esta tabla contiene el detalle de los documentos que han sido anexados al 
			    radicado consultado, si alguno esta digitalizado puede ver la imagen del mismo.">
<!-- MODIFICADO POR SKINATECH, OCTUBRE 5/09, para quitarle el cuadro con las imagenes del estado del documento, ya que no estaban permitiendo ver la informacion de los documentos anexos -->
<!--	<tr>
    <td colspan="2"><table width="99%"  border="0" cellpadding="0" cellspacing="0" class="borde_tab">
      <tr>
        <td>
	<?
/*	include "$ruta_raiz/flujo/flujoGrafico.php";
	echo "PRUEBA";
	$isql = "select RADI_NUME_SALIDA from anexos a where a.anex_radi_nume='$verrad'";
	$rs = $db->query($isql);
	$radicado_d= "";
	while(!$rs->EOF)
	{
		$valor = $rs->fields["RADI_NUME_SALIDA"];
		if(trim($valor))
			{
				$radicado_d .= "'".trim($valor) ."', ";
			}
		$rs->MoveNext();   		  
	}  
	$radicado_d .= "$verrad";
	// Finaliza Historicos
	?>
	</td>
     </tr>

<?
$isql = "select RADI_NUME_SALIDA from anexos a where a.anex_radi_nume='$verrad'";
$rs = $db->query($isql);
$radicado_d= "";
while(!$rs->EOF)
{
	$valor = $rs->fields["RADI_NUME_SALIDA"];
	if(trim($valor))
	{
		$radicado_d .= "'".trim($valor) ."', ";
	}
	$rs->MoveNext();   		  
}  
$radicado_d .= "$verrad";
*/
?>
</table>-->

<?

// by skinatech, octubre 6/09, se realizó el cambio de la variable en el query
/*$isql = "select 
		r.RA_ASUN,
		r.RADI_FECH_RADI,
		r.RADI_NUME_RADI,
		r.RADI_PATH
		from radicado r
		where
		r.radi_nume_deri in($verradicado)
		AND r.radi_tipo_deri = 0
         	";

*/

$isql= "select  *  from  anexos  where  anex_radi_nume='". $verradicado."'";

//$db->conn->debug = true;
$rss= $db->query($isql);
$i=1;
if(!$rss->EOF)
{
?>
<caption><h4>DOCUMENTOS ANEXOS DE LA SOLICITUD</h4></caption>
<thead>
<tr>
<th width="15%">TIPO</th>
<th width="15%">RADICADO</th>
<th width="15%">FECHA</th>
<th width="25%">ASUNTO</th>
<th width="15%">DIGITALIZACI&Oacute;N</th>
</tr>
</thead>
<tbody>
  <?
while(!$rss->EOF)
{
	$radEnviado = $rss->fields["RADI_NUME_SALIDA"];
        $anex_codigo = $rss->fields["ANEX_CODIGO"];
     //   if ($radi_path=="")
       //      {
           $ano=substr($anex_codigo, 0, 4);
           $depe=substr($anex_codigo, 4, 3);
           $radi_path="/".$ano ."/".$depe ."/docs/";
         //    }
        $long=strlen($anex_codigo);
        $anex_salida = $rss->fields["RADI_NUME_SALIDA"];
             if($anex_salida!=NULL) $anex_codigo=$anex_salida;
        

        if ($long>14) 
           { $radEnviado=substr($anex_codigo, 0, 14);
             }

       switch(substr($radEnviado,-1))
	{
	case 1;
		$tipoDocumentoAnexo = "Salida";
		break;
	case 2;
		$tipoDocumentoAnexo = "Entrada";
		break;
	case 3;
		$tipoDocumentoAnexo = "Interno";
		break;
	case 4;
		$tipoDocumentoAnexo = "Factura";
		break;
	case 6;
		$tipoDocumentoAnexo = "Acta";
		break;
	case 7;
		$tipoDocumentoAnexo = "PQR";
		break;
	case 5:
		$tipoDocumentoAnexo = "Resolucion";
	 break;
	}
	$verImagen = "";
	
        $anex = $rss->fields["ANEX_NOMB_ARCHIVO"];
       // $anex_codigo = $rss->fields["ANEX_CODIGO"];
       // $anex_salida = $rss->fields["RADI_NUME_SALIDA"];
       //      if($anex_salida!=NULL) $anex_codigo=$anex_salida;
        $radEnviado = $rss->fields["ANEX_RADI_NUME"];
	$radFecha = $rss->fields["ANEX_RADI_FECH"];
//	$radiPath = trim($rss->fields["RADI_PATH"]);
        $radiPath= $radi_path;
	$ra_asun = $rss->fields["ANEX_DESC"];

        $tipo=strtoupper(substr($anex,-3));
              //  echo $tipo1;
                if ($tipo =="TIF"  or  $tipo=="PDF" or $tipo=="CSV" or $tipo=="JPG")
                    {
                       $ruta = substr($radi_path, 0, 15);
                       $pathImagen=$ruta_raiz ."/bodega/". $ruta . $anex;
                    
	//$pathImagen = $ruta_raiz."/bodega/$radiPath";
	//$pathImagen = str_replace("//","/",$pathImagen);
        //$pathImagen = str_replace("\\","/",$pathImagen);

       
	 $verImagen = "<a href='$pathImagen' Target='ImagenOrfeo_$radEnviado' aria-label='Abrir Imagén de radicado'>Abrir Imag&eacute;n</a>";
	}
	$pathImagen = "";
        
	if($radDev)
	{
		$imgRadDev = "<img src='$ruta_raiz/imagenes/devueltos.gif' alt='Documento Devuelto por empresa de Mensajeria' title='Documento Devuelto por empresa de Mensajeria'>";
	}else
	{
		$imgRadDev = "";
	}
   ?>
	<?
		$i=1;
	?>
	<td>
	<?=$tipoDocumentoAnexo?>
	</td>
	<td>
	<?=$imgRadDev?>
	<?=$anex_codigo?>
	</td>
    <td>
	<?=$rss->fields["ANEX_RADI_FECH"]?>
	</td>
    <td  >
	 <?=$rss->fields["ANEX_DESC"] ?> </td>
	 <td  >
	 <?=$verImagen?> </td>
  </tr>
  <? 
    $i=$i++;
 // echo  "hola  $i";
	$rss->MoveNext();  
  }
	//$rss->MoveNext();  
}
?>
</tbody>
</table>
</div>

<div class="datagrid">
<?
//by skinatech, octubre 6/09, se hizo el cambio del campo r.radi_nume_deri en la query
$isql = "select a.SGD_RENV_FECH,
		a.DEPE_CODI,
		a.USUA_DOC,
		a.RADI_NUME_SAL,
		a.SGD_RENV_NOMBRE,
		a.SGD_RENV_DIR,
		a.SGD_RENV_MPIO,
		a.SGD_RENV_DEPTO,
		a.SGD_RENV_PLANILLA,
		a.SGD_RENV_FECH,
		b.DEPE_NOMB,
		c.SGD_FENV_DESCRIP,
		a.SGD_RENV_OBSERVA,
		a.SGD_DEVE_CODIGO,
		r.RADI_PATH
		from sgd_renv_regenvio a, dependencia b, sgd_fenv_frmenvio c, radicado r
		where
		r.radi_nume_deri in($verradicado)
		AND a.depe_codi=b.depe_codi
		AND a.sgd_fenv_codigo = c.sgd_fenv_codigo
		AND a.radi_nume_sal=r.radi_nume_radi
		order by a.SGD_RENV_FECH desc ";
$rs = $db->query($isql);
$i=1;
if(!$rs->EOF)
{
?>
<table width="90%" summary="Esta tabla contiene la información de los envios que se han realizado de los anexos 
			    del radicado consultado, día de envío, guía , etc.">
<caption><h4>DATOS DE ENVIOS REALIZADOS</h4></caption>
<thead>
<tr>
<th width=10%>RADICADO</th>
<th width=15%>FECHA</th>
<th width=15%>DESTINATARIO</th>
<th width=15%>DIRECCI&Oacute;N</th>
<th width=15%>DEPARTAMENTO</th>
<th width=15%>MUNICIPIO</th>
<th width=15%>TIPO DE ENVIO</th>
<th width=5%>N°. PLANILLA</th>
<th width=15%>OBSERVACIONES</th>
</tr>
</thead>
<tbody>
<tr>
<?
while(!$rs->EOF)
{
	$radDev = $rs->fields["SGD_DEVE_CODIGO"];
	$radEnviado = $rs->fields["RADI_NUME_SAL"];
	$radiPath = $rs->fields["RADI_PATH"];
	$pathImagen = $ruta_raiz."/bodega/$radiPath";
	str_replace("//","/",$pathImagen);
  str_replace("\\","/",$pathImagen);
	$pathImagen = "";
	if($radDev)
	{
		$imgRadDev = "<img src='$ruta_raiz/imagenes/devueltos.gif' alt='Documento Devuelto por empresa de Mensajeria' title='Documento Devuelto por empresa de Mensajeria'>";
	}else
	{
		$imgRadDev = "";
	}
if($i==1)
	{
   ?>
	<?
		$i=1;
	}
	?>
	<td  >
	<?=$imgRadDev?>
    <?=$radEnviado?>
		</td>
    <td >
	<?=$rs->fields["SGD_RENV_FECH"]?>
	</td>
    <td >
	<?=$rs->fields["SGD_RENV_NOMBRE"]
	?> </td>
    <td >
	<?=$rs->fields["SGD_RENV_DIR"]?> </td>
    <td >
	 <?=$rs->fields["SGD_RENV_DEPTO"] ?> </td>
    <td >
	 <?=$rs->fields["SGD_RENV_MPIO"] ?> </td>
    <td >
	 <?=$rs->fields["SGD_FENV_DESCRIP"] ?> </td>
    <td >
	 <?=$rs->fields["SGD_RENV_PLANILLA"] ?> </td>
    <td >
	 <?=$rs->fields["SGD_RENV_OBSERVA"] ?> </td>
  </tr>
  <?
	$rs->MoveNext();
  }
?>
 <!--<tr class='listado1'>-->
<!-- by skinatech, octubre 6/09 -->
<!--	<td TD class="borde_tab" colspan=3><img src='<?=$ruta_raiz?>/imagenes/devueltos.gif'>Documento Devuelto por empresa de Mensajeria</td>-->
<!--</tr>-->
<?
}
else
{
?>


<tr><td>
</td></tr>
<?
}
?>
</div>
</CENTER>
</body>
</html>
