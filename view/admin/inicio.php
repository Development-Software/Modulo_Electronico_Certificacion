<?php
include_once '../../templates/header.php';
include_once '../../templates/navegacion.php';
?>
<!-- Site wrapper -->
<div class="wrapper" style="width: 100%;">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <div style="width: 100%; text-align:end;">
    </div>
  </nav>
  <!-- /.navbar -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper row justify-content-center align-items-center minh-100">

    <div class="jumbotron" style="padding:10px; width: 80%; margin:auto; text-align:center;background: linear-gradient(to top, #00adee 0%,#273896 84%,#2e3192 100%,#2989d8 100%,#207cca 100%,#7db9e8 100%);">
      <h1 class="h1-responsive" style="color: #fff;">Bienvenid@ Módulo Electronico de Certificación</h1>
    </div>

    <div class="row" style="width: 100%;margin-top:10px;">
      <div class="col-md-2"></div>
      <div class="col-md-3" style="margin: auto;">
        <!-- Card Numero de Registros cargados -->
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                  Registros totales cargados</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                  <div>
                    <span class="counter" data-count="<?php echo $registros_totales['Folios'] ?>">0</span>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-cloud-upload-alt fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-3" style="margin: auto;">
        <!-- Card Numero de Registros cargados -->
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                  Registros totales firmados</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">
                  <div>
                    <span class="counter" data-count="<?php echo $registros_totales_xml['Folios'] ?>">0</span>
                  </div>
                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-file-signature fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-2"></div>
    </div>
    <div class="card" style="margin:auto;"><canvas id="registrosxcampus" width="600px" height="400px"></canvas></div>
    <div class="card" style="margin:auto;"><canvas id="selladosxcampus" width="600px" height="400px"></canvas></div>
  </div>
  <!-- /.content-wrapper -->
  <script>
    $(document).ready(function() {
      showGraph();
      showGraph2();
    });
    $(document).ready(function() {

      $('.counter').each(function() {
        var $this = $(this),
          countTo = $this.attr('data-count');

        $({
          countNum: $this.text()
        }).animate({
            countNum: countTo
          },

          {

            duration: 3000,
            easing: 'linear',
            step: function() {
              $this.text(Math.floor(this.countNum));
            },
            complete: function() {
              $this.text(this.countNum);
              //alert('finished');
            }
          });
      });
    });



    function showGraph() {
      {
        $.post("../../controller/controller_charts.php?id_chart=1",
          function(data) {
            console.log(data);
            var folios = [];
            var Campus = [];
            var data;

            var datos = eval('(' + data + ')');
            var registros = datos.length;
            n = 0;
            while (n < registros) {
              folios.push(datos[n].Folios)
              Campus.push(datos[n].Campus)
              n++;
            }

            var chartdata = {
              labels: Campus,
              datasets: [{
                label: 'Folios registrados',
                backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1,
                data: folios
              }]
            };

            var graphTarget = $("#registrosxcampus");

            var barGraph = new Chart(graphTarget, {
              type: 'line',
              data: chartdata,
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
                },
                title: {
                  display: true,
                  text: 'Registros cargados por campus (ultimos 7 días)'
                },
                legend: {
                  display: false
                }
              }
            });
          });
      }
    }

    function showGraph2() {
      {
        $.post("../../controller/controller_charts.php?id_chart=2",
          function(data) {
            console.log(data);
            var folios = [];
            var campus = [];
            var data;

            var datos = eval('(' + data + ')');
            var registros = datos.length;
            n = 0;
            while (n < registros) {
              folios.push(datos[n].Folios)
              campus.push(datos[n].Campus)
              n++;
            }

            var chartdata = {
              labels: campus,
              datasets: [{
                label: 'Folios firmados',
                backgroundColor: [
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)'
                ],
                borderColor: [
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)'
                ],
                borderWidth: 1,
                data: folios,

              }]
            };

            var graphTarget = $("#selladosxcampus");

            var barGraph = new Chart(graphTarget, {
              type: 'bar',
              data: chartdata,
              options: {
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true
                    }
                  }]
                },
                title: {
                  display: true,
                  text: 'Registros firmados por campus (ultimos 7 días)'
                },
                legend: {
                  display: false
                }
              }
            });
          });
      }
    }
  </script>
  <?php
  include_once '../../templates/footer.php'; ?>


  </html>