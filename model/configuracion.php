<?php
class configuracion
{
  
  private $database;
  private $dominio;
  private $dn;
  private $atributo;
  private $tipo;
  private $host;
  private $usuario;
  private $password;

  public function __construct(){
  	  $this->database = new db();
  }
  //AUTENTICACION
  public function setDominio($dominio){
      $this->dominio = $dominio;
  }
  public function setDN($dn){
      $this->dn = $dn;
  }
  public function setAtributo($atributo){
      $this->atributo = $atributo;
  }  
  public function setTipo($tipo){
      $this->tipo = $tipo;
  }
  
  
  public function getDominio(){
      return $this->dominio;
  }
  public function getDN(){
      return $this->dn;
  }
  public function getAtributo(){
      return $this->atributo;
  }
  public function getTipo(){
      return $this->tipo;
  }
  


  //FUENTE
  public function setHostFuente($host){ $this->host = $host;}
  public function setUsuarioFuente($usuario){ $this->usuario = $usuario;}
  public function setPasswordFuente($password){ $this->password = $password;}

  public function getHostFuente(){return $this->host;}
  public function getUsuarioFuente(){return $this->usuario;}
  public function getPasswordFuente(){return $this->password;}

   //CER
   public function setSerieCerFirma($serialcer){ $this->serialcer = $serialcer;}
   public function setNombreCerFirma($nombrecer){ $this->nombrecer = $nombrecer;}
   public function setCurpCerFirma($curpcer){ $this->curpcer = $curpcer;}
 
   public function getSerieCerFirma(){return $this->serialcer;}
   public function getNombreCerFirma(){return $this->nombrecer;}
   public function getCurpCerFirma(){return $this->curpcer;}
  

  public function getTipoAutenticacion(){ 
    try {
        $this->database->beginTransaction();

        $this->database->query("SELECT Fuente, Autenticacion, Host_BD, Usuario_BD, Contraseña, LDAP_Domain, BaseDn, SearchAttr from Parametros_Generales where Id=:idParametro");
        $this->database->bind(':idParametro',1);
    	  $this->database->execute();
        if($this->database->endTransaction()){
    		    return $this->database->single();
           $this->database = null;
         }
        
       }catch ( PDOException $e ) {
            echo 'ERROR!';
            print_r( $e );
        }
  }
  public function getTipofuente(){ 
    try {
        $this->database->beginTransaction();

        $this->database->query("SELECT Fuente, Autenticacion, Host_BD, Usuario_BD, Contraseña, LDAP_Domain, BaseDn, SearchAttr from Parametros_Generales where Id=:idParametro");
        $this->database->bind(':idParametro',1);
    	  $this->database->execute();
        if($this->database->endTransaction()){
    		    return $this->database->single();
           $this->database = null;
         }
        
       }catch ( PDOException $e ) {
            echo 'ERROR!';
            print_r( $e );
        }
  }

  public function getFirma(){ 
    try {
        $this->database->beginTransaction();

        $this->database->query("SELECT CURP_FIEL,Nombre_FIEL,Numero_Serie_FIEL from Parametros_Generales where Id=:idParametro");
        $this->database->bind(':idParametro',1);
    	  $this->database->execute();
        if($this->database->endTransaction()){
    		    return $this->database->single();
           $this->database = null;
         }
        
       }catch ( PDOException $e ) {
            echo 'ERROR!';
            print_r( $e );
        }
  }

