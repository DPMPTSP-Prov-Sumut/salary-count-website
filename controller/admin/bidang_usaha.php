<?php
include '../koneksi.php';

$hapus_id = $_GET['hapus_id'] ?? null;

if (!empty($hapus_id)) {
  $query3 = "DELETE FROM bidang_usaha WHERE id_bidang_usaha = ?";
  $stmt = mysqli_prepare($db, $query3);
  mysqli_stmt_bind_param($stmt, "s", $hapus_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  echo '<script type="text/javascript">';
  echo 'window.location= "../../view/admin/bidang_usaha.php";';
  echo '</script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id_bidang_usaha'])) {
    $id_bidang_usaha = $_POST['id_bidang_usaha'];
    $nama_bidang_usaha = $_POST['nama_bidang_usaha'];

    $query = "UPDATE bidang_usaha SET 
                nama_bidang_usaha = '$nama_bidang_usaha'
              WHERE id_bidang_usaha = '$id_bidang_usaha'";
    mysqli_query($db, $query);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/bidang_usaha.php";';
    echo '</script>';
  } elseif (!isset($_POST['id_wilayah'])) { // Add New Data
    $nama_bidang_usaha = $_POST['nama_bidang_usaha'] ?? '';

    $query2 = "INSERT INTO bidang_usaha SET 
                nama_bidang_usaha = '$nama_bidang_usaha'";
    mysqli_query($db, $query2);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/bidang_usaha.php";';
    echo '</script>';
  } else {
    echo '<script>window.location= "../../view/admin/bidang_usaha.php";</script>';
  }
} else {
  echo '<script>window.location= "../../view/admin/bidang_usaha.php";</script>';
}
