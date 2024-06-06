<?php

session_start();

// Periksa apakah variabel sesi untuk status login telah diatur
if (!isset($_SESSION['is_logged_in'])) {
    // Jika tidak, arahkan ke halaman login
    header('Location: login.php');
    exit;
}
// Sisanya dari kode index.php Anda
include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/IndexController.php");

$Index = new IndexController();

if ($_SESSION['role'] == 1) {
    // Jika role adalah 1, maka pengguna adalah admin
    if (isset($_GET['download_pdf'])) {
        $Index->downloadPDF();
        exit;
    }
    if(!empty($_GET['id_hapus']))
    {
        $id = $_GET['id_hapus'];
        $Index->delete($id); 
    }
    else if(isset($_GET['id_edit'])) // jika tombol edit ditekan
    {
        if(isset($_POST['edit']))
        {
            $id = $_GET['id_edit'];
            $Index->edit($id, $_POST);
        }
        else{
            $Index->indexEditAkun();
        }
    }
    else 
    {
        $Index->indexAdmin();
    }
} else {
    // Jika role adalah 0, maka pengguna adalah user
    if (isset($_GET['download_pdf'])) {
        $Index->downloadPDF();
        exit;
    }
    $Index->indexUser();
    
}
