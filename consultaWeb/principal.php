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
$dependencia = '240';
$codusuario = 1;
$verrad = $idRadicado;
$ent = substr($idRadicado,-1);
error_reporting(7);
$iTpRad = 10;

include "$ruta_raiz/ver_datosrad.php";
include "$ruta_raiz/config.php";
include "sessionWeb.php";

//$db->conn->debug = true;
/** encriptacion de pagina para inactivar en una Hora
  */
  
$llave = date("YmdH") . "$verrad";
$password =md5($llave);
$fechah=date("YmdHis");
// Finaliza Historicos
?>
<html lang="es">
<head>
<title> <?=$entidad_largo ?> - Consulta de PQR</title>
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
<body id="public">
<div id="container2">
      <h1>&nbsp;</h1>
      <div class="info">
           <center> <img src="../logoEntidad.png"  height="30%" align="center"/></center>
            <p>A continuacion encontrara toda la informacion correspondiente a su solicitud.</p>
      </div>
<div class="datagrid">
      <ul>
      <div id="foli3">
            <table width="100%" summary="Contiene la información de su solicitud">
                  <h4>INFORMACION DEL DOCUMENTO CON NUMERO DE RADICADO <?=$verradicado?><? $tipo1=strtoupper(substr($radi_path,-3));
                        if ($tipo1=="TIF" or $tipo1=="PDF" or $tipo1=="CSV" or $tipo1=="JPG"){?>
                              <a href='<?=$ruta_raiz?>/bodega/<?=$radi_path?>' title='Abrir el documento consultado'>(Ver el documento)</a>
                        <? } ?>
                  </h4>
                  <thead>
                        <tr>
                              <th width="11%">TIPO DOCUMENTO</th>
                              <th width="11%">FECHA RADICADO </th>
                              <th width="11%">ASUNTO </th>
                              <th width="11%"><?=$tip3Nombre[1][$ent]?></th>
                              <th width="11%">DIRECCI&Oacute;N </th>
                              <th width="11%">MUN/DPTO</th>
                              <th width="11%">REF/OFICIO/CUENTA INT </th>
                              <th width="11%">ESTADO ACTUAL</th>
                        </tr>
                  </thead>
                  <tbody>
                        <tr>
                              <td><?
                                // MODIFICADO POR SKINATECH SEPT 21/09
                                // $isql = "select SGD_TPR_DESCRIP FROM SGD_TPR_TPDCUMENTO where sgd_tpr_codigo='$tdoc'";
                                $isql = "select SGD_TPR_DESCRIP FROM SGD_TPR_TPDCUMENTO T, RADICADO R where R.radi_nume_radi='$verradicado' and R.tdoc_codi=t.sgd_tpr_codigo";
                                // $db->conn->debug=true;
                                $rs=$db->query($isql);
                                     if  (!$rs->EOF){ $tpdoc_nombre = $rs->fields["SGD_TPR_DESCRIP"];} ?>
                                     <?=$tpdoc_nombre ?>
                              </td>
                              <td><?=$radi_fech_radi ?></td>
                              <td><?=$ra_asun ?></td>
                              <td><?=$nombret_us1 ?> </td>
                              <td><?=$direccion_us1 ?></td>
                              <td><?=$dpto_nombre_us1."/".$muni_nombre_us1 ?></td>
                              <td><?=$cuentai?>-</td>
                        <? if(!$flujo_nombre and $radi_depe_actu=='999') $flujo_nombre = "Finalizado";
                        else { if(!$flujo_nombre) $flujo_nombre = "En Tramite";} ?>
                              <td><center>
                                <? /*  MODIFICADO POR SKINATECH, OCTUBRE 6/09
                                    $isql = "select a.SGD_FLD_CODIGO,a.SGD_FLD_DESC, b.SGD_TPR_TERMINO,a.SGD_FLD_IMAGEN
                                          ,a.SGD_FLD_GRUPOWEB FROM SGD_FLD_FLUJODOC a, SGD_TPR_TPDCUMENTO B
                                          where a.sgd_tpr_codigo=b.SGD_TPR_CODIGO AND a.sgd_tpr_codigo='$tdoc'
                                          AND a.sgd_fld_codigo=a.sgd_fld_grupoweb order by a.SGD_FLD_CODIGO";*/
                                    //$db->conn->debug=true;
                                    $rs=$db->query($isql);
                                    $iFld = 0;
                                    if(!$rs->EOF) {
                                          $flujo = $rs->fields["SGD_TPR_TERMINO"];
                                          //$flujo_nombre = $rs->fields["SGD_FLD_DESC"];                  
                                    }
                                    echo $flujo_nombre;?>
                              </center></td>
                        </tr>
                  </tbody>
            </table>
      </div>
      </ul>
      
      <ul>
      <div id="foli3">
            <table width="100%" summary="Detalle de los documentos que han sido anexados a la solicito.">
                  <?// by skinatech, octubre 6/09, se realizó el cambio de la variable en el query
                  /*$isql = "select r.RA_ASUN, r.RADI_FECH_RADI, r.RADI_NUME_RADI, r.RADI_PATH from radicado r where r.radi_nume_deri in($verradicado) AND r.radi_tipo_deri = 0";*/
                  $isql= "select * from anexos where anex_radi_nume='". $verradicado."'";
                  //$db->conn->debug = true;
                  $rss= $db->query($isql);
                  $i=1;
                  if(!$rss->EOF){?>
                        <h4>DOCUMENTOS ANEXOS DE LA SOLICITUD</h4>
                        <thead>
                              <tr>
                                    <th width="15%">TIPO</th>
                                    <th width="20%">RADICADO</th>
                                    <th width="20%">FECHA</th>
                                    <th width="30%">ASUNTO</th>
                                    <th width="15%">DIGITALIZACI&Oacute;N</th>
                              </tr>
                        </thead>
                        <tbody>
                        <? while(!$rss->EOF){
                              $radEnviado = $rss->fields["RADI_NUME_SALIDA"];
                              $anex_codigo = $rss->fields["ANEX_CODIGO"];
                              //if ($radi_path==""){
                                    $ano=substr($anex_codigo, 0, 4);
                                    $depe=substr($anex_codigo, 4, 3);
                                    $radi_path="/".$ano ."/".$depe ."/docs/";
                              //}
                                  
                              $long=strlen($anex_codigo);
                              $anex_salida = $rss->fields["RADI_NUME_SALIDA"];
                              if($anex_salida!=NULL) $anex_codigo=$anex_salida;
                              if ($long>14){ $radEnviado=substr($anex_codigo, 0, 14); }
                        
                                    switch(substr($radEnviado,-1)){
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
                                              $tipoDocumentoAnexo = "Pqr";
                                              break;
                                          case 6;
                                              $tipoDocumentoAnexo = "Acta";
                                              break;
                                          case 7;
                                              $tipoDocumentoAnexo = "Factura";
                                              break;
                                          case 5:
                                              $tipoDocumentoAnexo = "Resolucion";
                                          break;
                                    }
                                    
                              $verImagen = "";
                              $anex = $rss->fields["ANEX_NOMB_ARCHIVO"];
                              // $anex_codigo = $rss->fields["ANEX_CODIGO"];
                              // $anex_salida = $rss->fields["RADI_NUME_SALIDA"];
                              // if($anex_salida!=NULL) $anex_codigo=$anex_salida;
                              $radEnviado = $rss->fields["ANEX_RADI_NUME"];
                              $radFecha = $rss->fields["ANEX_RADI_FECH"];
                              // $radiPath = trim($rss->fields["RADI_PATH"]);
                              $radiPath= $radi_path;
                              $ra_asun = $rss->fields["ANEX_DESC"];
                              $tipo=strtoupper(substr($anex,-3));
                                    //echo $tipo1;
                                    /* if ($tipo =="TIF"  or  $tipo=="PDF" or $tipo=="CSV" or $tipo=="JPG" or $tipo=="docx"){*/
                                          $ruta = substr($radi_path, 0, 16);
                                          $pathImagen=$ruta_raiz ."/bodega". $ruta . $anex;
                                          //$pathImagen = $ruta_raiz."/bodega/$radiPath";
                                          //$pathImagen = str_replace("//","/",$pathImagen);
                                          //$pathImagen = str_replace("\\","/",$pathImagen);
                                          $verImagen = "<a href='$pathImagen' Target='ImagenOrfeo_$radEnviado' aria-label='Abrir Imagén de radicado'>Abrir Imag&eacute;n</a>";
                                    //}
                              $pathImagen = "";
                                    
                              if($radDev){
                                    $imgRadDev = "<img src='$ruta_raiz/imagenes/devueltos.gif' alt='Documento Devuelto por empresa de Mensajeria' title='Documento Devuelto por empresa de Mensajeria'>";
                              }else{
                                    $imgRadDev = "";
                              }
                              $i=1;?>
                        
                              <tr>
                                  <td><?=$tipoDocumentoAnexo?></td>
                                  <td><center> <?=$imgRadDev?> <?=$anex_codigo?> </center></td>
                                  <td> <?=$rss->fields["ANEX_RADI_FECH"]?> </td>
                                  <td> <?=$rss->fields["ANEX_DESC"] ?> </td>
                                  <td><center> <?=$verImagen?> </center></td>
                              </tr>
                        <?
                              $i=$i++;
                              // echo  "hola  $i";
                              $rss->MoveNext();
                        }
                              //$rss->MoveNext();  
                        ?>
                  </tbody>
                  <?php  } ?>
            </table>  
      </div>        
      </ul>
      <ul>
      <div id="foli3">
           <? //by skinatech, octubre 6/09, se hizo el cambio del campo r.radi_nume_deri en la query
	    $isql="select a.SGD_RENV_FECH, 
		   a.DEPE_CODI, a.USUA_DOC, 
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
from sgd_renv_regenvio a, 
dependencia b, 
sgd_fenv_frmenvio c, 
radicado r 
where r.radi_nume_deri in('$verradicado') 
AND a.depe_codi=b.depe_codi 
AND a.sgd_fenv_codigo = c.sgd_fenv_codigo 
AND a.radi_nume_sal=r.radi_nume_radi 
order by a.SGD_RENV_FECH desc ";
            //$db->conn->debug = true;
            $rs= $db->query($isql);
            $i=1;
            if(!$rs->EOF){?>
                  <table width="100%" summary="Información de los envios que se han realizado de los anexos de la solicitud, día de envío, guía, etc.">
                        <h4>DATOS DE ENVIOS REALIZADOS</h4>
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
                              <? while(!$rs->EOF){
                                    $radDev = $rs->fields["SGD_DEVE_CODIGO"];
                                    $radEnviado = $rs->fields["RADI_NUME_SAL"];
                                    $radiPath = $rs->fields["RADI_PATH"];
                                    $pathImagen = $ruta_raiz."/bodega/$radiPath";
                                    str_replace("//","/",$pathImagen);
                                    str_replace("\\","/",$pathImagen);
                                          
                                    $pathImagen = "";
                                    if($radDev){
                                          $imgRadDev = "<img src='$ruta_raiz/imagenes/devueltos.gif' alt='Documento Devuelto por empresa de Mensajeria' title='Documento Devuelto por empresa de Mensajeria'>";
                                    }else{
                                          $imgRadDev = "";
                                    }
                                          
                                    if($i==1){ $i=1; }?>
                                    
                                    <tr>
                                          <td><?=$imgRadDev?> <?=$radEnviado?> </td>
                                          <td><?=$rs->fields["SGD_RENV_FECH"]?> </td>
                                          <td><?=$rs->fields["SGD_RENV_NOMBRE"]?> </td>
                                          <td><?=$rs->fields["SGD_RENV_DIR"]?> </td>
                                          <td><?=$rs->fields["SGD_RENV_DEPTO"] ?> </td>
                                          <td><?=$rs->fields["SGD_RENV_MPIO"] ?> </td>
                                          <td><?=$rs->fields["SGD_FENV_DESCRIP"] ?> </td>
                                          <td><?=$rs->fields["SGD_RENV_PLANILLA"] ?> </td>
                                          <td><?=$rs->fields["SGD_RENV_OBSERVA"] ?> </td>
                                    </tr>
                                          
                                    <? $rs->MoveNext();
                              }?>
                        </tbody>
                  </table>                  
            <? }?>
      </div>
      </ul>
</div>
</div>
</body>
</html>
