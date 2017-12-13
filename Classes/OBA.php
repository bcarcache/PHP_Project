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
			$tesSiteVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idSite']) {
					$idSite = $_POST['idSite'];
				} else {
					$idSite = 0;
				}
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idSite = base64_decode(urldecode($_GET["fid"]));

				if (strcmp($action, 'editrecord') == 0) {
				}
			}

			//Inicia Primer Columna
			echo '<div class="col-lg-4">';
            echo '<div class="form-group">';
            echo '<label for="inputTesId">TES ID</label>';
            echo '<input type="text" class="form-control" name="inputTesId" placeholder="TESID" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectCriticidad">Criticidad</label>';
			echo '<select class="form-control" id="selectCriticidad" name="selectCriticidad" required>';
			$this->MostrarSelector('criticidad');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputUsuario">Encargado de Zona</label>';
            echo '<input type="text" class="form-control" name="inputUsuario" placeholder="Encargado de Zona" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectArea">Área</label>';
			echo '<select class="form-control" id="selectArea" name="selectArea" required>';
			$this->MostrarSelector('area');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDireccion">Dirección</label>';
			echo '<textarea rows="2" cols="50" class="form-control" id="inputDireccion" name="inputDireccion" placeholder="Dirección"></textarea>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDueñoSitio">Dueño del Sitio</label>';
			echo '<input type="text" class="form-control" id="inputDueñoSitio" name="inputDueñoSitio" placeholder="Dueño del Sitio"/>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoCobertura">Tipo de Cobertura</label>';
			echo '<select class="form-control" id="selectTipoCobertura" name="selectTipoCobertura" required>';
			$this->MostrarSelector('tipo_cobertura');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputRestriccionAcceso">Restricción de Acceso</label>';
            echo '<input type="text" class="form-control" name="inputRestriccionAcceso" placeholder="Restricción de Acceso" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputAltura">Altura (M)</label>';
            echo '<input type="number" class="form-control" name="inputAltura" min="0" placeholder="Altura (M)" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoMaterialShelter">Tipo de Material Shelter</label>';
			echo '<select class="form-control" id="selectTipoMaterialShelter" name="selectTipoMaterialShelter" required>';
			$this->MostrarSelector('tipo_material_shelter');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputComConElectrica">Comentarios de Conexión Eléctrica</label>';
			echo '<textarea rows="2" cols="50" class="form-control" id="inputComConElectrica" name="inputComConElectrica" placeholder="Comentarios de Conexión Eléctrica"></textarea>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectLineaElectrica">Línea Eléctrica</label>';
			echo '<select class="form-control" id="selectLineaElectrica" name="selectLineaElectrica" required>';
			$this->MostrarSelector('tipo_linea_electrica');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputModeloGenset">Modelo de Genset</label>';
            echo '<input type="text" class="form-control" name="inputModeloGenset" placeholder="Modelo de Genset" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectEstadoGenerador">Estado de Generador</label>';
			echo '<select class="form-control" id="selectEstadoGenerador" name="selectEstadoGenerador" required>';
			$this->MostrarSelector('estado_generador');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputEstadoATS">Estado de ATS</label>';
            echo '<input type="text" class="form-control" name="inputEstadoATS" placeholder="Estado de ATS" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputLTENemonico">LTE Nemonico</label>';
            echo '<input type="text" class="form-control" name="inputLTENemonico" placeholder="LTE Nemonico" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputUMTSLaunchDate">UMTS Launch Date</label>';
            echo '<input type="date" class="form-control" name="inputUMTSLaunchDate" required>';
            echo '</div>';
			echo '</div>';
			//Termina Primer Columna

            //Inicia Segunda Columna
            echo '<div class="col-lg-4">';
            echo '<div class="form-group">';
            echo '<label for="inputNombre">Nombre</label>';
            echo '<input type="text" class="form-control" name="inputNombre" placeholder="Nombre" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputFechaConstruccion">Fecha de Construcción</label>';
            echo '<input type="date" class="form-control" name="inputFechaConstruccion" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectZona">Zona</label>';
			echo '<select class="form-control" id="selectZona" name="selectZona" required>';
			$this->MostrarSelector('zona');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectDepartamento">Departamento</label>';
			echo '<select class="form-control" id="selectDepartamento" name="selectDepartamento" required>';
			$this->MostrarDepartamento();
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputLatitud">Latitud</label>';
            echo '<input type="number" class="form-control" name="inputLatitud" step="0.000001" placeholder="Latitud" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoCuenta">Tipo de Cuenta</label>';
			echo '<select class="form-control" id="selectTipoCuenta" name="selectTipoCuenta" required>';
			$this->MostrarSelector('tipo_cuenta');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputFormaAcceso">Forma de Acceso</label>';
            echo '<input type="text" class="form-control" name="inputFormaAcceso" placeholder="Forma de Acceso" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectPeligrosidad">Nivel de Peligrosidad</label>';
			echo '<select class="form-control" id="selectPeligrosidad" name="selectPeligrosidad" required>';
			$this->MostrarSelector('peligrosidad');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoHierro">Tipo de Hierro</label>';
			echo '<select class="form-control" id="selectTipoHierro" name="selectTipoHierro" required>';
			$this->MostrarSelector('tipo_hierro');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectOperadoresCoub">Operadores Coubicados</label>';
			echo '<select class="form-control" multiple="multiple" size="3" id="selectOperadoresCoub" name="selectOperadoresCoub" required>';
			$this->MostrarSelector('multi_comp_operadora');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectCompElectrica">Compañía Eléctrica</label>';
			echo '<select class="form-control" id="selectCompElectrica" name="selectCompElectrica" required>';
			$this->MostrarSelector('comp_electrica');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputCapTransformador">Capacidad de Transformador (KVA)</label>';
            echo '<input type="number" class="form-control" name="inputCapTransformador" min="1" step="0.01" placeholder="Capacidad de Transformador (KVA)" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputCapacidadGenset">Capacidad de Genset (KVA)</label>';
            echo '<input type="number" class="form-control" name="inputCapacidadGenset" min="1" step="0.01" placeholder="Capacidad de Genset (KVA)" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaATS">Marca de ATS</label>';
            echo '<input type="text" class="form-control" name="inputMarcaATS" placeholder="Marca de ATS" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputGSMNemonico">GSM Nemonico</label>';
            echo '<input type="text" class="form-control" name="inputGSMNemonico" placeholder="GSM Nemonico" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputClusterName">Cluster Name</label>';
            echo '<input type="text" class="form-control" name="inputClusterName" placeholder="Cluster Name" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputLTELaunchDate">LTE Launch Date</label>';
            echo '<input type="date" class="form-control" name="inputLTELaunchDate" required>';
            echo '</div>';
			echo '</div>';
            //Termina Segunda Columna

			//Inicia Tercera Columna
			echo '<div class="col-lg-4">';
			echo '<div class="form-group">';
			echo '<label for="selectEstado">Estado</label>';
			echo '<select class="form-control" id="selectEstado" name="selectEstado" required>';
			$this->MostrarSelector('estado');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipificacion">Tipificación</label>';
			echo '<select class="form-control" id="selectTipificacion" name="selectTipificacion" required>';
			$this->MostrarSelector('tipificacion');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectZonaGeografica">Zona Geográfica</label>';
			echo '<select class="form-control" id="selectZonaGeografica" name="selectZonaGeografica" required>';
			$this->MostrarSelector('zona_geografica');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectMunicipio">Municipio</label>';
			echo '<select class="form-control" id="selectMunicipio" name="selectMunicipio" required disabled>';
			echo '<option value="">Seleccionar...</option>';
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputLongitud">Longitud</label>';
            echo '<input type="number" class="form-control" name="inputLongitud" step="0.000001" placeholder="Longitud" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectEstadoContrato">Estado del Contrato</label>';
			echo '<select class="form-control" id="selectEstadoContrato" name="selectEstadoContrato" required>';
			$this->MostrarSelector('estado_contrato');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputContactoAcceso">Contacto de Acceso</label>';
            echo '<input type="text" class="form-control" name="inputContactoAcceso" placeholder="Contacto de Acceso" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoEstructura">Tipo de Estructura</label>';
			echo '<select class="form-control" id="selectTipoEstructura" name="selectTipoEstructura" required>';
			$this->MostrarSelector('tipo_estructura');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoMuroPerimetral">Tipo de Muro Perimetral</label>';
			echo '<select class="form-control" id="selectTipoMuroPerimetral" name="selectTipoMuroPerimetral" required>';
			$this->MostrarSelector('tipo_muro_perimetral');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputNIC">NIC</label>';
            echo '<input type="number" class="form-control" name="inputNIC" placeholder="NIC" min="1" required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputMedidorEnergia">Medidor de Energía</label>';
            echo '<input type="text" class="form-control" name="inputMedidorEnergia" placeholder="Medidor de Energía" required>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputMarcaGenset">Marca de Genset</label>';
            echo '<input type="text" class="form-control" name="inputMarcaGenset" placeholder="Marca de Genset" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputCapacidadTanque">Capacidad de Tanque (Galones)</label>';
            echo '<input type="number" class="form-control" name="inputCapacidadTanque" placeholder="Capacidad de Tanque" min="1" step="0.01" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputCapacidadATS">Capacidad de ATS</label>';
            echo '<input type="number" class="form-control" name="inputCapacidadATS" placeholder="Capacidad de ATS" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputUMTSNemonico">UMTS Nemonico</label>';
            echo '<input type="text" class="form-control" name="inputUMTSNemonico" placeholder="UMTS Nemonico" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputGSMLaunchDate">GSM Launch Date</label>';
            echo '<input type="date" class="form-control" name="inputGSMLaunchDate" required>';
            echo '</div>';
            echo '</div>';
            //Termina Tercera Columna
		}

		function MostrarMatrizFOD() {
			return '<thead> <tr> <th>#</th> <th>First Name</th> <th>Last Name</th> <th>Username</th> <th>Username</th> <th>Username</th> <th>Username</th> <th>Username</th> </tr> </thead> <tbody> <tr> <th scope="row">1</th> <td>Mark</td> <td>Otto</td> <td>@mdo</td> <td>Otto</td> <td>Otto</td> <td>Otto</td> <td>Otto</td> </tr> </tbody>';
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
				if (strcmp($row["nombre"], $valor) == 0) {
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
	    			if (strcmp($row["Valor"], 'Seleccionar...') == 0) {
						continue;
					} else {
						echo '<option value="' . $row["Valor"] . '">' . $row["Valor"] . '</option>';
					}
				}
			} else {
				foreach ($ret as $row) {
					if (strcmp($row["Valor"], 'Seleccionar...') == 0) {
						echo '<option value="" selected>' . $row["Valor"] . '</option>';
					} elseif (strcmp($row["Valor"], $valor) == 0) {
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