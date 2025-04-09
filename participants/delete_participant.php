<?php
include('../config/db_connection.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID tidak ditemukan.");
}

$id = $koneksi->real_escape_string($_GET['id']); 

$sql = "DELETE FROM tbl_peserta WHERE Id_peserta='$id'";
$exec = $koneksi->query($sql);

if ($exec) {
    header('Location: ../index.php');
    exit;
} else {
    echo "Gagal menghapus data. Error: " . $koneksi->error;
}
?>
