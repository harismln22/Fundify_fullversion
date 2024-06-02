<?php

session_start();

include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/PemasukanController.php");

$masuk = new PemasukanController();

if ($_SESSION['role'] == 1) // jika akun login tersebut adalah admin
{
    if (!empty($_GET['id_hapus'])) // mengambil id hapus
    {
        $id = $_GET['id_hapus'];
        $masuk->delete($id); 
    }
    else if(isset($_GET['id_edit'])) // jika tombol edit ditekan
    {
        if(isset($_POST['edit']))
        {
            $id = $_GET['id_edit'];
            $masuk->edit($id, $_POST);
        }
        else{
            $masuk->indexEdit();
        }
    }
    else {
        $masuk->indexAdmin();
    }
} else { // jika akun tersebut adalah user
    $masuk->indexUser();
}