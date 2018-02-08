<?php
/** CONSUTLA 001 
	* Estadiscas por medio de recepcion Entrada
	* @autor JAIRO H LOSADA - SSPD
	* @version ORFEO 3.1
	* 
	*/
$coltp3Esp = '"'.$tip3Nombre[3][2].'"';
if(!$orno) $orno=2;
$tmp_substr = $db->conn->substr;
 /**
   * $db-driver Variable que trae el driver seleccionado en la conexion
   * @var string
   * @access public
   */
 /**
   * $fecha_ini Variable que trae la fecha de Inicio Seleccionada  viene en formato Y-m-d
   * @var string
   * @access public
   */
/**
   * $fecha_fin Variable que trae la fecha de Fin Seleccionada
   * @var string
   * @access public
   */
/**
   * $mrecCodi Variable que trae el medio de recepcion por el cual va a sacar el detalle de la Consulta.
   * @var string
   * @access public
   */
switch($db->driver)
{
	case 'mssql':
	case 'postgresql':	
	case 'postgres':	
	{	if($tipoDocumento=='9999')
		{	$queryE = "SELECT b.USUA_NOMB as USUARIO, 
					count(*) as RADICADOS, 
					MIN(USUA_CODI) as HID_COD_USUARIO, 
					MIN(USUA_DOC) as HID_DOC_USUARIO, 
					MIN(depe_codi) as HID_DEPE_USUA 
					FROM RADICADO r 
						INNER JOIN USUARIO b ON r.radi_usua_radi=b.usua_CODI AND $tmp_substr($radi_nume_radi,5,$longitud_codigo_dependencia)=cast(b.depe_codi as varchar($longitud_codigo_dependencia))
					WHERE ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." BETWEEN '$fecha_ini' AND '$fecha_fin' 
						$whereDependencia $whereActivos $whereTipoRadicado 
					GROUP BY b.USUA_NOMB ORDER BY $orno $ascdesc";
		}
		else
		{	$queryE = "SELECT b.USUA_NOMB as USUARIO, 
						count(*) as RADICADOS,
						t.SGD_TPR_DESCRIP as TIPO_DOCUMENTO, 
						MIN(USUA_CODI) as HID_COD_USUARIO, 
						MIN(USUA_DOC) as HID_DOC_USUARIO, 
						MIN(SGD_TPR_CODIGO) as HID_TPR_CODIGO, 
						MIN(depe_codi) as HID_DEPE_USUA
					FROM RADICADO r 
						INNER JOIN USUARIO b ON r.RADI_USUA_RADI = b.USUA_CODI AND $tmp_substr($radi_nume_radi, 5, $longitud_codigo_dependencia) = cast(b.DEPE_CODI as varchar($longitud_codigo_dependencia))
						LEFT OUTER JOIN SGD_TPR_TPDCUMENTO t ON r.TDOC_CODI = t.SGD_TPR_CODIGO
					WHERE ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." BETWEEN '$fecha_ini' AND '$fecha_fin' 
						$whereDependencia $whereActivos $whereTipoRadicado 
					GROUP BY b.USUA_NOMB,t.SGD_TPR_DESCRIP ORDER BY $orno $ascdesc";		
		}
 		/** CONSULTA PARA VER DETALLES 
	 	*/
		//$condicionDep = " AND depe_codi = $depeUs ";
		$condicionDep = ($dependencia_busq==99999) ? " AND depe_codi is not null " : "AND depe_codi = '$dependencia_busq' ";
		//$condicionDep = " AND depe_codi = $dependencia_busq ";
		$condicionE = " AND b.USUA_CODI=$codUs $condicionDep ";
		$queryEDetalle = "SELECT $radi_nume_radi as RADICADO
					,r.RADI_FECH_RADI as FECHA_RADICADO
					,t.SGD_TPR_DESCRIP as TIPO_DE_DOCUMENTO
					,r.RA_ASUN as ASUNTO 
					,r.RADI_DESC_ANEX AS ANEXOS 
					,r.RADI_NUME_HOJA AS N_HOJAS
					,m.MREC_DESC as MEDIO_RECEPCION
					,b.usua_nomb as Usuario
					,r.RADI_PATH as HID_RADI_PATH {$seguridad}
					, dir.SGD_DIR_NOMREMDES as REMITENTE
				FROM RADICADO r
					INNER JOIN USUARIO b ON r.radi_usua_radi=b.usua_CODI AND $tmp_substr($radi_nume_radi,5,$longitud_codigo_dependencia)= cast(b.depe_codi as varchar($longitud_codigo_dependencia))
					LEFT OUTER JOIN SGD_TPR_TPDCUMENTO t ON r.tdoc_codi=t.SGD_TPR_CODIGO 
					LEFT OUTER JOIN MEDIO_RECEPCION m ON r.MREC_CODI = m.MREC_CODI
				 	LEFT OUTER JOIN SGD_DIR_DRECCIONES dir ON r.radi_nume_radi = dir.radi_nume_radi	
				WHERE ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." 
						BETWEEN '$fecha_ini' AND '$fecha_fin' 
						$whereTipoRadicado 
						AND B.USUA_CODI=$codUs AND B.DEPE_CODI='$depeUs'";
					$orderE = "	ORDER BY $orno $ascdesc";
			 /** CONSULTA PARA VER TODOS LOS DETALLES 
			 */ 
		
			$queryETodosDetalle = $queryEDetalle . $condicionDep . $orderE;
			$queryEDetalle .= $condicionE . $orderE;
	}break;
	case 'oracle':
	case 'oci8':
	case 'oci805':
	case 'ocipo':
	{
		if($tipoDocumento=='9999')
		{	$queryE = "SELECT b.USUA_NOMB as USUARIO, 
					count(*) as RADICADOS, 
					MIN(USUA_CODI) as HID_COD_USUARIO, 
					MIN(USUA_DOC) as HID_DOC_USUARIO, 
					MIN(depe_codi) as HID_DEPE_USUA 
					FROM RADICADO r 
						INNER JOIN USUARIO b ON r.radi_usua_radi=b.usua_CODI AND $tmp_substr($radi_nume_radi,5,$longitud_codigo_dependencia)=cast(b.depe_codi as varchar($longitud_codigo_dependencia))
					WHERE ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." BETWEEN '$fecha_ini' AND '$fecha_fin' 
						$whereDependencia $whereActivos $whereTipoRadicado 
					GROUP BY b.USUA_NOMB ORDER BY $orno $ascdesc";
		}
		else
		{	$queryE = "SELECT b.USUA_NOMB as USUARIO, 
						count(*) as RADICADOS,
						t.SGD_TPR_DESCRIP as TIPO_DOCUMENTO, 
						MIN(USUA_CODI) as HID_COD_USUARIO, 
						MIN(USUA_DOC) as HID_DOC_USUARIO, 
						MIN(SGD_TPR_CODIGO) as HID_TPR_CODIGO, 
						MIN(depe_codi) as HID_DEPE_USUA
					FROM RADICADO r 
						INNER JOIN USUARIO b ON r.RADI_USUA_RADI = b.USUA_CODI AND $tmp_substr($radi_nume_radi, 5, $longitud_codigo_dependencia) = cast(b.DEPE_CODI as varchar($longitud_codigo_dependencia))
						LEFT OUTER JOIN SGD_TPR_TPDCUMENTO t ON r.TDOC_CODI = t.SGD_TPR_CODIGO
					WHERE ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." BETWEEN '$fecha_ini' AND '$fecha_fin' 
						$whereDependencia $whereActivos $whereTipoRadicado 
					GROUP BY b.USUA_NOMB,t.SGD_TPR_DESCRIP ORDER BY $orno $ascdesc";		
		}
 		/** CONSULTA PARA VER DETALLES 
	 	*/
		//$condicionDep = " AND depe_codi = $depeUs ";
		$condicionDep = ($dependencia_busq==99999) ? " AND depe_codi is not null " : "AND depe_codi = '$dependencia_busq' ";
		//$condicionDep = " AND depe_codi = $dependencia_busq ";
		$condicionE = " AND b.USUA_CODI=$codUs $condicionDep ";
		$queryEDetalle = "SELECT $radi_nume_radi as RADICADO
					,r.RADI_FECH_RADI as FECHA_RADICADO
					,t.SGD_TPR_DESCRIP as TIPO_DE_DOCUMENTO
					,r.RA_ASUN as ASUNTO 
					,r.RADI_DESC_ANEX AS ANEXOS 
					,r.RADI_NUME_HOJA AS N_HOJAS
					,m.MREC_DESC as MEDIO_RECEPCION
					,b.usua_nomb as Usuario
					,r.RADI_PATH as HID_RADI_PATH {$seguridad}
					, dir.SGD_DIR_NOMREMDES as REMITENTE
				FROM RADICADO r
					INNER JOIN USUARIO b ON r.radi_usua_radi=b.usua_CODI AND $tmp_substr($radi_nume_radi,5,$longitud_codigo_dependencia)= cast(b.depe_codi as varchar($longitud_codigo_dependencia))
					LEFT OUTER JOIN SGD_TPR_TPDCUMENTO t ON r.tdoc_codi=t.SGD_TPR_CODIGO 
					LEFT OUTER JOIN MEDIO_RECEPCION m ON r.MREC_CODI = m.MREC_CODI
				 	LEFT OUTER JOIN SGD_DIR_DRECCIONES dir ON r.radi_nume_radi = dir.radi_nume_radi	
				WHERE ".$db->conn->SQLDate('Y/m/d', 'r.radi_fech_radi')." 
						BETWEEN '$fecha_ini' AND '$fecha_fin' 
						$whereTipoRadicado 
						AND B.USUA_CODI=$codUs AND B.DEPE_CODI='$depeUs'";
					$orderE = "	ORDER BY $orno $ascdesc";
			 /** CONSULTA PARA VER TODOS LOS DETALLES 
			 */ 
		
			$queryETodosDetalle = $queryEDetalle . $condicionDep . $orderE;
			$queryEDetalle .= $condicionE . $orderE;
	}break;
}

