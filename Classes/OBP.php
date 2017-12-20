<?php
	include 'OBC.php';

	if ($_GET) {
		if (strcmp($_GET["fa"], 'FOD') == 0) {
			$file="FOD_" . date("Y-m-d H.i.s") . ".xls";
			$content="<meta http-equiv='Content-Type' content='text/html; charset=utf-8' /><table>
        <thead> <tr> 
          <th>TES</th>
          <th>NOMBRE</th> 
          <th>ESTADO</th> 
          <th>CRITICIDAD</th> 
          <th>FECHA DE CONSTRUCCION</th> 
          <th>TIPIFICACION</th> 
          <th>RESPONSABLE DE ZONA</th> 
          <th>ZONA</th> 
          <th>ZONA GEOGRAFICA</th> 
          <th>AREA</th> 
          <th>DEPARTAMENTO</th> 
          <th>MUNICIPIO</th> 
          <th>DIRECCION</th> 
          <th>LATITUD</th> 
          <th>LONGITUD</th> 
          <th>DUEÑO DE SITIO</th> 
          <th>TIPO DE CUENTA</th> 
          <th>ESTADO DE CONTRATO</th> 
          <th>TIPO DE COBERTURA</th> 
          <th>FORMA DE ACCESO</th> 
          <th>CONTACTO DE ACCESO</th> 
          <th>RESTRICCION DE ACCESO</th> 
          <th>PELIGROSIDAD</th> 
          <th>TIPO DE ESTRUCTURA</th> 
          <th>ALTURA</th> 
          <th>TIPO DE HIERRO</th> 
          <th>TIPO DE MURO PERIMETRAL</th> 
          <th>TIPO DE MATERIAL SHELTER</th> 
          <th>OPERADORES COUBICADOS</th> 
          <th>NIC</th> 
          <th>COMENTARIOS DE CONEXION ELECTRICA</th> 
          <th>COMPAÑIA ELECTRICA</th> 
          <th>MEDIDOR DE ENERGIA</th> 
          <th>LINEA ELECTRICA</th> 
          <th>CAPACIDAD DE TRANSFORMADOR (KVA)</th> 
          <th>MARCA DE GENSET</th> 
          <th>MODELO DE GENSET</th> 
          <th>CAPACIDAD DE GENSET (KVA)</th> 
          <th>CAPACIDAD DE TANQUE (Galones)</th> 
          <th>ESTADO DE GENERADOR</th> 
          <th>MARCA DE ATS</th> 
          <th>CAPACIDAD DE ATS</th> 
          <th>ESTADO DE ATS</th> 
          <th>GSM NEMONICO</th> 
          <th>UMTS NEMONICO</th> 
          <th>LTE NEMONICO</th> 
          <th>CLUSTER NAME</th> 
          <th>GSM LAUNCH DATE</th> 
          <th>UMTS LAUNCH DATE</th> 
          <th>LTE LAUNCH DATE</th> 
          <th>UMTS CARRIER 1</th> 
          <th>UMTS CARRIER 2</th> 
          <th>UMTS CARRIER 3</th> 
          <th>LTE CELLS</th> 
          <th>RRUs POR SITE</th> 
          <th>ANTENAS POR SITE</th> 
          <th>2G TX TYPE</th> 
          <th>2G TX MARCA</th> 
          <th>3G TX TYPE</th> 
          <th>3G TX MARCA</th> 
          <th>4G TX TYPE</th> 
          <th>4G TX MARCA</th> 
          <th>GABINETE MODELO 1</th> 
          <th>RECTIFIER TYPE CAB 1</th> 
          <th>MARCA DE BATERIAS CAB 1</th> 
          <th>NUMERO DE BATERIAS CAB 1</th> 
          <th>AUTONOMIA DE GABINETE 1 (horas)</th> 
          <th>GABINETE MODELO 2</th> 
          <th>RECTIFIER TYPE CAB 2</th> 
          <th>MARCA DE BATERIAS CAB 2</th> 
          <th>NUMERO DE BATERIAS CAB 2</th> 
          <th>AUTONOMIA DE GABINETE 2 (HORAS)</th> 
          <th>GABINETE MODELO 3</th> 
          <th>RECTIFIER TYPE CAB 3</th> 
          <th>MARCA DE BATERIAS CAB 3</th> 
          <th>NUMERO DE BATERIAS CAB 3</th> 
          <th>AUTONOMIA DE GABINETE 3 (horas)</th> 
          <th>MINISHELTER 1</th> 
          <th>RECTIFIER TYPE MINISHELTER 1</th> 
          <th>MARCA DE BATERIAS MINISHELTER 1</th> 
          <th>NUMERO DE BATERIAS MINISHELTER 1</th> 
          <th>AUTONOMIA DE MINISHELTER 1 (horas)</th> 
          <th>MINISHELTER 2</th> 
          <th>RECTIFIER TYPE MINISHELTER 2</th> 
          <th>MARCA DE BATERIAS MINISHELTER 2</th> 
          <th>NUMERO DE BATERIAS MINISHELTER 2</th> 
          <th>AUTONOMIA DE MINISHELTER 2 (HORAS)</th> 
          <th>GABINETE ERICSSON 1</th> 
          <th>GABINETE ERICSSON 2</th> 
          <th>MARCA DE FUERZA 1</th> 
          <th>MODELO DE FUERZA 1</th> 
          <th>VOLTAGE DE SALIDA DE FUERZA 1</th> 
          <th>MARCA DE BATERIAS DE FUERZA 1</th> 
          <th>NUMERO DE BATERIAS DE FUERZA 1</th> 
          <th>CAPACIDAD DE AH FUERZA 1</th> 
          <th>MARCA DE FUERZA 2</th> 
          <th>MODELO DE FUERZA 2</th> 
          <th>VOLTAGE DE SALIDA DE FUERZA 2</th> 
          <th>MARCA DE BATERIAS DE FUERZA 2</th> 
          <th>NUMERO DE BATERIAS DE FUERZA 2</th> 
          <th>CAPACIDAD DE AH FUERZA 2</th> 
        <tbody>";

	        $oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMMFOD()");

			foreach ($ret as $row) {
				$content = $content . '<tr><td>' . $row["tes_id"] . '</td>';
				$content = $content . '<td>' . $row["nombre"] . '</td>';
				$content = $content . '<td>' . $row["estado"] . '</td>';
				$content = $content . '<td>' . $row["criticidad"] . '</td>';
				$content = $content . '<td>' . $row["fecha_construccion"] . '</td>';
				$content = $content . '<td>' . $row["tipificacion"] . '</td>';
				$content = $content . '<td>Responsable de Zona</td>';
				$content = $content . '<td>' . $row["zona"] . '</td>';
				$content = $content . '<td>' . $row["zona_geografica"] . '</td>';
				$content = $content . '<td>' . $row["area"] . '</td>';
				$content = $content . '<td>' . $row["departamento"] . '</td>';
				$content = $content . '<td>' . $row["municipio"] . '</td>';
				$content = $content . '<td>' . $row["direccion"] . '</td>';
				$content = $content . '<td>' . $row["latitud"] . '</td>';
				$content = $content . '<td>' . $row["longitud"] . '</td>';
				$content = $content . '<td>' . $row["dueño_sitio"] . '</td>';
				$content = $content . '<td>' . $row["tipo_cuenta"] . '</td>';
				$content = $content . '<td>' . $row["estado_contrato"] . '</td>';
				$content = $content . '<td>' . $row["tipo_cobertura"] . '</td>';
				$content = $content . '<td>' . $row["forma_acceso"] . '</td>';
				$content = $content . '<td>' . $row["contacto_acceso"] . '</td>';
				$content = $content . '<td>' . $row["restriccion_acceso"] . '</td>';
				$content = $content . '<td>' . $row["peligrosidad"] . '</td>';
				$content = $content . '<td>' . $row["tipo_estructura"] . '</td>';
				$content = $content . '<td>' . $row["altura"] . '</td>';
				$content = $content . '<td>' . $row["tipo_hierro"] . '</td>';
				$content = $content . '<td>' . $row["tipo_muro_perimetral"] . '</td>';
				$content = $content . '<td>' . $row["tipo_material_shelter"] . '</td>';
				$content = $content . '<td>Operadores coubidados</td>';
				$content = $content . '<td>' . $row["nic"] . '</td>';
				$content = $content . '<td>' . $row["comentarios_conexion_electrica"] . '</td>';
				$content = $content . '<td>' . $row["comp_electrica"] . '</td>';
				$content = $content . '<td>' . $row["medidor_energia"] . '</td>';
				$content = $content . '<td>' . $row["linea_electrica"] . '</td>';
				$content = $content . '<td>' . $row["capacidad_transformador"] . '</td>';
				$content = $content . '<td>' . $row["marca_genset"] . '</td>';
				$content = $content . '<td>' . $row["modelo_genset"] . '</td>';
				$content = $content . '<td>' . $row["capacidad_genset"] . '</td>';
				$content = $content . '<td>' . $row["capacidad_tanque"] . '</td>';
				$content = $content . '<td>' . $row["estado_generador"] . '</td>';
				$content = $content . '<td>' . $row["marca_ats"] . '</td>';
				$content = $content . '<td>' . $row["capacidad_ats"] . '</td>';
				$content = $content . '<td>' . $row["estado_ats"] . '</td>';
				$content = $content . '<td>' . $row["gsm_nemonico"] . '</td>';
				$content = $content . '<td>' . $row["umts_nemonico"] . '</td>';
				$content = $content . '<td>' . $row["lte_nemonico"] . '</td>';
				$content = $content . '<td>' . $row["cluster_name"] . '</td>';
				$content = $content . '<td>' . $row["gsm_launch"] . '</td>';
				$content = $content . '<td>' . $row["umts_launch"] . '</td>';
				$content = $content . '<td>' . $row["lte_launch"] . '</td>';
				$content = $content . '<td>' . $row["umts_carrier1"] . '</td>';
				$content = $content . '<td>' . $row["umts_carrier2"] . '</td>';
				$content = $content . '<td>' . $row["umts_carrier3"] . '</td>';
				$content = $content . '<td>' . $row["lte_cells"] . '</td>';
				$content = $content . '<td>' . $row["rrus_site"] . '</td>';
				$content = $content . '<td>' . $row["antenas_site"] . '</td>';
				$content = $content . '<td>' . $row["2g_tx_type"] . '</td>';
				$content = $content . '<td>' . $row["2g_tx_marca"] . '</td>';
				$content = $content . '<td>' . $row["3g_tx_type"] . '</td>';
				$content = $content . '<td>' . $row["3g_tx_marca"] . '</td>';
				$content = $content . '<td>' . $row["4g_tx_type"] . '</td>';
				$content = $content . '<td>' . $row["4g_tx_marca"] . '</td>';
				$content = $content . '<td>' . $row["modelo_gabinete1"] . '</td>';
				$content = $content . '<td>' . $row["rectifier_type_cab1"] . '</td>';
				$content = $content . '<td>' . $row["marca_bateria_cab1"] . '</td>';
				$content = $content . '<td>' . $row["numero_bateria_cab1"] . '</td>';
				$content = $content . '<td>' . $row["autonomia_gabinete1"] . '</td>';
				$content = $content . '<td>' . $row["modelo_gabinete2"] . '</td>';
				$content = $content . '<td>' . $row["rectifier_type_cab2"] . '</td>';
				$content = $content . '<td>' . $row["marca_bateria_cab2"] . '</td>';
				$content = $content . '<td>' . $row["numero_bateria_cab2"] . '</td>';
				$content = $content . '<td>' . $row["autonomia_gabinete2"] . '</td>';
				$content = $content . '<td>' . $row["modelo_gabinete3"] . '</td>';
				$content = $content . '<td>' . $row["rectifier_type_cab3"] . '</td>';
				$content = $content . '<td>' . $row["marca_bateria_cab3"] . '</td>';
				$content = $content . '<td>' . $row["numero_bateria_cab3"] . '</td>';
				$content = $content . '<td>' . $row["autonomia_gabinete3"] . '</td>';
				$content = $content . '<td>' . $row["minishelter1"] . '</td>';
				$content = $content . '<td>' . $row["rectifier_type_minishelter1"] . '</td>';
				$content = $content . '<td>' . $row["marca_bateria_minishelter1"] . '</td>';
				$content = $content . '<td>' . $row["numero_bateria_minishelter1"] . '</td>';
				$content = $content . '<td>' . $row["autonomia_minishelter1"] . '</td>';
				$content = $content . '<td>' . $row["minishelter2"] . '</td>';
				$content = $content . '<td>' . $row["rectifier_type_minishelter2"] . '</td>';
				$content = $content . '<td>' . $row["marca_bateria_minishelter2"] . '</td>';
				$content = $content . '<td>' . $row["numero_bateria_minishelter2"] . '</td>';
				$content = $content . '<td>' . $row["autonomia_minishelter2"] . '</td>';
				$content = $content . '<td>' . $row["gabinete_ericsson1"] . '</td>';
				$content = $content . '<td>' . $row["gabinete_ericsson2"] . '</td>';
				$content = $content . '<td>' . $row["marca_fuerza1"] . '</td>';
				$content = $content . '<td>' . $row["modelo_fuerza1"] . '</td>';
				$content = $content . '<td>' . $row["voltage_salida_fuerza1"] . '</td>';
				$content = $content . '<td>' . $row["marca_bateria_fuerza1"] . '</td>';
				$content = $content . '<td>' . $row["numero_bateria_fuerza1"] . '</td>';
				$content = $content . '<td>' . $row["capacidad_fuerza1"] . '</td>';
				$content = $content . '<td>' . $row["marca_fuerza2"] . '</td>';
				$content = $content . '<td>' . $row["modelo_fuerza2"] . '</td>';
				$content = $content . '<td>' . $row["voltage_salida_fuerza2"] . '</td>';
				$content = $content . '<td>' . $row["marca_bateria_fuerza2"] . '</td>';
				$content = $content . '<td>' . $row["numero_bateria_fuerza2"] . '</td>';
				$content = $content . '<td>' . $row["capacidad_fuerza2"] . '</td>';
			}
	        $content = $content . "</tbody>";
	        $content = $content . "</table>";
			header("Content-Type: application/vnd.ms-excel charset=utf-8");
			header("Content-Disposition: attachment; filename=$file");
			echo $content;
			return;
		}
	}

	if ($_POST["fa"]) {
		if (strcmp($_POST["fa"], "deptmun") == 0) {

			$oOBC = new OBC;
			$dbSelOpt = $oOBC->DBQuote($_POST['selected_opt']);
			$ret = $oOBC->PDODBConnection("CALL pMunicipioDept(" . $dbSelOpt . ")");
			foreach ($ret as $row) {
				//echo $row["id"];
				//echo $row["nombre"];
				echo $row["id"] . "@" . $row["nombre"] . "@@";
			}
			//echo [
			//    "1" => "First",
			//    "2" => "Second",
			//];
			//echo $array;
		}
	}
?>