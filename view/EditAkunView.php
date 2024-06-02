<?php
include_once("model/Template.php");
class EditAkunView {

    public function renderEditAkun()
    {
        $views = new Template("layout/editAkun.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->write();
    }
}