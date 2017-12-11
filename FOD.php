<?php	
	session_start();
  require_once('./Classes/OBA.php');
  $oOBA = new OBA;
  $oOBA->validarSesion();
?>
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="./Imgs/Logo.png">
	<title>Portal O&M - FOD</title>

	<!-- Bootstrap core CSS -->
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./bootstrap/css/justified-nav.css" rel="stylesheet">
</head>
<body>
	<div class="container">

      <header class="masthead">
        <h3 class="text-muted">Portal O&M</h3>
      	<?php
          $oOBA->MostrarMenuApp();
      	?>
      </header>

      <center><h1>Matriz FOD</h1></center>

          <form>
      <div class="row">
        <div class="col-lg-6">
          <div class="form-group">
              <label for="inputNombres">Nombres</label>
              <input type="text" class="form-control" name="inputNombres" placeholder="Nombres" required>
            </div>
            <div class="form-group">
              <label for="inputApellidos">Apellidos</label>
              <input type="text" class="form-control" name="inputApellidos" placeholder="Apellidos" required>
            </div>
            <div class="form-group">
              <label for="inputTelefono">Teléfono</label>
              <input type="text" class="form-control" name="inputTelefono" placeholder="XXXX-XXXX" required>
            </div>
            <div class="form-group">
              <label for="inputUsuario">Usuario</label>
              <input type="text" class="form-control" name="inputUsuario" placeholder="Usuario" required>
            </div>
            <div class="form-group">
              <label for="inpuPassword">Password</label>
              <input type="password" class="form-control" name="inputPassword" placeholder="Password" required>
            </div>
        </div>
        <div class="col-lg-6">
          <div class="form-group">
              <label for="inputNombres2">Nombres</label>
              <input type="text" class="form-control" name="inputNombres2" placeholder="Nombres" required>
            </div>
            <div class="form-group">
              <label for="inputApellidos2">Apellidos</label>
              <input type="text" class="form-control" name="inputApellidos2" placeholder="Apellidos" required>
            </div>
            <div class="form-group">
              <label for="inputTelefono2">Teléfono</label>
              <input type="text" class="form-control" name="inputTelefono2" placeholder="XXXX-XXXX" required>
            </div>
            <div class="form-group">
              <label for="inputUsuario2">Usuario</label>
              <input type="text" class="form-control" name="inputUsuario2" placeholder="Usuario" required>
            </div>
            <div class="form-group">
              <label for="inpuPassword2">Password</label>
              <input type="password" class="form-control" name="inputPassword2" placeholder="Password" required>
            </div>
        </div>
      </div>

          </form>
      <br/>

        <table class="table table-hover table-responsive">
          <thead> <tr> <th>TES</th> <th>First Name</th> <th>Last Name</th> <th>Username</th> <th>Username</th> <th>Username</th> <th>Username</th> <th>Username</th> <th>Username</th> <th>Username</th> <th>Username</th> <th>Username</th> <th>Username</th> <th>Username</th> </tr> </thead> <tbody> <tr> <th scope="row"><a href="#">TES1740</a></th> <td>Mark</td> <td>Otto</td> <td>@mdo</td> <td>Otto</td> <td>Otto</td> <td>Otto</td> <td>Otto</td> </tr> </tbody>
        </table>

      <!-- Site footer -->
      <footer class="footer">
        <p>Made by Bernardo Carcache &copy; Tigo - Huawei 2017</p>
      </footer>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="./bootstrap/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="./bootstrap/js/vendor/popper.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>