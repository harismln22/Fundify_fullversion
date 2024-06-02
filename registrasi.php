<?php

session_start();

include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/RegisterController.php");

$RegisterController = new RegisterController();

if (isset($_POST["Register"])) 
{
    $RegisterController->Regis($_POST);
} else {
    $RegisterController->index();
}