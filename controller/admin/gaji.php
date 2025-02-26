<?php
include '../koneksi.php';

// Handle delete requests
if (isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id_pegawai = $_POST['id_pegawai'];
    
    // Check if it's a specific month/year delete or all for a year
    if (isset($_POST['all_tahun']) && !empty($_POST['all_tahun'])) {
        // Delete all entries for this employee in the selected year
        $tahun = $_POST['all_tahun'];
        $queryDel = "DELETE FROM gaji WHERE id_pegawai = ? AND tahun = ?";
        $stmtDel = mysqli_prepare($db, $queryDel);
        mysqli_stmt_bind_param($stmtDel, "is", $id_pegawai, $tahun);
        mysqli_stmt_execute($stmtDel);
        
        if (mysqli_stmt_affected_rows($stmtDel) > 0) {
            echo "<script>
                    alert('Semua data gaji untuk tahun " . $tahun . " berhasil dihapus!');
                    window.location.href='../../view/admin/gaji.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Tidak ada data ditemukan untuk dihapus!');
                    window.location.href='../../view/admin/gaji.php';
                  </script>";
        }
        mysqli_stmt_close($stmtDel);
    } else {
        // Delete specific month/year entry
        $bulan = $_POST['bulan'];
        $tahun = $_POST['tahun'];
        
        $queryDel = "DELETE FROM gaji WHERE id_pegawai = ? AND bulan = ? AND tahun = ?";
        $stmtDel = mysqli_prepare($db, $queryDel);
        mysqli_stmt_bind_param($stmtDel, "iss", $id_pegawai, $bulan, $tahun);
        mysqli_stmt_execute($stmtDel);
        
        if (mysqli_stmt_affected_rows($stmtDel) > 0) {
            echo "<script>
                    alert('Data gaji untuk bulan " . $bulan . " tahun " . $tahun . " berhasil dihapus!');
                    window.location.href='../../view/admin/gaji.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Tidak ada data ditemukan untuk dihapus!');
                    window.location.href='../../view/admin/gaji.php';
                  </script>";
        }
        mysqli_stmt_close($stmtDel);
    }
    
    exit;
}

// Handle individual record deletion via GET (existing code)
if (isset($_GET['hapus_id']) && !empty($_GET['hapus_id'])) {
    $hapus_id = $_GET['hapus_id'];
    $queryDel = "DELETE FROM gaji WHERE id_gaji = ?";
    $stmtDel = mysqli_prepare($db, $queryDel);
    mysqli_stmt_bind_param($stmtDel, "i", $hapus_id);
    mysqli_stmt_execute($stmtDel);
    mysqli_stmt_close($stmtDel);
    echo '<script type="text/javascript">';
    echo 'window.location.href="../../view/admin/gaji.php";';
    echo '</script>'; 
    exit;
}

// Handle data submission (add/edit)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pegawai   = $_POST['id_pegawai'];
    $bulan        = $_POST['bulan'];
    $tahun        = $_POST['tahun'];
    $gaji_pegawai = $_POST['gaji_pegawai'];
    $pph          = $_POST['pph'];

    if (empty($id_pegawai) || empty($bulan) || empty($tahun) || empty($gaji_pegawai) || empty($pph)) {
        $redirect = (isset($_POST['id_gaji']) && !empty($_POST['id_gaji'])) 
                    ? "../../view/admin/gaji.php?aksi=edit&id=" . $_POST['id_gaji'] 
                    : "../../view/admin/gaji.php?aksi=tambah_data";
        echo "<script>
                alert('Semua bidang harus diisi!');
                window.location.href='$redirect';
              </script>";
        exit;
    }
    
    if (isset($_POST['id_gaji']) && !empty($_POST['id_gaji'])) {
        // Update existing record
        $id_gaji = $_POST['id_gaji'];
        $queryUp = "UPDATE gaji SET id_pegawai = ?, bulan = ?, tahun = ?, gaji_pegawai = ?, pph = ? WHERE id_gaji = ?";
        $stmtUp = mysqli_prepare($db, $queryUp);
        mysqli_stmt_bind_param($stmtUp, "issiii", $id_pegawai, $bulan, $tahun, $gaji_pegawai, $pph, $id_gaji);
        
        if (mysqli_stmt_execute($stmtUp)) {
            echo "<script>
                    alert('Data gaji berhasil diperbarui!');
                    window.location.href='../../view/admin/gaji.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Terjadi kesalahan saat update data, coba lagi!');
                    window.location.href='../../view/admin/gaji.php?aksi=edit&id=$id_gaji';
                  </script>";
        }
        mysqli_stmt_close($stmtUp);
    } else {
        // Check if record already exists
        $checkQuery = "SELECT id_gaji FROM gaji WHERE id_pegawai = ? AND bulan = ? AND tahun = ?";
        $checkStmt = mysqli_prepare($db, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, "iss", $id_pegawai, $bulan, $tahun);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_store_result($checkStmt);
        
        if (mysqli_stmt_num_rows($checkStmt) > 0) {
            // Record exists, update it
            mysqli_stmt_bind_result($checkStmt, $existing_id_gaji);
            mysqli_stmt_fetch($checkStmt);
            mysqli_stmt_close($checkStmt);
            
            $queryUp = "UPDATE gaji SET gaji_pegawai = ?, pph = ? WHERE id_gaji = ?";
            $stmtUp = mysqli_prepare($db, $queryUp);
            mysqli_stmt_bind_param($stmtUp, "iii", $gaji_pegawai, $pph, $existing_id_gaji);
            
            if (mysqli_stmt_execute($stmtUp)) {
                echo "<script>
                        alert('Data gaji berhasil diperbarui!');
                        window.location.href='../../view/admin/gaji.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Terjadi kesalahan saat update data, coba lagi!');
                        window.location.href='../../view/admin/gaji.php?aksi=tambah_data';
                      </script>";
            }
            mysqli_stmt_close($stmtUp);
        } else {
            // Insert new record
            mysqli_stmt_close($checkStmt);
            
            $queryIn = "INSERT INTO gaji (id_pegawai, bulan, tahun, gaji_pegawai, pph) VALUES (?, ?, ?, ?, ?)";
            $stmtIn = mysqli_prepare($db, $queryIn);
            mysqli_stmt_bind_param($stmtIn, "issii", $id_pegawai, $bulan, $tahun, $gaji_pegawai, $pph);
            
            if (mysqli_stmt_execute($stmtIn)) {
                echo "<script>
                        alert('Data gaji berhasil ditambahkan!');
                        window.location.href='../../view/admin/gaji.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Terjadi kesalahan, coba lagi!');
                        window.location.href='../../view/admin/gaji.php?aksi=tambah_data';
                      </script>";
            }
            mysqli_stmt_close($stmtIn);
        }
    }
    
    mysqli_close($db);
} else {
    header("Location: ../../view/admin/gaji.php");
    exit;
}
?>