<?php
include '../koneksi.php';

// Handle DELETE request
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hapus_id'])) {
    $hapus_id = $_GET['hapus_id'];

    $query = "DELETE FROM penetapan_daerah_tertinggal WHERE id_daerah_tertinggal = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "s", $hapus_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    echo '<script type="text/javascript">';
    echo 'window.location= "../../view/admin/daerah_tertinggal.php";';
    echo '</script>';
}

// Handle POST request for UPDATE and INSERT
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id_daerah_tertinggal'])) {
        // Update existing record
        $id_daerah_tertinggal = $_POST['id_daerah_tertinggal'];
        $id_provinsi = $_POST['id_provinsi'] ?? '';
        $id_kab_kota = $_POST['id_kab_kota'] ?? '';

        $query = "UPDATE penetapan_daerah_tertinggal SET 
                    id_provinsi = '$id_provinsi', 
                    id_kab_kota = '$id_kab_kota'
                  WHERE id_daerah_tertinggal = '$id_daerah_tertinggal'";
        mysqli_query($db, $query);

        echo '<script type="text/javascript">';
        echo 'window.location= "../../view/admin/daerah_tertinggal.php";';
        echo '</script>';
    } elseif (!isset($_POST['id_daerah_tertinggal']) && isset($_POST['id_provinsi'])) {
        // Insert new record
        $id_provinsi = $_POST['id_provinsi'] ?? '';
        $id_kab_kota = $_POST['id_kab_kota'] ?? '';

        $query2 = "INSERT INTO penetapan_daerah_tertinggal (id_provinsi, id_kab_kota) 
                   VALUES ('$id_provinsi', '$id_kab_kota')";
        mysqli_query($db, $query2);

        echo '<script type="text/javascript">';
        echo 'window.location= "../../view/admin/daerah_tertinggal.php";';
        echo '</script>';
    } else {
        echo '<script type="text/javascript">';
        echo 'alert("Invalid request.");';
        echo 'window.location= "../../view/admin/daerah_tertinggal.php";';
        echo '</script>';
    }
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Invalid request method.");';
    echo 'window.location= "../../view/admin/daerah_tertinggal.php";';
    echo '</script>';
}
?>