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
                <?php
                  $oOBA->FrmFOD();
                ?>
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
    <!--<script>window.jQuery || document.write('<script src="./bootstrap/js/vendor/jquery.min.js"><\/script>')</script>-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
            $(document).ready(function() {
                $('#selectDepartamento').change(function() {
                    var opt = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "pbActions.php",
                        data: {
                          'fa': 'test',
                          'selected_opt': opt,
                        },
                        success:function(data){
                          var arr = {value: 0, text: 'Seleccionar...'};
                          $('#selectMunicipio').append($('<option>', arr));
                            /*{
                            value: 1,
                            text: 'My option'
                          }));*/
                            //alert('This was sent back: ' + data);

                            /*$.each(items, function (i, item) {
    $('#mySelect').append($('<option>', { 
        value: item.value,
        text : item.text 
    }));
});*/
                        }
                    });
                });
            });
        </script>
    <script src="./bootstrap/js/vendor/popper.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>