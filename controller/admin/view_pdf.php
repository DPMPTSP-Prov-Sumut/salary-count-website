<?php
// Pastikan tidak ada whitespace sebelum <?php

// Bersihkan output buffer jika ada
if (ob_get_length()) {
    ob_clean();
}

include '../koneksi.php';  // Pastikan koneksi sudah benar

if (isset($_GET['id_pegawai'])) {
    $id = $_GET['id_pegawai'];
    
    // Disarankan menggunakan prepared statement untuk keamanan
    $stmt = mysqli_prepare($db, "SELECT file_pkwt FROM pegawai WHERE id_pegawai = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        $pdfContent = $data['file_pkwt'];
        
        // Pastikan PDF Content tidak kosong
        if ($pdfContent) {
            header("Content-Type: application/pdf");
            header("Content-Disposition: inline; filename=document.pdf");
            header("Content-Length: " . strlen($pdfContent));
            echo $pdfContent;
            exit; // Hentikan script agar tidak ada output tambahan
        } else {
            echo "Data PDF tidak valid.";
            exit;
        }
    } else {
        echo "File tidak ditemukan.";
        exit;
    }
} else {
    echo "ID tidak disediakan.";
    exit;
}
?>
