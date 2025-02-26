<?php
include '../../controller/koneksi.php';

header('Content-Type: application/json');

if (isset($_GET['employee_id']) && isset($_GET['bulan']) && isset($_GET['tahun'])) {
    $employee_id = $_GET['employee_id'];
    $bulan = $_GET['bulan'];
    $tahun = $_GET['tahun'];
    
    $query = "SELECT id_gaji, gaji_pegawai, pph FROM gaji 
              WHERE id_pegawai = ? AND bulan = ? AND tahun = ?";
    $stmt = mysqli_prepare($db, $query);
    mysqli_stmt_bind_param($stmt, "iss", $employee_id, $bulan, $tahun);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    
    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_bind_result($stmt, $id_gaji, $gaji_pegawai, $pph);
        mysqli_stmt_fetch($stmt);
        
        echo json_encode([
            'found' => true,
            'id_gaji' => $id_gaji,
            'gaji_pegawai' => $gaji_pegawai,
            'pph' => $pph
        ]);
    } else {
        echo json_encode([
            'found' => false
        ]);
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo json_encode([
        'error' => 'Missing required parameters'
    ]);
}

mysqli_close($db);
?>