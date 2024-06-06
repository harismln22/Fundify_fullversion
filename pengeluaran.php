<?php

session_start();

include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/PengeluaranController.php");

$keluaran = new PengeluaranController();

if ($_SESSION['role'] == 1) {

    if (!empty($_GET['id_hapus'])) 
    {
        $id = $_GET['id_hapus'];
        $keluaran->delete($id); 
    }
    else if(isset($_GET['id_edit']))
    {
        if(isset($_POST['edit']))
        {
            $id = $_GET['id_edit'];
            $keluaran->edit($id, $_POST);
        }
        else
        {
            $id = $_GET['id_edit'];
            $keluaran->indexEdit($id);
        }
    }
    else {
        $keluaran->indexAdmin();
    }
} else {
    $keluaran->indexUser();
}