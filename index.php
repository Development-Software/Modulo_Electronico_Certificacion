<?php
session_start();
if (empty($_SESSION['usuarioid'])) {
    session_unset();
    session_destroy();
    require 'controller/mensajes_login.php';
    require 'view/login.php';
}else{
    //echo $_SESSION['usuarioid'];
    require 'controller/controller_login.php';
};
