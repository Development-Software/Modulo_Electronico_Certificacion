<?php
     function msgError(){
        /* echo '<div class='alert alert-warning' role='alert' style='text-align: center;font-size: small;'>
            El usuario ingresado no existe
        </div>'; */
        echo "<script>$(document).ready(function() {
            Swal.fire({
                html: ' <div class=\"font_alert\" style=\"width: 100%;text-align: center;\"><img src=\"img/swal_alert/exclamacion.png\" width=\"100px\"><div style=\"font-weight: bolder;\">Datos incorrectos</div><div>El usuario ingresado no existe</div></div>',
                confirmButtonColor: \"#000461\"
            }).then(function() {
                window.location.href = \"./\";
            });
        });
        </script>";
    } 

     function msgErrorPass(){
        /* echo "<div class='alert alert-warning' role='alert' style='text-align: center;font-size: small;'>
            Favor de validar su contraseña
        </div>"; */
        echo "<script>$(document).ready(function() {
            Swal.fire({
                html: ' <div class=\"font_alert\" style=\"width: 100%;text-align: center;\"><img src=\"img/swal_alert/exclamacion.png\" width=\"100px\"><div style=\"font-weight: bolder;\">Datos incorrectos</div><div>La contraseña ingresada es incorrecta</div></div>',
                confirmButtonColor: \"#000461\"
            }).then(function() {
                window.location.href = \"./\";
            });
        });
        </script>";
    }

     function msgErrorInactivo(){
       /* echo "<div class='alert alert-warning' role='alert' style='text-align: center;font-size: small;'>
        El usuario ingresado se encuentra inactivo
        </div>"; */
        echo "<script>$(document).ready(function() {
            Swal.fire({
                html: ' <div class=\"font_alert\" style=\"width: 100%;text-align: center;\"><img src=\"img/swal_alert/exclamacion.png\" width=\"100px\"><div style=\"font-weight: bolder;\">Usuario Inactivo</div><div>El usuario ingresa se encuentra inactivo, favor de contactar al administrador</div></div>',
                confirmButtonColor: \"#000461\"
            }).then(function() {
                window.location.href = \"./\";
            });
        });
        </script>";
        
    }

     function imprimeMensajeLogin($msg){
        if($msg==0){
             msgError();
        }elseif($msg==1){
             msgErrorPass();
        }elseif($msg==2){
             msgErrorInactivo();
        }
    }

?>