<?php

session_start();

include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/LoginController.php");

$loginController = new LoginController();

if (isset($_POST["Login"])) {
    // Panggil fungsi cek pada LoginController untuk memproses login
    $loginController->cek($_POST);
} else {
    // Tampilkan halaman login jika tidak ada data POST yang diterima
    $loginController->index();
}
