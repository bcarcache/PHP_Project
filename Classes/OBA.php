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

		function FrmMttoEstados() {
			//Inicializar Variables
			$oOBC = new OBC;
			$idEstadoVal = '';
			$nombreEstadoVal = '';
			$descripcionEstadoVal = '';
			$activoEstadoVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idEstado']) {
					$idEstado = $_POST['idEstado'];
				} else {
					$idEstado = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$descripcion = $oOBC->DBQuote($_POST['inputDescripcion']);
				$activo = $_POST['checkboxActivo'];

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoND('estado'," . $idEstado . "," . $nombre . "," . $descripcion . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idEstado = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idEstadoVal = 'value="' . $idEstado . '"';
					$infoEstado = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('estado'," . $idEstado . ")");
					foreach ($infoEstado as $row) {
						$nombreEstadoVal = 'value="' . $row["nombre"] . '"';
						$descripcionEstadoVal = $row["descripcion"];
						if ($row["activo"]) {
							$activoEstadoVal = 'checked';
						}
					}

				}
			}
			echo '<input type="hidden" id="idEstado" name="idEstado" ' . $idEstadoVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreEstadoVal . ' required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDescripcion">Descripción</label>';
			echo '<textarea rows="4" cols="50" class="form-control" id="inputDescripcion" name="inputDescripcion" placeholder="Descripción">' . $descripcionEstadoVal . '</textarea>';
			echo '</div>';
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="hidden" name="checkboxActivo" value="0" />';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoEstadoVal . ' value="1"/> Activo';
			echo '</label>';
			echo '</div>';
		}

		function MostrarMatrizEstados() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('estado')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoEstados.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["descripcion"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CargaMasivaEstados() {
			if (isset($_FILES['fileTempEstados'])) {
				if ($_FILES['fileTempEstados']['tmp_name']) {
					if (!$_FILES['fileTempEstados']['error']) {

					    $inputFile = $_FILES['fileTempEstados']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTempEstados"]["name"]);
						move_uploaded_file($_FILES['fileTempEstados']['tmp_name'], $targetdir);
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
								  	$nombre = $oOBC->DBQuote($cell);
								  } elseif ($y == 2) {
								  	$descripcion = $oOBC->DBQuote($cell);
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoND('estado',0,". $nombre . "," . $descripcion . ",1)");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTempEstados']['error']);
					}
				}
			}
		}

		function FrmMttoCriticidad() {
			//Inicializar Variables
			$oOBC = new OBC;
			$idNCVal = '';
			$nombreNCVal = '';
			$descripcionNCVal = '';
			$activoNCVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idNC']) {
					$idNC = $_POST['idNC'];
				} else {
					$idNC = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$descripcion = $oOBC->DBQuote($_POST['inputDescripcion']);
				$activo = $_POST['checkboxActivo'];

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoND('criticidad'," . $idNC . "," . $nombre . "," . $descripcion . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idNC = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idNCVal = 'value="' . $idNC . '"';
					$infoNC = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('criticidad'," . $idNC . ")");
					foreach ($infoNC as $row) {
						$nombreNCVal = 'value="' . $row["nombre"] . '"';
						$descripcionNCVal = $row["descripcion"];
						if ($row["activo"]) {
							$activoNCVal = 'checked';
						}
					}

				}
			}
			echo '<input type="hidden" id="idNC" name="idNC" ' . $idNCVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreNCVal . ' required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDescripcion">Descripción</label>';
			echo '<textarea rows="4" cols="50" class="form-control" id="inputDescripcion" name="inputDescripcion" placeholder="Descripción">' . $descripcionNCVal . '</textarea>';
			echo '</div>';
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="hidden" name="checkboxActivo" value="0" />';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoNCVal . ' value="1"/> Activo';
			echo '</label>';
			echo '</div>';
		}

		function MostrarMatrizCriticidad() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('criticidad')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoCriticidad.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["descripcion"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CargaMasivaCriticidad() {
			if (isset($_FILES['fileTempCriticidad'])) {
				if ($_FILES['fileTempCriticidad']['tmp_name']) {
					if (!$_FILES['fileTempCriticidad']['error']) {

					    $inputFile = $_FILES['fileTempCriticidad']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTempCriticidad"]["name"]);
						move_uploaded_file($_FILES['fileTempCriticidad']['tmp_name'], $targetdir);
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
								  	$nombre = $oOBC->DBQuote($cell);
								  } elseif ($y == 2) {
								  	$descripcion = $oOBC->DBQuote($cell);
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoND('criticidad',0,". $nombre . "," . $descripcion . ",1)");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTempCriticidad']['error']);
					}
				}
			}
		}

		function FrmMttoTipificaciones() {
			//Inicializar Variables
			$oOBC = new OBC;
			$idTipificacionVal = '';
			$nombreTipificacionVal = '';
			$descripcionTipificacionVal = '';
			$activoTipificacionVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idTipificacion']) {
					$idTipificacion = $_POST['idTipificacion'];
				} else {
					$idTipificacion = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$descripcion = $oOBC->DBQuote($_POST['inputDescripcion']);
				$activo = $_POST['checkboxActivo'];

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoND('tipificacion'," . $idTipificacion . "," . $nombre . "," . $descripcion . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idTipificacion = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idTipificacionVal = 'value="' . $idTipificacion . '"';
					$infoTipificacion = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('tipificacion'," . $idTipificacion . ")");
					foreach ($infoTipificacion as $row) {
						$nombreTipificacionVal = 'value="' . $row["nombre"] . '"';
						$descripcionTipificacionVal = $row["descripcion"];
						if ($row["activo"]) {
							$activoTipificacionVal = 'checked';
						}
					}

				}
			}
			echo '<input type="hidden" id="idTipificacion" name="idTipificacion" ' . $idTipificacionVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreTipificacionVal . ' required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDescripcion">Descripción</label>';
			echo '<textarea rows="4" cols="50" class="form-control" id="inputDescripcion" name="inputDescripcion" placeholder="Descripción">' . $descripcionTipificacionVal . '</textarea>';
			echo '</div>';
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="hidden" name="checkboxActivo" value="0" />';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoTipificacionVal . ' value="1"/> Activo';
			echo '</label>';
			echo '</div>';
		}

		function MostrarMatrizTipificaciones() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('tipificacion')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoTipificaciones.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["descripcion"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CargaMasivaTipificaciones() {
			if (isset($_FILES['fileTempTipificaciones'])) {
				if ($_FILES['fileTempTipificaciones']['tmp_name']) {
					if (!$_FILES['fileTempTipificaciones']['error']) {

					    $inputFile = $_FILES['fileTempTipificaciones']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTempTipificaciones"]["name"]);
						move_uploaded_file($_FILES['fileTempTipificaciones']['tmp_name'], $targetdir);
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
								  	$nombre = $oOBC->DBQuote($cell);
								  } elseif ($y == 2) {
								  	$descripcion = $oOBC->DBQuote($cell);
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoND('tipificacion',0,". $nombre . "," . $descripcion . ",1)");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTempTipificaciones']['error']);
					}
				}
			}
		}

		function FrmMttoZonas() {
			//Inicializar Variables
			$oOBC = new OBC;
			$idZonaVal = '';
			$nombreZonaVal = '';
			$activoZonaVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idZona']) {
					$idZona = $_POST['idZona'];
				} else {
					$idZona = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$activo = $_POST['checkboxActivo'];

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoN('zona'," . $idZona . "," . $nombre . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idZona = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idZonaVal = 'value="' . $idZona . '"';
					$infoZona = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('zona'," . $idZona . ")");
					foreach ($infoZona as $row) {
						$nombreZonaVal = 'value="' . $row["nombre"] . '"';
						if ($row["activo"]) {
							$activoZonaVal = 'checked';
						}
					}

				}
			}
			echo '<input type="hidden" id="idZona" name="idZona" ' . $idZonaVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreZonaVal . ' required>';
			echo '</div>';
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="hidden" name="checkboxActivo" value="0" />';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoZonaVal . ' value="1"/> Activo';
			echo '</label>';
			echo '</div>';
		}

		function MostrarMatrizZonas() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('zona')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoZonas.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CargaMasivaZonas() {
			if (isset($_FILES['fileTempZonas'])) {
				if ($_FILES['fileTempZonas']['tmp_name']) {
					if (!$_FILES['fileTempZonas']['error']) {

					    $inputFile = $_FILES['fileTempZonas']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTempZonas"]["name"]);
						move_uploaded_file($_FILES['fileTempZonas']['tmp_name'], $targetdir);
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
								  	$nombre = $oOBC->DBQuote($cell);
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoN('zona',0,". $nombre . ",1)");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTempZonas']['error']);
					}
				}
			}
		}

		function FrmMttoZonasGeograficas() {
			//Inicializar Variables
			$oOBC = new OBC;
			$idZGVal = '';
			$nombreZGVal = '';
			$activoZGVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idZG']) {
					$idZG = $_POST['idZG'];
				} else {
					$idZG = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$activo = $_POST['checkboxActivo'];

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoN('zona_geografica'," . $idZG . "," . $nombre . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idZG = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idZGVal = 'value="' . $idZG . '"';
					$infoZG = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('zona_geografica'," . $idZG . ")");
					foreach ($infoZG as $row) {
						$nombreZGVal = 'value="' . $row["nombre"] . '"';
						if ($row["activo"]) {
							$activoZGVal = 'checked';
						}
					}

				}
			}
			echo '<input type="hidden" id="idZG" name="idZG" ' . $idZGVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreZGVal . ' required>';
			echo '</div>';
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="hidden" name="checkboxActivo" value="0" />';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoNCVal . ' value="1"/> Activo';
			echo '</label>';
			echo '</div>';
		}

		function MostrarMatrizZonasGeograficas() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('zona_geografica')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoZonasGeograficas.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CargaMasivaZonasGeograficas() {
			if (isset($_FILES['fileTempZonasGeograficas'])) {
				if ($_FILES['fileTempZonasGeograficas']['tmp_name']) {
					if (!$_FILES['fileTempZonasGeograficas']['error']) {

					    $inputFile = $_FILES['fileTempZonasGeograficas']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTempZonasGeograficas"]["name"]);
						move_uploaded_file($_FILES['fileTempZonasGeograficas']['tmp_name'], $targetdir);
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
								  	$nombre = $oOBC->DBQuote($cell);
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoN('zona_geografica',0,". $nombre . ",1)");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTempZonasGeograficas']['error']);
					}
				}
			}
		}

		function FrmMttoAreas() {
			//Inicializar Variables
			$oOBC = new OBC;
			$idAreaVal = '';
			$nombreAreaVal = '';
			$activoAreaVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idArea']) {
					$idArea = $_POST['idArea'];
				} else {
					$idArea = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$activo = $_POST['checkboxActivo'];

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoN('area'," . $idArea . "," . $nombre . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idArea = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idAreaVal = 'value="' . $idArea . '"';
					$infoArea = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('area'," . $idArea . ")");
					foreach ($infoArea as $row) {
						$nombreAreaVal = 'value="' . $row["nombre"] . '"';
						if ($row["activo"]) {
							$activoAreaVal = 'checked';
						}
					}

				}
			}
			echo '<input type="hidden" id="idArea" name="idArea" ' . $idAreaVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreAreaVal . ' required>';
			echo '</div>';
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="hidden" name="checkboxActivo" value="0" />';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoAreaVal . ' value="1"/> Activo';
			echo '</label>';
			echo '</div>';
		}

		function MostrarMatrizAreas() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('area')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoAreas.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CargaMasivaAreas() {
			if (isset($_FILES['fileTempAreas'])) {
				if ($_FILES['fileTempAreas']['tmp_name']) {
					if (!$_FILES['fileTempAreas']['error']) {

					    $inputFile = $_FILES['fileTempAreas']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTempAreas"]["name"]);
						move_uploaded_file($_FILES['fileTempAreas']['tmp_name'], $targetdir);
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
								  	$nombre = $oOBC->DBQuote($cell);
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoN('area',0,". $nombre . ",1)");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTempAreas']['error']);
					}
				}
			}
		}

		function FrmMttoTiposCuenta() {
			//Inicializar Variables
			$oOBC = new OBC;
			$idTipoCuentaVal = '';
			$nombreTipoCuentaVal = '';
			$descripcionTipoCuentaVal = '';
			$activoTipoCuentaVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idTipoCuenta']) {
					$idTipoCuenta = $_POST['idTipoCuenta'];
				} else {
					$idTipoCuenta = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$descripcion = $oOBC->DBQuote($_POST['inputDescripcion']);
				$activo = $_POST['checkboxActivo'];

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoND('tipo_cuenta'," . $idTipoCuenta . "," . $nombre . "," . $descripcion . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idTipoCuenta = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idTipoCuentaVal = 'value="' . $idTipoCuenta . '"';
					$infoTipoCuenta = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('tipo_cuenta'," . $idTipoCuenta . ")");
					foreach ($infoTipoCuenta as $row) {
						$nombreTipoCuentaVal = 'value="' . $row["nombre"] . '"';
						$descripcionTipoCuentaVal = $row["descripcion"];
						if ($row["activo"]) {
							$activoTipoCuentaVal = 'checked';
						}
					}

				}
			}
			echo '<input type="hidden" id="idTipoCuenta" name="idTipoCuenta" ' . $idTipoCuentaVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreTipoCuentaVal . ' required>';
			echo '</div>';
			echo '<div class="form-group">';
			echo '<label for="inputDescripcion">Descripción</label>';
			echo '<textarea rows="4" cols="50" class="form-control" id="inputDescripcion" name="inputDescripcion" placeholder="Descripción">' . $descripcionTipoCuentaVal . '</textarea>';
			echo '</div>';
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="hidden" name="checkboxActivo" value="0" />';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoTipoCuentaVal . ' value="1"/> Activo';
			echo '</label>';
			echo '</div>';
		}

		function MostrarMatrizTiposCuenta() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('tipo_cuenta')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoTipoCuenta.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["descripcion"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CargaMasivaTiposCuenta() {
			if (isset($_FILES['fileTempTiposCuenta'])) {
				if ($_FILES['fileTempTiposCuenta']['tmp_name']) {
					if (!$_FILES['fileTempTiposCuenta']['error']) {

					    $inputFile = $_FILES['fileTempTiposCuenta']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTempTiposCuenta"]["name"]);
						move_uploaded_file($_FILES['fileTempTiposCuenta']['tmp_name'], $targetdir);
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
								  	$nombre = $oOBC->DBQuote($cell);
								  } elseif ($y == 2) {
								  	$descripcion = $oOBC->DBQuote($cell);
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoND('tipo_cuenta',0,". $nombre . "," . $descripcion . ",1)");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTempTiposCuenta']['error']);
					}
				}
			}
		}

		function FrmMttoEstadosContrato() {
			//Inicializar Variables
			$oOBC = new OBC;
			$idECVal = '';
			$nombreECVal = '';
			$activoECVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idEC']) {
					$idEC = $_POST['idEC'];
				} else {
					$idEC = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$activo = $_POST['checkboxActivo'];

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoN('estado_contrato'," . $idEC . "," . $nombre . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idEC = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idECVal = 'value="' . $idEC . '"';
					$infoEC = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('estado_contrato'," . $idEC . ")");
					foreach ($infoEC as $row) {
						$nombreECVal = 'value="' . $row["nombre"] . '"';
						if ($row["activo"]) {
							$activoECVal = 'checked';
						}
					}

				}
			}
			echo '<input type="hidden" id="idEC" name="idEC" ' . $idECVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreECVal . ' required>';
			echo '</div>';
			echo '<div class="checkbox">';
			echo '<label>';
			echo '<input type="hidden" name="checkboxActivo" value="0" />';
			echo '<input type="checkbox" id="checkboxActivo" name="checkboxActivo" ' . $activoECVal . ' value="1"/> Activo';
			echo '</label>';
			echo '</div>';
		}

		function MostrarMatrizEstadosContrato() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('estado_contrato')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoEstadosContrato.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}

		function CargaMasivaEstadosContrato() {
			if (isset($_FILES['fileTempEstadosContrato'])) {
				if ($_FILES['fileTempEstadosContrato']['tmp_name']) {
					if (!$_FILES['fileTempEstadosContrato']['error']) {

					    $inputFile = $_FILES['fileTempEstadosContrato']['tmp_name'];

					    $targetdir = 'Up/' . basename($_FILES["fileTempEstadosContrato"]["name"]);
						move_uploaded_file($_FILES['fileTempEstadosContrato']['tmp_name'], $targetdir);
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
								  	$nombre = $oOBC->DBQuote($cell);
								  }
								  $y++;
								}
								$x++;

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoN('estado_contrato',0,". $nombre . ",1)");
							}
					    } else {
					    	error_log("Template has to be XLS 97-2003");
					    }
					} else{
					    error_log($_FILES['fileTempEstadosContrato']['error']);
					}
				}
			}
		}
	}
?>