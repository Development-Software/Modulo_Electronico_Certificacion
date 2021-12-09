<?php

if(!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['usuarioid'])||!isset($_SESSION['usuarioidRol'])){
    session_destroy ();
    header("Location: ../../");
    exit();
}