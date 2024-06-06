<?php
include_once("model/Template.php");
class LoginView {

    public function render()
    {
        
        $views = new Template("layout/login.html");
        $views->write();
    }
}