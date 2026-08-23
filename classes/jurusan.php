<?php
require_once __DIR__ . '/../config/database.php';
class Jurusan extends Koneksi {
    public function tampilSemua() {
        $query = "SELECT * FROM jurusan";
        $result = $this->koneksi->query($query);
        return $result;
    }
}
?>
