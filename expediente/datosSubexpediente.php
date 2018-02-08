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
error_reporting(0);
$ruta_raiz = "..";
if(!$dependencia or !$tpDepeRad) include "$ruta_raiz/rec_session.php";
require_once("$ruta_raiz/include/db/ConnectionHandler.php");
$ADODB_FETCH_MODE = ADODB_FETCH_ASSOC;
$db = new ConnectionHandler($ruta_raiz);	 
$db->conn->SetFetchMode(ADODB_FETCH_ASSOC);  
//$db->conn->debug=true;

if( isset( $_POST['grabar'] ) && $_POST['grabar'] == "GRABAR" )
{
    include_once( "$ruta_raiz/include/tx/Expediente.php" );
    
    $expediente = new Expediente( $db );
    $grabarSubexpediente = $expediente->grabarSubexpediente( $_GET['nurad'], $_GET['num_expediente'], $_POST['exp_subexpediente'] );
    if( $grabarSubexpediente == 1 )
    {
        $observa = "Creacion de Subexpediente";
        include_once "$ruta_raiz/include/tx/Historico.php";
        $radicados[] = $_GET['nurad'];
        $tipoTx = 55;
        $Historico = new Historico( $db );
        $Historico->insertarHistoricoExp( $_GET['num_expediente'], $radicados, $dependencia, $codusuario, $observa, $tipoTx, 0 );
    ?>
    <script language="JavaScript">
      opener.regresar();
      window.close();
    </script>
    <?php
    }
    else
    {
        print '<hr><font color=red>No se guardo el Subexpediente. Por favor intente de nuevo.</font><hr>';	    
    }
}
?>
<html>
<head>
  <meta http-equiv="Cache-Control" content="cache">
  <meta http-equiv="Pragma" content="public">
<link href="<?= $ruta_raiz . $ESTILOS_PATH2 ?>bootstrap.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="<?= $ruta_raiz . $_SESSION['ESTILOS_PATH_ORFEO'] ?>">
<?php
$fechah=date("dmy") . "_". time("h_m_s");
$encabezado = session_name()."=".session_id()."&krd=$krd";
?>
<script language="JavaScript">
// Grabar Subexpediente
function grabarSubexpediente()
{
	//by skina para ciac,130711,para varchar 
	//if( document.getElementById( 'exp_subexpediente').value == "" || isNaN( document.getElementById( 'exp_subexpediente').value ) )
    if( document.getElementById( 'exp_subexpediente').value == "" )
    {
        alert( "Debe ingresar un numero de subexpediente." );
        document.getElementById( 'exp_subexpediente').focus();
    }
    else
    {
        confirmar = confirm( "Recuerde que cualquier cambio que realice en este modulo afectara su \n\r ubicacio fisica dentro del expediente." );
    }
    
    if( confirmar )
    {
        document.getElementById( 'grabar' ).value = "GRABAR";
        document.frmSubexpediente.submit();
    }
}
</script>
</head>

<body bgcolor="#FFFFFF" topmargin="0" >
	 <form name='frmSubexpediente' action='' method="post">
     <input type="hidden" name="grabar" id="grabar" value="">
        <TABLE width="100%" align="center" cellspacing="5" cellpadding="0" border="0" class="borde_tab">
          <tr> 
            <TD class='titulos2' height="58"> 
              <table BORDER=0  cellpad=2 cellspacing='2' WIDTH=100% class='t_bordeGris' valign='top' align='center' cellpadding="2" >
                <tr><td class='titulos2' align="center">Radicado No <b><?=$nurad?></b> Perteneciente al expediente No <b><?=$num_expediente?></b></td>
