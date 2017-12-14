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


if (!$ruta_raiz)$ruta_raiz="..";
require_once("$ruta_raiz/include/db/ConnectionHandler.php");
if (!$db) $db = new ConnectionHandler("$ruta_raiz");
//include("crea_combos_universales.php");
//error_reporting(7);
$db->conn->SetFetchMode(ADODB_FETCH_NUM);
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);

session_start();
/**
  * Modificacion Variables Globales Infometrika 2009-05
  * Licencia GNU/GPL 
  */

foreach ($_GET as $key => $valor)   ${$key} = $valor;
foreach ($_POST as $key => $valor)   ${$key} = $valor;

$krd = $_SESSION["krd"];
$dependencia = $_SESSION["dependencia"];
$usua_doc = $_SESSION["usua_doc"];
$codusuario = $_SESSION["codusuario"];
$tpNumRad = $_SESSION["tpNumRad"];
$tpPerRad = $_SESSION["tpPerRad"];
$tpDescRad = $_SESSION["tpDescRad"];
$tip3Nombre = $_SESSION["tip3Nombre"];
$tip3img = $_SESSION["tip3img"];
$tpDepeRad = $_SESSION["tpDepeRad"];
$tip3desc = $_SESSION["tip3desc"];
$tipoRadicadoPqr = $_SESSION["tipoRadicadoPqr"];

//by skinatech
if(!$birds22) $birds22=0;

$ruta_raiz = "..";
/*
 * Variables de Session de Radicacion de Mails
 * Estas son variables que traen los valores con radicacoin de un correo Electronico
 *
 * @autor Orlando Burgos
 * @version Orfeo 3.7
 * @año 2008
 */
$tipoMedio = $_SESSION['tipoMedio'];
/*if($tipoMedio=="eMail"){
  
 $ruta_raiz. "/email/connectIMAP.php";
	if(!$asu){ 
	   $body =$msg->getBody($_GET['eMailMid'], $_GET['eMailPid']);
	   $msg->getHeaders($eMailMid);
	   $asu = $msg->header[$eMailMid]['subject'];
    	   $mail_us1= $msg->header[$eMailMid]['from_personal'][0]." <".$msg->header[$eMailMid]['from'][0].">";
	}
}*/
/**  Fin variables de session de Radicacion de Mail. **/
if(!isset($_SESSION['dependencia']) and !isset($_SESSION['cod_local']))	include "../rec_session.php";
$ruta_raiz = "..";
// Modificado SGD 21-Septiembre-2007
//define('ADODB_ASSOC_CASE', 0);

include_once "../include/db/ConnectionHandler.php";
include_once "../class_control/AplIntegrada.php";

$db = new ConnectionHandler("$ruta_raiz");
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);
//$db->conn->debug = true;
include "crea_combos_universales.php";
$objApl = new AplIntegrada($db);
if($nurad){
	$nurad=trim($nurad);
	$ent = substr($nurad,-1);
}

$no_tipo = "true";
$imgTp1 = str_replace(".jpg", "",$tip3img[1][$ent]);
$imgTp2 = str_replace(".jpg", "",$tip3img[2][$ent]);
$imgTp3 = str_replace(".jpg", "",$tip3img[3][$ent]);
$descTp1 = "alt='".$tip3desc[1][$ent]."' title='".$tip3desc[1][$ent]."'";
$descTp2 = "alt='".$tip3desc[2][$ent]."' title='".$tip3desc[2][$ent]."'";
$descTp3 = "alt='".$tip3desc[3][$ent]."' title='".$tip3desc[3][$ent]."'";
$nombreTp1 = $tip3Nombre[1][$ent];
$nombreTp2 = $tip3Nombre[2][$ent];
$nombreTp3 = $tip3Nombre[3][$ent];
?>

<HTML>
<head>
<title>.:: Orfeo Modulo de Radicaci&acuoteo;n::.</title>

        <meta charset="utf-8">
        <link rel="stylesheet" href="../js/jquery-ui/development-bundle/themes/base/jquery.ui.all.css">
        <script src="../js/jquery-ui/development-bundle/jquery-1.7.1.js"></script>
        <script src="../js/jquery-ui/development-bundle/ui/jquery.ui.core.js"></script>
        <script src="../js/jquery-ui/development-bundle/ui/jquery.ui.widget.js"></script>
        <script src="../js/jquery-ui/development-bundle/ui/jquery.ui.position.js"></script>
        <script src="../js/jquery-ui/development-bundle/ui/jquery.ui.autocomplete.js"></script>
        <script type="text/javascript" src="../ajax/js/ajax.js"></script> 
       <link rel="stylesheet" href="../js/jquery-ui/development-bundle/demos/demos.css">
        <style>
        .ui-autocomplete-loading { background: white url('../js/jquery-ui/development-bundle/demos/autocomplete/images/ui-anim_basic_16x16.gif') right center no-repeat; }
        </style>

<meta http-equiv="expires" content="99999999999">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="../estilos/tabber.css" TYPE="text/css" MEDIA="screen">
<link href="<?= $ruta_raiz . $ESTILOS_PATH2 ?>bootstrap.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?= $ruta_raiz . $_SESSION['ESTILOS_PATH_ORFEO'] ?>">

<script Language="JavaScript" src="../js/crea_combos_2.js"></script>
<script type="text/javascript" src="../js/tabber.js"></script>

<script>
//by skinatech
 var producto="hola ";
        $(function() {
                var cache = {},
                        lastXhr;
                $( "#birds" ).autocomplete({
                        minLength: 3, 
                        select: seleccion,
                        source: function( request, response ) {
                                var term = request.term;
                                if ( term in cache ) {
                                        response( cache[ term ] );
                                                         return;
                                }

                                lastXhr = $.getJSON( "search.php", request, function( data, status, xhr ) {
                                        cache[ term ] = data;
                                        if ( xhr === lastXhr ) {
                                          response( data );
                                        }
                                });
                        }
                });
        });


function seleccion(event, ui) {
    var  producto;  
    // recupera la informacion del producto seleccionado  
   producto = ui.item.value;
  
//  funcion en ajax  para traer  los datos  del  ciudadano seleccionado
$.ajax({
    data: "producto="+encodeURIComponent(producto)+"", //parametro a enviar para obtenerlo en search2.php
    type: "GET",
    dataType: "json",  
    url: "search2.php",
    success: function(data){
       restults(data);
     }
   });
   //  document.formulario.nombre_us1.value=producto;
   // $("#birds").val(producto.descripcion);  
  //  event.preventDefault();  
}

function restults(data){
     
    document.formulario.nombre_us1.value      = data.NOM;
    document.formulario.documento_us1.value   = data.DOCUMENTO;
    document.formulario.prim_apel_us1.value   = data.APELL1;
    document.formulario.seg_apel_us1.value    = data.APELL2;
    document.formulario.telefono_us1.value    = data.TELEFONO;      
    document.formulario.mail_us1.value        = data.MAIL;  
    document.formulario.direccion_us1.value   = data.DIRECCION;
    document.formulario.tipo_emp_us1.value    = data.TIPO_EMPRESA;
    document.formulario.cc_documento_us1.value=data.CC_DOCUMENTO;
    document.formulario.idcont1.value         =data.CONT;
    //Modificacion skina - Asignacion correcta de valores a combos de un¿bicacion geografica
    //Ing Camilo Pintor - cpintor@skinatech.com
    //Julio 2015
    cambia(formulario, 'idpais1', 'idcont1');
    document.formulario.idpais1.value         =data.PAIS;
    cambia(formulario, 'codep_us1', 'idpais1');
    document.formulario.codep_us1.value       =data.DPTO;
    cambia(formulario, 'muni_us1', 'codep_us1');
    document.formulario.muni_us1.value        =data.MUNI;
    //Fin Modificacion skina - Asignacion correcta de valores a combos de un¿bicacion geografica 
}
function recargar2(){
        var variable_post=document.formulario.coddepe.value;
        //var variable_post="Mi texto recargado";
        $.post("miscript.php", { variable: variable_post }, function(data){
        $("#recargado").html(data);
        });
}
</script>

<!--Script desarrollado para halar suscriptores ESP (Empopasto) -->
<script languaje="JavaScript">

    function findSubscr(subscriber){
	 $.ajax({
	    data: "subscriber="+subscriber+"", //parametro enviado a search3.php
	    type: "GET",
	    dataType: "json",  
 	    url: "search3.php",
 	    success: function(data){
               if (data.NOM != " "){
		  results(data);
	       }else{
                  alert("Codigo de identificación no encontrado");
                  //Limpieza del formulario para evitar confusion
                  results(data);
	       }
	    }
         });
      }

    function findSubscr2(subscriber)
      {
         $.ajax({
            data: "subscriber="+subscriber+"", //parametro enviado a search3.php
            type: "GET",
            dataType: "json",  
            url: "search5.php",
            success: function(data){
               if (data.NOM != " "){
                  results(data);
               }else{
                  alert("Codigo de suscriptor no encontrado");
                  //Limpieza del formulario para evitar confusion
                  results(data);
               }
            }
         });
      }

    function results(data)
      {
	    document.formulario.nombre_us1.value      = data.NOM;
	    document.formulario.documento_us1.value   = data.DOCUMENTO;
	    document.formulario.prim_apel_us1.value   = data.APELL1;
	    document.formulario.seg_apel_us1.value    = data.APELL2;
	    document.formulario.telefono_us1.value    = data.TELEFONO;      
	    document.formulario.mail_us1.value        = data.MAIL;  
	    document.formulario.direccion_us1.value   = data.DIRECCION;
	    document.formulario.tipo_emp_us1.value    = data.TIPO_EMPRESA;
	    document.formulario.cc_documento_us1.value=data.CC_DOCUMENTO;
            //Modificacion skina - Asignacion correcta de valores a combos de un¿bicacion geografica
	    //Ing Camilo Pintor - cpintor@skinatech.com
	    //Julio 2015
	    document.formulario.idcont1.value         =data.CONT;
            cambia(formulario, 'idpais1', 'idcont1');
	    document.formulario.idpais1.value         =data.PAIS;
            cambia(formulario, 'codep_us1', 'idpais1');
	    document.formulario.codep_us1.value       =data.DPTO;
            cambia(formulario, 'muni_us1', 'codep_us1');
	    document.formulario.muni_us1.value        =data.MUNI;
            //Fin Modificacion skina - Asignacion correcta de valores a combos de un¿bicacion geografica
      }
      
    function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode

         if (charCode == 13)
            if ($('#birds1').val() == "")
               alert("El campo identificación esta vacio");
	    else
	       findSubscr($('#birds1').val());
		
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

    function isNumberKey3(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode

         if (charCode == 13)
            if ($('#birds3').val() == "")
               alert("El campo codigo de suscriptor esta vacio");
            else
               findSubscr2($('#birds3').val());
                
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }

</script>

