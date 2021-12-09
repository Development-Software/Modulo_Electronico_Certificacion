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
      <h4>Configuración de Catálogos</h4>
      </div>
    </nav>
    
    <!-- /.navbar -->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper row justify-content-center align-items-center minh-100">
    <div class="card container h-100 py-2">
        <div style="padding: 15px;text-align:center;">
            <h4>Carga inicial de Catálogos</h4>
        </div>
        <ul class="nav nav-tabs border-0" id="sistemaTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active border border-dark border-bottom-0 bg-dark text-white" id="institucion-tab" data-toggle="tab" href="#institucion" role="tab" aria-controls="institucion" aria-selected="true">Institución</a>
            </li>
            <li class="nav-item">
                <a class="nav-link border border-dark border-bottom-0 bg-dark text-white" id="campus-tab" data-toggle="tab" href="#campus" role="tab" aria-controls="campus" aria-selected="false">Campus</a>
            </li>
            <li class="nav-item">
                <a class="nav-link border border-dark border-bottom-0 bg-dark text-white" id="carreras-tab" data-toggle="tab" href="#carreras" role="tab" aria-controls="carreras" aria-selected="false">Carreras</a>
            </li>
            <li class="nav-item">
                <a class="nav-link border border-dark border-bottom-0 bg-dark text-white" id="materias-tab" data-toggle="tab" href="#materias" role="tab" aria-controls="materias" aria-selected="false">Materias</a>
            </li>
            <li class="nav-item">
                <a class="nav-link border border-dark border-bottom-0 bg-dark text-white" id="rvoe-tab" data-toggle="tab" href="#rvoe" role="tab" aria-controls="rvoe" aria-selected="false">RVOE</a>
            </li>
            <li class="nav-item">
                <a class="nav-link border border-dark border-bottom-0 bg-dark text-white" id="plan-tab" data-toggle="tab" href="#plan" role="tab" aria-controls="plan" aria-selected="false">Plan de estudios</a>
            </li>
        </ul>

        <div class="tab-content h-75">
            <div class="tab-pane h-100 p-3 active border border-dark" id="institucion" role="tabpanel" aria-labelledby="institucion-tab"><?php include_once 'catalogos/institucion_file.php' ?></div>
            <div class="tab-pane h-100 p-3 border border-dark fade" id="campus" role="tabpanel" aria-labelledby="campus-tab"><?php include_once 'catalogos/campus_file.php' ?></div>
            <div class="tab-pane h-100 p-3 border border-dark fade" id="carreras" role="tabpanel" aria-labelledby="carreras-tab"><?php include_once 'catalogos/carreras_file.php' ?></div>
            <div class="tab-pane h-100 p-3 border border-dark fade" id="materias" role="tabpanel" aria-labelledby="materias-tab"><?php include_once 'catalogos/materias_file.php' ?></div>
            <div class="tab-pane h-100 p-3 border border-dark fade" id="rvoe" role="tabpanel" aria-labelledby="rvoe-tab"><?php include_once 'catalogos/rvoe_file.php' ?></div>
            <div class="tab-pane h-100 p-3 border border-dark fade" id="plan" role="tabpanel" aria-labelledby="plan-tab"><?php include_once 'catalogos/plan_estudios_file.php' ?></div>
        </div>

    </div>
    <script>
        $(document).ready(function() {
            //$('style').remove();
            $('head').append('<style>.nav-tabs .nav-link:not(.active) {border-color: transparent !important;background-color: transparent !important;color: #000000 !important;}</style>');

            if (location.hash) {

                $("a[href='" + location.hash + "']").tab("show");
            }
            $(document.body).on("click", "a[data-toggle='tab']", function(event) {
                location.hash = this.getAttribute("href");
            });

        });
        $(window).on("popstate", function() {
            var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
            $("a[href='" + anchor + "']").tab("show");
        });
    </script>
</div>
<!-- /.content-wrapper -->

<?php
include_once '../../templates/footer.php'; ?>


</html>