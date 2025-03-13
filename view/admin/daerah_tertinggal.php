<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/jpeg" href="../../assets/img/ptsp.png" />
  <title>Data Penetapan Daerah Tertinggal - Erporate Employee Attendance System</title>
  <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
  <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="../css/style.css" rel="stylesheet">
</head>

<style>
  /* Improve Select2 dropdown styling */
  .select2-container .select2-selection--single {
    height: 38px;
    padding-top: 5px;
  }

  .select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 28px;
  }

  .select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
  }
</style>

<body>
  <?php include '../../controller/koneksi.php'; ?>
  <?php include '../../navigation/navigation.php'; ?>

  <!-- End of Topbar -->

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- DataTales Example -->
    <div id="dataWilayah">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-map-marker-alt"></i> Penetapan Daerah tertinggal</h5>
          </span>
          <a href="daerah_tertinggal.php?aksi=tambah_data"><span class="btn btn-primary btn-sm float-right" style="border:1px solid blue">Tambah Data</span></a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Provinsi</th>
                  <th>Kabupaten</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>

                <?php

                $semuaWilayah = "
    SELECT 
        dt.id_daerah_tertinggal,
        p.id_provinsi,
        p.provinsi,
        k.id_kab_kota,
        k.kab_kota
    FROM penetapan_daerah_tertinggal dt
    INNER JOIN provinsi p 
        ON dt.id_provinsi = p.id_provinsi
    INNER JOIN kab_kota k 
        ON dt.id_kab_kota = k.id_kab_kota
";


                $resultWilayah = mysqli_query($db, $semuaWilayah);

                $no = 1;

                foreach ($resultWilayah as $row2) {

                ?>

                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row2['provinsi']; ?></td>
                    <td><?= $row2['kab_kota']; ?></td>
                    <td>
                      <a href="daerah_tertinggal.php?edit=<?= $row2['id_daerah_tertinggal']; ?>" title="Edit" class="btn btn-primary btn-sm btn-circle">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      <a data-toggle="modal" data-target="#hapusModal<?= $row2['id_daerah_tertinggal']; ?>" href="#" title="Hapus" class="btn btn-danger btn-circle btn-sm">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>

                  <!-- Portofolio Modal-->
                  <div class="modal fade" id="hapusModal<?= $row2['id_daerah_tertinggal']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">ID Wilayah <?= $row2['id_daerah_tertinggal']; ?></h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"></span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Apakah anda yakin ingin menghapus data Daerah tersebut?
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                          <a href="../../controller/admin/daerah_tertinggal.php?hapus_id=<?= $row2['id_daerah_tertinggal']; ?>"><span class="btn btn-danger">Hapus Sekarang</span></a>
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

    <!-- Tambah Data Wilayah -->
    <?php
if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah_data') {
  echo '
<div class="card shadow mb-4">
<div class="card-header py-3">
  <span class="float-left" style="padding-top:5px">
    <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-map-marker-alt aria-hidden="true"></i> Tambah Data Penetapan Daerah Tertinggal</h5>
  </span>
</div>
<div class="card-body">
  <form action="../../controller/admin/daerah_tertinggal.php" method="post">
    <!-- Provinsi -->
    <div class="form-group">
      <label>Provinsi <span style="color:red">*</span></label>
      <select class="form-control select2" data-placeholder="Pilih Provinsi" name="id_provinsi" required="">
        <option value="">Pilih Provinsi</option>';
  $querProv = "SELECT id_provinsi, provinsi FROM provinsi";
  $resultProv = mysqli_query($db, $querProv);
  while ($provinsi = mysqli_fetch_assoc($resultProv)) {
    echo "<option value='{$provinsi['id_provinsi']}'>{$provinsi['provinsi']}</option>";
  }
  echo ' </select>
    </div>
    
    <!-- Kabupaten/Kota -->
    <div class="form-group">
      <label>Kabupaten <span style="color:red">*</span></label>
      <select class="form-control select2" data-placeholder="Pilih Kabupaten/Kota" name="id_kab_kota" required="">
        <option value="">Pilih Kabupaten/Kota</option>';
  $querKabKota = "SELECT id_kab_kota, kab_kota FROM kab_kota";
  $resultKabKota = mysqli_query($db, $querKabKota);
  while ($kabKota = mysqli_fetch_assoc($resultKabKota)) {
    echo "<option value='{$kabKota['id_kab_kota']}'>{$kabKota['kab_kota']}</option>";
  }
  echo ' </select>
    </div>
    
    <!-- Tombol Submit dan Batalkan -->
    <div class="form-group">
      <div class="row">
        <div class="col-md-6">
          <button type="submit" style="width:100%" class="btn btn-primary">Tambah Data Wilayah</button>
        </div>
        <div class="col-md-6">
          <a href="daerah_tertinggal.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
        </div>
      </div>
    </div>
  </form>
</div>
</div>';

  echo '<script>document.getElementById("dataWilayah").innerHTML = "";</script>';
}
?>
    <!-- Update Data Wilayah -->
    <?php
