<?php
include '../koneksi.php';

if (isset($_POST['id_jenis_produksi'])) {
    $id_jenis_produksi = $_POST['id_jenis_produksi'];

    // Ambil KBLI berdasarkan jenis produksi
    $query = "SELECT kbli FROM jenis_produksi WHERE id_jenis_produksi = '$id_jenis_produksi'";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    echo json_encode($row);
}
?>
