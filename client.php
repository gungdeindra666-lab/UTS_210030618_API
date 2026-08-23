<?php
class RestClient {
    private $baseUrl;

    public function __construct() {
        // Menentukan URL endpoint REST API secara dinamis berdasarkan folder proyek Anda
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
        $host = $_SERVER['HTTP_HOST'];
        $current_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        
        // Base URL mengarah ke folder api/
        $this->baseUrl = $protocol . $host . $current_dir . "api/";
    }

    /**
     * Fungsi utama untuk melakukan HTTP Request ke REST API menggunakan cURL
     */
    private function request($endpoint, $method = 'GET', $data = null) {
        $url = $this->baseUrl . $endpoint;
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);

        // Jika ada data yang dikirim, ubah (encode) menjadi string JSON
        if ($data !== null) {
            $jsonPayload = json_encode($data);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonPayload);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonPayload)
            ]);
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
        }

        $response = curl_exec($ch);
        //curl_close($ch);

        // Mengembalikan data yang sudah di-decode menjadi Array PHP
        return json_decode($response, true);
    }

    // 1. HTTP GET - Mengambil Data
    public function get($endpoint) {
        return $this->request($endpoint, 'GET');
    }

    // 2. HTTP POST - Menambah Data Baru
    public function post($endpoint, $data) {
        return $this->request($endpoint, 'POST', $data);
    }

    // 3. HTTP PUT - Memperbarui Data Berdasarkan ID/NIM
    public function put($endpoint, $data) {
        return $this->request($endpoint, 'PUT', $data);
    }

    // 4. HTTP DELETE - Menghapus Data
    public function delete($endpoint, $data) {
        return $this->request($endpoint, 'DELETE', $data);
    }
}
?>
