<?php	
	session_start();
  require_once('./Classes/OBA.php');
  $oOBA = new OBA;
  $oOBA->validarSesion();
  $oOBA->CMFOD();
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

          <form method="POST">
            <div class="row">
                <?php
                  //$oOBA->FrmFOD();
                  $oOBA->FrmFOD3C();
                ?>
            </div>
            <center>
              <input type="submit" class="btn btn-success" value="Guardar"/>
              <a onClick="limpiarForm()" class="btn btn-success">Limpiar</a>
            </center>
          </form>
          <br/>
          <br/>


      <div class="row">
        <div class="col-lg-12">
      <table class="table table-hover table-responsive">
        <thead> <tr> 
          <th>ID</th>
          <th>TES</th>
          <th>Nombre</th> 
          <th>Estado</th> 
          <th>Criticidad</th> 
          <th>Fecha de Construcción</th> 
          <th>Tipificación</th> 
          <th>Responsable de Zona</th> 
          <th>Zona</th> 
          <th>Zona Geográfica</th> 
          <th>Área</th> 
          <th>Departamento</th> 
          <th>Municipio</th> 
          <th>Dirección</th> 
          <th>Latitud</th> 
          <th>Longitud</th> 
          <th>Dueño de Sitio</th> 
          <th>Tipo de Cuenta</th> 
          <th>Estado de Contrato</th> 
          <th>Tipo de Cobertura</th> 
          <th>Forma de Acceso</th> 
          <th>Contacto de Acceso</th> 
          <th>Restricción de Acceso</th> 
          <th>Peligrosidad</th> 
          <th>Tipo de Estructura</th> 
          <th>Altura</th> 
          <th>Tipo de Hierro</th> 
          <th>Tipo de Muro Perimetral</th> 
          <th>Tipo de Material Shelter</th> 
          <th>Operadores Coubicados</th> 
          <th>NIC</th> 
          <th>Comentarios de Conexión Eléctrica</th> 
          <th>Compañía Eléctrica</th> 
          <th>Medidor de Energía</th> 
          <th>Línea Eléctrica</th> 
          <th>Capacidad de Transformador (KVA)</th> 
          <th>Marca de Genset</th> 
          <th>Modelo de Genset</th> 
          <th>Capacidad de Genset (KVA)</th> 
          <th>Capacidad de Tanque (Galones)</th> 
          <th>Estado de Generador</th> 
          <th>Marca ATS</th> 
          <th>Capacidad de ATS</th> 
          <th>Estado de ATS</th> 
          <th>GSM Nemonico</th> 
          <th>UMTS Nemonico</th> 
          <th>LTE Nemonico</th> 
          <th>Cluster Name</th> 
          <th>GSM Launch Date</th> 
          <th>UMTS Launch Date</th> 
          <th>LTE Launch Date</th> 
          <th>UMTS Carrier 1</th> 
          <th>UMTS Carrier 2</th> 
          <th>UMTS Carrier 3</th> 
          <th>LTE Cells</th> 
          <th>RRUs por Site</th> 
          <th>Antenas por Site</th> 
          <th>2G TX Type</th> 
          <th>2G TX Marca</th> 
          <th>3G TX Type</th> 
          <th>3G TX Marca</th> 
          <th>4G TX Type</th> 
          <th>4G TX Marca</th> 
          <th>Gabinete Modelo 1</th> 
          <th>Rectifier Type Cab 1</th> 
          <th>Marca de Baterías Cab 1</th> 
          <th>Número de Baterías Cab 1</th> 
          <th>Autonomía de Gabinete 1 (horas)</th> 
          <th>Gabinete Modelo 2</th> 
          <th>Rectifier Type Cab 2</th> 
          <th>Marca de Baterías Cab 2</th> 
          <th>Número de Baterías Cab 2</th> 
          <th>Autonomía de Gabinete 2 (horas)</th> 
          <th>Gabinete Modelo 3</th> 
          <th>Rectifier Type Cab 3</th> 
          <th>Marca de Baterías Cab 3</th> 
          <th>Número de Baterías Cab 3</th> 
          <th>Autonomía de Gabinete 3 (horas)</th> 
          <th>Minishelter 1</th> 
          <th>Rectifier Type Minishelter 1</th> 
          <th>Marca de Baterías Minishelter 1</th> 
          <th>Número de Baterías Minishelter 1</th> 
          <th>Autonomía de Minishelter 1 (horas)</th> 
          <th>Minishelter 2</th> 
          <th>Rectifier Type Minishelter 2</th> 
          <th>Marca de Baterías Minishelter 2</th> 
          <th>Número de Baterías Minishelter 2</th> 
          <th>Autonomía de Minishelter 2 (horas)</th> 
          <th>Gabinete Ericsson 1</th> 
          <th>Gabinete Ericsson 2</th> 
          <th>Marca de Fuerza 1</th> 
          <th>Modelo de Fuerza 1</th> 
          <th>Voltage de Salida de Fuerza 1</th> 
          <th>Marca de Baterías de Fuerza 1</th> 
          <th>Número de Baterias de Fuerza 1</th> 
          <th>Capacidad AH de Fuerza 1</th> 
          <th>Marca de Fuerza 2</th> 
          <th>Modelo de Fuerza 2</th> 
          <th>Voltage de Salida de Fuerza 2</th> 
          <th>Marca de Baterías de Fuerza 2</th> 
          <th>Número de Baterías de Fuerza 2</th> 
          <th>Capacidad AH de Fuerza 2</th> 
          <th>Fecha de Creación</th> 
          <th>Creado Por</th> </tr> </thead> 
        <tbody>
          <?php
            $oOBA->MMFOD();
          ?>
        </tbody>
      </table>
      </div>
      <a href="Classes/OBP.php?fa=FOD" target="_blank">Descargar Excel</a>
    </div>
      
      <br/>
      <br/>

      <center><h1>Carga Masiva de FOD</h1></center>
      <div class="row">
        <div class="col-lg-4">
        </div>
        <div class="col-lg-4">
          <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <input type="file" id="fileTemp" name="fileTemp" accept=".xls" required>
            </div>
            <div class="form-group" align="center">
              <a href="./Temp/FOD.xls" name="excelTemplate">Descargar Plantilla</a><br/>
              <a href="./Temp/FOD.xls" name="excelTemplate"><img src="./Imgs/excel.png" height="35"></a>
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
    <!--<script>window.jQuery || document.write('<script src="./bootstrap/js/vendor/jquery.min.js"><\/script>')</script>-->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
            $(document).ready(function() {
                $('#selectDepartamento').change(function() {
                    var opt = $(this).val();
                    $.ajax({
                        type: "POST",
                        url: "Classes/OBP.php",
                        datatype: "html",
                        data: {
                          'fa': 'deptmun',
                          'selected_opt': opt,
                        },
                        success:function(data){
                          $('#selectMunicipio').empty();
                          var arr = {value: 0, text: 'Seleccionar...'};
                          $('#selectMunicipio').append($('<option>', arr));
                          var l1 = data.split("@@");
                          for (var i = 0; i < l1.length; ++i) {
                            var l2 = l1[i].split("@");
                            if (l2[0] && l2[1]) {
                              var narr = {value: l2[0], text: l2[1]};
                              $('#selectMunicipio').append($('<option>', narr));
                            }
                          }
                          $("#selectMunicipio").removeAttr('disabled');
                        }
                    });

                    if (!opt) {
                      //alert('no opt');
                      //$("#selectMunicipio").prop('disabled', true);
                    }
                });
            });
        </script>
    <script src="./bootstrap/js/vendor/popper.min.js"></script>
    <script src="./bootstrap/js/bootstrap.min.js"></script>
</body>
</html>