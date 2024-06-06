<?php

include_once ("koneksi.php");
include_once ("model/KeuanganModel.php");
include_once ("view/PengeluaranView.php");
include_once ("view/TambahView.php");
include_once ("view/EditView.php");

class PengeluaranController
{
  private $pengeluaran;
  function __construct()
  {
    $this->pengeluaran = new KeuanganModel(Connecttt::$db_host, Connecttt::$db_user, Connecttt::$db_pass, Connecttt::$db_name);
  }

  public function indexAdmin()
  {
    $this->pengeluaran->open();
    $this->pengeluaran->getDataKeluar();

    $data = array(
      'pengeluaran' => array(),
    );
    while ($row = $this->pengeluaran->getResult()) {
      // echo "<pre>";
      // print_r($row);
      // echo "</pre>";
      array_push($data['pengeluaran'], $row);
    }

    $this->pengeluaran->close();

    $view = new PengeluaranView();
    $view->renderAdmin($data);
  }

  public function indexUser()
  {
    $this->pengeluaran->open();
    $this->pengeluaran->getDataKeluar();

    $data = array(
      'pengeluaran' => array(),
    );
    while ($row = $this->pengeluaran->getResult()) {
      // echo "<pre>";
      // print_r($row);
      // echo "</pre>";
      array_push($data['pengeluaran'], $row);
    }

    $this->pengeluaran->close();

    $view = new PengeluaranView();
    $view->renderUser($data);
  }
  public function indexTambah()
  {
    $view = new TambahView();
    $view->renderAddPengeluaran();
  }

  public function indexEdit($id)
  {
    $this->pengeluaran->open();
    $getEdit = $this->pengeluaran->getForEditPengeluaran($id);
    //$resultDeskripsi = $this->pemasukan->getDeskripsi($id);

    // Mengambil data dari hasil query
    $resultEdit = $getEdit->fetch_assoc();
    // $getDeskripsi = $resultDeskripsi->fetch_assoc();

    $data = array(
      'jumlah' => $resultEdit['jumlah'], 
      'deskripsi' => $resultEdit['deskripsi'], 
    );

    $this->pengeluaran->close();

    $view = new EditView();
    $view->renderEditPengeluaran($id, $data);
  }

  // fungsi add data
  function add($data)
  {
    $this->pengeluaran->open();
    $this->pengeluaran->KeluaraddDataKeuangan($data);
    $this->pengeluaran->close();

    header("location:pengeluaran.php");
  }

  // fungsi delete data
  function delete($id)
  {
    $this->pengeluaran->open();
    $this->pengeluaran->KeluarDelDatakeuangan($id);
    $this->pengeluaran->close();

    header("location:pengeluaran.php");
  }
  // fungsi edit data
  function edit($id, $data)
  {
    $this->pengeluaran->open();
    $this->pengeluaran->KeluarEditDataKeuangan($id, $data);
    $this->pengeluaran->close();

    header("location:pengeluaran.php");
  }
}