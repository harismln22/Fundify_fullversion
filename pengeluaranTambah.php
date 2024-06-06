<?php

session_start();

include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/PengeluaranController.php");

$createKeluaran = new PengeluaranController();
if(isset($_POST['add']))
{
    $createKeluaran->add($_POST);
}
else{
    $createKeluaran->indexTambah();
}