  public function updateAutenticacion(){
        try{    

            if($this->getTipo()==0){
                $this->database->beginTransaction();

                $this->database->query("UPDATE Parametros_Generales 
                                        SET 
                                          Autenticacion=:tipo,
                                          LDAP_Domain=:dominio,
                                          BaseDn=:dn,
                                          SearchAttr=:atributo,
                                          Host_BD=:Host_BD,
                                          Usuario_BD=:Usuario_BD,
                                          Contraseña=:Contrasena 
                                        WHERE Id=:id limit 1");
              
                $this->database->bind(':id',1);
                $this->database->bind(':tipo',$this->getTipo());
                $this->database->bind(':dominio',$this->getDominio());
                $this->database->bind(':dn',$this->getDN());
                $this->database->bind(':atributo',$this->getAtributo());
                $this->database->bind(':Host_BD','');
                $this->database->bind(':Usuario_BD','');
                $this->database->bind(':Contrasena','');
                      
                $this->database->execute();
                if($this->database->endTransaction()){
                    $res = array('res'=>true);
                    return true;
                }else{
                    $res = array('res'=>false);
                    return false;
                     }
            }

            if($this->getTipo()==1){
                $this->database->beginTransaction();

                $this->database->query("UPDATE Parametros_Generales 
                                        SET 
                                          Autenticacion=:tipo,
                                          LDAP_Domain=:dominio,
                                          BaseDn=:dn,
                                          SearchAttr=:atributo,
                                          Host_BD=:Host_BD,
                                          Usuario_BD=:Usuario_BD,
                                          Contraseña=:Contrasena 
                                        WHERE Id=:id limit 1");
              
                $this->database->bind(':id',1);
                $this->database->bind(':tipo',$this->getTipo());
                $this->database->bind(':dominio','');
                $this->database->bind(':dn','');
                $this->database->bind(':atributo','');
                $this->database->bind(':Host_BD','');
                $this->database->bind(':Usuario_BD','');
                $this->database->bind(':Contrasena','');
                      
                $this->database->execute();
                if($this->database->endTransaction()){
                    $res = array('res'=>true);
                    return true;
                }else{
                    $res = array('res'=>false);
                    return false;
                     }
            }


            
        }catch(Exception $e){
         echo $e->getMessage();
         //Rollback de la transacción.
         $this->database->cancelTransaction();
        $res = array('res'=>false);
        return false;
    }


  }

  public function updateFuente(){
        try{    

            if($this->getTipo()==1){
                $this->database->beginTransaction();

                $this->database->query("UPDATE Parametros_Generales 
                                        SET 
                                          Fuente=:tipo,
                                          Host_BD=:Host_BD,
                                          Usuario_BD=:Usuario_BD,
                                          Contraseña=:Contrasena 
                                        WHERE Id=:id limit 1");
              
                $this->database->bind(':id',1);
                $this->database->bind(':tipo',$this->getTipo());
                $this->database->bind(':Host_BD','');
                $this->database->bind(':Usuario_BD','');
                $this->database->bind(':Contrasena','');
                      
                $this->database->execute();
                if($this->database->endTransaction()){
                    $res = array('res'=>true);
                    return true;
                }else{
                    $res = array('res'=>false);
                    return false;
                     }
            }

            if($this->getTipo()==0){
                $this->database->beginTransaction();

                $this->database->query("UPDATE Parametros_Generales 
                                        SET 
                                          Fuente=:tipo,
                                          Host_BD=:Host_BD,
                                          Usuario_BD=:Usuario_BD,
                                          Contraseña=:Contrasena 
                                        WHERE Id=:id limit 1");
              
                $this->database->bind(':id',1);
                $this->database->bind(':tipo',$this->getTipo());
                $this->database->bind(':Host_BD',$this->getHostFuente());
                $this->database->bind(':Usuario_BD',$this->getUsuarioFuente());
                $this->database->bind(':Contrasena',$this->getPasswordFuente());
                      
                $this->database->execute();
                if($this->database->endTransaction()){
                    $res = array('res'=>true);
                    return true;
                }else{
                    $res = array('res'=>false);
                    return false;
                     }
            }


            
        }catch(Exception $e){
         echo $e->getMessage();
         //Rollback de la transacción.
         $this->database->cancelTransaction();
        $res = array('res'=>false);
        return false;
    }


  }

  public function updateCerFirma(){
    try{    
        $this->database->beginTransaction();

        $this->database->query("UPDATE Parametros_Generales 
                                SET 
                                  Numero_Serie_FIEL=:serieCer,
                                  Nombre_FIEL=:nombreCer,
                                  CURP_FIEL=:curpCer
                                WHERE Id=:id limit 1");
      
        $this->database->bind(':id',1);
        $this->database->bind(':serieCer',$this->getSerieCerFirma());
        $this->database->bind(':nombreCer',$this->getNombreCerFirma());
        $this->database->bind(':curpCer',$this->getCurpCerFirma());
              
        $this->database->execute();
        if($this->database->endTransaction()){
            $res = array('res'=>true);
            return true;
        }else{
            $res = array('res'=>false);
            return false;
             }
            
    }catch(Exception $e){
     echo $e->getMessage();
     //Rollback de la transacción.
     $this->database->cancelTransaction();
    $res = array('res'=>false);
    return false;
}
} 

function quitar_tildes($cadena) {
    $no_permitidas= array ("á","é","í","ó","ú","Á","É","Í","Ó","Ú","ñ","À","Ã","Ì","Ò","Ù","Ã™","Ã ","Ã¨","Ã¬","Ã²","Ã¹","ç","Ç","Ã¢","ê","Ã®","Ã´","Ã»","Ã‚","ÃŠ","ÃŽ","Ã”","Ã›","ü","Ã¶","Ã–","Ã¯","Ã¤","«","Ò","Ã","Ã„","Ã‹");
    $permitidas= array ("a","e","i","o","u","A","E","I","O","U","n","N","A","E","I","O","U","a","e","i","o","u","c","C","a","e","i","o","u","A","E","I","O","U","u","o","O","i","a","e","U","I","A","E");
    $texto = str_replace($no_permitidas, $permitidas ,$cadena);
    return $texto;
    }

}
