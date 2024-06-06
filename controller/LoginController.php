<?php

include_once("koneksi.php");
include_once("model/AkunModel.php");
include_once("view/LoginView.php");

class LoginController {
    
    private $login;

    function __construct(){
        $this->login = new AkunModel(Connecttt::$db_host, Connecttt::$db_user, Connecttt::$db_pass, Connecttt::$db_name);
    }

    public function index() 
    {
        $view = new LoginView();
        $view->render();
    }

    function cek($data)
    {
        $this->login->open();
        $user = $this->login->verifyUser($data);
        $this->login->close();

        if ($user) {
            header("location:index.php"); 
            exit;
        } else {
            $_SESSION['error'] = 'Username atau password salah';
            header("location:login.php?error=invalid_credentials");
            exit;
        }
    }

}