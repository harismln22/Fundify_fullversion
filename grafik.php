<?php

session_start();

include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/GrafikController.php");

$grafik = new GrafikController();

$grafik->index();