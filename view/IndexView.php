<?php
include_once __DIR__ . '/../vendor/autoload.php';
include_once ("model/Template.php");


class IndexView
{

    function downloadPdf($dataMasuk, $dataKeluar)
    {
        // Style untuk PDF
        $style = "<style>
            body {
                font-family: Arial, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #dddddd;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
                text-align: left;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                text-align: center;
                font-size: 10px;
                color: #888888;
            }
        </style>";
    
        // Header untuk data pemasukan
        $theadMasuk = "<h1 class='header'>Laporan Keuangan PT Widata Intelligent Solution ". "</h1>
            <table>
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
    
        // Header untuk data pengeluaran
        $theadKeluar = "<h2>Pengeluaran</h2>
            <table>
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
    
        // Inisialisasi nomor urut
        $noMasuk = 1;
        $noKeluar = 1;
    
        // Inisialisasi string untuk menyimpan HTML tabel
        $pdfMasuk = "";
        $pdfKeluar = "";
    
        // Looping untuk data pemasukan
        foreach ($dataMasuk['pemasukan'] as $val) {
            // Memeriksa apakah data berada di bulan dan tahun yang sama
           
                $jumlahFormatted = "Rp. " . number_format($val['jumlah'], 2, ',', '.');
    
                // Membuat baris tabel untuk pemasukan
                $pdfMasuk .= "<tr>";
                $pdfMasuk .= "<td>" . $noMasuk . "</td>";
                $pdfMasuk .= "<td>" . $val['fullname'] . "</td>";
                $pdfMasuk .= "<td>" . $val['jabatan'] . "</td>";
                $pdfMasuk .= "<td>" . $val['tanggal'] . "</td>";
                $pdfMasuk .= "<td>" . $jumlahFormatted . "</td>";
                $pdfMasuk .= "<td>" . $val['sumber'] . "</td>";
                $pdfMasuk .= "<td>" . $val['deskripsi'] . "</td>";
                $pdfMasuk .= "</tr>";
    
                // Increment nomor urut
                $noMasuk++;
            }
        
    
        // Looping untuk data pengeluaran
        foreach ($dataKeluar['pengeluaran'] as $val) {
            // Memeriksa apakah data berada di bulan dan tahun yang sama
                // Format jumlah uang
                $jumlahFormatted = "Rp. " . number_format($val['jumlah'], 2, ',', '.');
    
                // Membuat baris tabel untuk pengeluaran
                $pdfKeluar .= "<tr>";
                $pdfKeluar .= "<td>" . $noKeluar . "</td>";
                $pdfKeluar .= "<td>" . $val['fullname'] . "</td>";
                $pdfKeluar .= "<td>" . $val['jabatan'] . "</td>";
                $pdfKeluar .= "<td>" . $val['tanggal'] . "</td>";
                $pdfKeluar .= "<td>" . $jumlahFormatted . "</td>";
                $pdfKeluar .= "<td>" . $val['deskripsi'] . "</td>";
                $pdfKeluar .= "</tr>";
    
                // Increment nomor urut
                $noKeluar++;
            }
        
    
        // Hitung total pemasukan
        $totalPemasukan = array_sum(array_column($dataMasuk['pemasukan'], 'jumlah'));
    
        // Hitung total pengeluaran
        $totalPengeluaran = array_sum(array_column($dataKeluar['pengeluaran'], 'jumlah'));
    
        // Hitung selisih
        $selisih = $totalPemasukan - $totalPengeluaran;
    
        // Buat konten selisih
        $selisihContent = "<h2>Selisih: Rp. " . number_format($selisih, 2, ',', '.') . "</h2>";
        $print_total_pemasukan = "<h2>Total Pemasukan: Rp. " . number_format($totalPemasukan, 2, ',', '.') . "</h2>";
        $print_total_pengeluaran = "<h2>Total Pengeluaran: Rp. " . number_format($totalPengeluaran, 2, ',', '.') . "</h2>";
    
        // Membuat instance mPDF
        $mpdf = new \Mpdf\Mpdf();
    
        // Menambahkan HTML ke PDF
        $mpdf->WriteHTML($style);
        $mpdf->WriteHTML("<div class='header'><h1>PT Widata Intelligent Solution" ."</h1></div>");
        $mpdf->WriteHTML($theadMasuk . $pdfMasuk . '</table>');
        $mpdf->WriteHTML($print_total_pemasukan);
        $mpdf->WriteHTML($theadKeluar . $pdfKeluar . '</table>');
        $mpdf->WriteHTML($print_total_pengeluaran);
        $mpdf->WriteHTML($selisihContent); // Tambahkan konten selisih ke PDF
        $mpdf->WriteHTML("<div class='footer'><p>Laporan dibuat pada tanggal. date('Y-m-d')</p></div>");

    // Menentukan nama file dan menyimpannya
    $filename = 'Laporan Keuangan PT Widata Intelligent Solution' . '.pdf';
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
    
    function downloadPdfPerbulan($dataMasuk, $dataKeluar, $bulan, $tahun)
    {
        // Style untuk PDF
        $style = "<style>
            body {
                font-family: Arial, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #dddddd;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
                text-align: left;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                text-align: center;
                font-size: 10px;
                color: #888888;
            }
        </style>";
    
        // Header untuk data pemasukan
        $theadMasuk = "<h1 class='header'>Laporan Keuangan Bulan " . date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) . "</h1>
            <table>
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
    
        // Header untuk data pengeluaran
        $theadKeluar = "<h2>Pengeluaran</h2>
            <table>
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
    
        // Inisialisasi nomor urut
        $noMasuk = 1;
        $noKeluar = 1;
    
        // Inisialisasi string untuk menyimpan HTML tabel
        $pdfMasuk = "";
        $pdfKeluar = "";
    
        // Looping untuk data pemasukan
        foreach ($dataMasuk['pemasukan'] as $val) {
            // Memeriksa apakah data berada di bulan dan tahun yang sama
            if (date('m', strtotime($val['tanggal'])) == $bulan && date('Y', strtotime($val['tanggal'])) == $tahun) {
                // Format jumlah uang
                $jumlahFormatted = "Rp. " . number_format($val['jumlah'], 2, ',', '.');
    
                // Membuat baris tabel untuk pemasukan
                $pdfMasuk .= "<tr>";
                $pdfMasuk .= "<td>" . $noMasuk . "</td>";
                $pdfMasuk .= "<td>" . $val['fullname'] . "</td>";
                $pdfMasuk .= "<td>" . $val['jabatan'] . "</td>";
                $pdfMasuk .= "<td>" . $val['tanggal'] . "</td>";
                $pdfMasuk .= "<td>" . $jumlahFormatted . "</td>";
                $pdfMasuk .= "<td>" . $val['sumber'] . "</td>";
                $pdfMasuk .= "<td>" . $val['deskripsi'] . "</td>";
                $pdfMasuk .= "</tr>";
    
                // Increment nomor urut
                $noMasuk++;
            }
        }
    
        // Looping untuk data pengeluaran
        foreach ($dataKeluar['pengeluaran'] as $val) {
            // Memeriksa apakah data berada di bulan dan tahun yang sama
            if (date('m', strtotime($val['tanggal'])) == $bulan && date('Y', strtotime($val['tanggal'])) == $tahun) {
                // Format jumlah uang
                $jumlahFormatted = "Rp. " . number_format($val['jumlah'], 2, ',', '.');
    
                // Membuat baris tabel untuk pengeluaran
                $pdfKeluar .= "<tr>";
                $pdfKeluar .= "<td>" . $noKeluar . "</td>";
                $pdfKeluar .= "<td>" . $val['fullname'] . "</td>";
                $pdfKeluar .= "<td>" . $val['jabatan'] . "</td>";
                $pdfKeluar .= "<td>" . $val['tanggal'] . "</td>";
                $pdfKeluar .= "<td>" . $jumlahFormatted . "</td>";
                $pdfKeluar .= "<td>" . $val['deskripsi'] . "</td>";
                $pdfKeluar .= "</tr>";
    
                // Increment nomor urut
                $noKeluar++;
            }
        }
    
        // Hitung total pemasukan
        $totalPemasukan = array_sum(array_column($dataMasuk['pemasukan'], 'jumlah'));
    
        // Hitung total pengeluaran
        $totalPengeluaran = array_sum(array_column($dataKeluar['pengeluaran'], 'jumlah'));
    
        // Hitung selisih
        $selisih = $totalPemasukan - $totalPengeluaran;
    
        // Buat konten selisih
        $selisihContent = "<h2>Selisih: Rp. " . number_format($selisih, 2, ',', '.') . "</h2>";
        $print_total_pemasukan = "<h2>Total Pemasukan: Rp. " . number_format($totalPemasukan, 2, ',', '.') . "</h2>";
        $print_total_pengeluaran = "<h2>Total Pengeluaran: Rp. " . number_format($totalPengeluaran, 2, ',', '.') . "</h2>";
    
        // Membuat instance mPDF
        $mpdf = new \Mpdf\Mpdf();
    
        // Menambahkan HTML ke PDF
        $mpdf->WriteHTML($style);
        $mpdf->WriteHTML("<div class='header'><h1>PT Widata Intelligent Solution" ."</h1></div>");
        $mpdf->WriteHTML($theadMasuk . $pdfMasuk . '</table>');
        $mpdf->WriteHTML($print_total_pemasukan);
        $mpdf->WriteHTML($theadKeluar . $pdfKeluar . '</table>');
        $mpdf->WriteHTML($print_total_pengeluaran);
        $mpdf->WriteHTML($selisihContent); // Tambahkan konten selisih ke PDF
        $mpdf->WriteHTML("<div class='footer'><p>Laporan dibuat pada tanggal. date('Y-m-d')</p></div>");

    // Menentukan nama file dan menyimpannya
    $filename = 'Laporan_Keuangan_' . date('F_Y', mktime(0, 0, 0, $bulan, 1, $tahun)) . '.pdf';
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
        foreach ($AkunData['akun'] as $val) {
            list($id, $nama, $username, $jabatan, $email, $tanggal, $role) = $val;
            if ($role == 0) {
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
                $dataAkun .= "<a href= 'index.php?id_edit=" . $id . "' class='btn btn-warning'>Edit</a> ";
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
        foreach ($AkunData['akun'] as $val) {
            list($id, $nama, $username, $jabatan, $email, $tanggal, $role) = $val;
            if ($role == 0) {
                $roleName = "User";
                $dataAkun .= "<tr>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $no . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $nama . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $username . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $jabatan . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $email . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $tanggal . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . $roleName . "</td>";
                $dataAkun .= "<td style='padding: 10px; border: 1px solid #ddd;'>" . "View Only" . "</td>";
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
