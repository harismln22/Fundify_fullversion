<?php
include_once("model/Template.php");
class RegisterView {

    public function render()
    {
        $views = new Template("layout/registrasi.html");
        $views->write();
    }
}

