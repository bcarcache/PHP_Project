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

		function FrmFOD() {
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

			echo '<div class="col-lg-6">';
            echo '<div class="form-group">';
            echo '<label for="inputTesId">TES ID</label>';
            echo '<input type="text" class="form-control" name="inputTesId" placeholder="TESID" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectEstado">Estado</label>';
			echo '<select class="form-control" id="selectEstado" name="selectEstado" required>';
			$this->MostrarSelector('estado');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputFechaConstruccion">Fecha de Construcción</label>';
            echo '<input type="date" class="form-control" name="inputFechaConstruccion" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputUsuario">Encargado de Zona</label>';
            echo '<input type="text" class="form-control" name="inputUsuario" placeholder="Encargado de Zona" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectZonaGeografica">Zona Geográfica</label>';
			echo '<select class="form-control" id="selectZonaGeografica" name="selectZonaGeografica" required>';
			$this->MostrarSelector('zona_geografica');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectDepartamento">Departamento</label>';
			echo '<select class="form-control" id="selectDepartamento" name="selectDepartamento" required>';
			$this->MostrarSelector('departamento');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDireccion">Dirección</label>';
			echo '<textarea rows="4" cols="50" class="form-control" id="inputDireccion" name="inputDireccion" placeholder="Dirección"></textarea>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDueñoSitio">Dueño del Sitio</label>';
			echo '<input type="text" class="form-control" id="inputDueñoSitio" name="inputDueñoSitio" placeholder="Dueño del Sitio"/>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectEstadoContrato">Estado del Contrato</label>';
			echo '<select class="form-control" id="selectEstadoContrato" name="selectEstadoContrato" required>';
			$this->MostrarSelector('estado_contrato');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputFormaAcceso">Forma de Acceso</label>';
            echo '<input type="text" class="form-control" name="inputFormaAcceso" placeholder="Forma de Acceso" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputRestriccionAcceso">Restricción de Acceso</label>';
            echo '<input type="text" class="form-control" name="inputRestriccionAcceso" placeholder="Restricción de Acceso" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoEstructura">Tipo de Estructura</label>';
			echo '<select class="form-control" id="selectTipoEstructura" name="selectTipoEstructura" required>';
			$this->MostrarSelector('tipo_estructura');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoHierro">Tipo de Hierro</label>';
			echo '<select class="form-control" id="selectTipoHierro" name="selectTipoHierro" required>';
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoMaterialShelter">Tipo de Material Shelter</label>';
			echo '<select class="form-control" id="selectTipoMaterialShelter" name="selectTipoMaterialShelter" required>';
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputNIC">NIC</label>';
            echo '<input type="text" class="form-control" name="inputNIC" placeholder="NIC" required>';
			echo '</div>';
            echo '</div>';
            echo '<div class="col-lg-6">';
            echo '<div class="form-group">';
            echo '<label for="inputNombre">Nombre</label>';
            echo '<input type="text" class="form-control" name="inputNombre" placeholder="Nombre" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectCriticidad">Criticidad</label>';
			echo '<select class="form-control" id="selectCriticidad" name="selectCriticidad" required>';
			$this->MostrarSelector('criticidad');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipificacion">Tipificación</label>';
			echo '<select class="form-control" id="selectTipificacion" name="selectTipificacion" required>';
			$this->MostrarSelector('tipificacion');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectZona">Zona</label>';
			echo '<select class="form-control" id="selectZona" name="selectZona" required>';
			$this->MostrarSelector('zona');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectArea">Área</label>';
			echo '<select class="form-control" id="selectArea" name="selectArea" required>';
			$this->MostrarSelector('area');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectMunicipio">Municipio</label>';
			echo '<select class="form-control" id="selectMunicipio" name="selectMunicipio" required>';
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputLatitud">Latitud</label>';
            echo '<input type="number" class="form-control" name="inputLatitud" step="0.000001" placeholder="Latitud" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputLongitud">Longitud</label>';
            echo '<input type="number" class="form-control" name="inputLongitud" step="0.000001" placeholder="Longitud" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoCuenta">Tipo de Cuenta</label>';
			echo '<select class="form-control" id="selectTipoCuenta" name="selectTipoCuenta" required>';
			$this->MostrarSelector('tipo_cuenta');
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoCobertura">Tipo de Cobertura</label>';
			echo '<select class="form-control" id="selectTipoCobertura" name="selectTipoCobertura" required>';
			$this->MostrarSelector('tipo_cobertura');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputContactoAcceso">Contacto de Acceso</label>';
            echo '<input type="text" class="form-control" name="inputContactoAcceso" placeholder="Contacto de Acceso" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectPeligrosidad">Nivel de Peligrosidad</label>';
			echo '<select class="form-control" id="selectPeligrosidad" name="selectPeligrosidad" required>';
			$this->MostrarSelector('peligrosidad');
			echo '</select>';
			echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="inputAltura">Altura (M)</label>';
            echo '<input type="number" class="form-control" name="inputAltura" min="0" placeholder="Altura (M)" required>';
            echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="selectTipoMuroPerimetral">Tipo de Muro Perimetral</label>';
			echo '<select class="form-control" id="selectTipoMuroPerimetral" name="selectTipoMuroPerimetral" required>';
			echo '</select>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label>Operadores Coubicados</label>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputComConElectrica">Dirección</label>';
			echo '<textarea rows="4" cols="50" class="form-control" id="inputComConElectrica" name="inputComConElectrica" placeholder="Comentarios de Conexión Eléctrica"></textarea>';
			echo '</div>';
			echo '</div>';
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

		function MostrarSelector($tipo, $valor = '') {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pSeleccionarOpciones('". $tipo . "')");

			foreach ($ret as $row) {
				if (strcmp($row["Nombre"], $valor) == 0) {
					echo '<option value="' . $row["Valor"] . '" selected>' . $row["Nombre"] . '</option>';
				} else {
					echo '<option value="' . $row["Valor"] . '">' . $row["Nombre"] . '</option>';
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

		function FrmMttoN($cat) {
			//Inicializar Variables
			$oOBC = new OBC;
			$idCatVal = '';
			$nombreCatVal = '';
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
				$activo = $_POST['checkboxActivo'];

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoN(" . $cat . "," . $idCat . "," . $nombre . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idCat = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idCatVal = 'value="' . $idCat . '"';
					$infoCat = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo(" . $cat . "," . $idCat . ")");
					foreach ($infoCat as $row) {
						$nombreCatVal = 'value="' . $row["nombre"] . '"';
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
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="hidden" name="checkboxActivo" value="0" />';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoCatVal . ' value="1"/> Activo';
			echo '</label>';
			echo '</div>';
		}

		function MostrarMatrizN($cat, $redir) {
			$oOBC = new OBC;
			$cat = $oOBC->DBQuote($cat);
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo(" . $cat . ")");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="' . $redir . '?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CargaMasivaN($cat) {
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
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoN(" . $cat . ",0,". $nombre . ",1)");
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

		function FrmMttoND($cat) {
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

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoND(" . $cat . "," . $idCat . "," . $nombre . "," . $descripcion . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idCat = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idCatVal = 'value="' . $idCat . '"';
					$infoCat = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo(" . $cat . "," . $idCat . ")");
					foreach ($infoCat as $row) {
						$nombreCatVal = 'value="' . $row["nombre"] . '"';
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

		function MostrarMatrizND($cat, $redir) {
			$oOBC = new OBC;
			$cat = $oOBC->DBQuote($cat);
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo(" . $cat . ")");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="' . $redir . '?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["descripcion"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CargaMasivaND($cat) {
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

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoND(" . $cat . ",0,". $nombre . "," . $descripcion . ",1)");
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