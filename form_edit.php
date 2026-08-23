<?php
// 1. Tangkap NIM dari parameter URL
$nim = isset($_GET['nim']) ? $_GET['nim'] : '';

if (empty($nim)) {
    header("Location: index.php");
    exit();
}

// 2. Tentukan URL endpoint REST API secara dinamis
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$current_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

// Kita buat URL endpoint untuk Mahasiswa (dengan parameter NIM) dan Jurusan
$url_api_mhs = $protocol . $host . $current_dir . "api/data_api.php?nim=" . urlencode($nim);
$url_api_jurusan = $protocol . $host . $current_dir . "api/jurusan_api.php";

require_once 'client.php';
$client = new RestClient();

$result_jurusan = $client->get('jurusan_api.php');
$dataJurusan = isset($result_jurusan['status']) && $result_jurusan['status'] == 'success' ? $result_jurusan['data'] : [];

// Khusus untuk form_edit.php, tambahkan penarikan data mahasiswa satu baris saja:
$nim = $_GET['nim'] ?? '';
$data = $client->get('data_api.php?nim=' . urlencode($nim));


// Karena data_api.php (GET) langsung mengembalikan array data atau record tunggal saat di-filter, 
// kita decode langsung responsenya.
$data = json_decode($response_mhs, true);

// Pengaman jika data mahasiswa tidak ditemukan via API
if (empty($data) || isset($data['status']) && $data['status'] === 'fail') {
    echo "<script>alert('Data mahasiswa tidak ditemukan di API!'); window.location='index.php';</script>";
    exit();
}

// 4. Ambil data daftar Jurusan dari REST API menggunakan cURL
curl_setopt($ch, CURLOPT_URL, $url_api_jurusan);
$response_jurusan = curl_exec($ch);
//curl_close($ch);

$result_jurusan = json_decode($response_jurusan, true);
$dataJurusan = [];
if (isset($result_jurusan['status']) && $result_jurusan['status'] == 'success') {
    $dataJurusan = $result_jurusan['data'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Mahasiswa (REST Client)</title>
</head>
<body>
    <h2>Formulir Edit Mahasiswa (REST API Client)</h2>
    <!-- Kirim form handler menuju file pemroses frontend baru menggunakan metode POST -->
    <form action="proses_client.php?aksi=ubah" method="POST">
        <!-- Menyimpan identifier NIM untuk dikirim via form body -->
        <input type="hidden" name="nim" value="<?= htmlspecialchars($data['NIM'] ?? $data['nim']); ?>">
        <table border="0" cellpadding="5">
            <tr>
                <td>NIM</td>
                <td>: <strong><?= htmlspecialchars($data['NIM'] ?? $data['nim']); ?></strong></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>: <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']); ?>" required></td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td>: 
                <select name="kode_jurusan" required>
                    <option value="">-- Pilih Jurusan --</option>
                    <?php foreach ($dataJurusan as $row) : ?>
                        <?php 
                            // Cek kecocokan kode_jurusan untuk tanda selected
                            $mhs_jurusan = $data['kode_jurusan'] ?? '';
                            $selected = ($row['kode_jurusan'] == $mhs_jurusan) ? 'selected' : ''; 
                        ?>
                        <option value="<?= htmlspecialchars($row['kode_jurusan']); ?>" <?= $selected; ?>>
                            <?= htmlspecialchars($row['nama_jurusan']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                </td>
            </tr>
            <tr>
                <td>Gender</td>
                <td>: 
                    <input type="radio" name="gender" value="L" <?= ($data['gender'] == 'L') ? 'checked' : ''; ?> required> Laki-laki
                    <input type="radio" name="gender" value="P" <?= ($data['gender'] == 'P') ? 'checked' : ''; ?>> Perempuan
                </td>
            </tr>
            <tr>
                <td>Tempat Lahir</td>
                <td>: <input type="text" name="tempat" value="<?= htmlspecialchars($data['tempat']); ?>" required></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>: <input type="date" name="tanggal_lahir" value="<?= htmlspecialchars($data['tanggal_lahir']); ?>" required></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <textarea name="alamat" rows="3" cols="22" required><?= htmlspecialchars($data['alamat']); ?></textarea></td>
            </tr>
            <tr>
                <td>Email</td>
                <td>: <input type="email" name="email" value="<?= htmlspecialchars($data['email']); ?>" required></td>
            </tr>
            <tr>
                <td>No HP</td>
                <td>: <input type="text" name="no_hp" value="<?= htmlspecialchars($data['no_hp']); ?>" required></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button type="submit">Update Data</button> 
                    <a href="index.php">Batal</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
