<?php
require_once 'client.php';
$client = new RestClient();
$aksi = $_GET['aksi'] ?? '';

// Kumpulan payload data dari input user
$payload = [
    "nim" => $_POST['nim'] ?? '',
    "nama" => $_POST['nama'] ?? '',
    "kode_jurusan" => $_POST['kode_jurusan'] ?? '',
    "gender" => $_POST['gender'] ?? '',
    "tempat" => $_POST['tempat'] ?? '',
    "tanggal_lahir" => $_POST['tanggal_lahir'] ?? '',
    "alamat" => $_POST['alamat'] ?? '',
    "email" => $_POST['email'] ?? '',
    "no_hp" => $_POST['no_hp'] ?? ''
];

if ($aksi == 'tambah') {
    $client->post('data_api.php', $payload);
} elseif ($aksi == 'ubah') {
    $client->put('data_api.php', $payload);
} elseif ($aksi == 'hapus') {
    $client->delete('data_api.php', ["nim" => $_GET['nim']]);
}

header("Location: index.php");
exit();
?>
