<?php
$aksi = $_GET['aksi'] ?? '';

// 1. Tentukan URL endpoint REST API Mahasiswa Anda secara dinamis
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
$host = $_SERVER['HTTP_HOST'];
$current_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$url_api = $protocol . $host . $current_dir . "api/data_api.php";

if (empty($aksi)) {
    header("Location: index.php");
    exit();
}

// 2. Proses Berdasarkan Aksi Form
if ($aksi == 'tambah') {
    // Siapkan struktur data payload dari input POST
    $payload = [
        "nim" => $_POST['nim'],
        "nama" => $_POST['nama'],
        "kode_jurusan" => $_POST['kode_jurusan'],
        "gender" => $_POST['gender'],
        "tempat" => $_POST['tempat'],
        "tanggal_lahir" => $_POST['tanggal_lahir'],
        "alamat" => $_POST['alamat'],
        "email" => $_POST['email'],
        "no_hp" => $_POST['no_hp']
    ];

    // Kirim JSON menggunakan cURL dengan HTTP Method: POST
    $ch = curl_init($url_api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload)); // Konversi array ke JSON string
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($payload))
    ]);
    curl_exec($ch);
    header("Location: index.php");
    exit();

} elseif ($aksi == 'ubah') {
    // Siapkan struktur data payload untuk pembaruan
    $payload = [
        "nim" => $_POST['nim'],
        "nama" => $_POST['nama'],
        "kode_jurusan" => $_POST['kode_jurusan'],
        "gender" => $_POST['gender'],
        "tempat" => $_POST['tempat'],
        "tanggal_lahir" => $_POST['tanggal_lahir'],
        "alamat" => $_POST['alamat'],
        "email" => $_POST['email'],
        "no_hp" => $_POST['no_hp']
    ];

    // Kirim JSON menggunakan cURL dengan HTTP Method: PUT
    $ch = curl_init($url_api);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload)); // Konversi array ke JSON string
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Content-Length: ' . strlen(json_encode($payload))
    ]);
    curl_exec($ch);
    header("Location: index.php");
    exit();

} elseif ($aksi == 'hapus') {
    $nim = $_GET['nim'] ?? '';
    
    if (!empty($nim)) {
        // Sesuai dengan spesifikasi file api/data_api.php Anda yang membaca JSON body pada method DELETE:
        $payload = ["nim" => $nim];

        // Kirim JSON menggunakan cURL dengan HTTP Method: DELETE
        $ch = curl_init($url_api);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload)); // Konversi array ke JSON string
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen(json_encode($payload))
        ]);
        curl_exec($ch);
    }
    header("Location: index.php");
    exit();
}
?>
