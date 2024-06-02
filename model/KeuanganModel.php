<?php

class KeuanganModel extends DB 
{
    function getDataMasuk() 
    {
        $query = "SELECT pemasukan.id_pemasukan, akun.fullname, akun.jabatan , pemasukan.tanggal, pemasukan.jumlah, pemasukan.sumber 
                    FROM akun 
                    JOIN pemasukan ON akun.id_akun = pemasukan.id_akun";
        return $this->execute($query);
    }

    function getDataKeluar() 
    {
        $query = "SELECT pengeluaran.id_pengeluaran, akun.fullname, akun.jabatan, pengeluaran.tanggal, pengeluaran.jumlah 
                    FROM akun 
                    JOIN pengeluaran ON akun.id_akun = pengeluaran.id_akun";
        return $this->execute($query);
    }


    function MasukaddDataKeuangan($data)
    {
        // Mendapatkan id_akun dari sesi pengguna yang login
        $id_akun = $_SESSION['id_akun'];

        // Menambahkan data ke tabel pemasukan
        $jumlah = $data['jumlah'];
        $sumber = $data['sumber'];
        $queryPemasukan = "INSERT INTO pemasukan (id_akun, tanggal, jumlah, sumber) VALUES ('$id_akun', CURRENT_TIMESTAMP(), '$jumlah', '$sumber')";
        return $this->execute($queryPemasukan);
    }
    function KeluaraddDataKeuangan($data)
    {
        $id_akun = $_SESSION['id_akun'];

        // Menambahkan data ke tabel pengeluaran
        $jumlah = $data['jumlah'];
        $queryPengeluaran = "INSERT INTO pengeluaran (id_akun, tanggal, jumlah) VALUES ('$id_akun', CURRENT_TIMESTAMP(), '$jumlah')";
        $this->execute($queryPengeluaran);

        $queryJoin = "SELECT akun.id_akun, akun.fullname, akun.jabatan, pengeluaran.tanggal, pengeluaran.jumlah 
                      FROM akun 
                      JOIN pengeluaran ON akun.id_akun = pengeluaran.id_akun
                      WHERE akun.id_akun = '$id_akun'";
        return $this->execute($queryJoin);
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

        $query = "UPDATE pemasukan SET jumlah = ?, tanggal = CURRENT_TIMESTAMP(), sumber = ? WHERE id_pemasukan = ?";
        $stmt = $this->db_link->prepare($query);
        $stmt->bind_param("isi", $jumlah, $sumber, $id_pemasukan);
        $stmt->execute();
        return $stmt->affected_rows == 1;
    }

    // Edit data pengeluaran
    function KeluarEditDataKeuangan($id_pengeluaran, $data)
    {
        $jumlah = $data['jumlah'];

        $queryPengeluaran = "UPDATE pengeluaran SET jumlah = ?, tanggal = CURRENT_TIMESTAMP() WHERE id_pengeluaran = ?";
        $stmt = $this->db_link->prepare($queryPengeluaran);
        $stmt->bind_param("ii", $jumlah, $id_pengeluaran);
        $stmt->execute();
        
        // Mengambil data yang telah diupdate untuk verifikasi
        $queryJoin = "SELECT pengeluaran.id_pengeluaran, akun.fullname, akun.jabatan, pengeluaran.tanggal, pengeluaran.jumlah 
                    FROM akun 
                    JOIN pengeluaran ON akun.id_akun = pengeluaran.id_akun
                    WHERE pengeluaran.id_pengeluaran = ?";
        $stmt = $this->db_link->prepare($queryJoin);
        $stmt->bind_param("i", $id_pengeluaran);
        $stmt->execute();
        return $stmt->get_result();
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