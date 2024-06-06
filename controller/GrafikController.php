<?php

include_once("koneksi.php");
include_once ("view/GrafikView.php");
include_once("model/KeuanganModel.php");

class GrafikController
{
  private $grafik;

  function __construct()
  {
    $this->grafik = new KeuanganModel(Connecttt::$db_host, Connecttt::$db_user, Connecttt::$db_pass, Connecttt::$db_name);
  }

  public function index()
  {
    $this->grafik->open();
    $incomeData = $this->grafik->getIncomeDataPerMonth();
    $expenseData = $this->grafik->getExpenseDataPerMonth();

    $view = new GrafikView();
    $view->render($incomeData, $expenseData);
  }
}