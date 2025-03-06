<?php
include '../koneksi.php'; // Sesuaikan dengan path koneksi database

if (isset($_POST['id_bidang_usaha'])) {
    $id_bidang_usaha = $_POST['id_bidang_usaha'];

    // Ambil jenis produksi berdasarkan bidang usaha
    $query = "SELECT id_jenis_produksi, jenis_produksi FROM jenis_produksi WHERE id_bidang_usaha = '$id_bidang_usaha'";
    $result = mysqli_query($db, $query);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
