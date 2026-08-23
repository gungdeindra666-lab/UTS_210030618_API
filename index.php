<?php
// 1. Hubungkan dengan file client.php yang baru dibuat
require_once 'client.php';

// 2. Inisialisasi object RestClient
$client = new RestClient();

// 3. Ambil data dari backend API menggunakan method get()
// Sesuai dengan folder api dan nama file backend Anda: api/data_api.php
$result = $client->get('data_api.php');

// 4. Pastikan data yang dimasukkan ke tabel berbentuk array valid
$dataMahasiswa = is_array($result) ? $result : [];
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Mahasiswa (Client REST API)</title>
</head>
<body>
    <h2>Data Mahasiswa (UTS - REST API Client)</h2>
    <a href="form_tambah.php">[+] Tambah Data Baru</a><br><br>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Jurusan</th>
                <th>Gender</th>
                <th>Tempat, Tgl Lahir</th>
                <th>Alamat</th>
                <th>Email</th>
                <th>No HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($dataMahasiswa)) : ?>
                <tr><td colspan="9" align="center">Belum ada data mahasiswa atau gagal memuat API.</td></tr>
            <?php else : ?>
                <?php foreach ($dataMahasiswa as $row) : ?>
                    <tr>
                        <td><?= htmlspecialchars($row['NIM']); ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['nama_jurusan'] ?? '-'); ?></td>
                        <td><?= $row['gender'] == 'L' ? 'Laki-laki' : 'Perempuan'; ?></td>
                        <td><?= htmlspecialchars($row['tempat']) . ', ' . htmlspecialchars($row['tanggal_lahir']); ?></td>
                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td><?= htmlspecialchars($row['no_hp']); ?></td>
                        <td>
                            <a href="form_edit.php?nim=<?= urlencode($row['NIM']); ?>">Edit</a> | 
                            <!-- Proses hapus dialihkan ke file handler baru atau langsung ke API -->
                            <a href="proses_client.php?aksi=hapus&nim=<?= urlencode($row['NIM']); ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
