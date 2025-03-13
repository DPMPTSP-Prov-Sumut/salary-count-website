<?php
include '../koneksi.php';

$hapus_id = $_GET['hapus_id'] ?? null;

if (!empty($hapus_id)) {
  $query3 = "DELETE FROM industri_pionir WHERE id_industri = ?";
  $stmt = mysqli_prepare($db, $query3);
  mysqli_stmt_bind_param($stmt, "s", $hapus_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  echo '<script type="text/javascript">';
  echo 'window.location= "../../view/admin/industry.php";';
  echo '</script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id_industri'])) {
    $id_industri = $_POST['id_industri'];
    $id_bidang_usaha = $_POST['id_bidang_usaha'] ?? '';
    $id_jenis_produksi = $_POST['id_jenis_produksi'] ?? '';
    $komoditi = $_POST['komoditi'] ?? '';

    $query = "UPDATE industri_pionir SET 
                id_bidang_usaha = '$id_bidang_usaha', 
                id_jenis_produksi = '$id_jenis_produksi', 
                komoditi = '$komoditi'
              WHERE id_industri = '$id_industri'";
    mysqli_query($db, $query);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/industry.php";';
    echo '</script>';
  } elseif (!isset($_POST['id_industri']) && isset($_POST['id_bidang_usaha'])) { // Add New Data
    $id_bidang_usaha = $_POST['id_bidang_usaha'] ?? '';
    $id_jenis_produksi = $_POST['id_jenis_produksi'] ?? '';
    $komoditi = $_POST['komoditi'] ?? '';

    $query2 = "INSERT INTO industri_pionir SET 
                id_bidang_usaha = '$id_bidang_usaha', 
                id_jenis_produksi = '$id_jenis_produksi', 
                komoditi = '$komoditi'";
    mysqli_query($db, $query2);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/industry.php";';
    echo '</script>';
  } else {
    echo '<script>window.location= "../../view/admin/industry.php";</script>';
  }
} else {
  echo '<script>window.location= "../../view/admin/industry.php";</script>';
}
