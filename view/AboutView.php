<?php
include_once("model/Template.php");
class AboutView {

    public function render()
    {
        $views = new Template("layout/about.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->write();
    }
}