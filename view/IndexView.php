<?php
include_once("model/Template.php");
class IndexView {
    
    public function renderAdmin($data, $AkunData)
    {
        $no = 1;
        $dataAkun = "";
        foreach($AkunData['akun'] as $val)
        {
            list($id, $nama, $username, $jabatan, $email, $tanggal, $role) = $val;
            if($role == 0)
            {
                $roleName = "User";
                $dataAkun .= "<tr>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $no . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $nama . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $username . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $jabatan . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $email . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $tanggal . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $roleName . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>";
                $dataAkun .= "<a href= 'index.php?id_edit=" . $id .  "' class='btn btn-warning'>Edit</a> ";
                $dataAkun .= "<a href= 'index.php?id_hapus=" . $id . "' class='btn btn-danger' name='hapus'>Hapus</a>";
                $dataAkun .= "</td>";
                $dataAkun .= "</tr>";
                $no++;
            }
        }
        $views = new Template("layout/index.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("TABEL_AKUN", $dataAkun);
        $views->replace("TOTAL_MASUK", "Rp." . number_format($data['total_pemasukan'], 2, ',', '.'));
        $views->replace("TOTAL_KELUAR", "Rp." . number_format($data['total_pengeluaran'], 2, ',', '.'));
        $views->replace("SELISIH", "Rp." . number_format($data['selisih'], 2, ',', '.'));
        $views->write();
    }
    public function renderUser($data, $AkunData)
    {
        $no = 1;
        $dataAkun = "";
        foreach($AkunData['akun'] as $val)
        {
            list($id, $nama, $username, $jabatan, $email, $tanggal, $role) = $val;
            if($role == 0)
            {
                $roleName = "User";
                $dataAkun .= "<tr>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $no . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $nama . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $username . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $jabatan . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $email . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $tanggal . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $roleName . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . "View Only". "</td>";
                $dataAkun .= "</tr>";
                $no++;
            }
        }
        $views = new Template("layout/index.html");
        $profileName = $_SESSION['username'];
        $views->replace("PROFILE", $profileName);
        $views->replace("TABEL_AKUN", $dataAkun);
        $views->replace("TOTAL_MASUK", "Rp." . number_format($data['total_pemasukan'], 2, ',', '.'));
        $views->replace("TOTAL_KELUAR", "Rp." . number_format($data['total_pengeluaran'], 2, ',', '.'));
        $views->replace("SELISIH", "Rp." . number_format($data['selisih'], 2, ',', '.'));
        $views->write();
    }

}
