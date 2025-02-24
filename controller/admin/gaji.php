
<?php

    include '../koneksi.php';
    
    $hapus_id = isset($_GET['hapus_id']);

    if ($hapus_id) {

        // Query Hapus Data Jabatan ke Database
        $query3 = "DELETE FROM gaji WHERE id_gaji = '$id_gaji'";
       
        // Proses semua aksi ke dalam database
        mysqli_query($db, $query3);

        // Proses selesai, redirect ke halaman karyawan
        echo '<script type="text/javascript">'; 
        echo 'alert("Berhasil! Data Jabatan telah dihapus");'; 
        echo 'window.location= "../../view/admin/jabatan.php";';
        echo '</script>'; 

    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $id_pegawai = $_POST['id_pegawai'];
      $bulan = $_POST['bulan'];
      $tahun = $_POST['tahun'];
      $gaji_pegawai = $_POST['gaji_pegawai'];
      $pph = $_POST['pph'];
      
      if (empty($id_pegawai) || empty($bulan) || empty($tahun) || empty($gaji_pegawai) || empty($pph)) {
          echo "<script>alert('Semua bidang harus diisi!'); 
          window.location.href='../../view/admin/gaji.php?aksi=tambah_data';</script>";
          exit;
      }
      
      $query = "INSERT INTO gaji (id_pegawai, bulan, tahun, gaji_pegawai, pph) VALUES (?, ?, ?, ?, ?)";
      $stmt = mysqli_prepare($db, $query);
      mysqli_stmt_bind_param($stmt, "issii", $id_pegawai, $bulan, $tahun, $gaji_pegawai, $pph);
      
      if (mysqli_stmt_execute($stmt)) {
          echo "<script> 
          window.location.href='../../view/admin/gaji.php';</script>";
      } else {
          echo "<script>alert('Terjadi kesalahan, coba lagi!'); window.location.href='../../view/admin/gaji.php?aksi=tambah_data';</script>";
      }
      
      mysqli_stmt_close($stmt);
      mysqli_close($db);
  } else {
      header("Location: ../../views/admin/gaji.php");
      exit;
  }

    // Gunakan print_r untuk melakukan troubleshooting jika terjadi kesalahan
    //print_r($query);

  ?>