<?php
				require "$ruta_raiz/class_control/class_control.php";
				$btt = new CONTROL_ORFEO($db);				
				if( $Grabar )
				{
				  	// Aqui se accede a la clase class_control para actualizar expedientes.
                    $btt->modificar_expediente($nurad,$num_expediente,$exp_titulo,$exp_asunto,$exp_ufisica,$exp_isla,$exp_caja,$exp_estante,$exp_carpeta,$exp_subexpediente);
				}
		$btt->datos_expediente( $num_expediente,$nurad );
                $num_carpetas = $btt->exp_num_carpetas;
                $exp_titulo = $btt->exp_titulo;
                $exp_asunto = $btt->exp_asunto;
                $exp_ufisica = $btt->exp_ufisica;
                $exp_isla = $btt->exp_isla;
                $exp_caja = $btt->exp_caja;
                $exp_estante = $btt->exp_estante;
                $exp_carpeta = $btt->exp_carpeta;
                $exp_subexpediente = $btt->exp_subexpediente;
				?>
				</tr>
              </TABLE>
            </td>
          </tr>
          <tr> 
            <td class=listado2> 
              <table width="100%" height="99%" cellspacing="5"  align="center" border="1" class="borde_tab" >
                <tr valign="bottom" > 
                  <td class='titulos5'>TITULO&nbsp;</td> 
				  <TD class='listado2'>
                    <input type=text class='tex_area' name=exp_titulo value='<?=$exp_titulo?>' size=30 maxlength="20" readonly>
                  </TD>
                </tr>
				<tr>
                  <td class='titulos5'>ASUNTO</td>
			      <TD class='listado2'>
                    <input type=text class='tex_area' name=exp_asunto value='<?=$exp_asunto?>' size=50 maxlength="40" readonly><BR>
                  </TD>
				</tr>
                <tr>
                  <td class='titulos5'>SUBEXPEDIENTE</td>
			      <TD class='listado2'nowrap>
		    <!--by skina para ciac,130711,para varchar -->
                    <!--<input type="text" class='tex_area' name="exp_subexpediente" id="exp_subexpediente" value='<?=$exp_subexpediente?>' size=3 maxlength="2">-->
                    <input type="text" class='tex_area' name="exp_subexpediente" id="exp_subexpediente" value='<?=$exp_subexpediente?>' size=25 maxlength="15">
                    &nbsp;
                    <span class="leidos" >Digite el numero del subexpediente al cual pertenece el radicado.</span>
                  </TD>
				</tr>
				<TR class='titulos2'>
				<TD colspan="3">
	<? // Subtabla donde se coloca inf. de la carpeta				 ?>
    						  
    <table width="100%" border="1" cellspacing="0" cellpadding="0" align="center" class="borde_tab"  >
      <TR class='titulos2'><TD>&nbsp;</TD></TR>
        <tr valign="bottom" class='titulos5'> 
          <td class='listado2' colspan="2">UBICACION FISICA&nbsp;</td> 
          <TD colspan="2">
            <input type=text class='tex_area' name=exp_ufisica value='<?=$exp_ufisica?>' maxlength="3" readonly>&nbsp;
          </TD>
        </tr>
        <tr>
          <td width="14%" colspan="4">&nbsp;</td>
        </tr>
        <tr>
          <td class='titulos5'>PISO</td>
          <TD class='listado2' valign="middle" align="left">
            <input type=text class='tex_area' name=exp_isla value='<?=$exp_isla?>' size=10 maxlength="3" readonly>
          </TD>
          <td class='titulos5'>ESTANTE</td>
          <TD class='listado2' valign="midle" align="left">
            <input type=text class='tex_area' name=exp_estante value='<?=$exp_estante?>' size=10 maxlength="3" readonly>
          </TD>
        </tr>
        <tr >
          <td class='titulos5'>CAJA</td>
          <TD valign="middle" align="left" class='listado2'>
            <input type=text class='tex_area' name=exp_caja value='<?=$exp_caja?>' size=10 maxlength="3" readonly>
          </TD>
          <td class='titulos5'>CARPETA</td>
          <TD class='listado2' valign="middle" align="left">
            <input type=text class='tex_area' name=exp_carpeta maxlength="3" value='<?=$exp_carpeta?>' size=10 readonly>
          </TD>
        </tr>
    </table>
  </TD>
				</TR>
				<TR class='titulos2'>
                <td colspan="4" align="center">
                  <input type="button" value="Grabar" name="btnGrabar" class="botones" onClick="grabarSubexpediente();">
                  &nbsp;
                  <input type="button" value="Cerrar" name="btnCerrar" onClick="opener.regresar(); window.close();" class="botones">
                  &nbsp;
                </td>
				</TR>
              </table>
		    </td></tr>
	   </table>
</form>
</body>
</html>
