<?php

include_once ("koneksi.php");
include_once ("model/KeuanganModel.php");
include_once ("view/PemasukanView.php");
include_once ("view/TambahView.php");
include_once ("view/EditView.php");

class PemasukanController
{
  private $pemasukan;

  function __construct()
  {
    $this->pemasukan = new KeuanganModel(Connecttt::$db_host, Connecttt::$db_user, Connecttt::$db_pass, Connecttt::$db_name);
  }

  // table pemasukan 
  public function indexAdmin()
  {
    $this->pemasukan->open();
    $this->pemasukan->getDataMasuk();

    $data = array(
      'pemasukan' => array(),
    );
    while ($row = $this->pemasukan->getResult()) {
      // echo "<pre>";
      // print_r($row);
      // echo "</pre>";
      array_push($data['pemasukan'], $row);
    }

    $this->pemasukan->close();

    $view = new PemasukanView();
    $view->renderAdmin($data);
  }
  public function indexUser()
  {
    $this->pemasukan->open();
    $this->pemasukan->getDataMasuk();

    $data = array(
      'pemasukan' => array(),
    );
    while ($row = $this->pemasukan->getResult()) {
      // echo "<pre>";
      // print_r($row);
      // echo "</pre>";
      array_push($data['pemasukan'], $row);
    }

    $this->pemasukan->close();

    $view = new PemasukanView();
    $view->renderUser($data);
  }

  //form tambah data
  public function indexTambah()
  {
    $view = new TambahView();
    $view->renderAddPemasukan();
  }

  // form edit data
  public function indexEdit($id)
{
    $this->pemasukan->open();
    $getEdit = $this->pemasukan->getForEditPemasukan($id);
    //$resultDeskripsi = $this->pemasukan->getDeskripsi($id);

    // Mengambil data dari hasil query
    $resultEdit = $getEdit->fetch_assoc();
    // $getDeskripsi = $resultDeskripsi->fetch_assoc();

    $data = array(
      'jumlah' => $resultEdit['jumlah'], 
      'deskripsi' => $resultEdit['deskripsi'], 
      'sumber' => $resultEdit['sumber'],
    );

    $this->pemasukan->close();

    $view = new EditView();
    $view->renderEditPemasukan($id, $data);
}


  // fungsi add data
  function add($data)
  {
    $this->pemasukan->open();
    $this->pemasukan->MasukaddDataKeuangan($data);
    $this->pemasukan->close();

    header("location:pemasukan.php");
  }

  // fungsi delete data
  function delete($id)
  {
    $this->pemasukan->open();
    $this->pemasukan->MasukDelDatakeuangan($id);
    $this->pemasukan->close();

    header("location:pemasukan.php");
  }
  // fungsi edit data
  function edit($id, $data)
  {
    $this->pemasukan->open();
    $this->pemasukan->MasukEditDataKeuangan($id, $data);
    $this->pemasukan->close();

    header("location:pemasukan.php");
  }
}