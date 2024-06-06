<?php

session_start();

include_once("koneksi.php");
include_once("model/db.php");
include_once("model/Template.php");
include_once("controller/AboutController.php");

$about = new AboutController();
$view = new Template("layout/about.html");

$about->index();