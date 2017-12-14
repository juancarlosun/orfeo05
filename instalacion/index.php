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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" media="screen" type="text/css" title="style" href="style.css" />
<title>Instalador Orfeo</title>
</head>
<body>
    <div align="center">
      <div id="holder">
   <!--BEGIN OF TERMS OF USE. DO NOT EDIT OR DELETE THESE LINES. IF YOU EDIT OR DELETE THESE LINES AN ALERT MESSAGE MAY APPEAR WHEN TEMPLATE WILL BE ONLINE-->
   <!--END OF TERMS OF USE-->
   <!-- HEADER -->
<div id="header"> <a href="index.php"></a> </div>
<!-- END HEADER -->
<div id="shadow">
  <!-- MENU -->
  <ul id="menu">
    <li> <a href="index.php"><div id="ojo">Inicio</div></a> </li>
    <li> | </li>
    <li> <a href="pasouno.php">Licencia </a> </li>
    <li> | </li>
    <li> <a href="pasodos.php">Base de Datos</a> </li>
    <li> | </li>
    <li> <a href="pasotres.php">PASO 3 </a></li>
    <li> | </li>
    <li> <a href="fin.html">FIN</a> </li>
  </ul>
<!--  <div class="clear"></div>-->
  <!-- END MENU -->
  <!-- EDITO -->
  <div class="idioma">
    <div id="edito">
      <div class="idioma">
        <div align="right"><img src="images/español.png" alt="español" width="18" height="19" longdesc="español" /><img src="images/ingles.png" alt="ingles" width="18" height="19" longdesc="ingles" /></div>
      </div>
      <h2>INSTALADOR ORFEO </h2>
      <p>&nbsp;</p>
    </div>
  </div>
  <!-- END EDITO -->
  <div id="toal"> </div>
	<h1>&nbsp;</h1>
	<h1 align="center">COMPROBACIONES PREVIAS</h1>
	<h1>&nbsp;</h1>
   <!--<div class="clear">-->
