<?php

include_once("koneksi.php");
include_once("model/KeuanganModel.php");
include_once("model/AkunModel.php");
include_once("view/IndexView.php");
include_once("view/EditAkunView.php");


class IndexController {
    
    private $index;
    private $AkunTable;

    function __construct(){
        $this->index = new KeuanganModel(Connecttt::$db_host, Connecttt::$db_user, Connecttt::$db_pass, Connecttt::$db_name);
        $this->AkunTable = new AkunModel(Connecttt::$db_host, Connecttt::$db_user, Connecttt::$db_pass, Connecttt::$db_name);
    }

    // halaman admin
    public function indexAdmin() {
      $this->index->open();
      $this->AkunTable->open();
      $this->AkunTable->getAkun();
      $totalPemasukan = $this->index->getTotalPemasukan(); 
      $totalPengeluaran = $this->index->getTotalPengeluaran(); 
      $selisih = $totalPemasukan - $totalPengeluaran;
  
      $data = array(
          'total_pemasukan' => $totalPemasukan,
          'total_pengeluaran' => $totalPengeluaran,
          'selisih' => $selisih,
      );

      $dataAkun = array(
        'akun' => array(),
      );

      while ($row = $this->AkunTable->getResult()) {
        // echo "<pre>";
        // print_r($row);
        // echo "</pre>";
        array_push($dataAkun['akun'], $row);
      }
  
      $view = new IndexView();
      $view->renderAdmin($data, $dataAkun);
    }

    // halaman user
    public function indexUser()
    {
        $this->index->open();
        $this->AkunTable->open();
        $this->AkunTable->getAkun();
        $totalPemasukan = $this->index->getTotalPemasukan(); 
        $totalPengeluaran = $this->index->getTotalPengeluaran(); 
        $selisih = $totalPemasukan - $totalPengeluaran;
    
        $data = array(
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'selisih' => $selisih,
        );
  
        $dataAkun = array(
          'akun' => array(),
        );
  
        while ($row = $this->AkunTable->getResult()) {
          // echo "<pre>";
          // print_r($row);
          // echo "</pre>";
          array_push($dataAkun['akun'], $row);
        }
    
        $view = new IndexView();
        $view->renderUser($data, $dataAkun);
      }

    // form edit akun
    function indexEditAkun()
    {
        $view = new EditAkunView();
        $view->renderEditAkun();
    }
    
    // edit akun user
    function edit($id, $data)
    {
        $this->AkunTable->open();
        $this->AkunTable->EditDataAkun($id, $data);
        $this->AkunTable->close();

        header("location:index.php");
    }

    // delete akun user
    function delete($id)
    {
        $this->AkunTable->open();
        $this->AkunTable->DelDataAkun($id);
        $this->AkunTable->close();

        header("location:index.php");
    }
}