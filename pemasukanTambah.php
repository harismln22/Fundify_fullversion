<?php

session_start();

include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/PemasukanController.php");

$createMasukan = new PemasukanController();
if(isset($_POST['add']))
{
    $createMasukan->add($_POST);
}
else{
    $createMasukan->indexTambah();
}

