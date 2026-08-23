<?php
// 1. Tentukan URL endpoint REST API Jurusan secara dinamis
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$current_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$url_api_jurusan = $protocol . $host . $current_dir . "api/jurusan_api.php";


require_once 'client.php';
$client = new RestClient();

$result_jurusan = $client->get('jurusan_api.php');
$dataJurusan = isset($result_jurusan['status']) && $result_jurusan['status'] == 'success' ? $result_jurusan['data'] : [];

// Khusus untuk form_edit.php, tambahkan penarikan data mahasiswa satu baris saja:
$nim = $_GET['nim'] ?? '';
$data = $client->get('data_api.php?nim=' . urlencode($nim));



// 3. Masukkan data hasil decode ke penampung array
$dataJurusan = [];
if (isset($result['status']) && $result['status'] == 'success') {
    $dataJurusan = $result['data'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Mahasiswa (REST Client)</title>
</head>
<body>
    <h2>Formulir Input Mahasiswa (REST API Client)</h2>
    <!-- Arahkan aksi form ke file handler frontend baru untuk memproses REST POST -->
    <form action="proses_client.php?aksi=tambah" method="POST">
        <table border="0" cellpadding="5">
            <tr>
                <td>NIM</td>
                <td>: <input type="text" name="nim" required></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>: <input type="text" name="nama" required></td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>: 
                    <select name="kode_jurusan" required>
                        <option value="">-- Pilih Jurusan --</option>
                        <!-- Iterasi data dinamis berbasis array JSON menggunakan foreach -->
                        <?php foreach ($dataJurusan as $row) : ?>
                            <option value="<?= htmlspecialchars($row['kode_jurusan']); ?>">
                                <?= htmlspecialchars($row['nama_jurusan']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>: 
                    <input type="radio" name="gender" value="L" required> Laki-laki
                    <input type="radio" name="gender" value="P"> Perempuan
                </td>
            </tr>
            <tr>
                <td>Tempat Lahir</td>
                <td>: <input type="text" name="tempat" required></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>: <input type="date" name="tanggal_lahir" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <textarea name="alamat" rows="3" cols="22" required></textarea></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: <input type="email" name="email" required></td>
            </tr>
            <tr>
                <td>No HP</td>
                <td>: <input type="text" name="no_hp" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit">Simpan Data</button> 
                    <a href="index.php">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
