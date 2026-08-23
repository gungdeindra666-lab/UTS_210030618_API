<?php
require_once __DIR__ . '/../config/database.php';
class Mahasiswa extends Koneksi {
    public function tampilSemua() {
        $query = "SELECT m.*, j.nama_jurusan FROM mahasiswa m 
                  LEFT JOIN jurusan j ON m.kode_jurusan = j.kode_jurusan";
        return $this->koneksi->query($query);
    }
    public function tambah($nim, $nama, $kode_jurusan, $gender, $tempat, $tanggal_lahir, $alamat, $email, $no_hp) {
        $query = "INSERT INTO mahasiswa (NIM, nama, kode_jurusan, gender, tempat, tanggal_lahir, alamat, email, no_hp) 
                  VALUES ('$nim', '$nama', '$kode_jurusan', '$gender', '$tempat', '$tanggal_lahir', '$alamat', '$email', '$no_hp')";
        return $this->koneksi->query($query);
    }
    public function ambilByNim($nim) {
        $query = "SELECT * FROM mahasiswa WHERE NIM = '$nim'";
        $result = $this->koneksi->query($query);
        return $result->fetch_assoc();
    }
    public function ubah($nim, $nama, $kode_jurusan, $gender, $tempat, $tanggal_lahir, $alamat, $email, $no_hp) {
        $query = "UPDATE mahasiswa SET 
                  nama = '$nama', 
                  kode_jurusan = '$kode_jurusan', 
                  gender = '$gender', 
                  tempat = '$tempat', 
                  tanggal_lahir = '$tanggal_lahir', 
                  alamat = '$alamat', 
                  email = '$email', 
                  no_hp = '$no_hp' 
                  WHERE NIM = '$nim'";
        return $this->koneksi->query($query);
    }
    public function hapus($nim) {
        $query = "DELETE FROM mahasiswa WHERE NIM = '$nim'";
        return $this->koneksi->query($query);
    }
}
?>