if (isset($_GET['edit'])) {

  $edit_id = $_GET['edit'];

  $getWilayah = "SELECT * FROM penetapan_daerah_tertinggal WHERE id_daerah_tertinggal = '$edit_id'";
  $resultEdit = mysqli_query($db, $getWilayah);
  $row4 = mysqli_fetch_assoc($resultEdit);

  echo '<script>document.getElementById("dataWilayah").innerHTML = "";</script>';

  echo '
<div id="updateWilayah">
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <span class="float-left" style="padding-top:5px">
        <h5 class="m-0 font-weight-bold text-primary">
          <i class="fas fa-map-marker-alt aria-hidden="true"></i> Update Data Penetapan Daerah Tertinggal
        </h5>
      </span>
    </div>
    <div class="card-body">
      <form action="../../controller/admin/daerah_tertinggal.php" method="post">
        <!-- Hidden field untuk id_daerah_tertinggal -->
        <input type="hidden" name="id_daerah_tertinggal" value="' . $row4['id_daerah_tertinggal'] . '">
        
        <!-- Provinsi -->
        <div class="form-group">
          <label>Provinsi <span style="color:red">*</span></label>
          <select class="form-control select2" data-placeholder="Pilih Provinsi" name="id_provinsi" required>
            <option value="">Pilih Provinsi</option>';
  $querProv = "SELECT id_provinsi, provinsi FROM provinsi";
  $resultProv = mysqli_query($db, $querProv);
  while ($rowProv = mysqli_fetch_assoc($resultProv)) {
    $selected = ($rowProv['id_provinsi'] == $row4['id_provinsi']) ? "selected" : "";
    echo "<option value='{$rowProv['id_provinsi']}' $selected>{$rowProv['provinsi']}</option>";
  }
  echo '    </select>
        </div>
        
        <!-- Kabupaten/Kota -->
        <div class="form-group">
          <label>Kabupaten/Kota <span style="color:red">*</span></label>
          <select class="form-control select2" data-placeholder="Pilih Kabupaten/Kota" name="id_kab_kota" required>
            <option value="">Pilih Kabupaten/Kota</option>';
  $querKab = "SELECT id_kab_kota, kab_kota FROM kab_kota";
  $resultKab = mysqli_query($db, $querKab);
  while ($rowKab = mysqli_fetch_assoc($resultKab)) {
    $selected = ($rowKab['id_kab_kota'] == $row4['id_kab_kota']) ? "selected" : "";
    echo "<option value='{$rowKab['id_kab_kota']}' $selected>{$rowKab['kab_kota']}</option>";
  }
  echo '    </select>
        </div>
        
        <!-- Tombol Submit dan Batalkan -->
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <button type="submit" style="width:100%" class="btn btn-primary">Perbarui Data</button>
            </div>
            <div class="col-md-6">
              <a href="daerah_tertinggal.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
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
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    $(document).ready(function() {
      $('.select2').select2({
        placeholder: function() {
          return $(this).data('placeholder') || "Pilih Opsi";
        },
        allowClear: true,
        width: '100%',
        language: {
          noResults: function() {
            return "Opsi tidak ditemukan";
          },
          searching: function() {
            return "Mencari...";
          }
        },
        matcher: function(params, data) {
          if ($.trim(params.term) === '') {
            return data;
          }
          var searchTerm = params.term.toLowerCase();
          if (data.text.toLowerCase().indexOf(searchTerm) > -1) {
            return data;
          }
          return null;
        }
      });
    });
  </script>

</body>

</html>