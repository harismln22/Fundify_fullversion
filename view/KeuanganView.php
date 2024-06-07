<?php
include_once("model/Template.php");

class KeuanganView {

    public function renderAdmin($type, $data)
    {
        $no = 1;
        $dataMasuk = "";
        $isijudul = ucfirst($type); // Mengubah huruf pertama menjadi kapital
        foreach($data[$type] as $val)
        {
            // Pastikan bahwa $id di sini adalah id_pemasukan atau id_pengeluaran dari database
            if ($type == 'pemasukan') {
                list($id, $NamaAkun, $jabatan, $tanggal, $jumlah, $sumber, $deskripsi) = $val;
            } else if ($type == 'pengeluaran') {
                list($id, $NamaAkun, $jabatan, $tanggal, $jumlah, $deskripsi) = $val;
                $sumber = ''; // Atau nilai lain yang Anda inginkan
            }
            $jumlahFormatted = "Rp. " . number_format($jumlah, 2, ',', '.');
            $dataMasuk .= "<tr>";
            $dataMasuk .= "<td>" . $no . "</td>";
            $dataMasuk .= "<td>" . $NamaAkun . "</td>";
            $dataMasuk .= "<td>" . $jabatan . "</td>";
            $dataMasuk .= "<td>" . $tanggal . "</td>"; 
            $dataMasuk .= "<td>" . $jumlahFormatted . "</td>"; 
            if ($type == 'pemasukan') {
                $dataMasuk .= "<td>" . $sumber . "</td>"; 
            }
            $dataMasuk .= "<td>" . $deskripsi . "</td>"; 
            $dataMasuk .= "<td>";
            $dataMasuk .= "<a href='keuangan.php?type=".$type."&id_edit=" . $id .  "' class='btn btn-warning'>Edit</a> ";
            $dataMasuk .= "<a href='keuangan.php?type=".$type."&id_hapus=" . $id . "' class='btn btn-danger'>Hapus</a>";
            $dataMasuk .= "</td>";
            $dataMasuk .= "</tr>";
            $no++;
        }
        $tombolTambah = "<a class='btn btn-primary' name='addBtn' href='keuanganTambah.php?type=".$type."'role='button'>Tambah</a>";

        $views = new Template("layout/$type.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("ISI_MASUK", $dataMasuk);
        $views->replace("ISI_JUDUL", $isijudul);
        if($type == "pemasukan")
        {
            $views->replace("TOMBOL_TAMBAHMASUK", $tombolTambah);
        }
        if($type == "pengeluaran")
        {
            $views->replace("TOMBOL_TAMBAHKELUAR", $tombolTambah);
        }
        
        $views->write();
    }


    public function renderUser($type, $data)
    {
        $no = 1;
        $dataMasuk = "";
        $isijudul = ucfirst($type); // Mengubah huruf pertama menjadi kapital
        foreach($data[$type] as $val)
        {
            if ($type == 'pemasukan') 
            {
                list($id, $NamaAkun, $jabatan, $tanggal, $jumlah, $sumber, $deskripsi) = $val;
            } else if ($type == 'pengeluaran') 
            {
                list($id, $NamaAkun, $jabatan, $tanggal, $jumlah, $deskripsi) = $val;
                $sumber = ''; // Atau nilai lain yang Anda inginkan
            }
            $jumlahFormatted = "Rp. " . number_format($jumlah, 2, ',', '.');
            $dataMasuk .= "<tr>";
            $dataMasuk .= "<td>" . $no . "</td>";
            $dataMasuk .= "<td>" . $NamaAkun . "</td>";
            $dataMasuk .= "<td>" . $jabatan . "</td>";
            $dataMasuk .= "<td>" . $tanggal . "</td>"; 
            $dataMasuk .= "<td>" . $jumlahFormatted . "</td>"; 
            if ($type == 'pemasukan') {
                $dataMasuk .= "<td>" . $sumber . "</td>"; 
            }
            $dataMasuk .= "<td>" . $deskripsi . "</td>"; 
            $dataMasuk .= "<td> View Only </td>";
            $dataMasuk .= "</tr>";
            $no++;
        }
        $tombolTambah = "";

        $views = new Template("layout/$type.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("ISI_MASUK", $dataMasuk);
        $views->replace("ISI_JUDUL", $isijudul);
        if($type == "pemasukan")
        {
            $views->replace("TOMBOL_TAMBAHMASUK", $tombolTambah);
        }
        if($type == "pengeluaran")
        {
            $views->replace("TOMBOL_TAMBAHKELUAR", $tombolTambah);
        }
        $views->write();
    }
}
