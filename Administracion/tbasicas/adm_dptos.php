<?php
session_start();
$ruta_raiz = "../..";
if($_SESSION['usua_admin_sistema'] !=1 ) die(include "$ruta_raiz/errorAcceso.php");

include("$ruta_raiz/config.php");       // incluir configuracion.
define('ADODB_ASSOC_CASE',1);
include($ADODB_PATH.'/adodb.inc.php');  // $ADODB_PATH configurada en config.php
$ADODB_FETCH_MODE = ADODB_FETCH_NUM;
$ADODB_COUNTRECS = false;

$error = 0;
$dsn = $driver."://".$usuario.":".$contrasena."@".$servidor."/".$db;
$conn = NewADOConnection($dsn);
//$db->conn->debug=true;

function valueToJsValue($value, $encoding = false)
{	if (!is_numeric($value)) 
{	$value = str_replace('\\', '\\\\', $value);
	$value = str_replace('"', '\"', $value);
	$value = '"'.$value.'"';
}
if ($encoding) 
{	switch ($encoding) 
	{	case 'utf8' :	return iconv("ISO-8859-2", "UTF-8", $value);
						break;
	}
}
else 
{	return $value;	}
}

function arrayToJsArray( $array, $name, $nl = "\n", $encoding = false ) 
{	if (is_array($array)) 
{	$jsArray = $name . ' = new Array();'.$nl;
	foreach($array as $key => $value) 
	{	switch (gettype($value)) 
		{	case 'unknown type':
			case 'resource':
			case 'object':	break;
			case 'array':	$jsArray .= arrayToJsArray($value,$name.'['.valueToJsValue($key, $encoding).']', $nl);
							break;
			case 'NULL':	$jsArray .= $name.'['.valueToJsValue($key,$encoding).'] = null;'.$nl;
							break;
			case 'boolean':	$jsArray .= $name.'['.valueToJsValue($key,$encoding).'] = '.($value ? 'true' : 'false').';'.$nl;
							break;
			case 'string':	$jsArray .= $name.'['.valueToJsValue($key,$encoding).'] = '.valueToJsValue($value, $encoding).';'.$nl;
							break;
			case 'double':	
			case 'integer':	$jsArray .= $name.'['.valueToJsValue($key,$encoding).'] = '.$value.';'.$nl;
							break;
			default:	trigger_error('Hoppa, egy új típus a PHP-ben?'.__CLASS__.'::'.__FUNCTION__.'()!', E_USER_WARNING);
		}
	}
	return $jsArray;
}
else 
{	return false;	}
}
//error_log('valor de dns------------------- '.$dsn,0);

