<?php
include_once("model/Template.php");
class EditView {

    public function renderEditPemasukan($id_edit, $editData)
    {
        // Judul halaman
        $isiJudul = "Edit Pemasukan Data";

        // Form sumber
        $formSumber = "<div class='form-group'>
                            <label for='sumber'>Sumber</label>
                            <input type='text' name='sumber' id='sumber' class='form-control'value ='" . $editData['sumber'] ."' placeholder='Masukkan sumber...' required>
                        </div>";

        // Inisialisasi variabel untuk jumlah dan deskripsi
        $editJumlah = "";
        $editDeskripsi = "";

        // Menggunakan data yang diterima untuk mengisi nilai input
        $editJumlah .= "<input type='text' name='jumlah' class='form-control' value='" . $editData['jumlah'] . "' required>";
        $editDeskripsi .= "<input type='text' name='deskripsi' class='form-control' value='" . $editData['deskripsi'] . "' required>";

        // Membuat objek template
        $views = new Template("layout/edit.html");

        // Mengganti placeholder di template dengan nilai yang sesuai
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("JUDUL", $isiJudul);
        $views->replace("FORM_SUMBER", $formSumber);
        $views->replace("EDIT_JUMLAH", $editJumlah);
        $views->replace("EDIT_DESKRIPSI", $editDeskripsi);

        // Menulis hasil ke output
        $views->write();
    }

    public function renderEditPengeluaran($id, $editData)
    {
        
        $formSumber = "";

        $editJumlah = "";
        $editDeskripsi = "";

        $editJumlah .= "<input type='text' name='jumlah' class='form-control' value='" . $editData['jumlah'] . "' required>";
        $editDeskripsi .= "<input type='text' name='deskripsi' class='form-control' value='" . $editData['deskripsi'] . "' required>";

        $isiJudul = "Edit pengeluaran data";
        $views = new Template("layout/edit.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("JUDUL", $isiJudul);
        $views->replace("FORM_SUMBER", $formSumber);
        $views->replace("EDIT_JUMLAH", $editJumlah);
        $views->replace("EDIT_DESKRIPSI", $editDeskripsi);
        $views->write();
    }
}