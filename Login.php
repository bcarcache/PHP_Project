<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="./Imgs/Logo.png">
	<title>Portal O&M</title>

	<!-- Bootstrap core CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./bootstrap/css/signin.css" rel="stylesheet">
</head>
<body>
	<?php
		if ($_SESSION) {
			session_unset();
			session_destroy();
		}
	?>
	<div class="container">

      <form class="form-signin" action="Welcome.php" method="POST">
        <center><h2 class="form-signin-heading">Ingrese sus credenciales</h2></center>
        <input type="text" name="inputUsuario" class="form-control" placeholder="Usuario" required autofocus>
        <input type="password" name="inputPassword" class="form-control" placeholder="Contraseña" required>
        <input class="btn btn-lg btn-primary btn-block" type="submit" value="Ingresar"/>
      </form>

    </div>
</body>
</html>