if ($conn)
{       $conn->SetFetchMode(ADODB_FETCH_ASSOC);

if (isset($_POST['btn_accion']))
{	$record = array();
	$record['ID_PAIS'] = $_POST['idpais'];	
	$record['DPTO_CODI'] = $_POST['txtIdDpto'];
	$record['ID_CONT'] = $_POST['idcont'];
	$record['DPTO_NOMB'] = $_POST['txtModelo'];
	switch($_POST['btn_accion'])
	{	Case 'Agregar':
			{
                         /**Modificacion Skina - Separo el case de agregar de modificar para evitar el cambio de los datos**/
                         /**de un registro ya existente mediante la opcion de agregar, usando la funcion Replace de adodb **/
                         /**Ing Camilo Pintor - cpintor@skinatech.com **/
                         /**Septiembre 2015 **/
 		         $sql = "INSERT INTO DEPARTAMENTO (ID_PAIS, DPTO_CODI, ID_CONT, DPTO_NOMB) VALUES (".$record['ID_PAIS'].",".$record['DPTO_CODI'].",".$record['ID_CONT'].",'".$record['DPTO_NOMB']."')";
                                        $rs = $conn->Execute($sql);
                                        ($rs) ? ($error = 4 ) : $error = 2;
                                }break;
                                /**Fin Modificacion**/
		Case 'Modificar':{		
							$res = $conn->Replace('DEPARTAMENTO', $record, array('ID_CONT','ID_PAIS','DPTO_CODI'), $autoquote = true);
							($res) ? ($res == 1 ? $error = 3 : $error = 4 ) : $error = 2;
						 }break;
		Case 'Eliminar':
			{	$ADODB_COUNTRECS = true;
				$sql = "SELECT * FROM SGD_DIR_DRECCIONES WHERE DPTO_CODI = ".$record['DPTO_CODI'];
				$rs = $conn->Execute($sql);
				$ADODB_COUNTRECS = false;
				if ($rs->RecordCount() > 0)
				{	$error = 5;	}
				else 
				{	$conn->BeginTrans();
					$ok = $conn->Execute('DELETE FROM MUNICIPIO WHERE DPTO_CODI='.$record['DPTO_CODI']);
					if ($ok)
					{	$record = array_slice($record, 0, 2);
						$ok = $conn->Execute('DELETE FROM DEPARTAMENTO WHERE ID_PAIS='.$record['ID_PAIS'].' AND DPTO_CODI='.$record['DPTO_CODI']);
					}
					($ok) ? $conn->CommitTrans() : $conn->RollbackTrans() ;
					($ok) ? $error = 6 : $error = 7;
				}
			}break;
		Default: break;
	}
	unset($record);
}

	$sql_cont = "SELECT NOMBRE_CONT,ID_CONT FROM SGD_DEF_CONTINENTES ORDER BY NOMBRE_CONT";
        $Rs_cont = $conn->CacheExecute(1,$sql_cont);    //Query en cache por 24 horas.
        if (!($Rs_cont)) $error = 2;

        $sql_pais = "SELECT ID_PAIS,NOMBRE_PAIS,ID_CONT FROM SGD_DEF_PAISES ORDER BY NOMBRE_PAIS";
        $Rs_pais = $conn->Execute($sql_pais);
        if ($Rs_pais)
        {       $vpaises = $conn->GetAssoc($sql_pais,$inputarr=false,$force_array=false,$first2cols=false);
                $vpaisesk = array_keys($vpaises);
                $vpaisesv = array_values($vpaises);
                $idx=0;
                foreach ($vpaisesk as $vpk)
                        {       $vpaisesv[$idx]['id_pais'] = $vpk;
                                $idx += 1;
                        }
        }
        else
                $error = 2;

        if ($_POST['idpais'] > 0)
        {       $sql_dpto = "SELECT dpto_nomb,dpto_codi FROM DEPARTAMENTO WHERE id_pais=".$_POST['idpais']." ORDER BY dpto_nomb";
                $Rs_dpto = $conn->Execute($sql_dpto);
        }


}
else
{	$error = 1;
}
?>
<html>
<script language="JavaScript">
<!--
function Actual()
{
var Obj = document.getElementById('iddpto');
var i = Obj.selectedIndex;
document.getElementById('txtModelo').value = Obj.options[i].text;
document.getElementById('txtIdDpto').value = Obj.value;
}

function rightTrim(sString)
{	while (sString.substring(sString.length-1, sString.length) == ' ')
{	sString = sString.substring(0,sString.length-1);  }
return sString;
}

function addOpt(oCntrl, iPos, sTxt, sVal)
{	var selOpcion=new Option(sTxt, sVal);
eval(oCntrl.options[iPos]=selOpcion);
}

function cambia(oCntrl)
{	while (oCntrl.length) 
{	oCntrl.remove(0);	}
$indice = 0;
addOpt(oCntrl, $indice, "<< Seleccione Pais >>", $indice);
for ($x=0; $x < vp.length; $x++)
//Por version de la base de datos de sht  id_cont y nombre pais deben estar en mayuscula
        {       if (vp[$x]["id_cont"] == document.form1.idcont.options[document.form1.idcont.selectedIndex].value)
                {       $indice += 1;
                        addOpt(oCntrl, $indice, vp[$x]["nombre_pais"], vp[$x]["id_pais"]);
                }
        }
}


function ver_listado()
{
window.open('listados.php?var=dpt','','scrollbars=yes,menubar=no,height=600,width=800,resizable=yes,toolbar=no,location=no,status=no');
}

<? echo arrayToJsArray($vpaisesv, 'vp'); ?>
//-->
</script>
<head>
<title>Orfeo- Admor de Departamentos.</title>
        <link href="<?= $ruta_raiz . $ESTILOS_PATH2 ?>bootstrap.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="<?= $ruta_raiz . $_SESSION['ESTILOS_PATH_ORFEO'] ?>">