if(isset($_GET['genDetalle'])&& $_GET['denDetalle']=1)
	$titulos=array("#","1#RADICADO","2#FECHA RADICADO","3#TIPO DOCUMENTO","4#ASUNTO","5#ANEXOS","6#NO HOJAS","7#MEDIO  DE RECEPCION","8#USUARIO","9#REMITENTE/DESTINATARIO");
else 		
	$titulos=array("#","1#Usuario","2#Radicados");
		
function pintarEstadistica($fila,$indice,$numColumna)
{
	global $ruta_raiz,$_POST,$_GET,$krd;
	$salida="";
    switch ($numColumna)
    {
    	case  0:
        	$salida=$indice;
        	break;
        case 1:	
        	$salida=$fila['USUARIO'];
        	break;
        case 2:
        	$datosEnvioDetalle="tipoEstadistica=".$_POST['tipoEstadistica']."&amp;genDetalle=1&amp;usua_doc=".urlencode($fila['HID_DOC_USUARIO'])."&amp;dependencia_busq=".$_POST['dependencia_busq']."&amp;fecha_ini=".$_POST['fecha_ini']."&amp;fecha_fin=".$_POST['fecha_fin']."&amp;tipoRadicado=".$_POST['tipoRadicado']."&amp;tipoDocumento=".$_POST['tipoDocumento']."&amp;codUs=".$fila['HID_COD_USUARIO']."&amp;depeUs=".$fila['HID_DEPE_USUA'];
	    	$datosEnvioDetalle=(isset($_POST['usActivos']))?$datosEnvioDetalle."&amp;usActivos=".$_POST['usActivos']:$datosEnvioDetalle;
	    	$salida="<a href=\"genEstadistica.php?{$datosEnvioDetalle}&amp;krd={$krd}\"  target=\"detallesSec\" >".$fila['RADICADOS']."</a>";
        	break;
        default: $salida=false;
			break;
	}
	return $salida;
}

