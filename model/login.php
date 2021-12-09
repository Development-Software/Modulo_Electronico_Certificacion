<?php

class Login
{
  //const ADDSERVER = "LDAP://apolloglobal.int";

  private $UserName;
  private $UserPass;
  private $addserver;
  private $ldaprdn;//AD
  private $ldap;//AD
  private $bind;//AD
  private $filter;//AD
  private $filterType;//AD
  private $result;
  private $info;//AD
  private $autenticado;//AD
  private $database;

  public function __construct($UserName,$UserPass,$LDAP_Domain,$BaseDn,$SearchAttr){
  	  $this->database = new db();
  	  $this->UserName=$UserName;
	    $this->UserPass=$UserPass;
      $this->addserver = $LDAP_Domain;
      $this->ldaprdn = $BaseDn;
      $this->filterType = $SearchAttr;//"sAMAccountName";
  }

public function authUserBD(){
  include_once '../model/bitacora.php';
try {
    $passHash = password_hash($this->UserPass, PASSWORD_BCRYPT);
    $password = password_verify($this->UserPass, $passHash);

    $this->database->query("SELECT idUsuario,concat(Nombre,' ',Apellido_Paterno,' ',Apellido_Materno) as Nombre,Username,Password,u.idRol,r.Descripcion Rol,u.Activo
    FROM Usuarios u
    JOIN Roles r on r.idRol=u.idRol WHERE Username= BINARY :username");
    $this->database->bind(':username',$this->UserName);
  $this->database->execute();
  
  
    if($this->database->rowCount() > 0){

            $datosUser = $this->database->single();
            $pass=$datosUser['Password'];
			
            if(password_verify($this->UserPass,$pass)){
                
                $nombreUsuario = $datosUser['Nombre'];
                $usernameUsuario = $datosUser['Username'];
                $rolUsuario = $datosUser['Rol'];
                $idrolUsuario = $datosUser['idRol'];
                $idusuario = $datosUser['idUsuario'];
                $idActivo = $datosUser['Activo'];
                $_SESSION['usuarioNombre'] = $nombreUsuario;
                $_SESSION['usuarioUser'] = $usernameUsuario;
                $_SESSION['usuarioRol'] = $rolUsuario;
                $_SESSION['usuarioid'] = $idusuario;
                $_SESSION['usuarioidRol'] = $idrolUsuario;
                
                if ($idActivo==1) {
					
				 /*  $this->database->query("INSERT INTO Auditoria(idUsuario,Menu,Descripcion) VALUES(:idUsuario,:menu,:descripcion)");
				  $this->database->bind(':idUsuario',$_SESSION['usuarioid']);
				  $this->database->bind(':menu','Login');
				  $this->database->bind(':descripcion','Autenticacion');
				  $this->database->execute(); */
          
          $registro_bitacora=new bitacora();
          $registro_bitacora->registro_bitacora($idusuario,'Inicio','El usuario inicio sesión');
                  header("Location: ../view/admin/?menu=inicio",true,301);
                }else{
                  header("Location: ../?msg=2");
                }
           }else{
              header("Location: ../?msg=1");
           }
         
       
       $this->database = null;
     }else{          
        header("Location: ../?msg=0");
       }
    
   }catch ( PDOException $e ) {
        echo 'ERROR!';
        print_r( $e );
    }
  }


  public function authUserAD()
  {

      $this->ldap = ldap_connect($this->addserver);
      ldap_set_option($this->ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
      ldap_set_option($this->ldap, LDAP_OPT_REFERRALS, 0);
      $this->filter="($this->filterType=$this->UserName)";
      $this->bind = ldap_bind($this->ldap, $this->ldaprdn, $this->UserPass);
      if ($this->bind) {
        $this->filter="($this->filterType=$this->UserName)";
        $this->result=ldap_search($this->ldap,"dc=apolloglobal,dc=int",$this->filter);
        ldap_sort($this->ldap,$this->result,"sn");
        $this->info = ldap_get_entries($this->ldap, $this->result);
        $this->autenticado = $this->autenticaUserBD($this->info[0]['samaccountname'][0]);

        
        if($this->autenticado != ""){
            foreach ($this->autenticado as $datosUser) {
                $nombreUsuario = $datosUser['nombre'];
                $usernameUsuario = $datosUser['Username'];
                $rolUsuario = 'ADMINISTRADOR';//$datosUser['idRol'];
                $idusuario = $datosUser['idUsuario'];
            }

            $_SESSION['usuarioNombre'] = $nombreUsuario;
            $_SESSION['usuarioUser'] = $usernameUsuario;
            $_SESSION['usuarioRol'] = $rolUsuario;
            $_SESSION['usuarioid'] = $idusuario;
          
            switch ($_SESSION['usuarioRol']) {
                       case 'ADMINISTRADOR':
                          header("Location: ../admuser?me=inicio",true,301);
                          exit();
                          break;
                       case 'CAPTURISTA':
                          header("Location: ../admuser?me=balumno",true,301);
                          exit();
                          break;
                       default:
                         header("Location: ../?msg=0");//No encontró usuario BD
                         exit();
                         break;
                     }         
            

          //return $this->autenticado;
        }else{
          //return $this->autenticado = "";
          header("Location: ../?msg=0");//No encontró usuario BD
          exit();
        }

      }else{
        //return $this->autenticado = "";
        header("Location: ../?msg=0");//no encontró usuario en Directorio
        exit();
      }
  }

   public function autenticaUserBD($userLdap){
      
    $this->database->query("SELECT idUsuario,concat(Nombre,' ',Apellido_Paterno,' ',Apellido_Materno) as nombre,Username,Password,idRol
                  FROM Usuarios 
                WHERE Username = :username");
    $this->database->bind(':username',$userLdap);
    $this->database->execute();
    if($this->database->rowCount() > 0){
       return $this->database->resultset();
       $this->database = null;
     }else{
        return "";
       }
    
   }


   
}   
