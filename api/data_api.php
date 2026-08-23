<?php
header("Content-Type: application/json; charset=UTF-8");

// 1. Pastikan path include mengarah ke file class yang benar
require_once __DIR__ . '/../classes/Mahasiswa.php'; 
$mhs = new Mahasiswa(); // Pastikan huruf kapital sesuai nama class Anda

$method = $_SERVER["REQUEST_METHOD"];

function sendResponse($status, $data = null)
{
    http_response_code($status);
    echo json_encode($data);
}

if($method == "GET"){
    // UBAH: dari getMahasiswa() menjadi tampilSemua()
    $result = $mhs->tampilSemua();
    $datamhs = [];
    while ($row = $result->fetch_assoc()) {
        $datamhs[] = $row;
    }
    sendResponse(200, $datamhs);

}elseif($method == "POST"){
    $data = json_decode(file_get_contents("php://input"), true);
    
    // UBAH: Sesuaikan parameter ke fungsi tambah()
    $insert = $mhs->tambah(
        $data['nim'], $data['nama'], $data['kode_jurusan'], 
        $data['gender'], $data['tempat'], $data['tanggal_lahir'], 
        $data['alamat'], $data['email'], $data['no_hp']
    );

    if($insert){
        $res = "Data berhasil disimpan";
    }else{
        $res = "Data gagal disimpan";
    }
    sendResponse(200, $res);

}elseif($method == "PUT"){
    $data = json_decode(file_get_contents("php://input"), true);
    
    // UBAH: Sesuaikan parameter ke fungsi ubah()
    $update = $mhs->ubah(
        $data['nim'], $data['nama'], $data['kode_jurusan'], 
        $data['gender'], $data['tempat'], $data['tanggal_lahir'], 
        $data['alamat'], $data['email'], $data['no_hp']
    );

    if($update){
        $res = $data['nim'] . " Berhasil di Update";
    }else{
        $res = $data['nim'] . " Gagal di Update";
    }
    sendResponse(200, "Data ". $res);

}elseif($method == "DELETE"){
    $data = json_decode(file_get_contents("php://input"), true);
    
    // UBAH: dari deleteMahasiswa() menjadi hapus()
    $delete = $mhs->hapus($data['nim']);

    if($delete){
        $res = $data['nim'] . " Berhasil di Hapus";
    }else{
        $res = $data['nim'] . " Gagal di Hapus";
    }
    sendResponse(200, $res);
}else{
    sendResponse(405, "Method invalid");
}