</head>
<body>
    <br>
    <br>
<form name="form1" method="post" action="<?= $_SERVER['PHP_SELF']?>">  
<input type="hidden" name="hdBandera" value="">
<center>
<div id="titulo" style="width: 75%;" align="center">Administrador de departamentos</div>
<table width="75%" border="1" align="center" cellspacing="0">
<tr bordercolor="#FFFFFF">
<!--<td colspan="3" height="40" align="center" valign="middle" class="titulos4"><b>ADMINISTRADOR DE DEPARTAMENTOS</b></td>-->
</tr>
<tr bordercolor="#FFFFFF"> 
<td width="3%" align="center" class="titulos2">1.</td>
<td width="25%" align="left" class="titulos2" height="26"><b>&nbsp;<label for="idcont">Seleccione Continente</label></b></td>
<td width="72%" class="listado2">
<?	// Listamos los continentes.
	echo $Rs_cont->GetMenu2('idcont',$_POST['idcont'],"0:&lt;&lt; SELECCIONE &gt;&gt;",false,0,"class='select' id='idcont' title='Listado de continentes' onchange=\"cambia(document.form1.idpais)\"");
            $Rs_cont->Close();

?>	</td>
</tr>

<tr bordercolor="#FFFFFF"> 
<td align="center" class="titulos2">2.</td>
<td align="left" class="titulos2" height="26"><b>&nbsp;<label for="idpais">Seleccione País</label></b></td>
<td align="left" class="listado2">
	<select id="idpais" name="idpais" class='select' onChange="this.form.submit()" title="Listado de países de acuerdo al continente seleccionado">
		<option value="0" selected>&lt;&lt; Seleccione Continente &gt;&gt;</option>
	<?	// Listamos los paises segun continente.
		if ($_POST['idpais'] > 0)
			while ($Reg2 = $Rs_pais->FetchRow())
			{	if ($Reg2['ID_CONT'] == $_POST['idcont'])
                                {       ($Reg2['ID_PAIS'] == $_POST['idpais']) ? $s="selected" : $s="" ;
                                        echo '<option value="'.$Reg2['ID_PAIS'].'"'.$s.' >'.$Reg2['NOMBRE_PAIS'].'</option>';
                                }

			}		
	?>
	</select></td>
</tr>

<tr bordercolor="#FFFFFF"> 
<td align="center" class="titulos2">3.</td>
<td align="left" class="titulos2" height="26"><b>&nbsp;<label for="iddpto">Seleccione Departamento</label></b></td>
<td class="listado2" height="1">
	<?	
	if (isset($_POST['idpais']) and $_POST['idpais'] > 0)
	{	// Listamos los Departamentos según pais seleccionado
	echo $Rs_dpto->GetMenu2('iddpto',$_POST['iddpto'],"0:&lt;&lt; SELECCIONE &gt;&gt;",false,0,"class='select'  id=\"iddpto\" onchange=\"Actual();\"");
	$Rs_dpto->Close();
	}
	else 
	{	echo "<select id='iddpto' name='iddpto' class='select'><option value='' selected>&lt;&lt; Seleccione Pa&iacute;s &gt;&gt;</option></select>";
	}
	?>	</td>
