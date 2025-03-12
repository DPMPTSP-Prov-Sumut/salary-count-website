<?php
include '../koneksi.php';

$hapus_id = $_GET['hapus_id'] ?? null;

if (!empty($hapus_id)) {
  $query3 = "DELETE FROM jenis_produksi WHERE id_jenis_produksi = ?";
  $stmt = mysqli_prepare($db, $query3);
  mysqli_stmt_bind_param($stmt, "s", $hapus_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  echo '<script type="text/javascript">';
  echo 'window.location= "../../view/admin/jenis_produksi.php";';
  echo '</script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id_jenis_produksi'])) {
    $id_jenis_produksi = $_POST['id_jenis_produksi'];
    $id_bidang_usaha = $_POST['id_bidang_usaha'];
    $jenis_produksi = $_POST['jenis_produksi'];
    $kbli = $_POST['kbli'];

    $query = "UPDATE jenis_produksi SET 
                id_bidang_usaha = '$id_bidang_usaha',
                jenis_produksi = '$jenis_produksi',
                kbli = '$kbli'
              WHERE id_jenis_produksi = '$id_jenis_produksi'";
    mysqli_query($db, $query);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/jenis_produksi.php";';
    echo '</script>';
  } elseif (!isset($_POST['id_jenis_produksi']) && isset($_POST['id_bidang_usaha'])) { // Add New Data
    $id_bidang_usaha = $_POST['id_bidang_usaha'] ?? '';
    $jenis_produksi = $_POST['jenis_produksi'] ?? '';
    $kbli = $_POST['kbli'] ?? '';

    $query2 = "INSERT INTO jenis_produksi SET 
                id_bidang_usaha = '$id_bidang_usaha',
                jenis_produksi = '$jenis_produksi',
                kbli = '$kbli'
              ";
    mysqli_query($db, $query2);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/jenis_produksi.php";';
    echo '</script>';
  } else {
    echo '<script>window.location= "../../view/admin/jenis_produksi.php";</script>';
  }
} else {
  echo '<script>window.location= "../../view/admin/jenis_produksi.php";</script>';
}
