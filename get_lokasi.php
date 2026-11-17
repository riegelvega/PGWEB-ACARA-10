<?php
header('Content-Type: application/json');

// Konfigurasi koneksi database
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "pgweb_acara9";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Ambil semua data dari tabel lokasi_opd
    $sql = "SELECT * FROM lokasi_opd";
    $result = $conn->query($sql);

    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);
    $conn->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status"  => "error",
        "message" => $e->getMessage()
    ]);
}
?>