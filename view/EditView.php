<?php
include_once("model/Template.php");
class EditView {

    public function renderEditPemasukan()
    {
        $isiJudul = "Edit pemasukan data";
        $formSumber = "<div class='form-group'>
                            <label for='sumber'>Sumber</label>
                            <input type='text' name='sumber' id='sumber' class='form-control' placeholder='sumber...' required>
                        </div>";

        $views = new Template("layout/edit.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("JUDUL", $isiJudul);
        $views->replace("FORM_SUMBER", $formSumber);
        $views->write();
    }
    public function renderEditPengeluaran()
    {
        $formSumber = "";
        $isiJudul = "Edit pengeluaran data";
        $views = new Template("layout/edit.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("JUDUL", $isiJudul);
        $views->replace("FORM_SUMBER", $formSumber);
        $views->write();
    }
}