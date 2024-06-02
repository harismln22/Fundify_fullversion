<?php

include_once("koneksi.php");
include_once("model/AkunModel.php");
include_once("view/RegisterView.php");

class RegisterController {
    
    private $register;

    function __construct(){
        $this->register = new AkunModel(Connecttt::$db_host, Connecttt::$db_user, Connecttt::$db_pass, Connecttt::$db_name);
    }

    public function index() 
    {
        $view = new RegisterView();
        $view->render();
    }

    function Regis($data)
    {
        $this->register->open();
        $isRegistered = $this->register->registration($data);
        $this->register->close();

        if ($isRegistered) {
            $_SESSION['username'] = $data['username'];
            header("location:index.php"); 
        } else {
            header("location:registrasi.php?error=registration_failed");
        }
    }
}