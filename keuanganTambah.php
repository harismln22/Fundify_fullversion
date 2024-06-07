<?php

session_start();

include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/KeuanganController.php");

$keuangan = new KeuanganController();

$type = $_GET['type']; // 'pemasukan' atau 'pengeluaran'
if(isset($_POST['add']))
{
    $keuangan->add($type,$_POST);
}
else{
    $keuangan->indexTambah($type);
}



