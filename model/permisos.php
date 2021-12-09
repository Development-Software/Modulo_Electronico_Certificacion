<?php


class permisos
{

  private $idUsuario;
  private $idrolUsuario;
  private $idPermiso;

  public function __construct($idUsuario, $idrolUsuario)
  {
    $this->database = new db();
    $this->idUsuario = $idUsuario;
    $this->idrolUsuario = $idrolUsuario;
  }

  public function listar_permisos()
  {

    $this->database->query("SELECT DISTINCT b.idPermiso,a.SubMenu FROM Permisos a 
    INNER JOIN Roles_Permisos b ON b.idPermiso=a.idPermiso
    WHERE a.idPrivilegio=1 AND b.idRol=:idrolUsuario ORDER BY 1");
    $this->database->bind(':idrolUsuario', $this->idrolUsuario);
    $this->database->execute();
    if ($this->database->rowCount() > 0) {
      return $this->database->resultset();
      $this->database = null;
    } else {
      return "";
    }
  }
  public function listar_total_permisos()
  {

    $this->database->query("SELECT DISTINCT b.idPermiso FROM Permisos a 
    INNER JOIN Roles_Permisos b ON b.idPermiso=a.idPermiso
    WHERE b.idRol=:idrolUsuario ORDER BY 1");
    $this->database->bind(':idrolUsuario', $this->idrolUsuario);
    $this->database->execute();
    if ($this->database->rowCount() > 0) {
      return $this->database->resultset();
      $this->database = null;
    } else {
      return "";
    }
  }
}
class menu
{

  private $items;
  private $active;

  public function __construct($items, $id_active)
  {
    $this->items = $items;
    $this->active = $id_active;
  }

  function menuInicio()
  {
    echo "<li class='nav-item'>
          <a href='./?menu=inicio' class='nav-link";
    if ($this->active == '1') {
      echo " active";
    }
    echo "'>
            <i class='nav-icon fas fa-home'></i>
            <p>Inicio</p>
          </a>
        </li>";
  }

  function menuAlumnos($permisos)
  {
    echo "<li class='nav-item has-treeview ";
    if ($this->active == '2' || $this->active == '3' || $this->active == '4') {
      echo " menu-open";
    } else {
      echo " menu-close";
    }
    echo "'>
          <a href='#' class='nav-link";
    if ($this->active == '2' || $this->active == '3' || $this->active == '4') {
      echo " active";
    }
    echo "'>
            <i class='nav-icon fas fa-user-graduate'></i>
            <p>
              Alumnos
              <i class='right fas fa-angle-left'></i>
            </p>
          </a>
          <ul class='nav nav-treeview'>";
    $this->submenu_alumno($permisos);
    echo "</ul>
          </li>";
  }

  function menuAlumnoscarga()
  {

    echo "<li class='nav-item'>
  <a href='./?menu=generar' class='nav-link";
    if ($this->active == '2') {
      echo " active";
    }
    echo "'style='text-indent: 15%;'>
    <i class='nav-icon fas fa-cogs'></i>
    <p>Generar</p>
  </a>
</li>";
  }

  function menuAlumnosfirmar()
  {
    echo "<li class='nav-item'>
  <a href='./?menu=firmar' class='nav-link";
    if ($this->active == '3') {
      echo " active";
    }
    echo "'style='text-indent: 15%;'>
    <i class='nav-icon fas fa-signature'></i>
    <p>Firmar</p>
  </a>
</li>";
  }

  function menuAlumnosconsultar()
  {

    echo "<li class='nav-item'>
          <a href='./?menu=consultar' class='nav-link";
    if ($this->active == '4') {
      echo " active";
    }
    echo "'style='text-indent: 15%;'>
            <i class='nav-icon far fa-file-code'></i>
            <p>Consultar</p>
          </a>
        </li>";
  }

  function menuUsuarios($permisos)
  {
    echo "<li class='nav-item has-treeview ";
    if ($this->active == '5' || $this->active == '6' || $this->active == '7') {
      echo " menu-open";
    } else {
      echo " menu-close";
    }
    echo "'>
          <a href='pages/gallery.html' class='nav-link";
    if ($this->active == '5' || $this->active == '6' || $this->active == '7') {
      echo " active";
    }
    echo "'>
            <i class='nav-icon far fa-image'></i>
            <p>Usuarios y Roles 
            <i class='right fas fa-angle-left'></i></p>
          </a> <ul class='nav nav-treeview'>";
    $this->submenu_usuarios($permisos);
    echo "</ul>
          </li>";
  }
  function menuUsuariosPersonas()
  {
    echo "<li class='nav-item'>
          <a href='./?menu=usuarios' class='nav-link";
    if ($this->active == '5') {
      echo " active";
    }
    echo "' style='text-indent: 15%;'>
            <i class='fas fa-user-plus nav-icon'></i>
            <p>Usuarios</p>
          </a>
        </li>";
  }
  function menuUsuariosRoles()
  {
    echo "<li class='nav-item'>
          <a href='./?menu=roles' class='nav-link";
    if ($this->active == '6') {
      echo " active";
    }
    echo "' style='text-indent: 15%;'>
            <i class='fas fa-key nav-icon'></i>
            <p>Roles</p>
          </a>
        </li>";
  }
  function menuUsuariosCampus()
  {
    echo "<li class='nav-item'>
          <a href='./?menu=campus' class='nav-link";
    if ($this->active == '7') {
      echo " active";
    }
    echo "' style='text-indent: 15%;'>
            <i class='fas fa-school nav-icon'></i>
            <p>Campus</p>
          </a>
        </li>";
  }


  function menuConfiguracion($permisos)
  {
    echo "<li class='nav-item has-treeview ";
    if ($this->active == '8' || $this->active == '9' || $this->active == '10') {
      echo " menu-open";
    } else {
      echo " menu-close";
    }
    echo "'>
          <a href='#' class='nav-link";
    if ($this->active == '8' || $this->active == '9' || $this->active == '10') {
      echo " active";
    }
    echo "'>
            <i class='nav-icon fas fa-sliders-h'></i>
            <p>
              Configuración
              <i class='right fas fa-angle-left'></i>
            </p>
          </a>
          <ul class='nav nav-treeview'>";
    $this->submenu_configuracion($permisos);
    echo "</ul>
          </li>";
  }

  function menuConfiguracionSistema()
  {
    echo "<li class='nav-item'>
          <a href='./?menu=sistema' class='nav-link";
    if ($this->active == '8') {
      echo " active";
    }
    echo "' style='text-indent: 15%;'>
            <i class='fas fa-desktop nav-icon'></i>
            <p>Sistema</p>
          </a>
        </li>";
  }
  function menuConfiguracionCatalogos()
  {
    echo "<li class='nav-item'>
          <a href='./?menu=catalogos' class='nav-link";
    if ($this->active == '9') {
      echo " active";
    }
    echo "' style='text-indent: 15%;'>
            <i class='fas fa-book-open nav-icon'></i>
            <p>Catálogos</p>
          </a>
        </li>";
  }
  function menuConfiguracionAlumnos()
  {
    echo "<li class='nav-item'>
          <a href='./?menu=alumnos' class='nav-link";
    if ($this->active == '10') {
      echo " active";
    }
    echo "' style='text-indent: 15%;'>
            <i class='fas fa-graduation-cap nav-icon'></i>
            <p>Alumnos</p>
          </a>
        </li>";
  }


  function menuItems($items)
  {

    foreach ($items as $valor) {
      $item = $valor['idPermiso'];

      if ($item == '1') {
        $this->menuInicio();
      } elseif ($item == '2') {
        $this->menuAlumnos($items);
      } elseif ($item == '15') {
        $this->menuUsuarios($items);
      } elseif ($item == '29') {
        $this->menuConfiguracion($items);
      }
    }
  }

  function submenu_alumno($permisos){
    foreach ($permisos as $idPermiso => $valor) {
      $item = $valor['idPermiso'];
      $this->asignar_submenu_alumno($item);
    }
  }

  function asignar_submenu_alumno($id_item){
    if ($id_item == '3') {
      $this->menuAlumnoscarga();
    } elseif ($id_item == '7') {
      $this->menuAlumnosfirmar();
    } elseif ($id_item == '11') {
      $this->menuAlumnosconsultar();
    }
  }

  function submenu_usuarios($permisos)
  {
    foreach ($permisos as $idPermiso => $valor) {
      $item = $valor['idPermiso'];
      $this->asginar_submenu_usuario($item);
    }
  }

  function asginar_submenu_usuario($id_item)
  {
    if ($id_item == '16') {
      $this->menuUsuariosPersonas();
    } elseif ($id_item == '21') {
      $this->menuUsuariosRoles();
    } elseif ($id_item == '26') {
      $this->menuUsuariosCampus();
    }
  }

  function submenu_configuracion($permisos)
  {
    foreach ($permisos as $idPermiso => $valor) {
      $item = $valor['idPermiso'];
      $this->asginar_submenu_conf($item);
    }
  }

  function asginar_submenu_conf($id_item)
  {
    if ($id_item == '30') {
      $this->menuConfiguracionSistema();
    } elseif ($id_item == '34') {
      $this->menuConfiguracionCatalogos();
    } elseif ($id_item == '35') {
      $this->menuConfiguracionAlumnos();
    }
  }


}
