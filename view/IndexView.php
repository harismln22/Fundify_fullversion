<?php
include_once __DIR__ . '/../vendor/autoload.php';
include_once("model/Template.php");


class IndexView {
    
    function downloadPdf($dataMasuk, $dataKeluar)
    {
        $style = "<style>
            table {
            border-collapse: collapse;
            }

            table, th, td {
            border: 1px solid black;
            }

            th, td {
            padding: 8px;
            text-align: left;
            }
            </style>
            ";

            $theadMasuk = $style . "<h1>Pemasukan</h1>
            <table class='table table-striped'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Jabatan</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Sumber</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>";

            $theadKeluar = $style . "<h1>Pengeluaran</h1>
            <table class='table table-striped'>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Karyawan</th>
                    <th>Jabatan</th>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>";
        
        $noMasuk = 1;
        $pdfMasuk = "";
        foreach($dataMasuk['pemasukan'] as $val)
        {
            $NamaAkun = $val['fullname'];
            $jabatan = $val['jabatan'];
            $tanggal = $val['tanggal'];
            $jumlah = $val['jumlah'];
            $sumber = $val['sumber'];
            $deskripsi = $val['deskripsi'];
            $jumlahFormatted = "Rp. " . number_format($jumlah, 2, ',', '.');
            $pdfMasuk .= "<tr>";
            $pdfMasuk .= "<td>" . $noMasuk . "</td>";
            $pdfMasuk .= "<td>" . $NamaAkun . "</td>";
            $pdfMasuk .= "<td>" . $jabatan . "</td>";
            $pdfMasuk .= "<td>" . $tanggal . "</td>"; 
            $pdfMasuk .= "<td>" . $jumlahFormatted . "</td>"; 
            $pdfMasuk .= "<td>" . $sumber . "</td>"; 
            $pdfMasuk .= "<td>" . $deskripsi . "</td>"; 
            $pdfMasuk .= "</tr>";
            $noMasuk++;
        }

        $noKeluar = 1;
        $pdfKeluar = "";
        foreach($dataKeluar['pengeluaran'] as $val)
        {
            $NamaAkun = $val['fullname'];
            $jabatan = $val['jabatan'];
            $tanggal = $val['tanggal'];
            $jumlah = $val['jumlah'];
            $deskripsi = $val['deskripsi'];
            $jumlahFormatted = "Rp. " . number_format($jumlah, 2, ',', '.');
            $pdfKeluar .= "<tr>";
            $pdfKeluar .= "<td>" . $noKeluar . "</td>";
            $pdfKeluar .= "<td>" . $NamaAkun . "</td>";
            $pdfKeluar .= "<td>" . $jabatan . "</td>";
            $pdfKeluar .= "<td>" . $tanggal . "</td>"; 
            $pdfKeluar .= "<td>" . $jumlahFormatted . "</td>"; 
            $pdfKeluar .= "<td>" . $deskripsi . "</td>"; 
            $pdfKeluar .= "</tr>";
            $noKeluar++;
        }

        // Membuat instance mPDF
        $mpdf = new \Mpdf\Mpdf();

        // Menambahkan HTML ke PDF
        $mpdf->WriteHTML($theadMasuk . $pdfMasuk . '</table>');
       // $mpdf->AddPage();
        $mpdf->WriteHTML($theadKeluar . $pdfKeluar . '</table>');

        $filename = 'Laporan Keuangan.pdf';

        // Simpan file PDF ke direktori yang diinginkan di server
        $mpdf->Output($filename, 'F');

        // Tentukan path file PDF
        $filePath = __DIR__ . '/../' . $filename;

        // Cek jika file ada dan dapat dibaca
        if (file_exists($filePath)) {
            // Kirimkan header yang tepat untuk download
            header('Content-Type: application/pdf');
            header("Content-Disposition: attachment; filename=\"$filename\"");
            header('Content-Length: ' . filesize($filePath));

            // Bersihkan semua output buffer
            while (ob_get_level()) {
                ob_end_clean();
            }

            // Baca file dan kirimkan ke browser
            readfile($filePath);

            // Hapus file PDF setelah diunduh
            unlink($filePath);

            exit;
        } else {
            echo "Error: File tidak ditemukan di" . $filePath;
        }
    }
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