<!--Script desarrollado para modificar dias de termino defecto (Empopasto) -->
<script languaje="JavaScript">

    function typeDoc()
      {
         type = document.formulario.tdoc.value;
         // Dias de termino defecto
         $.ajax({
            data: "tipoDoc="+type+"", //parametro enviado a search4.php
            type: "GET",
            dataType: "json",  
            url: "search4.php",
            success: function(data){
               if (data.DIAS != ""){
                  document.formulario.birds2.value = data.DIAS;
               }else{
                  alert("Tipo documental mal parametrizado");
                  //Limpieza del formulario para evitar confusion
               }
            }
         });
      }

    function isNumberKey2(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode

         if (charCode == 13)
               alert("El campo dias de termino no puede estar vacio");
                
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
</script>



<script language="JavaScript">
document.write('<style type="text/css">.tabber{display:none;}<\/style>');
<?


// Convertimos los vectores de los paises, dptos y municipios creados en crea_combos_universales.php a vectores en JavaScript.
echo arrayToJsArray($vpaisesv, 'vp');
echo arrayToJsArray($vdptosv, 'vd');
echo arrayToJsArray($vmcposv, 'vm');
?>

function cambIntgAp(valor){
	fecha_hoy =  '<?=date('d')."-".date('m')."-".date('Y')?>';

	if (valor!=0){
		if  (document.formulario.fecha_gen_doc.value.length==0)
			document.formulario.fecha_gen_doc.value=fecha_hoy;
	} else
		document.formulario.fecha_gen_doc.value="";

}

function fechf(formulario,n)
{
  var fechaActual = new Date();
	fecha_doc = document.formulario.fecha_gen_doc.value;
	dias_doc=fecha_doc.substring(0,2);
	mes_doc=fecha_doc.substring(3,5);
	ano_doc=fecha_doc.substring(6,10);
	var fecha = new Date(ano_doc,mes_doc-1, dias_doc);
  var tiempoRestante = fechaActual.getTime() - fecha.getTime();
  var dias = Math.floor(tiempoRestante / (1000 * 60 * 60 * 24));
  if (dias >60 && dias < 1500)
	{
    alert("El documento tiene fecha anterior a 60 dias!!");
		}
     else
		{
 	  if (dias > 1500)
		  {sftp://jlosada@172.16.0.168/home/orfeodev/jlosada/public_html/orfeointer/radicacion/NEW.php
       alert("Verifique la fecha del documento!!");
		   fecha_doc = "";
			}else
			{
				fecha_doc = "ok";
				if (dias < 0)
				{
				alert("Verifique la fecha del documento !!, es Una fecha Superior a la Del dia de Hoy");
				fecha_doc = "asdfa";
				}

			}

		}
	return fecha_doc;
}
function radicar_doc()

{	if(fechf ("formulario",16)=="ok")
	{
		if (
                        document.formulario.tdoc.value != 0 &&
			document.formulario.documento_us1.value != 0 &&
			//document.formulario.nombre_us1.value.trim() != '' &&
			document.formulario.muni_us1.value != 0 &&
			document.formulario.direccion_us1.value != 0 &&
			document.formulario.coddepe.value != 0 &&
                        document.formulario.asu.value != '') 
  		{
			document.getElementById( 'birds22' ).value = document.getElementById( 'birds2' ).value;
		  	document.formulario.submit();
			alert("Radicado creado exitosamente");
		}
	 else
	 	{	
		alert("El Asunto, tipo de Documento, Remitente/Destinatario, Direccion y Dependencia son obligatorios ");	}
	 }
}

function modificar_doc(){
	if (
	document.formulario.documento_us1.value && document.formulario.asu.value != '' && document.formulario.tdoc.value != 0)
{
        	document.getElementById( 'birds22' ).value = document.getElementById( 'birds2' ).value;
      		document.formulario.submit();
         }else{
          	alert("El Asunto, tipo de Documento, Remitente/Destinatario, Direccion y Dependencia son obligatorios ");       
	 }
}
function pestanas(pestana){
 <?
   //if($ent==1) $ver_pestana="none"; else $ver_pestana="";
//document.getElementById('remitente').style.display = "";
  // document.getElementById('remitente_R').style.display = "none";
  // document.getElementById('remitente').style.display = "none";
   if($ent==1) $ver_pestana=""; else $ver_pestana="";
  ?>
	document.getElementById('remitente').style.display = "";
   document.getElementById('predio').style.display = "<?=$ver_pestana?>";
   document.getElementById('empresa').style.display = "<?=$ver_pestana?>";
  if(pestana==1) {
   document.getElementById('pes1').style.display = "";
   
   }else
   {
    document.getElementById('pes1').style.display = "none";
   }
  if(pestana==2)
  {
  document.getElementById('pes2').style.display = "";
   }else{document.getElementById('pes2').style.display = "none";}
  if(pestana==3) {
  document.getElementById('pes3').style.display = "";
  }
  else
  {document.getElementById('pes3').style.display = "none";}
}
function pb1()
{
   dato1 = document.forma.no_documento.value;
}
function Start(URL, WIDTH, HEIGHT) {
windowprops = "top=0,left=0,location=no,status=no, menubar=no,scrollbars=yes, resizable=yes,width=1366,height=670";
preview = window.open(URL , "preview", windowprops);
}
function doPopup() {
url = "popup.htm";
width = 800; // ancho en pixels
height = 320; // alto en pixels
delay = 2; // tiempo de delay en segundos
timer = setTimeout("Start(url, width, height)", delay*1000);
}
function buscar_usuario()
{
   document.write('<form target=Buscar_Usuario name=formb action=buscar_usuario.php?envio_salida=true&ent=<?=$ent?> method=POST>************');
   document.write("<input type='hidden' name=no_documento value='" + documento +"'>");
   document.write("</form> ");
}
function regresar(){
i=1;
}
</script>
</head>             <!--Fin  del  encabezado  -->

<body bgcolor="#FFFFFF" >

<div id="spiffycalendar" class="text"></div>
<link rel="stylesheet" type="text/css" href="../js/spiffyCal/spiffyCal_v2_1.css">
<script language="JavaScript" src="../js/spiffyCal/spiffyCal_v2_1.js"></script>
<link rel="stylesheet" href="../estilos/tabber.css" TYPE="text/css" MEDIA="screen">
<script type="text/javascript" src="../js/tabber.js"></script>

<?PHP
    error_reporting(7);
  $ddate=date('d');
  $mdate=date('m');
  $adate=date('Y');
  $nurad = trim($nurad);
  $hora=date('H:i:s');
  $fechaf =$date.$mdate.$adate.$hora;
  // aqui se busca el radicado para editar si viene la variable $Buscar
  if($Buscar){
		$docDia = $db->conn->SQLDate('d','a.RADI_FECH_OFIC');
		$docMes = $db->conn->SQLDate('m','a.RADI_FECH_OFIC');
		$docAno = $db->conn->SQLDate('Y','a.RADI_FECH_OFIC');
		$fRad = $db->conn->SQLDate('Y-m-d','a.RADI_FECH_RADI');
		if (!$nurad || strlen(trim($nurad))==0)
			$nurad="NULL";
		$query = "select a.*
							,$docDia AS DOCDIA
							,$docMes AS DOCMES
							,$docAno AS DOCANO
							,a.EESP_CODI
							,a.RA_ASUN
							,$fRad AS FECHA_RADICADO
						from radicado a
						where a.radi_nume_radi='$nurad'";
	$rs=$db->conn->query($query);
	$varQuery = $query;
  	$busqueda=$nurad;
	
	if(!$rs->EOF and (isset($busqueda) || is_numeric($busqueda))) {
                  if($cursor){
                        $Submit4 = "Modificar";
                  }
			$asu=$rs->fields["RA_ASUN"];
			$tip_doc =$rs->fields["TDID_CODI"];
			$radicadopadre=$rs->fields["RADI_NUME_DERI"];
			$ane= $rs->fields["RADI_DESC_ANEX"];
			$codep=$rs->fields["DEPTO_CODI"];
			$pais=$rs->fields["RADI_PAIS"];
			$carp_codi = $rs->fields["CARP_CODI"];
			$cuentai = $rs->fields["RADI_CUENTAI"];
			$carp_per = $rs->fields["CARP_PER"];
			$depende=$rs->fields["RADI_DEPE_ACTU"];
			$tip_rem=$rs->fields["TRTE_CODI"]+1;
			$tdoc=$rs->fields["TDOC_CODI"];
			$med =$rs->fields["MREC_CODI"];
			$cod=$rs->fields["MUNI_CODI"];
			//$coddepe=$rs->fields["RADI_DEPE_ACTU"];
			$codusuarioActu=$rs->fields["RADI_USUA_RADI"];
			$coddepe=$rs->fields["RADI_DEPE_ACTU"];
			//$coddepe=100;
                        $fechproc12=$rs->fields["DOCDIA"];
			$fechproc22=$rs->fields["DOCMES"];
			$fechproc32=$rs->fields["DOCANO"];
			$fechaRadicacion=$rs->fields["FECHA_RADICADO"];
			$espcodi =$rs->fields["EESP_CODI"];
			$fecha_gen_doc = "$fechproc12/$fechproc22/$fechproc32";
			include "busca_direcciones.php";
	}else{
	    echo "<br>"
            . "<p>"
                . "<center>"
                . "<table width='90%' class=borde_tab celspacing=5>"
                    . "<tr>"
                        . "<td class=alarmas>"
                            . "<center>"
                                . "No se han encontrado registros con numero de radicado "
                                . "<font class='vinculos'>$nurad</font> "
                                . "<br>"
                                . "Revise el radicado escrito, solo pueden ser Numeros de 14 digitos"
                                . "<br>"
                                . "<p>"
                                . "<a href='edtradicado.php?fechaf=$fechaf&krd=$krd&drde=$drde'>Intente de Nuevo</a>"
                            . "</center>"
                        . "</td>"
                    . "</tr>"
                . "</table>"
            . "</center>";
			if(!$rsJHLC) die("<hr>");
	}	
  }
	 // Fin de Busqueda del Radicado para editar

?>
  <script language="javascript">
  <?

if(!$fecha_gen_doc || $fecha_gen_doc=='//')
{	$fecha_busq = date("d-m-Y");
	$fecha_gen_doc = $fecha_busq;
}
  ?>
   var dateAvailable1 = new ctlSpiffyCalendarBox("dateAvailable1", "formulario", "fecha_gen_doc","btnDate1","<?=$fecha_gen_doc?>",scBTNMODE_CUSTOMBLUE);
  </script>
   <?

	if($rad1 or $rad0 or $rad2)
	{
	if($rad1) $tpRadicado = "1";
	if($rad2) $tpRadicado = "2";
	if($rad0) $tpRadicado = "0";
  echo "<input type=hidden name=tpRadicado value=$tpRadicado>";
	$docDia = $db->conn->SQLDate('D','a.RADI_FECH_OFIC');
	$docMes = $db->conn->SQLDate('M','a.RADI_FECH_OFIC');
	$docAno = $db->conn->SQLDate('Y','a.RADI_FECH_OFIC');
	if (!$radicadopadre || strlen(trim($radicadopadre))==0)
			$radicadopadre="NULL";
  $query = "select a.*
							,$docDia AS DOCDIA
							,$docMes AS DOCMES
							,$docAno AS DOCANO
							,a.EESP_CODI from radicado a
						where a.radi_nume_radi='$radicadopadre'";
  $varQuery = $query;
	$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
	$rs=$db->conn->query($query);
	
	if(!$rs->EOF)
	{
		echo "<!-- No hay datos: $query -->";
	}
   if(!$Buscar and !$Submit4)
	 {
		$varQuery = $query;
		$comentarioDev = 'Entro a Anexar un radicado ';
		$cuentaii =$rs->fields["RADI_CUENTAI"];
		if($cuentaii){$cuentai=$cuentaii;}
		$pnom=$rs->fields["RADI_NOMB"];
		$papl=$rs->fields["RADI_PRIM_APEL"];
		$sapl=$rs->fields["RADI_SEGU_APEL"];
		$numdoc=$rs->fields["RADI_NUME_IDEN"];
		$asu=$rs->fields["RA_ASUN"];
		$tel=$rs->fields["RADI_TELE_CONT"];
		$rem2=$rs->fields["RADI_REM"];
		$adress=$rs->fields["RADI_DIRE_CORR"];
	}
	 $depende=$rs->fields["RADI_DEPE_ACTU"];
	 $radi_usua_actu_padre=$rs->fields["RADI_USUA_ACTU"];
	 $radi_depe_actu_padre=$rs->fields["RADI_DEPE_ACTU"];
	 $tip_doc =$rs->fields["TDID_CODI"];
	 $ane= $rs->fields["RADI_DESC_ANEX"];
	 $cod=$rs->fields["MUNI_CODI"];
	 $codep=$rs->fields["DPTO_CODI"];
	 $pais=$rs->fields["RADI_PAIS"];
	 $espcodi=$rs->fields["EESP_CODI"];
	 if($noradicar2)
	 {
			$fecha_gen_doc = $rs->fields["DOCDIA"] ."-".$rs->fields["DOCMES"] ."-".$rs->fields["DOCANO"];
			$fechproc12=$rs->fields["DOCDIA"];
			$fechproc22=$rs->fields["DOCMES"];
			$fechproc32=$rs->fields["DOCANO"];
		}
	$ruta_raiz = "..";
	$no_tipo = "true";
  include "busca_direcciones.php";
	}
	IF($rad1)
	{
	  $encabezado = "<center><b>Copia de datos del Radicado  $radicadopadre ";
	  $tipoanexo = "1";
	}
	IF($rad0)
	{
	  $encabezado = "<center><b>Anexo de $radicadopadre ";
	  $tipoanexo = "0";
	  $radicadopadre_exist=1;
	}
	 IF($rad2)
     {
	 $encabezado = "<center><b>Documento Asociado de $radicadopadre ";
	  if(!$Submit4 and !$Submit3){$cuentai = "";}
	  $tipoanexo = "2";
 	  $radicadopadre_exist=1;
	}
	 IF($noradicar1)
	  $radicadopadre_exist=0;
 ?>
  <script>
function procEst2(formulario,tb)
{
	var lista = document.formulario.codep.value;
	i = document.formulario.codep.value;
	if (i != 0) {
		var dropdownObjectPath = document.formulario.tip_doc;
		var wichDropdown = "tip_doc";
		var d=tb;
		var withWhat = document.formulario.codep.value;
		populateOptions2(wichDropdown, withWhat,tb);
	  }
}
function populateOptions2(wichDropdown, withWhat,tbres)
{
	r = new Array;
	i=0;
if (withWhat == "2")
	{
   r[i++]=new Option("NIT", "1");
     }
if (withWhat == "1")
	{
      document.formulario.submit();
      r[i++]=new Option("NIT","4");
      r[i++]=new Option("NUIR","5");
	}
if (withWhat == "3")
	{
		r[i++]=new Option("CC", "0");
		r[i++]=new Option("CE", "2");
		r[i++]=new Option("TI", "1");
		r[i++]=new Option("PASAPORTE", "3");
     }
	if (i==0) {
		alert(i + " " + "Error!!!");
		      }
	else{
		dropdownObjectPath = document.formulario.tip_doc;
		eval(document.formulario.tip_doc.length=r.length);
		largestwidth=0;
		for (i=0; i < r.length; i++)
			{
			  eval(document.formulario.tip_doc.options[i]=r[i]);
			  if (r[i].text.length > largestwidth) {
			     largestwidth=r[i].text.length;    }
	        }
		eval(document.formulario.tip_doc.length=r.length);
		//eval(document.myform.cod.options[0].selected=true);
	   }
}

function vnum(formulario,n)
{
	valor = formulario.elements[n].value;
	if (isNaN(valor))
      {
		alert ("Dato incorrecto..");
		formulario.elements[n].value="";
		formulario.elements[n].focus();
		return false;
      }
	else
		return true;
}

function fech(formulario,n)

{
m=n-1;
s=m-1;
var f=document.formulario.elements[n].value;
var meses=parseInt(document.formulario.elements[m].value);
eval(lona=document.formulario.elements[n].length);
eval(lonm=document.formulario.elements[m].length);
eval(lond=document.formulario.elements[s].length);
if(lona==44 || lonm==44 || lond==44)
{
alert("Fecha incorrecta  debe ser DD/MM/AAAA !!!");
document.formulario.elements[s].value="";
document.formulario.elements[m].value="";
document.formulario.elements[n].value="";
document.formulario.elements[s].focus();
}
else{
if ((f%4)==0){
if(document.formulario.elements[m].value<13){
switch(meses){
case 12 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 11 : if(document.formulario.elements[s].value>30)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 10 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 9 : if(document.formulario.elements[s].value>30)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 8 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 7 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 6 : if(document.formulario.elements[s].value>30)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 5 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 4 : if(document.formulario.elements[s].value>30)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 3 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 2 : if(document.formulario.elements[s].value>29)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 1 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
}
}
else {alert("Fecha mes inexistente!!");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
}
}
else {
if(document.formulario.elements[m].value<13){
switch(meses){
case 12 : if(document.formulario.elements[s].value>31)
				{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
	}break;
case 11 : if(document.formulario.elements[s].value>30)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 10 : if(document.formulario.elements[s].value>31)
{
alert ("Fecha incorrecta..");
document.formulario.elements[s].value="";
document.formulario.elements[m].value="";
document.formulario.elements[n].value="";
document.formulario.elements[s].focus();
return false;
}break;
case 9 : if(document.formulario.elements[s].value>30)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
			return false;
}break;
case 8 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 7 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 6 : if(document.formulario.elements[s].value>30)

{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 5 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 4 : if(document.formulario.elements[s].value>30)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 3 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 2 : if(document.formulario.elements[s].value>28)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
case 1 : if(document.formulario.elements[s].value>31)
{
	alert ("Fecha incorrecta..");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	return false;
}break;
}
}
	else {
	alert("Fecha mes inexistente!!");
	document.formulario.elements[s].value="";
	document.formulario.elements[m].value="";
	document.formulario.elements[n].value="";
	document.formulario.elements[s].focus();
	}
	}
}
}
var contadorVentanas=0
</script>
<?
  if ($Buscar1)
 {
	  include "busca_direcciones.php";
 }

if($Submit3=="ModificarDocumentos")  $var_envio=session_name()."=".trim(session_id())."&ent=$ent&carp_per=$carp_per&carp_codi=$carp_codi&rad=$nurad&depende=$depende&Submit3=$Submit3&depende=$depende";
else $var_envio=session_name()."=".trim(session_id())."&ent=$ent&carp_per=$carp_per&carp_codi=$carp_codi&rad=$nurad&coddepe=$coddepe&depende=$depende";

if($tipoMedio=="eMail"){
   $var_envio = $var_envio."&eMailMid=".$_GET['eMailMid']."&eMailPid=".$_GET['eMailPid'];
}
?>

<form action='NEW.php?<?=$var_envio?>'  method="post" name="formulario" id="formulario" class="borde_tab">
<INPUT TYPE=HIDDEN NAME=radicadopadre value='<?=$radicadopadre ?>'>
<input type=hidden name=tipoanexo value='<?=$tipoanexo ?>'>
<input type=hidden name='noradicar' value='<?=$noradicar ?>'>
<input type=hidden name='noradicar1' value='<?=$noradicar1 ?>'>
<input type=hidden name='noradicar2' value='<?=$noradicar2 ?>'>
<input type=hidden name='atrasRad0' value='<?=$rad0 ?>'>
<input type=hidden name='atrasRad1' value='<?=$rad1 ?>'>
<input type=hidden name='atrasRad2' value='<?=$rad2 ?>'>
<input type=hidden name='faxPath' value='<?=$faxPath ?>'>
<input type=hidden name='birds22' id='birds22' value='0'>
<?

// $producto=  $_COOKIE["variable"];
//echo $producto; 




if($tpRadicado) {echo "<input type=hidden name=tpRadicado value=$tpRadicado>";}
?>
<center>
    <br>
    <div id="titulo" style="width: 90%;" align="center">
        <table width="99%"  border="0" align="center" cellpadding="1" cellspacing="1" class="borde_tab">
        <!--<th colspan=4 style="color:#FFFFFF">Tabla1:Encabezado</th>-->
            <tr>
                <td width="6" class="titulos2"><a class="vinculosCabezote" href='./NEW.php?<?= session_name() . "=" . session_id() ?>&rad2=Asociado&krd=<?= $krd ?>&ent=<?= $ent ?>&rad1=<?= $atrasRad1 ?>&rad2=<?= $atrasRad2 ?>&rad0=<?= $atrasRad0 ?>&radicadopadre=<?= $radicadopadre ?>&noradicar=<?= $noradicar ?>&noradicar1=<?= $noradicar1 ?>&noradicar2=<?= $noradicar2 ?>'>Atras</a></td>
                <td width="94%" align="center" valign="middle" class="titulos2" style="font-size: 21px;"><b>
                        <?php
                        $query = "select SGD_TRAD_CODIGO
								, SGD_TRAD_DESCR from sgd_trad_tiporad
							where SGD_TRAD_CODIGO=$ent";
                        $ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
                        $rs = $db->conn->query($query);
                        $tRadicacionDesc = $rs->fields["SGD_TRAD_DESCR"];
                        ?>
                        Módulo de Radicación
                        <?= $tRadicacionDesc ?>
                        (Dep
                        <?= $dependencia ?>
                        ->
                        <?= $tpDepeRad[$ent] ?>
                        )</b>
                    <?php
                    if ($nurad) {
                        echo "<b>Rad No" . $nurad;
                        $ent = substr($nurad, -1);
                    }
                    ?>
                    <br>
                    <?= $encabezado ?>
                </td>
            </tr>
        </table>
    </div>
</center>

<table  width=90% border="0" align="center" cellspacing="1" cellpadding="1" class="borde_tab" style="display : none;">
	<tr valign="middle">
		<td class="titulos5" width="15%" align="right">
			<span class="titulos5">Fecha: dd/mm/aaaa</span>
		</td>
                <td class="listado5" width="15%">
                    <label for="fechproc1" style="display:none">Dia</label>
                    <input name="fechproc1" type="text"  readonly="true" title="Campo de fecha actual que indica el dia" id="fechproc1" size="2" maxlength="2" value="<?php echo $ddate; ?>" class="tex_area">/
                    <label for="fechproc2" style="display:none">Mes</label>
                    <input name="fechproc2" type="text"  readonly="true" id="fechproc2" size="2" maxlength="2" title="Campo de fecha actual que indica el mes"value="<?php echo $mdate; ?>" class="tex_area">/
                    <label for="fechproc3" style="display:none">Anho</label>
                    <input name="fechproc3" readonly="true" type="text" id="fechproc3" size="4" maxlength="4" title="Campo de fecha actual que indica el año" value="<?php echo $adate; ?>" class="tex_area">
                </td>
                <td width="15%" class="titulos5" align="right">
                    <font color="" class="titulos5"><label for="fecha_gen_doc" class="titulo5">Fecha Doc. dd/mm/aaaa</label> </font>
                </td>
		<td width="15%" class="listado5">
			<script language="javascript">
				dateAvailable1.date = "<?=date('Y-m-d');?>";
				dateAvailable1.writeControl();
				dateAvailable1.dateFormat="dd-MM-yyyy";
                              
			</script>
		</td>
		<td width="15%" class="titulos5" align="right"><label for="cuentai">Cuenta Interna, Oficio, Referencia</label></td>
		<td width="15%" class="listado5">
			<input name="cuentai" id="cuentai" type="text"  maxlength="20" class="tex_area" title="Campo para agregar una cuenta interna, un oficio o una referencia " value='<?php echo $cuentai; ?>' >
	</td>
	</tr>
</table>
<table width="600" border="0" cellspacing="0" cellpadding="0" style="display : none;">
	<tr>
	<td height="0"> <input name="VERIFICAR" type='hidden' class="ebuttons2" value="Verifique Radicaci&oacute;n">
	</td>
	</tr>
</table>
  
<table width="90%" align="center" border="0" cellspacing="0" cellpadding="0">
<!--	<tr valign="bottom">
		<td>-->
		<!--<table width="99%" align="center" border="0" cellspacing="0" cellpadding="0"> Pendiente por verificacion para eliminiacion-->
		<!--<tr>-->
		<?
			//Modificado skina 20170331
			//if($ent!=2) $img_remitente = "destinatario"; else $img_remitente = "remitente";
			if($ent==2 or $ent==7 or $ent==$tipoRadicadoPqr) $img_remitente = "remitente"; 
				else $img_remitente = "destinatario"; 
			
			?>
<!--	<td valign="bottom" > Pendiente por verificacion para eliminiacion
	</td>-->
		<?
		/* Modificado skina 020709
		if($ent!=2) $busq_salida="true"; 
		else  $busq_salida="";*/
		if($ent==2 or $ent==7 or $ent==$tipoRadicadoPqr) $busq_salida = ""; 
		else  $busq_salida="true";
	?>
		<!--</tr> Pendiente por verificacion para eliminiacion 13/02/2017 --> 
		<!--</table>-->
<!--		</td>
	</tr>-->
	<tr valign="top">
	<td>
<div class="tabber" id="tab1" border="1">
<?php
 for($i=1;$i<=1;$i++)
{

if($i==1)                 //  variables a llenar ene l formulario de radicación.
	{
$nombre = $nombre_us1;  
$documento = $documento_us1;
$papel = $prim_apel_us1;
$grbNombresUs1 = trim($nombre_us1) . " " . trim($prim_apel_us1) . " ". trim($seg_apel_us1);
$sapel = $seg_apel_us1;
$tel = $telefono_us1;
$dir = $direccion_us1;
$mail = $mail_us1;
$muni = $muni_us1;
$codep = $codep_us1;
$idp = $idpais1;
$idc = $idcont1;
$tipo = $tipo_emp_us1;
$cc_documento = $cc_documento_us1;
$otro = $otro_us1;
}
if($i==2)
{
$nombre = $nombre_us2;
$documento = $documento_us2;
$cc_documento = $cc_documento_us2;
$papel = $prim_apel_us2;
$sapel = $seg_apel_us2;
$grbNombresUs2 = trim($nombre_us2) . " " . trim($prim_apel_us2) . " ". trim($seg_apel_us2);
$tel = $telefono_us2;
$dir = $direccion_us2;
$mail = $mail_us2;
$muni = $muni_us2;
$codep = $codep_us2;
	$idp = $idpais2;
	$idc = $idcont2;
$tipo = $tipo_emp_us2;
$otro = $otro_us2;
}
if($i==3)

{
$nombre = $nombre_us3;
$documento = $documento_us3;
$cc_documento = $cc_documento_us3;
$grbNombresUs3 = trim($nombre_us3) . " " . trim($prim_apel_us3) . " ".trim($seg_apel_us3);
$papel = $prim_apel_us3;
$sapel = $seg_apel_us3;
$tel = $telefono_us3;
$dir = $direccion_us3;
$mail = $mail_us3;
$muni = $muni_us3;
$codep = $codep_us3;
	$idp = $idpais3;
	$idc = $idcont3;
$tipo = $tipo_emp_us3;
$otro = $otro_us3;
}
if($tipo==1 or $i==3)
{
$lbl_nombre = "Raz&oacute;n Social";
$lbl_apellido = "Sigla";
	$lbl_nombre2 = "Rep. Legal";
}
else
{
$lbl_nombre = "Nombres";
$lbl_apellido = "Primer Apellido";
$lbl_nombre2 = "Segundo Apellido";
}
$bloqEdicion="";
if ($i==3){
	$bloqEdicion = "readonly='true'";
}


$titulo = $tip3Nombre[$i][$ent];
if(!$titulo)  $titulo = "?? $i";
?>

<div class="tabbertab" title="<?=$titulo?>">
    
    <table width=100%  border='1' name='pes<?= $i ?>' id='pes<?= $i ?>' class="borde_tab" align="center" cellpadding="0" cellspacing="1">
        <!--<th style="color:#E0E6E7">Tabla5:Informacion de usuario</th>-->
            <tr class="listado2">
                <td colspan="5">
                    <!--  completado  automatico-->
                    <table class='borde_tabReducido' border='0'>
                        <!--<div class="demo"> clases demo y ui-widget no confirmado interaccion por javascript (por eso no eliminadas) --> 
                            <tr>
                                <b>BUSCAR:</b>
                                <!--<div class="ui-widget">-->
                                    <td>
                                        <label for="birds">Nombre:</label>
                                    </td>
                                    <td>
                                        <input id="birds" size="40" name="birds" title="Campo para buscar usuario por nombre, debe digitar minimo 3 caracteres para la busqueda, para buscar entre las coincidencias use las flechas arriba y abajo" aria-autocomplete="list" aria-haspopup="true" aria-owns="ui-autocomplete-instance" type="text">(Mínimo 3 caracteres)
                                                                        <!-- <input type="button" value="Enviar"" onclick="xajax_datos_usuario(xajax.getFormValues('formulario'))">-->
                                    </td>
                                <!--</div>--> 
                            </tr>      
                            <!-- suscriptor empopasto -->
                            <tr>
                                <!--<div class="ui-widget">-->
                                    <!--<td>
                                        <label for="birds1">Identificación:</label> DESACTIVADO PARA SHT
                                    </td>
                                    <td>
                                        <input id="birds1" size="40" onkeypress="return isNumberKey(event)" title="Campo para ingresar el codigo de identificación" />(Digite el número y presione la tecla Enter)
                                    </td>-->
                                <!--</div>-->
                            </tr>  <!--
-->                            <tr>
                                <!--<div class="ui-widget">-->
<!--                                    <td>
                                        <label for="birds3">Suscriptor:</label>
                                    </td>
                                    <td>
                                        <input id="birds3" size="40" onkeypress="return isNumberKey3(event)" title="Campo para ingresar el codigo del suscriptor" />(Digite el número y presione la tecla Enter)
                                    </td>-->
                                <!--</div>-->
                            </tr>
                        <!--</div>-->
                    </table>
                </td>
             </tr>  
             <tr>
            <td class="listado1"  align="right"><label for="cc_documento_us1">Documento</label></td>
            <td bgcolor="#FFFFFF"  class="listado2">
                <input type=text name='cc_documento_us<?= $i ?>' value='<?= $cc_documento ?>'readonly="true" id="cc_documento_us1" class="tex_area" title="Campo que contiene el documento de identificacion del usuario o suscriptor buscado">
                <label for="documento_us1" style="display:none">xx</label>
                <input type=hidden name='documento_us<?= $i ?>' value='<?= $documento ?>' readonly="true" id="documento_us1" class="tex_area" size="1">
            </td>
            <td class="listado1"  align="right"><font class="etextomenu"><label for="tipo_emp_us1">Tipo</label></font></td>
            <td widt h="45%"  bgcolor="#FFFFFF" class="listado2">
                <select name="tipo_emp_us<?= $i ?>" class="select"  tabindex="-1" id="tipo_emp_us1" title="Lista desplegable que contiene los tipos de usuario" >
                    <?
                    if ($i == 1) {
                        if ($tipo_emp_us1 == 0) {
                            $datos = " selected ";
                        } else {
                            $datos = "";
                        }
                    }
                    if ($i == 2) {
                        if ($tipo_emp_us2 == 0) {
                            $datos = " selected ";
                        } else {
                            $datos = "";
                        }
                    }
                    if ($i == 3) {
                        if ($tipo_emp_us3 == 0) {
                            $datos = " selected ";
                        } else {
                            $datos = "";
                        }
                    }
                    ?>
                    <option value=0 '<?= $datos ?>'>USUARIO</option>
    <?
    if ($i == 1) {
        if ($tipo_emp_us1 == 1) {
            $datos = " selected ";
        } else {
            $datos = "";
        }
    }
    if ($i == 2) {
        if ($tipo_emp_us2 == 1) {
            $datos = " selected ";
        } else {
            $datos = "";
        }
    }
    if ($i == 3) {
        if ($tipo_emp_us3 == 1) {
            $datos = " selected ";
        } else {
            $datos = "";
        }
    }
    ?>
                    <option value=1 '<?= $datos ?>'>TERCEROS </option>
                    <?
                    if ($i == 1) {
                        if ($tipo_emp_us1 == 2) {
                            $datos = " selected ";
                        } else {
                            $datos = "";
                        }
                    }
                    if ($i == 2) {
                        if ($tipo_emp_us2 == 2) {
                            $datos = " selected ";
                        } else {
                            $datos = "";
                        }
                    }
                    if ($i == 3) {
                        if ($tipo_emp_us3 == 2) {
                            $datos = " selected ";
                        } else {
                            $datos = "";
                        }
                    }
                    ?>
                    <option value=2 '<?= $datos ?>'>EMPRESAS  </option>
                    <?
                    if ($i == 1) {
                        if ($tipo_emp_us1 == 6) {
                            $datos = " selected ";
                        } else {
                            $datos = "";
                        }
                    }
                    if ($i == 2) {
                        if ($tipo_emp_us2 == 6) {
                            $datos = " selected ";
                        } else {
                            $datos = "";
                        }
                    }
                    if ($i == 3) {
                        if ($tipo_emp_us3 == 6) {
                            $datos = " selected ";
                        } else {
                            $datos = "";
                        }
                    }
                    ?>
                    <option value=6 '<?= $datos ?>'>FUNCIONARIOS  </option>
                </select>
            </td>
            <td align="right" class="listado2" style="text-align: center;">
    <?php if ($_SESSION["usua_perm_agrcontacto"] == 1) { ?>
                    <!--botom  BUSCAR -->
                    <input type="button" name="Button" value="Agregar usuario" class="botones" onClick="Start('buscar_usuario.php?&nombreTp1=<?= $nombreTp1 ?>&nombreTp2=<?= $nombreTp2 ?>&nombreTp3=<?= $nombreTp3 ?>&busq_salida=<?= $busq_salida ?>&ent=<?= $ent ?>',1024,400);" align="right">
                    <input type='hidden' name='depende22' value="<?php echo $depende; ?>">
            <?php } ?>
            </td>
            </tr>
            <tr class=e_tablas>
                <td width="13%" class="listado1" align="right"> <font class="etextomenu"><label for="nombre_us1"><?= $lbl_nombre ?></label></font>
                </td>
                <td width="30%" class="listado2">
                    <INPUT type=text id="nombre_us1" title="Campo que se autocompleta con el nombre completo del usuario o suscriptor buscado"  name='nombre_us<?= $i ?>' value='<?= $nombre ?>' 
                           class="tex_area" size=40 readonly="true">
                </td>
                <td width="10%" class="listado1" align="right">
                    <font class="etextomenu">
                    <label for="prim_apel_us1"> <?= $lbl_apellido ?></label></font>
                </td>
                <td colspan="2"  class="listado2">
            <?
            if ($i == 4) {
                $ADODB_COUNTRECS = true;
                $query = "select PAR_SERV_NOMBRE,PAR_SERV_CODIGO FROM PAR_SERV_SERVICIOS order by PAR_SERV_NOMBRE";
                $rs = $db->conn->query($query);
                $numRegs = "! " . $rs->RecordCount();
                $varQuery = $query;
                print $rs->GetMenu2("sector_us$i", "sector_us$i", "0:-- Seleccione --", false, "", "onChange='procEst(formulario,18,$i )' class='ecajasfecha'");
                $ADODB_COUNTRECS = false;
                ?>
                        <select name="sector_us<?= $i ?>" class="select">
                        <?
                        while (!$rs->EOF) {
                            $codigo_sect = $rs->fields["PAR_SERV_CODIGO"];
                            $nombre_sect = $rs->fields["PAR_SERV_NOMBRE"];
                            echo "<option value=$codigo_sect>$nombre_sect</option>";
                            $rs->MoveNext();
                        }
                        ?>
                        </select>
                        <?
                    } else {
                        ?>
                        <INPUT type=text name='prim_apel_us<?= $i ?>' value='<?= $papel ?>' class="tex_area" id="prim_apel_us1" readonly="true"  size="35" title="Campo que se autocompleta con el primer apellido del usuario o suscriptor buscado">
                        <?
                    }
                    ?>
                </td>
            </tr>
            <tr class=e_tablas>
                <td width="10%" class="listado1"  align="right"><font class="etextomenu"><label for="seg_apel_us1"><?= $lbl_nombre2 ?></label></font></td>
                <td width="30%" bgcolor="#FFFFFF" class="listado2">
                    <input type=text name='seg_apel_us<?= $i ?>' value='<?= $sapel ?>'  readonly="true" id="seg_apel_us1"  class="tex_area" size=40 title="Campo que se autocompletaa con el segundo apellido del usuario o suscriptor buscado">
                </td>
                <td width="10%" class="listado1"  align="right"><font class="etextomenu" ><label for="telefono_us1">Tel&eacute;fono</label>
                    </font></td>
                <td  colspan="2" bgcolor="#FFFFFF"  class="listado2">
                    <input type=text name='telefono_us<?= $i ?>' value='<?= $tel ?>' <?= $bloqEdicion ?> class="tex_area"id="telefono_us1"  size=35 title="Campo que se autocompleta con el telefono del usuario o suscriptor buscado">
                </td>
            </tr>
            <tr class=e_tablas>
                <td width="10%" class="listado1"  align="right"><font class="etextomenu"><label for="direccion_us1">Direcci&oacute;n</label>
                    </font>
                </td>
                <td width="30%" bgcolor="#FFFFFF"  class="listado2">
                    <INPUT type=text  name='direccion_us<?= $i ?>' value='<?= $dir ?>' <?= $bloqEdicion ?> class="tex_area" id="direccion_us1" size=40 title="Campo que se autocompleta con la direccion del usuario o suscriptor consultado">
                </td>
                <td width="10%" class="listado1"  align="right"><font class="etextomenu"><label for="mail_us1">Mail</label>
                    </font></td>
                <td  colspan="2" bgcolor="#FFFFFF"  class="listado2">
                    <INPUT id="mail_us1" type=text name='mail_us<?= $i ?>' value='<?= $mail ?>' <?= $bloqEdicion ?> class="tex_area" size=35 title="Campo que se autocompleta con el correo electronico del usuario o suscriptor buscado">
                </td>
            </tr>
    <?
    if ($i != 3) {
        ?>
                <tr class=e_tablas>
                    <td width="13%" class="listado1"  align="right" ><label>Dignatario</label></td>
                    <td bgcolor="#FFFFFF"  class="listado2" colspan="4">
                        <?php
                        //$otro = htmlspecialchars(stripcslashes($otro));
                        //if (!($v1 || $v2) && (strlen(trim($otro))>0)) $otro = "'".$otro."'"; else $otro=$db->conn->qstr($otro);
                        ?>
                        <INPUT type='text' name='otro_us<?= $i ?>' title="Campo para el ingreso de dignatario si existe" value="<?php echo htmlspecialchars(stripcslashes($otro)); ?>" class='tex_area' size='80' maxlength='50'>
                    </td>
                </tr>
                        <?
                    }
                    ?>
            <tr class=e_tablas>
                <td width="10%" class="listado1"  align="right"><font class="etextomenu"><label for="idcont1">Continente</label></font></td>
                <td width="20%" bgcolor="#FFFFFF"  class="listado2">
                    <?php
                    /*  En este segmento trabajaremos macrosusticiï¿½n, lo que en el argot php se denomina Variables variables.
                     * 	El objetivo es evitar realizar codigo con las mismas asignaciones y comparaciones cuya diferencia es el
                     * 	valor concatenado de una variable + $i.
                     */
                    $var_cnt = "idcont" . $i;
                    $var_pai = "idpais" . $i;
                    $var_dpt = "codep_us" . $i;
                    $var_mcp = "muni_us" . $i;

                    /* 	Se crean las variables cuyo contenido es el valor por defecto para cada combo, esto segï¿½n el siguiente orden:
                     * 	1. Se pregunta si existe idcont1, idcont2 e idcont3 (segï¿½n iteracciï¿½n del ciclo), si es asï¿½ se asigna a $contcodi.
                     * 	2. Sino existe (osea que no viene de buscar_usuario.php) se pregunta si existe "localidad" y se asigna el
                     * 	   respectivo cï¿½digo; de ser negativa la "localidad", $contcodi toma el valor de 0. Esto para cada
                     * 	   variable de continente, pais, dpto y mncpio respectivamente.
                     */

                    (${$var_cnt}) ? $contcodi = ${$var_cnt} : ($_SESSION['cod_local'] ? $contcodi = (substr($_SESSION['cod_local'], 0, 1) * 1) : $contcodi = 0 );
                    (${$var_pai}) ? $paiscodi = ${$var_pai} : ($_SESSION['cod_local'] ? $paiscodi = (substr($_SESSION['cod_local'], 2, 3) * 1) : $paiscodi = 0 );
                    (${$var_dpt}) ? $deptocodi = ${$var_dpt} : ($_SESSION['cod_local'] ? $deptocodi = $paiscodi . "-" . (substr($_SESSION['cod_local'], 6, 3) * 1) : $deptocodi = 0 );
                    (${$var_mcp}) ? $municodi = ${$var_mcp} : ($_SESSION['cod_local'] ? $municodi = $deptocodi . "-" . (substr($_SESSION['cod_local'], 10, 3) * 1) : $municodi = 0 );

                    //	Visualizamos el combo de continentes.
                    echo $Rs_Cont->GetMenu2("idcont$i", $contcodi, "0:<< seleccione >>", false, 0, " id=\"idcont$i\" CLASS=\"select\" TITLE=\"Lista desplegable con continentes, cambia automaticamente una vez el nombre o suscriptor es consultado\" onchange=\"cambia(this.form, 'idpais$i', 'idcont$i')\" ");
                    $Rs_Cont->Move(0);
                    ?>
                </td>
                <td width="10%" class="listado1"  align="right"><font class="etextomenu"><label for="idpais1">Pa&iacute;s</label></font></td>
                <td  colspan="2" bgcolor="#FFFFFF"  class="listado2">
    <?php
    //	Visualizamos el combo de paises.
    echo "<SELECT NAME=\"idpais$i\" ID=\"idpais$i\" TITLE=\"Lista desplegable con paises, cambia automaticamente una vez el nombre o suscriptor es consultado\" CLASS=\"select\" onchange=\"cambia(this.form, 'codep_us$i', 'idpais$i')\">";
    while (!$Rs_pais->EOF and ( !$Submit4)) {
        if ($Rs_pais->fields['id0'] == $contcodi) { //Si hay local Y pais pertenece al continente.
            ($paiscodi == $Rs_pais->fields['id1']) ? $s = " selected='selected'" : $s = "";
            echo "<option" . $s . " value='" . $Rs_pais->fields['id1'] . "'>" . $Rs_pais->fields['nombre'] . "</option>";
        }
        //var_dump($Rs_pais);
        $Rs_pais->MoveNext();
    }
    echo "</SELECT>";
    $Rs_pais->Move(0);
    ?>	</td>

            <tr >
                <td width="10%" class="listado1"  align="right"><font class="etextomenu"><label for="codep_us1">Departamento</label></font>
                </td>
                <td width="20%" bgcolor="#FFFFFF"  class="listado2">
    <?php
    echo "<SELECT NAME=\"codep_us$i\" ID=\"codep_us$i\" CLASS=\"select\" TITLE=\"Lista desplegable con departamentos, cambia automaticamente una vez el nombre o el suscriptor es consultado\" onchange=\"cambia(this.form, 'muni_us$i', 'codep_us$i')\">";
    while (!$Rs_dpto->EOF and ( !$Submit4)) {
        if ($Rs_dpto->fields['id0'] == $paiscodi) { //Si hay local Y dpto pertenece al pais.
            ($deptocodi == $Rs_dpto->fields['id1']) ? $s = " selected='selected'" : $s = "";
            echo "<option" . $s . " value='" . $Rs_dpto->fields['id1'] . "'>" . $Rs_dpto->fields['nombre'] . "</option>";
        }
        $Rs_dpto->MoveNext();
    }
    echo "</SELECT>";
    $Rs_dpto->Move(0);
    //echo $Rs_dpto;
    ?>
                </td>
                <td width="10%" class="listado1"  align="right"><font class="etextomenu"><label for="muni_us1">Municipio</label></font></td>
                <td  colspan="2" bgcolor="#FFFFFF"  class="listado2">
    <?php
    echo "<SELECT NAME=\"muni_us$i\" ID=\"muni_us$i\" TITLE=\"Lista desplegable con municipios, cambia automaticamente una vez el nombre o el suscriptor es consultado\" CLASS=\"select\">";
    while (!$Rs_mcpo->EOF and ( !$Submit4)) {
        if ($_SESSION['cod_local']) { //Si hay local
            ($municodi == $Rs_mcpo->fields['id1']) ? $s = " selected='selected'" : $s = "";
            echo "<option" . $s . " value='" . $Rs_mcpo->fields['id1'] . "'>" . $Rs_mcpo->fields['nombre'] . "</option>";
        }
        $Rs_mcpo->MoveNext();
    }
    echo "</SELECT>";
    $Rs_mcpo->Move(0);
    //echo $Rs_mcpo;


    $municodi = 0;
    $muninomb = "";
    $deptocodi = 0;
    ?>
                </td>
            </tr>
        </table>
</div>

<?
}
unset($contcodi);
unset($paiscodi);
unset($deptocodi);
unset($municodi);
?>
</div>
<br>
<table width=100% border="1" class="borde_tab">
<!--<th style="color:#E0E6E7">Tabla6:Asunto</th>-->
	<tr>
            <td  class="listado1" style="width:11.2%;"> <font color="" class="etextomenu"><label for="asu">Asunto</label>
		</font></td>
            <td width="75%" class="listado2" style="text-align: center;">
            <textarea id="asu" name="asu" cols="100" class="tex_area" title="Area de texto para escribir el asunto del radicado" maxlength="349" rows="2" ><?php echo htmlspecialchars(stripcslashes($asu)); ?></textarea>
	</td>
	</tr>
</table>
            <br>
<table width=100% border="1" cellspacing="1" cellpadding="1" class="borde_tab" align="center">
<!--<th style="color:#E0E6E7">Tabla7:Medios de envio-recepcion</th>-->
	<!--DWLayoutTable-->
    <tr>
        <td width="25%"  class="listado1"> <font class="etextomenu"><label for="tdoc">Tipo Doc</label></font>
        </td>
        <td width="25%" valign="top" class="listado2"> <font color="">
            <input name="hoj" type=hidden value="<? echo $hoj; ?>">
            <?php
            $query = "select SGD_TPR_DESCRIP
     ,SGD_TPR_CODIGO 
    from SGD_TPR_TPDCUMENTO 
    WHERE SGD_TPR_TP$ent='1'
     and SGD_TPR_RADICA='1' 
    ORDER BY SGD_TPR_DESCRIP ";
            $opcMenu = "0:-- Seleccione un tipo --";
            $fechaHoy = date("Y-m-d");
            $fechaHoy = $fechaHoy . "";
            $ADODB_COUNTRECS = true;
//$db->conn->debug=true;
            $rs = $db->conn->query($query);
            if ($rs && !$rs->EOF) {
                $numRegs = "!" . $rs->RecordCount();
                $varQuery = $query;
                print $rs->GetMenu2("tdoc", $tdoc, "$opcMenu", false, "", "class='selectReducido' onChange='typeDoc()' id='tdoc' title='Lista con tipos de dpcumentos'");
            } else {
                $tdoc = 0;
            }
            $ADODB_COUNTRECS = false;
            ?>
            </font>
        </td>
        
        <td width="25%" class="listado1" >
            <font color="" class="etextomenu">
            <?
            //by skina agregamos ent==4
            if ($ent == 2 or $ent == 7 or $ent == 4) {
                echo "<label for='med'>Medio Recepción</label>";
            } else {
                echo "<label for='med'>Medio Envío</label>";
            }
            /** Si la variable $faxPath viene significa que el tipo de recepcion es fax
             * Por eso $med se coloca en 2
             */
            if ($faxPath)
                $med = 2;
            if ($tipoMedio)
                $med = 4;
            ?>
            </font>
        </td>
        <td width="25%" valign="top" class="listado2"><font color="">
            <?
            $query = "Select MREC_DESC, MREC_CODI from MEDIO_RECEPCION ";
            $rs = $db->conn->query($query);
            $varQuery = $query;
            if ($rs) {
                print $rs->GetMenu2("med", $med, "$opcMenu", false, "", "class='select' title='Lista desplegable con medios de envío o recepción' id='med'");
            }
            ?>
            </font>
        </td>

        <!-- Agregado empopasto, modificacion dias de termino -->
        <td width="25%"  class="listado1" align="right"> 
            <font class="etextomenu"><label for="birds2">Días de Término: </label></font></td>
        <td width="25%" align="right" class="listado2"><input id="birds2"title="Ingresar numero de dias de vencimiento del radicado" name="birds2" onkeypress="return isNumberKey2(event)" maxlength="2" size="2" value="<?= $birds22 ?>">
        </td>
</tr>
</table>
<br>

<table width=100% border="1" cellspacing="1" cellpadding="1" class="borde_tab" align="center">
<!--<th style="color:#E0E6E7">Tabla8:Descripcion de anexos y dependencias</th>-->
<!--DWLayoutTable-->



<tr>
		<td  class="listado1" width="25%" align="right"> <font color="" class="etextomenu">
		<label for="ane">Desc Anexos</label></font>
		</td>
		<td width="75%" class="listado2"><font color="">
		<input name="ane" id="ane" type="text" title="Campo para agregar descripcion de los anexos" size="70" class="tex_area" maxlength="200" value="<?php echo htmlspecialchars(stripcslashes($ane));?>">
		</font>
	</tr>

   <!--
      /** Modificado Supersolidaria 01-Nov-2006
        * Datos del funcionario que tiene a cargo una entidad y la dependencia a la
        * que pertenece.
        */
    -->
    <?php
        switch( $db->entidad )
        {
            case 'SES':
    ?>
                <tr>
                    <td  class="listado1" width="25%" align="right">
                      <font color="" class="etextomenu">
                        Funcionario Encargado
                      </font>
                    </td>
                    <td width="75%" class="listado2">
                      <font color="">
                        <input name="supervisor_us" type="text" size="80" class="tex_area" value="<?=$supervisor_us;?>" readonly>
                      </font>
                    </td>
                </tr>
    <?php
                break;
        }
    ?>

<tr>
	<td class="listado1" width="25%" align="right"><font color="" class="etextomenu">
	<label for="coddepe">Dependencia</label></font>
	</td>
	<td colspan="3" width="75%" class="listado2">
    <font color="">
    <?
// Busca las dependencias existentes en la Base de datos...
if($radi_depe_actu_padre and $tipoanexo==0 and !$coddepeinf)  $coddepe = $radi_depe_actu_padre;
	if(!$coddepe)
	{
		$coddepe=$dependencia;
	}
	/** Solo los documentos de entrada (ent=2) muestra la posibilidad de redireccion a otras dependencias
		* @queryWhere String opcional para la consulta.
		*/
	/**if($ent!=2)
	{
		$queryWhere =" where depe_codi=$dependencia";
	}
	else
	{
		$queryWhere = "";
	}***/


//modificado por skina  para indupalma  por edd2
if($Submit3=="ModificarDocumentos"){
        $depende=false;
        $radi_usua_actu=$usua_select;
}
                if($depende) {
                       $queryWhere=" where depe_codi='$depende' and depe_estado = 1";
                }elseif($ent==2 or $ent==7 or $ent==$tipoRadicadoPqr) {
                       $queryWhere =" where depe_estado = 1 ";
                }else{
			$queryWhere = " where depe_codi='$coddepe' and depe_estado = 1 ";
                }

	// Modificado SGD 11-Jul-2007
	//$query = "select DEPE_NOMB,DEPE_CODI from dependencia $queryWhere order by depe_nomb";
	switch( $GLOBALS['entidad'] )
	{
		case 'SGD':
			$query = "SELECT ".$db->conn->Concat( "DEPE_CODI", "'-'", "DEPE_NOMB" ).", DEPE_CODI
			FROM DEPENDENCIA
			$queryWhere
			ORDER BY DEPE_CODI, DEPE_NOMB";
			break;
		
		default://query  para  modificar1
			$query = "select  DEPE_NOMB,DEPE_CODI from dependencia $queryWhere order by depe_nomb";
	}

	$ADODB_COUNTRECS = true;
        $rs=$db->conn->query($query);
	$numRegs = "!".$rs->RecordCount();
	$varQuery = $query;
        $comentarioDev = "Muestra las dependencias";
        //Modificado IDRD 7-May-2008 para diferencias entre ent=2 o ent=1
        //print $rs->GetMenu2("coddepe", $coddepe, "0:-- Seleccion una Dependencia --", false,"","class='select'");
//      if ($ent!=2 and !$Submit3=="ModificarDocumentos")  //edd modificacion
           if ($ent!=2 and $ent!=7 and $ent!=4 and !$Submit3=="ModificarDocumentos") {
                        print $rs->GetMenu2("coddepe",$coddepe, "0:-- Seleccione  una Dependencia --", false," id='coddepe' class='select'");
	   } else{
              
	       if(!isset($_POST['coddepe'])){
		   if($coddepe == ''){
                  	 print $rs->GetMenu2("coddepe","", "0:-- Seleccione  una Dependencia --", false,"id='coddepe' class='select' onchange='recargar2();'");
		   }else{
                    	print $rs->GetMenu2("coddepe",$coddepe, "0:-- Seleccione  una Dependencia --", false,"id='coddepe' class='select' onchange='recargar2();'");
                   }
	       } else{
			print $rs->GetMenu2("coddepe",$coddepe, "0:-- Seleccione  una Dependencia --", false," id='coddepe' class='select'"); 
	       }
//print $rs->GetMenu2("coddepe","", "0:-- Seleccione  una Dependencia --", false,false,"class='select' id='coddepe' onchange='recargar2();' title='Lista con las dependencias de la organizacion' ");
        } 
    $ADODB_COUNTRECS = false;

?>
<div id="recargado" align="left"></div>
    </font>
</td>
</tr>
    <?
// Comprueba si el documento es una radicaci�n nueva de entrada....
if($tipoanexo==0 and $radicadopadre and !$radicadopadreseg and (!$Submit3  and !$Submit4))
{
	?>
<tr>
	<td class="listado1" width="25%" align="right"><font color="" class="etextomenu">
	Usuario Destino
	</font>
	</td>
	<td colspan="3" width="75%" class="listado2">
<?
	if($radi_depe_actu_padre==999)
	{
		echo "<font color=red >Documento padre se encuentra en Archivo</font>";
	}
	elseif($radi_depe_actu_padre and $rad0)
	{
		$query= "select USUA_NOMB, USUA_CODI from usuario where depe_codi='$radi_depe_actu_padre' and usua_codi=$radi_usua_actu_padre";
		$ADODB_COUNTRECS = true;
    //$db->conn->debug = true;
		$rs=$db->conn->query($query);
		$numRegs = "!".$rs->RecordCount();
		$ADODB_COUNTRECS = false;
		$varQuery = $query;
		$comentarioDev = "Muestra las dependencias";
		$usuario_padre = $rs->fields["USUA_NOMB"];
		$cod_usuario_inf = $rs->fields["USUA_CODI"];
		echo "$usuario_padre";
			$coddepeinf = $radi_depe_actu_padre;
			$informar_rad = "Informar";
			$observa_inf = "(Se ha generado un anexo pero ha sido enviado a la dependencia $coddepe)";
?>
		<input type=hidden name=radi_depe_actu_padre value="<?=$radi_depe_actu_padre?>">
		<input type=hidden name=coddepeinf value="<?=$coddepeinf?>">
		<input type=hidden name=cod_usuario_inf value="<?=$cod_usuario_inf?>">
		<?
	}
	?>
</td>
</tr>
<?
}
	?>
	<tr align="center">
	<td height="23" colspan="4" class="listado2"> <font color="">
<?
//echo "Dependencia - Usuario Actual  $coddepe, $dependencia / $radi_usua_actu, $cod_usuario_inf, $codusuario";
include "$ruta_raiz/include/tx/Tx.php";
include("../include/tx/Radicacion.php");
include("../class_control/Municipio.php");
$hist = new Historico($db);
$Tx = new Tx($db);

if($Submit3=="Radicar")
{
	$ddate=date("d");
	$mdate=date("m");
	$adate=date("Y");
	$fechproc4=substr($adate,2,4);
	$fechrd=$ddate.$mdate.$fechproc4;
	if($fechproc12=='')
	{	$fechproc12=date('d');
	$fechproc22=date('m');
	$fechproc32=date('y');
	}
	//$fechrdoc=$fechproc12."-".$fechproc22."-".$fechproc32;
	$fechrdoc=$fecha_gen_doc;
	$apl .="";$apl=trim(substr($apl,0,50));
	$sapl .="";$sapl=trim(substr($sapl,0,50));
	$pnom .="";$pnom =trim(substr($pnom,0,89));
	$adress .="";
	$tip_rem +=0;
	$tip_doc +=0;
	$numdoc .='';$numdoc =trim(substr($numdoc,0,13));
	$long=strlen($cod);
	$codep +=0;
	$tel +=0;
	$cod +=0;
	$radicadopadre .='';
	$asu.='';
	$tip_rem=$tip_rem-1;
	$rem2.='';
	$dep +=0;
	$hoj +=0;
	$codieesp +=0;
	$ane .='';
	$med +=0;
	$acceso = 1;
	if($acceso==0)
	{}
	else
	{	if($tip_rem<0)
		{	$tip_rem=0;	}
		if(!$documento_us3)
		{	$documento_us3=0;	}
		/**  En esta linea si la dependencia es 999 ke es la dep. de salida envia el radicado a una
			*	 carpeta con el codigo de los dos primeros digitos de la dependencia
			*/
		/***by skina   if($ent != 2)
		{
			$carp_codi =$ent;
			$carp_per = "0";
			$radi_usua_actu = $codusuario;
		}
		else
		{
			$carp_codi ="0";
			$carp_per = "0";
			if($cod_usuario_inf!=1 and $coddepeinf==$coddepe)
			{
				$radi_usua_actu = $cod_usuario_inf;
			}
			else
			{
				$radi_usua_actu = 1;
			}
		}***/
	
		//Modificado skina 020709
		if($ent == 2 or $ent==7 or $ent==$tipoRadicadoPqr)
		{
			if ($ent==2) $carp_codi ="0";
			else $carp_codi=$ent;
                        $carp_per = "0";
                        if($cod_usuario_inf!=1 and $coddepeinf==$coddepe)
                        {
                                $radi_usua_actu = $cod_usuario_inf;
                        }
                        else
                        {
			//radicados tipo resoluciones quedaban en la bandeja del jefe de dep no del que los creo
                        //si usuario selecciona  algun usuario destino ese sera el usuario actual del radicado sino se ira a jefe de dep
                           $radi_usua_actu  = (!$usua_select)? $codusuario : $usua_select;
                                //$radi_usua_actu = 1;
                }    
		}
		else
		{

			$carp_codi =$ent;
                        $carp_per = "0";
                        $radi_usua_actu = $codusuario;

		}

		//Modificado skina 020709 sobreescribe los valores
		//if(!$radi_usua_actu and $ent == 2) $radi_usua_actu = $codusuario;
		//if(!$radi_usua_actu) $radi_usua_actu = 1;
		
			if($coddepe=='999')
			{
				$carp_codi=substr($dependencia,0,2);
				$carp_per=1;
				$radi_usua_actu = 1;
			}

		if(!$radi_usua_actu) $radi_usua_actu==1;
		if($radi_usua_actu_padre and $radi_depe_actu_padre)
		{
					$radi_usua_actu= "$radi_usua_actu_padre";
					$coddepe= "$radi_depe_actu_padre";
		}

		// Buscamos Nivel de Usuario Destino
		error_reporting(7);
	//	$db->conn->debug = true;
		$tmp_mun = new Municipio($db);
		$tmp_mun->municipio_codigo($codep_us1,$muni_us1);
		$rad = new Radicacion($db);
		$rad->radiTipoDeri = $tpRadicado;
		$rad->radiCuentai = "'".trim($cuentai)."'";
		$rad->eespCodi =  $documento_us3;
		$rad->mrecCodi =  $med; // "dd/mm/aaaa"
		$fecha_gen_doc_YMD = substr($fecha_gen_doc,6 ,4)."-".substr($fecha_gen_doc,3 ,2)."-".substr($fecha_gen_doc,0 ,2);
		$rad->radiFechOfic =  "'".$fecha_gen_doc_YMD."'";
		if(!$radicadopadre)  $radicadopadre = null;
		$rad->radiNumeDeri = trim($radicadopadre);
		$rad->radiPais =  $tmp_mun->get_pais_codi();
		$rad->descAnex = $ane;
		$rad->raAsun = $asu;
		// Modificado SGD 11-Jul-2007
		//$rad->radiDepeActu = $coddepe;
		//$rad->radiDepeRadi = $coddepe;
		$rad->radiDepeActu = "'".$coddepe."'";
		$rad->radiDepeRadi = "'".$dependencia."'";
		$rad->radiUsuaActu = $radi_usua_actu ;
		$rad->trteCodi =  $tip_rem;
		$rad->tdocCodi=$tdoc;
		$rad->tdidCodi=$tip_doc;
		$rad->carpCodi = $carp_codi;
		$rad->carPer = $carp_per;
		$rad->trteCodi=$tip_rem;
		$rad->ra_asun = htmlspecialchars(stripcslashes($asu)); // HLP Este si sirve? Para radicar se utiliza la variable $rad->raAsun (linea 1342)
		$rad->radiPath = 'null';
		if (strlen(trim($aplintegra)) == 0)
			$aplintegra = "0";
		$rad->sgd_apli_codi = $aplintegra;
		$codTx = 2;
		$flag = 1;

		$noRad = $rad->newRadicado($ent, $tpDepeRad[$ent]);
	if ($noRad=="-1")
		die("<hr><b><font color=red><center>Error no genero un Numero de Secuencia o Inserto el radicado<br>SQL </center></font></b><hr>");

	if(!$noRad) echo "<hr>RADICADO GENERADO <HR>$noRad<hr>";
	$radicadosSel[0] = $noRad;
	$hist->insertarHistorico($radicadosSel,  $dependencia , $codusuario, $coddepe, $radi_usua_actu, " ", $codTx);
	$nurad = $noRad;
	echo "<INPUT TYPE=HIDDEN NAME=nurad value=$nurad>";
	echo "<INPUT TYPE=HIDDEN NAME=flag value=$flag>";
	if($noRad)
	{
			$var_envio = session_name()."=".session_id()."&faxPath&leido=no&krd=$krd&verrad=$nurad&ent=$ent";
		?>
		</p><center><img src='../iconos/img_alerta_2.gif' title="Icono de alerta"><font face='Arial' size='3'><b>
		Se ha generado el radicado No.<b></font>
		<font face='Arial' size='4' color='red'><b><u>
		<?=$nurad?>
		</u></b></font><br>
		<font face='Arial' size='4' color='red'>
		<?
		if($faxPath)
		{
		$varEnvio = session_name()."=".session_id()."&faxPath&leido=no&krd=$krd&faxPath=$faxPath&nurad=$nurad&ent=$ent";
		?>
		<center>
		<input class="botones_largo" value ="SUBIR IMAGEN DE FAX" type=button target= 'UploadFax' onclick="window.open('uploadFax.php?<?=$varEnvio?>','Cargar Archivos de Fax', 'height=300, width=400,left=350,top=300')">
		</center>
		<?
		}
			/**Modificado skina para enviar correo en radicacion de entrada***/
		if( $ent==2 or $ent==7 or $ent==$tipoRadicadoPqr)
                {
                echo "<script>window.open('./mail.php?codusu=1&verrad=$nurad&asunto=$asu&nombre=$nombre_us1&apellido=$prim_apel_us1&fecha=$fecha_gen_doc&tx=Radicado', 'Modificacion_de_Datos', 'height=200,width=250,scrollbars=yes');</script>";
                }
/* Modificacion Skina                                                                                                           */
/* Se incluye la sentencia else para que abra ventana emergente para anexar "Documentos" cuando no sea entrada o Factura        */
/* Johnnatan Rodriguez Pinto                                                                                                    */
/* Mayo 2015                                                                                                                    */
/* jrodriguez@skinatech.com                                                                                                     */

		else{
                echo "<script>window.open('./mail.php?codusu=1&verrad=$nurad&asunto=$asu&nombre=$nombre_us1&apellido=$prim_apel_us1&fecha=$fecha_gen_doc&tx=Radicado', 'Modificacion_de_Datos', 'height=200,width=250,scrollbars=yes');</script>";

		echo "<script>window.open('../verradicado.php?verrad=$nurad&var_envio=$var_envio".$datos_envio."&datoVer=985&ruta_raiz=".$ruta_raiz."&menu_ver_tmp=2', 'Modificaciï¿½n_de_Datos', 'height=700,width=650,scrollbars=yes');</script>";
		}
/* Fin modificacion Skina                                                                                                       */

		//by skinatech, grabamos datos de dias de termino
		$mod=0;
		include_once "./grabar_dt.php";
		//echo "<script>window.open('radicado_n.php?nurad=$nurad&var_envio=$var_envio', 'ConfirmacionRad$nurad', 'height=260,width=430,left=350,top=300 ');</script>";
	/*  
	 *  Sitio en el cual se incluyen botones de acceso al boton de eMail para asociar archivos al radicado generado.
	 *@autor Orlando Burgos
	 *@fecha 2008
	 */
	      if($tipoMedio=="eMail") 
	      {
		$varEnvio = session_name()."=".session_id()."&nurad=$nurad"."&eMailMid=".$_GET['eMailMid']."&eMailPid=".$_GET['eMailPid'];
		?>
		<center>
		<input class="botones_largo" value ="ASOCIAR EMAIL A RADICADO" type=button target= 'UploadFax' onclick="window.open('../email/uploadMail.php?<?=$varEnvio?>','formulario', 'height=400, width=640,left=350,top=300')">
		</center>
	      <?
	      }
	}
	else
	{
		echo "<font color=red >Ha ocurrido un Problema<br>Verfique los datos e intente de nuevo</font>";
	}
	$sgd_dir_us2=2;
	$conexion = $db;
	error_reporting(7);
	include "grb_direcciones.php";
	$verradicado = $nurad;

	}
	echo  "<INPUT TYPE=HIDDEN NAME=nurad value=$nurad>";
	echo  "<INPUT TYPE=HIDDEN NAME=codusuarioActu value=$codusuarioActu>";
	echo  "<INPUT TYPE=HIDDEN NAME='codieesp' value='$codieesp'>";
	echo "<INPUT TYPE=HIDDEN NAME='flag' value='$flag'>";
}
$vector = $coddepeinf;
if($vector)
{
	error_reporting(0);
foreach ($vector as $key => $coddepeinf)
{

if( ($coddepeinf!=999) and ($Submit3 or $Submit4)  )
{
	$flag=0;
	//Modificado skina 020709
	//if(($coddepeinf!=$coddepe or ($cod_usuario_inf!=1 and $coddepeinf==$coddepe)) and $Submit3 and $ent==2)
	if(($coddepeinf!=$coddepe or ($cod_usuario_inf!=1 and $coddepeinf==$coddepe)) and $Submit3 and ($ent==2 or $ent==7 or $ent==$tipoRadicadoPqr))
	{

	/**
		* INFORMACION DE ENVIO DE UN RADICADO EL CUAL EL PADRE ESTA EN UNA DEPENDENCIA DIFERENTE
		* $observa_add   contiene el mensaje que se enviara al informado
		* El mensaje cambia dependiendo a la persona que va.
		* Si va a un funcinario le informa al jefe de lo contrario informa a la otra dependencia
		**/
	//Modificado skina 020709
	//if($cod_usuario_inf!=1 and $coddepeinf==$coddepe and $ent==2)
	if($cod_usuario_inf!=1 and $coddepeinf==$coddepe and ($ent==2 or $ent==7 or $ent==$tipoRadicadoPqr))
	{
		$observa_inf = "El documento Anexo del Radicado $radicadopadre se envio directamente al funcionario";
		$cod_usuario_inf = 1;
	}
	else
	{
		$observa_inf = "El documento Anexo del Radicado $radicadopadre se envio a la dep. $coddepe";
		$cod_usuario_inf = 1;
	}
	}
	else
	{
	if(!$Submit4)
	{
	$observa_add = "";
	$coddepeinf="";
	}
	}
	/** AQUI SE ENTRA A MODIFICAR EL RADICADO
	*
	*/

	if(( ($Submit4 and $coddepeinf!=$coddepe)) )
	{

	/**
	*	La siguiente decicion pregunta si la dependencia con la cual sale el radicado es
	* a misma que se pretende informar, ademas si es el jefe. En este caso no informa.
	*/
		$observa = "$observa_inf";
		if(!$cod_usuario_inf) $cod_usuario_inf=1;
		$nombTx = "Informar Documentos";
		$radicadoSel[0] = $nurad;
		// Modificado SGD 11-Jul-2007
		//$txSql = $Tx->informar($radicadoSel, $krd,$coddepeinf,$dependencia, $cod_usuario_inf,$codusuario, $observa, $_SESSION['usua_doc']);
//$db->conn->debug = true;

		$txSql = $Tx->informar($radicadoSel, $krd,"'".$coddepeinf."'","'".$dependencia."'", $cod_usuario_inf,$codusuario, $observa, $_SESSION['usua_doc']);
		$flagHistorico = true;
	}
}
}
}
$coddepeinf = $vector;
if($Submit4 and !$Buscar)
	{
	$secuens=str_pad($consec,6,"0",STR_PAD_LEFT);
	$fechproc4=substr($adate,2,4);
	$fechrd=$ddate.$mdate.$fechproc4;
	$fechrdoc=$fechproc12.$fechproc22.$fechproc32;
	$apl .=' ';$apl=trim(substr($apl,0,50));
	$sapl .=' ';$sapl=substr($sapl,0,50);
	$pnom .=' ';$pnom =substr($pnom,0,89);
	$adress .=' ';
	$tip_rem +=0;$tip_doc +=0;$numdoc .='';$numdoc =trim(substr($numdoc,0,13));
	$codieesp +=0;$radicadopadre +=0;$long=strlen($cod);
	$codep +=0;$tel +=0;$cod +=0;$asu.='';$tip_rem=$tip_rem-1;
	$rem2.='';
	$dep +=0;
	$hoj +=0;
	$ane .='';
	$med +=0;
	if($tip_rem<0)
	{
		$tip_rem=0;
	}
	if(!$documento_us3)
	{
		$documento_us3 = 0;
	}
	/**  En esta linea si la dependencia es 999 ke es la dep. de salida envia el radicado a una
		*	 carpeta con el codigo de los dos primeros digitos de la dependencia
		*/
	$carp_codi=$ent;
	$carp_per=0;
	if(!$radi_usua_actu) $radi_usua_actu = 1;
	if($coddepe==999)
	{
		$carp_codi=substr($dependencia,0,2);
		$carp_per=1;
		$radi_usua_actu = 1;
	}

	$rad = new Radicacion($db);
	$rad->radiTipoDeri = $tpRadicado;
	$rad->radiCuentai = "'$cuentai'";
	$rad->eespCodi =  $documento_us3;
	$rad->mrecCodi =  $med;
	$rad->radiFechOfic =  $fecha_gen_docF;
  $fecha_gen_doc_YMD = substr($fecha_gen_doc,6 ,4)."-".substr($fecha_gen_doc,3 ,2)."-".substr($fecha_gen_doc,0 ,2);
	$rad->radiFechOfic =  $fecha_gen_doc_YMD;

	if(!$radicadopadre)  $radicadopadre = null;
	$rad->radiNumeDeri = $radicadopadre;
	$rad->radiPais =  "'$pais'";
	$rad->descAnex = $ane;
	$rad->raAsun = $asu;
	$rad->radiDepeActu = $coddepe ;
	$rad->radiUsuaActu = $radi_usua_actu ;
	$rad->trteCodi =  $tip_rem;
	$rad->tdocCodi=$tdoc;
	$rad->tdidCodi=$tip_doc;
	$rad->carPer = $carp_per;
	$rad->trteCodi=$tip_rem;
	$rad->ra_asun = $asu;

	if (strlen(trim($aplintegra)) == 0)
		$aplintegra = "0";

	$rad->sgd_apli_codi = $aplintegra;
	$resultado = $rad->updateRadicado($nurad);
	$conexion = $db;
	include "grb_direcciones.php";
	if($resultado)
	{
		echo "<center><label class='alarmas alarmasOk'>Radicado No $nurad fue Modificado Correctamente, </label></center>";
		$radicadosSel[] = $nurad;
		$codTx = 11;
		$hist->insertarHistorico($radicadosSel,  $dependencia , $codusuario, $coddepe, $radi_usua_actu, "Modificacion Documento.", $codTx);
		
		//by skinatech, grabamos datos de dias de termino
		$mod=1;
		include_once "./grabar_dt.php";
	}
//$db->conn->debug = true;
if($borrarradicado)
{
	$flag=0;
	$observa = "Se borro de Inf. ($krd)";
	$depbrr = substr($borrarradicado,0,3);
	$fechbrr = substr($borrarradicado,3,20);
	$data6 = substr($borrarradicado,3,50);
	$radicadosSel [0] = $nurad;
	$nombTx = "Borrar Informados";
	$codTx = 7;
	//$txSql = $rs->borrarInformado( $radicadosSel, $krd,$depbrr,$dependencia,$usCodSelect, $codusuario);
	$isql_inf= "delete from informados where depe_codi='$depbrr' and radi_nume_radi='$nurad' and info_desc like '%$data6%'";
	$rs=$db->conn->query($isql_inf);
	$hist->insertarHistorico($radicadosSel,  $dependencia , $codusuario, $coddepe, $radi_usua_actu, $observa, $codTx);
		if($flag==1)
		{
			echo "No se ha borrado la inf. de la dependencia $depbrr<br>";
		}else
		{
			echo "<font color=red><center>Se ha borrado un Inf. y registrado en eventos</center><br></font><br>";
		}
}
}

	echo "<INPUT TYPE=HIDDEN NAME=codusuarioActu value=$codusuarioActu>";
	echo "<INPUT TYPE=HIDDEN NAME=radicadopadre value=$radicadopadre>";
	echo "<INPUT TYPE=HIDDEN NAME=radicadopadreseg value=2>";
	echo "<INPUT TYPE=HIDDEN NAME='codieesp' value='$codieesp'>";
	echo "<INPUT TYPE=HIDDEN NAME='consec' value='$consec'>";
	echo "<INPUT TYPE=HIDDEN NAME='seri_tipo' value='$seri_tipo'>";
	echo "<INPUT TYPE=HIDDEN NAME='radi_usua_actu' value='$radi_usua_actu'>";
if(!$Submit3 and !$Submit4){
?>
	<center><input type='button' onClick='radicar_doc()' name='Submit33' value='Radicar' class="botones_largo">
	<input type='hidden'  name='Submit3' value='Radicar' class='ebuttons2'></center>
	</font>
<?
}else{
	// Modificacion variable para agregar campos necesarios de sticker web
        $varEnvio = session_name()."=".session_id()."&faxPath&leido=no&krd=$krd&faxPath=$faxPath&verrad=$nurad&nurad=$nurad&ent=$ent&remite=$grbNombresUs1&dependenciaDestino=$dependencia";

	//$varEnvio = session_name()."=".session_id()."&faxPath&leido=no&krd=$krd&faxPath=$faxPath&verrad=$nurad&nurad=$nurad&ent=$ent";
?>
<center><input type='button' onClick='modificar_doc()' name='Submit44' value='Modificar datos' class="botones_largo">
<!--font face='Arial' size='2' color='red'><b><u>
<a href="hojaResumenRad.php?<?=$varEnvio?>" target="HojaResumen<?=$nurad?>" class=vinculos>Ver Hoja Resumen </a>
</u></b></font --><br>
<input type='hidden'  name='Submit4' value='MODIFICAR DATOS' class='ebuttons2'>
<input type='hidden' name='nurad' value='<?=$nurad?>'></center>

<center>
<br>
<font face='Arial' size='3' color='black'>Haga click en el código de barras para imprimir el sticker</font>
<br>
<a href="#"  class=vinculos onClick="window.open ('stickerWeb/index.php?<?=$varEnvio?>&alineacion=Center','sticker<?=$nurad?>','menubar=0,resizable=0,scrollbars=0,width=360,height=110,toolbar=0,location=0');"><img src="stickerWeb/codigoBarras.png" alt="Al dar click en la imagen se abrìra una nueva ventana que ejecutara la accion de imprimir                   " width="300" height="80" border="0"></a>
<br>
</center>
<?
}
?> </td>
</tr>
<?php
	/** Aqui valida si ya radico para dejar informar o Anexat archivos para ras. de Salida.*/
	if(($Submit4 or $Submit3) AND !$Buscar){
	if($ent==1 and !$Submit3)
	{
	?>
	<tr bgcolor=white>
	<td class="listado1" colspan="5" align="center">
	<font color="" class="etextomenu">
	</td>
	</TR>
	<TR>
	<TD colspan="5">
	<?
	$ruta_raiz = "..";
	$radicar_documento = "true";
	if($num_archivos==1 and $radicado=="false")
		{
			$generar_numero = "no";
			$vp = "n";
			$radicar_a="$nurad";
			error_reporting(0);
		}
		?>
	</TD></tr>
	<?
	}
	?> 
	<tr bgcolor=white>
	<td class="listado1">
	<label for="coddepeinf">Informar a</label> </td><td class="listado2">
	<?php
	// Modificado SGD 11-Jul-2007
	//$query ="select  DEPE_NOMB, DEPE_CODI from DEPENDENCIA ORDER BY DEPE_NOMB";
	switch( $GLOBALS['entidad'] )
	{
		case 'SGD':
			$query = "SELECT  ".$db->conn->Concat( "DEPE_CODI", "' - '", "DEPE_NOMB" ).", DEPE_CODI
			FROM DEPENDENCIA
			ORDER BY DEPE_CODI, DEPE_NOMB";
			break;
		default:
			$query ="select  DEPE_NOMB, DEPE_CODI from DEPENDENCIA ORDER BY DEPE_NOMB";
	}
	$rs=$db->conn->query($query);
	$varQuery = $query;
	print $rs->GetMenu2("coddepeinf", $coddepeinf, false, true,5,"id='coddepeinf' class='select' title='Listado de dependencias, seleccione a la que desea informar'" );
	echo "<script language='Javascript'>alert('Radicado creado exitosamente');</script>";
	?>
	</td>
	</tr>
	</table>
	<table border=1  width=100% class="borde_tab">
	<tr>
	<td class="listado1"><b>Se ha informado a:<b></td><td class=listado1>Seleccione un doc. de Informado para borrar</td></tr>
	</table>
	<table border=1 class='borde_tab' width=100%>
	<?php
	$query2 = "select b.depe_nomb
					,a.INFO_DESC
					,b.DEPE_NOMB
					,a.DEPE_CODI
					,a.info_fech as INFO_FECH
					,INFO_DESC
					from informados a,dependencia b
					where a.depe_codi=b.depe_codi and cast(a.radi_nume_radi as varchar)='$nurad'
					order by info_fech desc ";
	$k = 1;
	$rs=$db->conn->query($query2);
	if ($rs)
	{
		while (!$rs->EOF){
			$data = $rs->fields['INFO_DESC'];
			$data2 = $rs->fields['DEPE_NOMB'];
			$data3 = $rs->fields['DEPE_CODI'];
			$data4 = date("dMy",$rs->fields['INFO_FECH']);
			// Modificado SGD 11-Jul-2007
			//$data5 = date("d-m-Y",$rs->fields['INFO_FECH']);
			$data5 = date( "d-m-Y", $db->conn->UnixTimeStamp( $rs->fields['INFO_FECH'] ) );
			$data6 = $db->conn->UnixTimeStamp( $rs->fields['INFO_DESC'] );
			?>
                       <tr  class='listado2'>
                            <td><input type="radio" name="borrarradicado" value="<?= $data3 . $data6 ?>"></td>
                            <td class="listado2">
                                <b><?= $data ?></b>
                            </td>
                            <td class="listado2"> 
                        <center><?= $data2 ?></td>
                            <td class="listado2">
                                <?= $data5 ?>
                            </td>
                            </tr>
			<?
			$k = $k +1;
			$rs->MoveNext();
		}
	}
	$verrad = $nurad;
	?>
<!--	<tr><td>
	</td></tr>-->
	<?
	}
	?>
	</table>
	<input type='hidden' name='depende' value='<?php echo $depende; ?>'><BR>
	  </td>
	</tr>
  </table>
	<br>
</form>


<?php
	$verrad = $nurad;
	$radi = $nurad;
	$contra = $drde;
	$tipo = 1;
	if($Submit3 or $Submit4 or $rad0 or $rad1 or $rad2)
	{	echo "<script language='JavaScript'>";
		for ($i=1; $i<=3; $i++)
		{	$var_pai = "idpais".$i;
			$var_dpt = "codep_us".$i;
			$var_mcp = "muni_us".$i;
			$muni_tmp = ${$var_mcp};
			if (!(is_null($muni_tmp)))
			{	echo "\n";
				echo "cambia(document.formulario, 'idpais$i', 'idcont$i');
					formulario.idpais$i.value = ${$var_pai};
				  	cambia(document.formulario, 'codep_us$i', 'idpais$i');
				  	formulario.codep_us$i.value = '${$var_dpt}';
				  	cambia(document.formulario, 'muni_us$i', 'codep_us$i');
				  	formulario.muni_us$i.value = '${$var_mcp}';";
			}
		}
		echo "</script>";
	}
?>
</body>
</html>
