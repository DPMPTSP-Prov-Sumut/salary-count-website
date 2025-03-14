<?php
// Include database connection
include '../koneksi.php';

// Add new RTR data
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update'])) {
    // Get form data
    $id_provinsi = $_POST['id_provinsi'];
    $id_kab_kota = $_POST['id_kab_kota'];
    $id_kecamatan = $_POST['id_kecamatan'];
    
    /* Check if data already exists
    $checkQuery = "SELECT * FROM rtr_kawasan_perbatasan 
                  WHERE id_provinsi = '$id_provinsi' 
                  AND id_kab_kota = '$id_kab_kota' 
                  AND id_kecamatan = '$id_kecamatan'";
    $checkResult = mysqli_query($db, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // Data already exists, redirect with error message
        header("Location: ../../view/admin/rtr_perbatasan.php?status=duplicate");
        exit;
    }*/
    
    // Insert data
    $insertQuery = "INSERT INTO rtr_kawasan_perbatasan (id_provinsi, id_kab_kota, id_kecamatan)
                   VALUES ('$id_provinsi', '$id_kab_kota', '$id_kecamatan')";
    
    if (mysqli_query($db, $insertQuery)) {
        // Redirect with success message
        header("Location: ../../view/admin/rtr_perbatasan.php?status=success");
    } else {
        // Redirect with error message
        header("Location: ../../view/admin/rtr_perbatasan.php?status=error&message=" . mysqli_error($db));
    }
    exit;
}

// Update existing RTR data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Get form data
    $id_kawasan_perbatasan = $_POST['update_id'];
    $id_provinsi = $_POST['id_provinsi'];
    $id_kab_kota = $_POST['id_kab_kota'];
    $id_kecamatan = $_POST['id_kecamatan'];
    
    /* Check if updated data already exists (excluding the current record)
    $checkQuery = "SELECT * FROM rtr_kawasan_perbatasan 
                  WHERE id_provinsi = '$id_provinsi' 
                  AND id_kab_kota = '$id_kab_kota' 
                  AND id_kecamatan = '$id_kecamatan'
                  AND id_kawasan_perbatasan != '$id_kawasan_perbatasan'";
    $checkResult = mysqli_query($db, $checkQuery);
    
    if (mysqli_num_rows($checkResult) > 0) {
        // Data already exists, redirect with error message
        header("Location: ../../view/admin/rtr_perbatasan.php?status=duplicate");
        exit;
    }*/
    
    // Update data
    $updateQuery = "UPDATE rtr_kawasan_perbatasan 
                   SET id_provinsi = '$id_provinsi', 
                       id_kab_kota = '$id_kab_kota', 
                       id_kecamatan = '$id_kecamatan'
                   WHERE id_kawasan_perbatasan = '$id_kawasan_perbatasan'";
    
    if (mysqli_query($db, $updateQuery)) {
        // Redirect with success message
        header("Location: ../../view/admin/rtr_perbatasan.php?status=updated");
    } else {
        // Redirect with error message
        header("Location: ../../view/admin/rtr_perbatasan.php?status=error&message=" . mysqli_error($db));
    }
    exit;
}

// Delete RTR data
if (isset($_GET['hapus_id'])) {
    $id_kawasan_perbatasan = $_GET['hapus_id'];
    
    // Delete data
    $deleteQuery = "DELETE FROM rtr_kawasan_perbatasan WHERE id_kawasan_perbatasan = '$id_kawasan_perbatasan'";
    
    if (mysqli_query($db, $deleteQuery)) {
        // Redirect with success message
        header("Location: ../../view/admin/rtr_perbatasan.php?status=deleted");
    } else {
        // Redirect with error message
        header("Location: ../../view/admin/rtr_perbatasan.php?status=error&message=" . mysqli_error($db));
    }
    exit;
}

// Redirect if accessed directly
header("Location: ../../view/admin/rtr_perbatasan.php");
exit;
?>