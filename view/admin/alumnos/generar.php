<?php
include_once '../../templates/header.php';
include_once '../../templates/navegacion.php';
?>
<div class="wrapper" style="width: 100%;">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>
        <div style="width: 100%; text-align:end;">
            <h1 style="font-family: 'Noto Sans JP', sans-serif;">Generación de de Certificados</h1>
        </div>
    </nav>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper  justify-content-center align-items-center minh-100">
        <?php if ($Source_checkedFile != '') {
            if ($id_registros == 1) {
                include_once dirname(__DIR__) . '/alumnos/generar/registros.php';
            } else {
                include_once dirname(__DIR__) . '/alumnos/generar/carga.php';
            }
        } ?>
    </div>
    <!-- /.content-wrapper -->
    <?php
    include_once '../../templates/footer.php'; ?>


    </html>