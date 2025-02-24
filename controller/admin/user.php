
<?php

    include '../koneksi.php';
    
    session_start();

      if($_SESSION['level'] != '1') { // Cek Apakah Sebagai Admin
        echo '<script type="text/javascript">'; 
        echo 'alert("Maaf anda tidak memilik hak akses halaman ini");'; 
        echo 'window.location= "../login.php";';
        echo '</script>';  
      }
    
    $hapus_id = $_GET['hapus_id'];

    if ($hapus_id) {

        // Query Hapus Data user ke Database
        $query3 = "DELETE FROM user WHERE id_user = '$hapus_id'";
       
        // Proses semua aksi ke dalam database
        mysqli_query($db, $query3);

        // Proses selesai, redirect ke halaman user
        echo '<script type="text/javascript">'; 
        echo 'alert("Berhasil! Data User telah dihapus");'; 
        echo 'window.location= "../../view/admin/user.php";';
        echo '</script>'; 

    }

    if ($_POST['id_user']) { // Edit Data user

        $id_user = $_POST['id_user'];
        $nama = $_POST['nama'];
        $jk = $_POST['jk'];
        $id_jabatan = $_POST['jabatan'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];

        $query = "UPDATE user SET nama = '$nama', jk = '$jk', id_jabatan = '$id_jabatan', no_hp = '$no_hp', alamat = '$alamat' WHERE id_user = '$id_user'";

        mysqli_query($db, $query);

        // Proses selesai, redirect ke halaman anggota
        echo '<script type="text/javascript">'; 
        echo 'alert("Berhasil! Data User telah diperbarui");'; 
        echo 'window.location= "../../view/admin/user.php";';
        echo '</script>'; 

    }

    elseif (!$_POST['id_user'] AND $_POST['nama']) { // Tambah Data Baru
        // Inisialisasi variable dari data POST
        $nama = $_POST['nama'];
        $jk = $_POST['jk'];
        $id_jabatan = $_POST['jabatan'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];

        // Query Update Data user ke Database
        $query2 = "INSERT INTO user SET nama = '$nama', jk = '$jk', id_jabatan = '$id_jabatan', no_hp = '$no_hp', alamat = '$alamat'";
       
        // Proses semua aksi ke dalam database
        mysqli_query($db, $query2);
        
        // Proses selesai, redirect ke halaman user
        echo '<script type="text/javascript">'; 
        echo 'alert("Data karyawan berhasil ditambah");'; 
        echo 'window.location= "../../view/admin/user.php";';
        echo '</script>'; 

    }

    else {

        echo '<script>window.location= "../../view/admin/user.php";<script>';

    }

    // Gunakan print_r untuk melakukan troubleshooting jika terjadi kesalahan
    //print_r($query);

  ?>
