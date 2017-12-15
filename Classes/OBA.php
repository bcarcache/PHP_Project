<?php
	include 'OBC.php';
	include 'OBE.php';

	class OBA {
		function ValidarSesion() {
			$oOBC = new OBC;

			if (!$_SESSION) {
				//Validacion de Redireccion
				if (!$_POST['inputUsuario']) {
					//$page = "Login.php?lga=1";
	        		$page = "Login.php";
					header("Location: " . $page); /* Redirect browser */
					exit();
				}

				//Inicializacion y validacion de login-usuario
				$ret = $oOBC->PDODBConnection("CALL pHacerLogin('" . $_POST['inputUsuario'] . "','" . base64_encode($_POST['inputPassword']) . "')");
				foreach ($ret as $row) {
					$_SESSION["idPerfil"] = $row["id_perfil"];
					$_SESSION["usuario"] = $row["nombres"] . " " . $row["apellidos"];
				}
				if (!$_SESSION["idPerfil"] || !$_SESSION["usuario"]) {
					$page = "Login.php";
					header("Location: " . $page); /* Redirect browser */
					exit();
				}
			}
		}

		function MostrarMenuApp() {
			$oOBC = new OBC;

			if ($_SESSION["idPerfil"]) {
				echo '<nav class="navbar navbar-expand-md navbar-light bg-light rounded mb-3">';
          		echo '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">';
            	echo '<span class="navbar-toggler-icon"></span>';
				echo '</button>';
				echo '<div class="collapse navbar-collapse" id="navbarCollapse">';
            	echo '<ul class="navbar-nav text-md-center nav-justified w-100">';

				//Dropdown Menu Counter
				$dpcount = 1;

				//Menu Level 1
				$ret = $oOBC->PDODBConnection("CALL pMenuPerfilN1(" . $_SESSION["idPerfil"] . ")");
				foreach ($ret as $row) {
					if ($row["pagina"]) {
						echo '<li class="nav-item">';
						echo '<a class="nav-link" href="' . $row["pagina"] . '">' . $row["nombre"] . '</a>';
						echo '</li>';
					} else {
						//Menu Level 2
						echo '<li class="nav-item dropdown">';
						echo '<a class="nav-link dropdown-toggle" href="" id="dropdown' . $dpcount . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . $row["nombre"] . '</a>';
						echo '<div class="dropdown-menu" aria-labelledby="dropdown' . $dpcount . '">';
						$ret2 = $oOBC->PDODBConnection("CALL pMenuPerfilN2(" . $_SESSION["idPerfil"] . "," . $row["id"] . ")");
						foreach ($ret2 as $row2) {
							echo '<a class="dropdown-item" href="' . $row2["pagina"] . '">' . $row2["nombre"] . '</a>';
						}
						echo '</div></li>';
						$dpcount++;
					}
				}

				echo '<li class="nav-item">';
				echo '<a class="nav-link" href="Login.php?lga=1">Salir</a>';
				echo '</li>';
            	echo '</ul>';
          		echo '</div>';
        		echo '</nav>';
			}
		}

		function FrmFOD3C() {
			$oOBC = new OBC;
			$idSiteVal = '';
			$siteVal1 = $siteVal2 = $siteVal3 = $siteVal4 = $siteVal5 = $siteVal6 = $siteVal7 = $siteVal8 = $siteVal9 = $siteVal10 = '';
			$siteVal11 = $siteVal12 = $siteVal13 = $siteVal14 = $siteVal15 = $siteVal16 = $siteVal17 = $siteVal18 = $siteVal19 = $siteVal20 = '';
			$siteVal21 = $siteVal22 = $siteVal23 = $siteVal24 = $siteVal25 = $siteVal26 = $siteVal27 = $siteVal28 = $siteVal29 = $siteVal30 = '';
			$siteVal31 = $siteVal32 = $siteVal33 = $siteVal34 = $siteVal35 = $siteVal36 = $siteVal37 = $siteVal38 = $siteVal39 = $siteVal40 = '';
			$siteVal41 = $siteVal42 = $siteVal43 = $siteVal44 = $siteVal45 = $siteVal46 = $siteVal47 = $siteVal48 = $siteVal49 = $siteVal50 = '';
			$siteVal51 = $siteVal52 = $siteVal53 = $siteVal54 = $siteVal55 = $siteVal56 = $siteVal57 = $siteVal58 = $siteVal59 = $siteVal60 = '';
			$siteVal61 = $siteVal62 = $siteVal63 = $siteVal64 = $siteVal65 = $siteVal66 = $siteVal67 = $siteVal68 = $siteVal69 = $siteVal70 = '';
			$siteVal71 = $siteVal72 = $siteVal73 = $siteVal74 = $siteVal75 = $siteVal76 = $siteVal77 = $siteVal78 = $siteVal79 = $siteVal80 = '';
			$siteVal81 = $siteVal82 = $siteVal83 = $siteVal84 = $siteVal85 = $siteVal86 = $siteVal87 = $siteVal88 = $siteVal89 = $siteVal90 = '';
			$siteVal91 = $siteVal92 = $siteVal93 = $siteVal94 = $siteVal95 = $siteVal96 = $siteVal97 = $siteVal98 = $siteVal99 = $siteVal100 = '';
			$siteVal101 = $siteVal102 = $siteVal103 = $siteVal104 = $siteVal105 = $siteVal106 = $siteVal107 = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idSite']) {
					$idSite = $_POST['idSite'];
				} else {
					$idSite = 0;
				}

				$tes_id = $oOBC->DBQuote($_POST['inputTesId']);
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$estado = $oOBC->DBQuote($_POST['selectEstado']);
				$criticidad = $oOBC->DBQuote($_POST['selectCriticidad']);
				$fechaConstruccion = $oOBC->DBQuote($_POST['inputFechaConstruccion']);
				$tipificacion = $oOBC->DBQuote($_POST['selectTipificacion']);
				$zona = $oOBC->DBQuote($_POST['selectZona']);
				$zonaGeografica = $oOBC->DBQuote($_POST['selectZonaGeografica']);
				$area = $oOBC->DBQuote($_POST['selectArea']);
				$departamento = $oOBC->DBQuote($_POST['selectDepartamento']);
				$municipio = $oOBC->DBQuote($_POST['selectMunicipio']);
				$direccion = $oOBC->DBQuote($_POST['inputDireccion']);
				if (trim($_POST['inputLatitud']) == "") {
					$latitud = "NULL";
				} else {
					$latitud = $_POST['inputLatitud'];
				}

				if (trim($_POST['inputLatitud']) == "") {
					$longitud = "NULL";
				} else {
					$longitud = $_POST['inputLongitud'];
				}
				$dueñoSitio = $oOBC->DBQuote($_POST['inputDueñoSitio']);
				$tipoCuenta = $oOBC->DBQuote($_POST['selectTipoCuenta']);
				$estadoContrato = $oOBC->DBQuote($_POST['selectEstadoContrato']);
				$tipoCobertura = $oOBC->DBQuote($_POST['selectTipoCobertura']);
				$formaAcceso = $oOBC->DBQuote($_POST['inputFormaAcceso']);
				$contactoAcceso = $oOBC->DBQuote($_POST['inputContactoAcceso']);
				$restriccionAcceso = $oOBC->DBQuote($_POST['inputRestriccionAcceso']);
				$peligrosidad = $oOBC->DBQuote($_POST['selectPeligrosidad']);
				$tipoEstructura = $oOBC->DBQuote($_POST['selectTipoEstructura']);
				if (trim($_POST['inputAltura']) == "") {
					$altura = "NULL";
				} else {
					$altura = $_POST['inputAltura'];
				}
				$tipoHierro = $oOBC->DBQuote($_POST['selectTipoHierro']);
				$tipoMuroPerimetral = $oOBC->DBQuote($_POST['selectTipoMuroPerimetral']);
				$tipoMaterialShelter = $oOBC->DBQuote($_POST['selectTipoMaterialShelter']);
				if (trim($_POST['inputNIC']) == "") {
					$NIC = "NULL";
				} else {
					$NIC = $_POST['inputNIC'];
				}
				$comConElectrica = $oOBC->DBQuote($_POST['inputComConElectrica']);
				$compElectrica = $oOBC->DBQuote($_POST['selectCompElectrica']);
				$medidorEnergia = $oOBC->DBQuote($_POST['inputMedidorEnergia']);
				$lineaElectrica = $oOBC->DBQuote($_POST['selectLineaElectrica']);
				if (trim($_POST['inputCapTransformador']) == "") {
					$capTransformador = "NULL";
				} else {
					$capTransformador = $_POST['inputCapTransformador'];
				}
				$marcaGenset = $oOBC->DBQuote($_POST['inputMarcaGenset']);
				$modeloGenset = $oOBC->DBQuote($_POST['inputModeloGenset']);
				if (trim($_POST['inputCapacidadGenset']) == "") {
					$capacidadGenset = "NULL";
				} else {
					$capacidadGenset = $_POST['inputCapacidadGenset'];
				}

				if (trim($_POST['inputCapacidadTanque']) == "") {
					$capacidadTanque = "NULL";
				} else {
					$capacidadTanque = $_POST['inputCapacidadTanque'];
				}
				$estadoGenerador = $oOBC->DBQuote($_POST['selectEstadoGenerador']);
				$marcaATS = $oOBC->DBQuote($_POST['inputMarcaATS']);
				$capacidadATS = $oOBC->DBQuote($_POST['inputCapacidadATS']);
				$estadoATS = $oOBC->DBQuote($_POST['inputEstadoATS']);
				$GSMNemonico = $oOBC->DBQuote($_POST['inputGSMNemonico']);
				$UMTSNemonico = $oOBC->DBQuote($_POST['inputUMTSNemonico']);
				$LTENemonico = $oOBC->DBQuote($_POST['inputLTENemonico']);
				$clusterName = $oOBC->DBQuote($_POST['inputClusterName']);
				if (trim($_POST['inputGSMLaunchDate']) == "") {
					$GSMLaunchDate = "NULL";
				} else {
					$GSMLaunchDate = $oOBC->DBQuote($_POST['inputGSMLaunchDate']);
				}
				if (trim($_POST['inputUMTSLaunchDate']) == "") {
					$UMTSLaunchDate = "NULL";
				} else {
					$UMTSLaunchDate = $oOBC->DBQuote($_POST['inputUMTSLaunchDate']);
				}
				if (trim($_POST['inputLTELaunchDate']) == "") {
					$LTELaunchDate = "NULL";
				} else {
					$LTELaunchDate = $oOBC->DBQuote($_POST['inputLTELaunchDate']);
				}
				
				$UMTSC1 = $oOBC->DBQuote($_POST['selectUMTSC1']);
				$UMTSC2 = $oOBC->DBQuote($_POST['selectUMTSC2']);
				$UMTSC3 = $oOBC->DBQuote($_POST['selectUMTSC3']);
				$LTECells = $oOBC->DBQuote($_POST['selectLTECells']);
				if (trim($_POST['inputRRUSSite']) == "") {
					$RRUSSite = "NULL";
				} else {
					$RRUSSite = $_POST['inputRRUSSite'];
				}
				if (trim($_POST['inputAntenasSite']) == "") {
					$antenasSite = "NULL";
				} else {
					$antenasSite = $_POST['inputAntenasSite'];
				}
				$GTXType2 = $oOBC->DBQuote($_POST['select2GTXType']);
				$GTXMarca2 = $oOBC->DBQuote($_POST['input2GTXMarca']);
				$GTXType3 = $oOBC->DBQuote($_POST['select3GTXType']);
				$GTXMarca3 = $oOBC->DBQuote($_POST['input3GTXMarca']);
				$GTXType4 = $oOBC->DBQuote($_POST['select4GTXType']);
				$GTXMarca4 = $oOBC->DBQuote($_POST['input4GTXMarca']);
				$modeloGabinete1 = $oOBC->DBQuote($_POST['selectModeloGabinete1']);
				$rectTypeCab1 = $oOBC->DBQuote($_POST['selectRectTypeCab1']);
				$marcaBateriasCab1 = $oOBC->DBQuote($_POST['inputMarcaBateriasCab1']);
				if (trim($_POST['inputNumBateriasCab1']) == "") {
					$numBateriasCab1 = "NULL";
				} else {
					$numBateriasCab1 = $_POST['inputNumBateriasCab1'];
				}
				$autGabinete1 = $oOBC->DBQuote($_POST['inputAutGabinete1']);
				$modeloGabinete2 = $oOBC->DBQuote($_POST['selectModeloGabinete2']);
				$rectTypeCab2 = $oOBC->DBQuote($_POST['selectRectTypeCab2']);
				$marcaBateriasCab2 = $oOBC->DBQuote($_POST['inputMarcaBateriasCab2']);
				if (trim($_POST['inputNumBateriasCab2']) == "") {
					$numBateriasCab2 = "NULL";
				} else {
					$numBateriasCab2 = $_POST['inputNumBateriasCab2'];
				}
				$autGabinete2 = $oOBC->DBQuote($_POST['inputAutGabinete2']);
				$modeloGabinete3 = $oOBC->DBQuote($_POST['selectModeloGabinete3']);
				$rectTypeCab3 = $oOBC->DBQuote($_POST['selectRectTypeCab3']);
				$marcaBateriasCab3 = $oOBC->DBQuote($_POST['inputMarcaBateriasCab3']);
				if (trim($_POST['inputNumBateriasCab3']) == "") {
					$numBateriasCab3 = "NULL";
				} else {
					$numBateriasCab3 = $_POST['inputNumBateriasCab3'];
				}
				$autGabinete3 = $oOBC->DBQuote($_POST['inputAutGabinete3']);
				$minishelter1 = $oOBC->DBQuote($_POST['inputMinishelter1']);
				$rectTypeMin1 = $oOBC->DBQuote($_POST['selectRectTypeMin1']);
				$marcaBateriasMin1 = $oOBC->DBQuote($_POST['inputMarcaBateriasMin1']);
				if (trim($_POST['inputNumBateriasMin1']) == "") {
					$numBateriasMin1 = "NULL";
				} else {
					$numBateriasMin1 = $_POST['inputNumBateriasMin1'];
				}
				$autMinishelter1 = $oOBC->DBQuote($_POST['inputAutMinishelter1']);
				$minishelter2 = $oOBC->DBQuote($_POST['inputMinishelter2']);
				$rectTypeMin2 = $oOBC->DBQuote($_POST['selectRectTypeMin2']);
				$marcaBateriasMin2 = $oOBC->DBQuote($_POST['inputMarcaBateriasMin2']);
				$marcaBateriasMin1 = $oOBC->DBQuote($_POST['inputMarcaBateriasMin1']);
				if (trim($_POST['inputNumBateriasMin2']) == "") {
					$numBateriasMin2 = "NULL";
				} else {
					$numBateriasMin2 = $_POST['inputNumBateriasMin2'];
				}
				$autMinishelter = $oOBC->DBQuote($_POST['inputAutMinishelter2']);
				$modeloGabineteE1 = $oOBC->DBQuote($_POST['selectModeloGabineteE1']);
				$modeloGabineteE2 = $oOBC->DBQuote($_POST['selectModeloGabineteE2']);
				$marcaFuerza1 = $oOBC->DBQuote($_POST['inputMarcaFuerza1']);
				$modeloFuerza1 = $oOBC->DBQuote($_POST['inputModeloFuerza1']);
				if (trim($_POST['inputVoltageSalidaF1']) == "") {
					$voltageSalidaF1 = "NULL";
				} else {
					$voltageSalidaF1 = $_POST['inputVoltageSalidaF1'];
				}
				$marcaBateriasF1 = $oOBC->DBQuote($_POST['inputMarcaBateriasF1']);
				if (trim($_POST['inputNumeroBateriasF1']) == "") {
					$numeroBateriasF1 = "NULL";
				} else {
					$numeroBateriasF1 = $_POST['inputNumeroBateriasF1'];
				}
				if (trim($_POST['inputCapacidadAHF1']) == "") {
					$capacidadAHF1 = "NULL";
				} else {
					$capacidadAHF1 = $_POST['inputCapacidadAHF1'];
				}
				$marcaFuerza2 = $oOBC->DBQuote($_POST['inputMarcaFuerza2']);
				$modeloFuerza2 = $oOBC->DBQuote($_POST['inputModeloFuerza2']);
				if (trim($_POST['inputVoltageSalidaF2']) == "") {
					$voltageSalidaF2 = "NULL";
				} else {
					$voltageSalidaF2 = $_POST['inputVoltageSalidaF2'];
				}
				$marcaBateriasF2 = $oOBC->DBQuote($_POST['inputMarcaBateriasF2']);
				if (trim($_POST['inputNumeroBateriasF2']) == "") {
					$numeroBateriasF2 = "NULL";
				} else {
					$numeroBateriasF2 = $_POST['inputNumeroBateriasF2'];
				}
				if (trim($_POST['inputCapacidadAHF2']) == "") {
					$capacidadAHF2 = "NULL";
				} else {
					$capacidadAHF2 = $_POST['inputCapacidadAHF2'];
				}
				$dbUsuario = $oOBC->DBQuote($_SESSION["usuario"]);

				error_log("CALL pMttoFOD(" . $idSite . "," . $tes_id . "," . $nombre . "," . $estado . "," . $criticidad . "," . $fechaConstruccion . "," . $tipificacion . "," . $zona . "," . $zonaGeografica . "," . $area . "," . $departamento . "," . $municipio . "," . $direccion . "," . $latitud . "," . $longitud . "," . $dueñoSitio . "," . $tipoCuenta . "," . $estadoContrato . "," . $tipoCobertura . "," . $formaAcceso  . "," . $contactoAcceso . "," . $restriccionAcceso . "," . $peligrosidad . "," . $tipoEstructura  . "," . $altura . "," . $tipoHierro . "," . $tipoMuroPerimetral . "," . $tipoMaterialShelter . "," . $NIC . "," . $comConElectrica . "," . $compElectrica . "," . $medidorEnergia . "," . $lineaElectrica . "," . $capTransformador . "," . $marcaGenset . "," . $modeloGenset . "," . $capacidadGenset . "," . $capacidadTanque . "," . $estadoGenerador . "," . $marcaATS . "," . $capacidadATS . "," . $estadoATS . "," . $GSMNemonico . "," . $UMTSNemonico . "," . $LTENemonico . "," . $clusterName . "," . $GSMLaunchDate . "," . $UMTSLaunchDate . "," . $LTELaunchDate . "," . $UMTSC1 . "," . $UMTSC2 . "," . $UMTSC3 . "," . $LTECells . "," . $RRUSSite . "," . $antenasSite . "," . $GTXType2 . "," . $GTXMarca2 . "," . $GTXType3 . "," . $GTXMarca3 . "," . $GTXType4 . "," . $GTXMarca4 . "," . $modeloGabinete1 . "," . $rectTypeCab1 . "," . $marcaBateriasCab1 . "," . $numBateriasCab1 . "," . $autGabinete1 . "," . $modeloGabinete2 . "," . $rectTypeCab2 . "," . $marcaBateriasCab2 . "," . $numBateriasCab2 . "," . $autGabinete2 . "," . $modeloGabinete3 . "," . $rectTypeCab3 . "," . $marcaBateriasCab3 . "," . $numBateriasCab3 . "," . $autGabinete3 . "," . $minishelter1 . "," . $rectTypeMin1 . "," . $marcaBateriasMin1 . "," . $numBateriasMin1 . "," . $autMinishelter1 . "," . $minishelter2 . "," . $rectTypeMin2 . "," . $marcaBateriasMin2 . "," . $numBateriasMin2 . "," . $autMinishelter . "," . $modeloGabineteE1 . "," . $modeloGabineteE2 . "," . $marcaFuerza1 . "," . $modeloFuerza1 . "," . $voltageSalidaF1 . "," . $marcaBateriasF1 . "," . $numeroBateriasF1 . "," . $capacidadAHF1 . "," . $marcaFuerza2 . "," . $modeloFuerza2 . "," . $voltageSalidaF2 . "," . $marcaBateriasF2 . "," . $numeroBateriasF2 . "," . $capacidadAHF2 . "," . $dbUsuario . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idSite = base64_decode(urldecode($_GET["fid"]));

				if (strcmp($action, 'editrecord') == 0) {
					//pOIFOD
					$idSiteVal = 'value="' . $idSite . '"';
					$idSite = $oOBC->DBQuote(base64_decode(urldecode($_GET["fid"])));
					$infoFOD = $oOBC->PDODBConnection("CALL pOIFOD(" . $idSite . ")");
					foreach ($infoFOD as $row) {
						$siteVal1 = 'value="' . $row["tes_id"] . '"';
						$siteVal2 = 'value="' . $row["nombre"] . '"';
						$siteVal3 = $row["estado"];
						$siteVal4 = $row["criticidad"];
						$siteVal5 = 'value="' . $row["fecha_construccion"] . '"';
						$siteVal6 = ["tipificacion"];
						$siteVal7 = 'value="Encargado de Zona"';
						$siteVal8 = ["zona"];
						$siteVal9 = ["zona_geografica"];
						$siteVal10 = ["area"];
						$siteVal11 = ["departamento"];
						$siteVal12 = ["municipio"];
						$siteVal13 = $row["direccion"];
						$siteVal14 = 'value="' . $row["latitud"] . '"';
						$siteVal15 = 'value="' . $row["longitud"] . '"';
						$siteVal16 = 'value="' . $row["dueño_sitio"] . '"';
						$siteVal17 = $row["tipo_cuenta"];
						$siteVal18 = $row["estado_contrato"];
						$siteVal19 = $row["tipo_cobertura"];
						$siteVal20 = 'value="' . $row["forma_acceso"] . '"';
						$siteVal21 = 'value="' . $row["contacto_acceso"] . '"';
						$siteVal22 = 'value="' . $row["restriccion_acceso"] . '"';
						$siteVal23 = $row["peligrosidad"];
						$siteVal24 = $row["tipo_estructura"];
						$siteVal25 = 'value="' . $row["altura"] . '"';
						$siteVal26 = $row["tipo_hierro"];
						$siteVal27 = $row["tipo_muro_perimetral"];
						$siteVal28 = 'value="' . $row["tipo_material_shelter"] . '"';
						//$siteVal29 = 'value="' . $row["operadores_coubicados"] . '"';
						$siteVal30 = 'value="' . $row["nic"] . '"';
						$siteVal31 = $row["comentarios_conexion_electrica"];
						$siteVal32 = $row["comp_electrica"];
						$siteVal33 = $row["medidor_energia"];
						$siteVal34 = $row["linea_electrica"];
						$siteVal35 = 'value="' . $row["capacidad_transformador"] . '"';
						$siteVal36 = 'value="' . $row["marca_genset"] . '"';
						$siteVal37 = 'value="' . $row["modelo_genset"] . '"';
						$siteVal38 = 'value="' . $row["capacidad_genset"] . '"';
						$siteVal39 = 'value="' . $row["capacidad_tanque"] . '"';
						$siteVal40 = $row["estado_generador"];
						$siteVal41 = 'value="' . $row["marca_ats"] . '"';
						$siteVal42 = 'value="' . $row["capacidad_ats"] . '"';
						$siteVal43 = 'value="' . $row["estado_ats"] . '"';
						$siteVal44 = 'value="' . $row["gsm_nemonico"] . '"';
						$siteVal45 = 'value="' . $row["umts_nemonico"] . '"';
						$siteVal46 = 'value="' . $row["lte_nemonico"] . '"';
						$siteVal47 = 'value="' . $row["cluster_name"] . '"';
						$siteVal48 = 'value="' . $row["gsm_launch"] . '"';
						$siteVal49 = 'value="' . $row["umts_launch"] . '"';
						$siteVal50 = 'value="' . $row["lte_launch"] . '"';
						$siteVal51 = $row["umts_carrier1"];
						$siteVal52 = $row["umts_carrier2"];
						$siteVal53 = $row["umts_carrier3"];
						$siteVal54 = $row["lte_cells"];
						$siteVal55 = 'value="' . $row["rrus_site"] . '"';
						$siteVal56 = 'value="' . $row["antenas_site"] . '"';
						$siteVal57 = $row["2g_tx_type"];
						$siteVal58 = 'value="' . $row["2g_tx_marca"] . '"';
						$siteVal59 = $row["3g_tx_type"];
						$siteVal60 = 'value="' . $row["3g_tx_marca"] . '"';
						$siteVal61 = $row["4g_tx_type"];
						$siteVal62 = 'value="' . $row["4g_tx_marca"] . '"';
						$siteVal63 = $row["modelo_gabinete1"];
						$siteVal64 = $row["rectifier_type_cab1"];
						$siteVal65 = 'value="' . $row["marca_bateria_cab1"] . '"';
						$siteVal66 = 'value="' . $row["numero_bateria_cab1"] . '"';
						$siteVal67 = 'value="' . $row["autonomia_gabinete1"] . '"';
						$siteVal68 = $row["modelo_gabinete2"];
						$siteVal69 = $row["rectifier_type_cab2"];
						$siteVal70 = 'value="' . $row["marca_bateria_cab2"] . '"';
						$siteVal71 = 'value="' . $row["numero_bateria_cab2"] . '"';
						$siteVal72 = 'value="' . $row["autonomia_gabinete2"] . '"';
						$siteVal73 = $row["modelo_gabinete3"];
						$siteVal74 = $row["rectifier_type_cab3"];
						$siteVal75 = 'value="' . $row["marca_bateria_cab3"] . '"';
						$siteVal76 = 'value="' . $row["numero_bateria_cab3"] . '"';
						$siteVal77 = 'value="' . $row["autonomia_gabinete3"] . '"';
						$siteVal78 = 'value="' . $row["minishelter1"] . '"';
						$siteVal79 = $row["rectifier_type_minishelter1"];
						$siteVal80 = 'value="' . $row["marca_bateria_minishelter1"] . '"';
						$siteVal81 = 'value="' . $row["numero_bateria_minishelter1"] . '"';
						$siteVal82 = 'value="' . $row["autonomia_minishelter1"] . '"';
						$siteVal83 = 'value="' . $row["minishelter2"] . '"';
						$siteVal84 = $row["rectifier_type_minishelter2"];
						$siteVal85 = 'value="' . $row["marca_bateria_minishelter2"] . '"';
						$siteVal86 = 'value="' . $row["numero_bateria_minishelter2"] . '"';
						$siteVal87 = 'value="' . $row["autonomia_minishelter2"] . '"';
						$siteVal88 = $row["gabinete_ericsson1"];
						$siteVal89 = $row["gabinete_ericsson2"];
						$siteVal90 = 'value="' . $row["marca_fuerza1"] . '"';
						$siteVal91 = 'value="' . $row["modelo_fuerza1"] . '"';
						$siteVal92 = 'value="' . $row["voltage_salida_fuerza1"] . '"';
						$siteVal93 = 'value="' . $row["marca_bateria_fuerza1"] . '"';
						$siteVal94 = 'value="' . $row["numero_bateria_fuerza1"] . '"';
						$siteVal95 = 'value="' . $row["capacidad_fuerza1"] . '"';
						$siteVal96 = 'value="' . $row["marca_fuerza2"] . '"';
						$siteVal97 = 'value="' . $row["modelo_fuerza2"] . '"';
						$siteVal98 = 'value="' . $row["voltage_salida_fuerza2"] . '"';
						$siteVal99 = 'value="' . $row["marca_bateria_fuerza2"] . '"';
						$siteVal100 = 'value="' . $row["numero_bateria_fuerza2"] . '"';
						$siteVal101 = 'value="' . $row["capacidad_fuerza2"] . '"';
					}
				}
			}

			//Inicia Primer Columna
			echo '<div class="col-lg-4">';
			echo '<input type="hidden" id="idSite" name="idSite" ' . $idSiteVal . '/>';
            echo '<div class="form-group">';
            echo '<label for="inputTesId">TES ID</label>';
            echo '<input type="text" class="form-control" name="inputTesId" placeholder="TESID" ' . $siteVal1 . ' required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectCriticidad">Criticidad</label>';
			echo '<select class="form-control" id="selectCriticidad" name="selectCriticidad">';
			$this->MostrarSelector('criticidad', $siteVal4);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputUsuario">Encargado de Zona</label>';
            echo '<input type="text" class="form-control" name="inputUsuario" placeholder="Encargado de Zona" ' . $siteVal7 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectArea">Área</label>';
			echo '<select class="form-control" id="selectArea" name="selectArea">';
			$this->MostrarSelector('area', $siteVal10);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDireccion">Dirección</label>';
			echo '<textarea rows="2" cols="50" class="form-control" id="inputDireccion" name="inputDireccion" placeholder="Dirección">' . $siteVal13 . '</textarea>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDueñoSitio">Dueño del Sitio</label>';
			echo '<input type="text" class="form-control" id="inputDueñoSitio" name="inputDueñoSitio" placeholder="Dueño del Sitio" ' . $siteVal16 . '/>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoCobertura">Tipo de Cobertura</label>';
			echo '<select class="form-control" id="selectTipoCobertura" name="selectTipoCobertura">';
			$this->MostrarSelector('tipo_cobertura', $siteVal19);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputRestriccionAcceso">Restricción de Acceso</label>';
            echo '<input type="text" class="form-control" name="inputRestriccionAcceso" placeholder="Restricción de Acceso" ' . $siteVal22 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputAltura">Altura (M)</label>';
            echo '<input type="number" class="form-control" name="inputAltura" min="0" placeholder="Altura (M)" ' . $siteVal25 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoMaterialShelter">Tipo de Material Shelter</label>';
			echo '<select class="form-control" id="selectTipoMaterialShelter" name="selectTipoMaterialShelter">';
			$this->MostrarSelector('tipo_material_shelter', $siteVal28);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputComConElectrica">Comentarios de Conexión Eléctrica</label>';
			echo '<textarea rows="2" cols="50" class="form-control" id="inputComConElectrica" name="inputComConElectrica" placeholder="Comentarios de Conexión Eléctrica">' . $siteVal31 . '</textarea>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectLineaElectrica">Línea Eléctrica</label>';
			echo '<select class="form-control" id="selectLineaElectrica" name="selectLineaElectrica">';
			$this->MostrarSelector('tipo_linea_electrica', $siteVal34);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputModeloGenset">Modelo de Genset</label>';
            echo '<input type="text" class="form-control" name="inputModeloGenset" placeholder="Modelo de Genset" ' . $siteVal37 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectEstadoGenerador">Estado de Generador</label>';
			echo '<select class="form-control" id="selectEstadoGenerador" name="selectEstadoGenerador">';
			$this->MostrarSelector('estado_generador', $siteVal40);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputEstadoATS">Estado de ATS</label>';
            echo '<input type="text" class="form-control" name="inputEstadoATS" placeholder="Estado de ATS" ' . $siteVal43 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputLTENemonico">LTE Nemonico</label>';
            echo '<input type="text" class="form-control" name="inputLTENemonico" placeholder="LTE Nemonico" ' . $siteVal46 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputUMTSLaunchDate">UMTS Launch Date</label>';
            echo '<input type="date" class="form-control" name="inputUMTSLaunchDate" ' . $siteVal49 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectUMTSC2">UMTS Carrier 2</label>';
			echo '<select class="form-control" id="selectUMTSC2" name="selectUMTSC2">';
			$this->MostrarSelector('umts_carrier', $siteVal52);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputRRUSSite">RRUS por Site</label>';
            echo '<input type="number" class="form-control" min="1" name="inputRRUSSite" placeholder="RRUS por Site" ' . $siteVal55 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="input2GTXMarca">2G TX Marca</label>';
            echo '<input type="text" class="form-control" name="input2GTXMarca" placeholder="2G TX Marca" ' . $siteVal58 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="select4GTXType">4G TX Type</label>';
			echo '<select class="form-control" id="select4GTXType" name="select4GTXType">';
			$this->MostrarSelector('4gtx_type', $siteVal61);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectRectTypeCab1">Rectifier Type Cab 1</label>';
			echo '<select class="form-control" id="selectRectTypeCab1" name="selectRectTypeCab1">';
			$this->MostrarSelector('rectifier_type', $siteVal64);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputAutGabinete1">Autonomía de Gabinete 1 (Horas)</label>';
            echo '<input type="time" class="form-control" name="inputAutGabinete1" placeholder="Autonomía de Gabinete 1" ' . $siteVal67 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaBateriasCab2">Marca de Baterías Cab 2</label>';
            echo '<input type="text" class="form-control" name="inputMarcaBateriasCab2" placeholder="Marca de Baterías Cab 2" ' . $siteVal70 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectModeloGabinete3">Modelo de Gabinete 3</label>';
			echo '<select class="form-control" id="selectModeloGabinete3" name="selectModeloGabinete3">';
			$this->MostrarSelector('modelo_gabinete', $siteVal73);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputNumBateriasCab3">Número de Baterías Cab 3</label>';
            echo '<input type="number" class="form-control" min="1" name="inputNumBateriasCab3" placeholder="Número de Baterías Cab 3" ' . $siteVal76 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectRectTypeMin1">Rectifier Type Minishelter 1</label>';
			echo '<select class="form-control" id="selectRectTypeMin1" name="selectRectTypeMin1">';
			$this->MostrarSelector('rectifier_type_min', $siteVal79);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputAutMinishelter1">Autonomía de Minishelter 1 (Horas)</label>';
            echo '<input type="time" class="form-control" name="inputAutMinishelter1" placeholder="Autonomía de Minishelter 1" ' . $siteVal82 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaBateriasMin2">Marca de Baterías Minishelter 2</label>';
            echo '<input type="text" class="form-control" name="inputMarcaBateriasMin2" placeholder="Marca de Baterías Minishelter 2" ' . $siteVal85 . '>';
            echo '</div>';
            echo '<div class="form-group">';
			echo '<label for="selectModeloGabineteE1">Gabinete Ericsson 1</label>';
			echo '<select class="form-control" id="selectModeloGabineteE1" name="selectModeloGabineteE1">';
			$this->MostrarSelector('gabinete_ericsson', $siteVal88);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
            echo '<label for="inputModeloFuerza1">Modelo Fuerza 1</label>';
            echo '<input type="text" class="form-control" name="inputModeloFuerza1" placeholder="Modelo de Fuerza 1" ' . $siteVal91 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputNumeroBateriasF1">Número de Baterías de Fuerza 1</label>';
            echo '<input type="number" min="1" class="form-control" name="inputNumeroBateriasF1" placeholder="Número de Baterías de Fuerza 1" ' . $siteVal94 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputModeloFuerza2">Modelo Fuerza 2</label>';
            echo '<input type="text" class="form-control" name="inputModeloFuerza2" placeholder="Modelo de Fuerza 2" ' . $siteVal97 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputNumeroBateriasF2">Número de Baterías de Fuerza 2</label>';
            echo '<input type="number" min="1" class="form-control" name="inputNumeroBateriasF2" placeholder="Número de Baterías de Fuerza 2" ' . $siteVal100 . '>';
            echo '</div>';
			echo '</div>';
			//Termina Primer Columna

            //Inicia Segunda Columna
            echo '<div class="col-lg-4">';
            echo '<div class="form-group">';
            echo '<label for="inputNombre">Nombre</label>';
            echo '<input type="text" class="form-control" name="inputNombre" placeholder="Nombre" ' . $siteVal2 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputFechaConstruccion">Fecha de Construcción</label>';
            echo '<input type="date" class="form-control" name="inputFechaConstruccion" ' . $siteVal5 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectZona">Zona</label>';
			echo '<select class="form-control" id="selectZona" name="selectZona">';
			$this->MostrarSelector('zona', $siteVal8);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectDepartamento">Departamento</label>';
			echo '<select class="form-control" id="selectDepartamento" name="selectDepartamento">';
			$this->MostrarDepartamento($siteVal11);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputLatitud">Latitud</label>';
            echo '<input type="number" class="form-control" name="inputLatitud" step="0.000001" placeholder="Latitud" ' . $siteVal14 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoCuenta">Tipo de Cuenta</label>';
			echo '<select class="form-control" id="selectTipoCuenta" name="selectTipoCuenta">';
			$this->MostrarSelector('tipo_cuenta', $siteVal17);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputFormaAcceso">Forma de Acceso</label>';
            echo '<input type="text" class="form-control" name="inputFormaAcceso" placeholder="Forma de Acceso" ' . $siteVal20 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectPeligrosidad">Nivel de Peligrosidad</label>';
			echo '<select class="form-control" id="selectPeligrosidad" name="selectPeligrosidad">';
			$this->MostrarSelector('peligrosidad', $siteVal23);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoHierro">Tipo de Hierro</label>';
			echo '<select class="form-control" id="selectTipoHierro" name="selectTipoHierro">';
			$this->MostrarSelector('tipo_hierro', $siteVal26);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectOperadoresCoub">Operadores Coubicados</label>';
			echo '<select class="form-control" multiple="multiple" size="3" id="selectOperadoresCoub" name="selectOperadoresCoub">';
			$this->MostrarSelector('multi_comp_operadora', $siteVal29);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectCompElectrica">Compañía Eléctrica</label>';
			echo '<select class="form-control" id="selectCompElectrica" name="selectCompElectrica">';
			$this->MostrarSelector('comp_electrica', $siteVal32);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputCapTransformador">Capacidad de Transformador (KVA)</label>';
            echo '<input type="number" class="form-control" name="inputCapTransformador" min="1" step="0.01" placeholder="Capacidad de Transformador (KVA)" ' . $siteVal35 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputCapacidadGenset">Capacidad de Genset (KVA)</label>';
            echo '<input type="number" class="form-control" name="inputCapacidadGenset" min="1" step="0.01" placeholder="Capacidad de Genset (KVA)" ' . $siteVal38 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaATS">Marca de ATS</label>';
            echo '<input type="text" class="form-control" name="inputMarcaATS" placeholder="Marca de ATS" ' . $siteVal41 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputGSMNemonico">GSM Nemonico</label>';
            echo '<input type="text" class="form-control" name="inputGSMNemonico" placeholder="GSM Nemonico" ' . $siteVal44 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputClusterName">Cluster Name</label>';
            echo '<input type="text" class="form-control" name="inputClusterName" placeholder="Cluster Name" ' . $siteVal47 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputLTELaunchDate">LTE Launch Date</label>';
            echo '<input type="date" class="form-control" name="inputLTELaunchDate" ' . $siteVal50 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectUMTSC3">UMTS Carrier 3</label>';
			echo '<select class="form-control" id="selectUMTSC3" name="selectUMTSC3">';
			$this->MostrarSelector('umts_carrier', $siteVal53);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputAntenasSite">Antenas por Site</label>';
            echo '<input type="number" class="form-control" min="1" name="inputAntenasSite" placeholder="Antenas por Site" ' . $siteVal56 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="select3GTXType">3G TX Type</label>';
			echo '<select class="form-control" id="select3GTXType" name="select3GTXType">';
			$this->MostrarSelector('3gtx_type', $siteVal59);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="input4GTXMarca">4G TX Marca</label>';
            echo '<input type="text" class="form-control" name="input4GTXMarca" placeholder="4G TX Marca" ' . $siteVal62 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaBateriasCab1">Marca de Baterías Cab 1</label>';
            echo '<input type="text" class="form-control" name="inputMarcaBateriasCab1" placeholder="Marca de Baterías Cab 1" ' . $siteVal65 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectModeloGabinete2">Modelo de Gabinete 2</label>';
			echo '<select class="form-control" id="selectModeloGabinete2" name="selectModeloGabinete2">';
			$this->MostrarSelector('modelo_gabinete', $siteVal68);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputNumBateriasCab2">Número de Baterías Cab 2</label>';
            echo '<input type="number" class="form-control" min="1" name="inputNumBateriasCab2" placeholder="Número de Baterías Cab 2" ' . $siteVal71 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectRectTypeCab3">Rectifier Type Cab 3</label>';
			echo '<select class="form-control" id="selectRectTypeCab3" name="selectRectTypeCab3">';
			$this->MostrarSelector('rectifier_type', $siteVal74);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputAutGabinete3">Autonomía de Gabinete 3 (Horas)</label>';
            echo '<input type="time" class="form-control" name="inputAutGabinete3" placeholder="Autonomía de Gabinete 3" ' . $siteVal77 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaBateriasMin1">Marca de Baterías Minishelter 1</label>';
            echo '<input type="text" class="form-control" name="inputMarcaBateriasMin1" placeholder="Marca de Baterías Minishelter 1" ' . $siteVal80 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMinishelter2">Minishelter 2</label>';
            echo '<input type="text" class="form-control" name="inputMinishelter2" placeholder="Minishelter 2" ' . $siteVal83 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputNumBateriasMin2">Número de Baterías Minishelter 2</label>';
            echo '<input type="number" class="form-control" min="1" name="inputNumBateriasMin2" placeholder="Número de Baterías Minishelter 2" ' . $siteVal86 . '>';
            echo '</div>';
            echo '<div class="form-group">';
			echo '<label for="selectModeloGabineteE2">Gabinete Ericsson 2</label>';
			echo '<select class="form-control" id="selectModeloGabineteE2" name="selectModeloGabineteE2">';
			$this->MostrarSelector('gabinete_ericsson', $siteVal89);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
            echo '<label for="inputVoltageSalidaF1">Voltage de Salida de Fuerza 1</label>';
            echo '<input type="number" min="1" class="form-control" name="inputVoltageSalidaF1" placeholder="Voltage de Salida de Fuerza 1" ' . $siteVal92 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputCapacidadAHF1">Capacidad de AH de Fuerza 1</label>';
            echo '<input type="number" min="1" class="form-control" name="inputCapacidadAHF1" placeholder="Capacidad de AH de Fuerza 1" ' . $siteVal95 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputVoltageSalidaF2">Voltage de Salida de Fuerza 2</label>';
            echo '<input type="number" min="1" class="form-control" name="inputVoltageSalidaF2" placeholder="Voltage de Salida de Fuerza 2" ' . $siteVal98 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputCapacidadAHF2">Capacidad de AH de Fuerza 2</label>';
            echo '<input type="number" min="1" class="form-control" name="inputCapacidadAHF2" placeholder="Capacidad de AH de Fuerza 2" ' . $siteVal101 . '>';
            echo '</div>';
			echo '</div>';
            //Termina Segunda Columna

			//Inicia Tercera Columna
			echo '<div class="col-lg-4">';
			echo '<div class="form-group">';
			echo '<label for="selectEstado">Estado</label>';
			echo '<select class="form-control" id="selectEstado" name="selectEstado">';
			$this->MostrarSelector('estado', $siteVal3);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipificacion">Tipificación</label>';
			echo '<select class="form-control" id="selectTipificacion" name="selectTipificacion">';
			$this->MostrarSelector('tipificacion', $siteVal6);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectZonaGeografica">Zona Geográfica</label>';
			echo '<select class="form-control" id="selectZonaGeografica" name="selectZonaGeografica">';
			$this->MostrarSelector('zona_geografica', $siteVal9);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectMunicipio">Municipio</label>';
			echo '<select class="form-control" id="selectMunicipio" name="selectMunicipio">';
			echo '<option value="">Seleccionar...</option>';
			//$siteVal12
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputLongitud">Longitud</label>';
            echo '<input type="number" class="form-control" name="inputLongitud" step="0.000001" placeholder="Longitud" ' . $siteVal15 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectEstadoContrato">Estado del Contrato</label>';
			echo '<select class="form-control" id="selectEstadoContrato" name="selectEstadoContrato">';
			$this->MostrarSelector('estado_contrato', $siteVal18);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputContactoAcceso">Contacto de Acceso</label>';
            echo '<input type="text" class="form-control" name="inputContactoAcceso" placeholder="Contacto de Acceso" ' . $siteVal21 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoEstructura">Tipo de Estructura</label>';
			echo '<select class="form-control" id="selectTipoEstructura" name="selectTipoEstructura">';
			$this->MostrarSelector('tipo_estructura', $siteVal24);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoMuroPerimetral">Tipo de Muro Perimetral</label>';
			echo '<select class="form-control" id="selectTipoMuroPerimetral" name="selectTipoMuroPerimetral">';
			$this->MostrarSelector('tipo_muro_perimetral', $siteVal27);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputNIC">NIC</label>';
            echo '<input type="number" class="form-control" name="inputNIC" placeholder="NIC" min="1" ' . $siteVal30 . '>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputMedidorEnergia">Medidor de Energía</label>';
            echo '<input type="text" class="form-control" name="inputMedidorEnergia" placeholder="Medidor de Energía" ' . $siteVal33 . '>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaGenset">Marca de Genset</label>';
            echo '<input type="text" class="form-control" name="inputMarcaGenset" placeholder="Marca de Genset" ' . $siteVal36 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputCapacidadTanque">Capacidad de Tanque (Galones)</label>';
            echo '<input type="number" class="form-control" name="inputCapacidadTanque" placeholder="Capacidad de Tanque" min="1" step="0.01" ' . $siteVal39 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputCapacidadATS">Capacidad de ATS</label>';
            echo '<input type="number" class="form-control" name="inputCapacidadATS" placeholder="Capacidad de ATS" ' . $siteVal42 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputUMTSNemonico">UMTS Nemonico</label>';
            echo '<input type="text" class="form-control" name="inputUMTSNemonico" placeholder="UMTS Nemonico" ' . $siteVal45 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputGSMLaunchDate">GSM Launch Date</label>';
            echo '<input type="date" class="form-control" name="inputGSMLaunchDate" ' . $siteVal46 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectUMTSC1">UMTS Carrier 1</label>';
			echo '<select class="form-control" id="selectUMTSC1" name="selectUMTSC1">';
			$this->MostrarSelector('umts_carrier', $siteVal49);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectLTECells">LTE Cells</label>';
			echo '<select class="form-control" id="selectLTECells" name="selectLTECells">';
			$this->MostrarSelector('lte_cells', $siteVal52);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="select2GTXType">2G TX Type</label>';
			echo '<select class="form-control" id="select2GTXType" name="select2GTXType">';
			$this->MostrarSelector('2gtx_type', $siteVal55);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="input3GTXMarca">3G TX Marca</label>';
            echo '<input type="text" class="form-control" name="input3GTXMarca" placeholder="3G TX Marca" ' . $siteVal58 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectModeloGabinete1">Modelo de Gabinete 1</label>';
			echo '<select class="form-control" id="selectModeloGabinete1" name="selectModeloGabinete1">';
			$this->MostrarSelector('modelo_gabinete', $siteVal61);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputNumBateriasCab1">Número de Baterías Cab 1</label>';
            echo '<input type="number" class="form-control" min="1" name="inputNumBateriasCab1" placeholder="Número de Baterías Cab 1" ' . $siteVal63 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectRectTypeCab2">Rectifier Type Cab 2</label>';
			echo '<select class="form-control" id="selectRectTypeCab2" name="selectRectTypeCab2">';
			$this->MostrarSelector('rectifier_type', $siteVal66);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputAutGabinete2">Autonomía de Gabinete 2 (Horas)</label>';
            echo '<input type="time" class="form-control" name="inputAutGabinete2" placeholder="Autonomía de Gabinete 2" ' . $siteVal69 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaBateriasCab3">Marca de Baterías Cab 3</label>';
            echo '<input type="text" class="form-control" name="inputMarcaBateriasCab3" placeholder="Marca de Baterías Cab 3" ' . $siteVal72 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMinishelter1">Minishelter 1</label>';
            echo '<input type="text" class="form-control" name="inputMinishelter1" placeholder="Minishelter 1" ' . $siteVal75 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputNumBateriasMin1">Número de Baterías Minishelter 1</label>';
            echo '<input type="number" class="form-control" min="1" name="inputNumBateriasMin1" placeholder="Número de Baterías Minishelter 1" ' . $siteVal78 . '>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectRectTypeMin2">Rectifier Type Minishelter 2</label>';
			echo '<select class="form-control" id="selectRectTypeMin2" name="selectRectTypeMin2">';
			$this->MostrarSelector('rectifier_type_min', $siteVal81);
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputAutMinishelter2">Autonomía de Minishelter 2 (Horas)</label>';
            echo '<input type="time" class="form-control" name="inputAutMinishelter2" placeholder="Autonomía de Minishelter 2" ' . $siteVal84 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaFuerza1">Marca Fuerza 1</label>';
            echo '<input type="text" class="form-control" name="inputMarcaFuerza1" placeholder="Marca de Fuerza 1" ' . $siteVal87 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaBateriasF1">Marca de Baterías de Fuerza 1</label>';
            echo '<input type="text" class="form-control" name="inputMarcaBateriasF1" placeholder="Marca de Baterías de Fuerza 1" ' . $siteVal90 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaFuerza2">Marca Fuerza 2</label>';
            echo '<input type="text" class="form-control" name="inputMarcaFuerza2" placeholder="Marca de Fuerza 2" ' . $siteVal93 . '>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaBateriasF2">Marca de Baterías de Fuerza 2</label>';
            echo '<input type="text" class="form-control" name="inputMarcaBateriasF2" placeholder="Marca de Baterías de Fuerza 2" ' . $siteVal96 . '>';
            echo '</div>';
            echo '</div>';
            //Termina Tercera Columna
		}

		function MMFOD() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMMFOD()");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="FOD.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th>';
				echo '<td>' . $row["tes_id"] . '</td>';
				echo '<td>' . $row["nombre"] . '</td>';
				echo '<td>' . $row["estado"] . '</td>';
				echo '<td>' . $row["criticidad"] . '</td>';
				echo '<td>' . $row["fecha_construccion"] . '</td>';
				echo '<td>' . $row["tipificacion"] . '</td>';
				echo '<td>Responsable de Zona</td>';
				echo '<td>' . $row["zona"] . '</td>';
				echo '<td>' . $row["zona_geografica"] . '</td>';
				echo '<td>' . $row["area"] . '</td>';
				echo '<td>' . $row["departamento"] . '</td>';
				echo '<td>' . $row["municipio"] . '</td>';
				echo '<td>' . $row["direccion"] . '</td>';
				echo '<td>' . $row["latitud"] . '</td>';
				echo '<td>' . $row["longitud"] . '</td>';
				echo '<td>' . $row["dueño_sitio"] . '</td>';
				echo '<td>' . $row["tipo_cuenta"] . '</td>';
				echo '<td>' . $row["estado_contrato"] . '</td>';
				echo '<td>' . $row["tipo_cobertura"] . '</td>';
				echo '<td>' . $row["forma_acceso"] . '</td>';
				echo '<td>' . $row["contacto_acceso"] . '</td>';
				echo '<td>' . $row["restriccion_acceso"] . '</td>';
				echo '<td>' . $row["peligrosidad"] . '</td>';
				echo '<td>' . $row["tipo_estructura"] . '</td>';
				echo '<td>' . $row["altura"] . '</td>';
				echo '<td>' . $row["tipo_hierro"] . '</td>';
				echo '<td>' . $row["tipo_muro_perimetral"] . '</td>';
				echo '<td>' . $row["tipo_material_shelter"] . '</td>';
				echo '<td>Operadores coubidados</td>';
				echo '<td>' . $row["nic"] . '</td>';
				echo '<td>' . $row["comentarios_conexion_electrica"] . '</td>';
				echo '<td>' . $row["comp_electrica"] . '</td>';
				echo '<td>' . $row["medidor_energia"] . '</td>';
				echo '<td>' . $row["linea_electrica"] . '</td>';
				echo '<td>' . $row["capacidad_transformador"] . '</td>';
				echo '<td>' . $row["marca_genset"] . '</td>';
				echo '<td>' . $row["modelo_genset"] . '</td>';
				echo '<td>' . $row["capacidad_genset"] . '</td>';
				echo '<td>' . $row["capacidad_tanque"] . '</td>';
				echo '<td>' . $row["estado_generador"] . '</td>';
				echo '<td>' . $row["marca_ats"] . '</td>';
				echo '<td>' . $row["capacidad_ats"] . '</td>';
				echo '<td>' . $row["estado_ats"] . '</td>';
				echo '<td>' . $row["gsm_nemonico"] . '</td>';
				echo '<td>' . $row["umts_nemonico"] . '</td>';
				echo '<td>' . $row["lte_nemonico"] . '</td>';
				echo '<td>' . $row["cluster_name"] . '</td>';
				echo '<td>' . $row["gsm_launch"] . '</td>';
				echo '<td>' . $row["umts_launch"] . '</td>';
				echo '<td>' . $row["lte_launch"] . '</td>';
				echo '<td>' . $row["umts_carrier1"] . '</td>';
				echo '<td>' . $row["umts_carrier2"] . '</td>';
				echo '<td>' . $row["umts_carrier3"] . '</td>';
				echo '<td>' . $row["lte_cells"] . '</td>';
				echo '<td>' . $row["rrus_site"] . '</td>';
				echo '<td>' . $row["antenas_site"] . '</td>';
				echo '<td>' . $row["2g_tx_type"] . '</td>';
				echo '<td>' . $row["2g_tx_marca"] . '</td>';
				echo '<td>' . $row["3g_tx_type"] . '</td>';
				echo '<td>' . $row["3g_tx_marca"] . '</td>';
				echo '<td>' . $row["4g_tx_type"] . '</td>';
				echo '<td>' . $row["4g_tx_marca"] . '</td>';
				echo '<td>' . $row["modelo_gabinete1"] . '</td>';
				echo '<td>' . $row["rectifier_type_cab1"] . '</td>';
				echo '<td>' . $row["marca_bateria_cab1"] . '</td>';
				echo '<td>' . $row["numero_bateria_cab1"] . '</td>';
				echo '<td>' . $row["autonomia_gabinete1"] . '</td>';
				echo '<td>' . $row["modelo_gabinete2"] . '</td>';
				echo '<td>' . $row["rectifier_type_cab2"] . '</td>';
				echo '<td>' . $row["marca_bateria_cab2"] . '</td>';
				echo '<td>' . $row["numero_bateria_cab2"] . '</td>';
				echo '<td>' . $row["autonomia_gabinete2"] . '</td>';
				echo '<td>' . $row["modelo_gabinete3"] . '</td>';
				echo '<td>' . $row["rectifier_type_cab3"] . '</td>';
				echo '<td>' . $row["marca_bateria_cab3"] . '</td>';
				echo '<td>' . $row["numero_bateria_cab3"] . '</td>';
				echo '<td>' . $row["autonomia_gabinete3"] . '</td>';
				echo '<td>' . $row["minishelter1"] . '</td>';
				echo '<td>' . $row["rectifier_type_minishelter1"] . '</td>';
				echo '<td>' . $row["marca_bateria_minishelter1"] . '</td>';
				echo '<td>' . $row["numero_bateria_minishelter1"] . '</td>';
				echo '<td>' . $row["autonomia_minishelter1"] . '</td>';
				echo '<td>' . $row["minishelter2"] . '</td>';
				echo '<td>' . $row["rectifier_type_minishelter2"] . '</td>';
				echo '<td>' . $row["marca_bateria_minishelter2"] . '</td>';
				echo '<td>' . $row["numero_bateria_minishelter2"] . '</td>';
				echo '<td>' . $row["autonomia_minishelter2"] . '</td>';
				echo '<td>' . $row["gabinete_ericsson1"] . '</td>';
				echo '<td>' . $row["gabinete_ericsson2"] . '</td>';
				echo '<td>' . $row["marca_fuerza1"] . '</td>';
				echo '<td>' . $row["modelo_fuerza1"] . '</td>';
				echo '<td>' . $row["voltage_salida_fuerza1"] . '</td>';
				echo '<td>' . $row["marca_bateria_fuerza1"] . '</td>';
				echo '<td>' . $row["numero_bateria_fuerza1"] . '</td>';
				echo '<td>' . $row["capacidad_fuerza1"] . '</td>';
				echo '<td>' . $row["marca_fuerza2"] . '</td>';
				echo '<td>' . $row["modelo_fuerza2"] . '</td>';
				echo '<td>' . $row["voltage_salida_fuerza2"] . '</td>';
				echo '<td>' . $row["marca_bateria_fuerza2"] . '</td>';
				echo '<td>' . $row["numero_bateria_fuerza2"] . '</td>';
				echo '<td>' . $row["capacidad_fuerza2"] . '</td>';
				echo '<td>' . $row["fecha_creacion"] . '</td>';
				echo '<td>' . $row["creado_por"] . '</td> </tr>';
			}
		}

		function CMFOD() {
			if (isset($_FILES['fileTemp'])) {
				if ($_FILES['fileTemp']['tmp_name']) {
					if (!$_FILES['fileTemp']['error']) {

					    $inputFile = $_FILES['fileTemp']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTemp"]["name"]);
						move_uploaded_file($_FILES['fileTemp']['tmp_name'], $targetdir);
					    $extension = strtoupper(pathinfo($targetdir, PATHINFO_EXTENSION));

					    if ($extension == "XLS") {
							$excel = new PhpExcelReader;
							$excel->read($targetdir);

							$oOBC = new OBC;
							//Saltar la primer fila del archivo
							$x = 2;
							while($x <= $excel->sheets[0]['numRows']) {
								$y = 1;
								while($y <= $excel->sheets[0]['numCols']) {
								  $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? trim($excel->sheets[0]['cells'][$x][$y]) : "";
								  if ($y == 1) {
								  	$siteVal1 = $oOBC->DBQuote($cell);
								  } elseif ($y == 2) {
								  	$siteVal2 = $oOBC->DBQuote($cell);
								  } elseif ($y == 3) {
								  	$siteVal3 = $oOBC->DBQuote($cell);
								  } elseif ($y == 4) {
								  	$siteVal4 = $oOBC->DBQuote($cell);
								  } elseif ($y == 5) {
								  	$siteVal5 = $oOBC->DBQuote($cell);
								  } elseif ($y == 6) {
								  	$siteVal6 = $oOBC->DBQuote($cell);
								  } elseif ($y == 7) {
								  	$siteVal7 = $oOBC->DBQuote($cell);
								  } elseif ($y == 8) {
								  	$siteVal8 = $oOBC->DBQuote($cell);
								  } elseif ($y == 9) {
								  	$siteVal9 = $oOBC->DBQuote($cell);
								  } elseif ($y == 10) {
								  	$siteVal10 = $oOBC->DBQuote($cell);
								  } elseif ($y == 11) {
								  	$siteVal11 = $oOBC->DBQuote($cell);
								  } elseif ($y == 12) {
								  	$siteVal12 = $oOBC->DBQuote($cell);
								  } elseif ($y == 13) {
								  	$siteVal13 = $oOBC->DBQuote($cell);
								  } elseif ($y == 14) {
								  	$siteVal14 = $cell;
								  } elseif ($y == 15) {
								  	$siteVal15 = $cell;
								  } elseif ($y == 16) {
								  	$siteVal16 = $oOBC->DBQuote($cell);
								  } elseif ($y == 17) {
								  	$siteVal17 = $oOBC->DBQuote($cell);
								  } elseif ($y == 18) {
								  	$siteVal18 = $oOBC->DBQuote($cell);
								  } elseif ($y == 19) {
								  	$siteVal19 = $oOBC->DBQuote($cell);
								  } elseif ($y == 20) {
								  	$siteVal20 = $oOBC->DBQuote($cell);
								  } elseif ($y == 21) {
								  	$siteVal21 = $oOBC->DBQuote($cell);
								  } elseif ($y == 22) {
								  	$siteVal22 = $oOBC->DBQuote($cell);
								  } elseif ($y == 23) {
								  	$siteVal23 = $oOBC->DBQuote($cell);
								  } elseif ($y == 24) {
								  	$siteVal24 = $oOBC->DBQuote($cell);
								  } elseif ($y == 25) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal25 = $cell;
								  } elseif ($y == 26) {
								  	$siteVal26 = $oOBC->DBQuote($cell);
								  } elseif ($y == 27) {
								  	$siteVal27 = $oOBC->DBQuote($cell);
								  } elseif ($y == 28) {
								  	$siteVal28 = $oOBC->DBQuote($cell);
								  } elseif ($y == 29) {
								  	$siteVal29 = $oOBC->DBQuote($cell);
								  } elseif ($y == 30) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal30 = $cell;
								  } elseif ($y == 31) {
								  	$siteVal31 = $oOBC->DBQuote($cell);
								  } elseif ($y == 32) {
								  	$siteVal32 = $oOBC->DBQuote($cell);
								  } elseif ($y == 33) {
								  	$siteVal33 = $oOBC->DBQuote($cell);
								  } elseif ($y == 34) {
								  	$siteVal34 = $oOBC->DBQuote($cell);
								  } elseif ($y == 35) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal35 = $cell;
								  } elseif ($y == 36) {
								  	$siteVal36 = $oOBC->DBQuote($cell);
								  } elseif ($y == 37) {
								  	$siteVal37 = $oOBC->DBQuote($cell);
								  } elseif ($y == 38) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal38 = $cell;
								  } elseif ($y == 39) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal39 = $cell;
								  } elseif ($y == 40) {
								  	$siteVal40 = $oOBC->DBQuote($cell);
								  } elseif ($y == 41) {
								  	$siteVal41 = $oOBC->DBQuote($cell);
								  } elseif ($y == 42) {
								  	$siteVal42 = $oOBC->DBQuote($cell);
								  } elseif ($y == 43) {
								  	$siteVal43 = $oOBC->DBQuote($cell);
								  } elseif ($y == 44) {
								  	$siteVal44 = $oOBC->DBQuote($cell);
								  } elseif ($y == 45) {
								  	$siteVal45 = $oOBC->DBQuote($cell);
								  } elseif ($y == 46) {
								  	$siteVal46 = $oOBC->DBQuote($cell);
								  } elseif ($y == 47) {
								  	$siteVal47 = $oOBC->DBQuote($cell);
								  } elseif ($y == 48) {
								  	if (trim($cell) == "") {
								  		$siteVal48 = "NULL";
								  	} else {
								  		$siteVal48 = $oOBC->DBQuote($cell);
								  	}
								  } elseif ($y == 49) {
								  	if (trim($cell) == "") {
								  		$siteVal49 = "NULL";
								  	} else {
								  		$siteVal49 = $oOBC->DBQuote($cell);
								  	}
								  } elseif ($y == 50) {
								  	if (trim($cell) == "") {
								  		$siteVal50 = "NULL";
								  	} else {
								  		$siteVal50 = $oOBC->DBQuote($cell);
								  	}
								  } elseif ($y == 51) {
								  	$siteVal51 = $oOBC->DBQuote($cell);
								  } elseif ($y == 52) {
								  	$siteVal52 = $oOBC->DBQuote($cell);
								  } elseif ($y == 53) {
								  	$siteVal53 = $oOBC->DBQuote($cell);
								  } elseif ($y == 54) {
								  	$siteVal54 = $oOBC->DBQuote($cell);
								  } elseif ($y == 55) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal55 = $cell;
								  } elseif ($y == 56) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal56 = $cell;
								  } elseif ($y == 57) {
								  	$siteVal57 = $oOBC->DBQuote($cell);
								  } elseif ($y == 58) {
								  	$siteVal58 = $oOBC->DBQuote($cell);
								  } elseif ($y == 59) {
								  	$siteVal59 = $oOBC->DBQuote($cell);
								  } elseif ($y == 60) {
								  	$siteVal60 = $oOBC->DBQuote($cell);
								  } elseif ($y == 61) {
								  	$siteVal61 = $oOBC->DBQuote($cell);
								  } elseif ($y == 62) {
								  	$siteVal62 = $oOBC->DBQuote($cell);
								  } elseif ($y == 63) {
								  	$siteVal63 = $oOBC->DBQuote($cell);
								  } elseif ($y == 64) {
								  	$siteVal64 = $oOBC->DBQuote($cell);
								  } elseif ($y == 65) {
								  	$siteVal65 = $oOBC->DBQuote($cell);
								  } elseif ($y == 66) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal66 = $cell;
								  } elseif ($y == 67) {
								  	if (trim($cell) == "") {
								  		$siteVal67 = "NULL";
								  	} else {
								  		$siteVal67 = $oOBC->DBQuote($cell);
								  	}
								  } elseif ($y == 68) {
								  	$siteVal68 = $oOBC->DBQuote($cell);
								  } elseif ($y == 69) {
								  	$siteVal69 = $oOBC->DBQuote($cell);
								  } elseif ($y == 70) {
								  	$siteVal70 = $oOBC->DBQuote($cell);
								  } elseif ($y == 71) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal71 = $cell;
								  } elseif ($y == 72) {
								  	if (trim($cell) == "") {
								  		$siteVal72 = "NULL";
								  	} else {
								  		$siteVal72 = $oOBC->DBQuote($cell);
								  	}
								  } elseif ($y == 73) {
								  	$siteVal73 = $oOBC->DBQuote($cell);
								  } elseif ($y == 74) {
								  	$siteVal74 = $oOBC->DBQuote($cell);
								  } elseif ($y == 75) {
								  	$siteVal75 = $oOBC->DBQuote($cell);
								  } elseif ($y == 76) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal76 = $cell;
								  } elseif ($y == 77) {
								  	if (trim($cell) == "") {
								  		$siteVal77 = "NULL";
								  	} else {
								  		$siteVal77 = $oOBC->DBQuote($cell);
								  	}
								  } elseif ($y == 78) {
								  	$siteVal78 = $oOBC->DBQuote($cell);
								  } elseif ($y == 79) {
								  	$siteVal79 = $oOBC->DBQuote($cell);
								  } elseif ($y == 80) {
								  	$siteVal80 = $oOBC->DBQuote($cell);
								  } elseif ($y == 81) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal81 = $cell;
								  } elseif ($y == 82) {
								  	$siteVal82 = $oOBC->DBQuote($cell);
								  } elseif ($y == 83) {
								  	$siteVal83 = $oOBC->DBQuote($cell);
								  } elseif ($y == 84) {
								  	$siteVal84 = $oOBC->DBQuote($cell);
								  } elseif ($y == 85) {
								  	$siteVal85 = $oOBC->DBQuote($cell);
								  } elseif ($y == 86) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal86 = $cell;
								  } elseif ($y == 87) {
								  	$siteVal87 = $oOBC->DBQuote($cell);
								  } elseif ($y == 88) {
								  	$siteVal88 = $oOBC->DBQuote($cell);
								  } elseif ($y == 89) {
								  	$siteVal89 = $oOBC->DBQuote($cell);
								  } elseif ($y == 90) {
								  	$siteVal90 = $oOBC->DBQuote($cell);
								  } elseif ($y == 91) {
								  	$siteVal91 = $oOBC->DBQuote($cell);
								  } elseif ($y == 92) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal92 = $cell;
								  } elseif ($y == 93) {
								  	$siteVal93 = $oOBC->DBQuote($cell);
								  } elseif ($y == 94) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal94 = $cell;
								  } elseif ($y == 95) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal95 = $cell;
								  } elseif ($y == 96) {
								  	$siteVal96 = $oOBC->DBQuote($cell);
								  } elseif ($y == 97) {
								  	$siteVal97 = $oOBC->DBQuote($cell);
								  } elseif ($y == 98) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal98 = $cell;
								  } elseif ($y == 99) {
								  	$siteVal99 = $oOBC->DBQuote($cell);
								  } elseif ($y == 100) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal100 = $cell;
								  } elseif ($y == 101) {
								  	if (trim($cell) == "") {
								  		$cell = "NULL";
								  	}
								  	$siteVal101 = $cell;
								  }
								  $y++;
								}
								$x++;

								$dbUsuario = $oOBC->DBQuote($_SESSION["usuario"]);
								//$resultado = $oOBC->PDODBConnectionNE(
								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoFOD(0," . $siteVal1 . "," . $siteVal2 . "," . $siteVal3 . "," . $siteVal4 . "," . $siteVal5 . "," . $siteVal6 . "," . $siteVal8 . "," . $siteVal9 . "," . $siteVal10 . "," . $siteVal11 . "," . $siteVal12 . "," . $siteVal13 . "," . $siteVal14 . "," . $siteVal15 . "," . $siteVal16 . "," . $siteVal17 . "," . $siteVal18 . "," . $siteVal19 . "," . $siteVal20 . "," . $siteVal21 . "," . $siteVal22 . "," . $siteVal23 . "," . $siteVal24 . "," . $siteVal25 . "," . $siteVal26 . "," . $siteVal27 . "," . $siteVal28 . "," . $siteVal30 . "," . $siteVal31 . "," . $siteVal32 . "," . $siteVal33 . "," . $siteVal34 . "," . $siteVal35 . "," . $siteVal36 . "," . $siteVal37 . "," . $siteVal38 . "," . $siteVal39 . "," . $siteVal40 . "," . $siteVal41 . "," . $siteVal42 . "," . $siteVal43 . "," . $siteVal44 . "," . $siteVal45 . "," . $siteVal46 . "," . $siteVal47 . "," . $siteVal48 . "," . $siteVal49 . "," . $siteVal50 . "," . $siteVal51 . "," . $siteVal52 . "," . $siteVal53 . "," . $siteVal54 . "," . $siteVal55 . "," . $siteVal56 . "," . $siteVal57 . "," . $siteVal58 . "," . $siteVal59 . "," . $siteVal60 . "," . $siteVal61 . "," . $siteVal62 . "," . $siteVal63 . "," . $siteVal64 . "," . $siteVal65 . "," . $siteVal66 . "," . $siteVal67 . "," . $siteVal68 . "," . $siteVal69 . "," . $siteVal70 . "," . $siteVal71 . "," . $siteVal72 . "," . $siteVal73 . "," . $siteVal74 . "," . $siteVal75 . "," . $siteVal76 . "," . $siteVal77 . "," . $siteVal78 . "," . $siteVal79 . "," . $siteVal80 . "," . $siteVal81 . "," . $siteVal82 . "," . $siteVal83 . "," . $siteVal84 . "," . $siteVal85 . "," . $siteVal86 . "," . $siteVal87 . "," . $siteVal88 . "," . $siteVal89 . "," . $siteVal90 . "," . $siteVal91 . "," . $siteVal92 . "," . $siteVal93 . "," . $siteVal94 . "," . $siteVal95 . "," . $siteVal96 . "," . $siteVal97 . "," . $siteVal98 . "," . $siteVal99 . "," . $siteVal100 . "," . $siteVal101 . "," . $dbUsuario . ")");

								//$resultado = $oOBC->PDODBConnectionNE("CALL pMttoFOD(0," . $siteVal1 . "," . $siteVal2 . "," . $siteVal3 . "," . $siteVal4 . "," . $siteVal5 . "," . $siteVal6 . "," . $siteVal8 . "," . $siteVal9 . "," . $siteVal10 . "," . $siteVal11 . "," . $siteVal12 . "," . $siteVal13 . "," . $siteVal14 . "," . $siteVal15 . "," . $siteVal16 . "," . $siteVal17 . "," . $siteVal18 . "," . $siteVal19 . "," . $siteVal20 . "," . $siteVal21 . "," . $siteVal22 . "," . $siteVal23 . "," . $siteVal24 . "," . $siteVal25 . "," . $siteVal26 . "," . $siteVal27 . "," . $siteVal28 . "," . $siteVal30 . "," . $siteVal31 . "," . $siteVal32 . "," . $siteVal33 . "," . $siteVal34 . "," . $siteVal35 . "," . $siteVal36 . "," . $siteVal37 . "," . $siteVal38 . "," . $siteVal39 . "," . $siteVal40 . "," . $siteVal41 . "," . $siteVal42 . "," . $siteVal43 . "," . $siteVal44 . "," . $siteVal45 . "," . $siteVal46 . "," . $siteVal47 . "," . $siteVal48 . "," . $siteVal49 . "," . $siteVal50 . "," . $siteVal51 . "," . $siteVal52 . "," . $siteVal53 . "," . $siteVal54 . "," . $siteVal55 . "," . $siteVal56 . "," . $siteVal57 . "," . $siteVal58 . "," . $siteVal59 . "," . $siteVal60 . "," . $siteVal61 . "," . $siteVal62 . "," . $siteVal63 . "," . $siteVal64 . "," . $siteVal65 . "," . $siteVal66 . "," . $siteVal67 . "," . $siteVal68 . "," . $siteVal69 . "," . $siteVal70 . "," . $siteVal71 . "," . $siteVal72 . "," . $siteVal73 . "," . $siteVal74 . "," . $siteVal75 . "," . $siteVal76 . "," . $siteVal77 . "," . $siteVal78 . "," . $siteVal79 . "," . $siteVal80 . "," . $siteVal81 . "," . $siteVal82 . "," . $siteVal83 . "," . $siteVal84 . "," . $siteVal85 . "," . $siteVal86 . "," . $siteVal87 . "," . $siteVal88 . "," . $siteVal89 . "," . $siteVal90 . "," . $siteVal91 . "," . $siteVal92 . "," . $siteVal93 . "," . $siteVal94 . "," . $siteVal95 . "," . $siteVal96 . "," . $siteVal97 . "," . $siteVal98 . "," . $siteVal99 . "," . $siteVal100 . "," . $siteVal101 . "," . $dbUsuario . ")");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTemp']['error']);
					}
				}
			}
		}

		function MostrarCatalogoMantenimientos() {
			$oOBC = new OBC;

			if ($_SESSION["idPerfil"]) {
				$counter = 1;
				$counter_tot = $counter;
				$tot = 0;
				$ret = $oOBC->PDODBConnection("CALL pMenuPerfilN2(" . $_SESSION["idPerfil"] . ",7)");
				foreach ($ret as $row) {
					if ($counter == 1) {
						echo '<div class="row">';
					}
					
					echo '<div class="col-lg-4">';
					echo '<h2>' . $row["nombre"] . '</h2>';
					echo '<p>' . $row["descripcion"] . '</p>';
					echo '<p><a class="btn btn-primary" href="' . $row["pagina"] . '" role="button">Entrar &raquo;</a></p>';
					echo '</div>';
					
					if ($counter == 3) {
						echo '</div>';
						$counter = 1;
					} else {
						$counter = $counter + 1;
						$counter_tot = $counter_tot + 1;
					}
				}
				if ($counter > 1) {
					echo '</div>';
				}
			}
		}

		function MostrarMatrizUsuarios() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('usuario')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoUsuarios.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["perfil"] . '</td> <td>' . $row["nombres"] . '</td> <td>' . $row["apellidos"] . '</td> <td>' . $row["telefono"] . '</td> <td>' . $row["usuario"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function MostrarDepartamento($valor = '') {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pDepartamento()");

			foreach ($ret as $row) {
				if (strpos($row, $valor) !== false) {
					echo '<option value="' . $row["id"] . '" selected>' . $row["nombre"] . '</option>';
				} else {
					echo '<option value="' . $row["id"] . '">' . $row["nombre"] . '</option>';
				}
			}
		}

		function MostrarSelector($tipo, $valor = '') {
			$oOBC = new OBC;
			$multi = false;
			if (strpos($tipo, 'multi_') !== false) {
				$tipo = str_replace("multi_", "", $tipo);
				$multi = true;
			}

			$tipo = $oOBC->DBQuote($tipo);
			$ret = $oOBC->PDODBConnection("CALL pSOCatalogo(". $tipo . ")");

			if ($multi) {
				foreach ($ret as $row) {
	    			if (strpos($row, $valor) !== false) {
						continue;
					} else {
						echo '<option value="' . $row["Valor"] . '">' . $row["Valor"] . '</option>';
					}
				}
			} else {
				foreach ($ret as $row) {
					if (strcmp($row["Valor"], 'Seleccionar...') === 0) {
						echo '<option value="" selected>' . $row["Valor"] . '</option>';
					} elseif (strpos($row, $valor) !== false) {
						echo '<option value="' . $row["Valor"] . '" selected>' . $row["Valor"] . '</option>';
					} else {
						echo '<option value="' . $row["Valor"] . '">' . $row["Valor"] . '</option>';
					}
				}
			}
		}

		function FrmMttoUsuarios() {
			//Inicializar Variables
			$oOBC = new OBC;
			$idUsuarioVal = '';
			$perfilUsuario = '';
			$nombresUsuarioVal = '';
			$apellidosUsuarioVal = '';
			$telefonoUsuarioVal = '';
			$usuarioVal = '';
			$activoUsuarioVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idUsuario']) {
					$idUsuario = $_POST['idUsuario'];
				} else {
					$idUsuario = 0;
				}
				$idPerfil = $_POST['selectPerfil'];
				$nombres = $oOBC->DBQuote($_POST['inputNombres']);
				$apellidos = $oOBC->DBQuote($_POST['inputApellidos']);
				$telefono = $oOBC->DBQuote($_POST['inputTelefono']);
				$usuario = $oOBC->DBQuote($_POST['inputUsuario']);
				if (!$_POST['inputPassword']) {
					$password = $oOBC->DBQuote("");
				} else {
					$password = $oOBC->DBQuote(base64_encode($_POST['inputPassword']));
				}
				if (strcmp($_POST['checkboxActivo'], "on")) {
					$activo = 0;
				} else {
					$activo = 1;
				}

				$resultado = $oOBC->PDODBConnection("CALL pMttoUsuario(" . $idUsuario . "," . $idPerfil . "," . $nombres . "," . $apellidos . "," . $telefono . "," . $usuario . "," . $password . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idUsuario = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idUsuarioVal = 'value="' . $idUsuario . '"';
					$infoUsuario = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('usuario'," . $idUsuario . ")");
					foreach ($infoUsuario as $row) {
						$perfilUsuario = $row["perfil"];
						$nombresUsuarioVal = 'value="' . $row["nombres"] . '"';
						$apellidosUsuarioVal = 'value="' . $row["apellidos"] . '"';
						$telefonoUsuarioVal = 'value="' . $row["telefono"] . '"';
						$usuarioVal = 'value="' . $row["usuario"] . '"';
						if ($row["activo"]) {
							$activoUsuarioVal = 'checked';
						}
					}

				}
			}
			echo '<input type="hidden" id="idUsuario" name="idUsuario" ' . $idUsuarioVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="selectPerfil">Perfil</label>';
			echo '<select class="form-control" id="selectPerfil" name="selectPerfil" required>';
			$this->MostrarSelector('perfiles',$perfilUsuario);
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputNombres">Nombres</label>';
			echo '<input type="text" class="form-control" id="inputNombres" name="inputNombres" placeholder="Nombres" ' . $nombresUsuarioVal . ' required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputApellidos">Apellidos</label>';
			echo '<input type="text" class="form-control" id="inputApellidos" name="inputApellidos" placeholder="Apellidos" ' . $apellidosUsuarioVal . ' required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputTelefono">Teléfono</label>';
			echo '<input type="text" class="form-control" id="inputTelefono" name="inputTelefono" placeholder="XXXX-XXXX" ' . $telefonoUsuarioVal . ' required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputUsuario">Usuario</label>';
			echo '<input type="text" class="form-control" id="inputUsuario" name="inputUsuario" placeholder="Usuario" ' . $usuarioVal . ' required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputPassword">Password</label>';
			echo '<input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputPasswordConfirm">Confirmar Password</label>';
			echo '<input type="password" class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" placeholder="Password">';
			echo '</div>';
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoUsuarioVal . '> Activo';
			echo '</label>';
			echo '</div>';
		}

		function CargaMasivaUsuarios() {
			if (isset($_FILES['fileTempUsuarios'])) {
				if ($_FILES['fileTempUsuarios']['tmp_name']) {
					if (!$_FILES['fileTempUsuarios']['error']) {

					    $inputFile = $_FILES['fileTempUsuarios']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTempUsuarios"]["name"]);
						move_uploaded_file($_FILES['fileTempUsuarios']['tmp_name'], $targetdir);
					    $extension = strtoupper(pathinfo($targetdir, PATHINFO_EXTENSION));

					    if ($extension == "XLS") {
							$excel = new PhpExcelReader;
							$excel->read($targetdir);

							$oOBC = new OBC;
							//Saltar la primer fila del archivo
							$x = 2;
							while($x <= $excel->sheets[0]['numRows']) {
								$y = 1;
								while($y <= $excel->sheets[0]['numCols']) {
								  $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
								  if ($y == 1) {
								  	$idPerfil = $cell;
								  } elseif ($y == 2) {
								  	$nombres = $oOBC->DBQuote($cell);
								  } elseif ($y == 3) {
								  	$apellidos = $oOBC->DBQuote($cell);
								  } elseif ($y == 4) {
								  	$telefono = $oOBC->DBQuote($cell);
								  } elseif ($y == 5) {
								  	$usuario = $oOBC->DBQuote($cell);
								  } elseif ($y == 6) {
								  	$password = $oOBC->DBQuote(base64_encode($cell));
								  } elseif ($y == 7) {
								  	$activo = $cell;
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoUsuario(0," . $idPerfil . "," . $nombres . "," . $apellidos . "," . $telefono . "," . $usuario . "," . $password . "," . $activo . ")");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTempUsuarios']['error']);
					}
				}
			}
		}

		function FrmMtto($cat) {
			//Inicializar Variables
			$oOBC = new OBC;
			$idCatVal = '';
			$nombreCatVal = '';
			$descripcionCatVal = '';
			$activoCatVal = '';
			$cat = $oOBC->DBQuote($cat);

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idCat']) {
					$idCat = $_POST['idCat'];
				} else {
					$idCat = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$descripcion = $oOBC->DBQuote($_POST['inputDescripcion']);
				$activo = $_POST['checkboxActivo'];

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogo(" . $cat . "," . $idCat . "," . $nombre . "," . $descripcion . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idCat = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idCatVal = 'value="' . $idCat . '"';
					$infoCat = $oOBC->PDODBConnection("CALL pOICatalogo(" . $cat . "," . $idCat . ")");
					foreach ($infoCat as $row) {
						$nombreCatVal = 'value="' . $row["valor"] . '"';
						$descripcionCatVal = $row["descripcion"];
						if ($row["activo"]) {
							$activoCatVal = 'checked';
						}
					}

				}
			}
			echo '<input type="hidden" id="idCat" name="idCat" ' . $idCatVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreCatVal . ' required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDescripcion">Descripción</label>';
			echo '<textarea rows="4" cols="50" class="form-control" id="inputDescripcion" name="inputDescripcion" placeholder="Descripción">' . $descripcionCatVal . '</textarea>';
			echo '</div>';
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="hidden" name="checkboxActivo" value="0" />';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoCatVal . ' value="1"/> Activo';
			echo '</label>';
			echo '</div>';
		}

		function MMCatalogo($cat, $redir) {
			$oOBC = new OBC;
			$cat = $oOBC->DBQuote($cat);
			$ret = $oOBC->PDODBConnection("CALL pMMCatalogo(" . $cat . ")");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="' . $redir . '?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["valor"] . '</td> <td>' . $row["descripcion"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CMCatalogo($cat) {
			if (isset($_FILES['fileTemp'])) {
				if ($_FILES['fileTemp']['tmp_name']) {
					if (!$_FILES['fileTemp']['error']) {

					    $inputFile = $_FILES['fileTemp']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTemp"]["name"]);
						move_uploaded_file($_FILES['fileTemp']['tmp_name'], $targetdir);
					    $extension = strtoupper(pathinfo($targetdir, PATHINFO_EXTENSION));

					    if ($extension == "XLS") {
							$excel = new PhpExcelReader;
							$excel->read($targetdir);

							$oOBC = new OBC;
							$cat = $oOBC->DBQuote($cat);
							//Saltar la primer fila del archivo
							$x = 2;
							while($x <= $excel->sheets[0]['numRows']) {
								$y = 1;
								while($y <= $excel->sheets[0]['numCols']) {
								  $cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
								  if ($y == 1) {
								  	$nombre = $oOBC->DBQuote($cell);
								  } elseif ($y == 2) {
								  	$descripcion = $oOBC->DBQuote($cell);
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogo(" . $cat . ",0,". $nombre . "," . $descripcion . ",1)");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTemp']['error']);
					}
				}
			}
		}
	}
?>