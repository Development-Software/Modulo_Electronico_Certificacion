<?php
include dirname(dirname(dirname(__DIR__))) . '/templates/header.php';
include '../../templates/navegacion.php';
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
            <h4>Configuración del Sistema</h4>
        </div>
    </nav>

    <!-- /.navbar -->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper row justify-content-center align-items-center minh-100">
        <div class="card container h-100 py-2">
            <div style="padding: 15px;text-align:center;">
                <h4>Parametros Generales del Sistema</h4>
            </div>
            <ul class="nav nav-tabs border-0" id="sistemaTab" role="tablist">
                <?php if ($permiso_autenticacion) {
                    echo "<li class=\"nav-item\">
                    <a class=\"nav-link border ";if ($permiso_autenticacion) { echo "active";} echo" border-primary border-bottom-0 bg-primary text-white\" id=\"autenticacion-tab\" data-toggle=\"tab\" href=\"#autenticacion\" role=\"tab\" aria-controls=\"autenticacion\" aria-selected=\"true\">Autenticación</a>
                </li>";
                } ?>
                <?php if ($permiso_fuente) {
                echo"<li class=\"nav-item\">
                    <a class=\"nav-link border ";if (!$permiso_autenticacion && $permiso_fuente) { echo "active";} echo" border-warning border-bottom-0 bg-warning text-dark\" id=\"fuente-tab\" data-toggle=\"tab\" href=\"#fuente\" role=\"tab\" aria-controls=\"fuente\" aria-selected=\"false\">Fuente</a>
                </li>";
                }?>
                <?php if ($permiso_firma) {
                echo"<li class=\"nav-item\">
                    <a class=\"nav-link border ";if (!$permiso_autenticacion && !$permiso_fuente && $permiso_firma) { echo "active show";} echo" border-danger border-bottom-0 bg-danger text-white\" id=\"firma-tab\" data-toggle=\"tab\" href=\"#firma\" role=\"tab\" aria-controls=\"firma\" aria-selected=\"false\">Firma</a>
                </li>";
                } ?>
            </ul>

            <div class="tab-content h-75">
                <?php if ($permiso_autenticacion) { echo 
                "<div class=\"tab-pane h-100 p-3 ";if ($permiso_autenticacion) { echo "active";} echo" border border-primary\" id=\"autenticacion\" role=\"tabpanel\" aria-labelledby=\"autenticacion-tab\">";include_once 'sistema/autenticacion.php'; echo"</div>";
                }?>
                <?php if ($permiso_fuente) {
                echo "<div class=\"tab-pane h-100 p-3 border border-warning fade ";if (!$permiso_autenticacion && $permiso_fuente) { echo "active show";} echo"\" id=\"fuente\" role=\"tabpanel\" aria-labelledby=\"fuente-tab\">"; include_once 'sistema/fuente.php'; echo "</div>";
                }?>
                <?php if ($permiso_firma) {
                echo "<div class=\"tab-pane h-100 p-3 border border-danger fade ";if (!$permiso_autenticacion && !$permiso_fuente && $permiso_firma) { echo "active show";} echo"\" id=\"firma\" role=\"tabpanel\" aria-labelledby=\"firma-tab\">";$cargar_datos_cer;include_once 'sistema/firma.php';echo "</div>";
                }?>
            </div>

        </div>
    </div>
    <!-- /.content-wrapper -->
    <script>
        $(document).ready(function() {
            if (location.hash) {

                $("a[href='" + location.hash + "']").tab("show");
            }
            $(document.body).on("click", "a[data-toggle='tab']", function(event) {
                location.hash = this.getAttribute("href");
            });
            $('a[href = "#autenticacion"]').click(function() {
                //$('style').remove(); 
                $('head').append('<style>.custom-control-input:checked~.custom-control-label::before { color: #fff !important; border-color: #00ADEF !important; background-color: #00ADEF !important;}</style>');
            });
            $('a[href = "#fuente"]').click(function() {
                $('head').append('<style>.custom-control-input:checked~.custom-control-label::before { color: #fff !important; border-color: #ffc107 !important; background-color: #ffc107 !important;}</style>');

            });
            $('a[href = "#firma"]').click(function() {
                $('#firma').load('configuracion/sistema/firma.php');
            });
        });
        $(window).on("popstate", function() {
            var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
            $("a[href='" + anchor + "']").tab("show");
        });
    </script>

    <?php
    include_once '../../templates/footer.php'; ?>


    </html>