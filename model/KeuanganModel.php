<?php

class KeuanganModel extends DB 
{
    function getDataMasuk() 
    {
        $query = "SELECT pemasukan.id_pemasukan, akun.fullname, akun.jabatan , pemasukan.tanggal, pemasukan.jumlah, pemasukan.sumber, pemasukan.deskripsi
                    FROM akun 
                    JOIN pemasukan ON akun.id_akun = pemasukan.id_akun";
        return $this->execute($query);
    }

    function getDataKeluar() 
    {
        $query = "SELECT pengeluaran.id_pengeluaran, akun.fullname, akun.jabatan, pengeluaran.tanggal, pengeluaran.jumlah, pengeluaran.deskripsi
                    FROM akun 
                    JOIN pengeluaran ON akun.id_akun = pengeluaran.id_akun";
        return $this->execute($query);
    }

    function getForEditPemasukan($id)
    {
        $query = "SELECT sumber, jumlah, deskripsi FROM pemasukan WHERE id_pemasukan ='$id'";

        return $this->execute($query); 
    }

    function getForEditPengeluaran($id)
    {
        $query = "SELECT jumlah, deskripsi FROM pengeluaran WHERE id_pengeluaran ='$id'";

        return $this->execute($query); 
    }

    function MasukaddDataKeuangan($data)
    {
        // Mendapatkan id_akun dari sesi pengguna yang login
        $id_akun = $_SESSION['id_akun'];

        // Menambahkan data ke tabel pemasukan
        $jumlah = $data['jumlah'];
        $sumber = $data['sumber'];
        $deskripsi = $data['deskripsi'];
        $queryPemasukan = "INSERT INTO pemasukan (id_akun, tanggal, jumlah, sumber, deskripsi) VALUES ('$id_akun', CURRENT_TIMESTAMP(), '$jumlah', '$sumber', '$deskripsi')";
        return $this->execute($queryPemasukan);
    }
    function KeluaraddDataKeuangan($data)
    {
        $id_akun = $_SESSION['id_akun'];

        // Menambahkan data ke tabel pengeluaran
        $jumlah = $data['jumlah'];
        $deskripsi = $data['deskripsi'];
        $queryPengeluaran = "INSERT INTO pengeluaran (id_akun, tanggal, jumlah, deskripsi) VALUES ('$id_akun', CURRENT_TIMESTAMP(), '$jumlah', '$deskripsi')";
        return $this->execute($queryPengeluaran);
    }

    function MasukDelDatakeuangan($id_pemasukan)
    {
        $query = "DELETE FROM pemasukan WHERE id_pemasukan = '$id_pemasukan'";

        return $this->execute($query);
    }

    function KeluarDelDatakeuangan($id_pengeluaran)
    {
        $query = "DELETE FROM pengeluaran WHERE id_pengeluaran = '$id_pengeluaran'";

        return $this->execute($query);
    }
    
    // Edit data pemasukan
    function MasukEditDataKeuangan($id_pemasukan, $data)
    {
        $sumber = $data['sumber'];
        $jumlah = $data['jumlah'];
        $deskripsi = $data['deskripsi'];

        $query = "UPDATE pemasukan SET jumlah = ?, tanggal = CURRENT_TIMESTAMP(), sumber = ?, deskripsi = ? WHERE id_pemasukan = ?";
        $stmt = $this->db_link->prepare($query);
        $stmt->bind_param("issi", $jumlah, $sumber, $deskripsi, $id_pemasukan);
        $stmt->execute();
        return $stmt->affected_rows == 1;
    }

    // Edit data pengeluaran
    function KeluarEditDataKeuangan($id_pengeluaran, $data)
    {
        $jumlah = $data['jumlah'];
        $deskripsi = $data['deskripsi'];

        $queryPengeluaran = "UPDATE pengeluaran SET jumlah = ?, tanggal = CURRENT_TIMESTAMP(), deskripsi = ? WHERE id_pengeluaran = ?";
        $stmt = $this->db_link->prepare($queryPengeluaran);
        $stmt->bind_param("isi", $jumlah, $deskripsi , $id_pengeluaran);
        $stmt->execute();
        return $stmt->affected_rows == 1;
    }


    function getTotalPemasukan() {
        // Membuka koneksi ke database
        $this->open();
    
        // Query untuk menghitung total pemasukan
        $query = "SELECT SUM(jumlah) AS total_pemasukan FROM pemasukan";
        
        // Menjalankan query
        $result = $this->execute($query);
        
        // Mengambil hasil query
        $row = mysqli_fetch_assoc($result);
        
        // Menutup koneksi database
        $this->close();
        
        // Mengembalikan total pemasukan
        return $row['total_pemasukan'];
    }

    function getTotalPengeluaran() {
        // Membuka koneksi ke database
        $this->open();
    
        // Query untuk menghitung total pemasukan
        $query = "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran";
        
        // Menjalankan query
        $result = $this->execute($query);
        
        // Mengambil hasil query
        $row = mysqli_fetch_assoc($result);
        
        // Menutup koneksi database
        $this->close();
        
        // Mengembalikan total pemasukan
        return $row['total_pengeluaran'];
    }

    function getIncomeDataPerMonth() 
    {
        $incomeDataPerMonth = array();
        for ($month = 1; $month <= 12; $month++) {
            $query = "SELECT SUM(jumlah) AS total_income 
                      FROM pemasukan 
                      WHERE MONTH(tanggal) = $month";
            $result = $this->execute($query);
            $row = mysqli_fetch_assoc($result);
            $incomeDataPerMonth[$month - 1] = $row['total_income'];
        }
        return $incomeDataPerMonth;
    }

    function getExpenseDataPerMonth() 
    {
        $expenseDataPerMonth = array();
        for ($month = 1; $month <= 12; $month++) {
            $query = "SELECT SUM(jumlah) AS total_expense 
                      FROM pengeluaran 
                      WHERE MONTH(tanggal) = $month";
            $result = $this->execute($query);
            $row = mysqli_fetch_assoc($result);
            $expenseDataPerMonth[$month - 1] = $row['total_expense'];
        }
        return $expenseDataPerMonth;
    }
    
}