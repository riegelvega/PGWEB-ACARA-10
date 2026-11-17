<?php
header('Content-Type: application/json');

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "pgweb_acara9";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Ambil data dari POST
    $id_raw     = isset($_POST['id']) ? trim($_POST['id']) : '';
    $nama_dinas = isset($_POST['nama_dinas']) ? trim($_POST['nama_dinas']) : '';
    $lokasi     = isset($_POST['lokasi']) ? trim($_POST['lokasi']) : '';
    $latitude   = isset($_POST['latitude']) ? trim($_POST['latitude']) : '';
    $longitude  = isset($_POST['longitude']) ? trim($_POST['longitude']) : '';
    $keterangan = isset($_POST['keterangan']) ? trim($_POST['keterangan']) : '';

    if (empty($nama_dinas) || empty($latitude) || empty($longitude)) {
        echo json_encode(["status" => "error", "message" => "Nama Dinas, Latitude, dan Longitude wajib diisi!"]);
        exit;
    }

    // Jika ID dikirim (bukan string kosong), maka jalankan mode UPDATE
    if ($id_raw !== '' && is_numeric($id_raw)) {
        $id = intval($id_raw);
        $stmt = $conn->prepare("UPDATE lokasi_opd SET nama_dinas = ?, lokasi = ?, latitude = ?, longitude = ?, keterangan = ? WHERE no = ?");
        $stmt->bind_param("sssssi", $nama_dinas, $lokasi, $latitude, $longitude, $keterangan, $id);
        $stmt->execute();
        $message = "Data berhasil diperbarui!";
    } else {
        // Mode INSERT (Tambah Data Baru)
        $stmt = $conn->prepare("INSERT INTO lokasi_opd (nama_dinas, lokasi, latitude, longitude, keterangan) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nama_dinas, $lokasi, $latitude, $longitude, $keterangan);
        $stmt->execute();
        $message = "Data baru berhasil ditambahkan!";
    }

    echo json_encode(["status" => "success", "message" => $message]);
    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>