function pintarEstadisticaDetalle($fila,$indice,$numColumna)
{
	global $ruta_raiz,$encabezado,$krd;
	$verImg=($fila['SGD_SPUB_CODIGO']==1)?($fila['USUARIO']!=$_SESSION['usua_nomb']?false:true):($fila['USUA_NIVEL']>$_SESSION['nivelus']?false:true);
    $numRadicado=$fila['RADICADO'];	
	switch ($numColumna)
	{
		case 0:
			$salida=$indice;
			break;
		case 1:
			if($fila['HID_RADI_PATH'] && $verImg){
                            $rutaBodega = (substr($fila['HID_RADI_PATH'], 0,1)=='/')?$fila['HID_RADI_PATH']:"/".$fila['HID_RADI_PATH'];
                            // Verifico si tiene / al inicio, los registros .pdf no lo tienen y la ruta se crea mal, los docx si lo tienen, por eso no solo se concatena
				//$salida="<center><a href=\"{$ruta_raiz}bodega".$fila['HID_RADI_PATH']."\">".$fila['RADICADO']."</a></center>";
				$salida="<center><a href=\"{$ruta_raiz}bodega".$rutaBodega."\">".$fila['RADICADO']."</a></center>";
                        }else {
				$salida="<center class=\"leidos\">{$numRadicado}</center>";	
                        }
			break;
		case 2:
			if($verImg)
				$salida="<a class=\"vinculos\" href=\"{$ruta_raiz}verradicado.php?verrad=".$fila['RADICADO']."&amp;".session_name()."=".session_id()."&amp;krd=".$_GET['krd']."&amp;carpeta=8&amp;nomcarpeta=Busquedas&amp;tipo_carp=0 \" >".$fila['FECHA_RADICADO']."</a>";
			else 
				$salida="<a class=\"vinculos\" href=\"#\" onclick=\"alert(\"ud no tiene permisos para ver el radicado\");\">".$fila['FECHA_RADICADO']."</a>";
			break;
		case 3:
                    
			$salida="<center class=\"leidos\">".$fila['TIPO_DE_DOCUMENTO']."</center>";		
			break;
		case 4:
			$salida="<center class=\"leidos\">".$fila['ASUNTO']."</center>";
			break;
		case 5:
			$salida="<center class=\"leidos\">".$fila['ANEXOS']."</center>";
			break;
		case 6:
			$salida="<center class=\"leidos\">".$fila['N_HOJAS']."</center>";			
			break;	
		case 7:
			$salida="<center class=\"leidos\">".$fila['MEDIO_RECEPCION']."</center>";			
			break;	
		case 8:
			$salida="<center class=\"leidos\">".$fila['USUARIO']."</center>";			
			break;	
		case 9:
			$salida="<center class=\"leidos\">".$fila['REMITENTE']."</center>";			
			break;	
		case 10:
			$salida="<center class=\"leidos\">".$fila['SECTOR']."</center>";			
			break;
		case 11:
			$salida="<center class=\"leidos\">".$fila['CAUSAL']."</center>";			
			break;
		case 12:
			$salida="<center class=\"leidos\">".$fila['DETALLE_CAUSAL']."</center>";			
			break;
	}
	return $salida;
}
?>
