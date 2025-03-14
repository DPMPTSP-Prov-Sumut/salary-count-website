<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" type="image/jpeg" href="../../assets/img/ptsp.png" />
  <title>Data RTR Kawasan Perbatasan Negara - Sistem Informasi Tata Ruang</title>
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

  <!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Main Data Table -->
    <div id="dataRTR">
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-map-marked-alt" aria-hidden="true"></i> RTR Kawasan Perbatasan Negara</h5>
          </span>
          <a href="rtr_perbatasan.php?aksi=tambah_data"><span class="btn btn-primary btn-sm float-right" style="border:1px solid blue">Tambah Data</span></a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Provinsi</th>
                  <th>Kabupaten/Kota</th>
                  <th>Kecamatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $queryRTR = "
                    SELECT 
                        r.id_kawasan_perbatasan,
                        p.provinsi,
                        k.kab_kota,
                        kec.kecamatan
                    FROM rtr_kawasan_perbatasan r
                    INNER JOIN provinsi p ON r.id_provinsi = p.id_provinsi
                    INNER JOIN kab_kota k ON r.id_kab_kota = k.id_kab_kota
                    INNER JOIN kecamatan kec ON r.id_kecamatan = kec.id_kecamatan
                    ORDER BY p.provinsi, k.kab_kota, kec.kecamatan
                ";

                $resultRTR = mysqli_query($db, $queryRTR);
                $no = 1;

                while ($row = mysqli_fetch_assoc($resultRTR)) {
                ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $row['provinsi']; ?></td>
                    <td><?= $row['kab_kota']; ?></td>
                    <td><?= $row['kecamatan']; ?></td>
                    <td>
                      <a href="rtr_perbatasan.php?edit=<?= $row['id_kawasan_perbatasan']; ?>" title="Edit" class="btn btn-primary btn-sm btn-circle">
                        <i class="fas fa-pencil-alt"></i>
                      </a>
                      <a data-toggle="modal" data-target="#hapusModal<?= $row['id_kawasan_perbatasan']; ?>" href="#" title="Hapus" class="btn btn-danger btn-circle btn-sm">
                        <i class="fas fa-trash"></i>
                      </a>
                    </td>
                  </tr>

                  <!-- Delete Confirmation Modal -->
                  <div class="modal fade" id="hapusModal<?= $row['id_kawasan_perbatasan']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          Apakah anda yakin ingin menghapus data RTR Kawasan Perbatasan Negara ini?
                        </div>
                        <div class="modal-footer">
                          <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
                          <a href="../../controller/admin/rtr_perbatasan.php?hapus_id=<?= $row['id_kawasan_perbatasan']; ?>"><span class="btn btn-danger">Hapus Sekarang</span></a>
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

    <!-- Add RTR Data Form -->
    <?php
    if (isset($_GET['aksi']) && $_GET['aksi'] == 'tambah_data') {
      echo '
      <div class="card shadow mb-4">
        <div class="card-header py-3">
          <span class="float-left" style="padding-top:5px">
            <h5 class="m-0 font-weight-bold text-primary"><i class="fas fa-map-marked-alt" aria-hidden="true"></i> Tambah Data RTR Kawasan Perbatasan Negara</h5>
          </span>
        </div>
        <div class="card-body">
          <form action="../../controller/admin/rtr_perbatasan.php" method="post">
            <!-- Provinsi -->
            <div class="form-group">
              <label>Provinsi <span style="color:red">*</span></label>
              <select class="form-control select2" id="select-provinsi" data-placeholder="Pilih Provinsi" name="id_provinsi" required>
                <option value="">Pilih Provinsi</option>';
      $queryProvinsi = "SELECT id_provinsi, provinsi FROM provinsi ORDER BY provinsi";
      $resultProvinsi = mysqli_query($db, $queryProvinsi);
      while ($provinsi = mysqli_fetch_assoc($resultProvinsi)) {
        echo "<option value='{$provinsi['id_provinsi']}'>{$provinsi['provinsi']}</option>";
      }
      echo '</select>
            </div>
            
            <!-- Kabupaten/Kota -->
            <div class="form-group">
              <label>Kabupaten/Kota <span style="color:red">*</span></label>
              <select class="form-control select2" id="select-kabkota" data-placeholder="Pilih Kabupaten/Kota" name="id_kab_kota" required>
                <option value="">Pilih Kabupaten/Kota</option>';
                $querKabKota = "SELECT id_kab_kota, kab_kota FROM kab_kota";
                $resultKabKota = mysqli_query($db, $querKabKota);
                while ($kabKota = mysqli_fetch_assoc($resultKabKota)) {
                    echo "<option value='{$kabKota['id_kab_kota']}'>{$kabKota['kab_kota']}</option>";
                }
                echo ' </select>
            </div>
            
            <!-- Kecamatan -->
            <div class="form-group">
              <label>Kecamatan <span style="color:red">*</span></label>
              <select class="form-control select2" id="select-kecamatan" data-placeholder="Pilih Kecamatan" name="id_kecamatan" required>
                <option value="">Pilih Kecamatan</option>';
                $querKecamatan = "SELECT id_kecamatan, kecamatan FROM kecamatan";
                $resultKecamatan = mysqli_query($db, $querKecamatan);
                while ($kecamatan = mysqli_fetch_assoc($resultKecamatan)) {
                    echo "<option value='{$kecamatan['id_kecamatan']}'>{$kecamatan['kecamatan']}</option>";
                }
                echo ' </select>
            </div>
            
            <!-- Submit and Cancel Buttons -->
            <div class="form-group">
              <div class="row">
                <div class="col-md-6">
                  <button type="submit" style="width:100%" class="btn btn-primary">Tambah Data RTR</button>
                </div>
                <div class="col-md-6">
                  <a href="rtr_perbatasan.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>';

      echo '<script>document.getElementById("dataRTR").innerHTML = "";</script>';
    }
    ?>

    <!-- Edit RTR Data Form -->
    <?php
    if (isset($_GET['edit'])) {
      $edit_id = $_GET['edit'];
      $queryEdit = "SELECT * FROM rtr_kawasan_perbatasan WHERE id_kawasan_perbatasan = '$edit_id'";
      $resultEdit = mysqli_query($db, $queryEdit);
      $dataEdit = mysqli_fetch_assoc($resultEdit);

      echo '<script>document.getElementById("dataRTR").innerHTML = "";</script>';

      echo '
      <div id="updateRTR">
        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <span class="float-left" style="padding-top:5px">
              <h5 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-map-marked-alt" aria-hidden="true"></i> Update Data RTR Kawasan Perbatasan Negara
              </h5>
            </span>
          </div>
          <div class="card-body">
            <form action="../../controller/admin/rtr_perbatasan.php" method="post">
              <!-- Hidden field for id_kawasan_perbatasan -->
              <input type="hidden" name="update_id" value="' . $dataEdit['id_kawasan_perbatasan'] . '">
              
              <!-- Provinsi -->
              <div class="form-group">
                <label>Provinsi <span style="color:red">*</span></label>
                <select class="form-control select2" id="edit-provinsi" data-placeholder="Pilih Provinsi" name="id_provinsi" required>
                  <option value="">Pilih Provinsi</option>';
      $queryProvinsi = "SELECT id_provinsi, provinsi FROM provinsi";
      $resultProvinsi = mysqli_query($db, $queryProvinsi);
      while ($provinsi = mysqli_fetch_assoc($resultProvinsi)) {
        $selected = ($provinsi['id_provinsi'] == $dataEdit['id_provinsi']) ? "selected" : "";
        echo "<option value='{$provinsi['id_provinsi']}' $selected>{$provinsi['provinsi']}</option>";
      }
      echo '</select>
              </div>
              
              <!-- Kabupaten/Kota -->
              <div class="form-group">
                <label>Kabupaten/Kota <span style="color:red">*</span></label>
                <select class="form-control select2" id="edit-kabkota" data-placeholder="Pilih Kabupaten/Kota" name="id_kab_kota" required>
                  <option value="">Pilih Kabupaten/Kota</option>';
      $queryKabKota = "SELECT id_kab_kota, kab_kota FROM kab_kota";
      $resultKabKota = mysqli_query($db, $queryKabKota);
      while ($kabKota = mysqli_fetch_assoc($resultKabKota)) {
        $selected = ($kabKota['id_kab_kota'] == $dataEdit['id_kab_kota']) ? "selected" : "";
        echo "<option value='{$kabKota['id_kab_kota']}' $selected>{$kabKota['kab_kota']}</option>";
      }
      echo '</select>
              </div>
              
              <!-- Kecamatan -->
              <div class="form-group">
                <label>Kecamatan <span style="color:red">*</span></label>
                <select class="form-control select2" id="edit-kecamatan" data-placeholder="Pilih Kecamatan" name="id_kecamatan" required>
                  <option value="">Pilih Kecamatan</option>';
      $queryKecamatan = "SELECT id_kecamatan, kecamatan FROM kecamatan";
      $resultKecamatan = mysqli_query($db, $queryKecamatan);
      while ($kecamatan = mysqli_fetch_assoc($resultKecamatan)) {
        $selected = ($kecamatan['id_kecamatan'] == $dataEdit['id_kecamatan']) ? "selected" : "";
        echo "<option value='{$kecamatan['id_kecamatan']}' $selected>{$kecamatan['kecamatan']}</option>";
      }
      echo '</select>
              </div>
              
              <!-- Submit and Cancel Buttons -->
              <div class="form-group">
                <div class="row">
                  <div class="col-md-6">
                    <button type="submit" name="update" style="width:100%" class="btn btn-primary">Perbarui Data</button>
                  </div>
                  <div class="col-md-6">
                    <a href="rtr_perbatasan.php"><span style="width:100%" class="btn btn-danger">Batalkan</span></a>
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
      // Initialize Select2
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