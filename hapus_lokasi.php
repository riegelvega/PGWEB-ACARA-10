<?php
header('Content-Type: application/json');

$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "pgweb_acara9";

try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Ambil ID dari POST atau GET
    $id = isset($_POST['id']) ? trim($_POST['id']) : (isset($_GET['id']) ? trim($_GET['id']) : null);

    // Validasi: pastikan ID dikirim dan berupa angka (termasuk jika bernilai 0)
    if ($id === null || $id === '' || !is_numeric($id)) {
        echo json_encode(["status" => "error", "message" => "ID data tidak valid!"]);
        exit;
    }

    $id = intval($id);

    $stmt = $conn->prepare("DELETE FROM lokasi_opd WHERE no = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(["status" => "success", "message" => "Data berhasil dihapus!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Data tidak ditemukan atau sudah dihapus."]);
    }

    $stmt->close();
    $conn->close();
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
?>