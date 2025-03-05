<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/jpeg" href="../../assets/img/ptsp.png" />

  <title>Data Karyawan - Erporate Employee Attendance System</title>

  <!-- Custom fonts for this template-->
  <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <?php

  include '../../controller/koneksi.php';

  ?>

  <?php include '../../navigation/navigation.php' ?>


  <!-- End of Topbar -->

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- DataTales Example -->
    <div id="dataKaryawan">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fa fa-users" aria-hidden="true"></i> Data Karyawan</h5>
          </span>
          <a href="karyawan.php?aksi=tambah_data"><span class="btn btn-primary btn-sm float-right" style="border:1px solid blue">Tambah Data</span></a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Domisili</th>
                  <th>Mulai Kerja</th>
                  <th>File PKWT/PKWIT</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>

                <?php

                $semuaKaryawan = "SELECT * FROM `pegawai`";

                $resultKaryawan = mysqli_query($db, $semuaKaryawan);

                $no = 1;

                foreach ($resultKaryawan as $row2) {

                ?>

                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row2['nama']; ?></td>
                    <td><?= $row2['jabatan']; ?></td>
                    <td><?= $row2['alamat_domisili']; ?></td>
                    <td><?= $row2['mulai_kerja']; ?></td>
                    <td>
                      <a href="../../controller/admin/view_pdf.php?id_pegawai=<?= $row2['id_pegawai']; ?>" target="_blank" style="text-decoration: none;">
                        <i class="fas fa-file-pdf fa-lg" style="color: red;"></i>
                        <span> <?= $row2['file_pkwt_name']; ?></span>
                      </a>

                    </td>

                    </td>

                    <td>
                      <a href="karyawan.php?edit=<?= $row2['id_pegawai']; ?>" title="Edit" class="btn btn-primary btn-sm btn-circle">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      <a data-toggle="modal" data-target="#hapusModal<?= $row2['id_pegawai']; ?>" href="#" title="Hapus" class="btn btn-danger btn-circle btn-sm">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>

                  <!-- Portofolio Modal-->
                  <div class="modal fade" id="hapusModal<?= $row2['id_pegawai']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">ID Pegawai <?= $row2['id_pegawai']; ?></h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Apakah anda yakin ingin menghapus data Pegawai tersebut?
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                          <a href="../../controller/admin/karyawan.php?hapus_id=<?= $row2['id_pegawai']; ?>"><span class="btn btn-danger">Hapus Sekarang</span></a>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!-- Tambah Data Karyawan -->
    <?php
   if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah_data') {
    echo '
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fa fa-users" aria-hidden="true"></i> Tambah Data Karyawan</h5>
          </span>
        </div>
        <div class="card-body">
          <form action="../../controller/admin/karyawan.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label>Nama Lengkap <span style="color:red">*</span></label>
              <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Lengkap" required="">
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Jabatan <span style="color:red">*</span></label>
                  <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" required="">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Domisili <span style="color:red">*</span></label>
                  <select name="domisili" class="form-control" required>
                    <option disabled selected>Pilih Domisili</option>
                    <option value="Medan">Medan, Sumatera Utara</option>
                    <option value="Deli Serdang">Deli Serdang, Sumatera Utara</option>
                    <option value="Tebing Tinggi">Tebing Tinggi, Sumatera Utara</option>
                    <option value="Pematang Siantar">Pematang Siantar, Sumatera Utara</option>
                    <option value="Binjai">Binjai, Sumatera Utara</option>
                  </select>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Mulai Kerja <span style="color:red">*</span></label>
                  <select name="mulai_kerja" class="form-control" required>
                    <option disabled selected>Pilih Tahun</option>';
    $tahunSekarang = date("Y");
    for ($i = $tahunSekarang; $i >= 2011; $i--) {
      echo "<option value=$i >$i</option>";
    }
    echo '</select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Unggah Dokumen <span style="color:red">*</span></label>
              <input type="file" class="form-control border-0" id="formFile" name="file_pkwt" accept=".pdf" required>
              <small class="form-text text-muted">Format yang diperbolehkan: PDF.</small>
            </div>
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <button type="submit" style="width:100%" class="btn btn-primary">Tambah Karyawan</button>
                </div>
                <div class="col-md-6">
                  <a href="karyawan.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>';
  
    echo '<script>document.getElementById("dataKaryawan").innerHTML = "";</script>';
  }
    ?>

    <!-- Edit Data Karyawan -->
    <?php
    if (isset($_GET['edit'])) {

      $edit_id = $_GET['edit'];

      $getKaryawan = "SELECT * FROM pegawai WHERE id_pegawai = '$edit_id'";
      $resultEdit = mysqli_query($db, $getKaryawan);

      $row4 = mysqli_fetch_array($resultEdit);

      echo '<script>document.getElementById("dataKaryawan").innerHTML = "";</script>';
      echo '
          <script>document.getElementById("updateKaryawan").innerstyle = "";</script>
          <div id="updateKaryawan">
          <div class="card shadow mb-4">
            <div class="card-header py-3">
			  <span class="float-left" style="padding-top:5px">
				<h5 class="m-0 font-weight-bold text-primary"><i class="fa fa-users" aria-hidden="true"></i> Update Data Karyawan</h5>
			  </span>
            </div>
            <div class="card-body">
              <form action="../../controller/admin/karyawan.php" method="post" enctype="multipart/form-data">
              <input type="text" name="id_pegawai" readonly="" hidden="" value="' . $row4['id_pegawai'] . '">
              <div class="form-group">
              	<label>Nama Lengkap <span style="color:red">*</span></label>
                <input type="text" class="form-control" name="nama" placeholder="Masukkan Nama Lengkap" value="' . $row4['nama'] . '" required="">
              </div>
              <div class="row">
              <div class="col-md-4">
		              <div class="form-group">
		              	<label>Jabatan <span style="color:red">*</span></label>
		                <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="' . $row4['jabatan'] . '" required="">
		              </div>
		            </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label>Mulai Kerja <span style="color:red">*</span></label>
                    <select name="mulai_kerja" class="form-control" required>
                      <option disabled>Pilih Tahun</option>';
      $tahunSekarang = date("Y");
      for ($i = $tahunSekarang; $i >= 2011; $i--) {
        $selected = ($i == $row4['mulai_kerja']) ? 'selected' : '';
        echo "<option value=\"$i\" $selected>$i</option>";
      }
      echo '</select>
                  </div>
                </div>
		      </div>
            <div class="form-group">
              <label>Unggah Dokumen <span style="color:red">*</span></label>
              <input type="file" class="form-control border-0" id="formFile" name="file_pkwt" accept=".pdf">';
      if (!empty($row4['file_pkwt'])):
        echo '<small class="form-text text-muted">;
                  File saat ini: <a href="../../controller/admin/view_pdf.php?id_pegawai=' . $row4['id_pegawai'] . '" type="application/pdf" target="_blank">Lihat PDF</a>
                </small>';
      endif;
      echo '<small class="form-text text-muted">Format yang diperbolehkan: PDF. Kosongkan jika tidak ingin mengganti file.</small>
            </div>

              <div class="form-group">
              	<div class="row">
              		<div class="col-md-6">
              			<button type="submit" style="width:100%" class="btn btn-primary">Perbarui Data</button>
              		</div>
              		<div class="col-md-6">
              			<a href="karyawan.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
              		</div>
              	</div>
              </div>
          	  </form>
            </div>
          </div>
      	  </div>';
    }
    ?>

  </div>
  <!-- /.container-fluid -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="../../assets/vendor/jquery/jquery.min.js"></script>
  <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../../assets/js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="../../assets/js/demo/datatables-demo.js"></script>

</body>

</html>