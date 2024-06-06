<?php
include_once("model/Template.php");
class PengeluaranView {

    public function renderAdmin($data)
    {
        $no = 1;
        $dataKeluar = null;
        $isijudul = "Pengeluaran";
        foreach($data['pengeluaran'] as $val)
        {
            list($id_pengeluaran, $NamaAkun, $jabatan, $tanggal, $jumlah, $deskripsi) = $val;
            $jumlahFormatted = "Rp. " . number_format((float)$jumlah, 2, ',', '.');
            $dataKeluar .= "<tr>";
            $dataKeluar .= "<td>" . $no . "</td>";
            $dataKeluar .= "<td>" . $NamaAkun . "</td>";
            $dataKeluar .= "<td>" . $jabatan . "</td>";
            $dataKeluar .= "<td>" . $tanggal . "</td>"; 
            $dataKeluar .= "<td>" . $jumlahFormatted . "</td>"; 
            $dataKeluar .= "<td>" . $deskripsi . "</td>"; 
            $dataKeluar .= "<td>";
            $dataKeluar .= "<a href='pengeluaran.php?id_edit=" . $id_pengeluaran .  "' class='btn btn-warning'>Edit</a> ";
            $dataKeluar .= "<a href='pengeluaran.php?id_hapus=" . $id_pengeluaran . "' class='btn btn-danger'>Hapus</a>";
            $dataKeluar .= "</td>";
            $dataKeluar .= "</tr>";
            $no++;
        }
        $tombolTambah = "<a class='btn btn-primary' name='addBtn' href='pengeluaranTambah.php' role='button'>Tambah</a>";
        
        $views = new Template("layout/pengeluaran.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("ISI_MASUK", $dataKeluar);
        $views->replace("ISI_JUDUL", $isijudul);
        $views->replace("TOMBOL_TAMBAHKELUAR", $tombolTambah);
        $views->write();
    }

    public function renderUser($data)
    {
        $no = 1;
        $dataKeluar = null;
        $isijudul = "Pengeluaran";
        foreach($data['pengeluaran'] as $val)
        {
            list($id_pengeluaran, $NamaAkun, $jabatan, $tanggal, $jumlah) = $val;
            $jumlahFormatted = "Rp. " . number_format((float)$jumlah, 2, ',', '.');
            $dataKeluar .= "<tr>";
            $dataKeluar .= "<td>" . $no . "</td>";
            $dataKeluar .= "<td>" . $NamaAkun . "</td>";
            $dataKeluar .= "<td>" . $jabatan . "</td>";
            $dataKeluar .= "<td>" . $tanggal . "</td>"; 
            $dataKeluar .= "<td>" . $jumlahFormatted . "</td>";  
            $dataKeluar .= "<td> View Only </td>";
            $dataKeluar .= "</tr>";
            $no++;
        }
        $tombolTambah = "";
        $views = new Template("layout/pengeluaran.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("ISI_MASUK", $dataKeluar);
        $views->replace("ISI_JUDUL", $isijudul);
        $views->replace("TOMBOL_TAMBAHKELUAR", $tombolTambah);
        $views->write();
    }
}

