<?php
include '../koneksi.php';

$hapus_id = $_GET['hapus_id'] ?? null;

if (!empty($hapus_id)) {
  $query3 = "DELETE FROM pegawai WHERE id_pegawai = ?";
  $stmt = mysqli_prepare($db, $query3);
  mysqli_stmt_bind_param($stmt, "s", $hapus_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  echo '<script type="text/javascript">';
  echo 'window.location= "../../view/admin/karyawan.php";';
  echo '</script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['id_pegawai'])) {
    $id_pegawai = $_POST['id_pegawai'];
    $nama = $_POST['nama'] ?? '';
    $jabatan = $_POST['jabatan'] ?? '';
    $mulai_kerja = $_POST['mulai_kerja'] ?? '';
    $alamat_domisili = $_POST['domisili'] ?? '';
    if (isset($_FILES['file_pkwt']) && $_FILES['file_pkwt']['error'] == 0) {
      $fileContent = addslashes(file_get_contents($_FILES['file_pkwt']['tmp_name']));

      $originalName = $_FILES['file_pkwt']['name'];
    } else {
      $fileContent = '';
    }

    $query = "UPDATE pegawai SET nama = '$nama', jabatan = '$jabatan', mulai_kerja = '$mulai_kerja', alamat_domisili ='$alamat_domisili', file_pkwt = '$fileContent', file_pkwt_name = '$originalName' WHERE id_pegawai = '$id_pegawai'";
    mysqli_query($db, $query);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/karyawan.php";';
    echo '</script>';
  } elseif (!isset($_POST['id_pegawai']) && isset($_POST['nama'])) { // Add New Data
    $nama = $_POST['nama'] ?? '';
    $jabatan = $_POST['jabatan'] ?? '';
    $alamat_domisili = $_POST['domisili'] ?? '';
    $mulai_kerja = $_POST['mulai_kerja'] ?? '';
    if (isset($_FILES['file_pkwt']) && $_FILES['file_pkwt']['error'] == 0) {
      $fileContent = addslashes(file_get_contents($_FILES['file_pkwt']['tmp_name']));

      $originalName = $_FILES['file_pkwt']['name'];
    } else {
      $fileContent = '';
    }

    $query2 = "INSERT INTO pegawai SET nama = '$nama', jabatan = '$jabatan', alamat_domisili = '$alamat_domisili' , mulai_kerja = '$mulai_kerja', file_pkwt = '$fileContent', file_pkwt_name = '$originalName'";
    mysqli_query($db, $query2);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/karyawan.php";';
    echo '</script>';
  } else {
    echo '<script>window.location= "../../view/admin/karyawan.php";</script>';
  }
} else {
  echo '<script>window.location= "../../view/admin/karyawan.php";</script>';
}
