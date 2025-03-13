<?php
include '../koneksi.php';

$hapus_id = $_GET['hapus_id'] ?? null;

if (!empty($hapus_id)) {
  $query3 = "DELETE FROM data_wilayah WHERE id_wilayah = ?";
  $stmt = mysqli_prepare($db, $query3);
  mysqli_stmt_bind_param($stmt, "s", $hapus_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  echo '<script type="text/javascript">';
  echo 'window.location= "../../view/admin/desa.php";';
  echo '</script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id_wilayah'])) {
    $id_wilayah = $_POST['id_wilayah'];
    $id_provinsi = $_POST['id_provinsi'] ?? '';
    $id_kabKota = $_POST['id_kab_kota'] ?? '';
    $id_kecamatan = $_POST['id_kecamatan'] ?? '';
    $id_kel_desa = $_POST['id_kel_desa'] ?? '';
    $klasifikasi = $_POST['klasifikasi'] ?? '';

    $query = "UPDATE data_wilayah SET 
                provinsi = '$id_provinsi', 
                kab_kota = '$id_kabKota', 
                kecamatan = '$id_kecamatan' , 
                kel_desa = '$id_kel_desa', 
                klasifikasi = '$klasifikasi'
              WHERE id_wilayah = '$id_wilayah'";
    mysqli_query($db, $query);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/desa.php";';
    echo '</script>';
  } elseif (!isset($_POST['id_wilayah']) && isset($_POST['id_provinsi'])) { // Add New Data
    $id_provinsi = $_POST['id_provinsi'] ?? '';
    $id_kabKota = $_POST['id_kab_kota'] ?? '';
    $id_kecamatan = $_POST['id_kecamatan'] ?? '';
    $id_kel_desa = $_POST['id_kel_desa'] ?? '';
    $klasifikasi = $_POST['klasifikasi'] ?? '';

    $query2 = "INSERT INTO data_wilayah SET 
                provinsi = '$id_provinsi', 
                kab_kota = '$id_kabKota', 
                kecamatan = '$id_kecamatan' , 
                kel_desa = '$id_kel_desa', 
                klasifikasi = '$klasifikasi'";
    mysqli_query($db, $query2);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/desa.php";';
    echo '</script>';
  } else {
    echo '<script>window.location= "../../view/admin/desa.php";</script>';
  }
} else {
  echo '<script>window.location= "../../view/admin/desa.php";</script>';
}