<?php
include '../koneksi.php';

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
        $queryIn = "INSERT INTO gaji (id_pegawai, bulan, tahun, gaji_pegawai, pph) VALUES (?, ?, ?, ?, ?)";
        $stmtIn = mysqli_prepare($db, $queryIn);
        mysqli_stmt_bind_param($stmtIn, "issii", $id_pegawai, $bulan, $tahun, $gaji_pegawai, $pph);
        
        if (mysqli_stmt_execute($stmtIn)) {
            echo "<script>
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
    
    mysqli_close($db);
} else {
    header("Location: ../../view/admin/gaji.php");
    exit;
}
?>
