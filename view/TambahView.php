<?php
include_once("model/Template.php");
class TambahView {

    public function renderAddPemasukan()
    {
        $isiJudul = "Tambah Pemasukan Data";
        $formSumber = "<div class='form-group'>
                            <label for='sumber'>Sumber</label>
                            <input type='text' name='sumber' id='sumber' class='form-control' placeholder='sumber...' required>
                        </div>";

        $views = new Template("layout/tambah.html");
        
        $views->replace("JUDUL", $isiJudul);
        $views->replace("FORM_SUMBER", $formSumber);
        $views->write();
    }

    public function renderAddPengeluaran()
    {
        $isiJudul = "Tambah Pengeluaran Data";
        $formSumber = "";

        $views = new Template("layout/tambah.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("JUDUL", $isiJudul);
        $views->replace("FORM_SUMBER", $formSumber);
        $views->write();
    }

}