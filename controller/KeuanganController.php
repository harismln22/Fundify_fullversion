<?php

include_once ("koneksi.php");
include_once ("model/KeuanganModel.php");
include_once ("view/KeuanganView.php");
include_once ("view/TambahView.php");
include_once ("view/EditView.php");

class KeuanganController
{
  private $keuangan;
  private $role;

  function __construct()
  {
    $this->keuangan = new KeuanganModel(Connecttt::$db_host, Connecttt::$db_user, Connecttt::$db_pass, Connecttt::$db_name);
    $this->role = $_SESSION['role'];
  }

  public function index($type)
  {
    $this->keuangan->open();
    if ($type == 'pemasukan') 
    {
      $this->keuangan->getDataMasuk();
    } 
    else if ($type == 'pengeluaran') 
    {
      $this->keuangan->getDataKeluar();
    }

    $data = array(
      $type => array(),
    );
    while ($row = $this->keuangan->getResult()) {
    //     echo "<pre>";
    //   print_r($row);
    //   echo "</pre>";
      array_push($data[$type], $row);
    }

    $this->keuangan->close();
    $view = new KeuanganView();
    if ($this->role == 1) 
    {
      $view->renderAdmin($type, $data);
    } 
    else if ($this->role == 0) 
    {
      $view->renderUser($type, $data);
    }
  }

    public function indexTambah($type)
    {
        $view = new TambahView();
        if ($type == 'pemasukan') 
        {
            $view->renderAddPemasukan();
        } 
        else if ($type == 'pengeluaran') 
        {
            $view->renderAddPengeluaran();
        }
    }

    public function indexEdit($type, $id)
    {
        $this->keuangan->open();
        if ($type == 'pemasukan')
        {
            $getEdit = $this->keuangan->getForEditPemasukan($id);
            $resultEdit = $getEdit->fetch_assoc();
            $data = array(
                'jumlah' => $resultEdit['jumlah'], 
                'deskripsi' => $resultEdit['deskripsi'], 
                'sumber' => $resultEdit['sumber'],
            );
        } 
        else if ($type == 'pengeluaran') 
        {
            $getEdit = $this->keuangan->getForEditPengeluaran($id);
            $resultEdit = $getEdit->fetch_assoc();
            $data = array(
                'jumlah' => $resultEdit['jumlah'], 
                'deskripsi' => $resultEdit['deskripsi'], 
            );
        }
        $this->keuangan->close();

        $view = new EditView();
        if ($type == 'pemasukan') 
        {
            $view->renderEditPemasukan($id, $data);
        } 
        else if ($type == 'pengeluaran') 
        {
            $view->renderEditPengeluaran($id, $data);
        }
    }

    // fungsi add data
    function add($type, $data)
    {
        $this->keuangan->open();
        if ($type == 'pemasukan') 
        {
            $this->keuangan->MasukaddDataKeuangan($data);
        } else if ($type == 'pengeluaran') 
        {
            $this->keuangan->KeluaraddDataKeuangan($data);
        }
        $this->keuangan->close();

        header("location:keuangan.php?type=$type");
    }

    // fungsi delete data
    function delete($type, $id)
    {
        $this->keuangan->open();
        if ($type == 'pemasukan') 
        {
            $this->keuangan->MasukDelDatakeuangan($id);
        } 
        else if ($type == 'pengeluaran')
        {
            $this->keuangan->KeluarDelDatakeuangan($id);
        }
        $this->keuangan->close();

        header("location:keuangan.php?type=$type");
    }

    // fungsi edit data
    function edit($type, $id, $data)
    {
        $this->keuangan->open();
        if ($type == 'pemasukan') 
        {
            $this->keuangan->MasukEditDataKeuangan($id, $data);
        } 
        else if ($type == 'pengeluaran') 
        {
            $this->keuangan->KeluarEditDataKeuangan($id, $data);
        }
        $this->keuangan->close();

        header("location:keuangan.php?type=$type");
    }

}
