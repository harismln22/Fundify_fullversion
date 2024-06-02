<?php

class AkunModel extends DB
{
    function getAkun()
    {
        $query = "SELECT id_akun, fullname,username ,jabatan, email, tanggal, role FROM akun";
        
        return $this->execute($query);
    }

    function EditDataAkun($id, $data)
    {
        $fullname = $data['fullname'];
        $username = $data['username'];
        $email = $data['email'];
        $jabatan = $data['jabatan'];
        // $password = password_hash($data['password'], PASSWORD_DEFAULT); 

        $query = "UPDATE akun SET fullname = ?,username = ?, email = ?, jabatan = ? WHERE id_akun = ?";
        $stmt = $this->db_link->prepare($query);
        $stmt->bind_param("ssssi", $fullname, $username , $email, $jabatan, $id);
        $stmt->execute();
        if ($stmt->affected_rows == 1) {
            return true;
        }
        return false;
    }

    function DelDataAkun($id)
    {
        $query = "DELETE FROM akun WHERE id_akun = '$id'";
        
        return $this->execute($query);
    }

    function registration($data)
    {
        $fullname = $data['fullname'];
        $email = $data['email'];
        $username = $data['username'];
        $jabatan = $data['jabatan'];
        $password = password_hash($data['password'], PASSWORD_DEFAULT); // Menggunakan password_hash untuk keamanan

        $query = "INSERT INTO akun (fullname, email, username, jabatan, password, tanggal) VALUES (?, ?, ?, ?, ?, CURRENT_TIMESTAMP())";

        if ($stmt = $this->db_link->prepare($query)) {
            $stmt->bind_param("sssss", $fullname, $email, $username, $jabatan, $password);
            $stmt->execute();
            if ($stmt->affected_rows == 1) {
                return true;
            }
        }
        return false;
    }

    function verifyUser($data)
    {
        // Mulai sesi jika belum dimulai
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $username = $data['username'];
        $password = $data['password'];

        // Gunakan prepared statement untuk mencegah SQL injection
        $stmt = $this->db_link->prepare("SELECT * FROM akun WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        // Periksa apakah ada satu baris hasil
        if ($result->num_rows == 1)
        {
            $hasil = $result->fetch_assoc();

            // Verifikasi password (password harus di hash terlebih dahulu)
            if (password_verify($password, $hasil['password']))
            {
                // Setel variabel sesi
                $_SESSION['username'] = $hasil['username'];
                $_SESSION['id_akun'] = $hasil['id_akun'];
                $_SESSION['role'] = $hasil['role'];
                $_SESSION['is_logged_in'] = true;
                return $hasil;
            }
        }
        return false;
    }

}