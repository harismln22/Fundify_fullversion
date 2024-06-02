<?php
include_once("model/Template.php");
class PemasukanView {

    public function renderAdmin($data)
    {
        $no = 1;
        $dataMasuk = "";
        $isijudul = "Pemasukan";
        foreach($data['pemasukan'] as $val)
        {
            // Pastikan bahwa $id di sini adalah id_pemasukan dari database
            list($id_pemasukan, $NamaAkun, $jabatan, $tanggal, $jumlah, $sumber) = $val;
            $jumlahFormatted = "Rp. " . number_format((float)$jumlah, 2, ',', '.');
            $dataMasuk .= "<tr>";
            $dataMasuk .= "<td>" . $no . "</td>";
            $dataMasuk .= "<td>" . $NamaAkun . "</td>";
            $dataMasuk .= "<td>" . $jabatan . "</td>";
            $dataMasuk .= "<td>" . $tanggal . "</td>"; 
            $dataMasuk .= "<td>" . $jumlahFormatted . "</td>"; 
            $dataMasuk .= "<td>" . $sumber . "</td>"; 
            $dataMasuk .= "<td>";
            $dataMasuk .= "<a href='pemasukan.php?id_edit=" . $id_pemasukan .  "' class='btn btn-warning'>Edit</a> ";
            $dataMasuk .= "<a href='pemasukan.php?id_hapus=" . $id_pemasukan . "' class='btn btn-danger' name='hapus'>Hapus</a>";
            $dataMasuk .= "</td>";
            $dataMasuk .= "</tr>";
            $no++;
        }
        $tombolTambah = "<a class='btn btn-primary' name='addBtn' href='pemasukanTambah.php' role='button'>Tambah</a>";

        $views = new Template("layout/pemasukan.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("ISI_MASUK", $dataMasuk);
        $views->replace("ISI_JUDUL", $isijudul);
        $views->replace("TOMBOL_TAMBAHMASUK", $tombolTambah);
        $views->write();
    }

    public function renderUser($data)
    {
        $no = 1;
        $dataMasuk = "";
        $isijudul = "Pemasukan";
        foreach($data['pemasukan'] as $val)
        {
            list($id_pemasukan, $NamaAkun, $jabatan, $tanggal, $jumlah, $sumber) = $val;
            $jumlahFormatted = "Rp. " . number_format((float)$jumlah, 2, ',', '.');
            $dataMasuk .= "<tr>";
            $dataMasuk .= "<td>" . $no . "</td>";
            $dataMasuk .= "<td>" . $NamaAkun . "</td>"; 
            $dataMasuk .= "<td>" . $jabatan . "</td>";
            $dataMasuk .= "<td>" . $tanggal . "</td>"; 
            $dataMasuk .= "<td>" . $jumlahFormatted . "</td>"; 
            $dataMasuk .= "<td>" . $sumber . "</td>"; 
            $dataMasuk .= "<td> View Only </td>";
            $dataMasuk .= "</tr>";
            $no++;
        }
        $tombolTambah = "";

        $views = new Template("layout/pemasukan.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("ISI_MASUK", $dataMasuk);
        $views->replace("ISI_JUDUL", $isijudul);
        $views->replace("TOMBOL_TAMBAHMASUK", $tombolTambah);
        $views->write();
    }
}

