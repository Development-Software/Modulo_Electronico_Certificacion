<?php
include_once '../../templates/header.php';
include_once '../../templates/navegacion.php';
?>

 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light"> 
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>
      <div style="width: 100%; text-align:end;">
      <h1 style="font-family: 'Noto Sans JP', sans-serif;">Consulta/Descarga de Certificados</h1>
      </div>
    </nav>
    
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper justify-content-center align-items-center minh-100">
        <?php include_once dirname(__DIR__) . '/alumnos/consultar/reporte_consulta.php'; ?>
    </div>
    <!-- /.content-wrapper -->

    <?php
    include_once '../../templates/footer.php'; ?>


</html>