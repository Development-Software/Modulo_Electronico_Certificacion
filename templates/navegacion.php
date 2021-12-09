<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #000461;">
  <!-- Brand Logo -->
  <a href="../../" class="brand-link" style="text-align: center;">
    <span class="brand-text font-weight-light"><img src="../../img/menu/LogoUM.png" width="230px"></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="../../img/menu/profile_user.png" class="img-circle elevation-2" alt="User Image" />
      </div>
      <div class="info">
        <div class="d-block" style="color: #fff;"><?php echo ucwords($nombre_user) ?></div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <?php
        $menu = new menu($permisos_user,$active_inicio);
        $menu_item= $menu->menuItems($permisos_user);
        ?>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
    <br>
    <br>
    <a href="./?menu=logout">  
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="../../img/menu/logout.png" class="img-circle elevation-2" alt="User Image"  style="width: 25px;"/>
      </div>
      <div class="info">
        <div class="d-block" style="color: #fff;">Cerrar Sesión</div>
      </div>
    </div>
    </a>
  </div>
  <!-- /.sidebar -->
</aside>