<?php
include '../koneksi.php';

$hapus_id = $_GET['hapus_id'] ?? null;

if (!empty($hapus_id)) {
  $query3 = "DELETE FROM kawasan_industri WHERE id_kawasan_industri = ?";
  $stmt = mysqli_prepare($db, $query3);
  mysqli_stmt_bind_param($stmt, "s", $hapus_id);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);

  echo '<script type="text/javascript">';
  echo 'window.location= "../../view/admin/kawasan_industri.php";';
  echo '</script>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_kawasan_industri'])) {
        // Update existing data
        $id_kawasan_industri = $_POST['id_kawasan_industri'];
        $id_provinsi         = $_POST['id_provinsi'] ?? '';
        $id_kabKota          = $_POST['id_kab_kota'] ?? '';
        $id_kecamatan        = $_POST['id_kecamatan'] ?? '';
        $id_kel_desa         = $_POST['id_kel_desa'] ?? '';
    
        // Handle file upload
        if (isset($_FILES['peta_spasial']) && $_FILES['peta_spasial']['error'] == 0) {
            $fileData        = file_get_contents($_FILES['peta_spasial']['tmp_name']);
            $fileName        = $_FILES['peta_spasial']['name'];
            $fileDataBase64  = base64_encode($fileData); // Encode file data to base64
            
            // Update the database
            $query = "UPDATE kawasan_industri SET 
                        id_provinsi = ?, 
                        id_kab_kota = ?, 
                        id_kecamatan = ?, 
                        id_kel_desa = ?, 
                        peta_spasial = ?
                      WHERE id_kawasan_industri = ?";
            $stmt = mysqli_prepare($db, $query);
            // Pastikan untuk bind 6 parameter sesuai dengan 6 placeholder di query
            mysqli_stmt_bind_param($stmt, "ssssss", $id_provinsi, $id_kabKota, $id_kecamatan, $id_kel_desa, $fileName, $id_kawasan_industri);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }
    
        echo '<script type="text/javascript">';
        echo 'window.location= "../../view/admin/kawasan_industri.php";';
        echo '</script>';
    } elseif (!isset($_POST['id_kawasan_industri']) && isset($_POST['id_provinsi'])) {
        // Add new data
        $id_provinsi = $_POST['id_provinsi'] ?? '';
        $id_kabKota = $_POST['id_kab_kota'] ?? '';
        $id_kecamatan = $_POST['id_kecamatan'] ?? '';
        $id_kel_desa = $_POST['id_kel_desa'] ?? '';

        // Handle file upload
        if (isset($_FILES['peta_spasial']) && $_FILES['peta_spasial']['error'] == 0) {
            $fileData = file_get_contents($_FILES['peta_spasial']['tmp_name']);
            $fileName = $_FILES['peta_spasial']['name'];
            $fileDataBase64 = base64_encode($fileData); // Encode file data to base64
            
            // Insert into the database
            $query2 = "INSERT INTO kawasan_industri (id_provinsi, id_kab_kota, id_kecamatan, id_kel_desa, peta_spasial) 
                        VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($db, $query2);
            mysqli_stmt_bind_param($stmt, "sssss", $id_provinsi, $id_kabKota, $id_kecamatan, $id_kel_desa, $fileName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        echo '<script type="text/javascript">';
        echo 'window.location= "../../view/admin/kawasan_industri.php";';
        echo '</script>';
    } else {
        echo '<script>window.location= "../../view/admin/kawasan_industri.php";</script>';
    }
} else {
    echo '<script>window.location= "../../view/admin/kawasan_industri.php";</script>';
}