<table width="100%">
 <tbody>
	<tr>
	<td style="width:34%">
	<p>Si alguno de estos elementos no está soportado (marcado con ERROR), por favor, realice las acciones necesarias para corregirlo. Los fallos podrían hacer que su instalación de Orfeo no funcionara correctamente.</p>
	</td>
	<td style="width:66%" colspan="2">
	<p>&nbsp;</p>
	<?
	// PHP 5 check
	if (version_compare(PHP_VERSION, '5.3.4', '<')) {
	die('Se necesita PHP 5.3.4 o superior para esta version de Orfeo!');
	}else{
	?>
	<table width="100%">
	<tr>
		<td><p>La versión de PHP debe ser 5.3 o superior </p> </td>
		<td><em>OK</em>
		</td>
	</tr>
	<?
	}
	/*
	 * Check for existing configuration file.
	 * deshabilito para seguir desarrollando
	 
	if (file_exists('../config.php') && (filesize('../config.php') > 10) ) {
	header('Location: ../index.php');
	exit();
	} */	
	if(ini_get('display_errors')=='') { 
	?>
	<tr>
		<td><p>Display Errors debe estar apagado</p></td>
		<td><em>OK</em></td>
	</tr>
	<?
	}else{
	?>
	<tr>
		<td><p>Display Errors debe estar apagado</p></td>
		<td><em>ERROR</em></td>
	</tr>
	<?
	}
	if(ini_get('register_globals')=='') { 
	?>
	<tr>
		<td><p>Register globals debe estar apagado</p></td>
		<td><em>OK</em></td>
	</tr>
	<?
	}else{
	?>
	<tr>
		<td><p>Register globals debe estar apagado</p></td>
		<td><em>ERROR</em></td>
	</tr>
	<?
	}
	if(ini_get('session.save_handler') == 'files') {
		 $session_save_path = session_save_path();
    		if (strpos ($session_save_path, ";") !== FALSE)
			$session_save_path = substr ($session_save_path, strpos ($session_save_path, ";")+1);
    		if(is_dir($session_save_path)){
        		if(is_writable($session_save_path)){
            		?>
			<tr>
			<td><p>Session save path es escribible</p></td>
			<td><em>OK</em></td>
			</tr>
			<?
        		}else{
			?>
			<tr>
			<td><p>Session save path es escribible</p></td>
			<td><em>ERROR</em></td>
			</tr>
			<?
			}
		    }else{
			?>
			<tr>
			<td><p>Session save path no es un directorio</p></td>
			<td><em>ERROR</em></td>
			</tr>
			<?
			}
		}
	if(ini_get('session.gc_maxlifetime')=='1') { 
	?>
	<tr>
		<td><p>Session.gc_maxlifetime debe estar prendido</p></td>
		<td><em>OK</em></td>
	</tr>
	<?
	}else{
	?>
	<tr>
		<td><p>Session.gc_maxlifetime debe estar prendido</p></td>
		<td><em>ERROR</em></td>
	</tr>
	<?
	}
	if(ini_get('session.cache_expire')=='0') { 
	?>
	<tr>
		<td><p>Session.cache_expire debe estar apagado</p></td>
		<td><em>OK</em></td>
	</tr>
	<?
	}else{
	?>
	<tr>
		<td><p>Session.cache_expire debe estar apagado</p></td>
		<td><em>ERROR</em></td>
	</tr>
	<?
	}
	if(ini_get('session.use_trans_sid')=='1') { 
	?>
	<tr>
		<td><p>Session.use_trans_sid  debe estar prendido</p></td>
		<td><em>OK</em></td>
	</tr>
	<?
	}else{
	?>
	<tr>
		<td><p>Session.use_trans_sid  debe estar prendido</p></td>
		<td><em>ERROR</em></td>
	</tr>
	<?
	}
	if(ini_get('short_open_tag')=='1') { 
	?>
	<tr>
		<td><p>Short_open_tag debe estar prendido</p></td>
		<td><em>OK</em></td>
	</tr>
	<?
	}else{
	?>
	<tr>
		<td><p>Short_open_tag debe estar prendido</p></td>
		<td><em>ERROR</em></td>
	</tr>
	<?
	}
	if(ini_get('allow_url_include')=='1') { 
	?>
	<tr>
		<td><p>Allow_url_include debe estar prendido</p></td>
		<td><em>OK</em></td>
	</tr>
	<?
	}else{
	?>
	<tr>
		<td><p>Allow_url_include debe estar prendido</p></td>
		<td><em>ERROR</em></td>
	</tr>
	<?
	}
	if (extension_loaded('gd')) {
	?>
	<tr>
		<td><p>Soporte GD</p></td>
		<td><em>OK</em></td>
	</tr>
	<?
	}else{
	?>
	<tr>
		<td><p>Soporte GD</p></td>
		<td><em>ERROR</em></td>
	</tr>
	<?
	}
    	if (extension_loaded('json')) {
	?>
	<tr>
		<td><p>Soporte JSON</p></td>
		<td><em>OK</em></td>
	</tr>
	<?
	}else{
	?>
	<tr>
		<td><p>Soporte JSON</p></td>
		<td><em>ERROR</em></td>
	</tr>
	<?
	}	
	?>
	</table>
	</td>
    </tr>
    <tr>
      <td colspan="3" align="center">
	<p>&nbsp;</p>
          <p align="center"><a href="pasouno.php" id="button_edito">INICIAR INSTALACI&Oacute;N </a>
          </p>
      	  <p>&nbsp;</p>
	</td>
    </tr>
    <tr>
	<td><h1 align="center">SkinaTech</h1></td>
	<td><h1 align="center">Kuine</h1></td>
	<td><h1 align="center">Orfeolibre</h1></td>
	</tr>
    <tr>
      <td>
      	<p>&nbsp;</p>
      	<p align="center"><a href="http://www.skinatech.com"><img src="images/skinatech.gif" alt="skina" width="200" longdesc="skina" /></a></p>
      	<p>&nbsp;</p>
	</td>
      <td>
      	<p>&nbsp;</p>
      	<p align="center"><a href="http://www.kuine.org"><img src="images/kuine_logo.jpg" alt="kuine" width="200"/></a></p>
	<p>&nbsp;</p>
	</td>
      <td>
      	<p>&nbsp;</p>
      	<p align="center"><a href="http://www.orfeolibre.org/inicio/"><img src="images/img_edito.png" alt="orfeolibre" width="200" /></a></p>
      	<p>&nbsp;</p>
	</td>
    </tr>
  </tbody>
</table>
<!--</div> -->
<!-- END CLEAR -->
</div> 
<!-- END SHADOW -->
<!-- FOOTER -->
<div id="footer">
  <p>© 2008 Skina Technologies<br />
Dirección: Carrera 64 No. 96-17 | PBX:+57(1) 226-2080 | Movil: +57(310) 288-0926  | Bogotá DC- Colombia<br />
Design by SkinaTech</p>
</div>
<!-- END FOOTER -->
</div>
    </div>
    <!-- END HOLDER -->
</body>
</html>
