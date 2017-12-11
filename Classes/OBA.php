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
						echo '<a class="nav-link dropdown-toggle" href="" id="dropdown' . $dpcount . '" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' . utf8_encode($row["nombre"]) . '</a>';
						echo '<div class="dropdown-menu" aria-labelledby="dropdown' . $dpcount . '">';
						$ret2 = $oOBC->PDODBConnection("CALL pMenuPerfilN2(" . $_SESSION["idPerfil"] . "," . $row["id"] . ")");
						foreach ($ret2 as $row2) {
							echo '<a class="dropdown-item" href="' . $row2["pagina"] . '">' . utf8_encode($row2["nombre"]) . '</a>';
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
					echo '<h2>' . utf8_encode($row["nombre"]) . '</h2>';
					echo '<p>' . utf8_encode($row["descripcion"]) . '</p>';
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
				
				
				/*echo '<div class="col-lg-4">';
				echo '<h2>Heading</h2>';
				echo '<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>';
				echo '<p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>';
				echo '</div>';
				echo '<div class="col-lg-4">';
				echo '<h2>Heading</h2>';
				echo '<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>';
				echo '<p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>';
				echo '</div>';
				echo '</div>';
				echo '<br/>';*/
			}
		}

		function MostrarMatrizUsuarios() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizUsuarios()");

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
					$infoUsuario = $oOBC->PDODBConnection("CALL pObtenerInformacionMttoUsuario(" . $idUsuario . ")");
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

								$resultado = $oOBC->PDODBConnection("CALL pMttoUsuarioMasivo(" . $idPerfil . "," . $nombres . "," . $apellidos . "," . $telefono . "," . $usuario . "," . $password . "," . $activo . ")");
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
			$perfilUsuario = '';
			$nombresUsuarioVal = '';
			$apellidosUsuarioVal = '';
			$telefonoUsuarioVal = '';
			$usuarioVal = '';
			$activoUsuarioVal = '';

			//Validacion de Acciones
			if ($_POST) {
				if ($_POST['idEstado']) {
					$idEstado = $_POST['idEstado'];
				} else {
					$idEstado = 0;
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

				$resultado = $oOBC->PDODBConnection("CALL pMttoUsuario(" . $idEstado . "," . $idPerfil . "," . $nombres . "," . $apellidos . "," . $telefono . "," . $usuario . "," . $password . "," . $activo . ")");
			} elseif ($_GET) {
				$action = base64_decode(urldecode($_GET["fa"]));
				$idUsuario = base64_decode(urldecode($_GET["fid"]));
				if (strcmp($action, 'editrecord') == 0) {
					
					$idEstadoVal = 'value="' . $idEstado . '"';
					$infoUsuario = $oOBC->PDODBConnection("CALL pObtenerInformacionMttoUsuario(" . $idEstado . ")");
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
			echo '<input type="hidden" id="idEstado" name="idEstado" ' . $idEstadoVal . '/>';
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

		function MostrarMatrizEstados() {
			$oOBC = new OBC;
			$ret = $oOBC->PDODBConnection("CALL pMostrarMatrizUsuarios()");

			$fa = urlencode(base64_encode("editrecord"));

			foreach ($ret as $row) {
				$fid = urlencode(base64_encode($row["id"]));
				echo '<tr> <th scope="row"><a id="ra' . $row["id"] . '" href="MantenimientoUsuarios.php?fa=' . $fa . '&fid=' . $fid . '">' . $row["id"] . '</a></th> <td>' . $row["perfil"] . '</td> <td>' . $row["nombres"] . '</td> <td>' . $row["apellidos"] . '</td> <td>' . $row["telefono"] . '</td> <td>' . $row["usuario"] . '</td> <td>' . $row["activo"] . '</td> </tr>';
			}
		}
		}
	}
?>