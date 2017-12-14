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


//Verifico que haya pasado por paso dos
$nombre_archivo = 'config.txt';
// Primero vamos a asegurarnos de que el archivo existe y es escribible.
if (is_writable($nombre_archivo)) {
	 if (!$gestor = fopen($nombre_archivo,'r')) {
	         echo "No se puede abrir el archivo ($nombre_archivo)";
        	 exit;
    	}else {
		//busco entidad
		$palabra=" $menuAdicional = 0;";
		while(!feof($gestor))
		{
			$linea = fgets($gestor,13);
			echo $linea;
			if($linea == $palabra)  { $ok1="ok"; echo "encontre entidad"; 
			}	
			 //   header("Location: pasouno.php?error=4");
		}

	}
	fclose($gestor);
}else {
//	header("Location: pasouno.php?error=4");
	echo "No es escribible";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" media="screen" type="text/css" title="style" href="style.css" />
<title>Instalador Orfeo</title>
<script>

function mostrardiv1() {
	div = document.getElementById('flotante1');
	div.style.display = '';
	div2 = document.getElementById('flotante2');
	div2.style.display='none';
}

function mostrardiv2() {
	div = document.getElementById('flotante2');
	div.style.display = '';
	div1 = document.getElementById('flotante1');
	div1.style.display='none';
}

function cerrar() {
}
</script>
</head>
<body>
 <div id="holder">
   <!--BEGIN OF TERMS OF USE. DO NOT EDIT OR DELETE THESE LINES. IF YOU EDIT OR DELETE THESE LINES AN ALERT MESSAGE MAY APPEAR WHEN TEMPLATE WILL BE ONLINE-->
<div id="footer_terms">
 </div>
<!--END OF TERMS OF USE-->
<!-- HEADER -->
<div id="header"> <a href="index.html"></a> </div>
<!-- END HEADER -->
<div id="shadow">
  <!-- MENU -->
  <ul id="menu">
    <li> <a href="index.html">inicio</a> </li>
    <li> | </li>
    <li> <a href="pasouno.html">paso 1 </a> </li>
    <li> | </li>
    <li> <a href="pasodos.php">paso 2</a> </li>
    <li> | </li>
    <li> <a href="pasotres.html"><div id="ojo">paso 3</div></a></li>
    <li> | </li>
    <li> <a href="fin.html">fin</a> </li>
  </ul>
  <div class="clear"></div>
  <!-- END MENU -->
  <!-- EDITO -->
  <div class="idioma">
    <div id="edito">
      <div class="idioma">
        <div align="right"><img src="images/español.png" alt="español" width="18" height="19" longdesc="español" /><img src="images/ingles.png" alt="ingles" width="18" height="19" longdesc="ingles" /></div>
      </div>
      <h2>COMPROBAR ACCESOS </h2>
      <p>Diligencie los datos para comprobar y crear acceso </p>
      <p>&nbsp;</p>
    </div>
  </div>
  <!-- END EDITO -->
  <div id="toal"> </div>
  <!-- CONTENT -->

  <div id="content">
    <!-- ABOUT ME -->
    <div>
      <h1>RUTA DE LA BODEGA </h1>
      <p> <em>Digite  la ruta de la bodega </em></p>
      <p>
        <input type="text" name="bodega" />
      </p>
      <p>&nbsp;</p>
      <h1>&nbsp;</h1>
      <h1>COMPROBACIÓN DE USUARIO</h1>
      <p><em>Ingrese contraseña de Usuario Administrador </em></p>
      <p>
        <input type="text" name="compuser" />
</p>
    </div>
    <!-- END ABOUT ME -->
    <!-- NEWS -->
    <div id="vertical_barr">
      <h1>ELIJA EL MODO DE AUTENTICACION </h1>
      <p>
        <label></label>
      </p>
      <p>
        <label></label>
        <label>
          <input name="radiobutton" type="radio" value="radiobutton" checked="checked" onclick="javascript:mostrardiv1();" />
          Base de Datos</label>
        <label></label>
      </p>
      <p>
        <label></label>
        <label>
          <input name="radiobutton" type="radio" value="radiobutton" accesskey="l" onclick="javascript:mostrardiv2();" />
          LDAP</label>
      </p>
      <p>
        <label>
          <input name="radiobutton" type="radio" value="radiobutton" accesskey="a"  onclick="javascript:mostrardiv2();"/>
          Active Directory</label>
      </p>
      <div id="flotante1" style="display:none;"><br>
         <form id="form2" method="post" action="">
          <p>
            <label></label>
		  </form>
        <a href="#" class="content_button">Comprobar</a> </div>
     
  </div>
    <div  id="vertical_bar">
    <div id="flotante2" style="display:none;">  <br >
        </span></p>
        <form id="form2" method="post" action="">
          <p>
            <label></label>
          <p>
            <label>IP Servidor:<br />
              <input type="text" name="textfield" />
            </label>
          </p>
          <p>
            <label>Base de Busqueda:
              <input type="text" name="textfield2" />
            </label>
          </p>
          <p>
            <label>Usuario:<br />
              <input type="text" name="textfield3" />
            </label>
          </p>
          <p>
            <label>Contraseña:<br />
              <input type="text" name="textfield4" />
            </label>
            <label></label>
          </p>
        </form>
        <a href="#" class="content_button">Comprobar</a> </div>
   </div>
    <!-- END NEWS -->
    <!-- SERVICES --><!-- END SERVICES -->
  </div>
      <!-- END CONTENT -->
  <div class="clear"><a href="fin.html" id="button_edito">FINALIZAR</a></div>
     <!-- END SHADOW -->
</div>
<!-- FOOTER -->
<div id="footer">
  <p>© 2008 Skina Technologies<br />
Dirección: Carrera 64 No. 96-17 | PBX:+57(1) 226-2080 | Movil: +57(310) 288-0926  | Bogotá DC- Colombia<br />
Design by SkinaTech based on <a href="http://www.templatki.com" target="_blank">Templatki</a> </p>
</div>
<!-- END FOOTER -->
</div>
<!-- END HOLDER -->
</body>
</html>
