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

		function MostrarPerfilesMttoUsuarios($perfil = '') {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pSeleccionarPerfiles()");

			foreach ($ret as $row) {
				if (strcmp($row["Nombre"], $perfil) == 0) {
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
			$this->MostrarPerfilesMttoUsuarios($perfilUsuario);
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

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idEstado']) {
					$idEstado = $_POST['idEstado'];
				} else {
					$idEstado = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$descripcion = $oOBC->DBQuote($_POST['inputDescripcion']);
				error_log($descripcion);

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoND('estado'," . $idEstado . "," . $nombre . "," . $descripcion . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idEstado = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idEstadoVal = 'value="' . $idEstado . '"';
					$infoEstado = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('estado'," . $idEstado . ")");
					foreach ($infoEstado as $row) {
						$nombreEstadoVal = 'value="' . $row["nombre"] . '"';
						$descripcionEstadoVal = $row["descripcion"];
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
		}

		function MostrarMatrizEstados() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('estado')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoEstados.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["descripcion"] . '</td> </tr>';
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

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoND('estado',0,". $nombre . "," . $descripcion . ")");
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

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idNC']) {
					$idNC = $_POST['idNC'];
				} else {
					$idNC = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$descripcion = $oOBC->DBQuote($_POST['inputDescripcion']);

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoND('criticidad'," . $idNC . "," . $nombre . "," . $descripcion . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idNC = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idNCVal = 'value="' . $idNC . '"';
					$infoNC = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('criticidad'," . $idNC . ")");
					foreach ($infoNC as $row) {
						$nombreNCVal = 'value="' . $row["nombre"] . '"';
						$descripcionNCVal = $row["descripcion"];
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
		}

		function MostrarMatrizCriticidad() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('criticidad')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoCriticidad.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["descripcion"] . '</td> </tr>';
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

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoND('criticidad',0,". $nombre . "," . $descripcion . ")");
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

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idTipificacion']) {
					$idTipificacion = $_POST['idTipificacion'];
				} else {
					$idTipificacion = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);
				$descripcion = $oOBC->DBQuote($_POST['inputDescripcion']);

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoND('tipificacion'," . $idTipificacion . "," . $nombre . "," . $descripcion . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idTipificacion = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idTipificacionVal = 'value="' . $idTipificacion . '"';
					$infoTipificacion = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('tipificacion'," . $idTipificacion . ")");
					foreach ($infoTipificacion as $row) {
						$nombreTipificacionVal = 'value="' . $row["nombre"] . '"';
						$descripcionTipificacionVal = $row["descripcion"];
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
		}

		function MostrarMatrizTipificaciones() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('tipificacion')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoTipificaciones.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> <td>' . $row["descripcion"] . '</td> </tr>';
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

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoND('tipificacion',0,". $nombre . "," . $descripcion . ")");
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

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idZona']) {
					$idZona = $_POST['idZona'];
				} else {
					$idZona = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoN('tipificacion'," . $idZona . "," . $nombre . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idZona = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idZonaVal = 'value="' . $idZona . '"';
					$infoZona = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('zona'," . $idZona . ")");
					foreach ($infoZona as $row) {
						$nombreZonaVal = 'value="' . $row["nombre"] . '"';
					}

				}
			}
			echo '<input type="hidden" id="idZona" name="idZona" ' . $idZonaVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreZonaVal . ' required>';
			echo '</div>';
		}

		function MostrarMatrizZonas() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('zona')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoZonas.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> </tr>';
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

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoN('zona',0,". $nombre . ")");
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

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idZG']) {
					$idZG = $_POST['idZG'];
				} else {
					$idZG = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoN('zona_geografica'," . $idZG . "," . $nombre . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idZG = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idZGVal = 'value="' . $idZG . '"';
					$infoZG = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('zona_geografica'," . $idZG . ")");
					foreach ($infoZG as $row) {
						$nombreZGVal = 'value="' . $row["nombre"] . '"';
					}

				}
			}
			echo '<input type="hidden" id="idZG" name="idZG" ' . $idZGVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreZGVal . ' required>';
			echo '</div>';
		}

		function MostrarMatrizZonasGeograficas() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('zona_geografica')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoZonasGeograficas.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> </tr>';
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

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoN('zona_geografica',0,". $nombre . ")");
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

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idArea']) {
					$idArea = $_POST['idArea'];
				} else {
					$idArea = 0;
				}
				$nombre = $oOBC->DBQuote($_POST['inputNombre']);

				$resultado = $oOBC->PDODBConnection("CALL pMttoCatalogoN('area'," . $idArea . "," . $nombre . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idArea = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idAreaVal = 'value="' . $idArea . '"';
					$infoArea = $oOBC->PDODBConnection("CALL pObtenerInformacionCatalogo('area'," . $idArea . ")");
					foreach ($infoArea as $row) {
						$nombreAreaVal = 'value="' . $row["nombre"] . '"';
					}

				}
			}
			echo '<input type="hidden" id="idArea" name="idArea" ' . $idAreaVal . '/>';
			echo '<div class="form-group">';
			echo '<label for="inputNombre">Nombre</label>';
			echo '<input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombre" ' . $nombreAreaVal . ' required>';
			echo '</div>';
		}

		function MostrarMatrizAreas() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizCatalogo('area')");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoAreas.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["nombre"] . '</td> </tr>';
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

								$resultado = $oOBC->PDODBConnectionNE("CALL pMttoCatalogoN('area',0,". $nombre . ")");
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
	}
?>