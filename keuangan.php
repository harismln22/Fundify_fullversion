<?php

session_start();

include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/KeuanganController.php");

$keuangan = new KeuanganController();

$type = $_GET['type']; // 'pemasukan' atau 'pengeluaran'

if ($_SESSION['role'] == 1) 
{ // jika akun login tersebut adalah admin

    if (!empty($_GET['id_hapus'])) 
    { // mengambil id hapus
        $id = $_GET['id_hapus'];
        $keuangan->delete($type, $id); 
    } 
    else if(isset($_GET['id_edit'])) 
    { // jika tombol edit ditekan
        if(isset($_POST['edit'])) 
        {
            $id = $_GET['id_edit'];
            $keuangan->edit($type, $id, $_POST);
        } 
        else 
        {
            $id = $_GET['id_edit'];
            $keuangan->indexEdit($type, $id);
        }
    } 
    else 
    {
        $keuangan->index($type);
    }
} else { // jika akun tersebut adalah user
    $keuangan->index($type);
}