</tr>
<tr bordercolor="#FFFFFF"> 
<td rowspan="2" valign="middle" class="titulos2">4.</td>
<td align="left" class="titulos2" height="26"><b>&nbsp;<label for="txtIdDpto">Ingrese el código del Departamento</label></b></td>
<td class="listado2"><input name="txtIdDpto" id="txtIdDpto" type="text" size="10" maxlength="3" title="Campo para ver,ingresar o modificar el identificador del departamento"></td>
</tr>
<tr bordercolor="#FFFFFF"> 
<td align="left" class="titulos2" height="26"><b>&nbsp;<label for="txtModelo">Ingrese nombre del Departamento</label></b></td>
<td class="listado2"><input name="txtModelo" id="txtModelo" type="text" size="50" maxlength="70" title="Campo para ver,ingresar o modificar el nombre del departamento"></td>
</tr>
<?php
if ($error)
{	echo '<tr bordercolor="#FFFFFF"> 
			<td width="3%" align="center" class="titulosError" colspan="3" bgcolor="#FFFFFF">';
	switch ($error)
	{	case 1:	//NO CONECCION A BD
				echo "Error al conectar a BD, comuníquese con el Administrador de sistema !!";
				break;
		case 2:	//ERROR EJECUCCIÓN SQL
				echo "Error al gestionar datos, comuníquese con el Administrador de sistema !!";
				break;
		case 3:	//ACUTALIZACION REALIZADA
				echo "Información actualizada!!";break;
		case 4:	//INSERCION REALIZADA
				echo "Departamento creado satisfactoriamente!!";break;
		case 5:	//IMPOSIBILIDAD DE ELIMINAR PAIS, ESTÁ LIGADO CON DIRECCIONES
				echo "No se puede eliminar departamento, se encuentra ligado a direcciones.";break;
		case 6: //departamento correctamente eliminado
				echo "Departamento eliminado";break;
		case 7: //error eliminando departamento
				echo "Ha ocurrido un error eliminando el departamento";break;
	}
	echo '</td></tr>';
}
?>
</table>
<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0" class="tablas">
<tr class="cajaBotonesMedio">
	<td width="10%" class="listado1">&nbsp;</td>
	<td width="20%" class="listado1">
		<span class="e_texto1"><center>
		<input name="btn_accion" type="button" class="botones" id="btn_accion" value="Listado" onClick="ver_listado();" aria-label="Mostrar listado de departamentos en una nueva ventana">
		</center></span>
	</td>
	<td width="20%" class="listado1">
		<span class="e_texto1"><center>
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Agregar" onClick="document.form1.hdBandera.value='A'; return ValidarInformacion();" aria-label="Agregar nuevo departamento">
		</center></span>
	</td>
	<td width="20%" class="listado1">
		<span class="e_texto1"><center>
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Modificar" onClick="document.form1.hdBandera.value='M'; return ValidarInformacion();" aria-label="Guardar cambios realizados al departamento">
		</center></span>
	</td>
	<td width="20%" class="listado1">
		<span class="e_texto1"><center>
		<input name="btn_accion" type="submit" class="botones" id="btn_accion" value="Eliminar" onClick="document.form1.hdBandera.value='E'; return ValidarInformacion();" aria-label="Eliminar departamento seleccionado">
		</center></span>
	</td>
	<td width="10%" class="listado1">&nbsp;</td>
</tr>
</table>
</center>
</form>
</body>
</html>

<script ID="clientEventHandlersJS" LANGUAGE="JavaScript">
<!--
function ValidarInformacion()
{	var strMensaje = "Por favor ingrese las datos.";

	if(document.form1.idcont.value == "0") 
	{	alert("Debe seleccionar el continente.\n" + strMensaje);
		document.form1.idcont.focus();
		return false;
	}
	
	if(document.form1.idpais.value == "0") 
	{	alert("Debe seleccionar el pais.\n" + strMensaje);
		document.form1.idpais.focus();
		return false;
	}
	
	if(document.form1.txtIdDpto.value <= "0") 
	{	alert("Debe ingresar el Codigo del Dpto.\n" + strMensaje);
		document.form1.txtIdDpto.focus();
		return false;
	}
	else if(isNaN(document.form1.txtIdDpto.value))
	{	alert("El Codigo del dpto debe ser numerico.\n" + strMensaje);
		document.form1.txtIdDpto.select();
		document.form1.txtIdDpto.focus();
		return false; 
	}
	
	if(document.form1.hdBandera.value == "A")
	{	if(document.form1.txtModelo.value == "")
		{	alert("Debe ingresar nombre del Dpto.\n" + strMensaje);
			document.form1.txtModelo.focus();
			return false; 
		}
		else
		{	document.form1.submit();	
		}
	}
	else if(document.form1.hdBandera.value == "M")
	{	if(document.form1.txtModelo.value == "")
		{	alert("Primero debe seleccionar el Dpto a modificar.\n" + strMensaje);	
			return false; 
		}
		else
		{	document.form1.submit();	
		}
	}
	else if(document.form1.hdBandera.value == "E") 
	{	if(confirm("Esta seguro de borrar el registro ?\n La eliminación del Dpto incluye sus municipios."))
		{	document.form1.submit();	}
		else
		{	return false;	}
	}
}
//-->
</script>
