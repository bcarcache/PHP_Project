<?php	
	session_start();
  require_once('./Classes/OBA.php');
  $oOBA = new OBA;
  $oOBA->validarSesion();
  $oOBA->CargaMasivaUsuarios();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="icon" href="./Imgs/Logo.png">
	<title>Portal O&M - Mantenimiento de Usuarios</title>

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

      <center><h1>Mantenimiento de Usuarios</h1></center>

      <div class="row">
        <div class="col-lg-6">
          <form method="POST">
            <?php
              $oOBA->FrmMttoUsuarios();
            ?>
            <center>
              <input type="submit" class="btn btn-success" value="Guardar"/>
              <a onClick="limpiarForm()" class="btn btn-success">Limpiar</a>
            </center>
          </form>
        </div>

        <div class="col-lg-6">
          <table class="table table-hover table-responsive">
            <thead>
              <tr> <th>ID</th> <th>Perfil</th> <th>Nombres</th> <th>Apellidos</th> <th>Teléfono</th> <th>Usuario</th> <th>Activo</th> </tr>
            </thead>
            <tbody>
              <?php
                $oOBA->MostrarMatrizUsuarios();
              ?>
            </tbody>
          </table>
        </div>
      </div>
      
      <br/>
      <br/>

      <center><h1>Carga Masiva de Usuarios</h1></center>
      <div class="row">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4">
          <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <input type="file" id="fileTempUsuarios" name="fileTempUsuarios">
            </div>
            <div class="form-group" align="center">
              <a href="./Temp/Usuarios.xls" name="excelTemplate">Descargar Plantilla</a><br/>
              <a href="./Temp/Usuarios.xls" name="excelTemplate"><img src="./Imgs/excel.png" height="35"></a>
            </div>
            <center>
              <input type="submit" class="btn btn-success" value="Cargar"/>
            </center>
          </form>
        </div>
        <div class="col-lg-4">
        </div>
      </div>

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
    <script type="text/javascript">
      function populateForm (element) {
        alert('This is an alert');
        if (element.hasAttributes()) {
         var attrs = element.attributes;
         var output = "";
         for(var i = attrs.length - 1; i >= 0; i--) {
           alert(attrs[i].name + "->" + attrs[i].value);
         }
       }
      }

      function limpiarForm() {
        document.getElementById("idUsuario").value = '';
        document.getElementById("selectPerfil").value = '';
        document.getElementById("inputNombres").value = '';
        document.getElementById("inputApellidos").value = '';
        document.getElementById("inputTelefono").value = '';
        document.getElementById("inputUsuario").value = '';
        document.getElementById("inputPassword").value = '';
        document.getElementById("inputPasswordConfirm").value = '';
        document.getElementById("checkboxActivo").checked = false;
      }
    </script>
</body>
</html>